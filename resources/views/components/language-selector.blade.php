{{-- Sélecteur de langue avec JavaScript natif --}}
<div class="relative">
    
    {{-- Bouton principal - Affiche seulement la langue courante --}}
    <button onclick="toggleLanguageDropdown()" 
            type="button"
            id="language-button"
            class="flex items-center px-3 py-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
        
        @switch(app()->getLocale())
            @case('fr')
                <span class="text-lg mr-2">🇫🇷</span>
                <span class="hidden md:inline text-sm font-medium text-gray-700">Français</span>
                @break
            @case('en')
                <span class="text-lg mr-2">🇺🇸</span>
                <span class="hidden md:inline text-sm font-medium text-gray-700">English</span>
                @break
            @case('zh_CN')
                <span class="text-lg mr-2">🇨🇳</span>
                <span class="hidden md:inline text-sm font-medium text-gray-700">中文</span>
                @break
            @default
                <i class="fas fa-globe mr-2 text-gray-600"></i>
                <span class="hidden md:inline text-sm font-medium text-gray-700">{{ __('Langue') }}</span>
        @endswitch
        
        {{-- Flèche dropdown --}}
        <svg class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200" 
             id="language-arrow"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Menu dropdown - Affiche toutes les langues --}}
    <div id="language-dropdown"
         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50 hidden opacity-0 scale-95 transition-all duration-200">
        
        {{-- Option Français --}}
        <a href="{{ route('lang.switch', 'fr') }}" 
           onclick="closeLanguageDropdown()"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ app()->getLocale() == 'fr' ? 'bg-yellow-50 text-yellow-700 font-medium' : '' }}">
            <div class="flex items-center">
                <span class="text-lg mr-3">🇫🇷</span>
                <span class="flex-1">Français</span>
                @if(app()->getLocale() == 'fr')
                    <i class="fas fa-check text-yellow-600 ml-2 text-sm"></i>
                @endif
            </div>
        </a>

        {{-- Option English --}}
        <a href="{{ route('lang.switch', 'en') }}" 
           onclick="closeLanguageDropdown()"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ app()->getLocale() == 'en' ? 'bg-yellow-50 text-yellow-700 font-medium' : '' }}">
            <div class="flex items-center">
                <span class="text-lg mr-3">🇺🇸</span>
                <span class="flex-1">English</span>
                @if(app()->getLocale() == 'en')
                    <i class="fas fa-check text-yellow-600 ml-2 text-sm"></i>
                @endif
            </div>
        </a>

        {{-- Option 中文 --}}
        <a href="{{ route('lang.switch', 'zh_CN') }}" 
           onclick="closeLanguageDropdown()"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ app()->getLocale() == 'zh_CN' ? 'bg-yellow-50 text-yellow-700 font-medium' : '' }}">
            <div class="flex items-center">
                <span class="text-lg mr-3">🇨🇳</span>
                <span class="flex-1">中文 (简体)</span>
                @if(app()->getLocale() == 'zh_CN')
                    <i class="fas fa-check text-yellow-600 ml-2 text-sm"></i>
                @endif
            </div>
        </a>
    </div>
</div>

{{-- JavaScript pour le fonctionnement du dropdown --}}
<script>
function toggleLanguageDropdown() {
    const dropdown = document.getElementById('language-dropdown');
    const arrow = document.getElementById('language-arrow');
    
    if (dropdown.classList.contains('hidden')) {
        // Ouvrir le dropdown
        dropdown.classList.remove('hidden');
        setTimeout(() => {
            dropdown.classList.remove('opacity-0', 'scale-95');
            dropdown.classList.add('opacity-100', 'scale-100');
            arrow.classList.add('rotate-180');
        }, 10);
    } else {
        // Fermer le dropdown
        closeLanguageDropdown();
    }
}

function closeLanguageDropdown() {
    const dropdown = document.getElementById('language-dropdown');
    const arrow = document.getElementById('language-arrow');
    
    dropdown.classList.add('opacity-0', 'scale-95');
    dropdown.classList.remove('opacity-100', 'scale-100');
    arrow.classList.remove('rotate-180');
    
    setTimeout(() => {
        dropdown.classList.add('hidden');
    }, 200);
}

// Fermer le dropdown quand on clique ailleurs
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('language-dropdown');
    const button = document.getElementById('language-button');
    
    if (dropdown && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
        closeLanguageDropdown();
    }
});

// Fermer avec la touche Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeLanguageDropdown();
    }
});
</script>

