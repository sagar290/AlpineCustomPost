<?php
/**
 * Custom Post Type Class
 *
 * Used to help create custom post types for Wordpress.
 * @link https://github.com/sagar290/AlpineCustomPost.git
 *
 * @author  Sagar Dash
 * @link    sagardash.com
 * @version 1.0
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class AlpineCustomPost
{
    /**
     * Post type name.
     *
     * @var string $post_type_name Holds the name of the post type.
     */
    public $post_type;
    /**
     * Post label options.
     *
     * @var array $post_label Holds the name of the post type.
     */
    public $post_label;
     /**
     * Post argument option.
     *
     * @var array $post_args Holds the name of the post type.
     */
    public $post_args;
        /**
     * Constructor
     *
     * Register a custom post type.
     *
     * @param mixed $name The name(s) of the post type, accepts (post type name, slug, plural, singular).
     * @param array $args User submitted options (optional).
     * @param array $labels User submitted options (optional).
     */
    public function __construct($name, $args = [], $labels = [])
    {

        // Set some important variables
        $this->post_type_name   = strtolower(str_replace(' ', '_', $name));
        $this->post_type_args   = $args;
        $this->post_type_labels = $labels;
 
        add_action("init", array(&$this, 'register_post_type'));

    }
    /**
     * register_post_type
     *
     * Register post type used make custom post
     * 
     * @return void
     */
    public function register_post_type()
    {

        $name       = ucwords(str_replace('_', ' ', $this->post_type_name));
        $plural     = $name . 's';
        $labels = array_merge(
            [
                'name'                  => _x($plural, 'post type general name'),
                'singular_name'         => _x($name, 'post type singular name'),
                'add_new'               => _x('Add New', strtolower($name)),
                'add_new_item'          => __('Add New ' . $name),
                'edit_item'             => __('Edit ' . $name),
                'new_item'              => __('New ' . $name),
                'all_items'             => __('All ' . $plural),
                'view_item'             => __('View ' . $name),
                'search_items'          => __('Search ' . $plural),
                'not_found'             => __('No ' . strtolower($plural) . ' found'),
                'not_found_in_trash'    => __('No ' . strtolower($plural) . ' found in Trash'),
                'parent_item_colon'     => '',
                'menu_name'             => $plural
            ],
            $this->post_type_labels
        );
        $args = array_merge(
            [
                'label'                 => $plural,
                'labels'                => $labels,
                'public'                => true,
                'show_ui'               => true,
                'supports'              => array('title', 'editor'),
                'show_in_nav_menus'     => true,
                '_builtin'              => false,
            ],

            $this->post_type_args
        );
        register_post_type($this->post_type_name, $args);
    }
    /**
     * add_taxonomy
     *
     * add_taxonomy with registeredf custom post
     * @param mixed $name The name(s) of the post type, accepts (post type name, slug, plural, singular).
     * @param array $args User submitted options (optional).
     * @param array $labels User submitted options (optional).
     * 
     * @return void
     */

    public function add_taxonomy($name, $args = [], $labels = [])
    {
        if (!empty($name)) {
            // We need to know the post type name, so the new taxonomy can be attached to it.
            $post_type_name = $this->post_type_name;

            // Taxonomy properties
            $taxonomy_name      = strtolower(str_replace(' ', '_', $name));
            $taxonomy_labels    = $labels;
            $taxonomy_args      = $args;

            if (!taxonomy_exists($taxonomy_name)) {
                //Capitilize the words and make it plural
                $name       = ucwords(str_replace('_', ' ', $name));
                $plural     = $name . 's';

                // Default labels, overwrite them with the given labels.
                $labels = array_merge(

                    // Default
                    [
                        'name'                  => _x($plural, 'taxonomy general name'),
                        'singular_name'         => _x($name, 'taxonomy singular name'),
                        'search_items'          => __('Search ' . $plural),
                        'all_items'             => __('All ' . $plural),
                        'parent_item'           => __('Parent ' . $name),
                        'parent_item_colon'     => __('Parent ' . $name . ':'),
                        'edit_item'             => __('Edit ' . $name),
                        'update_item'           => __('Update ' . $name),
                        'add_new_item'          => __('Add New ' . $name),
                        'new_item_name'         => __('New ' . $name . ' Name'),
                        'menu_name'             => __($name),
                    ],

                    // Given labels
                    $taxonomy_labels

                );

                // Default arguments, overwritten with the given arguments
                $args = array_merge(

                    // Default
                    array(
                        'label'                 => $plural,
                        'labels'                => $labels,
                        'public'                => true,
                        'show_ui'               => true,
                        'show_in_nav_menus'     => true,
                        '_builtin'              => false,
                    ),

                    // Given
                    $taxonomy_args

                );

                // Add the taxonomy to the post type
                add_action(
                    'init',
                    function () use ($taxonomy_name, $post_type_name, $args) {
                        register_taxonomy($taxonomy_name, $post_type_name, $args);
                    }
                );
            } else {
                throw new Exception("{$taxonomy_name} already exists", 1);
            }
        }
    }
}
