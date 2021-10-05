<?php


class Webigo_Header_Menu_Shortcode {
 

    public function __construct()
    {
        $this->load_dependencies();
        $this->add_shortcodes();
        
    }

    private function load_dependencies()
    {
        require_once WEBIGO_PLUGIN_PATH . '/modules/header-menu/views/class-webigo-view-header-menu-shortcode.php';
    }

    public function add_shortcodes()
    {
        add_shortcode( 'header_menu', array( $this, 'render' ) );
    }

    public function render()
    {

        $view = new Webigo_View_Header_Menu_Shortcode( );

        $view->render( );
    }


}
