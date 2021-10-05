<?php



class Webigo_Header_Menu_Category {


    private $taxonomy;

    /**
     * @var object WP_Term
     */
    private $category;

    public function __construct( object $category, string $taxonomy = 'product_cat' )
    {
        $this->taxonomy = $taxonomy;
        $this->category = $category;
    }

    public function id() : int
    {
        return $this->category->term_id;
    }

    public function name() : string
    {
        return $this->category->name;
    }

    public function slug() : string
    {
        return $this->category->slug;
    }

    public function description() : string
    {
        return $this->category->description;
    }

    public function parent() : int
    {
        return $this->category->parent;
    }


    public function link( ) : string
    {
        return get_term_link( $this->category->slug, $this->taxonomy );
    }


    public function image_url() : string
    {
        $thumbnail_id = get_term_meta( $this->id(), 'thumbnail_id', true );
        return wp_get_attachment_url( $thumbnail_id );
    }

    private function get_wc_products_category ( ) : array
    {

        $query = new WC_Product_Query( array(
            'status' => 'publish',
            'category' => array(  $this->category->slug ),
            'return' => 'objects',
        ) );

        return $query->get_products();
    }

    public function is_empty() : bool
    {
        $wc_products_category = $this->get_wc_products_category();

        return count( $wc_products_category ) === 0 ? true : false;
    }


}

