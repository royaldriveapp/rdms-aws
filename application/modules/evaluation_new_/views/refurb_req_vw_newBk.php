
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
.bg-gray{
          background-color: #cacaca!important;
     }
     .brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 0px !important;
          border-top-right-radius: 0px !important;
          border-bottom-right-radius: 35px !important;
          border-bottom-left-radius: 35px !important;   
     }
     .h-brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 35px !important;
          border-top-right-radius: 35px !important;
          border-bottom-right-radius: 0px !important;
          border-bottom-left-radius: 0px !important; 

     }
     .dialog {
          /*    width: 746px !important;*/
          /*    margin: 30px auto !important ;*/
          /*    width: 746px !important;*/
     }
     .bg-gray{
          background-color: #cacaca!important;
     }
     .modal-content {
          border: 7px solid rgba(0,0,0,.2)!important;
          border-radius: 42px!important;
     }
     /*.cus-fdbk-content{
      border: 7px solid rgb(205 204 199 / 26%)!important;
     }*/
     .cus-fdbk-content {
          border: 7px solid #cdcbc373!important;
     }
     .lbl{
          color: black !Important;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Refurb request</h2>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
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
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead style="background-color: gray; color: white;">
                                             <tr class="hdr singleline">
                                                    <th class="lbl-blk">Sl No </th>
                                             <th class="lbl-blk">Location  </th>
                                              <th class="lbl-blk">Stock date  </th>
                                             <th class="lbl-blk">Source Of Purchase (Park & Sell or Purchase ) </th>
                                             <th class="lbl-blk">Reg No  </th>
                                             <th class="lbl-blk">Make</th>
                                             <th class="lbl-blk">Model</th>
                                             <th class="lbl-blk">Prod Year </th>
                                             <th class="lbl-blk">KM</th>
                                             <th class="lbl-blk">Refurbing Job List </th>
                                             <th class="lbl-blk">No of days required </th>
                                             <th class="lbl-blk">Job approved or not </th>
                                             <th class="lbl-blk">service given date</th>
                                             <th class="lbl-blk">service return date</th>
                                             <th class="lbl-blk">Service Location </th>
                                             <th class="lbl-blk">Remarks </th>
                                            </tr>
                                        </thead>
                                        <tbody id="ajx_content"></tbody>
                                   </table>
                                   <div align="center" id="pagination_link"></div>
                                   <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

  <!-- popup -->
                         <div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document" >
                                   <div class=" modal-content bg-gray brd-radi cus-fdbk-content">
                                        <?php echo form_open_multipart("evaluation/update_refurb_req_approval", array('id' => "update_home_visit", 'class' => "upd_hm_visit"))?>
                                        <div class="modal-header bg-gray h-brd-radi">
                                             <h5 class="modal-title lbl" id="exampleModalLabel" style="float: left;">Refurb req Approval</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                             </button>
                                        </div>
                                        <div class="modal-body viewEditModel bg-gray brd-radi"></div>
                                        <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary btnCloseModel lbl" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-success btnSubmit">Submit</button>
                                        </div>
                                        <?php echo form_close()?>
                                   </div>
                              </div>
                         </div>
                         <!-- @popup -->

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
                    url: "<?php echo site_url('evaluation/refurb_reqs');?>/" + page,
                    method: "POST",
                    dataType: "JSON",
                    data: form.serialize(),
                    success: function (data)
                    {
                         $('.divLoading').hide();
                         $('#ajx_content').html(data.tableContent);
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

