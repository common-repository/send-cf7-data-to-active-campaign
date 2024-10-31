<?php

require_once(CF7_DATA_TO_AC_PATH . "includes/class.sdtac-active-campaing.php");
require_once(CF7_DATA_TO_AC_PATH . "vendor/autoload.php");
if (is_admin()) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    require_once(CF7_DATA_TO_AC_PATH . "includes/class.sdtac-installer.php");
    require_once(CF7_DATA_TO_AC_PATH . "admin/class.sdtac-render-tab.php");
    require_once(CF7_DATA_TO_AC_PATH . "admin/class.sdtac-save-settings.php");
}

/**
 * check for contact form 7 activation.
 */

class CF7_To_AC
{
    /**
     * constructor
     */
    function __construct()
    {
        $this->setup();
    }
    function setup()
    {
        register_activation_hook(__FILE__, array($this, 'sdtac__activate_plugin'));
        add_action('init', array($this, 'register_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wpcf7_mail_sent', array($this, 'mail_sent_cb'), 10, 1);
        add_filter('wpcf7_editor_panels', array($this, 'append_tab_at_cfs_menu'), 10, 1);
        add_filter('plugin_action_links', array($this, 'settingPagelink'), 10, 2); //setting option in plugin with active/deactivate campaign.
        add_action('wpcf7_after_save', array($this, "fetch_active_campaign_data"));
        add_action('wp_ajax_sdtac_call_api', array($this, "sdtac_call_api_cb"));
    }
    function sdtac_call_api_cb()
    {
        
        if(isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], "sdac_nonce")){
            wp_send_json('');
            wp_die();
        }
        
        $feattch = new SDTAC_Active_Campaing();
        $respo = $feattch->get_lists();
        wp_send_json(json_encode($respo));
        wp_die();
    
    }
    public function sdtac__activate_plugin()
    {
        $activePlugin = new InitializePlugin();
        $activePlugin->wpcf7__activecampaign_plugin_activate();
    }
    public function register_scripts()
    {
        wp_register_script("sdac-script", CF7_DATA_TO_AC_URL . "admin/js/admin-script.js");
    }
    function enqueue_scripts()
    {
        $page_slug = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        $post_id = isset($_GET['post']) ? (int)sanitize_text_field($_GET['post']) : '';
        if ($page_slug == 'wpcf7' && $post_id && is_int($post_id) && $post_id != 0) {
            wp_localize_script('sdac-script', "sdac_ajax_obj", array('ajax_url' => admin_url('admin-ajax.php'), 'sdac_nonce' => wp_create_nonce("sdac_nonce"), 'form_id' => (int)sanitize_key($_GET["post"]), "selected_item" => get_post_meta((int)sanitize_key($_GET['post']), 'active_campaign_list_id', true)));
            wp_enqueue_script("sdac-script");
        }
    }
    public function mail_sent_cb($data)
    {
        $send_data_obj = new SDTAC_Active_Campaing();
        $send_data_obj->mail_sent_cb($data);
    }
    public function append_tab_at_cfs_menu($panels)
    {
        $panels['preview-panel'] = array(
            'title' => __('Active Campaign', 'contact-form-7'),
            'callback' => array($this, 'render_tab_html')
        );
        return $panels;
    }

    public function render_tab_html()
    {
        $obj_tab = new SDTAC_Render_Tab();
        $obj_tab->wpcf7_editor_panel_activecampaign();
    }
    function settingPagelink($links, $file)
    {

        if ($file == plugin_basename(SEND_DATA_TO_AC_ROOT)) {
            /*
             * Insert the link at the beginning
             */
            // check for plugin using plugin name     
            if (in_array('Add-Contact-To-Active-Campaign/CF7-Contact-To-Active-Campaign.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                $in = '<a href="admin.php?page=wpcf7">' . __('Settings', 'mtt') . '</a>';
                array_unshift($links, $in);
            }
        }
        return $links;
    }
    function fetch_active_campaign_data()
    {
        $save = new SDTAC_Save_Settings();
        $save->save_setting_to_form_meta();
    }
    function sdtac_prerequisite()
    {

        function_exists('deactivate_plugins');

        if (!(in_array('contact-form-7/wp-contact-form-7.php', apply_filters('active_plugins', get_option('active_plugins'))))) {
            if (function_exists('deactivate_plugins')) {
                deactivate_plugins(CF7_DATA_TO_AC_BASE);
            }
            //remove activation notice form admin.
            if (isset($_GET['activate'])) {
                unset($_GET['activate']);
            }

            //show notice
            function sample_admin_notice__error()
            {
                $class = 'notice notice-error is-dismissible text-danger';
                $message = __('Contact form 7 is required For Add contact to Active Campaign.', 'cft-to-ac');
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
            }
            add_action('admin_notices', 'sample_admin_notice__error');

        }
    }



}
$preRequest = new CF7_To_AC();
$preRequest->sdtac_prerequisite();
?>