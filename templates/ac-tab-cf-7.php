<form action="" method="post">
            <table class="form-table">
                <tbody>
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_url">Active Campaign Url*</label>
                        </th>
                        <td>
                            <input type="text" name="active_campaign_url" style="width: 50%;" id="active_campaign_url" placeholder="Active Campaign Url" value="<?php echo esc_html(get_post_meta($post_id_for_current_form, 'active_campaign_url', true)); ?>">
                            <span style="color:#d60000;" id="url_message">
                                <?php
                                    $url = get_post_meta($post_id_for_current_form, 'active_campaign_url', true);
                                    if (($url) && !(filter_var($url, FILTER_VALIDATE_URL))) { ?>
                                        Invalid URL
                                        <?php
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_key">Active Campaign Key*</label>
                        </th>
                        <td>
                            <input type="password" name="active_campaign_key" style="width: 50%;" id="active_campaign_key" placeholder="Active Campaign Key" value="<?php echo esc_html(get_post_meta($post_id_for_current_form, 'active_campaign_key', true)); ?>">
                            <?php $key_listt = get_post_meta($post_id_for_current_form, 'active_campaign_key', true); ?>
                        <span style="color:#d60000;" id='acKeyMessge'></span>
                        </td>
                    </tr>
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_tag">Active Campaign Tag</label>
                        </th>
                        <td>
                            <input type="text" name="active_campaign_tag" style="width: 50%;" id="active_campaign_tag" placeholder="Active Campaign tag" value="<?php echo esc_html(get_post_meta($post_id_for_current_form, 'active_campaign_tag', true)); ?>">
                        </td>
                    </tr>
                    
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_list_id">Active Campaign List*</label>
                        </th>
                        <td>
                            <select name="active_campaign_list_id" id="active_campaign_list_id" style="width: 50%;">
                                <option value=""  select>select</option>
                            </select>
                            <span style="color:#ffa31a;" id='list_idKeyMessge'></span>
                            <span id="get_list" class="button" >
                                <span class="dashicons dashicons-controls-repeat" style="margin:4px auto;user-select: none;"></span>
                            </span>
                        </td>
                    </tr>
                           
                    <tr scope="row" >
                        <th></th>
                        <td id="suggestedTags">
                            <span>Tokens: </span><?php
                            $WPCF7_ContactForm = WPCF7_ContactForm::get_instance($post_id_for_current_form);
                            $WPCF7_ContactForm->suggest_mail_tags(); ?>
                        </td>
                    </tr>
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_first_name">First Name</label>
                        </th>
                        <td>
                            <input type="text" name="active_campaign_first_name" style="width: 50%;" id="active_campaign_first_name" placeholder="first name" value="<?php echo esc_html(get_post_meta($post_id_for_current_form, 'active_campaign_first_name', true)); ?>">
                            <?php $firstName = get_post_meta($post_id_for_current_form, 'active_campaign_first_name', true); ?>
                            <span style="color:#d60000;" id='first_name_message_token'>
                            <?php
                            if ($firstName && !preg_match("/.*\[.+\].*/", $firstName)) {
                                echo "Invalid Token";
                            }?>
                        </span>
                        </td>
                    </tr>
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_last_name">Last Name</label>
                        </th>
                        <td>
                            <input type="text" name="active_campaign_last_name" style="width: 50%;" id="active_campaign_last_name" placeholder="last name " value="<?php echo esc_html(get_post_meta($post_id_for_current_form, 'active_campaign_last_name', true)); ?>">
                            <span style="color:#d60000;" id='last_name_message_token'>
                            <?php $lastName = get_post_meta($post_id_for_current_form, 'active_campaign_last_name', true);
                            if ($lastName && !preg_match("/.*\[.+\].*/", $lastName)) {
                                echo "Invalid Token";
                            }?>
                        </span>
                        </td>
                    </tr>
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_email">Email*</label>
                        </th>
                        <td>
                            <input type="text" name="active_campaign_email" style="width: 50%;" id="active_campaign_email" placeholder="email " value="<?php echo esc_html(get_post_meta($post_id_for_current_form, 'active_campaign_list_email', true)); ?>">
                            <span style="color:#d60000;" id='email_message_token'>
                            <?php $email = get_post_meta($post_id_for_current_form, 'active_campaign_list_email', true);
if ($email && !preg_match("/.*\[.+\].*/", $email)) {
    echo "Invalid Token";
}?>
                        
                        <?php
if (get_post_meta($post_id_for_current_form, 'active_campaign_list_id', true) && !$email && $lists) {
    echo "Email is Required";
}?>
                        </span>
                        </td>
                    </tr>
                    <tr scope="row" >
                        <th style="width: 20%;">
                            <label for="active_campaign_phone_number">Phone Number</label>
                        </th>
                        <td>
                            <input type="text" name="active_campaign_phone_number" style="width: 50%;" id="active_campaign_phone_number" placeholder="phone number tag" value="<?php echo esc_html(get_post_meta($post_id_for_current_form, 'active_campaign_list_phone_number', true)); ?>">
                            <span style="color:#d60000;" id='phone_message_token'>
                            <?php $phone = get_post_meta($post_id_for_current_form, 'active_campaign_list_phone_number', true);
if ($phone && !preg_match("/.*\[.+\].*/", $phone)) {
    echo "Invalid Token";
}?>
                        </span>
                        </td>
                    </tr>
                </tbody>
            </table>            
        </form>
        