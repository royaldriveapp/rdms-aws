<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>General Settings</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php echo form_open_multipart("settings/insert", array('id' => "frmSettings", 'class' => "form-horizontal form-label-left")) ?>
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                            <li role="presentation" class="active">
                                <a href="#tab_dar" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">DAR</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab_website" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Website</a>
                            </li>
                            <li role="presentation">
                                <a href="#general" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                            </li>
                            <li role="presentation">
                                <a href="#followup" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Folllow up</a>
                            </li>
                            <li role="presentation">
                                <a href="#sms-gateway" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">SMS Gateway</a>
                            </li>
                            <li role="presentation">
                                <a href="#app" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">APP
                                    Settings</a>
                            </li>
                            <li role="presentation">
                                <a href="#booking" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Booking</a>
                            </li>
                            <li role="presentation">
                                <a href="#cronejob" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Crone
                                    job</a>
                            </li>
                            <li role="presentation">
                                <a href="#ihits" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">iHits</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="ihits" aria-labelledby="iHits-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Financial year and
                                        code</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[iHits_fin_year_lx_sm_code]" id="mod_title" placeholder="Financial year (Eg:2024-25/{luxury code}-{Smat code})" value="<?php echo get_settings_by_key('iHits_fin_year_lx_sm_code'); ?>" />
                                        <i class="lbl-narration">Financial year (Eg:2024-25/{luxury code}-{Smat
                                            code})</i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sync ledgers</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a type="submit" target="_blank" href="<?php echo site_url('settings/pullExpence'); ?>" class="btn btn-success">Sync</a>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade active in" id="tab_dar" aria-labelledby="dar-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">DAR Closing Day</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[DAR_closing_day]" id="mod_title" placeholder="DAR Closing Day" value="<?php echo get_settings_by_key('DAR_closing_day'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">DAR Starting Hour</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 hourPicker" autocomplete="off" name="settings[DAR_starting_hour]" id="mod_title" placeholder="DAR Starting Hour" value="<?php echo get_settings_by_key('DAR_starting_hour'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">DAR Time Frame</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 hourPicker" autocomplete="off" name="settings[DAR_time_frame]" id="mod_title" placeholder="DAR Time Frame" value="<?php echo get_settings_by_key('DAR_time_frame'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_website" aria-labelledby="dar-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Quick contact mobile for
                                        vehicle</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[qck_contact_mobile]" id="mod_title" placeholder="Quick contact mobile for vehicle" value="<?php echo get_settings_by_key('qck_contact_mobile'); ?>" />
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Default loan AMT %</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off"
                                                         name="settings[emi_def_loan_amt_perce]" id="mod_title" placeholder="Default loan AMT %"
                                                         value="<?php //echo get_settings_by_key('emi_def_loan_amt_perce');
                                                                ?>"/>
                                             </div>
                                        </div>
                                        
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Default EMI %</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off"
                                                         name="settings[emi_def_perce]" id="mod_title" placeholder="Percentage of vehicle amount"
                                                         value="<?php //echo get_settings_by_key('emi_def_perce');
                                                                ?>"/>
                                             </div>
                                        </div>
                                        
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Default EMI Tenure (Year)</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off"
                                                         name="settings[emi_def_tenure]" id="mod_title" placeholder="Default EMI Tenure in Year"
                                                         value="<?php //echo get_settings_by_key('emi_def_tenure');
                                                                ?>"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">TCS Limit</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="decimalOnly form-control col-md-7 col-xs-12" autocomplete="off"
                                                         name="settings[tcs_limit]" id="mod_title" placeholder="TCS Limit"
                                                         value="<?php //echo get_settings_by_key('tcs_limit');
                                                                ?>"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">TCS</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="decimalOnly form-control col-md-7 col-xs-12" autocomplete="off"
                                                         name="settings[tcs_per]" id="mod_title" placeholder="TCS%"
                                                         value="<?php //echo get_settings_by_key('tcs_per');
                                                                ?>"/>
                                             </div>
                                        </div> -->
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="general" aria-labelledby="dar-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Settings</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Number of
                                                        items in list</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[pagination_limit]" id="mod_title" placeholder="Number of items in list" value="<?php echo get_settings_by_key('pagination_limit'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dashboard
                                                        news</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[dashboard_news]" id="mod_title" placeholder="Dashboard news"><?php echo get_settings_by_key('dashboard_news'); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Voxbay
                                                        Call Base</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[voxbay_call_baseurl]" value="<?php echo get_settings_by_key('voxbay_call_baseurl'); ?>" id="mod_title" placeholder="Voxbay call record base url" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Refurb maximum amount</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="number" class="form-control col-md-7 col-xs-12" autocomplete="off"
                                                            name="settings[refurb_max_amt]"
                                                            value="<?php echo get_settings_by_key('refurb_max_amt'); ?>"
                                                            id="mod_title" placeholder="Maximum amount allowed for refurb" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="followup" aria-labelledby="dar-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer feedback for
                                        missed followup</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[comn_foll_customer_feedback]" id="mod_title" placeholder="Customer feedback for missed followup" value="<?php echo get_settings_by_key('comn_foll_customer_feedback'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="sms-gateway" aria-labelledby="dar-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sender Id</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_sender_id]" id="mod_title" placeholder="Sender Id" value="<?php echo get_settings_by_key('sms_sender_id'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity ID</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_entity_id]" id="sms_entity_id" placeholder="Entity ID" value="<?php echo get_settings_by_key('sms_entity_id'); ?>" />
                                    </div>
                                </div>

                                <div class="form-group"><label class="control-label col-md-6 col-sm-3 col-xs-12">Transactional</label></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">API Key</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_trans_api_key]" id="sms_trans_api_key" placeholder="API Key" value="<?php echo get_settings_by_key('sms_trans_api_key'); ?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Client Id</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_trans_clnt_id]" id="sms_trans_clnt_id" placeholder="Client Id" value="<?php echo get_settings_by_key('sms_trans_clnt_id'); ?>" />
                                    </div>
                                </div>

                                <div class="form-group"><label class="control-label col-md-6 col-sm-3 col-xs-12">OTP</label></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">API Key</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_otp_api_key]" id="sms_otp_api_key" placeholder="API Key" value="<?php echo get_settings_by_key('sms_otp_api_key'); ?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Client Id</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_otp_clnt_id]" id="sms_otp_clnt_id" placeholder="Client Id" value="<?php echo get_settings_by_key('sms_otp_clnt_id'); ?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_username]" id="mod_title" placeholder="Username" value="<?php echo get_settings_by_key('sms_username'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[sms_password]" id="mod_title" placeholder="Password" value="<?php echo get_settings_by_key('sms_password'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="app" aria-labelledby="dar-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">APP android version</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[app_android_version]" id="mod_title" placeholder="APP android version" value="<?php echo get_settings_by_key('app_android_version'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">APP IOS version</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[app_ios_version]" id="mod_title" placeholder="APP IOS version" value="<?php echo get_settings_by_key('app_ios_version'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">IOS APP link
                                        (itunes)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[app_ios_link]" id="mod_title" placeholder="IOS APP link" value="<?php echo get_settings_by_key('app_ios_link'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">IOS APP link (app
                                        store)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[app_ios_link_app_store]" id="mod_title" placeholder="IOS APP link" value="<?php echo get_settings_by_key('app_ios_link_app_store'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Android APP link</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[app_android_link]" id="mod_title" placeholder="Android APP link" value="<?php echo get_settings_by_key('app_android_link'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">App SMS Signature</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[app_sms_signature]" id="mod_title" placeholder="App SMS Signature" value="<?php echo get_settings_by_key('app_sms_signature'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="booking" aria-labelledby="dar-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Default loan AMT %</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[emi_def_loan_amt_perce]" id="mod_title" placeholder="Default loan AMT %" value="<?php echo get_settings_by_key('emi_def_loan_amt_perce'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Default EMI %</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[emi_def_perce]" id="mod_title" placeholder="Percentage of vehicle amount" value="<?php echo get_settings_by_key('emi_def_perce'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Default EMI Tenure
                                        (Year)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off" name="settings[emi_def_tenure]" id="mod_title" placeholder="Default EMI Tenure in Year" value="<?php echo get_settings_by_key('emi_def_tenure'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">TCS Limit</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="decimalOnly form-control col-md-7 col-xs-12" autocomplete="off" name="settings[tcs_limit]" id="mod_title" placeholder="TCS Limit" value="<?php echo get_settings_by_key('tcs_limit'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">TCS</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="decimalOnly form-control col-md-7 col-xs-12" autocomplete="off" name="settings[tcs_per]" id="mod_title" placeholder="TCS%" value="<?php echo get_settings_by_key('tcs_per'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking open if not
                                        document submitted</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="numOnly form-control col-md-7 col-xs-12" autocomplete="off" name="settings[no_days_bk_opn_doc_submtd]" id="mod_title" placeholder="Booking open if not document submitted" value="<?php echo get_settings_by_key('no_days_bk_opn_doc_submtd'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Booking open if not loan
                                        submitted</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="numOnly form-control col-md-7 col-xs-12" autocomplete="off" name="settings[no_days_bk_loan_submtd]" id="mod_title" placeholder="Booking open if not loan submitted" value="<?php echo get_settings_by_key('no_days_bk_loan_submtd'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Show discount on
                                        sales ? </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        Yes <input type="radio" name="settings[show_bl_on_sales]" value="1" <?php echo (get_settings_by_key('show_bl_on_sales') == 1) ? 'checked' : ''; ?> />
                                        No <input type="radio" name="settings[show_bl_on_sales]" value="0" <?php echo (get_settings_by_key('show_bl_on_sales') == 0) ? 'checked' : ''; ?> />
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="cronejob" aria-labelledby="dar-tab">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Prepare sitemap
                                        (Luxury)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://royaldrive.in/crone/preparesitemap" class="btn btn-success">Action</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .lbl-narration {
        font-size: 11px;
        font-weight: bold;
    }
</style>