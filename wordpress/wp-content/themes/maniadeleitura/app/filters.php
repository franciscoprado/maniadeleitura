<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter("excerpt_more", function () {
    return sprintf(
        ' &hellip; <a href="%s">%s</a>',
        get_permalink(),
        __("Continued", "sage"),
    );
});

// Custom: Replace WooCommerce product loop hooks with theme callbacks
add_action("init", function () {
    // Only run when WooCommerce is active
    if (!class_exists("WooCommerce")) {
        return;
    }

    // Remove WooCommerce default callbacks for product loop title, meta and actions
    remove_action(
        "woocommerce_shop_loop_item_title",
        "woocommerce_template_loop_product_title",
        10,
    );
    remove_action(
        "woocommerce_after_shop_loop_item_title",
        "woocommerce_template_loop_rating",
        5,
    );
    remove_action(
        "woocommerce_after_shop_loop_item_title",
        "woocommerce_template_loop_price",
        10,
    );
    remove_action(
        "woocommerce_after_shop_loop_item",
        "woocommerce_template_loop_product_link_close",
        5,
    );
    remove_action(
        "woocommerce_after_shop_loop_item",
        "woocommerce_template_loop_add_to_cart",
        10,
    );

    // Add theme replacement callbacks (namespaced functions in App\ namespace)
    add_action(
        "woocommerce_shop_loop_item_title",
        __NAMESPACE__ . "\\maniadeleitura_shop_loop_item_title",
        10,
    );
    add_action(
        "woocommerce_after_shop_loop_item_title",
        __NAMESPACE__ . "\\maniadeleitura_after_shop_loop_item_title",
        10,
    );
    add_action(
        "woocommerce_after_shop_loop_item",
        __NAMESPACE__ . "\\maniadeleitura_after_shop_loop_item",
        10,
    );
});

/**
 * Theme replacement for 'woocommerce_after_shop_loop_item'.
 * Closes the product link and outputs the add-to-cart button inside a theme wrapper.
 */
function maniadeleitura_after_shop_loop_item()
{
    global $product;

    // Ensure $product is a WC_Product
    if (!is_a($product, "WC_Product")) {
        return;
    }

    echo '<div class="maniadeleitura-loop-actions">';

    // Close the product link (falls back to closing tag if function unavailable)
    if (function_exists("woocommerce_template_loop_product_link_close")) {
        woocommerce_template_loop_product_link_close();
    } else {
        echo "</a>";
    }

    // Output add to cart (use WooCommerce default template if available)
    if (function_exists("woocommerce_template_loop_add_to_cart")) {
        woocommerce_template_loop_add_to_cart();
    } else {
        // Fallback button
        printf(
            '<a href="%s" data-quantity="1" class="button add_to_cart_button" aria-label="%s">%s</a>',
            esc_url($product->add_to_cart_url()),
            esc_attr(
                sprintf(
                    __('Add "%s" to your cart', "woocommerce"),
                    $product->get_name(),
                ),
            ),
            esc_html($product->add_to_cart_text()),
        );
    }

    echo "</div>";
}

/**
 * Theme replacement for 'woocommerce_shop_loop_item_title'.
 * Outputs the product title.
 */
function maniadeleitura_shop_loop_item_title()
{
    global $product;

    if (!is_a($product, "WC_Product")) {
        return;
    }

    printf(
        '<h2 class="maniadeleitura-loop-product__title" title="%s">%s</h2>',
        esc_attr(get_the_title()),
        esc_html(get_the_title()),
    );
}

/**
 * Theme replacement for 'woocommerce_after_shop_loop_item_title'.
 * Outputs rating and price inside a theme wrapper.
 */
function maniadeleitura_after_shop_loop_item_title()
{
    global $product;

    if (!is_a($product, "WC_Product")) {
        return;
    }

    echo '<div class="maniadeleitura-loop-meta">';
    if (function_exists("woocommerce_template_loop_rating")) {
        woocommerce_template_loop_rating();
    }
    if (function_exists("woocommerce_template_loop_price")) {
        woocommerce_template_loop_price();
    }
    echo "</div>";
}
