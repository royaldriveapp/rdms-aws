
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
     .rotateObjqq{
          width:150px;
          display:inline-block;
          position:absolute;
          left:-50px;

          -webkit-transform:rotate(-90deg);
     }
</style>

<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2> Sales Enq Model Wise Analysis
                         </h2>

                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="#" method="get" id="filterForm" >
                              <table>
                                   <td>
                                        <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" value="<?php echo date("01-m-Y"); ?>"/>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date to" value="<?php echo date("d-m-Y"); ?>"/>
                                   </td>

                                   <td style="padding-left: 10px;">
                                        <?php $showrooms = unserialize(Showrooms); ?>
                                        <select  name="showroom" class="select2_group form-control col-md-7 col-xs-12" >
                                             <?php foreach ($showrooms as $key => $showroom) { ?>
                                                  <option <?php $key == 1 ? 'selected' : ''; ?> value="<?php echo $key; ?>" ><?php echo $showroom; ?></option>
                                             <?php } ?>
                                        </select>
                                   </td>



                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                              </table>
                         </form>
                    </div> <!-- @@@@@@@@@@comment -->
                    <div class="x_content">
                         <!--                         <div class="row filter">
                                                       <form action="#" method="get" id="filterForm">
                                                            <table>
                                                                 <td style="margin: 10px;">
                         <?php $showrooms = unserialize(Showrooms); ?>
                                                                      <select  name="showroom" class="select2_group " >
                         <?php foreach ($showrooms as $key => $showroom) { ?>
                                                                                       <option <?php $key == 1 ? 'selected' : ''; ?> value="<?php echo $key; ?>" ><?php echo $showroom; ?></option>
                         <?php } ?>
                                                                      </select>
                                                                 </td>
                         
                         
                                                                 <td style="margin: 10px;">
                                                                      <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                                                 </td>
                                                            </table>
                                                       </form>
                                                  </div>-->
                         <h5  class="lbl-blk"><center>Model wise Analysis
                                   <?php
                                   $currentMonth = date('F');
                                   echo ' <br><br>' . Date('d-m-Y') . '&nbsp;|&nbsp;' . date('h:i:sa');
                                   ?> 
                              </center></h5>

                         <div id="ajx_content"> </div>
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
               url: "<?php echo site_url('reports/enq_model_wise_analysis'); ?>",
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    $('.divLoading').hide();
                    //  alert(data.tableContent);
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

