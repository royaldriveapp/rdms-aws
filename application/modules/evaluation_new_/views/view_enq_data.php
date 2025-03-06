
<style>
     .bg-old{
          background-color: #69b86a3b;
     }
</style>
                           
                                   <div id="j" class="<?php echo $enq==1 ?'bg-old':''; ?>">
                                                                                              <?php
  $usr_showroom=get_logged_user('usr_showroom');
          $div=$this->evaluation->getDivisionByShowRoom($usr_showroom);
          if(!is_roo_user()){
          $branches=$this->evaluation->getShowRoomByDivision($div['shr_division']);
          }
          //print_r($enq_data);
    ?>
                                        <div class="row">
                                            <?php if($enq===1){?>
                                              <input type="hidden" name="val_id" value="<?php echo @$enq_data['val_id']; ?>"/>
                         <input type="hidden" name="val_status" value="<?php echo @$enq_data['val_status']; ?>"/>
                                            <?php } ?>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Division Enq </label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control cmbBindShowroomByDivision" name="valuation[val_division]" id="vreg_division"
                                                                    data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" 
                                                                    required data-dflt-select="Select Showroom">
                                                                 <option value="">Select division</option>
                                                                 <?php
                                                                foreach ($division as $key => $value) {
                                                                      ?>
                                                                      <option <?php echo @$div['shr_division']== $value['div_id'] ? 'selected' :''?> value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                                                      <?php
                                                                 }
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <input type="hidden" name="val_vehicle_id" value="<?php echo @$enq_data['veh_id'] ;?>" >
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Sales Officer </label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" 
                                                                    name="valuation[val_sales_officer]">
                                                                 <option value="">Select executive</option>
                                                                 <?php foreach ($salesExe as $key => $value) { ?>
                                                                      <option <?php echo $enq_data['enq_se_id']==$value['usr_id']?'selected':'';?> value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_username']; ?></option>                                               
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Branch</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control cmbShowroom" name="valuation[val_showroom]" id="val_showroom">
                                                                 <option value="">Select showroom</option>
                                                                   <?php foreach($branches as $key => $value) {?>
                                                                      <option <?php echo get_logged_user('usr_showroom')== $value['shr_id'] ? 'selected' :''?> value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location']; ?></option>                                                                     
                                                                 <?php }?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePicker" 
                                                                   value="" name="valuation[val_valuation_date]" id="val_valuation_date" placeholder="Date" required="required"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Evaluator</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?php
                                                            $readOnly = 0;
                                                            if (in_array($this->uid, array_column($evaluators, 'col_id'))) {
                                                                 $readOnly = 1;
                                                            }
                                                            ?>
                                                            <select required="true" <?php echo ($readOnly == 1) ? 'disabled' : ''; ?> 
                                                                    class="select2_group form-control" name="valuation[val_evaluator]" id="val_added_by">
                                                                 <option value="">Select Evaluator</option>
                                                                 <?php
                                                                 if (!empty($evaluators)) {
                                                                      foreach ($evaluators as $key => $value) {
                                                                           ?>
                                                                           <option <?php echo ($this->uid == $value['col_id']) ? 'selected="selected"' : ''; ?>
                                                                                value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title']; ?></option>
                                                                                <?php
                                                                           }
                                                                      }
                                                                      ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Evaluation Location</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" 
                                                                   name="valuation[val_location]" id="val_location" placeholder="Evaluation Location"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Manager</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="true" class="select2_group form-control" name="valuation[val_manager]" id="val_manager">
                                                                 <option value="">Select Manager</option>
                                                                 <?php
                                                                 if (!empty($managers)) {
                                                                      foreach ($managers as $key => $value) {
                                                                           ?>
                                                                           <option value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')'; ?></option>
                                                                           <?php
                                                                      }
                                                                 }
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Evaluation</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-4 col-xs-6 hourPicker" required
                                                                   value="<?php echo date('h:i A'); ?>" style="width: 50%;"  name="valuation[val_in_time]" id="val_in_time" placeholder="IN Time"/>

                                                            <input type="text" class="form-control col-md-4 col-xs-6 hourPicker" required
                                                                   style="width: 50%;" name="valuation[val_out_time]" id="val_out_time" placeholder="Out Time"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo @$enq_data['enq_cus_name'] ?>" name="valuation[val_cust_name]" 
                                                                   required id="val_cust_name" placeholder="Customer Name"/>
                                                       </div>
                                                  </div>  
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Phone Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text"  class="form-control col-md-7 col-xs-12" value="<?php echo @$typed_phone ?>" autofocus="autofocus" name="valuation[val_cust_phone]" 
                                                                    data-url="<?php echo site_url('evaluation/matchingInquiry'); ?>" required id="val_cust_phone" placeholder="Phone Number"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Email</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" value="<?php echo @$enq_data['enq_cus_email'] ?>" class="form-control col-md-4 col-xs-6"
                                                                   placeholder="Email" name="valuation[val_cust_email]" id="val_cust_email"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Purchase type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="" class="select2_group form-control" name="valuation[val_type]" id="val_fuel">
                                                                 <option value="">Select type</option>
                                                                 <?php foreach (unserialize(EVALUATION_TYPES) as $key => $value) { ?>
                                                                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer Source</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control cmbModeOfContact" name="valuation[val_cust_source]">
                                                                 <option value="">Select one</option>
                                                                 <?php
                                                                 foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                      ?>
                                                                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                      <?php
                                                                 }
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                            
                                            
                                             
                                                                                          <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Referal type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                                  <select class="form-control col-md-7 col-xs-12 referal_type" name="valuation[val_refferal_type]">
                                                                <option value="">Please select</option>
                    <?php foreach (unserialize(REFERAL_TYPES) as $key => $value) { ?>
                         <option <?php echo @$enq_data['enq_ref_type']==$key ? 'selected':'' ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                                                            </select>

                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
  <!-- $referal details -->
                                             <div class="row" style="<?php echo @$enq_data['enq_ref_type']!=4 ? 'display:none':'' ?>" id="referal_details">
                                     
                                             <div class="col-sm-6 "  >
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Staff</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
<!--                                                            <input type="text" class="form-control col-md-7 col-xs-12"
                                                                   name="valuation[val_refferer_name]" id="val_reference" placeholder="Refferer name"/>-->
                                                            <select  id="referalRdStaffs" class="referalRdStaffs select2_group form-control staff_select" name="referal_name1">


                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                              <div class="col-sm-6">
                                               <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reference Phone</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
<!--                                                            <input type="text" class="form-control col-md-7 col-xs-12 txtReference"
                                                                   name="valuation[val_reference]" id="val_reference" placeholder="Reference phone"/>-->
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly " value="" name="referal_phone1" id="referal_phone1" autocomplete="off" placeholder="Referal phone"/>
                                                       </div>
                                                  </div>
                                             </div>

                                           
                                        </div>
                              
                                                <div class="row" style="<?php echo @$enq_data['enq_ref_type']!=5 ? 'display:none':'' ?>" id="referal_details2">
                                     <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Referal Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control col-md-7 col-xs-12" name="referal_name2" id="referal_customer_name"
                           autocomplete="off" placeholder="Referal Name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                                       <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer Phone</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">

                                                            <input  type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" name="referal_phone2" id="customer_phone"
                           data-url="<?php echo site_url('registration/customerByPhone');?>" 
                           autocomplete="off" placeholder="Referal phone(Customer)" value=""/>
                    <h6 class="customer_phone_msg" id="customer_phone_msg" style="color: red;"></h6>
                                                       </div>
                                                  </div>
                                                             <input type="hidden"  name="referal_enq_cus_id" id="referal_enq_cus_id"/>
                                             </div>

                                           
                                        </div>
                                             <div class="row" style="<?php echo @$enq_data['enq_ref_type']==5 OR @$enq_data['enq_ref_type']==4 OR @$enq_data['enq_ref_type']=='' ? 'display:none':'' ?>" id="referal_details3">
                                     
                                             <div class="col-sm-6 "  >
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12"><?php echo @$enq_data['enq_ref_type']; ?>Referal Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control col-md-7 col-xs-12" name="referal_name3" id="referal_name3"
                           autocomplete="off" placeholder="Referal Name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                              <div class="col-sm-6 "  >
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reference Phone</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control col-md-7 col-xs-12 numOnly " name="referal_phone3" id="referal_phone3"
                           
                           autocomplete="off" placeholder="Referal phone"/>
                                                       </div>
                                                  </div>
                                             </div>

                                           
                                        </div>
                                        <!-- @referal details -->

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label value="" class="control-label col-md-4 col-sm-3 col-xs-12">First delivery state</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_delivery_state'];?>" type="text" class="form-control col-md-7 col-xs-12"
                                                                   name="valuation[val_first_dlvry_state]" id="val_reference" placeholder="First delivery state"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Dealership</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_dealership'];?>" type="text" class="form-control col-md-7 col-xs-12"
                                                                   name="valuation[val_first_dlvry_dlrship]" id="val_reference" placeholder="Dealership"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-2 col-sm-3 col-xs-12">First delivery location</label>
                                                       <div class="col-md-9 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_delivery_location'];?>" type="text" class="form-control col-md-7 col-xs-12"
                                                                   name="valuation[val_first_dlvry_location]" id="val_reference" placeholder="First delivery location"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Vehicle details</h3>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <?php
                                                         @$reg_no=explode('-', @$enq_data['veh_reg']);
                                                           ?>
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reg: NO</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$reg_no['0']; ?>" type="text"  class="form-control col-md-7 col-xs-12" name="valuation[val_prt_1]" 
                                                                   maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="KL"/>

                                                            <input value="<?php echo @$reg_no['1']; ?>" type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_prt_2]" 
                                                                   maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="00"/>

                                                            <input value="<?php echo @$reg_no['2']; ?>" type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_prt_3]" 
                                                                   maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="AA"/>

                                                            <input value="<?php echo @$reg_no['3']; ?>" type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_prt_4]" 
                                                                   maxlength="4" style="text-transform: uppercase;width: 80px;" required placeholder="0000"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Brand</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="true" data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" 
                                                                    data-dflt-select="Select Model" class="select2_group form-control bindToDropdown" name="valuation[val_brand]" id="val_brand">
                                                                 <option value="">Select Brand</option>
                                                                 <?php
                                                                 
                                                                      foreach ($brand as $key => $value) {
                                                                           ?>
                                                                 <option <?php echo !empty($enq_data) ? $enq_data['veh_brand']==$value['brd_id']? 'selected':'' :'' ?> value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                                                                           <?php
                                                                      }
                                                               
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                         <?php  
                                           if(!empty($enq_data)){
                                              $model = $this->enquiry->getModelByBrand($enq_data['veh_brand']);
                                               $variant = $this->enquiry->getVariantByModel($enq_data['veh_model']);
                                           }
                                                                  
                                                                        ?>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Model</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required data-url="<?php echo site_url('enquiry/bindVarient'); ?>" 
                                                                    data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                    class="cmbEvModel select2_group form-control bindToDropdown" 
                                                                    name="valuation[val_model]" id="val_model">
                                                                 <option value="">Select brand first</option>
                                                                 
                                                                   <?php if(!empty($model)){
                                                                        foreach ((array) $model as $key => $value) {?>
                                                                                   <option <?php echo $value['mod_id'] == $enq_data['veh_model'] ? 'selected="selected"' : '';?> 
                                                                                       value="<?php echo $value['mod_id'];?>"><?php echo $value['mod_title'];?></option>
                                                                                  <?php }
                                                                   }
                                                                                  ?>
                                                            
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Variant</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control cmbEvVariant" 
                                                                    name="valuation[val_variant]" id="val_variant">
                                                                 <option value="">Select model first</option>
                                                                 <?php 
                                                                   if(!empty($variant)){
                                                                        foreach ((array) $variant as $key => $value) {?>
                                                                                  <option <?php echo $value['var_id'] == $enq_data['veh_varient'] ? 'selected="selected"' : '';?> 
                                                                                       value="<?php echo $value['var_id'];?>"><?php echo $value['var_variant_name'];?></option>
                                                                                  <?php }
                                                                                  }?>
                                                            
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Delivery Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_delivery_date'] ?>" required="required" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_delv_date]" id="val_delv_date">
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Fuel</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control bindToDropdown" name="valuation[val_fuel]" i="val_fuel">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) { ?>
                                                                      <option  <?php echo @$enq_data['veh_fuel']==$key?'selected':''?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">1ST Reg Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_first_reg'] ?>" type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   name="valuation[val_reg_date]" id="val_reg_date" placeholder="1ST Reg Date"/>
                                                       </div>
                                                  </div>
                                             </div>
                                              <?php
     $vehicleColors = getVehicleColors();
       ?>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Color</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-4 col-xs-6" name="valuation[val_color]" required>
                                                                 <option value="">Colour</option>
                                                                 <?php foreach ( $vehicleColors as $key => $value) { ?>
                                                                      <option <?php echo @$enq_data['veh_color']==$value['vc_id']?'selected':''; ?> value="<?php echo $value['vc_id']; ?>"><?php echo $value['vc_color']; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Model Year</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_year'] ?>" type="text" class="form-control col-md-4 col-xs-6 numOnly val_model_year"
                                                                   maxlength="4" style="width: 50%;" name="valuation[val_model_year]" id="val_model_year" placeholder="Model Year"/>

                                                            <input value="<?php echo @$enq_data['veh_manf_year'] ?>" type="text" class="form-control col-md-4 col-xs-6 numOnly val_minif_year"
                                                                   maxlength="4" style="width: 50%;" name="valuation[val_minif_year]" id="val_minif_year" placeholder="Mnf Year" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">RC Color</label>
                                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-4 col-xs-6" name="valuation[val_rc_color]" required>
                                                                 <option value="">Colour</option>
                                                                 <?php foreach ( $vehicleColors as $key => $value) { ?>
                                                                      <option <?php echo @$enq_data['veh_color_in_rc']==$value['vc_id']?'selected':''; ?> value="<?php echo $value['vc_id']; ?>"><?php echo $value['vc_color']; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <?php
                                                                $ac=unserialize(AC);
                                                                                                ?>
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">A/C</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select style="width: 50%;" class="form-control col-md-4 col-xs-6" name="valuation[val_ac]" id="val_ac">
                                                                 <option value="">Select A/C</option>
                                                                 <?php foreach ($ac as $key => $value) {?>
                                                                 <option <?php echo @$enq_data['veh_ac']==$key ? 'selected':'veh_ac' ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                                                                
                                                                         <?php } ?>
                                                            </select>
                            <input value="<?php echo @$enq_data['veh_ac_zone'] ?>" type="text" class="form-control col-md-4 col-xs-6 numOnly"
                                                                   style="width: 50%;" name="valuation[val_ac_zone]" id="val_ac_zone" placeholder="No of zone" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Owner(s)</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_owner'] ?>" required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   placeholder="No.of Owner(s)" type="text" name="valuation[val_no_of_owner]" id="val_no_of_owner">
                                                       </div>
                                                  </div>
                                             </div>
                                             <!--                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Manufacture Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_manf_date]" id="val_manf_date">
                                                       </div>
                                                  </div>
                                             </div>-->
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Eng CC</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_cc'] ?>" type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_eng_cc]" 
                                                                   id="val_eng_cc" placeholder="Eng CC"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!-- <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Registration Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_reg_date]" id="val_reg_date">
                                                       </div>
                                                  </div>
                                             </div>-->
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Transmission</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control" name="valuation[val_transmission]" id="val_transmission">
                                                                 <option value="">Select Transmission</option>
                                                                    <?php $transmission= unserialize(transmission);?>
                                                                 <?php foreach ($transmission as $key => $value) {?>
                                                               <option <?php echo @$enq_data['veh_transmission']==$key ? 'selected':''; ?> value="<?php echo $key; ?>"><?php echo $value;?></option>
                                                                 <?php } ?>
                                                                
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Vehicle type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control" name="valuation[val_veh_type]" required>
                                                                 <option value="">Select vehicle type</option>
                                                                 <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) { ?>
                                                                      <option <?php echo @$enq_data['veh_vehicle_type']==$key?'selected':''?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Seats</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" value="<?php echo @$enq_data['veh_seat_no'] ?>" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   placeholder="No.of Seats"  type="text" name="valuation[val_no_of_seats]" id="val_no_of_seats">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <!-- <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Milage</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                                   type="text" name="valuation[val_milage]" id="val_milage">
                                                       </div>
                                                  </div>
                                             </div>-->

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Engine Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_engine_num'] ?>" required="required" class="form-control col-md-7 col-xs-12" 
                                                                   placeholder="Engine Number" type="text" name="valuation[val_engine_no]" id="val_engine_no">
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Chassis Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_chassis_number'] ?>" required="required" class="form-control col-md-7 col-xs-12" 
                                                                   placeholder="Chassis Number" type="text" name="valuation[val_chasis_no]" id="val_chasis_no">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Compressor</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="valuation[val_ac_compressor]">
                                                                 <option value="">Select Compressor </option>
                                                                 <option <?php echo @$enq_data['veh_comprossr']==1?'selected':''?> value="1">Single</option> 
                                                                 <option <?php echo @$enq_data['veh_comprossr']==2?'selected':''?> value="2">Double</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">KM Reading</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['veh_km_from'] ?>" type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_km]" 
                                                                   id="val_km" placeholder="KM Reading" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                       <!-- comment -->
                                        <div class="row">
                                             <!--<div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Camera fine</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="valuation[val_camera_fine]" id="val_camera_fine">
                                                       </div>
                                                  </div>
                                             </div>-->
                                        </div>

                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Insurance</h3>
                                        </div>
                                        <div class="row">
                                             <!-- -->
                                             <table class="table table-striped table-bordered">
                                                  <tr>
                                                       <th>Insurance</th>
                                                       <th>Valid UP to</th>
                                                       <th>IDV Value</th>
                                                  </tr>
                                                  <tr>
                                                       <td>Comprehensive</td>
                                                       <td><input placeholder="Valid UP to (comprehensive)" type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" value="<?php echo @$enq_data['val_insurance_comp_date'] ?>" name="valuation[val_insurance_comp_date]"/></td>
                                                       <td><input placeholder="IDV Value (comprehensive)" type="text" class="form-control col-md-7 col-xs-12 decimalOnly" value="<?php echo @$enq_data['val_insurance_comp_idv'] ?>" name="valuation[val_insurance_comp_idv]"/></td>
                                                  </tr>
                                                  <tr>
                                                       <td>Limited Liability</td>
                                                       <td><input placeholder="Limited Liability (Limited Liability)" type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation"  value="<?php echo @$enq_data['val_insurance_ll_date'] ?>" name="valuation[val_insurance_ll_date]"/></td>
                                                       <td><input placeholder="NCB" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo @$enq_data['val_insurance_ll_idv'] ?>" name="valuation[val_insurance_ll_idv]"/></td>
                                                  </tr>
                                                  <tr>
                                                       <td>NCB need by Customer</td>
                                                       <td><input value="1" type="checkbox" <?php echo @$enq_data['val_insurance_need_ncb']==1?'checked':'' ?> name="valuation[val_insurance_need_ncb]"/></td>
                                                       <td>
                                                            <span style="float: left;">Type</span>  
                                                            <div style="float: left;width: 200px;margin-left: 20px;">
                                                                 <select class="col-md-2 col-xs-5 select2_group form-control"
                                                                         name="valuation[val_insurance]" id="val_insurance">
                                                                      <option value="0">Select Insurance Type</option>
                                                                      <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                                                           <option <?php echo $key==@$enq_data['val_insurance']?'selected':''  ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </div>
                                                       </td>
                                                  </tr>
                                             </table>
                                             <!-- -->
                                             <!--<div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control" name="valuation[val_insurance]" id="val_insurance">
                                                                 <option value="0">Select Insurance Type</option>
                                             <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                                                                                                                                                                                                                                                                                                                                                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                             <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Valid Up to</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   name="valuation[val_insurance_validity]" id="val_insurance_validity" placeholder="Valid Up to"/>
                                                       </div>
                                                  </div>
                                             </div>-->
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Insurance company Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="<?php echo @$enq_data['val_insurance_company'] ?>" type="text" class="form-control col-md-7 col-xs-12 txtValHypoBankBranch" 
                                                                   name="valuation[val_insurance_company]" id="val_hypo_bank_branch" placeholder="Insurance company Name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!--                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">IDV Value</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="valuation[val_insurance_idv]" 
                                                                   id="val_insurance_idv" placeholder="IDV Value"/>
                                                       </div>
                                                  </div>
                                             </div>-->
                                        </div>
                                        <div class="row">
                                             <div class="chk-container">
                                                  <h3 class="border-bottom border-gray pb-2 text-center">Hypothecation Details</h3>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Hypothecation</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12"><input class="chkHypo" type="checkbox"  <?php echo @$enq_data['val_finance']==1 ? 'checked':'' ?> name="valuation[val_finance]" value="1" id="val_finance"/></div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Hypothecation will close by customer</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12"><input class="chkHypoByCust" type="checkbox" <?php echo @$enq_data['val_hypo_close_by_cust']==1 ? 'checked':'' ?> name="valuation[val_hypo_close_by_cust]" value="1" id="val_hypo_close_by_cust"/></div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Bank</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="cmbSearchList select2_group form-control cmbValHypoBank" name="valuation[val_hypo_bank]" id="val_hypo_bank">
                                                                 <option value="">Select bank</option>
                                                                 <?php foreach ($banks as $key => $value) { ?>
                                                                      <option <?php echo $key==@$enq_data['val_hypo_bank']?'selected':''  ?> value="<?php echo $value['bnk_id']; ?>"><?php echo $value['bnk_name']; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Branch</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 txtValHypoBankBranch" 
                                                                   name="valuation[val_hypo_bank_branch]" value="<?php echo @$enq_data['val_hypo_bank_branch'] ?>" id="val_hypo_bank_branch" placeholder="Branch"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan amount</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly txtValHypoLoanAmt" 
                                                                   name="valuation[val_hypo_loan_amt]" value="<?php echo @$enq_data['val_hypo_loan_amt'] ?>" id="val_hypo_loan_amt" placeholder="Loan amount"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation txtValHypoLoanDate" 
                                                                   value="<?php echo @$enq_data['val_hypo_loan_date'] ?>" name="valuation[val_hypo_loan_date]" id="val_hypo_loan_date" placeholder="Loan date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Foreclosure value</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly txtValHypoFrclosVal" 
                                                                   name="valuation[val_hypo_frclos_val]" value="<?php echo @$enq_data['val_hypo_frclos_val'] ?>" id="val_hypo_frclos_val" placeholder="Foreclosure value"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Foreclosure date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation txtValHypoFrclosDate" 
                                                                   name="valuation[val_hypo_frclos_date]" value="<?php echo @$enq_data['val_hypo_frclos_date'] ?>" id="val_hypo_frclos_date" placeholder="Foreclosure date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Daily interest</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly txtValHypoDailyInt" 
                                                                   name="valuation[val_hypo_daily_int]" value="<?php echo @$enq_data['val_hypo_daily_int'] ?>" id="val_hypo_daily_int" placeholder="Daily interest"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan ending date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation txtValHypoLoanEndDate" 
                                                                   name="valuation[val_hypo_loan_end_date]" value="<?php echo @$enq_data['val_hypo_loan_end_date'] ?>" id="val_hypo_loan_end_date" placeholder="Loan ending date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-2 col-sm-3 col-xs-12">Description</label>
                                                       <div class="col-md-9 col-sm-6 col-xs-12">
                                                            <textarea id="val_finance_remark"  class="form-control col-md-7 col-xs-12" 
                                                                      rows="4" name="valuation[val_finance_remark]"> <?php echo @$enq_data['val_finance_remark'] ?> </textarea>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-2 col-sm-3 col-xs-12">Any Top up Loan</label>
                                                       <div class="col-md-9 col-sm-6 col-xs-12">
                                                            <input type="checkbox" <?php echo @$enq_data['val_top_up_loan']==1 ? 'checked':''  ?> name="valuation[val_top_up_loan]" value="1"/>
                                                       </div>
                                                  </div>
                                             </div>

                                       
                                        </div>
                                       <!-- comment -->
                              </div>
<script>
      $('.dtpDatePickerEvaluation').datetimepicker({
          format: "DD-MM-YYYY"
     });
     $('.dtpDatePicker').datetimepicker({
          format: "DD-MM-YYYY"
     });
      $('.hourPicker').datetimepicker({
          format: 'hh:mm A'
     });
     </script>
                                 
                        