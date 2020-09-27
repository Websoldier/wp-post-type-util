<?php
/**
 * New post type utilite
 *
 * @package WordPress.PostType
 */

namespace WP_Utility;

class Post_Type {
	private $slug;
	private $args;
	private $labels;

	/**
	 * Get current post type slug/ID
	 *
	 * @return string Slug from filter.
	 */
	public function get_slug() {
		return apply_filters( 'post_type_slug', $this->slug );
	}

	/**
	 * Init new post type
	 *
	 * @param string $slug   Post type slug/ID.
	 * @param array  $args   Arguments like as register_post_type().
	 * @param array  $labels For easy change once label string.
	 */
	public function __construct( $slug, $args = array(), $labels = array() ) {
		$this->slug   = $slug;
		$this->args   = $args;
		$this->labels = $labels;

		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register post hook
	 */
	public function register() {
		$labels = wp_parse_args(
			$this->labels,
			array(
				'name'               => __( 'Запись' ),
				'singular_name'      => __( 'Запись' ),
				'add_new'            => __( 'Добавить запись' ),
				'add_new_item'       => __( 'Добавить запись' ),
				'edit_item'          => __( 'Редактировать запись' ),
				'new_item'           => __( 'Новая запись' ),
				'all_items'          => __( 'Все записи' ),
				'view_item'          => __( 'Просмотр записи на сайте' ),
				'search_items'       => __( 'Найти запись' ),
				'not_found'          => __( 'Записей не найдено.' ),
				'not_found_in_trash' => __( 'В корзине нет записей.' ),
				'menu_name'          => __( 'Запись' ),
			)
		);

		register_post_type(
			$this->slug,
			wp_parse_args(
				$this->args,
				array(
					'labels'              => $labels,
					'public'              => true,
					'publicly_queryable'  => null,
					'exclude_from_search' => null,
					'show_ui'             => null,
					'show_in_menu'        => null,
					'show_in_admin_bar'   => null,
					'show_in_nav_menus'   => null,
					'menu_icon'           => null,
					'menu_position'       => 15,
					'has_archive'         => false,
					'hierarchical'        => false,
					'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
					'description'         => '',
				)
			)
		);

		return $this;
	}

	/**
	 * Set metabox for Post edit page
	 *
	 * @param Abstract_Custom_Fields_Meta_Box $metabox Meta_Box instance.
	 */
	public function set_metabox( Abstract_Custom_Fields_Meta_Box $metabox ) {
		$metabox->init( $this->get_slug() );
		return $this;
	}
}
