<?php



class Webigo_Header_Menu_Categories {

    private $taxonomy = 'product_cat';

    private $orderby = 'name';

    private $query_params = array();

    /**
     * Flat array of product categories
     */
    private $categories = array();

    /**
     * List of product categories organized for hierarchical search
     * 
     *  'parent_id' => array( ...childs )
     * 
     */
    private $categories_hierarchy = array();

    public function __construct( )
    {
        $this->load_dependencies();
        $this->load_query_params();
        $this->load_categories();
    }

    private function load_dependencies()
    {

        require_once WEBIGO_PLUGIN_PATH . 'modules/header-menu/includes/class-webigo-header-menu-category.php';
        require_once WEBIGO_PLUGIN_PATH . 'modules/core/includes/class-webigo-pod-custom-fields.php';
        
    }

    private function load_query_params()
    {
        $this->query_params = array(
            'taxonomy'     => $this->taxonomy,
            'orderby'      => $this->orderby,
            'show_count'   => false,
            'pad_counts'   => false,
            'hierarchical' => true,
            'title_li'     => '',
            'hide_empty'   => false
        );
    }


    private function load_priority( object $category )
    {
        $pod_custom_fields  = new Webigo_Pod_Custom_Fields( 'product_cat' , $category, 'term' );
        $pod_priority_field = Webigo_Header_Menu_Settings::POD_CUSTOM_FIELDS_NAME['category_priority'];
        $priority           = (string)$pod_custom_fields->value_of( $pod_priority_field );

        if ( isset( $priority) ) {
            $_priority = (int)$priority;

            if ( $_priority === 0 ) {
                return 999;
            }
    
            return $_priority;
        }

        return 999;
    }

     
    private function load_categories( ) : void
    {

        $wc_categories = get_categories( $this->query_params );


        foreach ( $wc_categories as $wc_category ) {

            if ( ! isset( $this->categories[$wc_category->parent] ) ) {
                $this->categories[$wc_category->parent] = array();
            }

            $wbg_category = new Webigo_Header_Menu_Category( $wc_category );

            if ( Webigo_Header_Menu_Settings::HEADER_MENU_SHOW_EMPTIES === true && $wbg_category->is_empty() === true ) {

                $category = array(
                    'id'          => $wbg_category->id(),
                    'name'        => $wbg_category->name(),
                    'description' => $wbg_category->description(),
                    'link'        => $wbg_category->link(),
                    'image_url'   => $wbg_category->image_url(),
                    'priority'    => $this->load_priority( $wbg_category )
                );
    
                $this->categories_hierarchy[$wbg_category->parent()][$wbg_category->id()] = $category;
    
                array_push( $this->categories, $category );
            }
            
        }
        
    }

    private function _sort_priority_callback( $a, $b ) {

        if ( ! isset( $a['priority'], $b['priority'] ) || $a['priority'] === $b['priority'] ) {
            return 0;
        }
        return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
    }


    public function categories() : array
    {
        $categories = $this->categories;
        uasort( $categories, array( $this, '_sort_priority_callback' ) );

        return $categories;
    }

    public function categories_hierarchy() : array
    {

        $categories_hierarchy = $this->categories_hierarchy;
        uasort( $categories_hierarchy, array( $this, '_sort_priority_callback' ) );

        return $categories_hierarchy;
    }


    public function first_level_categories() : array
    {

        if (isset( $this->categories_hierarchy[0] ) ) {
            $categories_hierarchy = $this->categories_hierarchy[0];
            uasort( $categories_hierarchy, array( $this, '_sort_priority_callback' ) );
    
            return $categories_hierarchy;
        }

        return [];
    }

    public function has_children( $parent_category_id ) : bool
    {
        if ( isset( $this->categories_hierarchy[$parent_category_id] ) ) { 
            return count( $this->categories_hierarchy[$parent_category_id] ) > 0 ? true : false;
        }

        return false;
    }

    public function children( $parent_category_id ) : array
    {
        if ( isset( $this->categories_hierarchy[$parent_category_id] ) ) {
            $categories = $this->categories_hierarchy[$parent_category_id];
       
            uasort( $categories, array( $this, '_sort_priority_callback' ) );
    
            return $categories;
        }
        
        return [];
        
    }


}
