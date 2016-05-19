<?php
/*
Plugin Name: EasyTech Connect
Plugin URI: https://easytech.support.com/Connect
Description: The plugin is a way to make sure that the user agrees to the terms and rules of the website owner.
Version: 1.0
Author: developer
Author URI: https://www.upwork.com/freelancers/_~01c10e7a70568b27d3/
*/

class EasyTech {

    const OPTION_SETTINGS = 'et_settings';
    public function __construct()
    {
        add_action('init', array($this, 'et_bootstrap_init'));
        add_action('admin_enqueue_scripts', array($this, 'et_admin_enqueue_scripts'));
        add_action('admin_menu', array($this, 'et_add_submenus'));
        add_action('wp_ajax_et_get_settings', array($this, 'et_get_settings'));
        add_action('wp_ajax_et_save_settings', array($this, 'et_save_settings'));
        add_filter( 'page_template', array($this, 'et_override_page') );
    }

//    public function et_override_page($template)
//    {
//        global $post;
//        if ($post->post_type == 'page' && $post->ID == get_option(self::OPTION_MAIN_PAGE)) {
//            return plugin_dir_path( __FILE__ ) . 'templates/et-main-page.php';
//        }
//    }

    public function et_save_settings()
    {
        if (isset($_POST['et-settings'])) {
            if (update_option(self::OPTION_SETTINGS, $_POST['et-settings']) or add_option(self::OPTION_SETTINGS, $_POST['et-settings'])) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
        }
        die;
    }

    public function et_get_settings()
    {
        echo json_encode(array(
            'pages'     => get_pages() ,
            'settings'  => get_option(self::OPTION_SETTINGS)
        ));
        die;
    }

    public function et_admin_enqueue_scripts()
    {
        wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
        wp_enqueue_style('style.admin', plugins_url('/css/style.admin.css', __FILE__));
        wp_enqueue_script ('jquery');
        wp_enqueue_script ('angular', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js');
        wp_enqueue_script ('angular.aminate', 'https://code.angularjs.org/1.4.5/angular-animate.min.js', array('angular'));
        wp_enqueue_script ('angular.sanitize', 'https://code.angularjs.org/1.4.5/angular-sanitize.min.js', array('angular.aminate'));
        wp_enqueue_script ('angular.bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.2/ui-bootstrap.min.js', array('angular.sanitize'));
        wp_enqueue_script ('angular.tpls', 'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.2/ui-bootstrap-tpls.min.js', array('angular.bootstrap'));
        wp_enqueue_script ('admin.module', plugins_url('/js/admin/module.js', __FILE__), array('angular.tpls'), false, true);
        wp_enqueue_script ('admin.service', plugins_url('/js/admin/service.js', __FILE__), array('admin.module'), false, true);
        wp_enqueue_script ('admin.controller', plugins_url('/js/admin/controller.js', __FILE__), array('admin.service'), false, true);
        wp_localize_script('admin.controller', 'ajaxUrl', admin_url('admin-ajax.php'));
    }

    public function et_bootstrap_init()
    {
        // register ticket post type
        register_post_type('et_ticket', array(
            'labels' => array(
                'name' => 'Tickets',
                'singular_name' => 'Ticket',
                'add_new' => 'Add Ticket',
                'add_new_item' => 'Add new Ticket',
                'edit_item' => 'Edit Ticket',
                'new_item' => 'New Ticket',
                'view_item' => 'View Ticket',
                'search_items' => 'Search Ticket',
                'not_found' =>  'Ticket not found',
                'not_found_in_trash' => 'Ticket not found',
                'parent_item_colon' => '',
                'menu_name' => 'Tickets'
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'menu_icon' => 'dashicons-clipboard',
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'excerpt')
        ));
    }

    public function et_add_submenus()
    {
        add_submenu_page( 'edit.php?post_type=et_ticket', 'Settings', 'Settings', 'manage_options', 'et_settings', array($this, 'et_setting_callback'));
    }

    public function et_setting_callback()
    {
        require_once ('templates/et-settings.php');
    }

}
new EasyTech();