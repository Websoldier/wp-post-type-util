```php
/**
 * Register post type example.
 *
 * Author: NikolayS93
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
```

Определите классы _(которые вы хотите использовать)_.

```php
use WP_Utility\Post_Type;
use WP_Utility\Custom_Fields_Meta_Box;
```

Загрузите необходимые файлы _(или подключите автозагрузчик)_
```php
require_once __DIR__ . '/vendor/wp-post-type-util/autoload.php';
```

_Теперь вы можете без проблем __зарегистрировать новый тип__:_
```php
// Register new post type.
$post_type = new Post_Type( 'slide', $args = array(), array(
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
) );
```
_...и добавить __метабокс с произвольным полем__ "Ссылка"_
```php
// Add metabox with custom meta fields on edit page.
$post_type
	->set_metabox( new Custom_Fields_Meta_Box( array(
		'link' => __( 'Ссылка' ),
	) ) );
```
