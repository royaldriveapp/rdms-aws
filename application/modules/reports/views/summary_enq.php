
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
.hdr{    background-color: #DDEBF7!important;
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
background-color:#ACB9CA!important;
    color: black!important; 
}
.td-green{
    background-color: #83F37D!important;  
}
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Sales Summary Enquiry</h2>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row filter">
                              <form action="reports_1/summary_enq" method="get" id="filterForm">
                                  
                                        <td style="margin: 10px;">
                                             <?php 
                                               $default_shrm=$this->shrm==0?1:$this->shrm;
                                                $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                                               $showrooms = unserialize(Showrooms);?>
                                             <select  name="showroom" class="select2_group " >
                                                  <?php foreach ($showrooms as $key => $showroom) {?>
                                                         <option <?php echo $key == $default_shrm ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $showroom;?></option>
                                                    <?php }?>
                                             </select>
                                        </td>
                                          <td style="margin: 10px;">
                                                                                         <select  name="month" class="select2_group " >
                                                  <?php 
                                                  $mnth= date('m');
                                                    ?>
                                                  <?php foreach ($months as $key => $month) {?>
                                                         <option <?php echo $key == $mnth ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $month?></option>
                                                    <?php }?>
                                             </select>
                                        </td>


                                        <td style="margin: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   
                              </form>
                         </div>
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
                                             <select data-placeholder="Brand" multiple data-url="<?php echo site_url('enquiry_new/bindModel');?>" data-bind="cmbEvModel" is-multi-check="1"
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
                                             <select data-placeholder="Model" multiple data-url="<?php echo site_url('enquiry_new/bindVarient');?>" is-multi-check="1"
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
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr"  id="rowClick">
                                        <thead >
                                             <tr class="hdr singleline">
                                                  <th></th> <th colspan="2">Walk in</th>  <th colspan="2">CUG</th> <th colspan="2">Print Adv</th><th colspan="2">WhatsApp</th><th colspan="2">Events</th><th colspan="2">OLX</th> <th colspan="2">Facebook/Insat</th><th colspan="4s">Others</th><th colspan="2">Total</th>  
                                                                                              </tr>
                                                                                               <tr class="hdr singleline">
                                                                                                    <th>Date</th> <th class="total">Total Counts</th><th class="qlt">Quantity Counts</th>  <th class="total">Total Counts</th><th class="qlt">Quantity Counts</th><th class="total">Total Counts</th><th class="qlt">Quantity Counts</th><th class="total">Total Counts</th><th class="qlt">Quantity Counts</th><th class="total">Total Counts</th><th class="qlt">Quantity Counts</th><th class="total">Total Counts</th><th class="qlt">Quantity Counts</th><th class="total">Total Counts</th><th class="qlt">Quantity Counts</th> 
                                                  <th class="qlt">Own</th><th class="qlt">Tele in</th><th class="qlt">Web</th><th class="qlt">Refferal</th><th class="qlt">No of Quality Cases</th><th class="total">Total</th>
                                                                                              </tr>
                                        </thead>
                                        <tbody id="ajx_content"></tbody>
                                   </table>
                                  
                                   <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                              </div>
                         </div>
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
               url: site_url + "reports_1/summary_enq",
               data: form.serialize(),
               dataType: "JSON",
               beforeSend: function () {
                    $('.divLoading').show();
               },
               success: function (data) {
                    $('.divLoading').hide();
                    $('#ajx_content').html(data.tableContent);
                    //$('#pagination_link').html(data.pagination_link);
               }
          });
     });
     $(document).ready(function () {
          filter_data(1);
          function filter_data(page)
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
                    url: "<?php echo site_url('reports_1/summary_enq');?>/" + page,
                    method: "POST",
                    dataType: "JSON",
                    data: form.serialize(),
                    success: function (data)
                    {
                         $('.divLoading').hide();
                         $('#ajx_content').html(data.tableContent);
                         //$('#pagination_link').html(data.pagination_link);
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
               if ($(this).attr('href').split('/').pop()) {
                    page = $(this).attr('href').split('/').pop();
               } else {

                    page = 1;
               }
                 if(isNaN(page)){
                     // alert(page +'=Nonum');  
                      page=1;
             }
               filter_data(page);
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

