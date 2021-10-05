<?php

require_once WEBIGO_PLUGIN_PATH . 'includes/abstract-class-webigo-module.php';

/**
* {@inheritdoc}
*/
class Webigo_Header_Menu extends Webigo_Module
{

	protected $name;

	private $style_version;

	private $js_version;

	public function __construct()
	{
		$this->name          = Webigo_Header_Menu_Settings::MODULE_NAME;
		$this->style_version = Webigo_Header_Menu_Settings::CSS_VERSION;
		$this->js_version    = Webigo_Header_Menu_Settings::JS_VERSION;

		parent::__construct();
		$this->load_dependencies();
		$this->add_shortcodes();
	}

	public function load_dependencies()
	{

		require_once WEBIGO_PLUGIN_PATH . '/modules/header-menu/includes/class-webigo-header-menu-shortcode.php';

	}

	public function module()
	{

		return $this->name;
	}


	public function add_style()
	{
		$style_data = array(
			'module'       => $this->name,
			'file_name'    => 'header-menu.css',
			'dependencies' => array('core'),
			'version'	   => $this->style_version,
		);

		$this->style->register_public_style($style_data);

	}

	public function add_script()
	{

		$script_data = array(
			'module'       => $this->name,
			'file_name'    => 'header-menu.js',
			'dependencies' => array('core'),
			'version'	   => $this->js_version,
			'in_footer'    => true
		);

		$this->script->register_public_script( $script_data );
	}

	public function add_hooks()
	{
        
	}

	private function add_shortcodes()
	{

		new Webigo_Header_Menu_Shortcode();
	}

}
