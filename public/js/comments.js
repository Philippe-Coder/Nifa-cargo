class CommentSystem {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.commentForm = document.getElementById('comment-form');
        this.commentList = document.getElementById('comment-list');
        this.commentInput = document.getElementById('comment-content');
        this.commentCount = document.getElementById('comment-count');
        this.replyForms = document.querySelectorAll('.reply-form');
        this.likeButtons = document.querySelectorAll('.like-comment');
        this.editButtons = document.querySelectorAll('.edit-comment');
        this.deleteButtons = document.querySelectorAll('.delete-comment');
        this.currentUser = document.getElementById('current-user') ? 
            JSON.parse(document.getElementById('current-user').dataset.user) : null;
        
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Soumission du formulaire de commentaire principal
        if (this.commentForm) {
            this.commentForm.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        // Gestion des réponses aux commentaires
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('reply-button')) {
                e.preventDefault();
                this.toggleReplyForm(e.target.dataset.commentId);
            }
        });

        // Gestion des likes
        document.addEventListener('click', (e) => {
            if (e.target.closest('.like-comment')) {
                e.preventDefault();
                this.handleLike(e.target.closest('.like-comment'));
            }
        });

        // Gestion de l'édition
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('edit-comment')) {
                e.preventDefault();
                this.enableEditMode(e.target.dataset.commentId);
            }
        });

        // Gestion de la suppression
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-comment')) {
                e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
                    this.deleteComment(e.target.dataset.commentId);
                }
            }
        });
    }

    async handleSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const url = form.action;
        const method = form.method;
        const parentId = form.querySelector('[name="parent_id"]') ? 
            form.querySelector('[name="parent_id"]').value : null;

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    content: formData.get('content'),
                    annonce_id: formData.get('annonce_id'),
                    parent_id: parentId
                })
            });

            const data = await response.json();

            if (data.success) {
                this.addCommentToDOM(data.comment, parentId);
                form.reset();
                this.updateCommentCount(1);
                
                if (parentId) {
                    this.toggleReplyForm(parentId);
                }
            } else {
                alert('Une erreur est survenue lors de l\'ajout du commentaire.');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la communication avec le serveur.');
        }
    }

    async handleLike(button) {
        const commentId = button.dataset.commentId;
        const url = `/comments/${commentId}/like`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                const likeCount = button.querySelector('.like-count');
                likeCount.textContent = data.likes_count;
                
                if (data.is_liked) {
                    button.classList.add('liked');
                } else {
                    button.classList.remove('liked');
                }
            }
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    async deleteComment(commentId) {
        const url = `/comments/${commentId}`;

        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                const commentElement = document.getElementById(`comment-${commentId}`);
                if (commentElement) {
                    commentElement.remove();
                    this.updateCommentCount(-1);
                }
            } else {
                alert('Une erreur est survenue lors de la suppression du commentaire.');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la communication avec le serveur.');
        }
    }

    addCommentToDOM(comment, parentId = null) {
        const commentElement = this.createCommentElement(comment);
        
        if (parentId) {
            const repliesContainer = document.querySelector(`#comment-${parentId} .comment-replies`);
            if (repliesContainer) {
                repliesContainer.appendChild(commentElement);
                repliesContainer.style.display = 'block';
            }
        } else {
            const commentList = document.getElementById('comment-list');
            if (commentList) {
                commentList.prepend(commentElement);
            }
        }
    }

    createCommentElement(comment) {
        const commentElement = document.createElement('div');
        commentElement.className = 'comment mb-4';
        commentElement.id = `comment-${comment.id}`;
        
        const userAvatar = comment.author_name ? '/images/default-avatar.png' : (comment.user?.avatar_url || '/images/default-avatar.png');
        const isCurrentUser = this.currentUser && this.currentUser.id === comment.user_id;
        const isAdmin = this.currentUser && this.currentUser.is_admin;
        const authorName = comment.author_name || comment.user?.name || 'Anonyme';
        
        commentElement.innerHTML = `
            <div class="flex items-start space-x-3 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-700">${authorName.charAt(0).toUpperCase()}</span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-900">${authorName}</h4>
                        <time class="text-xs text-gray-500">${new Date(comment.created_at).toLocaleString('fr-FR')}</time>
                    </div>
                    <p class="comment-content text-sm text-gray-700 mb-3">${this.escapeHtml(comment.contenu)}</p>
                    
                    <div class="comment-actions flex items-center space-x-4">
                        <button class="reply-button text-xs text-blue-600 hover:text-blue-800" 
                                data-comment-id="${comment.id}">
                            Répondre
                        </button>
                        
                        ${(isCurrentUser || isAdmin) ? `
                            <button class="delete-comment text-xs text-red-600 hover:text-red-800" 
                                    data-comment-id="${comment.id}">
                                Supprimer
                            </button>
                        ` : ''}
                    </div>`
                    
                    <div class="reply-form mt-3" id="reply-form-${comment.id}" style="display: none;">
                        <form class="comment-form" action="/comments" method="POST">
                            <input type="hidden" name="annonce_id" value="${document.getElementById('annonce-id').value}">
                            <input type="hidden" name="parent_id" value="${comment.id}">
                            <div class="input-group">
                                <input type="text" name="content" class="form-control" placeholder="Votre réponse..." required>
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="comment-replies mt-3 ms-4"></div>
                </div>
            </div>
        `;
        
        // Ajouter un écouteur d'événement pour le formulaire de réponse
        const replyForm = commentElement.querySelector('.comment-form');
        if (replyForm) {
            replyForm.addEventListener('submit', (e) => this.handleSubmit(e));
        }
        
        return commentElement;
    }

    toggleReplyForm(commentId) {
        const replyForm = document.getElementById(`reply-form-${commentId}`);
        if (replyForm) {
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        }
    }

    enableEditMode(commentId) {
        const commentElement = document.getElementById(`comment-${commentId}`);
        if (!commentElement) return;
        
        const contentElement = commentElement.querySelector('.comment-content');
        const currentContent = contentElement.textContent;
        
        // Créer un formulaire d'édition
        const form = document.createElement('form');
        form.className = 'edit-comment-form';
        form.innerHTML = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" value="${this.escapeHtml(currentContent)}" required>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                <button type="button" class="btn btn-secondary btn-sm cancel-edit">Annuler</button>
            </div>
        `;
        
        // Remplacer le contenu par le formulaire d'édition
        contentElement.style.display = 'none';
        contentElement.after(form);
        
        // Gérer la soumission du formulaire
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const newContent = form.querySelector('input').value.trim();
            if (newContent) {
                await this.updateComment(commentId, newContent);
            }
        });
        
        // Gérer l'annulation
        form.querySelector('.cancel-edit').addEventListener('click', () => {
            form.remove();
            contentElement.style.display = 'block';
        });
    }
    
    async updateComment(commentId, content) {
        const url = `/comments/${commentId}`;
        
        try {
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content })
            });
            
            const data = await response.json();
            
            if (data.success) {
                const commentElement = document.getElementById(`comment-${commentId}`);
                if (commentElement) {
                    const contentElement = commentElement.querySelector('.comment-content');
                    contentElement.textContent = content;
                    contentElement.style.display = 'block';
                    
                    const form = commentElement.querySelector('.edit-comment-form');
                    if (form) {
                        form.remove();
                    }
                }
            }
        } catch (error) {
            console.error('Erreur lors de la mise à jour du commentaire:', error);
            alert('Une erreur est survenue lors de la mise à jour du commentaire.');
        }
    }
    
    updateCommentCount(change) {
        if (this.commentCount) {
            const currentCount = parseInt(this.commentCount.textContent) || 0;
            const newCount = currentCount + change;
            this.commentCount.textContent = newCount > 0 ? newCount : 'Aucun';
        }
    }
    
    async loadComments(annonceId) {
        try {
            const response = await fetch(`/blog/${annonceId}/comments`);
            const data = await response.json();
            
            if (data.success) {
                this.renderComments(data.comments);
            }
        } catch (error) {
            console.error('Erreur lors du chargement des commentaires:', error);
        }
    }
    
    renderComments(comments) {
        const commentList = document.getElementById('comment-list');
        if (!commentList) return;
        
        // Vider le conteneur
        commentList.innerHTML = '';
        
        if (comments.length === 0) {
            commentList.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-gray-500">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                </div>
            `;
            return;
        }
        
        // Afficher chaque commentaire
        comments.forEach(comment => {
            const commentElement = this.createCommentElement(comment);
            commentList.appendChild(commentElement);
            
            // Afficher les réponses si elles existent
            if (comment.replies && comment.replies.length > 0) {
                const repliesContainer = commentElement.querySelector('.comment-replies');
                comment.replies.forEach(reply => {
                    const replyElement = this.createCommentElement(reply);
                    repliesContainer.appendChild(replyElement);
                });
            }
        });
    }

    escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
}

// Initialisation du système de commentaires
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('comment-section')) {
        window.commentSystem = new CommentSystem();
    }
});
