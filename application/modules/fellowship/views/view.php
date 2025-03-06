<div class="right_col" role="main">
     <div class="">
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <?php// print_r($master); ?>
                              <h2>Fellowship (<?php echo unserialize(WEB_FORM_ENQ_TYPE)[$master['web_enq_type']] ?>) </h2>
                              &nbsp; &nbsp; 
                              <!-- <a class="btn btn-info" href="<?php echo site_url('fellowship/convert'); ?>/<?php echo $master['web_id']?>"> <i class="fa fa-exchange" style="font-size:15px;color:green"></i> Convert</a> -->
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">

                              <div class="panel-group">

                                   <div class="panel panel-default">
                                        <!-- <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#basic">Category/source/remarks<span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div> -->
                                        <div id="basic" class="panel-collapse collapse in">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <th>Category</th>
                                                            <th>Source of Enquiry</th>
                                                            <th>Customer Remarks</th>


                                                       </thead>
                                                       <tbody>
                                                            <tr>


                                                                 <td><?php echo  $master['web_category'] == 1 ? 'Luxury' : ($master['web_category'] == 2 ? 'Smart' : ''); ?></td>

                                                                 <td><?php echo unserialize(MODE_OF_CONTACT)[$master['web_source_of_enq']] ?></td>

                                                                 <td><?php echo $master['web_remarks']; ?></td>

                                                            </tr>
                                                       </tbody>
                                                  </table>
                                                  <!-- <ul class="list-group">
          <li class="list-group-item"><b>Name</b>: Jaefar sadikh</li>
          <li class="list-group-item">Two</li>
          <li class="list-group-item">Three</li>
        </ul> -->
                                                  <div class="panel-footer"></div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#collapse1">Login details <span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse in">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>


                                                       </thead>
                                                       <tbody>
                                                            <tr>


                                                                 <td><?php echo $master['added_usr_username']; ?></td>

                                                                 <td><?php echo $master['web_usr_email']; ?></td>

                                                                 <td><?php echo $master['web_usr_phone']; ?></td>

                                                            </tr>
                                                       </tbody>
                                                  </table>

                                                  <div class="panel-footer"></div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#collapse2">Customer info <span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div>
                                        <div id="collapse2" class="panel-collapse collapse in">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Gender</th>
                                                            <th>Address</th>
                                                            <th>Distict</th>
                                                            <th>Pin</th>
                                                            <th>Occupation</th>


                                                       </thead>
                                                       <tbody>
                                                            <tr>


                                                                 <td><?php echo $master['web_name']; ?></td>

                                                                 <td><?php echo $master['web_email']; ?></td>

                                                                 <td><?php echo $master['web_gender'] == 1 ? 'Male' : 'Female'; ?></td>
                                                                 <td><?php echo $master['web_address']; ?></td>
                                                                 <td><?php echo $master['std_district_name']; ?></td>
                                                                 <td><?php echo $master['web_pin']; ?></td>
                                                                 <td><?php echo $master['occ_cat_name']; ?> / <?php echo $master['occ_name']; ?></td>

                                                            </tr>
                                                       </tbody>
                                                  </table>
                                                  <div class="panel-footer"></div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#collapse4">Contact No <span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div>
                                        <div id="collapse4" class="panel-collapse collapse">
                                             <ul class="list-group">

                                                  <?php foreach ($phone_numbers as $key => $phone) : ?>
                                                       <li class="list-group-item"><b>Phone <?php echo $key + 1; ?></b>: <?php echo $phone['webph_phone']; ?></li>
                                                  <?php endforeach; ?>
                                                  <?php if (!empty($master['web_whatsapp'])) : ?>
                                                       <li class="list-group-item"><b>WhatsApp</b>: <?php echo $master['web_whatsapp']; ?></li>
                                                  <?php endif; ?>

                                             </ul>
                                             <div class="panel-footer"></div>

                                        </div>
                                   </div>

                                   <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#collapse3">Social Media <span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div>
                                        <div id="collapse3" class="panel-collapse collapse">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <?php if (!empty($master['web_youtube'])) : ?><th>Youtube</th><?php endif; ?>
                                                            <?php if (!empty($master['web_fb'])) : ?><th>Facebook</th><?php endif; ?>
                                                            <?php if (!empty($master['web_insta'])) : ?><th>Instagram</th><?php endif; ?>
                                                            <?php if (!empty($master['web_twitter'])) : ?><th>Twitter</th><?php endif; ?>
                                                            <?php if (!empty($master['web_linkedin'])) : ?><th>Linkedin</th><?php endif; ?>
                                                       </thead>
                                                       <tbody>
                                                            <tr>
                                                                 <?php if (!empty($master['web_youtube'])) : ?><td><?php echo $master['web_youtube']; ?></td><?php endif; ?>
                                                                 <?php if (!empty($master['web_fb'])) : ?><td><?php echo $master['web_fb']; ?></td><?php endif; ?>
                                                                 <?php if (!empty($master['web_insta'])) : ?><td><?php echo $master['web_insta']; ?></td><?php endif; ?>
                                                                 <?php if (!empty($master['web_twitter'])) : ?><td><?php echo $master['web_twitter']; ?></td><?php endif; ?>
                                                                 <?php if (!empty($master['web_linkedin'])) : ?><td><?php echo $master['web_linkedin']; ?></td><?php endif; ?>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                                  <div class="panel-footer"></div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#collapse_man">MAN <span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div>
                                        <div id="collapse_man" class="panel-collapse collapse">
                                             <div class="table-responsive">
                                                  <table class="table table-striped table-bordered bg-clr">
                                                       <thead>
                                                            <tr>
                                                                 <th class=" form-control-enq"> </th>
                                                                 <th class="lbl-blk">Name</th>
                                                                 <th class="lbl-blk">Phone</th>
                                                                 <th class="lbl-blk">Relation</th>
                                                                 <th class="lbl-blk">Remarks</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <tr>
                                                                 <th class="lbl-blk">Money</th>
                                                                 <td><?php echo $money['webman_name']; ?></td>
                                                                 <td><?php echo $money['webman_phone']; ?></td>
                                                                 <td><?php echo $money['webman_relation']; ?></td>
                                                                 <td><?php echo $money['webman_remarks']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                 <th class="lbl-blk">Need</th>
                                                                 <td><?php echo $need['webman_name']; ?></td>
                                                                 <td><?php echo $need['webman_phone']; ?></td>
                                                                 <td><?php echo $need['webman_relation']; ?></td>
                                                                 <td><?php echo $need['webman_remarks']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                 <th class="lbl-blk">Authority</th>
                                                                 <td><?php echo $authority['webman_name']; ?></td>
                                                                 <td><?php echo $authority['webman_phone']; ?></td>
                                                                 <td><?php echo $authority['webman_relation']; ?></td>
                                                                 <td><?php echo $authority['webman_remarks']; ?></td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                                  <div class="panel-footer"></div>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- family -->

                                   <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#collapse_family">Family details <span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div>
                                        <div id="collapse_family" class="panel-collapse collapse">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <th>Name</th>
                                                            <th>Relation</th>
                                                            <th>Occupation</th>
                                                            <th>Age</th>


                                                       </thead>
                                                       <tbody>
                                                            <?php foreach ($family as $fmly) : ?>
                                                                 <tr>

                                                                      <td><?php echo $fmly['web_fml_name']; ?></td>
                                                                      <td><?php echo $fmly['web_fml_relation']; ?></td>
                                                                      <td><?php echo $fmly['web_fml_occu']; ?></td>
                                                                      <td><?php echo $fmly['web_fml_age']; ?></td>

                                                                 </tr>
                                                            <?php endforeach; ?>
                                                       </tbody>
                                                  </table>

                                                  <div class="panel-footer"></div>
                                             </div>
                                             <div class="panel-footer"></div>

                                        </div>
                                   </div>
                                   <!-- End family -->

                                   <!-- Pitched vehicle -->
                                   <?php if (!empty($pitchedVeh)) : ?>
                                   <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title">
                                                  <a data-toggle="collapse" href="#collapse_Pitched">Pitched vehicle <span class="glyphicon glyphicon-plus"></span></a>
                                             </h4>
                                        </div>
                                        <div id="collapse_Pitched" class="panel-collapse collapse">
                                          
                                                  <div class="table-responsive">
                                                       <table class="table">
                                                            <thead>
                                                                 <th>Brad</th>
                                                                 <th>Model</th>
                                                                 <th>Variant</th>
                                                                 <th>Budget</th>
                                                                 <th>Ownership</th>


                                                            </thead>
                                                            <tbody>
                                                                 <?php foreach ($pitchedVeh as $pitched) : ?>
                                                                      <tr>
                                                                           <td><?php echo $pitched['brd_title']; ?></td>
                                                                           <td><?php echo $pitched['mod_title']; ?></td>
                                                                           <td><?php echo $pitched['var_variant_name']; ?></td>
                                                                           <td><?php echo $pitched['pr_range']; ?></td>
                                                                           <td><?php echo $pitched['web_pi_ownership']; ?></td>
                                                                      </tr>
                                                                 <?php endforeach; ?>
                                                            </tbody>
                                                       </table>

                                                       <div class="panel-footer"></div>
                                                  </div>
                                            
                                             <div class="panel-footer"></div>

                                        </div>
                                   </div>
                                   <?php endif; ?>
                                   <!-- End Pitched vehicle -->

                                   <!-- asso vehicle -->
                                   <?php if (!empty($assoVeh)): ?>
<div class="panel panel-default">
     <div class="panel-heading">
          <h4 class="panel-title">
               <a data-toggle="collapse" href="#collapse_asso">Vehicle Associated with custome <span class="glyphicon glyphicon-plus"></span></a>
          </h4>
     </div>
     <div id="collapse_asso" class="panel-collapse collapse">
    
          <div class="table-responsive">
               <table class="table">
                    <thead>
                         <th>Brad</th>
                         <th>Model</th>
                         <th>Variant</th>
                         <th>Registration No</th>
                         <th>Insurance Validity</th>


                    </thead>
                    <tbody>
                    <?php foreach ($assoVeh as $asso): ?>
<tr>
<td><?php echo $asso['brd_title']; ?></td>
<td><?php echo $asso['mod_title']; ?></td>
<td><?php echo $asso['var_variant_name']; ?></td>
<td><?php echo $asso['web_asso_reg_no']; ?></td>
<td><?php echo $asso['web_asso_insurance_validity']; ?></td>
</tr>
<?php endforeach; ?>
                    </tbody>
               </table>

               <div class="panel-footer"></div>
          </div>
        
          <div class="panel-footer"></div>

     </div>
</div>
<?php endif; ?>
<!-- End asso vehicle -->

<!-- purchase vehicle -->
<?php if (!empty($purchaseVeh)): ?>
<div class="panel panel-default">
     <div class="panel-heading">
          <h4 class="panel-title">
               <a data-toggle="collapse" href="#collapse_purchase">Purchase Vehicle <span class="glyphicon glyphicon-plus"></span></a>
          </h4>
     </div>
     <div id="collapse_purchase" class="panel-collapse collapse">

          <div class="table-responsive">
               <table class="table">
                    <thead>
                         <th>Brad</th>
                         <th>Model</th>
                         <th>Variant</th>
                         <th>Ownership</th>
                         <th>Insurance Company</th>
                         <th>Insurance Validity</th>
                         <th>License Plate</th>
                         <th>KM</th>
                   </thead>
                    <tbody>
                    <?php foreach ($purchaseVeh as $purchase): ?>
<tr>
<td><?php echo $purchase['brd_title']; ?></td>
<td><?php echo $purchase['mod_title']; ?></td>
<td><?php echo $purchase['var_variant_name']; ?></td>
<td><?php echo $purchase['web_purch_ownersip']; ?></td>
<td><?php echo unserialize(insurance_company)[$purchase['web_purch_insurance_comp']]; ?></td>
<td><?php echo $purchase['web_purch_insurance_validity']; ?></td>
<td><?php echo $purchase['web_purch_license_plate']; ?></td>
<td><?php echo $purchase['web_purch_km']; ?></td>
</tr>
<?php endforeach; ?>
                    </tbody>
               </table>

               <div class="panel-footer"></div>
          </div>
          
          <div class="panel-footer"></div>

     </div>
</div>
<?php endif; ?>
<!-- End purchase vehicle -->

<!-- rf -->
<?php if (!empty($rfDetails)): ?>
<div class="panel panel-default">
     <div class="panel-heading">
          <h4 class="panel-title">
               <a data-toggle="collapse" href="#rf">Job to be done <span class="glyphicon glyphicon-plus"></span></a>
          </h4>
     </div>
     <div id="rf" class="panel-collapse collapse">
          <div class="table-responsive">
               <table class="table">
                    <thead>
                         <th>Job details</th>
                         


                    </thead>
                    <tbody>
                    <?php foreach ($rfDetails as $rf): ?>
<tr>
<td><?php echo $rf['web_rf_details']; ?></td>

</tr>
<?php endforeach; ?>
                    </tbody>
               </table>

               <div class="panel-footer"></div>
          </div>
   
          <div class="panel-footer"></div>

     </div>
</div>
<!-- End rf -->
<?php endif; ?>


                              </div>



                         </div>
                         <form action="<?php echo site_url('fellowship/addToReg'); ?>" method="post" class="form-horizontal" onsubmit="disableSubmitButton()">
    <div class="form-group">
        <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <select <?php echo ($this->usr_grp != 'TC') ? 'required' : '';?> class="select2_group form-control" name="vreg_customer_status" id="vreg_customer_status">
                    <option value="">Please select customer status</option>
                    <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) {?>
                           <option value="<?php echo $key;?>"><?php echo $value;?></option>
                      <?php }?>
               </select>
        </div>
    </div>

    <input type="hidden" name="web_id" value="<?php echo $master['web_id']?>">

  
    <div class="form-group">
        <label for="vreg_division" class="control-label col-md-3 col-sm-3 col-xs-12">Division 
            <?php echo isset($mandatory['vreg_division']) ? '<span class="required">*</span>' : '';?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division"
                                                          data-url="<?php echo site_url('enquiry/bindShowroomByDivision');?>" data-bind="cmbShowroom" 
                                                          <?php echo isset($mandatory['vreg_division']) ? 'required' : '';?> data-dflt-select="Select Showroom">
                                                       <option value="">Select division</option>
                                                       <?php
                                                         foreach ($division as $key => $value) {
                                                              ?>
                                                              <option value="<?php echo $value['div_id'];?>"><?php echo $value['div_name'];?></option>
                                                              <?php
                                                         }
                                                       ?>
                                                  </select>
        </div>
    </div>

    <div class="form-group">
        <label for="vreg_showroom" class="control-label col-md-3 col-sm-3 col-xs-12">Showroom <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select required class="select2_group form-control cmbShowroom shorm_stf" name="vreg_showroom" id="vreg_showroom">
                <option value="">Select showroom</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="vreg_department" class="control-label col-md-3 col-sm-3 col-xs-12">Departments 
            <?php echo isset($mandatory['vreg_department']) ? '<span class="required">*</span>' : '';?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select <?php echo isset($mandatory['vreg_department']) ? 'required' : '';?> class="select2_group form-control cmbDepartment" name="vreg_department" id="vreg_department">
                <option value="">Select departments</option>
                <!-- Insert PHP loop to generate department options -->
            </select>
        </div>
    </div>
    <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
               <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <?php if (check_permission('registration', 'canselfassignregister')) { ?>
                      <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                           <option value="">Select executive</option>
                           <option value="<?php echo $this->uid;?>">Self</option>
                           <?php foreach ($salesExe as $key => $value) {?>
                                <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>                                               
                           <?php }?>
                      </select>
                 <?php } else {?>
                      <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                           <option value="">Select executive</option>
                           <?php foreach ($salesExe as $key => $value) {?>
                                <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>                                               
                           <?php }?>
                      </select>
                 <?php }?>
          </div>
     </div>

    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
        </div>
    </div>
</form>

                    </div>
               </div>
          </div>
     </div>
</div>
<script>
        function disableSubmitButton() {
            // Disable the submit button to prevent multiple submissions
            document.getElementById("submitBtn").disabled = true;
        }


    </script>