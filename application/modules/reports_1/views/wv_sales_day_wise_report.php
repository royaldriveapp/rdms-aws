
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
          border: 10px solid #dfe1e6 !important;
          /*   border:3px dotted whitesmoke !important;*/
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
          background-color:#AEAAAA!important;
          color: black;
     }
     .t-head2{
          background-color:#e2e1e1!important;   
          color: black;
     }
     .bg-own{
          background-color:#ACB9CA!important;   
          color: black;   
     }
     .bg-rd{
          background-color:#F8CBAD!important;   
          color: black;   
     }
     table, th, td {
          border: 1px solid #00000030  !important;
          border-collapse: collapse !important;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Daily Sales report </h2>

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
                              <h5  class="lbl-blk"><center>Minutes of the meeeting of DOMM
                                        <?php
                                          $today = date("l");
                                          echo ' <br><br>' . $today . '&nbsp;|&nbsp;' . Date('d-m-Y') . '&nbsp;|&nbsp;' . date('h:i:sa');
                                        ?> 
                                   </center></h5>
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered bg-clr tbl"  id="rowClick">
                                        <thead class="t-head">
<!--                                             <tr class="hdr singleline">-->
                                             <tr class="hdr singleline">
                                                  <th>Emp Name</th>
                                                  <th>Yesterdays' Achievement</th>
                                                  <th>Todays' Plan </th>
                                                  <th>Bottle Neck</th>
                                                  <th>Any help from Mgmnt</th>
                                                  <th>Monthly Target</th>
                                                  <th>Target Achievement</th>


                                             </tr>

                                        </thead>
                                        <tbody id="ajx_content"></tbody>
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
               url: "<?php echo site_url('reports/sales_day_wise_report');?>",
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    $('#ajx_content').html(data.tableContent);




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

