<?php


class Webigo_View_Header_Menu_Shortcode
{


    public function __construct()
    {
        $this->load_dependencies();
    }

    private function load_dependencies(): void
    {

        require_once WEBIGO_PLUGIN_PATH . '/modules/header-menu/includes/class-webigo-header-menu-categories.php';
        $this->categories_handler = new Webigo_Header_Menu_Categories();

        require_once WEBIGO_PLUGIN_PATH . '/modules/core/includes/class-webigo-pod-custom-settings-page.php';
        $this->theme_editor = new Webigo_Pod_Custom_Settings_Page( Webigo_Header_Menu_Settings::POD_CUSTOM_SETTINGS_PAGE['pod_name'] );
    }

    public function render(): void
    {
        $categories = $this->categories_handler->first_level_categories();
        $level = 1;

        $navstyle = json_encode(
            array(
                'breakpoints'      => Webigo_Header_Menu_Settings::POD_CUSTOM_SETTINGS_PAGE['mobile']['breakpoints'],
                'backgroundColor'  => $this->theme_editor->value_of( Webigo_Header_Menu_Settings::POD_CUSTOM_SETTINGS_PAGE['mobile']['background_color'] ),
                'color'            => $this->theme_editor->value_of( Webigo_Header_Menu_Settings::POD_CUSTOM_SETTINGS_PAGE['mobile']['font_color'] ),
            )
        );
?>

        <nav class="wbg-nav-menu" data-visibility="visible">
            <?php $this->render_hamburger(); ?>    
            <div class="wbg-nav-menu-content" data-visibility="visible" data-style="<?php echo esc_attr($navstyle) ?>">
                <?php $this->render_mobile_menu_toggle(); ?>
                <?php $this->render_hierarchy($categories, $level); ?>
            </div>
        </nav>

    <?php
    }

    private function render_hierarchy($categories, $level)
    {

        $visibility = $level === 1 ? 'visible' : 'hidden';

        $navstyle = json_encode(
            array(
                'breakpoints'      => Webigo_Header_Menu_Settings::POD_CUSTOM_SETTINGS_PAGE['desktop']['breakpoints'],
                'backgroundColor'  => $this->theme_editor->value_of( Webigo_Header_Menu_Settings::POD_CUSTOM_SETTINGS_PAGE['desktop']['submenu_background_color'] ),
            )
        );

    ?>
        <ul class="wbg-nav-items" data-visibility="<?php echo esc_attr($visibility); ?>" data-nav-level="<?php echo esc_attr($level) ?>" data-style="<?php echo $level === 2 ?  esc_attr($navstyle) : '' ?>">

            <?php foreach ($categories as $category) : ?>
                <li class="wbg-nav-item" data-category-id="<?php echo $category['id'] ?>">
                    <?php

                    $has_children = $this->categories_handler->has_children( $category['id'] );

                    $this->render_category( $category, $has_children );

                    if ( $has_children ) {
                        $next_level = $level + 1;
                        $children = $this->categories_handler->children($category['id']);
                        $this->render_hierarchy($children, $next_level);
                    }
                    ?>
                </li>
            <?php endforeach; ?>

        </ul>

    <?php
    }

    /*
    private function render_category_all( $category, $level )
    {
        $has_children = $this->categories_handler->has_children( $category['id'] );

        if ($has_children && $level > 1) : ?>
            <li class="wbg-nav-item">
                <a href="<?php echo esc_url($category['link']) ?>">
                    <span class="wbg-nav-item-label">Todos <?php echo esc_html($category['name']) ?></span>
                </a>
            </li>
        <?php endif;
   
    }
    */


    private function render_category( $category, $has_children )
    {

        ?>
        <div class="wbg-nav-item-wrapper">
            <?php
            $this->render_link_label( $category );

            if ( $has_children ) {
                $this->render_nav_item_toggle();
            }
            ?>
        </div>
        <?php
    }

    private function render_link_label( $category )
    {
        ?>
            <a href="<?php echo esc_url($category['link']) ?>">
                <?php $this->render_label( $category ) ?>
            </a>
        <?php
    }

    private function render_label( $category ) 
    {
        ?>
            <span class="wbg-nav-item-label"><?php echo esc_html($category['name']) ?></span>
        <?php
    }


    private function render_nav_item_toggle()
    {
        ?>
            <div class="wbg-nav-item-toggle">
                <i class="fas fa-chevron-right"></i>
            </div>
        <?php
    }


    private function render_mobile_menu_toggle()
    {
    ?>

        <div class="wbg-nav-toggle" data-visibility="hidden">
            <i class="fas fa-times"></i>
        </div>

<?php
    }

    private function render_hamburger()
    {
        ?>

        <div class="wbg-nav-hamburger" data-visibility="hidden">
            <i class="fas fa-bars"></i>
        </div>

<?php
    }
}
