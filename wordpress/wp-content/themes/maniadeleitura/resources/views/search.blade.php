@extends('layouts.app')

@section('content')
    @php
        do_action('get_header', 'search');
    @endphp

    <header class="woocommerce-products-header">
        <h1 class="woocommerce-products-header__title page-title">
            {{ sprintf(__('Search results for: %s', 'sage'), get_search_query()) }}
        </h1>
    </header>

    <div class="woocommerce">

        @if (have_posts())
            @php
                woocommerce_product_loop_start();
            @endphp

            @while (have_posts())
                @php
                    the_post();
                @endphp

                @include('woocommerce.content-product')
            @endwhile

            @php
                woocommerce_product_loop_end();
            @endphp
        @else
            <x-alert type="warning">
                {!! __('Sorry, no results were found.', 'sage') !!}
            </x-alert>

            {!! get_search_form(false) !!}
        @endif
    </div>

    @php
        do_action('get_sidebar', 'search');
        do_action('get_footer', 'search');
    @endphp
@endsection
