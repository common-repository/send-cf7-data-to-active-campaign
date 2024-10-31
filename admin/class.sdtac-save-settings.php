<?php
/**
 * settings saved
 */
class SDTAC_Save_Settings
{

    public function __construct()
    {
        $this->save_setting_to_form_meta();
    }
    function save_setting_to_form_meta()
    {
        if ($_POST['action'] != 'save') {
            return;
        }
        $post_id_for_current_form = isset($_POST["post_ID"]) ? (int)sanitize_text_field($_POST["post_ID"]) : '';
        $url_value = isset($_POST['active_campaign_url']) ? sanitize_text_field($_POST['active_campaign_url']) : '';
        $key_value = isset($_POST['active_campaign_key']) ? sanitize_text_field($_POST['active_campaign_key']) : '';
        $tag_value = isset($_POST['active_campaign_tag']) ? sanitize_text_field($_POST['active_campaign_tag']) : '';
        $list_id_value = isset($_POST['active_campaign_list_id']) ? sanitize_text_field($_POST['active_campaign_list_id']) : '';
        $first_name = isset($_POST['active_campaign_first_name']) ? sanitize_text_field($_POST['active_campaign_first_name']) : '';
        $last_name = isset($_POST['active_campaign_last_name']) ? sanitize_text_field($_POST['active_campaign_last_name']) : '';
        $email = isset($_POST['active_campaign_email']) ? sanitize_text_field($_POST['active_campaign_email']) : '';
        $phone_number = isset($_POST['active_campaign_phone_number']) ? sanitize_text_field($_POST['active_campaign_phone_number']) : '';
        if (is_int($post_id_for_current_form) && $post_id_for_current_form !=0) {


            update_post_meta($post_id_for_current_form, "active_campaign_url", esc_sql($url_value));

            update_post_meta($post_id_for_current_form, "active_campaign_key", esc_sql($key_value));

            update_post_meta($post_id_for_current_form, "active_campaign_list_id", esc_sql($list_id_value));

            update_post_meta($post_id_for_current_form, "active_campaign_tag", esc_sql($tag_value));

            update_post_meta($post_id_for_current_form, "active_campaign_first_name", esc_sql($first_name));

            update_post_meta($post_id_for_current_form, "active_campaign_last_name", esc_sql($last_name));

            update_post_meta($post_id_for_current_form, "active_campaign_list_email", esc_sql($email));

            update_post_meta($post_id_for_current_form, "active_campaign_list_phone_number", esc_sql($phone_number));

        }


    }
}