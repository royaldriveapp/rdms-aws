
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
     .total-tr {background-color: #131212f0 !important;
                color: #57f463 !important;} 
     .percent-tr {background-color: #131212f0 !important;
                  color: #57f463 !important;}

     .bg_abv_121 {
          background-color: #e91111!important;
          color:black;
     }
     .bg_91to120 {
          background-color: #e65000!important;
          color:black;
     }
     .bg_61to90 {
          background-color: #e1ac16!important;
          color:black;
     }
     .bg_31to60 {
          background-color: #52bf3ec7!important;
          color:black;
     }
     .bg_0to30 {
          background-color: #257c23e0!important;
          color:black;
     }
     .t-head{
           background-color:#b19c9c!important;
          color: black;
     }
         .t-head2{
         background-color:#e2e1e1!important;   
          color: black;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Sales report</h2>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row filter">
                              <form action="#" method="get" id="filterForm">
                                   <table>
                                        <td style="margin: 10px;">
                                             <?php $showrooms = unserialize(Showrooms);?>
                                             <select  name="showroom" class="select2_group " >
                                                  <?php foreach ($showrooms as $key => $showroom) {?>
                                                         <option <?php $key == 2 ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $showroom;?></option>
                                                    <?php }?>
                                             </select>
                                        </td>


                                        <td style="margin: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </table>
                              </form>
                         </div>
                         <div class="row">
                             <h5 class="lbl-blk"><center> New & Live  Enquiry</center> </h5> 
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead class="t-head">
<!--                                             <tr class="hdr singleline">-->
                                             <tr class="hdr singleline">
                                                  <th></th>
                                                  <th colspan="4">Walk IN</th>
                                                  <th colspan="4">CUG</th>
                                                  <th colspan="4">Online</th>
                                                  <th colspan="4">Others</th>
                                                  <th colspan="4">Olx</th>
                                                  <th colspan="4">Total</th>


                                             </tr>

                                        </thead>
                                        <tbody id="ajx_content"></tbody>
                                   </table>

                              </div>
                         </div>
                             <div class="row">
                             <h5 class="lbl-blk"><center> Enquiry Status with Home Visit  </center> </h5> 
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead class="t-head">
<!--                                             <tr class="hdr singleline">-->
                                             <tr class="hdr singleline">
                                                   <th></th>
                                                  <th>HOT+</th>
                                                  <th>%</th>
                                                  <th>HOT</th>
                                                  <th>%</th>
                                                  <th>Warm</th>
                                                  <th>%</th>
                                                  <th>Cold</th>
                                                  <th>%</th>
                                                  <th>Total</th>
                                                  <th>Home Vist </th>
                                                  <th>Hot + % </th>
                                                  <th>Hot %</th>
                                                  <th>TTL %</th>
                                                  <th>Total Enquiry Up to Last Q </th>
                                                  <th>Cold Call Calling</th>
                                                   <th>% of re connecting </th>
                                            </tr>

                                        </thead>
                                        <tbody id="ajxStsHomeVstContent"></tbody>
                                   </table>

                              </div>
                         </div>
                         <div class="row">
                              <h5  class="lbl-blk"><center>Target Vs Achivement - 
                                        <?php
                                          $currentMonth = date('F');
                                          echo Date('F', strtotime($currentMonth . " last month"));

                                          echo ' &nbsp;' . Date('Y')
                                        ?> 
                                   </center></h5>
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead class="t-head">
<!--                                             <tr class="hdr singleline">-->
                                             <tr class="hdr singleline">
                                                  <th>Last Month</th>
                                                  <th>Target</th>
                                                  <th>Booking </th>
                                                  <th>Cancelation</th>
                                                  <th>Delivery</th>
                                                  <th>% Of Ach</th>
                                                  <th>Target Vs Booking %</th>
                                                  <th>% of Q Target </th>
                                                  <th>01-03-2020</th>
                                                  <th>YOY %</th>
                                             </tr>

                                        </thead>
                                        <tbody id="ajx_target_last_month"></tbody>
                                   </table>

                              </div>
                         </div>  

                         <div class="row">
                              <h5  class="lbl-blk"><center>Target Vs Achivement - 
                                        <?php
                                          $currentMonth = date('F');
                                          echo Date('F', strtotime($currentMonth . " this month"));

                                          echo ' &nbsp;' . Date('Y')
                                        ?> 
                                   </center></h5>
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead class="t-head">
                                             <tr class="hdr singleline ">
                                                  <th>This Month</th>
                                                  <th>Target</th>
                                                  <th>Booking </th>
                                                  <th>Cancelation</th>
                                                  <th>Delivery</th>
                                                  <th>% Of Ach</th>
                                                  <th>Tager Vs Booking %</th>
                                                  <th>% of Q Target </th>
                                                  <th>01-03-2020</th>
                                                  <th>YOY %</th>
                                             </tr>

                                        </thead>
                                        <tbody id="ajx_target_this_month"></tbody>
                                   </table>

                              </div>

                              <div class="row">
                                   <h5 class="lbl-blk"><center>Booking Status  </center> </h5>
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                             <thead class="t-head">
     <!--                                             <tr class="hdr singleline">-->
                                                  <tr class="hdr singleline ">
                                                       <th></th>
                                                       <th colspan="2">1ST week</th>
                                                       <th colspan="2">2nd week</th>
                                                       <th colspan="2">3rd week</th>
                                                       <th colspan="2">4th week</th>
                                                       <th colspan="2">Month</th>
                                                  </tr>


                                             </thead>
                                             <tbody id="ajxBookingStatus">

                                             </tbody>
                                        </table>

                                   </div>
                              </div>
                              <div class="row">
                                   <h5  class="lbl-blk"><center>Delivery Status </center> </h5>
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                             <thead class="t-head">
     <!--                                             <tr class="hdr singleline">-->
                                                  <tr class="hdr singleline ">
                                                       <th></th>
                                                       <th colspan="2">1ST week</th>
                                                       <th colspan="2">2nd week</th>
                                                       <th colspan="2">3rd week</th>
                                                       <th colspan="2">4th week</th>
                                                       <th colspan="2">Month</th>
                                                  </tr>


                                             </thead>
                                             <tbody id="ajxDeliveryStatus">

                                             </tbody>
                                        </table>

                                   </div>
                              </div>
                              <!-- $ -->
                              <div class="row">
                                   <h5  class="lbl-blk"><center>Stock Report</center> </h5>
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                             <thead class="t-head2">
                                                  <tr class="hdr singleline ">
                                                       <th></th>
                                                       <th>Above 120 Days</th>
                                                       <th>90-120 Days</th>
                                                       <th>60-90 Days</th>
                                                       <th>30-60 Days</th>
                                                       <th>Below 30 Days </th>
                                                       <th>Total </th>

                                                  </tr>


                                             </thead>
                                             <tbody id="ajxStockReport">

                                             </tbody>
                                        </table>

                                   </div>
                              </div>
                              <!-- @ -->
                              <!-- $ -->
                              <div class="row">
                                   <h5  class="lbl-blk"><center>Expect Booking for the day </center> </h5>
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                             <thead class="t-head">
                                                  <tr class="hdr singleline ">
                                                       <th>Sl No</th>
                                                       <th>Date</th>
                                                       <th>Branch</th>
                                                       <th>Enquiry date</th>
                                                       <th>Sales Staff </th>
                                                       <th>ASM </th>
                                                       <th>Customer </th>
                                                       <th> Phone</th>
                                                       <th>Reg No</th>
                                                       <th>Make & Model</th>
                                                       <th>Mode of sales</th>
                                                       <th>Expeted Delivery date</th>
                                                       <th>Remarks</th>

                                                  </tr>


                                             </thead>
                                             <tbody id="ExpBooking">

                                             </tbody>
                                        </table>
                                        <div align="center" class="pagination_link" id="exp_pagination_link"></div>
                                        <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                   </div>
                              </div>
                              <!-- @ -->
                              
                                  <!-- $ -->
                              <div class="row">
                                   <h5  class="lbl-blk"><center>Expect Delivery for the day </center> </h5>
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                             <thead class="t-head">
                                                  <tr class="hdr singleline ">
                                                       <th>Sl No</th>
                                                       <th>Date</th>
                                                       <th>Branch</th>
                                                       <th>Enquiry date</th>
                                                       <th>Sales Staff </th>
                                                       <th>ASM </th>
                                                       <th>Customer </th>
                                                       <th> Phone</th>
                                                       <th>Reg No</th>
                                                       <th>Make & Model</th>
                                                       <th>Mode of sales</th>
                                                       <th>Expected Full payment</th>
                                                 </tr>


                                             </thead>
                                             <tbody id="ExpDelivery">

                                             </tbody>
                                        </table>
                                        <div align="center" class="pagination_link" id="exp_pagination_link"></div>
                                        <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                                   </div>
                              </div>
                              <!-- @ -->
                         </div> 

                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $("#filterForm").submit(function (e) {
          e.preventDefault();
          load_data();
     });
     $(document).ready(function () {
          load_data();
         // exp_booking_data(1);
     });
     function load_data()
     {
          $('.divLoading').show();
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports_1/sales_report');?>",
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    $('#ajx_content').html(data.tableContent);
                    $('#ajx_target_last_month').html(data.targetVwLastMonth);
                    $('#ajx_target_this_month').html(data.targetVwThisMonth);
                    $('#ajxBookingStatus').html(data.bookingStatus);
                    $('#ajxDeliveryStatus').html(data.deliveryStatus);
                    $('#ajxStockReport').html(data.stockReport);
                    $('#ExpBooking').html(data.expectBooking);
                    $('#ExpDelivery').html(data.expectDelivery);
                    $('#ajxStsHomeVstContent').html(data.stsHmVstVw);

               }
          });


     }

     $(document).on('click', '.pagination li a', function (event) {
          event.preventDefault();
          var page = 1;
          if ($(this).attr('href').split('/').pop()) {
               page = $(this).attr('href').split('/').pop();
          } else {

               page = 1;
          }
          if (isNaN(page)) {
               // alert(page +'=Nonum');  
               page = 1;
          }
          exp_booking_data(page);
     });
</script>

