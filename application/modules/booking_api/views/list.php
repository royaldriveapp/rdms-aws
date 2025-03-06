
<style>
   
   .approvalModaljjjj{
        position: absolute;
        margin-left:797px;
        top: 10px;   
   }
   .lbl{
        color: black !Important;
   }
   .dialog {
        width: 746px !important;
        margin: 30px auto !important ;
   }
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
   .modal-content {
        border: 7px solid rgba(0,0,0,.2)!important;
        border-radius: 42px!important;
   }
   .cus-fdbk-content{
        border: 7px solid rgb(205 204 199 / 26%)!important;
   }
   .modal-dialog.approval_modal {

        width: 837px!important;

   }
   .radio-btn{
        border-radius: 50%!important;
        width: 25px !important;
        height: 25px!important;

        border: 2px solid lightskyblue!important;
        transition: 0.2s all linear!important;
        position: relative!important;
        top: 8px!important;
   }
   .slctwidth{
        width: 270px !important; 
   }
   .multiselect{
        width: 269px !important; 
   }

</style>
<div class="right_col" role="main">
   <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="x_panel">
               
            
                      
                       <table id="tblBooking" class="table table-striped table-bordered">
                            <thead>
                                 <tr>
                                    <th>ID</th>
                                      <th>Customer Name </th>
                                      <th>Address</th>
                                      <th>Pin</th>
                                      <th>District</th>
                                      <th>Pan no</th>
                                      <th>Adhaar no</th>
                                      <th>Advance Amount</th>
                                      <th>Vehicle</th>
                                       <th>Action</th>
                                      
                                 </tr>
                            </thead>
                       </table>                   
             </div>
        </div>
   </div>
</div>
<div class="divBookingForm"></div>

<script>
var reserve = "<?php echo check_permission('purchase','update_approval') ? true : false;?>";
var canEdit = "<?php echo check_permission('purchase','edit') ? true : false;?>";
var actionBtn='';


   $(document).ready(function () {


      
        $('[data-toggle="tooltip"]').tooltip();
        var canDelete = "<?php echo is_roo_user() ? 1 : 0;?>";
       
       bookingList(canDelete);


   });
   function bookingList(canDelete) {
        var editUrl = "<?php echo site_url('purchase/edit');?>";
$('#tblBooking').DataTable().clear().destroy();
        $('#tblBooking').DataTable({
             "order": [[1, "asc"]],
             "processing": true,
             "serverSide": true,
             'serverMethod': 'post',
             "ajax": {
                  "type": "POST",
                  "url": site_url + "booking_api/list_ajax?" 
             },
             "columnDefs": [
                  {
                       "targets": [0],
                       "visible": false
                  }
             ],
             'columns': [
                {data: 'ab_id'},
                  {data: 'ab_name'},
                  {data: 'ab_address'},
                  {data: 'ab_pin'},
                  {data: 'ab_district'},
                  {data: 'ab_pan_no'},
                  {data: 'ab_aadhaar_no'},
                  {data: 'ab_advance_amount'},
                  {data: 'ab_vehicle'},
 {
                       "mData": null,
                       "bSortable": true,
                       "mRender": function (data, type, row) {
                        //  if (reserve) {
                            if(1){
                                var url = "<?php echo site_url('booking_api/reserve');?>" + "/" + data.ab_id;
                                var url2 = "<?php echo site_url('booking/reserveVehicleViewApi/');?>" + "/" + data.ab_id;
 //actionBtn= '<a  href= " '+url+'" class="approvalModalk btn btn-success mdl-btn" ><i class="fa fa-plus ficon "></i><span> Reserve </span></a>';
actionBtn=' <button data-url="'+url2+'" class="btnBookingForm btn btn-primary">Reserve</button>'
;
                            } 
                            return actionBtn;
                       }
                  },
             ],
        
        });
        $('#tblBooking tbody').on('click', 'tr', function () {
             var data = $('#tblBooking').DataTable().row(this).data();
             var url = "<?php echo site_url('Purchase/printPurchase');?>" + "/" + data.ab_id;
             //window.location.href = url;
        });
   }

   $(document).on('submit', ".submitApproval", function (e) {
     
      e.preventDefault();
      var url = $(this).attr('action');
      var formData = new FormData($(this)[0]);
      $.ajax({
          type: 'post',
          url: url,
          dataType: 'json',
          data: formData,
          async: false,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function (xhr) {
              //  $('.divLoading').show();
          },
          success: function (resp) {

             $('.divLoading').hide();
              $('.msgBox').show();
              setTimeout(function () {
                  $('.msgBox').fadeOut();
              }, 1500);

              $("#approval-modal").trigger("reset");
              $("#approvalModal").modal("hide");
              var canDelete = "<?php echo is_roo_user() ? 1 : 0;?>";
       
       bookingList(canDelete);

          }
      });
  });

  
</script>




