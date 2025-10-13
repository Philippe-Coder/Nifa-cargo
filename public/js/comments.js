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
        
        const userAvatar = comment.user.avatar_url || '/images/default-avatar.png';
        const isCurrentUser = this.currentUser && this.currentUser.id === comment.user_id;
        
        commentElement.innerHTML = `
            <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                    <img src="${userAvatar}" alt="${comment.user.name}" class="rounded-circle" width="50" height="50">
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold">${comment.user.name}</h6>
                        <small class="text-muted">${new Date(comment.created_at).toLocaleString()}</small>
                    </div>
                    <p class="comment-content mb-2">${this.escapeHtml(comment.content)}</p>
                    
                    <div class="comment-actions d-flex align-items-center">
                        <button class="btn btn-sm btn-link text-decoration-none like-comment ${comment.is_liked ? 'liked' : ''}" 
                                data-comment-id="${comment.id}">
                            <i class="far fa-thumbs-up"></i>
                            <span class="like-count">${comment.likes_count || 0}</span>
                        </button>
                        
                        <button class="btn btn-sm btn-link text-decoration-none reply-button" 
                                data-comment-id="${comment.id}">
                            <i class="far fa-comment"></i> Répondre
                        </button>
                        
                        ${isCurrentUser ? `
                            <button class="btn btn-sm btn-link text-decoration-none edit-comment" 
                                    data-comment-id="${comment.id}">
                                <i class="far fa-edit"></i> Modifier
                            </button>
                            <button class="btn btn-sm btn-link text-danger text-decoration-none delete-comment" 
                                    data-comment-id="${comment.id}">
                                <i class="far fa-trash-alt"></i> Supprimer
                            </button>
                        ` : ''}
                    </div>
                    
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
