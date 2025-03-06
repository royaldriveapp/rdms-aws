<style>
     .req_color{
          background-color: #161515;
     }
          .req_head{
          background-color: #9ea09c;
     }

     .existing{
          background-color: #5d7685;    
     }
     .exssting_new{
          background-color: #6fb4dc7a;
     }
     .existing_head{
        background-color: #a7cfd1bd;   
     }
     .pitched{
          background-color: #a3bc88;    
     }
     .lbl{
          color:white  !important;    
     }
     .form-control{
          background-color: #6866660 !important;
     }
     .multiselect{
          width: 277px !important; 
            }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update enquiry</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <!-- Smart Wizard -->
                         <!--<p></p>-->
                         <?php
                           $kms = get_km_ranges();
                           $price_ranges = get_price_ranges();
                           $vehicleColors = getVehicleColors();
                         ?>
                         <form id="wizard" data-url="<?php echo site_url('enquiry/update');?>" class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                              <input type="hidden" class="txtEnqId" name="enq_id" value="<?php echo $enquiry['enq_id'];?>"/>
                              <ul class="wizard_steps">
                                   <li>
                                        <a href="#step-1">
                                             <span class="step_no">1</span>
                                             <span class="step_descr">
                                                  Step 1<br />
                                                  <small>Customer enquiry</small>
                                             </span>
                                        </a>
                                   </li>

                                   <li>
                                        <a href="#step-2">
                                             <span class="step_no">2</span>
                                             <span class="step_descr">
                                                  Step 2<br />
                                                  <small>Inquiry Questions</small>
                                             </span>
                                        </a>
                                   </li>

                                   <li>
                                        <a href="#step-3">
                                             <span class="step_no">3</span>
                                             <span class="step_descr">
                                                  Step 3<br />
                                                  <small>Vehicle details</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-4">
                                             <span class="step_no">4</span>
                                             <span class="step_descr">
                                                  Step 4<br />
                                                  <small>Mode of payment</small>
                                             </span>
                                        </a>
                                   </li>
                              </ul>
                              <div id="step-1" class="step1">


                                   <div class="form-horizontal form-label-left">



                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <div class="row"> 
                                                  <div class="col-md-6">   
                                                       <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Grade<span class="required">*</span></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select required class="select2_group form-control" name="enquiry[enq_customer_grade]">
                                                                      <option value="">Customer grade</option>
                                                                      <?php foreach ($customerGrades as $key => $value) {?>
                                                                             <option <?php echo $value['sgrd_id'] == $enquiry['enq_customer_grade'] ? 'selected="selected"' : '';?>
                                                                                  value="<?php echo $value['sgrd_id'];?>"><?php echo $value['sgrd_grade'];?></option>
                                                                             <?php }?>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select class="select2_group form-control cmbEnqStatus" name="enquiry[enq_cus_status]" disabled="true">
                                                                      <option <?php echo $enquiry['enq_cus_status'] == 1 ? 'selected="selected"' : '';?> value="1">Sales</option>
                                                                      <option <?php echo $enquiry['enq_cus_status'] == 2 ? 'selected="selected"' : '';?> value="2">Purchase</option>
                                                                      <option <?php echo $enquiry['enq_cus_status'] == 3 ? 'selected="selected"' : '';?> value="3">Exchange</option>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                       <?php
                                                         if (check_permission('enquiry', 'assignenquires') && !empty($salesExe)) {
                                                              ?>
                                                              <div class="form-group">
                                                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sales Executive
                                                                        <span class="required">*</span>
                                                                   </label>
                                                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <select required="true" class="select2_group form-control enq_se_id cmbSearchList" name="enquiry[enq_se_id]">
                                                                             <option value="">Assign to sales executive</option>
                                                                             <?php foreach ($salesExe as $key => $value) {?>
                                                                                  <option <?php echo (isset($datas['vreg_assigned_to']) == $value['usr_id']) ? 'selected="selected"' : '';?>
                                                                                       value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_first_name'];?></option>
                                                                                  <?php }
                                                                                  ?>
                                                                        </select>
                                                                   </div>
                                                              </div>
                                                              <?php
                                                         }
                                                       ?>
                                                       <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enq_cus_name">Enquiry Date..
                                                                 <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input name="enquiry[enq_entry_date]" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" required="true"
                                                                        value="<?php echo date('d-m-Y');?>"/>
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enq_cus_name">Name
                                                                 <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_name']?>" name="enquiry[enq_cus_name]" type="text" id="first-name" class="enq_cus_name form-control col-md-7 col-xs-12" required>
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Address <span class="required">*</span></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_address']?>" id="enq_cus_address" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_address]">
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_ofc_address" class="control-label col-md-3 col-sm-3 col-xs-12">Address(Office) <span class="required">*</span></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input required id="enq_cus_ofc_address" value="<?php echo $enquiry['enq_cus_ofc_address']?>" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_ofc_address]">
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile
                                                                 <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input <?php echo!can_access_module('canchangesemodemobile') ? "disabled" : '';?> 
                                                                      value="<?php echo $enquiry['enq_cus_mobile']?>" id="enq_cus_mobile" 
                                                                      class="enq_cus_mobile form-control col-md-7 col-xs-12 numOnly" type="text" 
                                                                      name="enquiry[enq_cus_mobile]">
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Office No
                                                                 <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_office_no']?>" id="enq_cus_office_no" class="form-control col-md-7 col-xs-12 numOnly enq_cus_office_no" type="text" name="enquiry[enq_cus_office_no]">
                                                            </div>
                                                       </div>


                                                       <div class="form-group">
                                                            <label for="enq_cus_city" class="control-label col-md-3 col-sm-3 col-xs-12">Place<span class="required">*</span></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_city']?>" id="enq_cus_city" class="autoComCity form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_city]">
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_email']?>" id="enq_cus_email" class="form-control col-md-7 col-xs-12 emailOnly" type="text" name="enquiry[enq_cus_email]">
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">Whatsapp</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_whatsapp']?>" id="enq_cus_whatsapp" class="form-control col-md-7 col-xs-12 numOnly enq_cus_whatsapp" type="text" name="enquiry[enq_cus_whatsapp]">
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_fbid" class="control-label col-md-3 col-sm-3 col-xs-12">Customer FB Id</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_fbid']?>" id="enq_cus_fbid" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_fbid]">
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_age" class="control-label col-md-3 col-sm-3 col-xs-12">Age</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input value="<?php echo $enquiry['enq_cus_age']?>" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_age]">
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_gender" class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select class="select2_group form-control" name="enquiry[enq_cus_gender]">
                                                                      <option value="">- Select-</option>
                                                                      <?php foreach (unserialize(GENDER) as $key => $value) {?>
                                                                             <option value="<?php echo $key;?>" <?php echo $key == $enquiry['enq_cus_gender'] ? 'selected' : ''?> ><?php echo $value;?></option>
                                                                        <?php }?>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                       <!--                                             <div class="form-group">
                                                                                                         <label for="enq_cus_occu" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                                                                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                              <input id="enq_cus_occu" value="<?php echo isset($datas['vreg_occupation']);?>" class="autoComOccupation form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_occu]">
                                                                                                         </div>
                                                                                                    </div>-->


                                                  </div><!-- @col1 -->
                                                  <div class="col-md-6">

                                                       <div class="form-group"><?php // print_r($Profession); ?>
                                                            <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12">Profession</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select class="select2_group form-control" name="enquiry[enq_cus_occu]">
                                                                      <option value="">-Select-</option>
                                                                      <?php foreach ((array) $Profession as $value) {?>
                                                                             <option value="<?php echo $value['occ_id'];?>" <?php echo $value['occ_id'] == $enquiry['enq_cus_occu'] ? 'selected' : ''?>><?php echo $value['occ_name'];?></option>
                                                                        <?php }?>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select class="select2_group form-control" name="enquiry[enq_cus_occu_category]">
                                                                      <option value="">-Select-</option>
                                                                      <?php foreach ((array) $Profession_cat as $value) {?>
                                                                             <option value="<?php echo $value['occ_cat_id'];?>" <?php echo $value['occ_cat_id'] == $enquiry['enq_cus_occu_category'] ? 'selected' : ''?>><?php echo $value['occ_cat_name'];?></option>
                                                                        <?php }?>    
                                                                 </select>
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_company" class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required">*</span></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input required id="enq_cus_company" value="<?php echo $enquiry['enq_cus_company'];?>" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_company]">
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_phone_res" class="control-label col-md-3 col-sm-3 col-xs-12">Resi phone</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input id="enq_cus_phone_res" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $enquiry['enq_cus_phone_res'];?>" name="enquiry[enq_cus_phone_res]">
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_state" class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input id="enq_cus_country" value="91" class="autoComCountry form-control col-md-7 col-xs-12" type="hidden" name="enquiry[enq_cus_country]">
                                                                 <select   data-placeholder="Select State" name="enquiry[enq_cus_state]" class="BindDistirct select2_group form-control cmbMultiSelect" data-url="<?php echo site_url('enquiry/bindDistrict');?>" >
                                                                             <option selected>-Select State-</option>
                                                                      <?php foreach ($states as $state) {?>
                                                                             <option <?php echo $state['sts_id'] == $enquiry['enq_cus_state'] ? 'selected' : ''?> value="<?php echo $state['sts_id']?>"><?php echo $state['sts_name']?></option>
                                                                        <?php }?>
                                                                 </select>
                                                            </div>
                                                      
                                                       </div>
                                                       <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12" id="distict">
                                                                 <select class="select2_group form-control" name="enquiry[enq_cus_dist]">
                                                                      <option value="">Select District</option>
                                                                      <?php
                                                                        foreach ($districts as $key => $value) {
                                                                             ?>
                                                                             <option <?php echo $enquiry['enq_cus_dist'] == $value['std_id'] ? 'selected' : '';?>
                                                                                  value="<?php echo $value['std_id'];?>"><?php echo $value['std_district_name'];?></option>
                                                                                  <?php
                                                                             }
                                                                           ?>
                                                                 </select>
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_pin" class="control-label col-md-3 col-sm-3 col-xs-12">Pin</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input id="enq_cus_pin" class="form-control col-md-7 col-xs-12 numOnly" type="number" value="<?php echo $enquiry['enq_cus_pin'];?>" name="enquiry[enq_cus_pin]">
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_budget" class="control-label col-md-3 col-sm-3 col-xs-12">Budget</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input type="text" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                        name="enquiry[enq_budget]" value="<?php echo $enquiry['enq_budget']?>" required gtrzro="true"/>
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_vehicle_type" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle type</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select class="select2_group form-control enq_cus_when_buy" name="enquiry[enq_vehicle_type]" required>
                                                                      <option value="">Select one</option>
                                                                      <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                             <option value="<?php echo $key;?>" <?php echo $key == $enquiry['enq_vehicle_type'] ? 'selected' : ''?>><?php echo $value;?></option>
                                                                        <?php }?>
                                                                 </select>
                                                            </div>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of enquiry</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select required class="select2_group form-control enq_mode_enq cmbModeOfContact" name="enquiry[enq_mode_enq]" disabled>
                                                                      <option value="">Select one</option>
                                                                      <optgroup label="RD Mode of Enquiry">
                                                                           <?php
                                                                             foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                                  if (!in_array($key, array(18, 17, 6, 19, 20))) {
                                                                                       ?>
                                                                                       <option <?php echo ($enquiry['enq_mode_enq'] == $key) ? 'selected="selected"' : '';?> 
                                                                                            value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                                            <?php
                                                                                       }
                                                                                  }
                                                                                ?>
                                                                      </optgroup>
                                                                      <optgroup label="Own Mode of Enquiry">
                                                                           <?php
                                                                             foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                                  if (in_array($key, array(18, 17, 6, 19, 20))) {
                                                                                       ?>
                                                                                       <option <?php echo ($enquiry['enq_mode_enq'] == $key) ? 'selected="selected"' : '';?> 
                                                                                            value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                                            <?php
                                                                                       }
                                                                                  }
                                                                                ?>
                                                                      </optgroup>
                                                                 </select>
                                                                 <input type="hidden" name="enquiry[enq_mode_enq]" value="<?php echo $enquiry['enq_mode_enq'];?>"/>
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <textarea class="form-control col-md-7 col-xs-12" name="enquiry[enq_cus_remarks]"><?php echo isset($enquiry['enq_cus_remarks']) ? strip_tags($enquiry['enq_cus_remarks']) : '';?></textarea>
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Last Comments</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <?php echo isset($enquiry['vreg_last_action']) ? strip_tags($enquiry['vreg_last_action']) : '';?>
                                                            </div>
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12">Purpose of the Purchase</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select class="select2_group form-control" name="enquiry[enq_cus_purpose]" id="purpose">
                                                                      <option value="">-Select-</option>
                                                                      <?php foreach ((array) $puposes as $value) {?>
                                                                             <option value="<?php echo $value['purp_id'];?>" <?php echo $value['purp_id'] == $enquiry['enq_cus_purpose'] ? 'selected' : ''?> ><?php echo $value['purp_name'];?></option>
                                                                        <?php }?>    
                                                                      <option value="">Others</option>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                       <div class="form-group" style="display: none" id="otherPurpose">
                                                            <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Enter purpose</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <input placeholder="Enter purpose" value="" type="text" class="form-control col-md-7 col-xs-12" name="enq[other_purpose]"/>
                                                            </div>
                                                       </div>

                                                  </div><!-- @col2 -->
                                             </div><!-- @rw -->
                                             <!-- rw2 --> <div>
                                                  <table class="table table-striped table-bordered">
                                                       <thead>
                                                            <tr>
                                                                 <th>MAN</th>
                                                                 <th>Name</th>
                                                                 <th>Phone</th>
                                                                 <th>Relation</th>
                                                                 <th>Remarks</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <tr>
                                                                 <th>Money</th>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_money_name'];?>" type="text" name="money[name]"></td> 
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_money_phone'];?>" type="text" name="money[phone]"></td>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_money_relation'];?>" type="text" name="money[relation]"></td>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_money_remarks'];?>" type="text" name="money[remarks]"></td>
                                                            </tr>
                                                            <tr>
                                                                 <th>Need</th>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_need_name'];?>" type="text" name="need[name]"></td> 
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_need_phone'];?>" type="text" name="need[phone]"></td>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_need_relation'];?>" type="text" name="need[relation]"></td>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_need_remarks'];?>" type="text" name="need[remarks]"></td>
                                                            </tr>
                                                            <tr>
                                                                 <th>Authority</th>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_authority_name'];?>" type="text" name="authority[name]"></td> 
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_authority_phone'];?>" type="text" name="authority[phone]"></td>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_authority_relation'];?>" type="text" name="authority[relation]"></td>
                                                                 <td><input class="form-control col-md-7 col-xs-12" value="<?php echo $enquiry['enq_authority_remarks'];?>" type="text" name="authority[remarks]"></td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div><!-- @rw2 -->
                                        </div>

                                   </div>

                              </div>

                              <div id="step-2" class="step2">
                                   <div class="form-horizontal form-label-left">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <div class="qstSell" style="<?php echo ($enquiry['enq_cus_status'] == 1) ? 'display: block;' : 'display: none;';?>">
                                                  <?php
                                                    foreach ((array) $questions['sell'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         $answer = isset($enquiry['questions'][$value['qus_id']]['enqq_answer']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_answer'] : '';
                                                         $enqQuesId = isset($enquiry['questions'][$value['qus_id']]['enqq_id']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_id'] : 0;
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input type="checkbox"  <?php
                                                                        echo $required;
                                                                        echo ($answer == 1) ? ' checked="checked"' : '';
                                                                        ?> name="saquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                          <?php } else { // Text box ?>
                                                                        <textarea autocomplete="off" <?php echo $required;?>  id="enq_cus_need" type="text" 
                                                                                  class="form-control col-md-7 col-xs-12" name="saquestions[<?php echo $value['qus_id'];?>]"><?php echo $answer;?></textarea>
                                                                             <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                             <div class="qstBuy" style="<?php echo ($enquiry['enq_cus_status'] == 2) ? 'display: block;' : 'display: none;';?>">
                                                  <?php
                                                    foreach ((array) $questions['buy'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         $answer = isset($enquiry['questions'][$value['qus_id']]['enqq_answer']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_answer'] : '';
                                                         $enqQuesId = isset($enquiry['questions'][$value['qus_id']]['enqq_id']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_id'] : '';
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input <?php
                                                                        echo $required;
                                                                        echo ($answer == 1) ? ' checked="checked"' : '';
                                                                        ?> type="checkbox" name="byquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                        <?php } else { // Text box ?>
                                                                        <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                          name="byquestions[<?php echo $value['qus_id'];?>]"><?php echo $answer;?></textarea>
                                                                                                     <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                             <div class="qstExch" style="<?php echo ($enquiry['enq_cus_status'] == 3) ? 'display: block;' : 'display: none;';?>">
                                                  <?php
                                                    foreach ((array) $questions['exch'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         $answer = isset($enquiry['questions'][$value['qus_id']]['enqq_answer']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_answer'] : '';
                                                         $enqQuesId = isset($enquiry['questions'][$value['qus_id']]['enqq_id']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_id'] : '';
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input type="checkbox" <?php
                                                                        echo $required;
                                                                        echo ($answer == 1) ? ' checked="checked"' : '';
                                                                        ?>  name="exquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                          <?php } else { // Text box ?>
                                                                        <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                          name="exquestions[<?php echo $value['qus_id'];?>]"><?php echo $answer;?></textarea>
                                                                                                     <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div id="step-3">
                                   <?php //print_r($enquiry['vehicle_exist']);   ?>    <h2 class="StepTitle lblSale" style="<?php echo ($enquiry['enq_cus_status'] == 1 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?> width: 100%;">Customer required vehicle<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsRqVeh"></span></h2>
                                   <div class="table-responsive divVehDetailsSale" style="<?php echo ($enquiry['enq_cus_status'] == 1 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?>">
                                        <?php
                                          if (!empty($enquiry['vehicle_sall'])) {

                                               foreach ($enquiry['vehicle_sall'] as $key => $sales) {
                                                    if (empty($sales['vst_current_status']) || $sales['vst_current_status'] == 1) {
                                                         ?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleSales" +<?php echo $sales['veh_id'];?> + " :input").prop("disabled", false);
                                                              });
                                                         </script>
                                                    <?php } else {?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleSales" +<?php echo $sales['veh_id'];?> + " :input").prop("disabled", true);
                                                              });
                                                         </script>
                                                    <?php }?>

                                                    <input value="<?php echo isset($sales['veh_delete']) ? $sales['veh_delete'] : '';?>" 
                                                           type="hidden" name="vehicle[sale][veh_delete][]">
                                                    <table id="datatable-responsive" class="req_color lbl vehDetailsSale tblVehicleSales<?php echo $sales['veh_id'];?> tblVehicle<?php echo $sales['veh_id'];?> table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                         <thead>
                                                              <tr class="req_head">
                                                                   <th colspan="11" >
                                                                        Required Vehicle
                                                                        <input type="hidden" name="vehicle[sale][veh_id][]" value="<?php echo isset($sales['veh_id']) ? $sales['veh_id'] : '';?>"/>
                                                                   </th>
                                                              </tr>
                                                              <tr class="">
                                                                   <th>Brand</th>
                                                                   <th>Model</th>
                                                                   <th>Variant</th>
                                                                   <th>Fuel</th>
                                                                   <th colspan="2">Manufacturing Year</th>
                                                                   <th>Prefer Colour</th>
                                                                   <th>Budget range </th>
                                                                   <th>Km Range</th>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <tr class="lbl">
                                                                   <td>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                                                                             <option value="0">Select Brand1</option>
                                                                             <?php foreach ($brands as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_brand']) && ($value['brd_id'] == $sales['veh_brand'])) ? 'selected="selected"' : '';?> value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <?php $model = $this->myEnquiry->bindModel($sales['veh_brand'], 'array');?>
                                                                        <select style="width: 170px;" required="" data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                                class="cmbEvModel select2_group form-control bindToDropdown" name="vehicle[sale][veh_model][]" id="vreg_model">
                                                                                     <?php foreach ((array) $model as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_model']) && ($value['mod_id'] == $sales['veh_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td><?php $variant = $this->myEnquiry->bindVarient($sales['veh_model'], 'array');?>
                                                                        <select style="width: 170px;" required="" class="select2_group form-control cmbEvVariant" name="vehicle[sale][veh_varient][]" id="vreg_varient">
                                                                             <?php foreach ((array) $variant as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_varient']) && ($value['var_id'] == $sales['veh_varient'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                             <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_fuel']) && ($key == $sales['veh_fuel'])) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>

                                                                        <select data-placeholder="Select Year" name="vehicle[sale][veh_manf_year_from][]" style="width: 85px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value=""><?php echo $sales['veh_manf_year_from']?>From</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo @$sales['veh_manf_year_from'] == $i ? 'selected' : ''?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                             <?php }?>  

                                                                        </select>
                                                                   </td>
                                                                   <td> <select data-placeholder="Select Year" name="vehicle[sale][veh_manf_year_to][]" style="width: 85px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="">To</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo @$sales['veh_manf_year_to'] == $i ? 'selected' : ''?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                             <?php }?>  

                                                                        </select></td>
                                                                   <td>
                                                                        <select data-placeholder="Select Color" name="vehicle[sale][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select Color-</option>
                                                                             <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                                  <option <?php echo @$sales['veh_color'] == $vehicleColor['vc_id'] ? 'selected' : ''?> value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                             <?php }?>
                                                                        </select> 
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select KM" name="vehicle[sale][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select Price-</option>
                                                                             <?php foreach ($price_ranges as $price_range) {?>
                                                                                  <option <?php echo @$sales['veh_price_id'] == $price_range['pr_id'] ? 'selected' : ''?> value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                             <?php }?>
                                                                        </select>                              
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select KM" name="vehicle[sale][veh_km_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select KM-</option>
                                                                             <?php foreach ($kms as $km) {?>
                                                                                  <option <?php echo @$sales['veh_km_id'] == $km['kmr_id'] ? 'selected' : ''?> value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>

                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                              </tr>
                                                              <tr class="">
            <!--                                                       <td>Prefer Number</td>-->
                                                                   <td colspan="2">
                                                                        <p class="labl">Prefer Number</p>
            <!--                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">-->
                                                                        <input placeholder="Prefer Number" value="<?php echo @$sales['veh_prefer_no']?>" id="enq_cus_loan_emi" style="width: 313px;" class="form-control col-md-12 col-xs-12" type="text" name="vehicle[sale][veh_prefer_number][]" autocomplete="off">             
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <p class="labl">Expected Date of Purchase</p>
                                                                        <input placeholder="Expected Date of Purchase" value="<?php echo @$sales['veh_exptd_date_purchase']?>" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_exptd_date_purchase][]">
                                                                   </td>

                                                                   <td colspan="5">
                                                                        <p class="labl">Remarks</p>
                                                                        <input placeholder="Remarks" value="<?php echo @$sales['veh_remarks']?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                                                                   </td>
                                                              </tr>
                                                         </tbody>



                                                    </table>
                                                    <?php
                                               }
                                          } else {
                                               ?>
                                               <table id="datatable-responsive" class="req vehDetailsSale table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                         <tr>
                                                              <th colspan="11">
                                                                   Required Vehicle
                                                              </th>
                                                         </tr>
                                                         <tr>
                                                              <th colspan="11">
                                                                   <input type="hidden" name="vehicle[sale][veh_id][]" value="0"/>
                                                                   <select style="width: 170px;" class="cmbSearchList select2_group form-control cmbStock" 
                                                                           name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindSalesTable');?>">
                                                                        <option value="0">Select Vehicle</option>
                                                                        <?php
                                                                        foreach ((array) $evaluation as $key => $value) {
                                                                             ?>
                                                                             <option value="<?php echo $value['val_id'];?>">
                                                                                  <?php
                                                                                  echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                                  $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                                  ?>
                                                                             </option>
                                                                        <?php }?>
                                                                   </select>
                                                              </th>
                                                         </tr>
                                                         <tr>
                                                              <th>Brand</th>
                                                              <th>Model</th>
                                                              <th>Variant</th>
                                                              <th>Fuel</th>
                                                              <th>Year</th>
                                                              <th>Color</th>
                                                              <th>Price range</th>
                                                              <th>Km range</th>
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                         <tr>
                                                              <td>
                                                                   <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                                                                        <option value="0">Select Brand02</option>
                                                                        <?php foreach ($brands as $key => $value) {?>
                                                                             <option <?php echo (isset($sales['veh_brand']) && ($value['brd_id'] == $sales['veh_brand'])) ? 'selected="selected"' : '';?> value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                              <td></td>
                                                              <td></td>
                                                              <td>
                                                                   <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                        <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                             <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                              <td>
                                                                   <select data-placeholder="Select Year" name="vehicle[sale][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                        <option value="">-Select Year-</option>
                                                                        <?php
                                                                        $earliest_year = YEAR_RANGE_START;
                                                                        $latest_year = date('Y');
                                                                        foreach (range($latest_year, $earliest_year) as $i) {
                                                                             ?>
                                                                             <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                        <?php }?>  

                                                                   </select>
                                                              </td>
                                                              <td>
                                                                   <select data-placeholder="Select Color" name="vehicle[sale][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                        <option value="">-Select Color-</option>
                                                                        <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                             <option  value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                        <?php }?>
                                                                   </select> 
                                                              </td>
                                                              <td>
                                                                   <select data-placeholder="Select Price" name="vehicle[sale][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                        <option value="">-Select Price-</option>
                                                                        <?php foreach ($price_ranges as $price_range) {?>
                                                                             <option value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                        <?php }?>
                                                                   </select>   
                                                              </td>

                                                              <td>
                                                                   <select data-placeholder="Select KM" name="vehicle[sale][veh_km_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                        <option value="">-Select KM-</option>
                                                                        <?php foreach ($kms as $km) {?>
                                                                             <option value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>

                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="6">
       <!--                                                                   <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">-->
                                                                   <input required="true" placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[sale][veh_reg1][]" autocomplete="off">
                                                                   <input required="true" placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[sale][veh_reg2][]" autocomplete="off">
                                                                   <input required="true" placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[sale][veh_reg3][]" autocomplete="off">
                                                                   <input required="true" placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[sale][veh_reg4][]" autocomplete="off">               
                                                              </td>
                                                              <td colspan="5">
                                                                   <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="11">
                                                                   <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                                                              </td>
                                                         </tr>
                                                    </tbody>
                                               </table>
                                          <?php }
                                        ?>
                                   </div>
                                   <div class="divVehDetailsReq">
                                   </div>
                                   <!-- Existing -->
                                   <div class="table-responsive divVehDetailsSale" style="">
                                        <h2 class="StepTitle lblSale" style="<?php echo ($enquiry['enq_cus_status'] == 1 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?> width: 100%;">2Existing vehicle<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsExisting"></span></h2>
                                        <?php
                                          if (!empty($enquiry['vehicle_exist'])) {

                                               foreach ($enquiry['vehicle_exist'] as $key => $exist) {
                                                    ?>

                                                    <div class="table-responsive">
                                                         <table id="datatable-responsive" class="existing lbl vehDetailsBuy table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                              <thead>
                                                                   <tr class="existing_head">
                                                                        <th colspan="11">
                                                                             Existing Vehicle.
                                                                        </th>
                                                                   </tr>
                                                                   <tr>
                                                                        <th class="labl"><?php //print_r($enquiry['vehicle_exist']); ?>Make</th>
                                                                        <th class="labl">Model</th>
                                                                        <th class="labl">Variant</th>
                                                                        <th class="labl">Fuel</th>
                                                                        <th class="labl">Manf Year</th>
                                                                        <th class="labl">Color</th>
                                                                        <th class="labl">KM</th>
                                                                        <th class="labl">Exchange intrested</th>

                                                                   </tr>
                                                              </thead>
                                                              <tbody>
                                                                   <tr>

                                                                        <td>
                                                                             <input type="hidden" name="vehicle[existing][veh_id][]" value="<?php echo isset($exist['veh_id']) ? $exist['veh_id'] : '';?>"/>
                                                                             <select required style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[existing][veh_brand][]">
                                                                                  <option value="0">Select Brand</option>
                                                                                  <?php foreach ($brands as $key => $value) {?>
                                                                                       <option <?php echo (isset($exist['veh_brand']) && ($value['brd_id'] == $exist['veh_brand'])) ? 'selected="selected"' : '';?>  value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                                  <?php }?>
                                                                             </select>
                                                                        </td>
                                                                        <td><?php 
                                                                             $model = $this->myEnquiry->bindModel($exist['veh_brand'], 'array');?>
                                                                             <select style="width: 170px;" required="" data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                                     class="cmbEvModel select2_group form-control bindToDropdown" name="vehicle[existing][veh_model][]" id="vreg_model">
                                                                                          <?php foreach ((array) $model as $key => $value) {?>
                                                                                       <option <?php echo (isset($exist['veh_model']) && ($value['mod_id'] == $exist['veh_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                                                  <?php }?>
                                                                             </select></td>
                                                                        <td><?php 
                                                                          
                                                                       $variant = $this->myEnquiry->bindVarient($exist['veh_model'], 'array');?>
                                                                             <select style="width: 170px;" required="" class="select2_group form-control cmbEvVariant" name="vehicle[existing][veh_varient][]" id="vreg_varient">
                                                                                  <?php foreach ((array) $variant as $key => $value) {?>
                                                                                       <option <?php echo (isset($exist['veh_varient']) && ($value['var_id'] == $exist['veh_varient'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                                                  <?php }?>
                                                                             </select></td>
                                                                        <td>

                                                                             <select style="width: 170px;" class="select2_group form-control" name="vehicle[existing][veh_fuel][]">
                                                                                  <option><?php echo $exist['veh_model'];?></option>
                                                                                  <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                                       <option <?php echo (isset($exist['veh_fuel']) && ($key == $exist['veh_fuel'])) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                                  <?php }?>
                                                                             </select>
                                                                        </td>
                                                                        <td>
                                                                             <select data-placeholder="Select Year" name="vehicle[existing][veh_manf_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                                  <option value="">-Select Year-</option>
                                                                                  <?php
                                                                                  $earliest_year = YEAR_RANGE_START;
                                                                                  $latest_year = date('Y');
                                                                                  foreach (range($latest_year, $earliest_year) as $i) {
                                                                                       ?>
                                                                                       <option <?php echo (isset($exist['veh_manf_year']) && ( $i == $exist['veh_manf_year'])) ? 'selected="selected"' : '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                                  <?php }?>  

                                                                             </select>
                                                                        </td>
                                                                        <td>
                                                                             <select data-placeholder="Select Color" name="vehicle[existing][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                                  <option value="">-Select Color-</option>
                                                                                  <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                                       <option <?php echo @$sales['veh_color'] == $vehicleColor['vc_id'] ? 'selected' : ''?> value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                                  <?php }?>
                                                                             </select>  
                                                                        </td>
                                                                        <td>
                                                                             <input style="width: 100px;" value="<?php echo $exist['veh_km_from']?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][veh_km_from][]">

                                                                        </td>
                                                                        <td>
                                                                             <select data-placeholder="Select Color" name="vehicle[existing][exchange_intrested][]" style="width: 170px;" class=" form-control  " >
                                                                                  <?php
                                                                                  $yesOrNo = unserialize(Yes_or_No);
                                                                                  ?>
                                                                                  <option value="">-Select-</option>
                                                                                  <?php foreach ($yesOrNo as $key => $value) {?>
                                                                                       <option value="<?php echo $key;?>" <?php echo $exist['veh_exchange_intrested'] == $key ? 'selected' : ''?>> <?php echo $value;?></option>       
                                                                                  <?php }?>



                                                                             </select>  
                                                                        </td>
                                                                   </tr>
                                                                   <tr>
                                                                        <td colspan="4">
                                                                             <p class="labl">Market value</p>
                                                                             <input placeholder="Market value" value="<?php echo $exist['veh_exch_dealer_value'];?>"  class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][market_value][]">

                                                                        </td>
                                                                        <td colspan="2">
                                                                             <p class="labl">Our offer</p>
                                                                             <input placeholder="Our Offer" value="<?php echo $exist['veh_exch_estimate']?>"  class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][our_offer][]">
                                                                        </td>
                                                                        <td colspan="2">
                                                                             <p class="labl">Customer expectation</p>
                                                                             <input value="<?php echo $exist['veh_exch_cus_expect'];?>" placeholder="Customer expectation" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][veh_exch_cus_expect][]"> 
                                                                        </td>
                                                                   </tr>
                                                                   <tr>
                                                                        <td colspan="4">
                                                                             <?php @$reg_no = explode('-', $exist['veh_reg']);?>
                                                                             <p class="labl">Registration</p>
                                                                             <input required value="<?php echo @$reg_no[0]?>" placeholder="KL" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[existing][veh_reg1][]" autocomplete="off">
                                                                             <input required value="<?php echo @$reg_no[1]?>" placeholder="00"  style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[existing][veh_reg2][]" autocomplete="off">
                                                                             <input required value="<?php echo @$reg_no[2]?>" placeholder="AA"  style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[existing][veh_reg3][]" autocomplete="off">
                                                                             <input required value="<?php echo @$reg_no[3]?>" placeholder="0000"  style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[existing][veh_reg4][]" autocomplete="off">
                                                                        </td>
                                                                        <td colspan="2">
                                                                             <p class="labl">Ownership</p>
                                                                             <input value="<?php echo $exist['veh_owner'];?>" placeholder="Ownership"  class="form-control col-md-7 col-xs-12" type="number" name="vehicle[existing][veh_owner][]">
                                                                        </td>
                                                                        <td colspan="2">
                                                                             <p class="labl">Insurance Validity</p>
                                                                             <input value="<?php echo $exist['veh_insurance_validity'];?>"  placeholder=" Insurance Validity " class="dtpDatePickerDMY form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][insurance_validity][]">
                                                                        </td>
                                                                   </tr>
                                                                   <tr>
                                                                        <td colspan="8">
                                                                             <p class="labl">Tyre condition</p>
                                                                             <input value="<?php echo $exist['tyre_condition'];?>" placeholder="Tyre condition" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][tyre_condition][]">
                                                                        </td>
                                                                   </tr>
                                                                   <tr>
                                                                        <td colspan="8">
                                                                             <p class="labl">Remarks</p>
                                                                             <input value="<?php echo $exist['veh_remarks'];?>" placeholder="Remarks"  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][veh_remarks][]">
                                                                        </td>
                                                                   </tr>

                                                              </tbody>
                                                         </table>
                                                    </div>
                                                    <?php
                                               }
                                          } else {
                                               ?>
                                               <div class="table-responsive">
                                                    <table id="datatable-responsive" class="exssting_new vehDetailsBuy table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                         <thead>
                                                              <tr>
                                                                   <th colspan="11">
                                                                        Existing Vehicle
                                                                   </th>
                                                              </tr>
                                                              <tr>
                                                                   <th>Make</th>
                                                                   <th>Model</th>
                                                                   <th>Variant</th>
                                                                   <th>Fuel</th>
                                                                   <th>Manf Year</th>
                                                                   <th>Color</th>
                                                                   <th>KM</th>
                                                                   <th>Exchange intrested</th>

                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <tr>
                                                                   <td>
                                                                        <select required style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[existing][veh_brand][]">
                                                                             <option value="0">Select Brand</option>
                                                                             <?php foreach ($brands as $key => $value) {?>
                                                                                  <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td></td>
                                                                   <td></td>
                                                                   <td>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[existing][veh_fuel][]">
                                                                             <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                                  <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Year" name="vehicle[existing][veh_manf_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="">-Select Year-</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                             <?php }?>  

                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Color" name="vehicle[existing][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select Color-</option>
                                                                             <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                                  <option value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                             <?php }?>
                                                                        </select>  
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][veh_km_from][]">

                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Color" name="vehicle[existing][exchange_intrested][]" style="width: 170px;" class=" form-control  " >
                                                                             <option value="">-Select-</option>

                                                                             <option value="1">Yes</option>
                                                                             <option value="2">No</option>

                                                                        </select>  
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="4">
                                                                        <input placeholder="Market value" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][market_value][]">

                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Our Offer" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][our_offer][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input  placeholder="Customer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][veh_exch_cus_expect][]"> 
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="4">

                                                                        <input required placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[existing][veh_reg1][]" autocomplete="off">
                                                                        <input required placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[existing][veh_reg2][]" autocomplete="off">
                                                                        <input required placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[existing][veh_reg3][]" autocomplete="off">
                                                                        <input required placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[existing][veh_reg4][]" autocomplete="off">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Ownership" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[existing][veh_owner][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Insurance Validity " id="enq_cus_loan_emi" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][insurance_validity][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="8">
                                                                        <input placeholder="Tyre condition" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][tyre_condition][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="8">
                                                                        <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][veh_remarks][]">
                                                                   </td>
                                                              </tr>

                                                         </tbody>
                                                    </table>
                                               </div>
                                          <?php }
                                        ?>
                                        <div class="divVehDetailsExisting">
                                        </div>
                                   </div>
                                   <!-- @Existing -->

                                   <!-- pitched1 -->
                                   <?php if (!empty($enquiry['vehicle_pitched'])) {?>
                                          <h2 class="StepTitle lblSale" style="width: 100%;">Pitched vehicle </h2>
                                          <?php
                                          foreach ($enquiry['vehicle_pitched'] as $key => $pitched) {
                                                                                      $pitchedVehData = $this->evaluation->getPitchedVeh($pitched['veh_stock_id']);
                                               ?>
                                               <table id="datatable-responsive" class="pitched lbl vehDetailsSale table table-stripedj table-bordered dt-responsive nowrap tbl" cellspacing="0" width="100%">
                                                    <thead>
                                                         <tr>
                                                              <th colspan="11">Pitched vehicle</th>
                                                         </tr>
            <!--                                                         <tr>
                                                              <th colspan="11">
                                                         <?php //print_r($pitchedVehData);?>
                                                                   <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemove_pitchedVeh"></span>
                                                                   <select style="width: 170px;float: left;" class="cmbSearchList select2_group form-control cmbStock" 
                                                                           name="vehicle[pitched][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindPitchedVehTable');?>">
                                                                        <option value="0"><?php echo $pitched['veh_stock_id'];?>Select Vehicle</option>
                                                         <?php
                                                         foreach ((array) $evaluation as $key => $value) {//val_color
                                                              if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
                                                                   ?>
                                                                                            <option <?php echo $pitched['veh_stock_id'] == $value['val_id'] ? 'selected' : '';?> value="<?php echo $value['val_id'];?>">
                                                                   <?php
                                                                   echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                   $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                   ?>
                                                                                            </option>
                                                                   <?php
                                                              }
                                                         }
                                                         ?>
                                                                   </select>
                                                              </th>
                                                         </tr>-->
                                                         <tr>
                                                              <th>Brand</th>
                                                              <th>Model</th>
                                                              <th>Variant</th>
                                                              <th>Fuel</th>
                                                              <th>Year</th>
            <!--                                                       <th>Color</th>-->
                                                              <th>Our Price</th>
                                                              <th>Customer Offer</th>
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                         <tr>

                                                              <td>
                                                                   <input type="hidden" value="<?php echo $pitchedVehData['val_id'];?>" name="vehicle[pitched][veh_val_id][]" >
                                                                   <input type="hidden" name="vehicle[pitched][veh_id][]" value="<?php echo $pitched['veh_id'];?>"/>
                                                                   <?php echo $pitchedVehData['brd_title'];?>
                                                              </td>
                                                              <td>
                                                                   <?php echo $pitchedVehData['mod_title'];?>
                                                              </td>
                                                              <td>
                                                                   <?php echo $pitchedVehData['var_variant_name'];?>
                                                              </td>
                                                              <td>
                                                                   <?php echo unserialize(FUAL)[$pitchedVehData['val_fuel']];?>
                                                              </td>
                                                              <td>
                                                                   <?php echo $pitchedVehData['val_model_year'];?>
                                                              </td>
                                                              <td>     
                                                                   <?php echo $pitchedVehData['val_price_market_est']?>
                                                                   <!--veh_exch_estimate-->
                                                              </td>
                                                              <td>
                                                                   <!--veh_exch_cus_expect-->

                                                                   <input value="<?php echo $pitched['veh_exch_cus_expect'];?>" placeholder="Customer Offer" style="width: 100%;"  class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[pitched][veh_customer_offer][]">

                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="2">
                                                                   <?php echo $pitchedVehData['val_prt_1'] . '-' . $pitchedVehData['val_prt_2'] . '-' . $pitchedVehData['val_prt_3'] . '-' . $pitchedVehData['val_prt_4']?>
                                                              </td>
                                                              <td colspan="3">
                                                                   <input value="<?php echo $pitched['veh_remarks'];?> "placeholder="Executive Remarks "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_remarks][]">
                                                              </td>
                                                              <td colspan="3">
                                                                   <input value="<?php echo $pitched['veh_tl_remarks'];?>" placeholder="TL remarks "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_tl_remarks][]">
                                                              </td>

                                                         </tr>
                                                         <tr>

                                                              <td colspan="4">
                                                                   <input value="<?php echo $pitched['veh_sm_remarks'];?>" placeholder="SM Remarks "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_sm_remarks][]">
                                                              </td>
                                                              <td colspan="6">
                                                                   <input  value="<?php echo $pitched['veh_gm_remarks'];?>" placeholder="Gm Reamrk "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_gm_remarks][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="11">
                                                                   <label>Evaluated By : <?php echo $pitchedVehData['usr_first_name'] . ' ' . $pitchedVehData['usr_last_name'];?></label>
                                                              </td>
                                                         </tr>

                                                    </tbody>
                                               </table>
                                          <?php }
                                     }
                                   ?>
                                   <!-- @pitched1-->
                                   <!-- pitched2 -->
                                   <h2 class="StepTitle lblSale" style="width: 100%;">Add Pitched vehicle <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsPitched"></span></h2>
                                   <div class="table-responsive divVehDetailsPitched">
                                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap tbl" cellspacing="0" width="100%">
                                             <thead>
                                                  <tr>
                                                  <tr>
                                                       <th colspan="11">Pitched vehicle..</th>
                                                  </tr>
                                             <th colspan="11">
                                                  <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemove_pitchedVeh"></span>
                                                  <select style="width: 170px;float: left;" class="cmbSearchList select2_group form-control cmbStock" 
                                                          name="vehicle[pitched][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindPitchedVehTable');?>">
                                                       <option value="0">Select Vehicle</option>
                                                       <?php
                                                         foreach ((array) $evaluation as $key => $value) {//val_color
                                                              if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
                                                                   ?>
                                                                   <option  value="<?php echo $value['val_id'];?>">
                                                                        <?php
                                                                        echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                        $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                        ?>
                                                                   </option>
                                                                   <?php
                                                              }
                                                         }
                                                       ?>
                                                  </select>
                                             </th>
                                             </tr>
                                             <tr>
                                                  <th>Brand</th>
                                                  <th>Model</th>
                                                  <th>Variant</th>
                                                  <th>Fuel</th>
                                                  <th>Year</th>
<!--                                                       <th>Color</th>-->
                                                  <th>Our Price</th>
                                                  <th>Customer Offer</th>
                                             </tr>
                                             </thead>
                                             <tbody>


                                             </tbody>
                                        </table>
                                   </div>

                                   <!-- @Pitched2 -->
                                   <h2 class="StepTitle lblBuy" style="<?php echo ($enquiry['enq_cus_status'] == 2 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?>width: 100%;">Purchase<small> (Vehicle from customer)</small><span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsBuy"></span></h2>
                                   <div class="table-responsive divVehDetailsBuy" style="<?php echo ($enquiry['enq_cus_status'] == 2 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?>">
                                        <?php
                                          if (!empty($enquiry['vehicle_buy'])) {
                                               foreach ($enquiry['vehicle_buy'] as $key => $buy) {
                                                    if (empty($buy['vst_current_status']) || $buy['vst_current_status'] == 1) {
                                                         ?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleBuy" +<?php echo $buy['veh_id'];?> + " :input").prop("disabled", false);
                                                              });
                                                         </script>
                                                    <?php } else {?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleBuy" +<?php echo $buy['veh_id'];?> + " :input").prop("disabled", true);
                                                              });
                                                         </script>
                                                    <?php }?>
                                                    <input type="hidden" name="vehicle[buy][veh_id][]" value="<?php echo isset($buy['veh_id']) ? $buy['veh_id'] : '';?>"/>
                                                    <input value="<?php echo isset($buy['veh_delete']) ? $buy['veh_delete'] : '';?>" 
                                                           type="hidden" name="vehicle[buy][veh_delete][]">
                                                    <table id="datatable-responsive" class="vehDetailsBuy tblVehicleBuy<?php echo $buy['veh_id'];?> tblVehicle<?php echo $buy['veh_id'];?> table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                         <thead>
                                                              <tr>
                                                                   <th>Brand</th>
                                                                   <th>Model</th>
                                                                   <th>Variant</th>
                                                                   <th>Fuel</th>
                                                                   <th>Model year</th>
                                                                   <th>Color</th>
                                                                   <th>Price Range</th>
                                                                   <th>KM</th>
                                                              </tr>

                                                         </thead>

                                                         <tbody>
                                                              <tr>
                                                                   <td>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" name="vehicle[buy][veh_brand][]" data-url="<?php echo site_url('enquiry/bindModel');?>">
                                                                             <option value="0">Select Brand</option>
                                                                             <?php foreach ($brands as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_brand']) && ($value['brd_id'] == $buy['veh_brand'])) ? 'selected="selected"' : '';?> value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td> <?php $model = $this->myEnquiry->bindModel($buy['veh_brand'], 'array');?>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindVariantBuy" name="vehicle[buy][veh_model][]" data-url="<?php echo site_url('enquiry/bindVarient');?>">
                                                                             <?php foreach ((array) $model as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_model']) && ($value['mod_id'] == $buy['veh_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                                             <?php }?>
                                                                        </select></td>
                                                                   <td> <?php $variant = $this->myEnquiry->bindVarient($buy['veh_model'], 'array');?>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_varient][]">
                                                                             <?php foreach ((array) $variant as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_varient']) && ($value['var_id'] == $buy['veh_varient'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                                                                             <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_fuel']) && ($key == $buy['veh_fuel'])) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Year" name="vehicle[buy][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="">-Select Year-</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo $buy['veh_year'] == $i ? 'selected' : ''?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                             <?php }?>  

                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Color" name="vehicle[buy][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select Color1-</option>
                                                                             <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                                  <option <?php echo $buy['veh_color'] == $vehicleColor['vc_id'] ? 'selected' : ''?> value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                             <?php }?>
                                                                        </select>  
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Price" name="vehicle[buy][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select Price-</option>
                                                                             <?php foreach ($price_ranges as $price_range) {?>
                                                                                  <option <?php echo $buy['veh_price_id'] == $price_range['pr_id'] ? 'selected' : ''?> value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                             <?php }?>
                                                                        </select> 
                                                                   </td>
                                                                   <td>

                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_km_from']) ? $buy['veh_km_from'] : '';?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="4">
                                                                        <input value="<?php echo isset($buy['veh_exch_cus_expect']) ? $buy['veh_exch_cus_expect'] : '';?>" placeholder="Customeer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_exch_cus_expect][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input value="<?php echo isset($buy['veh_exch_estimate']) ? $buy['veh_exch_estimate'] : '';?>" placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input value="<?php echo isset($buy['veh_exch_dealer_value']) ? $buy['veh_exch_dealer_value'] : '';?>" placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="4">
                                                                        <?php
                                                                        $regNo = explode("-", $buy['veh_reg']);
                                                                        ?>
                                                                        <input value="<?php echo $regNo[0];?>" required="true" placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg1][]" autocomplete="off">
                                                                        <input value="<?php echo $regNo[1];?>" required="true" placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg2][]" autocomplete="off">
                                                                        <input value="<?php echo $regNo[2];?>" required="true" placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg3][]" autocomplete="off">
                                                                        <input value="<?php echo $regNo[3];?>" required="true" placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg4][]" autocomplete="off">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input value="<?php echo isset($buy['veh_owner']) ? $buy['veh_owner'] : '';?>" placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input value="<?php echo isset($buy['veh_chassis_number']) ? $buy['veh_chassis_number'] : '';?>" placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_chassis_number][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="8">
                                                                        <input value="<?php echo isset($buy['veh_remarks']) ? $buy['veh_remarks'] : '';?>" placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="2">
                                                                        <input value="<?php echo isset($buy['veh_delivery_date']) ? date('d-m-Y', strtotime($buy['veh_delivery_date'])) : '';?>" placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                                                                               type="text" name="vehicle[buy][veh_delivery_date][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input value="<?php echo isset($buy['veh_first_reg']) ? date('d-m-Y', strtotime($buy['veh_first_reg'])) : '';?>" placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" name="vehicle[buy][veh_first_reg][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <select data-placeholder="First manf year" name="vehicle[buy][veh_manf_year][]" style="width: 270px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="">-Select First manf year-</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo $buy['veh_manf_year'] == $i ? 'selected' : '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                             <?php }?>  

                                                                        </select>
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                             <option value="">Select A/C</option>
                                                                             <option <?php echo $buy['veh_ac'] == 1 ? 'selected' : '';?> value="1">W/o </option>
                                                                             <option <?php echo $buy['veh_ac'] == 2 ? 'selected' : '';?> value="2">Single </option>
                                                                             <option <?php echo $buy['veh_ac'] == 3 ? 'selected' : '';?> value="3">Dual </option>
                                                                             <option <?php echo $buy['veh_ac'] == 4 ? 'selected' : '';?> value="4">Multi </option>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <input value="<?php echo isset($buy['veh_ac_zone']) ? $buy['veh_ac_zone'] : '';?>" placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" name="vehicle[buy][veh_ac_zone][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="2">
                                                                        <input value="<?php echo isset($buy['veh_cc']) ? $buy['veh_cc'] : '';?>" placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" name="vehicle[buy][veh_cc][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                                                                             <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                                  <option <?php echo $buy['veh_vehicle_type'] == $key ? 'selected' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option> 
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input  value="<?php echo isset($buy['veh_engine_num']) ? $buy['veh_engine_num'] : '';?>" placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_engine_num][]">
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                             <option  value="">Select Transmission</option>
                                                                             <option <?php echo $buy['veh_transmission'] == 1 ? 'selected' : '';?> value="1">M/T</option>
                                                                             <option <?php echo $buy['veh_transmission'] == 2 ? 'selected' : '';?> value="2">A/T</option>
                                                                             <option <?php echo $buy['veh_transmission'] == 3 ? 'selected' : '';?> value="3">S/T</option>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <input  value="<?php echo isset($buy['veh_seat_no']) ? $buy['veh_seat_no'] : '';?>" placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
                                                                   </td>
                                                              </tr>
                                                         </tbody>
                                                    </table>
                                                    <?php
                                               }
                                          } else if ($enquiry['enq_cus_status'] != 1) {
                                               ?>
                                               <table id="datatable-responsive" class="vehDetailsBuy table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                    <thead>

                                                         <tr>
                                                              <th>Brand</th>
                                                              <th>Model</th>
                                                              <th>Variant</th>
                                                              <th>Fuel</th>
                                                              <th>Model year</th>
                                                              <th>Color</th>
                                                              <th>Price Range</th>
                                                              <th>KM</th>
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                         <tr>
                                                              <td>
                                                                   <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
                                                                        <option value="0">Select Brand</option>
                                                                        <?php foreach ($brands as $key => $value) {?>
                                                                             <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                              <td></td>
                                                              <td></td>
                                                              <td>
                                                                   <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                                                                        <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                             <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                              <td>
                                                                   <select data-placeholder="Select Year" name="vehicle[buy][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                        <option value="">-Select Year-</option>
                                                                        <?php
                                                                        $earliest_year = YEAR_RANGE_START;
                                                                        $latest_year = date('Y');
                                                                        foreach (range($latest_year, $earliest_year) as $i) {
                                                                             ?>
                                                                             <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                        <?php }?>  

                                                                   </select>
                                                              </td>
                                                              <td>
                                                                   <select data-placeholder="Select Color" name="vehicle[buy][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                        <option value="">-Select Color-</option>
                                                                        <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                             <option value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                        <?php }?>
                                                                   </select>  
                                                              </td>
                                                              <td>
                                                                   <select data-placeholder="Select Price" name="vehicle[buy][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                        <option value="">-Select Price-</option>
                                                                        <?php foreach ($price_ranges as $price_range) {?>
                                                                             <option value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                        <?php }?>
                                                                   </select>  
                                                              </td>
                                                              <td>
                                                                   <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="4">
                                                                   <input  placeholder="Customer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_cus_expect][]">
                                                              </td>
                                                              <td colspan="2">
                                                                   <input placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
                                                              </td>
                                                              <td colspan="2">
                                                                   <input placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="4">
                                                                   <input required="true" placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg1][]" autocomplete="off">
                                                                   <input required="true" placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg2][]" autocomplete="off">
                                                                   <input required="true" placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg3][]" autocomplete="off">
                                                                   <input required="true" placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg4][]" autocomplete="off">
                                                              </td>
                                                              <td colspan="2">
                                                                   <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                                                              </td>
                                                              <td colspan="2">
                                                                   <input placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_chassis_number][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="8">
                                                                   <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="2">
                                                                   <input placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                                                                          type="text" name="vehicle[buy][veh_delivery_date][]">
                                                              </td>
                                                              <td colspan="2">
                                                                   <input placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                          type="text" name="vehicle[buy][veh_first_reg][]">
                                                              </td>
                                                              <td colspan="2">
                                                                   <select data-placeholder="First manf year" name="vehicle[buy][veh_manf_year][]" style="width: 270px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                        <option value="">-Select First manf year-</option>
                                                                        <?php
                                                                        $earliest_year = YEAR_RANGE_START;
                                                                        $latest_year = date('Y');
                                                                        foreach (range($latest_year, $earliest_year) as $i) {
                                                                             ?>
                                                                             <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                        <?php }?>  

                                                                   </select>
                                                              </td>
                                                              <td colspan="1">
                                                                   <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                        <option value="">Select A/C</option>
                                                                        <option value="1">W/o</option>
                                                                        <option value="2">Single</option>
                                                                        <option value="3">Dual</option>
                                                                        <option value="4">Multi</option>
                                                                   </select>
                                                              </td>
                                                              <td colspan="1">
                                                                   <input placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                          type="text" name="vehicle[buy][veh_ac_zone][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="2">
                                                                   <input placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                          type="text" name="vehicle[buy][veh_cc][]">
                                                              </td>
                                                              <td colspan="2">
                                                                   <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                                                                        <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                             <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                              <td colspan="2">
                                                                   <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_engine_num][]">
                                                              </td>
                                                              <td colspan="1">
                                                                   <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                        <option value="">Select Transmission</option>
                                                                        <option value="1">M/T</option>
                                                                        <option value="2">A/T</option>
                                                                        <option value="3">S/T</option>
                                                                   </select>
                                                              </td>
                                                              <td colspan="1">
                                                                   <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
                                                              </td>
                                                         </tr>
                                                    </tbody>
                                               </table>
                                          <?php }
                                        ?>
                                   </div>
                              </div>
                              <div id="step-4">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="enq_cus_loan_perc" class="control-label col-md-3 col-sm-3 col-xs-12">Loan percentage</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_perc']?>" id="enq_cus_loan_perc" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_perc]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_amount" class="control-label col-md-3 col-sm-3 col-xs-12">Loan amount</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_amount']?>" id="enq_cus_loan_amount" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_amount]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_emi" class="control-label col-md-3 col-sm-3 col-xs-12">Loan EMI</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_emi']?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_emi]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_period" class="control-label col-md-3 col-sm-3 col-xs-12">Loan total period</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_period']?>" id="enq_cus_loan_period" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_period]">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>
<script>
     $(document).ready(function () {
          /*Clone of sell buy table*/
          var count = 0;
          var vehDetailsSale = $(".tmpVehDetailsSale").prop('outerHTML');
          var vehDetailsBuy = $(".tmpVehDetailsBuy").prop('outerHTML');
          $(document).on('click', '.btnAddVehDetailsSale', function () {
               $('.divVehDetailsSale').append(vehDetailsSale);
               $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
          });
          $(document).on('click', '.btnAddVehDetailsBuy', function () {
               $('.divVehDetailsBuy').append(vehDetailsBuy);
               $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
          });
          $(document).on('click', '.btnAddVehDetailsRqVeh', function () {
               count = count + 1;
               $.ajax({
                    type: 'get',
                    "url": site_url + "enquiry/add_req_veh_details",
                    data: {count: count},
                    success: function (resp) {
                         $(".divVehDetailsReq").append(resp);
                    }
               });
          });
          $(document).on('click', '.btnAddVehDetailsExisting', function () {
               count = count + 1;
               $.ajax({
                    type: 'get',
                    "url": site_url + "enquiry/add_existing_veh_details",
                    data: {count: count},
                    success: function (resp) {
                         console.log(resp);
                         $(".divVehDetailsExisting").append(resp);
                    }
               });
          });
          $(document).on('click', '.btnAddVehDetailsPitched', function () {
               count = count + 1;
               $.ajax({
                    type: 'get',
                    "url": site_url + "enquiry/add_pitched_veh_details",
                    data: {count: count},
                    success: function (resp) {
                         console.log(resp);
                         $(".divVehDetailsPitched").append(resp);
                    }
               });
          });

     });
</script>

<div style="display: none;">
     <table id="datatable-responsive" class="tmpVehDetailsSale vehDetailsSale table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"> 

          <thead>
               <tr>
                    <th colspan="11">
                         <input type="hidden" name="vehicle[sale][veh_id][]" value="0"/>
                         <select style="width: 170px;" class="cmbSearchList select2_group form-control cmbStock" 
                                 name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindSalesTable');?>">
                              <option value="0">Select Vehicle</option>
                              <?php
                                foreach ((array) $evaluation as $key => $value) {
                                     ?>
                                     <option value="<?php echo $value['val_id'];?>">
                                          <?php
                                          echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                          $value['mod_title'] . ', ' . $value['var_variant_name'];
                                          ?>
                                     </option>
                                <?php }?>
                         </select>
                    </th>
               </tr>
               <tr>
                    <th>Brand-3no</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Fuel</th>
                    <th>Year</th>
                    <th>Color</th>
                    <th>Price range</th>
                    <th>Km range</th>
               </tr>
          </thead>
          <tbody>
               <tr>
                    <td>
                         <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                              <option value="0">Select Brand</option>
                              <?php foreach ($brands as $key => $value) {?>
                                     <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                         <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                              <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                     <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td>
                         <select data-placeholder="Select Year" name="vehicle[sale][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                              <option value="">-Select Year-</option>
                              <?php
                                $earliest_year = YEAR_RANGE_START;
                                $latest_year = date('Y');
                                foreach (range($latest_year, $earliest_year) as $i) {
                                     ?>
                                     <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php }?>  

                         </select>
                    </td>
                    <td>
                         <select data-placeholder="Select Color" name="vehicle[sale][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                              <option value="">-Select Color-</option>
                              <?php foreach ($vehicleColors as $vehicleColor) {?>
                                     <option  value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                <?php }?>
                         </select> 
                    </td>
                    <td>
                         <select data-placeholder="Select Price" name="vehicle[sale][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                              <option value="">-Select Price-</option>
                              <?php foreach ($price_ranges as $price_range) {?>
                                     <option value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                <?php }?>
                         </select>   
                    </td>

                    <td>
                         <select data-placeholder="Select KM" name="vehicle[sale][veh_km_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                              <option value="">-Select KM-</option>
                              <?php foreach ($kms as $km) {?>
                                     <option value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>

                                <?php }?>
                         </select>
                    </td>

               </tr>
               <tr>
                    <td colspan="2">
<!--                         <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">-->

                         <input required="true" placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[sale][veh_reg1][]" autocomplete="off">
                         <input required="true" placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[sale][veh_reg2][]" autocomplete="off">
                         <input required="true" placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[sale][veh_reg3][]" autocomplete="off">
                         <input required="true" placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[sale][veh_reg4][]" autocomplete="off">                    </td>
                    <td colspan="1">
                         <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
                    </td>


                    <td colspan="5">
                         <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                    </td></tr>

          </tbody>
     </table>
     <table id="datatable-responsive" class="tmpVehDetailsBuy vehDetailsBuy table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
               <tr>
                    <th colspan="11">
                         <input type="text" name="vehicle[buy][veh_id][]" value="0"/>
                         <span style="margin: 5px 10px;cursor: pointer;font-size: 18px;" class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
                    </th>
               </tr>
               <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Fuel</th>
                    <th>Model year</th>
                    <th>Color</th>
                    <th>Price Range</th>
                    <th>KM</th>
               </tr>
          </thead>
          <tbody>
               <tr>
                    <td>
                         <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
                              <option value="0">Select Brand</option>
                              <?php foreach ($brands as $key => $value) {?>
                                     <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                         <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                              <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                     <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td>
                         <select data-placeholder="Select Year" name="vehicle[buy][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                              <option value="">-Select Year-</option>
                              <?php
                                $earliest_year = YEAR_RANGE_START;
                                $latest_year = date('Y');
                                foreach (range($latest_year, $earliest_year) as $i) {
                                     ?>
                                     <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php }?>  

                         </select>
                    </td>
                    <td>
                         <select data-placeholder="Select Color" name="vehicle[buy][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                              <option value="">-Select Color-</option>
                              <?php foreach ($vehicleColors as $vehicleColor) {?>
                                     <option value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                <?php }?>
                         </select>  
                    </td>
                    <td>
                         <select data-placeholder="Select Price" name="vehicle[buy][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                              <option value="">-Select Price-</option>
                              <?php foreach ($price_ranges as $price_range) {?>
                                     <option value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                <?php }?>
                         </select>  
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="4">
                         <input  placeholder="Customer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_cus_expect][]">
                    </td>
                    <td colspan="2">
                         <input placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
                    </td>
                    <td colspan="2">
                         <input placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="4">
                         <input required="true" placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg1][]" autocomplete="off">
                         <input required="true" placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg2][]" autocomplete="off">
                         <input required="true" placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg3][]" autocomplete="off">
                         <input required="true" placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg4][]" autocomplete="off">
                    </td>
                    <td colspan="2">
                         <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                    </td>
                    <td colspan="2">
                         <input placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_chassis_number][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="8">
                         <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="2">
                         <input placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                                type="text" name="vehicle[buy][veh_delivery_date][]">
                    </td>
                    <td colspan="2">
                         <input placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                type="text" name="vehicle[buy][veh_first_reg][]">
                    </td>
                    <td colspan="2">
                         <select data-placeholder="First manf year" name="vehicle[buy][veh_manf_year][]" style="width: 270px;" class="select2_group form-control cmbMultiSelectmm" >
                              <option value="">-Select First manf year-</option>
                              <?php
                                $earliest_year = YEAR_RANGE_START;
                                $latest_year = date('Y');
                                foreach (range($latest_year, $earliest_year) as $i) {
                                     ?>
                                     <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php }?>  

                         </select>
                    </td>
                    <td colspan="1">
                         <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                              <option value="">Select A/C</option>
                              <option value="1">W/o</option>
                              <option value="2">Single</option>
                              <option value="3">Dual</option>
                              <option value="4">Multi</option>
                         </select>
                    </td>
                    <td colspan="1">
                         <input placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                                type="text" name="vehicle[buy][veh_ac_zone][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="2">
                         <input placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                                type="text" name="vehicle[buy][veh_cc][]">
                    </td>
                    <td colspan="2">
                         <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                              <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                     <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td colspan="2">
                         <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_engine_num][]">
                    </td>
                    <td colspan="1">
                         <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                              <option value="">Select Transmission</option>
                              <option value="1">M/T</option>
                              <option value="2">A/T</option>
                              <option value="3">S/T</option>
                         </select>
                    </td>
                    <td colspan="1">
                         <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
                    </td>
               </tr>
          </tbody>
     </table>
</div>

<!-- $(document).ready(function () {-->
<script>
     $('#purpose').change(function () {
          var selected = $(this).children("option:selected").val();
          if (selected === '') {
               $("#otherPurpose").show();

          } else {
               $("#otherPurpose").hide();
          }
          //alert(selectedCountry);
     });
</script>
