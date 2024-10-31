(function($) {
    $(document).ready(function() {
        URLInp = $('#active_campaign_url')
        URLInp.change(function() {
            console.log('changes');
            if (URLInp.val() != '') {
                campaingURLMessage = $('#url_message');
                if (!validURL(URLInp.val())) {
                    campaingURLMessage.html('Invalid URL');
                } else {
                    campaingURLMessage.html('');
                }
            }
        })
        $('#active_campaign_key').change(function() {
            if ($('#active_campaign_key').val() != '') {
                campaignKey_html = $('#acKeyMessge');
                if (campaignKey_html) {
                    campaignKey_html.html('');
                }
            }
        })
        $('#active_campaign_list_id').change(function() {
            if ($('#active_campaign_key').val() != '') {
                $('#list_idKeyMessge').html('');
            }
        })
        $('#active_campaign_first_name').change(function() {
            if ($('#first_name_message_token') && tokenValidation($('#active_campaign_first_name').val())) {
                $('#first_name_message_token').text('');
            } else if ($('#first_name_message_token') && $('#active_campaign_first_name').val()) {
                $('#first_name_message_token').text('Invalid Token');
            } else if (!$('#active_campaign_first_name').val()) {
                $('#first_name_message_token').text('');
            }
        });
        $('#active_campaign_last_name').change(function() {
            if ($('#last_name_message_token') && tokenValidation($('#active_campaign_last_name').val())) {
                $('#last_name_message_token').text('');
            } else if ($('#last_name_message_token') && $('#active_campaign_last_name').val()) {
                $('#last_name_message_token').text('Invalid Token');
            } else if (!$('#active_campaign_last_name').val()) {
                $('#last_name_message_token').text('');
            }
        });
        $('#active_campaign_email').change(function() {
            if ($('#email_message_token') && tokenValidation($('#active_campaign_email').val())) {
                $('#email_message_token').text('');
            } else if ($('#email_message_token') && $('#active_campaign_email').val()) {
                $('#email_message_token').text('Invalid Token');
            } else if ($('#email_message_token') && !$('#active_campaign_email').val()) {
                $('#email_message_token').text('Email is Required');
            }
        });
        $('#active_campaign_phone_number').change(function() {
            if ($('#phone_message_token') && tokenValidation($('#active_campaign_phone_number').val())) {
                $('#phone_message_token').text('');
            } else if ($('#phone_message_token') && $('#active_campaign_phone_number').val()) {
                $('#phone_message_token').text('Invalid Token');
            } else if (!$('#active_campaign_phone_number').val()) {
                $('#phone_message_token').text('');
            }
        });

        function validURL(str) {
            var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
            return pattern.test(str);
        }

        function tokenValidation(val) {
            if (!val) {
                return 0;
            }
            addTokens = [];
            foundInTokens = false;
            temObj = val.split('[');
            for (const item of temObj) {
                if (item.includes("]")) {
                    temp = item.split(']');
                    addTokens.push(temp[0]);
                }
            }
            const regex = new RegExp(/.*\[.+\].*/);
            validSantax = regex.test(val)
            if (addTokens) {
                suggestedTags = $('#suggestedTags').children('span.mailtag.code.used');
                findInString = suggestedTags.text();
                for (token of addTokens) {
                    foundInTokens = findInString.includes(token);
                    if (!foundInTokens) {
                        break;
                    }
                }
            }
            if (foundInTokens && validSantax) {
                return true;
            } else {
                return false;
            }
        }

        $(document).on('click', "#get_list", () => {
            activeCampaignKey = $('#active_campaign_key').val();
            activeCampaignURL = $('#active_campaign_url').val();
            if (activeCampaignKey && activeCampaignURL) {
                makeAjaxCall(activeCampaignKey, activeCampaignURL)
            } else if (activeCampaignKey) {
                $('#list_idKeyMessge').text('Url is required');
            } else if (activeCampaignURL) {
                $('#list_idKeyMessge').text('Key is required');
            } else {
                $('#list_idKeyMessge').text('URL & Key are required');
            }
        });

        function makeAjaxCall(activeCampaignKey, activeCampaignURL) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: sdac_ajax_obj.ajax_url,
                data: {
                    action: "sdtac_call_api",
                    nonce: sdac_ajax_obj.sdac_nonce,
                    active_campaign_key: activeCampaignKey,
                    active_campaign_url: activeCampaignURL,
                    post: sdac_ajax_obj.form_id
                },
                success: function(response) {
                    makeOptions(response);
                }
            });
        }

        function makeOptions(arg) {
            obj = JSON.parse(arg);
            if (obj.success && obj.success == 1) {
                $html = '<option value="">select</option>';
                Object.values(obj).forEach((value, index) => {
                    if (value.id) {
                        if (sdac_ajax_obj.selected_item != value.id) {
                            $html += `<option value="` + value.id + `" >` + value.name + `</option>   `
                        } else {
                            $html += `<option value="` + value.id + `" selected>` + value.name + `</option>   `
                        }
                    }
                    $('#active_campaign_list_id').html($html);
                    $('#list_idKeyMessge').text('');
                });
            } else if (obj.message) {
                $('#list_idKeyMessge').text(obj.message);
            }
        }
        //make an ajax call on page load.
        if ($('#active_campaign_key').val() && $('#active_campaign_url').val()) {
            makeAjaxCall($('#active_campaign_key').val(), $('#active_campaign_url').val())
        }
    });
})(jQuery);