
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
                         <h2 class="txtBlk">Price list</h2>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row filter">
                              <form action="reports/price_list_bk" method="get" id="filterForm">

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




                         <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2 class="txtBlk"> <small></small></h2>

                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                             <div class="row">
                                                  <div class="table-responsive">
<!--                                                              <table id="example" class="display" cellspacing="0" width="100%">-->
                                                       <table id="example" class="table table-striped table-bordered bg-clr display"  id="rowClick" cellspacing="0" width="100%">
                                                            <thead style="background-color: gray; color: white;">
                                                                 <tr class="hdr singleline">
                                                                      <th>Sl No<span></span></th> <th>Brand <span></span></th>  <th class="">Vehicle<span></span></th> <th class="">Mode<span></span> </th><th class="singleline">Color<span></span></th><th class="singleline">Fuel<span></span></th> <th class="singleline">Mnr Year<span></span></th><th class="singleline">Month & Year of <span></span></th><th class="singleline">Reg no <span></span></th> <th class="singleline">Km <span></span></th> <th class="singleline">No.Owners <span></span></th> 
                                                                      <th class="singleline">INS Date<span></span></th><th class="singleline" >IDV  <span></span></th><th class="singleline" data-th="warm" data-order="DESC">Price  <span></span></th><th>AVG<span></span> </th><th class="singleline">HP <span></span></th>
                                                                      <th class="singleline">Options<span></span></th>
                                                                      <th class="singleline">Booking Date<span></span></th>
                                                                      <th class="singleline">Booked Staff Name<span></span></th>
                                                                      <th class="singleline">Status<span></span></th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody id="ajx_content">  </tbody>
                                                       </table>
                                                       <div align="center" id="pagination_link" data-id="<?php echo $key;?>" data-tbl="booking-veh"></div>
                                                       <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
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
          filter_data(1);

     });
     $(document).ready(function () {
       filter_data(1);
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
     function filter_data(page)
     {
          alert(255);
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/price_list_bk');?>/" + page,
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

 //////
 
 
 
 
 ///////


</script>

