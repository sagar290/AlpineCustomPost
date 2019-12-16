# Alpine Custom Post Class

This class helps you to make custom post type within a second. 
No need to worry about all those wordpress api functions for registered custom post, just give the 
name of your post type and **BOOM**! 

#### Example
``` php
    $book = new AlpineCustomPost("book");
```
And see the result :smiley:

## Documentation
 
#### Basic

```php

    $book = new AlpineCustomPost("book");
``` 
#### With Custom Labels and Argument

```php
        $labels = [
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
        ];
       $args = [
                'label'                 => $plural,
                'labels'                => $labels,
                'public'                => true,
                'show_ui'               => true,
                'supports'              => array('title', 'editor'),
                'show_in_nav_menus'     => true,
                '_builtin'              => false,
           ];

     $book = new AlpineCustomPost("book", $args, $labels);
```

### Extra Features
Some extra features, which will make your life more beautiful.
#### Add Column
You also can add custom column in edit.php page
```php
    $book->add_column("price", "callback");

    function callback( $column, $post_id ) {
        if ( 'price' === $column ) {
            echo "your price here";
        }
    }
``` 

## Conclusion 
I made this class for my personal project. You can use this as well for your personal project or development. 

## Last but not least 
As I am a noob developer, its normal to make mistake.
please feel free raise issue if any problem happen and also **contribution which is highly welcome**.
