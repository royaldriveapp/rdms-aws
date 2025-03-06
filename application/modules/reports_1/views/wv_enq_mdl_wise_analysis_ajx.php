  <div class="row">
                          
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead class="t-head">
<!--                                             <tr class="hdr singleline">-->
                                             <tr class="hdr singleline">
                                                  <th style="width:20%">Model Intrested</th>
                                                  <?php foreach ($staffs as $key => $staff) {?>
                                                <th style="width:10%" class="verticalText"><?php echo $staff['satff_name'] ?></th>
                                                 <?php } ?>
                                                  <th style="width:10%" class="verticalText">Grand Total<?php// echo $vehs['frm_date'].'-'.$vehs['to_date']?></th>
                                                                                                 
                                             </tr>

                                        </thead>
                                        <tbody>
                                             <?php  foreach ($vehs['vehData'] as $key => $veh) {
                                                    
                                             ?>
                                             <tr class="lbl-blk">
                                                  <td><?php //echo $veh['veh_model'];?> <?php echo $veh['mod_title'];?></td>
                                                   <?php 
                                                     $sum=0;
                                                     foreach ($staffs as $key => $staff) {
                                                         $enqs= $this->reports->getEnqCountByStaffAndMdl($staff['usr_id'],$veh['veh_model'],$vehs['frm_date'],$vehs['to_date']);
                                                         $sum+=$enqs['count'];
                                                        ?>
                                                  
                                                  <td> <?php //echo 'staff:-'.$staff['usr_id'] ?> <?php echo $enqs['count']; ?></td>
                                                    <?php } ?>
                                                 
                                                  <td> <?php echo $sum; ?></td>
                                                                                                 
                                             </tr>
                                             <?php } ?>
                                         
                                        </tbody>
                                   </table>

                              </div>
                         </div>  