<?php
/**
 * Plugin Name: Register post type example
 * Plugin URI: https://github.com/nikolays93/wp-post-type-util
 * Description: Make post type easy
 * Version: 1.0.0
 * Author: NikolayS93
 * Author URI: https://vk.com/nikolays_93
 * Author EMAIL: NikolayS93@ya.ru
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package WordPress.PostType
 */

namespace WP_Utility;

require_once __DIR__ . '/autoload.php';

// Post type program name.
$post_type_slug = 'slide';
// Custom labels.
$labels = array(
	'name'               => __( 'Слайды' ),
	'singular_name'      => __( 'Слайд' ),
	'add_new'            => __( 'Добавить слайд' ),
	'add_new_item'       => __( 'Добавить слайд' ),
	'edit_item'          => __( 'Редактировать слайд' ),
	'new_item'           => __( 'Новый слайд' ),
	'all_items'          => __( 'Все слайды' ),
	'view_item'          => __( 'Просмотр слайда на сайте' ),
	'search_items'       => __( 'Найти слайд' ),
	'not_found'          => __( 'Слайдов не найдено.' ),
	'not_found_in_trash' => __( 'В корзине нет слайдов.' ),
	'menu_name'          => __( 'Слайды' ),
);
// Custom meta fields.
$fields = array(
	'link' => __( 'Ссылка' ),
);

/**
 * Register new post type.
 *
 * @note Use third arg for change only once label.
 */
$new_post_type = new Post_Type( $post_type_slug, array( 'labels' => $labels ) );
$new_post_type
	// Add metabox with custom meta fields on edit page.
	->set_metabox( new Custom_Fields_Meta_Box( $fields ) );
