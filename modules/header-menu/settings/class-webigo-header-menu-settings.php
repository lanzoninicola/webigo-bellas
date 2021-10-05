<?php


class Webigo_Header_Menu_Settings {

    const MODULE_NAME = 'header-menu';

    const MODULE_FOLDER = 'header-menu';

    const BOOTSTRAP_CLASS_NAME = 'Webigo_Header_Menu';

    const BOOTSTRAP_CLASS_FILENAME = 'class-webigo-header-menu.php';

    const CSS_VERSION = '2109292134';

    const JS_VERSION = '2109292134';

    const HEADER_MENU_SHOW_CATEGORY_IMAGE = false;

    const HEADER_MENU_SHOW_EMPTIES = false;

    const POD_CUSTOM_FIELDS_NAME = array(
        'category_priority' => 'em_destaque',
    );

    const POD_CUSTOM_SETTINGS_PAGE = array(
        'pod_name'   => 'pod_theme_editor',
        'mobile'     => array(
            'breakpoints'      => ['min' => 0, 'max' => 478],
            'background_color' => 'mobile_menu_background_color',
            'font_color'       => 'mobile_menu_font_color'
        ),
        'desktop'     => array(
            'breakpoints'               => ['min' => 479, 'max' => 2048],
            'submenu_background_color'  => 'desktop_submenu_background_color',
            'menu_item_underline_color' => 'desktop_menu_underline_color'
        )
    );
    

}