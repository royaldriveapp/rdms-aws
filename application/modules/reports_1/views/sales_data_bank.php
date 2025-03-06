
<style>
     .filter{
          margin-bottom: 10px;
     }
     .btn-round{
          margin-left: 10px;  
     }
     .noDataMessage{
          text-align: center;
     }
     .lbl-blk{
          color: black !important; 
     }
     .tbl{ overflow-x: auto;
           overflow-y: hidden;
     }
     /*      .tbl-blk{
                      background-color:#98cdd9; 
                    border: 3px dotted #fffffff2;
          }*/
     table, th, td {
          border: 1px solid black !important;
     }

     .tbl-pitch{
          background-color:#474a56; 
          border: 4px dotted #fffffff2;
     }
     .bg-clr {
          background-color: #2b27271c !important;
          border: 1px solid #dfe1e6 !important;
          padding: 20px !important;
          box-shadow: 14px 1px 14px 3px #6f81a8f5 !important;
     }
     .singleline { white-space: nowrap; overflow: hidden; text-overflow:ellipsis; }
     .hdr{   
          background-color: #ededed!important;
          color: black!important;
     }
     .total{
          background-color: #F4B084!important;
          color: black!important;  
     }
     .qlt{
          background-color:#ACB9CA!important;
          color: black!important; 
     }

     .td-total{
          background-color: #F8CBAD!important;
          color: black!important;  
     }
     .qlt{
          background-color:#BDD7EE!important;
          color: black!important; 
     }
      .txtBlk{
          color: black !important;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2 class="txtBlk">Sales Data Bank</h2>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row filter">
                              <form action="reports/sales_data_bank_ajx" method="get" id="filterForm">

                                   <td style="margin: 10px;">
                                        <?php
                                          $default_shrm = $this->shrm == 0 ? 1 : $this->shrm;
                                          $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                                          $showrooms = unserialize(Showrooms);
                                        ?>
                                        <select  name="showroom" class="select2_group " >
                                             <?php foreach ($showrooms as $key => $showroom) {?>
                                                    <option <?php echo $key == $default_shrm ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $showroom;?></option>
                                               <?php }?>
                                        </select>
                                   </td>
                                   <td style="margin: 10px;">
                                        <select  name="month" class="select2_group " >
                                             <?php
                                               $mnth = date('m');
                                             ?>
                                             <?php foreach ($months as $key => $month) {?>
                                                    <option <?php echo $key == $mnth ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $month?></option>
                                               <?php }?>
                                        </select>
                                   </td>
                                   <input type="hidden" value="" id="page">

                                   <td style="margin: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>

                              </form>
                         </div>
                         <!--                         <div class="row filter">
                                                       <form action="<?php echo site_url('reports/enquiry_pool_list/1');?>" method="get" id="filterForm">
                                                            <table>
                                                                 <td style="margin: 10px;">
                         <?php $kms = get_km_ranges();?>
                                                                      <select data-placeholder="Select KM" name="km[]" class="select2_group filter-form-control  cmbMultiSelect" multiple>
                         <?php foreach ($kms as $km) {?>
                                                                                                       <option value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>
                           <?php }?>
                                                                      </select>
                                                                 </td>
                                                                 <td style="margin: 20px;">
                                                                      <select data-placeholder="Select Year" name="year[]" class="select2_group filter-form-control cmbMultiSelect" multiple>
                         <?php
                           $earliest_year = YEAR_RANGE_START;
                           $latest_year = date('Y');
                           foreach (range($latest_year, $earliest_year) as $i) {
                                ?>
                                                                                                       <option value="<?php echo $i;?>"><?php echo $i;?></option>
                           <?php }?>  
                                                                      </select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <select data-placeholder="Brand" multiple data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" is-multi-check="1"
                                                                              data-dflt-select="" class="cmbMultiSelect select2_group filter-form-control bindToDropdown" 
                                                                              name="val_brand[]" id="val_brand">
                         <?php
                           if (!empty($brand)) {
                                foreach ($brand as $key => $value) {
                                     ?>
                                                                                                                           <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                     <?php
                                }
                           }
                         ?>
                                                                      </select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <select data-placeholder="Model" multiple data-url="<?php echo site_url('enquiry/bindVarient');?>" is-multi-check="1"
                                                                              data-bind="cmbEvVariant" data-dflt-select="" class="select2_group cmbEvModel cmbMultiSelect
                                                                              filter-form-control bindToDropdown" name="val_model[]" id="val_model"></select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <select multiple class="select2_group filter-form-control cmbEvVariant cmbMultiSelect" is-multi-check="1" 
                                                                              data-placeholder="Varient" name="val_variant[]" id="val_variant"></select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="sales_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Sales Date from" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="sales_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Sales Date to" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="purchase_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Purchase Date from" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="purchase_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Purchase Date to" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                                                 </td>
                                                            </table>
                                                       </form>
                                                  </div>-->
                         <div class="row">
                              <div class="x_panel">
                                   <h2 class="txtBlk">Hot + List </h2>
                                   <div class="table-responsive">
                                        <table class="table table-striped table-borderedjuy bg-clr"  id="rowClick">
                                             <thead >
                                                  <tr class="hdr singleline">
                                                       <th>Sl No</th>
                                                       <th>Customer Name </th>
                                                       <th>Exicutive name</th>
                                                       <th>Phone Number </th>
                                                       <th>Vehicle Details </th>
                                                       <th>Did the Home Visit</th>                                                    
                                                  </tr>

                                             </thead>
                                             <tbody id="ajx_content"></tbody>
                                        </table>
                                        <div align="center" id="pagination_link" data-tbl="tbl1"></div>
                                        <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                   </div>
                              </div>
                         </div>

                         <!--                         <div class="row filter">
                                                       <form action="<?php echo site_url('reports/enquiry_pool_list/1');?>" method="get" id="filterForm">
                                                            <table>
                                                                 <td style="margin: 10px;">
                         <?php $kms = get_km_ranges();?>
                                                                      <select data-placeholder="Select KM" name="km[]" class="select2_group filter-form-control  cmbMultiSelect" multiple>
                         <?php foreach ($kms as $km) {?>
                                                                                                       <option value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>
                           <?php }?>
                                                                      </select>
                                                                 </td>
                                                                 <td style="margin: 20px;">
                                                                      <select data-placeholder="Select Year" name="year[]" class="select2_group filter-form-control cmbMultiSelect" multiple>
                         <?php
                           $earliest_year = YEAR_RANGE_START;
                           $latest_year = date('Y');
                           foreach (range($latest_year, $earliest_year) as $i) {
                                ?>
                                                                                                       <option value="<?php echo $i;?>"><?php echo $i;?></option>
                           <?php }?>  
                                                                      </select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <select data-placeholder="Brand" multiple data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" is-multi-check="1"
                                                                              data-dflt-select="" class="cmbMultiSelect select2_group filter-form-control bindToDropdown" 
                                                                              name="val_brand[]" id="val_brand">
                         <?php
                           if (!empty($brand)) {
                                foreach ($brand as $key => $value) {
                                     ?>
                                                                                                                           <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                     <?php
                                }
                           }
                         ?>
                                                                      </select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <select data-placeholder="Model" multiple data-url="<?php echo site_url('enquiry/bindVarient');?>" is-multi-check="1"
                                                                              data-bind="cmbEvVariant" data-dflt-select="" class="select2_group cmbEvModel cmbMultiSelect
                                                                              filter-form-control bindToDropdown" name="val_model[]" id="val_model"></select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <select multiple class="select2_group filter-form-control cmbEvVariant cmbMultiSelect" is-multi-check="1" 
                                                                              data-placeholder="Varient" name="val_variant[]" id="val_variant"></select>
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="sales_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Sales Date from" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="sales_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Sales Date to" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="purchase_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Purchase Date from" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <input autocomplete="off" name="purchase_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                                             placeholder="Purchase Date to" />
                                                                 </td>
                                                                 <td style="margin: 10px;">
                                                                      <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                                                 </td>
                                                            </table>
                                                       </form>
                                                  </div>-->

                         <?php
                           $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                           $i = 1;
                           foreach ($months as $key => $month) {
                                ?>
                                <div class="row">
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2 class="txtBlk">Booking Vehicle List <small>[<?php echo $month;?>]</small></h2>

                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">

                                                    <div class="row">
                                                         <div class="table-responsive">
                                                              <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                                                   <thead style="background-color: gray; color: white;">
                                                                        <tr class="hdr singleline">
                                                                             <th>Sl No</th> <th>Date in Stock </th>  <th class="">Date Of Booking </th> <th class="">No Of Days in Booking  </th><th class="singleline">Days In Stock </th><th class="singleline">Branch</th> <th class="singleline">Sales Staff </th><th class="singleline">ASM</th><th class="singleline">Custommer Name </th> <th class="singleline">Phone Number </th> <th class="singleline">Reg No </th> 
                                                                             <th class="singleline">Make & Model </th><th class="singleline" >Mode of Deal  </th><th class="singleline" data-th="warm" data-order="DESC">Expecting Full payment  </th><th>Expecting date of delivery  </th><th class="singleline">Delivery Date </th>
                                                                             <th class="singleline">Status</th>
                                                                        </tr>
                                                                   </thead>
                                                                   <tbody id="ajx_content<?php echo $key;?>">  </tbody>
                                                              </table>
                                                              <div align="center" id="pagination_link<?php echo $key;?>" data-id="<?php echo $key;?>" data-tbl="booking-veh"></div>
                                                              <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                </div>

                           <?php }?>
                         <!-- old stock--> 
                         <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2 class="txtBlk">Old Stock<small>[This month]</small></h2>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                             <div class="row">
                                                  <div class="table-responsive">
                                                       <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                                            <thead style="background-color: gray; color: white;">
                                                                 <tr class="hdr singleline">
                                                                      <th>Sl No</th> <th>Stock Date </th>  <th class="">Reg NO  </th> <th class="">Make & Model </th><th class="singleline">Year </th><th class="singleline">KM</th> <th class="singleline">No of Day in Stock  </th><th class="singleline">Action Plan ?</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody id="ajx_content_old_stk">  </tbody>
                                                       </table>
                                                       <div align="center" id="pagination_link_oldStk" data-id="oldStk"></div>
                                                       <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- @old stock-->

                         <!-- Pymnt pndng--> 
                         <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2 class="txtBlk">FC Payment Pending Deals<small>(Do Issued or Vehicle Delivered)</small></h2>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                             <div class="row">
                                                  <div class="table-responsive">
                                                       <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                                            <thead style="background-color: gray; color: white;">
                                                                 <tr class="hdr singleline">
                                                                      <th>Sl No</th> <th>Customer Name </th>  <th class="">Phone Number</th> <th class="">Reg No</th><th class="singleline">Brand & Model  </th><th class="singleline">Date of Delivery </th> <th class="singleline">FC Company </th><th class="singleline">DO Date </th>
                                                                      <th class="singleline">Days from DO</th><th class="singleline">Loan Amount</th><th class="singleline">Sales Branch </th><th class="singleline">Sales Staff </th><th class="singleline">ASM</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody id="ajx_fc_pymnt_pnd">  </tbody>
                                                       </table>
                                                       <div align="center" id="pagination_link_oldStk" data-id="oldStk"></div>
                                                       <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- @pymnt pndng-->
                         <!-- rc pndng--> 
                         <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2 class="txtBlk">RC Transfer Pending List <small>(Above 30 Days)</small></h2>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                             <div class="row">
                                                  <div class="table-responsive">
                                                       <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                                            <thead style="background-color: gray; color: white;">
                                                                 <tr class="hdr singleline">
                                                                      <th>Sl No</th><th>Month</th> <th>Customer Name </th>  <th class="">Phone Number</th> <th class="">Reg No</th><th class="singleline">Brand & Model  </th><th class="singleline">Date of Delivery </th> <th class="singleline">Rc Status  </th><th class="singleline">RTO Office  </th>
                                                                      <th class="singleline">Sales Branch </th><th class="singleline">Sales Staff </th><th class="singleline">ASM</th><th class="singleline">Expe Rc Transfer Date  </th><th class="singleline">Remark</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody id="ajx_rc_pnd">  </tbody>
                                                       </table>
                                                       <div align="center" id="pagination_link_oldStk" data-id="oldStk"></div>
                                                       <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- @rc pndng-->
                         <!-- rc pndng blw--> 
                         <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2 class="txtBlk">RC Transfer Pending List <small>(Bellow 30 Days)</small></h2>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                             <div class="row">
                                                  <div class="table-responsive">
                                                       <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                                            <thead style="background-color: gray; color: white;">
                                                                 <tr class="hdr singleline">
                                                                      <th>Sl No</th><th>Month</th> <th>Customer Name </th>  <th class="">Phone Number</th> <th class="">Reg No</th><th class="singleline">Brand & Model  </th><th class="singleline">Date of Delivery </th> <th class="singleline">Rc Status  </th><th class="singleline">RTO Office  </th>
                                                                      <th class="singleline">Sales Branch </th><th class="singleline">Sales Staff </th><th class="singleline">ASM</th><th class="singleline">Expe Rc Transfer Date  </th><th class="singleline">Remark</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody id="ajx_rc_pnd_blw">  </tbody>
                                                       </table>
                                                       <div align="center" id="pagination_link_oldStk" data-id="oldStk"></div>
                                                       <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- @rc pndng blw-->
                          <!-- insrnc pndng blw--> 
                         <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2 class="txtBlk">Insurance Transfer Pending List   <small>(Above 14 Days After Rc Transfer)</small></h2>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                             <div class="row">
                                                  <div class="table-responsive">
                                                       <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                                            <thead style="background-color: gray; color: white;">
                                                                 <tr class="hdr singleline">
                                                                      <th>Sl No</th><th>Month</th> <th>Customer Name </th>  <th class="">Phone Number</th> <th class="">Reg No</th><th class="singleline">Brand & Model  </th><th class="singleline">Rc Transfer Date </th> <!--<th class="singleline">Rc Status  </th>--> 
                                                                      <th class="singleline">RTO Office  </th>
                                                                      <th class="singleline">Sales Branch </th><th class="singleline">Sales Staff </th><th class="singleline">ASM</th><th class="singleline">Inform the Customer By Writen</th>
                                                                      <th class="singleline">Expe Transfer date </th><th class="singleline">Remark</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody id="ajx_insrnc_pnd">  </tbody>
                                                       </table>
                                                       <div align="center" id="pagination_link_oldStk" data-id="oldStk"></div>
                                                       <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- @insrnc pndng blw-->
                         
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $("#filterForm").submit(function (e) {

          e.preventDefault();
          for (let i = 1; i <= 12; i++) {
               booking_veh_month_wise(1, i);
          }
          var form = $(this);
          var url = form.attr('action');
          var page = $('#page').val();
          $.ajax({
               type: "POST",
               url: site_url + "reports/sales_data_bank_ajx/" + page,
               data: form.serialize(),
               dataType: "JSON",
               beforeSend: function () {
                    //$('.divLoading').show();
               },
               success: function (data) {
                    $('.divLoading').hide();
                    $('#ajx_content').html(data.tableContent);
                    $('#page').val(data.uri_seg);
                    $('#pagination_link').html(data.pagination_link);
               }
          });
          load_old_stk(1);
          fc_payment_pending_deals(1);
          rc_tnsfr_pending_list(1);
          rc_tnsfr_pending_list(2);
          insrnc_pendings();
     });
     $(document).ready(function () {
          load_old_stk(1);
          filter_data(1);
          fc_payment_pending_deals(1);
          rc_tnsfr_pending_list(1);
          rc_tnsfr_pending_list(2);
          insrnc_pendings();

          for (let i = 1; i <= 12; i++) {
               booking_veh_month_wise(1, i);
          }

          function filter_data(page)
          {
               var form = $("#filterForm");
               $.ajax({
                    url: "<?php echo site_url('reports/sales_data_bank_ajx');?>/" + page,
                    method: "POST",
                    dataType: "JSON",
                    data: form.serialize(),
                    success: function (data)
                    {
                         //alert(data.tableContent);
                         $('.divLoading').hide();
                         $('#ajx_content').html(data.tableContent);
                         $('#page').val(data.uri_seg);

                         $('#pagination_link').html(data.pagination_link);
                    }
               });
          }



          function get_filter(class_name)
          {
               var filter = [];
               $('.' + class_name + ':checked').each(function () {
                    filter.push($(this).val());
               });
               return filter;
          }
          $(document).on('click', '.pagination li a', function (event) {
               event.preventDefault();
               var page = 1;
               var tbl = $(this).data("oldStk");
               if ($(this).attr('href').split('/').pop()) {
                    page = $(this).attr('href').split('/').pop();
               } else {

                    page = 1;
               }
               if (isNaN(page)) {
                    page = 1;
               }
               filter_data(page);
//                             for (let i = 1; i <= 12; i++) {
//               booking_veh_month_wise(page, i);
//          }
          });

//          $('.common_selector').click(function () {
//               filter_data(1);
//          });
          /*th sorting $("#rowClick .hdr th").click(function (e) {
           var sortField = $(this).attr("data-th");
           var sortOrder = $(this).attr("data-order");  
           alert(sortField);
           $(this).attr('data-th','7');   
           });
           */
     });
     function booking_veh_month_wise(page, month)
     {
          $('.divLoading').show();
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/booking_veh_month_wise');?>/" + page,
               method: "POST",
               dataType: "JSON",
               data: form.serialize() + "&month=" + month,
               success: function (data)
               {
                    $('.divLoading').hide();
                    if (data.isEmpty === 1) {
                         $('#ajx_content' + data.month).html(data.tableContent);
                    } else {
                         $('#ajx_content' + data.month).html('&nbsp;<span class="singleline cntr">NO DATA FOUND</span>');
                    }

//                         $('#pagination_link' + data.month).html(data.pagination_link);
               }
          });
     }
     function load_old_stk(page)
     {
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/old_stock_report');?>/" + page,
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    $('#ajx_content_old_stk').html(data.oldStkContent);
//                         $('#page').val(data.uri_seg);

//                         $('#pagination_link_oldStk').html(data.pagination_link);
               }
          });
     }
     function fc_payment_pending_deals(page)
     {
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/fc_payment_pending_deals');?>/" + page,
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    $('#ajx_fc_pymnt_pnd').html(data.fcPaymentPendContent);

               }
          });
     }
     function rc_tnsfr_pending_list(isAbv)
     {
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/rc_transfer_pending_list');?>/" + isAbv,
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    if (isAbv == 1) {

                         if (data.isEmpty === 0) {
                              $('#ajx_rc_pnd').html(data.rcTrnfrContent);
                         } else {
                              $('#ajx_rc_pnd').html('&nbsp;<span class="singleline cntr">NO DATA FOUND</span>');
                         }
                    } else if (isAbv == 2) {
                         if (data.isEmpty === 0) {
                              $('#ajx_rc_pnd_blw').html(data.rcTrnfrContent);
                         } else {
                              $('#ajx_rc_pnd_blw').html('&nbsp;<span class="singleline cntr">NO DATA FOUND</span>');
                         }

                    }



               }
          });
     }
     function insrnc_pendings()
     {
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/insrnc_transfer_pending_list');?>",
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    if (data.isEmpty === 0) {
                          $('#ajx_insrnc_pnd').html(data.insrncTrnfrContent);
                         } else {
                              $('#ajx_insrnc_pnd').html('&nbsp;<span class="singleline cntr">NO DATA FOUND</span>');
                         }
                    

               }
          });
     }
</script>

