<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section principale -->
        <div class="py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Logo et description -->
                <div class="lg:col-span-3">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                        <img src="{{ asset('img/logo.png') }}" alt="NIFA CARGO" class="w-10 h-10 object-contain">
                    </div>
                    </div>
                    <p class="text-gray-400 mb-6 text-sm leading-relaxed">
                        Leader du transport et de la logistique en Afrique depuis plus de 10 ans. 
                        Votre partenaire de confiance pour tous vos besoins de transport.
                    </p>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/Espoir.amewuho55" class="w-8 h-8 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors duration-300">
                            <i class="fab fa-facebook-f text-xs"></i>
                        </a>
                        <a href="https://www.tiktok.com/@nifgroupcargo" class="w-8 h-8 bg-gray-800 hover:bg-pink-600 rounded-full flex items-center justify-center transition-colors duration-300">
                            <i class="fab fa-tiktok text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Services -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-800">Nos Services</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-ship mr-3 text-blue-400 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm">Transport Maritime</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-plane mr-3 text-red-400 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm">Transport Aérien</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-truck mr-3 text-blue-400 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm">Transport Terrestre</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-file-invoice mr-3 text-red-400 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm">Dédouanement</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-warehouse mr-3 text-blue-400 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm">Entreposage</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Liens utiles -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-800">Liens Utiles</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('apropos') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                <span class="text-sm">À propos de NIFA</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('suivi.public') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                <span class="text-sm">Suivre un colis</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                <span class="text-sm">Créer un compte</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                <span class="text-sm">Carrières</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                <span class="text-sm">Blog & Actualités</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div class="lg:col-span-5">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-800">Nous Contacter</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Togo -->
                        <div>
                            <h4 class="font-medium text-blue-400 mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                🇹🇬 Siège Social - Togo
                            </h4>
                            <ul class="space-y-2 text-gray-400 text-sm">
                                <li class="flex items-start">
                                    <i class="fas fa-location-dot mr-2 mt-1 text-blue-400 text-xs"></i>
                                    <span>Totsi à 100m non loin de l'église catholique<br>Lomé, Togo</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-blue-400 text-xs"></i>
                                    <a href="tel:+22822610000" class="hover:text-white transition-colors">+228 99 25 25 31</a>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-mobile-alt mr-2 text-blue-400 text-xs"></i>
                                    <a href="tel:+22890123456" class="hover:text-white transition-colors">+228 90 12 34 56</a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Bénin -->
                        <div>
                            <h4 class="font-medium text-red-400 mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                🇧🇯 Agence - Bénin
                            </h4>
                            <ul class="space-y-2 text-gray-400 text-sm">
                                <li class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-red-400 text-xs"></i>
                                    <a href="tel:+22921123456" class="hover:text-white transition-colors">+229 96 12 34 56</a>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-mobile-alt mr-2 text-red-400 text-xs"></i>
                                    <a href="tel:+22996123456" class="hover:text-white transition-colors">+229 96 12 34 56</a>
                                </li>
                            </ul>
                            
                            <!-- Email général -->
                            <div class="mt-4">
                                <ul class="space-y-2 text-gray-400 text-sm">
                                    <li class="flex items-center">
                                        <i class="fas fa-envelope mr-2 text-blue-400 text-xs"></i>
                                        <a href="mailto:contact@nifa.tg" class="hover:text-white transition-colors">contact@nifa.tg</a>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-headset mr-2 text-red-400 text-xs"></i>
                                        <a href="mailto:support@nifa.tg" class="hover:text-white transition-colors">support@nifa.tg</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Horaires -->
                    <div class="mt-6 p-4 bg-gray-800 rounded-lg">
                        <h4 class="font-medium text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Horaires d'ouverture
                        </h4>
                        <div class="grid grid-cols-2 gap-2 text-gray-400 text-xs">
                            <div>Lun - Ven : 8h00 - 18h00</div>
                            <div>Samedi : 8h00 - 12h00</div>
                            <div>Dimanche : Fermé</div>
                            <div class="text-red-400 font-medium">Urgences 24h/7j : +228 90 00 00 00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions rapides -->
        <div class="border-t border-gray-800 py-6">
            <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('register') }}" 
                       class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 text-sm flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-box mr-2"></i> Faire une demande
                    </a>
                    <a href="{{ route('suivi.public') }}" 
                       class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 text-sm flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-search mr-2"></i> Suivre un colis
                    </a>
                    <a href="https://wa.me/22899252531" target="_blank"
                       class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 text-sm flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                    </a>
                </div>
                
                <!-- Certifications -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-gray-400 text-xs bg-gray-800 px-3 py-1 rounded-full">
                        <i class="fas fa-certificate mr-1 text-blue-400"></i>
                        <span>ISO 9001:2015</span>
                    </div>
                    <div class="flex items-center text-gray-400 text-xs bg-gray-800 px-3 py-1 rounded-full">
                        <i class="fas fa-shield-alt mr-1 text-red-400"></i>
                        <span>IATA Cargo</span>
                    </div>
                    <div class="flex items-center text-gray-400 text-xs bg-gray-800 px-3 py-1 rounded-full">
                        <i class="fas fa-leaf mr-1 text-green-400"></i>
                        <span>ISO 14001</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-800 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} NIFA - OGOUBI KOMIVI Philippe. Tous droits réservés.
                    </p>
                </div>
                
                <div class="flex space-x-6 text-gray-400 text-sm">
                    <a href="#" class="hover:text-white transition-colors">Conditions générales</a>
                    <a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a>
                    <a href="#" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Script pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation au scroll pour le footer
    const footer = document.querySelector('footer');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, { threshold: 0.1 });

    if (footer) {
        observer.observe(footer);
    }

    // Smooth scroll pour les ancres internes
    document.querySelectorAll('footer a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<style>
/* Animations supplémentaires */
.animate-fade-in {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    footer .grid > div {
        margin-bottom: 2rem;
    }
    
    footer .text-sm {
        font-size: 0.875rem;
    }
    
    footer .text-xs {
        font-size: 0.75rem;
    }
}

@media (max-width: 640px) {
    footer .flex-wrap {
        justify-content: center;
    }
    
    footer .flex-wrap a {
        margin-bottom: 0.5rem;
    }
    
    footer .space-y-3 > li {
        margin-bottom: 0.75rem;
    }
}
</style>