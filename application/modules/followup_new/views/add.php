<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New enquiry</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <!-- Smart Wizard -->
                         <!--<p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>-->
                         <form id="wizard" data-url="<?php echo site_url('enquiry/add'); ?>" class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                              <ul class="wizard_steps">
                                   <li>
                                        <a href="#step-1">
                                             <span class="step_no">1</span>
                                             <span class="step_descr">
                                                  Step 1<br />
                                                  <small>Customer enquiry</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-2">
                                             <span class="step_no">2</span>
                                             <span class="step_descr">
                                                  Step 3<br />
                                                  <small>Vehicle details</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-3">
                                             <span class="step_no">3</span>
                                             <span class="step_descr">
                                                  Step 2<br />
                                                  <small>Mode of payment</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-4">
                                             <span class="step_no">4</span>
                                             <span class="step_descr">
                                                  Step 4<br />
                                                  <small>Follow up</small>
                                             </span>
                                        </a>
                                   </li>
                              </ul>
                              <div id="step-1">
                                   <div class="form-horizontal form-label-left">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input name="enquiry[enq_cus_name]" type="text" id="first-name" class="form-control col-md-7 col-xs-12" required>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_address" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_address]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_mobile" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="enquiry[enq_cus_mobile]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_email" class="form-control col-md-7 col-xs-12 emailOnly" type="text" name="enquiry[enq_cus_email]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">Whatsapp</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_whatsapp" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="enquiry[enq_cus_whatsapp]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_fbid" class="control-label col-md-3 col-sm-3 col-xs-12">Customer FB Id</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_fbid" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_fbid]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12">Age group</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control" name="enquiry[enq_cus_age_group]">
                                                            <?php foreach (unserialize(CUST_AGE_GROUP) as $key => $value) { ?>
                                                                   <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                              <?php } ?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_occu" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_occu" class="autoComOccupation form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_occu]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_company" class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_company" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_company]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_phone_res" class="control-label col-md-3 col-sm-3 col-xs-12">Resi phone</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_phone_res" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_phone_res]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_country" class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_country" class="autoComCountry form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_country]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_state" class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_state" class="autoComState form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_state]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_dist" class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_dist" class="autoComDistrict form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_dist]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_city" class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_city" class="autoComCity form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_city]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_pin" class="control-label col-md-3 col-sm-3 col-xs-12">Pin</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_pin" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_pin]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_presenet_vehicle" class="control-label col-md-3 col-sm-3 col-xs-12">Which vehicle are you using presently?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_presenet_vehicle" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_presenet_vehicle]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_family_members" class="control-label col-md-3 col-sm-3 col-xs-12">How many members in your family?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_family_members" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_family_members]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_vehicle_user" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be the user of this vehicle?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_vehicle_user" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_vehicle_user]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_money" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be spend money?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_money" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_money]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_authority" class="control-label col-md-3 col-sm-3 col-xs-12">Who will be the authority?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_authority" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_authority]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_need" class="control-label col-md-3 col-sm-3 col-xs-12">Who needs this vehicle?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_need]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_when_buy" class="control-label col-md-3 col-sm-3 col-xs-12">When would you like to buy?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control" name="enquiry[enq_cus_when_buy]">
                                                            <option value="1">Hot</option>
                                                            <option value="2">Warm</option>
                                                            <option value="3">Cool</option>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_test_drive" class="control-label col-md-3 col-sm-3 col-xs-12">Test drive</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="checkbox" class="js-switch" name="enquiry[enq_cus_test_drive]" value="1"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control cmbEnqStatus" name="enquiry[enq_cus_status]">
                                                            <option value="1">Sell</option>
                                                            <option value="2">Buy</option>
                                                            <option value="3">Exchange</option>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Mod of enquiry</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" class="form-control col-md-7 col-xs-12" name="enquiry[enq_mode_enq]"/>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div id="step-2">
                                   <h2 class="StepTitle lblSale" style="width: 100%;">Sales<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsSale"></span></h2>
                                   <div class="table-responsive divVehDetailsSale">
                                        <table id="datatable-responsive" class="vehDetailsSale table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                             <thead>
                                                  <tr>
                                                       <th>Brand</th>
                                                       <th>Model</th>
                                                       <th>Variant</th>
                                                       <th>Fual</th>
                                                       <th>Year</th>
                                                       <th>Color</th>
                                                       <th>Price from</th>
                                                       <th>Price to.</th>
                                                       <th>Km from</th>
                                                       <th>Km to</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <tr>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[sale][veh_brand][]">
                                                                 <?php foreach ($brands as $key => $value) { ?>
                                                                        <option value="<?php echo $value['brd_id'] ?>"><?php echo $value['brd_title'] ?></option>
                                                                   <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[sale][veh_model][]">
                                                                 <?php foreach ($model as $key => $value) { ?>
                                                                        <option value="<?php echo $value['mod_id'] ?>"><?php echo $value['mod_title'] ?></option>
                                                                   <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[sale][veh_varient][]">
                                                                 <?php foreach ($variant as $key => $value) { ?>
                                                                        <option value="<?php echo $value['var_id'] ?>"><?php echo $value['var_variant_name'] ?></option>
                                                                   <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) { ?>
                                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                   <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[sale][veh_year][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_color][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[sale][veh_price_from][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[sale][veh_price_to][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[sale][veh_km_from][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[sale][veh_km_to][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="6">
                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">
                                                       </td>
                                                       <td colspan="5">
                                                            <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_owner][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="11">
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                                                       </td>
                                                  </tr>
                                             </tbody>
                                        </table>
                                   </div>
                                   <h2 class="StepTitle lblBuy" style="width: 100%;">Buy<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsBuy"></span></h2>
                                   <div class="table-responsive divVehDetailsBuy">
                                        <table id="datatable-responsive" class="vehDetailsBuy table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                             <thead>
                                                  <tr>
                                                       <th>Brand</th>
                                                       <th>Model</th>
                                                       <th>Variant</th>
                                                       <th>Fual</th>
                                                       <th>Year</th>
                                                       <th>Color</th>
                                                       <th>Price from</th>
                                                       <th>Price to.</th>
                                                       <th>Km from</th>
                                                       <th>Km to</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <tr>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[buy][veh_brand][]">
                                                                 <option value="1">Sell</option>
                                                                 <option value="2">Buy</option>
                                                                 <option value="3">Exchange</option>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[buy][veh_model][]">
                                                                 <option value="1">Sell</option>
                                                                 <option value="2">Buy</option>
                                                                 <option value="3">Exchange</option>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[buy][veh_varient][]">
                                                                 <option value="1">Sell</option>
                                                                 <option value="2">Buy</option>
                                                                 <option value="3">Exchange</option>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) { ?>
                                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                   <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_year][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_color][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_price_from][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_price_to][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_km_from][]">
                                                       </td>
                                                       <td>
                                                            <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_km_to][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="4">
                                                            <input placeholder="Customeer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_exch_cus_expect][]">
                                                       </td>
                                                       <td colspan="4">
                                                            <input placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_exch_estimate][]">
                                                       </td>
                                                       <td colspan="3">
                                                            <input placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_exch_dealer_value][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="6">
                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">
                                                       </td>
                                                       <td colspan="5">
                                                            <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_owner][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="11">
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                                                       </td>
                                                  </tr>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>
                              <div id="step-3">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="enq_cus_loan_perc" class="control-label col-md-3 col-sm-3 col-xs-12">Loan percentage</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_perc" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="enquiry[enq_cus_loan_perc]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_amount" class="control-label col-md-3 col-sm-3 col-xs-12">Loan amount</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_amount" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="enquiry[enq_cus_loan_amount]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_emi" class="control-label col-md-3 col-sm-3 col-xs-12">Loan EMI</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="enquiry[enq_cus_loan_emi]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_period" class="control-label col-md-3 col-sm-3 col-xs-12">Loan total period</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_period" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="enquiry[enq_cus_loan_period]">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div id="step-4">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="followup[foll_status]">
                                                       <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) { ?>
                                                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                         <?php } ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="foll_remarks" class="form-control col-md-7 col-xs-12" type="text" name="followup[foll_remarks]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="followup[foll_contact]">
                                                       <?php foreach (unserialize(MODE_OF_CONTACT) as $key => $value) { ?>
                                                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                         <?php } ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next action plan</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="foll_action_plan" class="form-control col-md-7 col-xs-12" type="text" name="followup[foll_action_plan]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next follow up date</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" id="single_cal2" placeholder="First Name" name="followup[foll_next_foll_date]">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>