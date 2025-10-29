{{-- Test simple du sélecteur sans session --}}
<div class="relative">
    
    {{-- Bouton principal --}}
    <button onclick="toggleLanguageDropdown()" 
            type="button"
            id="language-button"
            class="flex items-center px-3 py-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
        
        @php
            $currentLocale = request()->get('locale', app()->getLocale());
        @endphp
        
        @switch($currentLocale)
            @case('en')
                <span class="text-lg mr-2">🇺🇸</span>
                <span class="hidden md:inline text-sm font-medium text-gray-700">English</span>
                @break
            @case('zh_CN')
                <span class="text-lg mr-2">🇨🇳</span>
                <span class="hidden md:inline text-sm font-medium text-gray-700">中文</span>
                @break
            @default
                <span class="text-lg mr-2">🇫🇷</span>
                <span class="hidden md:inline text-sm font-medium text-gray-700">Français</span>
        @endswitch
        
        <svg class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200" 
             id="language-arrow"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Menu dropdown --}}
    <div id="language-dropdown"
         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50 hidden opacity-0 scale-95 transition-all duration-200">
        
        {{-- Option Français --}}
        @php
            $currentUrl = request()->url();
            $currentParams = request()->query();
            unset($currentParams['locale']);
            $baseUrl = $currentUrl . (count($currentParams) ? '?' . http_build_query($currentParams) : '');
            $separator = count($currentParams) ? '&' : '?';
        @endphp
        
        <a href="{{ $baseUrl }}{{ $separator }}locale=fr" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ $currentLocale == 'fr' ? 'bg-yellow-50 text-yellow-700 font-medium' : '' }}">
            <div class="flex items-center">
                <span class="text-lg mr-3">🇫🇷</span>
                <span class="flex-1">Français</span>
                @if($currentLocale == 'fr')
                    <i class="fas fa-check text-yellow-600 ml-2 text-sm"></i>
                @endif
            </div>
        </a>

        {{-- Option English --}}
        <a href="{{ $baseUrl }}{{ $separator }}locale=en" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ $currentLocale == 'en' ? 'bg-yellow-50 text-yellow-700 font-medium' : '' }}">
            <div class="flex items-center">
                <span class="text-lg mr-3">🇺🇸</span>
                <span class="flex-1">English</span>
                @if($currentLocale == 'en')
                    <i class="fas fa-check text-yellow-600 ml-2 text-sm"></i>
                @endif
            </div>
        </a>

        {{-- Option 中文 --}}
        <a href="{{ $baseUrl }}{{ $separator }}locale=zh_CN" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ $currentLocale == 'zh_CN' ? 'bg-yellow-50 text-yellow-700 font-medium' : '' }}">
            <div class="flex items-center">
                <span class="text-lg mr-3">🇨🇳</span>
                <span class="flex-1">中文 (简体)</span>
                @if($currentLocale == 'zh_CN')
                    <i class="fas fa-check text-yellow-600 ml-2 text-sm"></i>
                @endif
            </div>
        </a>
    </div>
</div>

<script>
function toggleLanguageDropdown() {
    const dropdown = document.getElementById('language-dropdown');
    const arrow = document.getElementById('language-arrow');
    
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
        setTimeout(() => {
            dropdown.classList.remove('opacity-0', 'scale-95');
            dropdown.classList.add('opacity-100', 'scale-100');
            arrow.classList.add('rotate-180');
        }, 10);
    } else {
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

document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('language-dropdown');
    const button = document.getElementById('language-button');
    
    if (dropdown && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
        closeLanguageDropdown();
    }
});
</script>