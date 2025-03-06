<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Create Invoice Stock ID : <b><?php echo $valDetails['val_stock_num']; ?></b></h2>
                         <!--<i style="cursor: pointer;" class="fa fa-plus btnNewRefurbishJob"></i>-->

                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                   <ul class="dropdown-menu" role="menu">
                                        <li><a target="blank" href="<?php echo site_url('evaluation/printevaluation/' . encryptor($vehicles['val_id'])); ?>">Valuation</a></li>
                                   </ul>
                              </li>
                         </ul>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/refurbisheReturn", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left")) ?>
                         <input type="hidden" name="evaluationId" value="<?php echo $valDetails['val_id'] ?>" />
                         <!-- -->
                         <table class="toptable table table-stripedk table-borderedj">
                              <tbody>
                                   <tr class="top-tbl-tr">
                                        <td><b>Vehicle Registration NO</b></td>
                                        <td>
                                             <?php echo strtoupper(str_replace('-', '', $valDetails['val_veh_no'])); ?>
                                        </td>
                                        <td><b>Vehicle Make & Model</b></td>
                                        <td>
                                             <?php echo $valDetails['brd_title'] . ', ' . $valDetails['mod_title'] . ', ' . $valDetails['var_variant_name']; ?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td><b>Date of Evaluation</b></td>
                                        <td>
                                             <?php echo date('d-m-Y', strtotime($valDetails['val_valuation_date'])); ?>
                                        </td>
                                        <td><b>Purchase Type</b></td>
                                        <td>
                                             <?php
                                             $purchaseTypes = unserialize(EVALUATION_TYPES);
                                             echo isset($purchaseTypes[$valDetails['val_type']]) ? $purchaseTypes[$valDetails['val_type']] : '';
                                             ?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td><b>Bill Number</b></td>
                                        <td><input required type="text" name="m[vum_bill_no]" id="evnt_title" placeholder="Enter Bill Number here" /></td>
                                        <td><b>Bill Date</b></td>
                                        <td><input required type="text" class="dtpDatePicker" name="m[vum_bill_date]" id="evnt_title" placeholder="Enter Bill Date here" /></td>
                                   </tr>
                                   <tr>
                                        <td><b>Party</b></td>
                                        <td>
                                             <select required style="border: none;" name="m[vum_vendor]">
                                                  <option value="">Select party</option>
                                                  <?php foreach ($vendors as $id => $sstation) { ?>
                                                       <option value="<?php echo $sstation['ven_id']; ?>"><?php echo $sstation['ven_name']; ?></option>
                                                  <?php } ?>
                                             </select>
                                        </td>
                                        <td>GST Applicable</td>
                                        <td>
                                             <!--Yes <input required name="m[vum_gst_apbl]" type="radio" value="1"/> No <input name="m[vum_gst_apbl]" required type="radio" value="0"/>-->
                                             <label class="radio-inline">
                                                  <input required type="radio" class="rdoGSTYesNo" name="m[vum_gst_apbl]" value="1" /> &nbsp; &nbsp; Yes
                                             </label>
                                             <label class="radio-inline">
                                                  <input required type="radio" class="rdoGSTYesNo" name="m[vum_gst_apbl]" value="0" /> &nbsp; &nbsp; No
                                             </label>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td colspan="4">
                                             <textarea min="20" placeholder="Remarks" name="m[vum_remarks]" class="form-control col-md-7 col-xs-12 text-left"><?php echo $valDetails['brd_title'] . ', ' . $valDetails['mod_title'] . ', ' . $valDetails['var_variant_name']; ?></textarea>
                                        </td>
                                   </tr>
                              </tbody>
                         </table>
                         <?php if (!empty($vehicles['upgradeDetails'])) { ?>
                              <div style="width:100%;overflow-x: scroll;">
                                   <table cellpadding="0" ; cellspacing="0" class="tblUpgradeDetails tblRefurb" style="width:100%;white-space: nowrap;">
                                        <tr>
                                             <th></th>
                                             <th>SL NO</th>
                                             <th>Refurbish job in evaluation</th>
                                             <th>Estimated cost</th>
                                             <?php if (check_permission('evaluation', 'candorefurbreturn')) { ?>
                                                  <th>Actual job description</th>
                                                  <th>Actual cost</th>
                                                  <th>SGST(%)</th>
                                                  <th>SGST</th>
                                                  <th>CGST(%)</th>
                                                  <th>CGST</th>
                                                  <th>IGST(%)</th>
                                                  <th>IGST</th>
                                                  <th>Description</th>
                                                  <th>Expence type</th>
                                                  <th>Actual/Estimate</th>
                                             <?php } ?>
                                        </tr>
                                        <?php
                                        foreach ($vehicles['upgradeDetails'] as $key => $value) {
                                        ?>
                                             <tr>
                                                  <td><input type="checkbox" class="chkNeedToPost" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_is_done]" value="1" /></td>
                                                  <td width="50"><?php echo $key + 1; ?>
                                                       <input type="hidden" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_id]" value="<?php echo $value['upgrd_id'] ?>" />
                                                       <input type="hidden" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_refurb_master]" value="<?php echo $value['upgrd_refurb_master'] ?>" />
                                                  </td>
                                                  <td style="width: 100%;background:#f5f3f3;"><?php echo $value['upgrd_key']; ?></td>
                                                  <td style="background:#f5f3f3;">
                                                       <input readonly type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_value]" value="<?php echo $value['upgrd_value']; ?>" />
                                                  </td>
                                                  <?php if (check_permission('evaluation', 'candorefurbreturn')) { ?>
                                                       <td><input style="width:400px;" type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][actual_job_desc]" value="<?php echo $value['actual_job_description'] ?>" /></td>
                                                       <td>
                                                            <input type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][newcost]" value="<?php echo $value['upgrd_refurb_actual_cost'] > 0 ? $value['upgrd_refurb_actual_cost'] : ''; ?>" class="decimalOnly" />
                                                       </td>
                                                       <td><input type="text" class="gstmandatory sgstp decimalOnly" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][sgstp]" value="<?php echo $value['upgrd_sgstp'] > 0 ? $value['upgrd_sgstp'] : ''; ?>" /></td>
                                                       <td><input type="text" class="gstmandatory sgst decimalOnly" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][sgst]" value="<?php echo $value['upgrd_sgst'] > 0 ? $value['upgrd_sgst'] : ''; ?>" /></td>
                                                       <td><input type="text" class="gstmandatory cgstp decimalOnly" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][cgstp]" value="<?php echo $value['upgrd_cgstp'] > 0 ? $value['upgrd_cgstp'] : ''; ?>" /></td>
                                                       <td><input type="text" class="gstmandatory cgst decimalOnly" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][cgst]" value="<?php echo $value['upgrd_cgst'] > 0 ? $value['upgrd_cgst'] : ''; ?>" /></td>
                                                       <td><input type="text" class="igstp decimalOnly" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][igstp]" value="<?php echo $value['upgrd_igstp'] > 0 ? $value['upgrd_igstp'] : ''; ?>" /></td>
                                                       <td><input type="text" class="igst decimalOnly" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][igst]" value="<?php echo $value['upgrd_igst'] > 0 ? $value['upgrd_igst'] : ''; ?>" /></td>
                                                       <td><input type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][desc]" value="<?php echo $value['upgrd_refurb_remarks'] ?>" /></td>
                                                       <td>
                                                            <select style="border: none;" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_expence_type]">
                                                                 <option value="">Expence type</option>
                                                                 <?php foreach ($expenceType as $id => $expty) { ?>
                                                                      <option value="<?php echo $expty['ven_id']; ?>" <?php echo ($expty['ven_id'] == $value['upgrd_expence_type']) ? "selected" : ''; ?>>
                                                                           <?php echo $expty['ven_name']; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <!-- 1 => Actual
                                                            2 => Estimate -->
                                                            <select style="border: none;" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_act_est]">
                                                                 <option value="">Select one</option>
                                                                 <option value="1" <?php echo ($value['upgrd_act_est'] == 1) ? "selected" : ''; ?>>RF Expense incurred</option>
                                                                 <option value="2" <?php echo ($value['upgrd_act_est'] == 2) ? "selected" : ''; ?>>RF Addl Expected</option>
                                                            </select>
                                                       </td>
                                                  <?php } ?>
                                             </tr>
                                        <?php
                                        }
                                        ?>
                                   </table>
                              </div>
                         <?php
                         } else {
                              echo '<div>No records found</div>';
                         }
                         ?>
                         <!-- -->
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <?php if (!empty($vehicles['upgradeDetails'])) { ?>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                   <?php } ?>
                              </div>
                         </div>
                         <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>
<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong>Updated successfully!</strong>
</div>

<script>
     var d = '<?php
               if (check_permission('evaluation', 'candorefurbreturn')) {
                    echo 1;
               }
               ?>';
     <?php
     $sstationsJson = json_encode($vendors);
     echo "var sstations = " . $sstationsJson . ";\n";

     $expenceTypeJson = json_encode($expenceType);
     echo "var expenceType = " . $expenceTypeJson . ";\n";
     ?>
     $(document).ready(function() {
          $('.dtpDMY').datetimepicker({
               format: "DD-MM-YYYY"
          });
     });

     $(document).on('click', '.btnNewRefurbishJob', function(e) {

          var cmbSstation =
               '<td><select required name="newRefrubishjob[serviceat][]" style="border: none;"><option value="">Service at</option>';
          $.each(sstations, function(index, value) {
               cmbSstation = cmbSstation + '<option value="' + value.ven_id + '">' + value.ven_name +
                    '</option>';
          });
          cmbSstation = cmbSstation + '</select></td>';

          var cmbExpenceType =
               '<td><select required name="newRefrubishjob[upgrd_expence_type][]" style="border: none;"><option value="">Expence type</option>';
          $.each(expenceType, function(index, value) {
               cmbExpenceType = cmbExpenceType + '<option value="' + value.ven_id + '">' + value.ven_name +
                    '</option>';
          });
          cmbExpenceType = cmbExpenceType + '</select></td>';

          var estActu = '<td> <select required style = "border: none;" name = "newRefrubishjob[upgrd_act_est][]" > ' +
               '<option value="2"> Estimate </option> <option value="1" > Actual </option> </select> </td>'
          if (d) {
               var tmp = '<tr><td></td>' +
                    '<td><input type="text" name="newRefrubishjob[refurb_job][]" class=""/></td>' +
                    '<td><input type="number" max="<?php echo get_settings_by_key('refurb_max_amt'); ?>" name="newRefrubishjob[refurb_job_cost][]" class="decimalOnly"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[actual_job_desc][]" class=""/></td>' +
                    '<td><input type="number" max="<?php echo get_settings_by_key('refurb_max_amt'); ?>" name="newRefrubishjob[newcost][]" class="decimalOnly"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[sgstp][]" class="sgstp"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[sgst][]" class="sgst"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[cgstp][]" class="cgstp"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[cgst][]" class="cgst"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[igstp][]" class="igstp"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[igst][]" class="igst"/></td>' +
                    '<td><input type="text" name="newRefrubishjob[desc][]" class=""/></td>' + cmbSstation +
                    '<td><input required type="text" name="newRefrubishjob[billno][]"/></td>' +
                    '<td><input required type="text" name="newRefrubishjob[billdt][]" class="dtpDMY"/></td>' + cmbExpenceType + estActu + '</tr>';
          } else {
               var tmp = '<tr><td></td>' +
                    '<td><input type="text" name="newRefrubishjob[refurb_job][]" class=""/></td>' +
                    '<td><input type="number" max="<?php echo get_settings_by_key('refurb_max_amt'); ?>" name="newRefrubishjob[refurb_job_cost][]" class="decimalOnly"/></td>' +
                    '</tr>';
          }

          $('.tblUpgradeDetails tbody tr:last').after(tmp);
          $('.dtpDMY').datetimepicker({
               format: "DD-MM-YYYY"
          });
     });
     $("#frmAccessories").submit(function(e) {
          e.preventDefault();
          var form = $(this);
          var url = site_url + '<?php echo $controller ?>/refurbisheReturn';
          $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(),
               dataType: "json",
               beforeSend: function() {
                    $('.divLoading').show();
                    $(".btn-success").attr("disabled", true);
               },
               success: function(data) {
                    location.href = site_url + 'evaluation/printevaluation/' + <?php echo $valDetails['val_id']; ?>;
               }
          });
     });
     $(document).on('keyup', '.sgstp', function(e) {
          var p = parseFloat($(this).val());
          if (p > 0) {
               var amt = parseFloat($(this).closest('td').prev('td').find('input').val());
               var sgst = (amt * p) / 100;
               $(this).closest('td').next('td').find('input').val(sgst);
          } else {
               $(this).closest('td').next('td').find('input').val('');
          }
     });
     $(document).on('keyup', '.cgstp', function(e) {
          var p = parseFloat($(this).val());
          if (p > 0) {
               var amt = parseFloat($(this).closest('td').prev('td').prev('td').prev('td').find('input').val());
               var cgst = (amt * p) / 100;
               $(this).closest('td').next('td').find('input').val(cgst);
          } else {
               $(this).closest('td').next('td').find('input').val('');
          }
     });

     $(document).on('keyup', '.igstp', function(e) {
          var p = parseFloat($(this).val());
          if (p > 0) {
               var amt = parseFloat($(this).closest('td').prev('td').prev('td').prev('td').prev('td').prev('td').find(
                    'input').val());
               var igst = (amt * p) / 100;
               $(this).closest('td').next('td').find('input').val(igst);
          } else {
               $(this).closest('td').next('td').find('input').val('');
          }
     });
     $(document).on('change', '.chkNeedToPost', function(e) {
          if ($(this).is(":checked")) {
               $(this).closest('td').next('td').next('td').next('td').next('td').find('input').prop("required", true);
               $(this).closest('td').next('td').next('td').next('td').next('td').next('td').find('input').prop("required", true);
               $(this).closest('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').find('select').prop("required", true);
               $(this).closest('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').find('select').prop("required", true);
          } else {
               $(this).closest('td').next('td').next('td').next('td').next('td').find('input').prop("required", false);
               $(this).closest('td').next('td').next('td').next('td').next('td').next('td').find('input').prop("required", false);
               $(this).closest('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').find('select').prop("required", false);
               $(this).closest('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').next('td').find('select').prop("required", false);
          }
     });

     $(document).on('change', '.rdoGSTYesNo', function(e) {
          if ($(this).val() == 1) {
               $('.tblUpgradeDetails tr').each(function() {
                    var $checkbox = $(this).find('.chkNeedToPost');
                    var $textboxes = $(this).find('.gstmandatory');
                    // Check if the checkbox is checked
                    if ($checkbox.is(':checked')) {
                         // Check if mandatory textboxes are empty
                         $textboxes.each(function() {
                              $(this).prop("required", true);
                         });
                    }
               });
          } else {
               $('.tblUpgradeDetails tr').each(function() {
                    var $checkbox = $(this).find('.chkNeedToPost');
                    var $textboxes = $(this).find('.gstmandatory');
                    // Check if the checkbox is checked
                    if ($checkbox.is(':checked')) {
                         $textboxes.each(function() {
                              $(this).prop("required", false);
                         });
                    }
               });
          }
     });
</script>
<style>
     /*white-space:nowrap;*/
     .tblRefurb {
          width: 100%;
     }

     input {
          border: 0px solid #000;
          margin: 0;
          background: transparent;
          width: -webkit-fill-available;
     }

     .tblUpgradeDetails tr td {
          border: 1px solid #000;
          padding: 0px 5px 0px 5px;
          white-space: nowrap;
     }

     .tblUpgradeDetails tr th {
          border: 1px solid #000;
          padding: 3px;
          text-align: center;
          background: #eee;
     }

     /*table{background: #fff none repeat scroll 0 0;border-left: 1px solid #000;border-top: 1px solid #000;}*/
     /*table tr:nth-child(even){background:#ccc;}*/
     /*table tr:nth-child(odd){background:#eee;}*/
</style>