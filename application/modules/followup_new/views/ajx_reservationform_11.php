<div class="popReservationForm_1 modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
          <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="float: left;">Choose vehicle for booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="row">
                         <div class="x_panel">
                              <div class="x_content">
                                   <?php
                                     if (!empty($stockVehicles)) {
                                          ?>
                                          <table id="datatable" class="tblStockVehicle table table-striped table-bordered">
                                               <thead>
                                                    <tr>
                                                         <th>Reg no</th>
                                                         <th>Make</th>
                                                         <th>Model variant</th>
                                                         <th>Year</th>
                                                         <th>Color</th>
                                                         <th>Select</th>
                                                    </tr>
                                               </thead>
                                               <tbody>
                                                    <?php foreach ($stockVehicles as $key => $value) {?>
                                                         <tr>
                                                              <td><?php echo $value['val_veh_no'];?></td>
                                                              <td><?php echo $value['brd_title'];?></td>
                                                              <td><?php echo $value['mod_title'] . ', ' . $value['var_variant_name'];?></td>
                                                              <td><?php echo $value['val_model_year'];?></td>
                                                              <td><?php echo $value['val_color'];?></td>
                                                              <td><i data-url="<?php echo site_url('followup/bindVehicleDetails/' . encryptor($value['val_id']) . '/' . encryptor($enqId));?>" 
                                                                     class="fa fa-arrow-right btnReserveVehicle"></i></td>
                                                         </tr>     
                                                    <?php }?>
                                               </tbody>
                                          </table>
                                     <?php }?>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
               </div>
          </div>
     </div>
</div>

<div class="divVehicleDetails"></div>