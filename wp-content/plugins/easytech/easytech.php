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

    const OPTION_STEPS = 'et_steps';
    const OPTION_MAIN_PAGE = 'et_main_page';
    public function __construct()
    {
        add_action('init', array($this, 'et_bootstrap_init'));
        add_action('admin_enqueue_scripts', array($this, 'et_admin_enqueue_scripts'));
        add_action('admin_menu', array($this, 'et_add_submenus'));
        add_action('wp_ajax_et_add_save_step_settings', array($this, 'et_add_save_step_settings'));
        add_action('wp_ajax_et_get_settings', array($this, 'et_get_settings'));
        add_action('wp_ajax_et_get_pages', array($this, 'et_get_pages'));
        add_action('wp_ajax_et_get_main_page', array($this, 'et_get_main_page'));
        add_action('wp_ajax_et_set_main_page', array($this, 'et_set_main_page'));
        add_filter( 'page_template', array($this, 'et_override_page') );
    }

    public function et_add_save_step_settings()
    {
        if (isset($_POST['stepsSettings']) && $_POST['stepsSettings'] !== 'false') {
            if (update_option(self::OPTION_STEPS, $_POST['stepsSettings']) or add_option(self::OPTION_STEPS, $_POST['stepsSettings'])) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
        } else {
            delete_option(self::OPTION_STEPS);
        }
        die;
    }

    public function et_override_page($template)
    {
        global $post;
        if ($post->post_type == 'page' && $post->ID == get_option(self::OPTION_MAIN_PAGE)) {
            return plugin_dir_path( __FILE__ ) . 'templates/et-page.php';
        }
    }

    public function et_set_main_page()
    {
        if (isset($_POST['pageSettings'])) {
            if (update_option(self::OPTION_MAIN_PAGE, $_POST['pageSettings']) or add_option(self::OPTION_MAIN_PAGE, $_POST['pageSettings'])) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
        }
        die;
    }

    public function et_get_settings()
    {
        echo json_encode(get_option(self::OPTION_STEPS));
        die;
    }

    public function et_get_main_page()
    {
        delete_option(self::OPTION_MAIN_PAGE);
//        $T = get_option(self::OPTION_MAIN_PAGE);
        echo json_encode(get_option(self::OPTION_MAIN_PAGE));
        die;
    }

    public function et_get_pages()
    {
        echo json_encode(get_pages());
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
        wp_enqueue_script ('script.admin', plugins_url('/js/admin.js', __FILE__), array('angular.tpls'), false, true);
        wp_localize_script('script.admin', 'ajaxUrl', admin_url('admin-ajax.php'));
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
        require_once ('templates/settings.php');
    }

}
new EasyTech();