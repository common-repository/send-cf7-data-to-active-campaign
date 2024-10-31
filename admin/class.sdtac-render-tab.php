<?php

/**
 * create tab in in contact form menu page
 */
class SDTAC_Render_Tab
{

    public function __construct()
    {
        $this->post_id_for_current_form = (int)sanitize_key($_GET["post"]);
        if (is_int($this->post_id_for_current_form) && $this->post_id_for_current_form !=0) {
            $this->url_for_active_campain = get_post_meta($this->post_id_for_current_form, 'active_campaign_url', true);
            $this->key_for_active_campain = get_post_meta($this->post_id_for_current_form, 'active_campaign_key', true);
        }
        if ($this->url_for_active_campain && $this->key_for_active_campain) {

            $this->ac = new ActiveCampaign($this->url_for_active_campain, $this->key_for_active_campain);
        }
    }

    function wpcf7_editor_panel_activecampaign()
    {
        $post_id_for_current_form = (int)sanitize_key($_GET["post"]);
        $objects = new SDTAC_Active_Campaing();
        $lists = $objects->lists;
        require_once(CF7_DATA_TO_AC_PATH . 'templates/ac-tab-cf-7.php');
    }
}
