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
                         <?php echo form_open_multipart("settings/insert", array('id' => "frmSettings", 'class' => "form-horizontal form-label-left"))?>
                         <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                                   <li role="presentation" class="active">
                                        <a href="#tab_dar" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">DAR</a>
                                   </li>
                                   <li role="presentation">
                                        <a href="#tab_website" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Website</a>
                                   </li>
                              </ul>
                              <div id="myTabContent" class="tab-content">
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_dar" aria-labelledby="dar-tab">
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">DAR Closing Day</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off"
                                                         name="settings[DAR_closing_day]" id="mod_title" placeholder="DAR Closing Day"
                                                         value="<?php echo get_settings_by_key('DAR_closing_day');?>"/>
                                             </div>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">DAR Starting Hour</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 hourPicker" autocomplete="off"
                                                         name="settings[DAR_starting_hour]" id="mod_title" placeholder="DAR Starting Hour"
                                                         value="<?php echo get_settings_by_key('DAR_starting_hour');?>"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">DAR Time Frame</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 hourPicker" autocomplete="off"
                                                         name="settings[DAR_time_frame]" id="mod_title" placeholder="DAR Time Frame"
                                                         value="<?php echo get_settings_by_key('DAR_time_frame');?>"/>
                                             </div>
                                        </div>
                                   </div>
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_website" aria-labelledby="dar-tab">
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Quick contact mobile for vehicle</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" autocomplete="off"
                                                         name="settings[qck_contact_mobile]" id="mod_title" placeholder="Quick contact mobile for vehicle"
                                                         value="<?php echo get_settings_by_key('qck_contact_mobile');?>"/>
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
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
</div>