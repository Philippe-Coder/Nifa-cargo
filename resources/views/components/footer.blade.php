<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo et description -->
            <div>
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-400 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">N</span>
                    </div>
                    <span class="text-xl font-bold">NIFA</span>
                </div>
                <p class="text-gray-400 mb-4">
                    Leader du transport et de la logistique en Afrique depuis plus de 10 ans. 
                    Votre partenaire de confiance pour tous vos besoins de transport.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            
            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Nos Services</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-ship mr-2 text-blue-400"></i> Transport Maritime
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-plane mr-2 text-red-400"></i> Transport Aérien
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-truck mr-2 text-blue-400"></i> Transport Terrestre
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-file-invoice mr-2 text-red-400"></i> Dédouanement
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-warehouse mr-2 text-blue-400"></i> Entreposage
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Liens utiles -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Liens Utiles</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('apropos') }}" class="text-gray-400 hover:text-white transition-colors">
                            À propos de NIFA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('suivi.public') }}" class="text-gray-400 hover:text-white transition-colors">
                            Suivre un colis
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors">
                            Créer un compte
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            Carrières
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            Blog & Actualités
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            Conditions générales
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            Politique de confidentialité
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Nous Contacter</h3>
                
                <!-- Togo -->
                <div class="mb-4">
                    <h4 class="font-medium text-blue-400 mb-2">🇹🇬 Siège Social - Togo</h4>
                    <ul class="space-y-1 text-gray-400 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mr-2 mt-1 text-blue-400"></i>
                            <span>123 Avenue de la Logistique<br>Lomé, Togo</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-blue-400"></i>
                            <a href="tel:+22822610000" class="hover:text-white">+228 22 61 00 00</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-mobile-alt mr-2 text-blue-400"></i>
                            <a href="tel:+22890123456" class="hover:text-white">+228 90 12 34 56</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Bénin -->
                <div class="mb-4">
                    <h4 class="font-medium text-red-400 mb-2">🇧🇯 Agence - Bénin</h4>
                    <ul class="space-y-1 text-gray-400 text-sm">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-red-400"></i>
                            <a href="tel:+22921123456" class="hover:text-white">+229 21 12 34 56</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-mobile-alt mr-2 text-red-400"></i>
                            <a href="tel:+22996123456" class="hover:text-white">+229 96 12 34 56</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Email général -->
                <div class="mb-4">
                    <ul class="space-y-1 text-gray-400 text-sm">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-blue-400"></i>
                            <a href="mailto:contact@nifa.tg" class="hover:text-white">contact@nifa.tg</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-headset mr-2 text-red-400"></i>
                            <a href="mailto:support@nifa.tg" class="hover:text-white">support@nifa.tg</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Horaires -->
                <div>
                    <h4 class="font-medium text-gray-300 mb-2">🕒 Horaires d'ouverture</h4>
                    <ul class="space-y-1 text-gray-400 text-xs">
                        <li>Lun - Ven : 8h00 - 18h00</li>
                        <li>Samedi : 8h00 - 12h00</li>
                        <li>Dimanche : Fermé</li>
                        <li class="text-red-400">Urgences 24h/7j : +228 90 00 00 00</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Séparateur -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} NIFA - Network International Freight Africa. Tous droits réservés.
                    </p>
                </div>
                
                <!-- Certifications -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-gray-400 text-xs">
                        <i class="fas fa-certificate mr-1 text-blue-400"></i>
                        <span>ISO 9001:2015</span>
                    </div>
                    <div class="flex items-center text-gray-400 text-xs">
                        <i class="fas fa-shield-alt mr-1 text-red-400"></i>
                        <span>IATA Cargo</span>
                    </div>
                    <div class="flex items-center text-gray-400 text-xs">
                        <i class="fas fa-leaf mr-1 text-green-400"></i>
                        <span>ISO 14001</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions rapides -->
        <div class="mt-6 text-center">
            <div class="inline-flex space-x-4">
                <a href="{{ route('register') }}" 
                   class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 text-sm">
                    <i class="fas fa-box mr-2"></i> Faire une demande
                </a>
                <a href="{{ route('suivi.public') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 text-sm">
                    <i class="fas fa-search mr-2"></i> Suivre un colis
                </a>
                <a href="https://wa.me/22890123456" target="_blank"
                   class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 text-sm">
                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</footer>
