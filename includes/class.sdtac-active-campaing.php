<?php

/**
 * data is featched form active campaign in this file
 */
class SDTAC_Active_Campaing
{

    public function __construct()
    {
    }
    function get_lists()
    {

        if (isset($_POST["post"])) {

            if (is_int((int)sanitize_key($_POST["post"]))  && (int)sanitize_key($_POST["post"]) !=0) {
                $this->url_for_active_campain = sanitize_url($_POST["active_campaign_url"]);
                $this->key_for_active_campain = sanitize_text_field($_POST["active_campaign_key"]);
            }
            if ($this->url_for_active_campain && $this->key_for_active_campain) {

                $this->ac = new ActiveCampaign($this->url_for_active_campain, $this->key_for_active_campain);

                if ((int)$this->ac->credentials_test()) {

                    $this->lists = $this->ac->api("list/list?ids=all");
                    return $this->lists;

                }
                else {
                    return array('message'=>'Invalid Credentials');
                }
            }
        }
        return null;
    }
    function mail_sent_cb($contact_form)
    {
        $submited_form_id = $contact_form->id;
        $title = $contact_form->title;
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $posted_data = $submission->get_posted_data();
        }

        $API_URL = get_post_meta($submited_form_id, 'active_campaign_url', true) ?? '';
        $API_KEY = get_post_meta($submited_form_id, 'active_campaign_key', true) ?? '';
        $list_id = get_post_meta($submited_form_id, 'active_campaign_list_id', true) ?? '';
        $this->tags = get_post_meta($submited_form_id, 'active_campaign_tag', true) ?? '';
        $formNameArray = [];
        $formNameArray["first_name"] = get_post_meta($submited_form_id, 'active_campaign_first_name', true) ?? '';
        $formNameArray['last_name'] = get_post_meta($submited_form_id, 'active_campaign_last_name', true) ?? '';
        $formNameArray['email'] = get_post_meta($submited_form_id, 'active_campaign_list_email', true) ?? '';
        $formNameArray['phone_number'] = get_post_meta($submited_form_id, 'active_campaign_list_phone_number', true) ?? '';
        foreach ($formNameArray as $key => $value) {
            $valuesub = explode('[', $value);
            $tempArray = [];
            foreach ($valuesub as $keysub => $valuesub) {
                if ((preg_match('/[\]]/', $valuesub))) {
                    $valuesub = substr($valuesub, 0, strrpos($valuesub, ']'));
                    array_push($tempArray, $valuesub);


                }
                $formNameArray[$key] = $tempArray;
            }
        }


        if ($API_URL != '' && $API_KEY != '' && $list_id != '') {

            $this->ac = new ActiveCampaign($API_URL, $API_KEY);
            if ((int)$this->ac->credentials_test()) {
                // $this->account = $this->ac->api("account/view");
                $firstName = '';
                $lastName = '';
                foreach ($formNameArray["first_name"] as $value) {
                    if (isset($posted_data[$value])) {
                        $firstName .= strtolower($posted_data[$value]) . " ";
                    }
                }
                foreach ($formNameArray["last_name"] as $value) {
                    if (isset($posted_data[$value])) {
                        $lastName .= strtolower($posted_data[$value]) . " ";
                    }
                }
                if (isset($posted_data[$formNameArray["email"][0]])) {
                    $email = strtolower($posted_data[$formNameArray['email'][0]]);
                }
                if (isset($posted_data[$formNameArray["phone_number"][0]])) {
                    $phone = strtolower($posted_data[$formNameArray['phone_number'][0]]);
                }
                $contact = array(
                    "email" => $email,
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "phone" => $phone,
                    "p[{$list_id}]" => $list_id,
                    "status[{$list_id}]" => 1, // "Active" status
                );
                $contact_sync = $this->ac->api("contact/sync", $contact);
                $contactTag = array(
                    "contact" => $contact_sync,
                    "tag" => "tagtesting"
                );
                $contactTag = array(
                    "tags" => $this->tags,
                    "email" => $email
                );
                $this->ac->api("contact/tag/add", $contactTag);
            }
        }


    }

}