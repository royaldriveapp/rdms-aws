<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2> Preference List</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="datatableFollowup table table-striped table-bordered">
                              <thead>
                                   <?php $vehicleTypes = unserialize(ENQ_VEHICLE_TYPES); ?>
                                   <tr>
                                        <th>Customer Name</th>
                                        <th>Mobile No</th>
                                        <th>Preferences</th>
                                        <th>Sales staff</th>
                                        <th>Added by</th>
                                        <th>Added on</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                       
                                     foreach ((array) $preferences as $key => $value) {                                          
                                          $now = date('Y-m-d'); ?>
                                          <tr title="<?php echo empty($value['prf_id']) ? 'Pending to set followup date' : '';?>"
                                              style=""
                                              data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($value['prf_id']));?>">
                                               <td class="trVOE"><?php //echo strtoupper($value['prf_enq_id']); 
                                               echo $value['enq_cus_name']?></td>
                                               <td class="trVOE"><?php //echo strtoupper($value['prf_enq_id']); 
                                               echo $value['enq_cus_mobile']?></td>
                                             <?php //$prfDta=unserialize($value['prf_data']);
                                                   //  print_r(@$prfDta['colors_description'][$key]);
                                                     ?>
                                               <td><?php  if($value['prf_key']==1){
                                                             $color= $this->followup->getColors($value['prf_value']);
                                                             echo'<b>Color</b>:'. $color.' ('.$value['prf_description'].')';
                                                                
                                                        }if($value['prf_key']==2){
                                                           echo'<b>Registration</b>:'. $value['prf_value'].' ('.$value['prf_description'].')';
                                                                
                                                        }if($value['prf_key']==3){
                                                             $otherState=$this->followup->getStates($value['prf_value']);
                                                           echo'<b>Other state</b>:'.  $otherState.' ('.$value['prf_description'].')';
                                                                
                                                        }if($value['prf_key']==4){
                                                              $vehicleTypes=unserialize(ENQ_VEHICLE_TYPES);
                                                               $vehType=$vehicleTypes[$value['prf_value']];
                                                           echo'<b>Vehicle type</b>:'.  $vehType.' ('.$value['prf_description'].')';
                                                        } if ($value['prf_key'] == 5) {
                                                       $rto = $this->followup->getRto($value['prf_value']);
                                                       echo'<b>RTO</b>:' . $rto['rto_reg_num'] . '-' . $rto['rto_place'] . ' (' . $value['prf_description'] . ')';
                                                  }
                                                        ?></td>
                                               <td><?php
                                                    $salesStaff=$this->followup->getSalesStaff($value['enq_se_id']);
                                                 echo $salesStaff?></td>
                                               <td class="trVOE"><?php echo ($value['prf_addded_by'] == $this->uid) ? 'Self' : $value['enq_added_by_name'];?></td>
                                               <td class="trVOE"><?php echo date('j M Y', strtotime($value['prf_added_on']));?></td>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>