<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Register Summary</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="form_wizard wizard_horizontal">
                              <table class="table table-striped table-bordered" style="margin-left: auto; margin-right: auto;">
                                   <tbody>
                                        <tr>
                                            <td>Customer Name Date</td>
                                            <td><?php echo $trackCard['vreg_cust_name'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Phone number</td>
                                            <td><?php echo $trackCard['vreg_cust_phone'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Email address</td>
                                            <td><?php echo $trackCard['vreg_email'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer place</td>
                                            <td><?php echo $trackCard['vreg_cust_place'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Remarks</td>
                                            <td><?php echo $trackCard['vreg_customer_remark'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Register punched by</td>
                                            <td><?php echo $trackCard['addedby_usr_first_name'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Register punched on</td>
                                            <td><?php echo date('j M Y h:i A', strtotime($trackCard['vreg_first_added_on']));?></td>
                                        </tr>
                                        <tr>
                                            <td>Register assigned to</td>
                                            <td><?php echo $trackCard['assign_usr_first_name'];?></td>
                                        </tr>
                                         <tr>
                                            <td>Customer enquired on</td>
                                            <td><?php echo date('j M Y', strtotime($eventEnq['eve_added_on'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Event title</td>
                                            <td><?php echo $eventEnq['evnt_title'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Vehicle Register No</td>
                                            <td><?php echo $eventEnq['eve_vehicle_selected'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Vehicle</td>
                                            <td><?php echo $eventEnq['brd_title'] . ', ' . $eventEnq['mod_title'] . ', ' . $eventEnq['var_variant_name']; ?></td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>  
                    </div>
               </div>
          </div>
     </div>
</div>