<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Comapny Vehicle Insurance Renewel</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="datatableFollowup table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <?php if($this->uid == 100) { ?>
                                             <th>Val ID</th>
                                        <?php } ?>
                                        <th>Reg No</th>
                                        <th>Vehicle</th>
                                        <th>Ins Company</th>
                                        <th>Ins Validity</th>
                                        <th>Validity (in days)</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php foreach ((array) $stockVehicle as $key => $value) {
                                        $canedit = check_permission('insurance', 'updateins') ? 'trVOE' : '';
                                        $date1 = date_create($value['val_insurance_comp_date']);
                                        $date2 = date_create(date('Y-m-d'));
                                        $diff = date_diff($date2, $date1);
                                        $days = $diff->format("%r%a");
                                        $color = '';
                                        if ($days <= 8) {
                                             $color = 'background:red;color:#fff !important;';
                                        }
                                        ?>
                                        <tr style="<?php echo $color; ?>" data-url="<?php echo site_url('insurance/updateins/' . encryptor($value['val_id']));?>">
                                             <?php if($this->uid == 100) { ?>
                                                  <td><?php echo $value['val_id'] ?></td>
                                             <?php } ?>
                                             <td class="<?php echo $canedit; ?>"><?php echo $value['val_veh_no'] ?></td>
                                             <td class="<?php echo $canedit; ?>"><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?></td>
                                             <td class="<?php echo $canedit; ?>"><?php echo $value['val_insurance_company'] ?></td>
                                             <td class="<?php echo $canedit; ?>"><?php echo !empty($value['val_insurance_comp_date']) ? date('d-m-Y', strtotime($value['val_insurance_comp_date'])) : ''; ?></td>
                                             <td class="<?php echo $canedit; ?>"><?php echo $days ?></td>
                                        </tr>
                                   <?php } ?>
                              </tbody>
                        </table>
                    </div>
               </div>
          </div>
     </div>
</div>