<?php

/**
 * Add support for two custom navigation menus.
 */
register_nav_menus( array(
    'topbar'   => __( 'Top Bar Menu', 'flatsome-child' ),
	'primary'   => __( 'Main Menu', 'flatsome-child' ),
	'secondary' => __( 'Footer Menu', 'flatsome-child' ),
) );

/**
 * Add custom CSS
 */
function mzrd_enqueue_styles() {

    wp_enqueue_style('top-bar-menu-style', get_stylesheet_directory_uri() . '/assets/css/top-bar-menu.css', '', time());
    wp_enqueue_style('header-main-style', get_stylesheet_directory_uri() . '/assets/css/header-main.css', '', time());
    wp_enqueue_style('header-menu-style', get_stylesheet_directory_uri() . '/assets/css/header-menu.css', '', time());
    wp_enqueue_style('top-footer-style', get_stylesheet_directory_uri() . '/assets/css/top-footer.css', '', time());
    wp_enqueue_style('shop-style', get_stylesheet_directory_uri() . '/assets/css/shop.css', '', time());
    wp_enqueue_style('single-product-style', get_stylesheet_directory_uri() . '/assets/css/single-product.css', '', time());
}
add_action('wp_enqueue_scripts', 'mzrd_enqueue_styles');

/**
 * Add custom JS
 */
function mzrd_enqueue_scripts() {

    wp_enqueue_script('var-calculator-script', get_stylesheet_directory_uri() . '/assets/js/var-calculator.js', array('jquery'), time(), true);
}
add_action('wp_enqueue_scripts', 'mzrd_enqueue_scripts');

/**
 * Add text before the product price on Single Product
 */
add_filter( 'woocommerce_get_price_html', 'mzrd_add_custom_text_before_price' );
add_filter( 'woocommerce_cart_item_price', 'mzrd_add_custom_text_before_price' );
function mzrd_add_custom_text_before_price( $price ) {
    $text = __('Starting From', 'flatsome-child');
    return $text . ' ' . $price;
}

/**
 * Add product title to breadcrumbs on Single Product
 */
add_filter('woocommerce_get_breadcrumb', 'mzrd_woocommerce_breadcrumbs');
function mzrd_woocommerce_breadcrumbs($crumbs) {
    if (is_product()) {
        global $post;
        $product_title = get_the_title($post->ID);
        $crumbs[] = array($product_title, get_permalink($post->ID));
    }
    return $crumbs;
}

/**
 * Remove WooCommerce default tabs
 */
add_filter('woocommerce_product_tabs', 'mzrd_remove_woocommerce_product_tabs', 98);
function mzrd_remove_woocommerce_product_tabs($tabs) {
    // Remove "Additional Information" tab
    unset($tabs['additional_information']);

    // Remove "Reviews" tab
    unset($tabs['reviews']);

    return $tabs;
}


/**
 * Create metaboxes for tabs on Single Product
 */
// Create an array of metaboxes
function mzrd_register_custom_metaboxes() {
    $metaboxes = [
        'mzrd_product_details_meta_box' => [
            'title' => __('Product Details', 'flatsome-child'),
            'callback' => 'mzrd_product_details_meta_box_callback',
        ],
        'mzrd_our_diamonds_meta_box' => [
            'title' => __('Our Diamonds', 'flatsome-child'),
            'callback' => 'mzrd_our_diamonds_meta_box_callback',
        ],
        'mzrd_shipping_returns_meta_box' => [
            'title' => __('Shipping & Returns', 'flatsome-child'),
            'callback' => 'mzrd_shipping_returns_meta_box_callback',
        ],
    ];

    foreach ($metaboxes as $id => $metabox) {
        add_meta_box(
            $id,
            $metabox['title'],
            $metabox['callback'],
            'product',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'mzrd_register_custom_metaboxes');

// Product Details metabox output
function mzrd_product_details_meta_box_callback($post) {
    // Creating a nonce field for protection
    wp_nonce_field('mzrd_save_product_details_data', 'mzrd_product_details_meta_box_nonce');

    // Get the current field value
    $product_details = get_post_meta($post->ID, '_mzrd_product_details', true);

    // Text field
    echo '<label for="mzrd_product_details">' . __('Enter Product Details Tab Content:', 'flatsome-child') . '</label>';
    echo '<textarea style="width:100%;" id="mzrd_product_details" name="mzrd_product_details" rows="5">' . esc_textarea($product_details) . '</textarea>';
}

// Our Diamonds metabox output
function mzrd_our_diamonds_meta_box_callback($post) {
    // Creating a nonce field for protection
    wp_nonce_field('mzrd_save_our_diamonds_data', 'mzrd_our_diamonds_meta_box_nonce');

    // Get the current field value
    $our_diamonds = get_post_meta($post->ID, '_mzrd_our_diamonds', true);

    // Text field
    echo '<label for="mzrd_our_diamonds">' . __('Enter Our Diamonds Tab Content:', 'flatsome-child') . '</label>';
    echo '<textarea style="width:100%;" id="mzrd_our_diamonds" name="mzrd_our_diamonds" rows="5">' . esc_textarea($our_diamonds) . '</textarea>';
}

// Shipping & Returns metabox output
function mzrd_shipping_returns_meta_box_callback($post) {
    // Creating a nonce field for protection
    wp_nonce_field('mzrd_save_shipping_returns_data', 'mzrd_shipping_returns_meta_box_nonce');

    // Get the current field value
    $shipping_returns = get_post_meta($post->ID, '_mzrd_shipping_returns', true);

    // Display the editor with the stored HTML content
    wp_editor($shipping_returns, '_mzrd_shipping_returns', array(
        'textarea_name' => 'mzrd_shipping_returns',
        'textarea_rows' => 5,
        'media_buttons' => true,
        'tinymce'       => true
    ));
}

// Saving Product Details metafield data
function mzrd_save_product_details_data($post_id) {
    // Nonce validation
    if (!isset($_POST['mzrd_product_details_meta_box_nonce']) || !wp_verify_nonce($_POST['mzrd_product_details_meta_box_nonce'], 'mzrd_save_product_details_data')) {
        return;
    }

    // Checking the right to edit
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && $_POST['post_type'] === 'product') {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Data storage
    if (isset($_POST['mzrd_product_details'])) {
        update_post_meta($post_id, '_mzrd_product_details', sanitize_textarea_field($_POST['mzrd_product_details']));
    }
}
add_action('save_post', 'mzrd_save_product_details_data');

// Saving Our Diamonds metafield data
function mzrd_save_our_diamonds_data($post_id) {
    // Nonce validation
    if (!isset($_POST['mzrd_our_diamonds_meta_box_nonce']) || !wp_verify_nonce($_POST['mzrd_our_diamonds_meta_box_nonce'], 'mzrd_save_our_diamonds_data')) {
        return;
    }

    // Checking the right to edit
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && $_POST['post_type'] === 'product') {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Data storage
    if (isset($_POST['mzrd_our_diamonds'])) {
        update_post_meta($post_id, '_mzrd_our_diamonds', sanitize_textarea_field($_POST['mzrd_our_diamonds']));
    }
}
add_action('save_post', 'mzrd_save_our_diamonds_data');

// Saving Shipping & Returns metafield data
function mzrd_save_shipping_returns_data($post_id) {
    // Nonce validation
    if (!isset($_POST['mzrd_shipping_returns_meta_box_nonce']) || !wp_verify_nonce($_POST['mzrd_shipping_returns_meta_box_nonce'], 'mzrd_save_shipping_returns_data')) {
        return;
    }

    // Checking the right to edit
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && $_POST['post_type'] === 'product') {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Data storage
    if (isset($_POST['mzrd_shipping_returns'])) {
        update_post_meta($post_id, '_mzrd_shipping_returns', wp_kses_post($_POST['mzrd_shipping_returns']));
    }
}
add_action('save_post', 'mzrd_save_shipping_returns_data');

/**
 * Add custom tabs to Single Product
 */
add_filter('woocommerce_product_tabs', 'mzrd_custom_product_tabs');
function mzrd_custom_product_tabs($tabs) {
    // Product Details Tab
    $tabs['product_details'] = [
        'title' => __('Product Details', 'flatsome-child'),
        'priority' => 10,
        'callback' => 'mzrd_product_details_tab_callback',
    ];

    // Our Diamonds Tab
    $tabs['our_diamonds'] = [
        'title' => __('Our Diamonds', 'flatsome-child'),
        'priority' => 12,
        'callback' => 'mzrd_our_diamonds_tab_callback',
    ];

    // Shipping & Returns Tab
    $tabs['shipping_returns'] = [
        'title' => __('Shipping & Returns', 'flatsome-child'),
        'priority' => 14,
        'callback' => 'mzrd_shipping_returns_tab_callback',
    ];

    return $tabs;
}

/**
 * Add content in Product Details tab to Single Product
 */
function mzrd_product_details_tab_callback() {
    global $post;

    $product_details = get_post_meta($post->ID, '_mzrd_product_details', true);

    if ($product_details) {
        echo '<p>' . nl2br(esc_html($product_details)) . '</p>';
    } else {
        echo '<p>' . __('No additional details available.', 'flatsome-child') . '</p>';
    }
}

/**
 * Add content in Our Diamonds tab to Single Product
 */
function mzrd_our_diamonds_tab_callback() {
    global $post;

    // Отримання даних мета поля
    $our_diamonds = get_post_meta($post->ID, '_mzrd_our_diamonds', true);

    // Виведення контенту
    if ($our_diamonds) {
        echo '<p>' . nl2br(esc_html($our_diamonds)) . '</p>';
    } else {
        echo '<p>' . __('No additional details available.', 'flatsome-child') . '</p>';
    }
}

/**
 * Add content in Shipping & Returns tab to Single Product
 */
function mzrd_shipping_returns_tab_callback() {
    global $post;

    // Get the meta field value
    $shipping_returns = get_post_meta($post->ID, '_mzrd_shipping_returns', true);

    // Check if there is content to display
    if ($shipping_returns) {
        echo wp_kses_post(wpautop($shipping_returns)); // Display the formatted content
    } else {
        echo '<p>' . __('No additional details available.', 'flatsome-child') . '</p>';
    }
}

/**
 * Show attributes on Single Product
 */
add_action( 'woocommerce_single_product_summary', 'mzrd_display_product_attributes', 25 );
function mzrd_display_product_attributes() {
    global $product;

    $attributes = $product->get_attributes();

    if ( ! empty( $attributes ) ) {
        echo '<div class="product_attributes">';
        foreach ( $attributes as $attribute ) {
            if ( $attribute->get_visible() ) {
                // Get the attribute name and options
                $attribute_name = wc_attribute_label( $attribute->get_name() );

                // If attribute is a taxonomy, get its terms
                if ( $attribute->is_taxonomy() ) {
                    $terms = wp_get_post_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) );
                    $attribute_value = implode( ', ', $terms );
                } else {
                    // If not a taxonomy, just get the value
                    $attribute_value = implode( ', ', $attribute->get_options() );
                }

                // Output the attribute name and value
                echo '<p><strong>' . $attribute_name . ':</strong> ' . $attribute_value . '</p>';
            }
        }
        echo '</div>';
    }
}

/**
 * Hide product price on Single Product
 */
add_filter('woocommerce_get_price_html', 'mzrd_remove_price_on_single_product', 10, 2);
function mzrd_remove_price_on_single_product($price, $product) {
    if (is_product()) {
        $price = '';
    }
    return $price;
}

/**
 * Add custom text before variation attribute label
 */
function mzrd_add_text_after_diamond_shape( $html, $args ) {
    if ( isset( $args['attribute'] ) && 'pa_diamond-shape' === $args['attribute'] ) {
        $custom_text = '<p>Please choose diamond shape</p>';
        $html = $custom_text . $html;
    }
    return $html;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'mzrd_add_text_after_diamond_shape', 20, 2 );

function mzrd_add_text_after_precious_metal( $html, $args ) {
    if ( isset( $args['attribute'] ) && 'pa_precious-metal' === $args['attribute'] ) {
        $custom_text = '<p>Please choose diamond metal</p>';
        $html = $custom_text . $html;
    }
    return $html;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'mzrd_add_text_after_precious_metal', 20, 2 );

function mzrd_add_text_after_carats_weight( $html, $args ) {
    if ( isset( $args['attribute'] ) && 'pa_carats-weight' === $args['attribute'] ) {
        $custom_text = '<p>Please choose carats weight</p>';
        $html = $custom_text . $html;
    }
    return $html;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'mzrd_add_text_after_carats_weight', 20, 2 );

function mzrd_add_text_after_ring_size( $html, $args ) {
    if ( isset( $args['attribute'] ) && 'pa_ring-size' === $args['attribute'] ) {
        $custom_text = '<p>Please choose ring size</p>';
        $html = $custom_text . $html;
    }
    return $html;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'mzrd_add_text_after_ring_size', 20, 2 );

/**
 * Add color circle before Precious metal variation attributes
 */
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'mzrd_variation_option_html', 20, 2);
function mzrd_variation_option_html($html, $args) {
    // Get the terms related to the current attribute
    $terms = wc_get_product_terms($args['product']->get_id(), $args['attribute'], array('fields' => 'all'));

    foreach ($terms as $term) {
        // Get the color value from the ACF field by term ID
        $color_value = get_field('precious_metal_', 'pa_precious-metal_' . $term->term_id);

        if ($color_value) {
            // Create a color circle HTML with appropriate escaping and sanitization
            $color_circle = '<span style="display:inline-block; width:25px; height:20px; background-color:' . esc_attr($color_value) . '; border-radius:50%; margin-left:5px;"></span>';

            // Build a search pattern to find the correct place to insert the color circle
            $pattern = '/(<li\b[^>]*?\bdata-value="' . preg_quote($term->slug, '/') . '"[^>]*>)(.*?)(<\/li>)/i';

            // Replace term name within the matched pattern
            $replacement = '$1<div class="variable-item-contents">' . $color_circle . '$2</div>$3';

            // Apply the replacement to the entire HTML block
            $html = preg_replace($pattern, $replacement, $html);
        }
    }
    return $html;
}

/**
 * Display Diamond Shape icons
 */
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'mzrd_diamond_shape_variation_html', 20, 2);

function mzrd_diamond_shape_variation_html($html, $args) {
    // Check if the current attribute is Diamond Shape
    if ($args['attribute'] === 'pa_diamond-shape') {
        // Get the terms related to the current attribute
        $terms = wc_get_product_terms($args['product']->get_id(), $args['attribute'], array('fields' => 'all'));

        foreach ($terms as $term) {
            // Get the icon ID from the ACF field by term ID
            $icon_id = get_field('shape_icon', 'pa_diamond-shape_' . $term->term_id);

            if ($icon_id) {
                // Get the image URL from the icon ID
                $icon_url = wp_get_attachment_image_url($icon_id, 'thumbnail');

                if ($icon_url) {
                    // Create an image HTML tag with the icon URL
                    $icon_html = '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($term->name) . '" >';

                    // Build a search pattern to find the correct place to insert the icon
                    $pattern = '/(<li\b[^>]*?\bdata-value="' . preg_quote($term->slug, '/') . '"[^>]*>)(.*?)(<\/li>)/i';

                    // Replace term name within the matched pattern
                    $replacement = '$1<div class="variable-item-contents">' . $icon_html . '$2</div>$3';

                    // Apply the replacement to the entire HTML block
                    $html = preg_replace($pattern, $replacement, $html);
                }
            }
        }
    }

    return $html;
}

/**
 * Output base price of the variable product on Single Product
 */
add_action('woocommerce_single_product_summary', 'mzrd_display_base_price', 5);
function mzrd_display_base_price() {
    global $product;

    $base_price = get_field('base_price', $product->get_id());

    if ($base_price) {
        echo '<input type="hidden" id="base_price" value="' . esc_attr($base_price) . '">';
    }
}

/**
 * Add HTML element for show variation price before Add To Cart button
 */
function mzrd_display_calculated_price() {
    echo '<div id="calculated-price">Loading...</div>';
}
add_action('woocommerce_before_add_to_cart_button', 'mzrd_display_calculated_price', 10);

/**
 * The actual calculation the variable product price on Single Product
 */
function mzrd_calculate_price() {
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(['error' => 'Product ID is missing.']);
        return;
    }

    $product_id = absint($_POST['product_id']);
    $precious_metal = isset($_POST['precious_metal']) ? sanitize_text_field($_POST['precious_metal']) : '';
    $carat_weight = isset($_POST['carat_weight']) ? (float)$_POST['carat_weight'] : 0.0;
    $ring_size = isset($_POST['ring_size']) ? (float)$_POST['ring_size'] : 0.0;

    // Obtaining the base price using ACF
    $base_price = get_field('base_price', $product_id);
    if (!$base_price) {
        wp_send_json_error(['error' => 'Base price is missing.']);
        return;
    }

    $final_price = $base_price;

    // Calculation depending on the metal
    if ($precious_metal === 'platinum') {
        $precious_metal_percent = (float)get_field('platinum_increase', $product_id);
        $final_price += ($final_price * $precious_metal_percent / 100);
    }

    // Calculation based on carat weight
    if ($carat_weight) {
        $price_per_carat = (float)get_field('price_per_carat', $product_id);
        $final_price += ($price_per_carat * $carat_weight);
    }

    // Calculation depending on the size of the ring
    if (isset($ring_size) && $ring_size >= 8) {
        $ring_size_percent = (float)get_field('ring_size_increase', $product_id);
        $final_price += ($base_price * $ring_size_percent / 100);
    }

    wp_send_json_success(['final_price' => $final_price]);

}
add_action('wp_ajax_calculate_price', 'mzrd_calculate_price');
add_action('wp_ajax_nopriv_calculate_price', 'mzrd_calculate_price');

/**
 * Update options for Carats Weight attribute
 */
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'mzrd_carats_weight_options', 10, 2);
function mzrd_carats_weight_options($html, $args) {
    if ($args['attribute'] === 'pa_carats-weight') {
        // Get the terms for the attribute
        $terms = get_terms(array(
            'taxonomy' => 'pa_carats-weight',
            'hide_empty' => false,
        ));

        // Create new options
        $options = '';
        foreach ($terms as $term) {
            // Replace dots with hyphens for display values
            $value = str_replace('-', '.', $term->name);
            $options .= '<option value="' . esc_attr($value) . '">' . esc_html($value) . '</option>';
        }

        // Replace old options with new ones
        $html = preg_replace('/<option value="">.*?<\/option>/', '', $html);
        $html = str_replace('</select>', $options . '</select>', $html);
    }

    return $html;
}

/**
 * Dynamically form options for the "Carats Weight" field depending on the minimum and maximum
 */
add_action('woocommerce_single_product_summary', 'mzrd_display_carat_range', 6);
function mzrd_display_carat_range() {
    global $product;

    $carat_min = get_field('carat_min', $product->get_id());
    $carat_max = get_field('carat_max', $product->get_id());

    if ($carat_min && $carat_max) {
        echo '<input type="hidden" id="carat_min" value="' . esc_attr($carat_min) . '">';
        echo '<input type="hidden" id="carat_max" value="' . esc_attr($carat_max) . '">';
    }
}

/**
 * Add a Engagement Rings header to the Categories page
 */
function mzrd_custom_category_layout() {
    if (is_product_category()) {
        $current_category = get_queried_object();

        if ($current_category && !is_wp_error($current_category)) {
            // Display the title of the category before the content
            ?>
            <div id="brxe-sgwtpk" class="brxe-container" style="text-align: center;">
                <div id="mydiv">
                    <div id="brxe-sgwtpk" class="brxe-container">
                        <div id="brxe-krisox" class="brxe-divider heading__line--left horizontal">
                            <div class="line"></div>
                        </div>
                        <h2 id="brxe-cqiaxm" class="brxe-heading"><?php echo esc_html($current_category->name); ?></h2>
                        <div id="brxe-emmydi" class="brxe-divider heading__line--right horizontal">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            // Get the ID of the image and the URL of the category
            $category_image_id = get_term_meta($current_category->term_id, 'thumbnail_id', true);
            $category_image_url = wp_get_attachment_url($category_image_id);
            $category_name = $current_category->name;

            // Receive all products of the category
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 7, // Всі 7 товарів
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $current_category->term_id,
                    ),
                ),
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                // Open the grid container
                echo '<div class="custom-category-grid">';
                // Take out the first product
                $query->the_post();
                ?>
                <div class="grid-item category-image">
                    <div class="category-image__img">
                        <img src="<?php echo esc_url($category_image_url); ?>" alt="<?php echo esc_attr($category_name); ?>">
                    </div>
                    <div class="category-name term__injection-title"><?php echo esc_html($category_name); ?></div>
                </div>
                <div class="grid-item product">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <img src="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>" alt="<?php the_title(); ?>">
                    </a>
                    <div class="product-info">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <h2><?php the_title(); ?></h2>
                        </a>
                        <p class="starting-from"><?php
                            if ('Affordable Elegance' !== $category_name) _e('Starting From ', 'flatsome-child');
                            echo ' ' . wc_price(get_post_meta(get_the_ID(), '_price', true)); ?></p>
                        <a class="shop__btn bricks-button" href="<?php echo esc_url(get_permalink()); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="#1F1D1D" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M3 6H21" stroke="#1F1D1D" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10" stroke="#1F1D1D" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            SHOP NOW
                        </a>

                    </div>
                </div>
                <?php

                // Take out the rest of the products
                while ($query->have_posts()) : $query->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
                echo '</div>'; // Close the grid container
            endif;

            wp_reset_postdata();
        }
    }
}
add_action('woocommerce_before_main_content', 'mzrd_custom_category_layout', 15);

