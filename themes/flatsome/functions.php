<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */

require get_template_directory() . '/inc/init.php';

/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */

function mrkvuamp_set_regular_price_plus($price)
{
    return 1.20 * $price;
}
add_filter( 'mrkvuamp_after_get_regular_price', 'mrkvuamp_set_regular_price_plus' );