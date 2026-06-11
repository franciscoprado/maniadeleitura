<header class="banner bg-white border-b border-gray-300 md:py-2 md:fixed w-full z-10 shadow">
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
          <!-- Search form (visible on md and up) -->
          <form class="search-form hidden md:flex items-center md:mr-6" role="search" method="get" action="{{ home_url('/') }}">
            <input class="h-10 px-3 bg-gray-100 text-gray-900 placeholder:text-gray-500 border border-gray-300 focus:ring-indigo-500 focus:outline-none rounded-l" type="text" placeholder="{{ __('Search', 'woocommerce') }}" value="{{ get_search_query() }}" name="s" />
            <button type="submit" class="h-10 bg-gray-100 border border-l-0 border-gray-300 px-3 rounded-r hover:bg-gray-200 text-gray-500 cursor-pointer" aria-label="{{ __('Search', 'woocommerce') }}">
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </button>
          </form>
        
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
      <!-- Search form (visible on sm and down) -->
      <form class="search-form flex items-center" role="search" method="get" action="{{ home_url('/') }}">
        <input class="flex-1 h-10 px-3 bg-gray-100 text-gray-900 placeholder:text-gray-500 border border-gray-300 focus:ring-indigo-500 focus:outline-none rounded-l" type="text" placeholder="{{ __('Search', 'woocommerce') }}" value="{{ get_search_query() }}" name="s" />
        <button type="submit" class="h-10 bg-gray-100 border border-l-0 border-gray-300 px-3 rounded-r hover:bg-gray-200 text-gray-500 cursor-pointer" aria-label="{{ __('Search', 'woocommerce') }}">
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
          </svg>
        </button>
      </form>

      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav flex flex-col space-y-2', 'echo' => false]) !!}
    </nav>
  @endif
</header>
