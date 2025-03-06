
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
                         <h2>Purchase report</h2>

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
                                                         <option <?php $key == 1 ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $showroom;?></option>
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
                                                  <th colspan="4">Online&OLX</th>
                                                  <th colspan="4">Broker&Refferal</th>
                                                  <th colspan="4">Exchange Sale Reff</th>
                                                  <th colspan="4">Total</th>


                                             </tr>

                                        </thead>
                                        <tbody id="ajx_content"></tbody>
                                   </table>

                              </div>
                         </div>
                         <div class="row">
                              <h5  class="lbl-blk"><center>Enquiry Status with Evaluation
                                                                 </center></h5>
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr "  id="rowClick">
                                        <thead class="t-head">
<!--                                             <tr class="hdr singleline">-->
                                             <tr class="hdr singleline">
                                                  <th>Showroom</th>
                                                  <th>Total Enq</th>
                                                  <th>Not Qualified </th>
                                                  <th>Qualified</th>
                                                  <th>Evaluated</th>
                                                  <th>Pending Eval</th>
                                                  <th>Pending Priceing</th>
                                                  <th>10% of Price Diff Cases  </th>
                                                  <th>20 % of Price Diff Cases </th>
                                                  <th>Purchase </th>
                                                   <th>Evaluation Strick Rate  </th>
                                                    <th>Enquiry  Stricke Rate  </th>
                                             </tr>

                                        </thead>
                                        <tbody id="ajx_enq_sts_evl"></tbody>
                                   </table>

                              </div>
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
                                             <tbody id="ajxTargetAch">

                                             </tbody>
                                        </table>

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
          load_data();
     });
      $(document).ready(function () {
          load_data();
            });
  function load_data()
     {
          $('.divLoading').show();
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/purchase_new_live_enqs');?>",
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    $('#ajx_content').html(data.tableContent);
                  $('#ajx_enq_sts_evl').html(data.tableContent2);
                  $('#ajxTargetAch').html(data.tableContent3); 
                  //ajx_target_ach
//                    $('#ajx_target_this_month').html(data.targetVwThisMonth);
//                    $('#ajxBookingStatus').html(data.bookingStatus);
//                    $('#ajxDeliveryStatus').html(data.deliveryStatus);
//                    $('#ajxStockReport').html(data.stockReport);
//                    $('#ExpBooking').html(data.expectBooking);
//                     $('#ExpDelivery').html(data.expectDelivery);

               }
          });


     }     
</script>

