{{-- Hack para fazer paginação do Woocommerce sem precisar pagar a versão PRO --}}
@php
    global $wp_query;
    $total = $wp_query->max_num_pages;
    $current = max(1, get_query_var('paged'));
    $base = esc_url_raw(
        str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))),
    );
    $format = '?paged=%#%';

@endphp

<nav class="woocommerce-pagination" aria-label="<?php esc_attr_e('Product Pagination', 'woocommerce'); ?>">
    @php
        echo paginate_links(
            apply_filters('woocommerce_pagination_args', [
                // WPCS: XSS ok.
                'base' => $base,
                'format' => $format,
                'add_args' => false,
                'current' => max(1, $current),
                'total' => $total,
                'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                'type' => 'list',
                'end_size' => 3,
                'mid_size' => 3,
            ]),
        );
    @endphp
</nav>
