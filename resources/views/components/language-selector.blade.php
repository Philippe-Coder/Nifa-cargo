{{-- Sélecteur de langue avec Tailwind CSS et Alpine.js --}}
<div class="relative" x-data="{ 
    open: false,
    toggle() { this.open = !this.open },
    close() { this.open = false }
}" @click.away="close()">
    
    {{-- Bouton principal - Affiche seulement la langue courante --}}
    <button @click="toggle()" 
            type="button"
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
             :class="{ 'rotate-180': open }" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Menu dropdown - Affiche toutes les langues --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.stop
         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
         style="display: none;">
        
        {{-- Option Français --}}
        <a href="{{ route('lang.switch', 'fr') }}" 
           @click="close()"
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
           @click="close()"
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
           @click="close()"
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

