<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Event</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/add", array('id' => "frmBrand", 'class' => "form-horizontal form-label-left frmEmployee"))?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="form-control col-md-7 col-xs-12" 
                                          name="evnt_title" id="evnt_title" placeholder="Event Title"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Event Description <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea required="true" placeholder="Event Description" class="editor" name="evnt_desc"></textarea>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="form-control col-md-7 col-xs-12" 
                                          name="evnt_place" id="evnt_place" placeholder="Event Place"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="form-control col-md-7 col-xs-12 dtpDatePicker" 
                                          name="evnt_date" id="evnt_date" placeholder="Event Date"/>
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