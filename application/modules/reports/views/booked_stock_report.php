<!--- add loop -- for month wise table jsk-->
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
      .tbl-blk{
                 background-color:#98cdd9; 
               border: 3px dotted #fffffff2;
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
.cntr{text-align: center;}

.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #23252242 !important;
}
  .delivered{
       background-color: #bde9ba;
     }
      .cancelled{
       background-color: #ea111126;
     }
     .rejected{
       background-color: #ea11114a;
     }
     body{
              color: #0d0e0f!important;
     }
</style>


<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booked Stock report [ <?php echo date("Y"); ?> ]</h2>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
<!--                         <div class="row filter">
                              <form action="<?php echo site_url('reports_1/enquiry_pool_list/1');?>" method="get" id="filterForm">
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
  $i=1;
  foreach ($months as $key=>$month){?>
                    <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2><?php echo $month; ?></h2>
                                            <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                         <div class="row">
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead style="background-color: gray; color: white;">
                                             <tr class="hdr singleline">
                                                  <th>Sl No</th> <th>Location</th>  <th class="">Stock date</th> <th class="">Booked date </th><th class="singleline">Source Of Purchase</th><th class="singleline">Reg No</th> <th class="singleline">Make</th><th class="singleline">Model</th><th class="singleline">variant</th> <th class="singleline">Prod Year </th> <th class="singleline">KM</th> 
                                                  <th class="singleline">Sales staff</th><th class="singleline" >Mode of Purchase </th><th class="singleline" data-th="warm" data-order="DESC">Expected date of Delivery </th><th>PDI Work Date </th><th class="singleline">Approved Order Refurbishment Job</th>
                                                  <th class="singleline">Pending Refurb Job</th><th class="singleline">Remark</th><th class="singleline">If Cancelled , Cancelation date </th><th class="singleline">Reason for  Cancellation </th><th class="singleline">No Of Days in Booking </th>
                                             </tr>
                                        </thead>
                                        <tbody id="ajx_content<?php echo $key; ?>">  </tbody>
                                   </table>
                                   <div align="center" id="pagination_link<?php echo $key; ?>" data-id="<?php echo $key; ?>"></div>
                                   <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

 <?php } ?>
                    </div>
               </div>
          </div>
     </div>
 
     
     
</div>

<script>
     $("#filterForm").submit(function (e) {

          e.preventDefault();

          var form = $(this);
          var url = form.attr('action');

          $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(),
               dataType: "JSON",
               beforeSend: function () {
                    $('.divLoading').show();
               },
               success: function (data) {
                    $('.divLoading').hide();
                    $('#ajx_content').html(data.tableContent);
                    $('#pagination_link').html(data.pagination_link);
               }
          });
     });
     $(document).ready(function () {
    
         // console.log(jkhjhkj);
         // alert(month_names);
         for (let i = 1; i <= 12; i++) {
                filter_data(1,i);
         }
        
       
        //  filter_data(1,2);
          function filter_data(page,month)
          {
               $('.divLoading').show();
               var form = $("#filterForm");
               var action = 'fetch_data';
               var minimum_price = $('#hidden_minimum_price').val();
               var maximum_price = $('#hidden_maximum_price').val();
               var brand = get_filter('brand');
               var ram = get_filter('ram');
               var storage = get_filter('storage');
               $.ajax({
                    url: "<?php echo site_url('reports_1/booked_stock_report');?>/" + page,
                    method: "POST",
                    dataType: "JSON",
                    data: form.serialize()+ "&month="+month,
                    success: function (data)
                    {
                         $('.divLoading').hide();
                        if (data.isEmpty===1){   
                             $('#ajx_content'+data.month).html(data.tableContent);
                         }else{
                              $('#ajx_content'+data.month).html('&nbsp;<span class="singleline cntr">NO DATA FOUND</span>');
                         }
                        
                         $('#pagination_link'+data.month).html(data.pagination_link);
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
 //   var $div = $(this).closest('div[data-id]'); 
//var did = $div.data('id');
var month  = $(this).closest('div[data-id]').data('id')

               if ($(this).attr('href').split('/').pop()) {
                    page = $(this).attr('href').split('/').pop();
               } else {

                    page = 1;
               }
                 if(isNaN(page)){
                     // alert(page +'=Nonum');  
                      page=1;
             }
               filter_data(page,month);
          });

          $('.common_selector').click(function () {
               filter_data(1);
          });
         /*th sorting $("#rowClick .hdr th").click(function (e) {
               var sortField = $(this).attr("data-th");
                var sortOrder = $(this).attr("data-order");  
               alert(sortField);
                $(this).attr('data-th','7');   
          });
            */
     });
</script>

