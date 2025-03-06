<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Accessories</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("careers/update", array('id' => "frmCareers", 'class' => "form-horizontal"))?>
                         <input value="<?php echo $career['car_id'];?>" type="hidden" name="car_id" id="car_id"/>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $career['car_title'];?>" type="text" class="form-control col-md-7 col-xs-12" name="car_title" id="car_title" placeholder="Brand Title"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">No of Vacancies</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="numOnly form-control col-md-7 col-xs-12" name="car_no_of_vacancies" 
                                          id="car_no_of_vacancies" placeholder="No of Vacancies" value="<?php echo $career['car_no_of_vacancies'];?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Qualification</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea placeholder="Qualification" class="editor" name="car_qualification"><?php echo $career['car_qualification'];?></textarea>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Experience</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea placeholder="Total Experience" class="editor" name="car_experience_total"><?php echo $career['car_experience_total'];?></textarea>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Experience Preferably</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea placeholder="Experience Preferably" class="editor" name="car_experience_preferably"><?php echo $career['car_experience_preferably'];?></textarea>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Preferred Industry</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea placeholder="Preferred Industry" class="editor" name="car_pref_industry"><?php echo $career['car_pref_industry'];?></textarea>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Preferred Competencies</label>
                              <div class="col-md-6 col-sm-6 col-xs-12 redactor-width">
                                   <textarea placeholder="Preferred Competencies" class="editor" name="car_preferred_competencies"><?php echo $career['car_preferred_competencies'];?></textarea>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Age Limit</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="car_age_limit" 
                                          value="<?php echo $career['car_age_limit'];?>" id="car_age_limit" placeholder="Age Limit"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="car_order" 
                                          value="<?php echo $career['car_order'];?>" id="car_age_limit" placeholder="Priority"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="car_location" 
                                          value="<?php echo $career['car_location'];?>" id="car_location" placeholder="Location"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Functional Competencies</label>
                              <div class="col-md-6 col-sm-6 col-xs-12 redactor-width">
                                   <textarea name="car_functional_competencies" id="car_functional_competencies" 
                                             class='editor'><?php echo $career['car_functional_competencies'];?></textarea>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Behavioral Competencies</label>
                              <div class="col-md-6 col-sm-6 col-xs-12 redactor-width">
                                   <textarea name="car_behavioral_competencies" id="car_behavioral_competencies" 
                                             class='editor'><?php echo $career['car_behavioral_competencies'];?></textarea>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Job Description</label>
                              <div class="col-md-6 col-sm-6 col-xs-12 redactor-width">
                                   <textarea name="car_job_description" id="car_job_description" 
                                             class='editor'><?php echo $career['car_job_description'];?></textarea>
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