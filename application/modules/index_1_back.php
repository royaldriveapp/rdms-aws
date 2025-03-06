<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Add New Employee</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <div class="tabbable portlet-tabs">
                              <ul class="nav nav-tabs pull-left">
                                   <li><a href="#smtp_settings" data-toggle="tab">SMTP</a></li>
                                   <li><a href="#backend_settings" data-toggle="tab">Backend Settings</a></li>
                                   <li class="active"><a href="#frontend_settings" data-toggle="tab">Frontend Settings</a></li>
                              </ul>
                              <div class="clearfix"></div>
                              <div class="tab-content">
                                   <div class="tab-pane" id="smtp_settings">
                                        <div class="widget-body">
                                             <?php echo form_open_multipart("settings/insert", array('id' => "frmSettings", 'class' => "form-horizontal"))?>
                                             <div class="control-group">
                                                  <label class="control-label">SMTP HOST</label>
                                                  <div class="controls">
                                                       <input value="<?php echo get_settings_by_key('smtp_host');?>" type="text" placeholder="Host" class="input-xxlarge" name="settings[smtp_host]" />
                                                  </div>
                                             </div>
                                             <div class="control-group">
                                                  <label class="control-label">SMTP PORT</label>
                                                  <div class="controls">
                                                       <input value="<?php echo get_settings_by_key('smtp_post');?>" type="text" placeholder="Port" class="input-xxlarge" name="settings[smtp_post]" />
                                                  </div>
                                             </div>
                                             <div class="control-group">
                                                  <label class="control-label">SMTP USER</label>
                                                  <div class="controls">
                                                       <input value="<?php echo get_settings_by_key('smtp_user');?>" type="text" placeholder="User" class="input-xxlarge" name="settings[smtp_user]" />
                                                  </div>
                                             </div>
                                             <div class="control-group">
                                                  <label class="control-label">SMTP PASS</label>
                                                  <div class="controls">
                                                       <input value="<?php echo get_settings_by_key('smtp_pass');?>" type="text" placeholder="Password" class="input-xxlarge" name="settings[smtp_pass]" />
                                                  </div>
                                             </div>
                                             <div class="form-actions">
                                                  <input type="submit" class="btn blue"/>
                                                  <button type="button" class="btn"><i class=" icon-remove"></i> Cancel</button>
                                             </div>
                                             <?php echo form_close()?>
                                        </div>
                                   </div>
                                   <div class="tab-pane active" id="frontend_settings">
                                        <div class="widget-body">
                                             <?php echo form_open_multipart("settings/insert", array('id' => "frmSettings", 'class' => "form-horizontal"))?>
                                             <div class="control-group">
                                                  <label class="control-label">Site Url</label>
                                                  <div class="controls">
                                                       <input value="<?php echo get_settings_by_key('site_url');?>" type="text" placeholder="Site Url" class="input-xxlarge" name="settings[site_url]" />
                                                  </div>
                                             </div>
                                             <div class="form-actions">
                                                  <input type="submit" class="btn blue"/>
                                                  <button type="button" class="btn"><i class=" icon-remove"></i> Cancel</button>
                                             </div>
                                             <?php echo form_close()?>
                                        </div>
                                   </div>
                                   <div class="tab-pane" id="backend_settings">
                                        <div class="widget-body">
                                             <?php echo form_open_multipart("settings/insert", array('id' => "frmSettings", 'class' => "form-horizontal"))?>
                                             <div class="control-group">
                                                  <label class="control-label">Site Name</label>
                                                  <div class="controls">
                                                       <input value="<?php echo get_settings_by_key('site_name');?>" type="text" placeholder="Site Name" class="input-xxlarge" name="settings[site_name]" />
                                                  </div>
                                             </div>
                                             <div class="control-group">
                                                  <label class="control-label">Dashboard Content</label>
                                                  <div class="controls">
                                                       <textarea  placeholder="Dashboard Content" class="input-xxlarge editor" name="settings[dashboard_content]"><?php echo get_settings_by_key('dashboard_content');?></textarea>
                                                  </div>
                                             </div>
                                             <?php if (get_settings_by_key('site_logo')) {?>
                                                    <div class="form-group">
                                                         <label class="control-label"></label>
                                                         <div class="controls">
                                                              <div class="input-group">
                                                                   <?php echo img(array('src' => UPLOAD_PATH . 'admin_logo/' . get_settings_by_key('site_logo'), 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage'));?>
                                                              </div>
                                                              <span class="help-block">
                                                                   <a data-url="<?php echo site_url('settings/removeSettings/site_logo');?>" 
                                                                      href="javascript:void(0);" style="width: 100px;" class="btnDeleteImage btn btn-block btn-danger btn-xs">Delete</a>
                                                              </span>
                                                         </div>
                                                    </div>
                                               <?php }?>
                                             <div class="control-group">
                                                  <label class="control-label">Site Logo</label>
                                                  <div class="controls">
                                                       <div id="newupload">
                                                            <input type="hidden" id="x10" name="x1" />
                                                            <input type="hidden" id="y10" name="y1" />
                                                            <input type="hidden" id="x20" name="x2" />
                                                            <input type="hidden" id="y20" name="y2" />
                                                            <input type="hidden" id="w0" name="w" />
                                                            <input type="hidden" id="h0" name="h" />
                                                            <input type="file" class="form-control" style="display: table;margin-bottom: 10px;" 
                                                                   name="site_logo" id="image_file0" onchange="fileSelectHandler('0', '500', '333')" />
                                                            <img id="preview0" class="preview"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="control-group">
                                                  <label class="control-label">Thumb Image Resolution</label>
                                                  <div class="controls">
                                                       <input value="<?php echo get_settings_by_key('thumbnail_width');?>" 
                                                              type="text" placeholder="Width" class="input-small" 
                                                              name="settings[thumbnail_width]" />

                                                       <input value="<?php echo get_settings_by_key('thumbnail_height');?>" 
                                                              type="text" placeholder="Height" class="input-small" 
                                                              name="settings[thumbnail_height]" />
                                                  </div>
                                             </div>
                                             <div class="control-group">
                                                  <label class="control-label">Can create sub-category</label>
                                                  <div class="controls">

                                                       <input <?php echo (get_settings_by_key('can_create_sub_category')) ? "checked='true'" : '';?> 
                                                            value="1" type="radio" name="settings[can_create_sub_category]" />&nbsp;Yes &nbsp;

                                                       <input <?php echo (!get_settings_by_key('can_create_sub_category')) ? "checked='true'" : '';?> 
                                                            value="0" type="radio" name="settings[can_create_sub_category]" />&nbsp; No
                                                  </div>
                                             </div>
                                             <div class="form-actions">
                                                  <input type="submit" class="btn blue"/>
                                                  <button type="button" class="btn"><i class=" icon-remove"></i> Cancel</button>
                                             </div>
                                             <?php echo form_close()?>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>