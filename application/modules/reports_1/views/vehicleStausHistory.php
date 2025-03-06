<div class="right_col" role="main">
     <div class="">
          <div class="page-title">
               <div class="title_left" style="width: 100%;">
                    <h2>Status details of <?php echo $vehicles['brd_title'] . ', ' . $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name'];?></h2>
               </div>
          </div>
          <div class="clearfix"></div>
          <br/>
          <div class="row">
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Customer Detail</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <table class="table table-striped">
                                   <tbody>
                                        <tr>
                                             <td>Customer Name</td>
                                             <td><?php echo $vehicles['enq_cus_name'];?></td>
                                        </tr>
                                        <tr>
                                             <td> Customer Mobile</td>
                                             <td><?php echo $vehicles['enq_cus_mobile'];?></td>
                                        </tr>
                                        <tr>
                                             <td> Customer Whatsapp</td>
                                             <td><?php echo $vehicles['enq_cus_whatsapp'];?></td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Vehicle Details</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <table class="table table-striped">
                                   <tbody>
                                        <tr>
                                             <td>Brand</td>
                                             <td><?php echo $vehicles['brd_title'];?></td>
                                        </tr>
                                        <tr>
                                             <td>Model</td>
                                             <td><?php echo $vehicles['mod_title'];?></td>
                                        </tr>
                                        <tr>
                                             <td>Variant</td>
                                             <td><?php echo $vehicles['var_variant_name'];?></td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>
               <?php
                 if (isset($vehicles['currentStatus']['sts_value']) && ($vehicles['currentStatus']['sts_value'] != 99 &&
                         $vehicles['currentStatus']['sts_value'] != 3 && $vehicles['currentStatus']['sts_value'] != 7)) {
                      ?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="x_panel">
                                <div class="x_title">
                                     <h2>Comments</h2>
                                     <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                     <form id="demo-form2" method="post"   class="form-horizontal form-label-left" 
                                           enctype="multipart/form-data">
                                          <input type="hidden" name="vst_vehicle_id" value="<?php echo $vehicles['veh_id'];?>"/>
                                          <input type="hidden" name="vst_enq_id" value="<?php echo $vehicles['veh_enq_id'];?>"/>
                                          <input type="hidden" name="est_status" value="11"/>

                                          <p>What executive says</p>
                                          <div class="table-responsive">
                                               <div class="form-group">
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                         <code><?php echo isset($vehicles['currentStatus']['vst_remarks']) ? $vehicles['currentStatus']['vst_remarks'] : '';?></code>
                                                    </div>
                                               </div>
                                          </div>
                                          <?php if (isset($vehicles['soldVehicle']) && !empty($vehicles['soldVehicle'])) {?>
                                               <p>Vehicle for sale</p>
                                               <div class="table-responsive">
                                                    <div class="form-group">
                                                         <div class="col-md-12 col-sm-6 col-xs-12">
                                                              <select class="select2_group form-control" name="vst_evaluation_id" required="required">
                                                                   <option value="">Vehicle</option>
                                                                   <?php foreach ((array) $valuationVehicles as $key => $value) {?>
                                                                        <option value="<?php echo $value['val_id'];?>"
                                                                                <?php echo ($vehicles['soldVehicle']['est_valuation_id'] == $value['val_id']) ? 'selected="selected"' : '';?>>
                                                                                     <?php echo strtoupper($value['val_veh_no']) . ' ' . $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?>
                                                                        </option>
                                                                   <?php }?>
                                                              </select>
                                                         </div>
                                                    </div>
                                               </div>
                                          <?php }?>
                                          <br/>
                                          <?php if (!empty($statusButtons)) {?>
                                               <p>Comments</p>
                                               <div class="table-responsive">
                                                    <div class="form-group">
                                                         <div class="col-md-12 col-sm-6 col-xs-12">
                                                              <textarea name="vst_remarks" type="text" id="enq_cus_name"
                                                                        class="form-control col-md-7 col-xs-12 enq_cus_name" required="true"></textarea>
                                                         </div>
                                                    </div>
                                               </div>
                                               <div class="ln_solid"></div>
                                               <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                         <?php
                                                         foreach ($statusButtons as $key => $value) {
                                                              ?>
                                                              <button type="submit" class="btn btn-round btn-<?php echo $value['buttonClass']?>" 
                                                                      name="vst_status" value="<?php echo $value['id']?>"><?php echo $value['title']?></button>
                                                                 <?php }?>
                                                    </div>
                                               </div>
                                          <?php }?>

                                     </form>
                                </div>
                           </div>
                      </div>
                 <?php }?>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Current Status</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <table class="table table-striped">
                                   <tbody>
                                        <tr>
                                             <td>Customer Executive</td>
                                             <td><?php echo $vehicles['usr_username'];?></td>
                                        </tr>
                                        <tr>
                                             <td>Time</td>
                                             <td><?php echo date('j M Y h:i A', strtotime($vehicles['currentStatus']['vst_added_on']));?></td>
                                        </tr>
                                        <tr>
                                             <td>Current Status</td>
                                             <td><?php echo isset($vehicles['currentStatus']['sts_des']) ? $vehicles['currentStatus']['sts_des'] : '';?></td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Vehicle history</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <ul class="list-unstyled timeline">
                                   <?php
                                     foreach ((array) $vehicles['statuses'] as $key => $value) {
                                          ?>
                                          <li>
                                               <div class="block" style="margin-left: 170px;">
                                                    <div class="tags"  style="width: 150px;">
                                                         <a href="javascript:;" class="tag">
                                                              <span>
                                                                   <?php echo isset($value['vst_added_on']) ? date('j M Y h:i A', strtotime($value['vst_added_on'])) : '';?>
                                                              </span>
                                                         </a>
                                                    </div>
                                                    <div class="block_content">
                                                         <h2 class="title">
                                                              <a><?php echo isset($value['sts_title']) ? $value['sts_title'] : '';?></a>
                                                         </h2>
                                                         <p class="excerpt"><?php echo isset($value['sts_des']) ? $value['sts_des'] : '';?></p>
                                                    </div>
                                               </div>
                                          </li>
                                     <?php }?>
                              </ul>
                         </div>
                    </div>
               </div>

               <?php if (isset($vehicles['soledVehicle']) && !empty($vehicles['soledVehicle'])) {?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="x_panel">
                                <div class="x_title">
                                     <h2>Soled Vehicle</h2>
                                     <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                     <table class="table table-striped">
                                          <tbody>
                                               <tr>
                                                    <td>Soled On</td>
                                                    <td><?php echo date('j M Y h:i A', strtotime($vehicles['soledVehicle']['est_added_on']));?>></td>
                                               </tr>
                                               <tr>
                                                    <td>Registration No</td>
                                                    <td><?php echo $vehicles['soledVehicle']['val_veh_no'];?></td>
                                               </tr>
                                               <tr>
                                                    <td>Brand, Model, Variant</td>
                                                    <td>
                                                         <?php
                                                         echo $vehicles['soledVehicle']['brd_title'] . ', ' .
                                                         $vehicles['soledVehicle']['mod_title'] . ', ' .
                                                         $vehicles['soledVehicle']['var_variant_name'];
                                                         ?>
                                                    </td>
                                               </tr>
                                               <tr>
                                                    <td>Engine No</td>
                                                    <td><?php echo $vehicles['soledVehicle']['val_engine_no'];?></td>
                                               </tr>
                                               <tr>
                                                    <td>Chasis No</td>
                                                    <td><?php echo $vehicles['soledVehicle']['val_chasis_no'];?></td>
                                               </tr>
                                          </tbody>
                                     </table>
                                </div>
                           </div>
                      </div>
                 <?php }?>
          </div>
     </div>
</div>