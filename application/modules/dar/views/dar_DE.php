<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Daily Assesment Report <?php echo date('j M Y')?> of <?php echo $this->session->userdata('usr_username');?></h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="form-horizontal form-label-left">
                              <?php if (!empty($todaysEnquires)) {?>
                                     <div class="form-group">
                                          <h4>1. Enquiries entered today itself</h4>
                                          <div class="table-responsive" style="overflow-x: inherit;">
                                               <table id="datatable" class="table table-striped table-bordered">
                                                    <thead>
                                                         <tr>
                                                              <th>Vehicle</th>
                                                              <th>Customer</th>
                                                              <th>Mobile</th>
                                                              <th>Mode of Contact</th>
                                                              <th>Status</th>
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php
                                                         $hwcStatus = unserialize(ENQUIRY_UP_STATUS);
                                                         $modOfContact = unserialize(MODE_OF_CONTACT);

                                                         foreach ($todaysEnquires as $key => $value) {
                                                              ?>
                                                              <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id']));?>">
                                                                   <td class="trVOE"><?php echo $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['var_variant_name'];?></td>
                                                                   <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                                   <td class="trVOE"><?php echo $value['enq_cus_mobile'];?></td>
                                                                   <td class="trVOE">
                                                                        <?php
                                                                        echo isset($modOfContact[$value["enq_mode_enq"]]) ?
                                                                                $modOfContact[$value["enq_mode_enq"]] : '';
                                                                        ?>
                                                                   </td>
                                                                   <td class="trVOE">
                                                                        <?php
                                                                        echo isset($hwcStatus[$value["enq_cus_when_buy"]]) ?
                                                                                $hwcStatus[$value["enq_cus_when_buy"]] : '';
                                                                        ?>
                                                                   </td>
                                                              </tr> 
                                                         <?php }?>
                                                    </tbody>
                                               </table>
                                               <table class="table table-striped table-bordered" style="margin-top: 57px;">
                                                    <tfoot style="background-color: darkgreen; color: white;">
                                                         <tr>
                                                              <td align="center" colspan="3" ><i class="fa fa-spinner"> TOTAL ENQUIRY : <?php echo count($todaysEnquires);?> </i></td>
                                                              <?php
                                                              foreach ($hwcStatus as $key => $value) {
                                                                   $count = isset($hwc[$key]) ? $hwc[$key] : 0;
                                                                   $per = ($hwcTotal > 0) ? ($count * 100) / $hwcTotal : 0;
                                                                   if ($per >= 80 && $per <= 100) {
                                                                        $battery = 'fa-battery-full';
                                                                   } else if ($per >= 60 && $per < 80) {
                                                                        $battery = 'fa-battery-three-quarters';
                                                                   } else if ($per >= 40 && $per < 60) {
                                                                        $battery = 'fa-battery-half';
                                                                   } else if ($per >= 10 && $per < 40) {
                                                                        $battery = 'fa-battery-1';
                                                                   } else if ($per < 10 && $per > 0) {
                                                                        $battery = 'fa-battery-1';
                                                                   } else if ($per <= 0) {
                                                                        $battery = 'fa-battery-empty';
                                                                   }
                                                                   ?>
                                                                   <td>
                                                                        <i class="fa <?php echo $battery;?>">
                                                                             <?php echo strtoupper($value) . ' : ' . $count;?>
                                                                        </i>
                                                                   </td>
                                                              <?php }?>
                                                         </tr>
                                                    </tfoot>
                                               </table>
                                          </div>
                                     </div>
                                     <br>
                                <?php }?>
                              <form class="form-horizontal form-label-left frmDAR" action="<?php echo site_url('dar/processDar');?>" method="post">
                                   <input type="hidden" name="master[darm_showroom]" value="<?php echo $this->shrm;?>"/>
                                   <input type="hidden" name="master[darm_added_by]" value="<?php echo $this->uid;?>"/>
                                   <div class="form-group">
                                        <h4><?php echo empty($todaysEnquires) ? '1' : '2';?>. Pending</h4>
                                        <label  class="control-label col-md-3 col-sm-3 col-xs-12">Pending works</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <textarea required="true" name="master[darm_pending]" class="form-control col-md-5 col-xs-12 editor"></textarea>
                                        </div>
                                   </div>

                                   <div class="form-group">
                                        <h4><?php echo empty($todaysEnquires) ? '2' : '3';?>. Today's work</h4>
                                        <label  class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <textarea required="true" name="master[darm_remarks]" class="form-control col-md-5 col-xs-12 editor"></textarea>
                                        </div>
                                   </div>
                                   <div class="ln_solid"></div>
                                   <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                             <button type="submit" class="btn btn-success btnDARSubmit">Submit DAR</button>
                                        </div>
                                   </div>    
                              </form>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
