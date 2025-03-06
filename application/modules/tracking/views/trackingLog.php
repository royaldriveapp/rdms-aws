<div class="right_col" role="main">
     <div class="">
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">

                              <?php
                                $brand = isset($evaliationDetails['brd_title']) ? $evaliationDetails['brd_title'] : '';
                                $model = isset($evaliationDetails['mod_title']) ? $evaliationDetails['mod_title'] : '';
                                $varnt = isset($evaliationDetails['var_variant_name']) ? $evaliationDetails['var_variant_name'] : '';
                              ?>

                              <h2>Vehicle tracking log of <?php echo $brand . ', ' . $model . ', ' . $varnt;?></h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <ul class="list-unstyled timeline">
                                   <?php
                                     foreach ($vehicleTrackLog as $key => $value) {
                                          if (!empty($value['trk_check_in_date'])) {//
                                               ?>
                                               <li>
                                                    <div class="block" style="margin-left: 180px;">
                                                         <div class="tags" style="width: 150px;">
                                                              <a href="javascript:;" class="tag">
                                                                   <span><?php echo $value['trk_check_in_date'];?></span>
                                                              </a>
                                                         </div>
                                                         <div class="block_content">
                                                         <h2 class="title">
                                                                   <a>
                                                                        <i>Tracking No</i> : <?php
                                                                        echo empty($value['trk_number']) ? $value['trk_number'] :
                                                                                $value['trk_number'];
                                                                        ?>
                                                                   </a>
                                                              </h2>
                                                              <h2 class="title">
                                                                   <a>
                                                                        <i>Location</i> : <?php
                                                                        echo empty($value['trk_check_in_other_place']) ? $value['checkin_by_tmp_show'] :
                                                                                $value['trk_check_in_other_place'];
                                                                        ?>
                                                                   </a>
                                                              </h2>
                                                              <div class="excerpt">
                                                                   <div><i>Vehicle Dropped By </i> : <?php
                                                                        echo empty($value['trk_check_in_other_driver']) ? $value['checkin_driver_first_name'] :
                                                                                $value['trk_check_in_other_driver'];
                                                                        ?></div>
                                                                   <div><i>Check in KM</i> : <?php echo $value['trk_check_in_km'];?></div>
                                                                   <div><i>Purpose</i> : <?php echo $value['trk_out_pass_purpose'];?></div>
                                                                   <div><i>Check in by</i> : <?php echo $value['checkin_by_first_name'];?></div>
                                                              </div>
                                                         </div>
                                                    </div>
                                               </li>
                                          <?php }?>
                                          <li>
                                               <div class="block" style="margin-left: 180px;">
                                                    <div class="tags" style="width: 150px;">
                                                         <a href="javascript:;" class="tag">
                                                              <span><?php echo $value['trk_out_pass_time'];?></span>
                                                         </a>
                                                    </div>
                                                    <div class="block_content">
                                                    <h2 class="title">
                                                                   <a>
                                                                        <i>Tracking No</i> : <?php
                                                                        echo empty($value['trk_number']) ? $value['trk_number'] :
                                                                                $value['trk_number'];
                                                                        ?>
                                                                   </a>
                                                              </h2>
                                                         <h2 class="title">
                                                              <a>
                                                                   <i>Location</i> : 
                                                                   <?php
                                                                   if (empty($value['trk_out_pass_to_place'])) {
                                                                        $from = !empty($value['added_by_tmp_show']) ? 
                                                                                $value['added_by_tmp_show'] : $value['checkout_from'];
                                                                        
                                                                        echo $from . ' => ' . $value['checkin_by_tmp_show'];
                                                                   } else {
                                                                        $from = !empty($value['added_by_tmp_show']) ? 
                                                                                $value['added_by_tmp_show'] : $value['checkout_from'];
                                                                        echo $from . ' => ' . $value['trk_out_pass_to_place'];
                                                                   }
                                                                   ?>
                                                              </a>
                                                         </h2>
                                                         <div class="excerpt">
                                                              <div><i>Vehicle Pickup By</i> : <?php
                                                                   echo empty($value['trk_out_pass_other_driver']) ? $value['usr_first_name'] :
                                                                           $value['trk_out_pass_other_driver'];
                                                                   ?></div>
                                                              <div><i>Out pass KM</i> : <?php echo $value['trk_out_pass_km'];?></div>
                                                              <div><i>Purpose</i> : <?php echo $value['trk_out_pass_purpose'];?></div>
                                                              <div><i>Issued by</i> : <?php echo $value['added_first_name'];?></div>
                                                         </div>
                                                    </div>
                                               </div>
                                          </li>
                                     <?php } if (!empty($evaliationDetails)) { ?>
                                          <li>
                                               <div class="block" style="margin-left: 180px;">
                                                    <div class="tags" style="width: 150px;">
                                                         <a href="javascript:;" class="tag">
                                                              <span><?php echo strtoupper($evaliationDetails['val_veh_no']);?></span>
                                                         </a>
                                                    </div>
                                                    <div class="block_content">
                                                         <h2 class="title">
                                                              <a>
                                                                   <i>Location</i> : <?php echo $evaliationDetails['shr_address']; ?>
                                                              </a>
                                                         </h2>
                                                         <div class="excerpt">
                                                              <div><i>KM</i> : <?php echo $evaliationDetails['val_km'];?></div>
                                                              <div><i>Vehicle Evaluated By </i> : <?php echo $evaliationDetails['usr_first_name'];?></div>
                                                              <div><i>Evaluated On</i> : <?php echo $evaliationDetails['val_added_date'];?></div>
                                                         </div>
                                                    </div>
                                               </div>
                                          </li>
                                     <?php }?>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>