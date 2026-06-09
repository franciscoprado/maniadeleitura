<header class="banner bg-white border-b">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <div class="flex items-center">
        <a class="brand text-lg font-semibold text-gray-900" href="{{ home_url('/') }}">
          @php
          $logo = Vite::asset('resources/images/mania-de-leitura.webp');
          @endphp

          @if ($logo)
          <img src="{{ $logo }}" alt="{{ $siteName }}" width="150px">
          @else
          {!! $siteName !!}
          @endif
        </a>
      </div>

      @if (has_nav_menu('primary_navigation'))
        <div class="flex items-center">
          <!-- Desktop nav (visible on md and up) -->
          <nav class="hidden md:block" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav flex items-center md:space-x-6', 'echo' => false]) !!}
          </nav>

          <!-- Mobile menu button (visible on small screens) -->
          <button id="menu-toggle" type="button" class="md:hidden ml-2 inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false" aria-label="{{ __('Toggle menu', 'maniadeleitura') }}">
            <span class="sr-only">{{ __('Open main menu', 'maniadeleitura') }}</span>
            <!-- hamburger -->
            <svg id="icon-menu" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <!-- close (hidden by default) -->
            <svg id="icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      @endif
    </div>
  </div>

  @if (has_nav_menu('primary_navigation'))
    <!-- Mobile menu placed below header so it 'expands downward' -->
    <nav id="mobile-menu" class="md:hidden hidden px-4 pb-4" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav flex flex-col space-y-2', 'echo' => false]) !!}
    </nav>
  @endif
</header>
