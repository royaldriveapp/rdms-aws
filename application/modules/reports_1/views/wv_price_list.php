
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
   <ul class="nav navbar-right panel_toolbox">
                                             <li style="float: right;">
                                                  
                                                       <a href="<?php echo site_url('reports/price_list_export_excel?' . $_SERVER['QUERY_STRING']); ?>">
                                                            <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                                       </a>
                                                
                                             </li>

                                           
                                        </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row filter">
                              <form action="<?php echo site_url('reports/price_list');?>" method="get" id="filterForm">
                                   
                                     <table>
                                   <tr>
                                        <td>
                                             <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division"
                                                     data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" 
                                                     data-dflt-select="Select Showroom">
                                                  <option value="">Select division</option>
                                                  <?php foreach ($division as $key => $value) { ?>
                                                       <option <?php
                                                       echo (isset($_GET['vreg_division']) && ($_GET['vreg_division'] == $value['div_id'])) ?
                                                               'selected="selected"' : '';
                                                       ?> value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control cmbShowroom shorm_stf" 
                                                     name="vreg_showroom" id="vreg_showroom">
                                                  <option value="">Select showroom<?php //print_r($showroom['associatedShowroom']); ?></option>
                                                  <?php foreach ($showroom['associatedShowroom'] as $key => $value) { ?>
                                                       <option <?php
                                                       echo (isset($_GET['vreg_showroom']) && ($_GET['vreg_showroom'] == $value['col_id'])) ?
                                                               'selected="selected"' : '';
                                                       ?> value="<?php echo $value['col_id']; ?>"> <?php echo $value['col_title']; ?>
                                                       </option>
                                                  <?php } ?>
                                             </select>
                                        </td>
                              
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                             
                              
                              </table>

<!--                                   <td style="margin: 10px;">
                                        <?php
                                             $default_shrm = $this->shrm == 0 ? 1 : $this->shrm;
                                          if(isset($showroom)){
                                               $default_shrm=$showroom;
                                          }elseif ($this->shrm==0) {
                                            $default_shrm=1;   
                                          }
                                        $showrooms = unserialize(Showrooms);
                                        ?>
                                        <select  name="showroom" class="select2_group " >
                                             <?php foreach ($showrooms as $key => $showroom) {?>
                                                    <option <?php echo $key == $default_shrm ? 'selected' : '';?> value="<?php echo $key;?>" ><?php echo $showroom;?></option>
                                               <?php }?>
                                        </select>
                                   </td>
                                
                                   <input type="hidden" value="" id="page">

                                   <td style="margin: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
-->
                              </form>
                         </div>
 <input type="hidden" id="id-0" value="Brand">
                         <input type="hidden" id="id-1" value="Brand">
                           <input type="hidden" id="id-2" value="Vehicle">
                           <input type="hidden" id="id-3" value="Mode">
                            <input type="hidden" id="id-4" value="Color">
                             <input type="hidden" id="id-5" value="Fuel">
                               <input type="hidden" id="id-6" value="Mnr Year">
                                 <input type="hidden" id="id-7" value="Month & Year of">
                                  <input type="hidden" id="id-8" value="Reg no">
                               <input type="hidden" id="id-9" value="Km">
                                 <input type="hidden" id="id-10" value="No.Owners ">
                                  <input type="hidden" id="id-11" value="INS">
                               <input type="hidden" id="id-12" value="IDV">
                                 <input type="hidden" id="id-13" value="Price">
                                                                   <input type="hidden" id="id-14" value="Booking Date">
                               <input type="hidden" id="id-15" value="Booked Staff Name">
                                 <input type="hidden" id="id-16" value="Status">
                         
                                  
                               


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
                                 <table id="example" class="table table-striped table-bordered bg-clr display"  id="rowClick" cellspacing="0" width="10%">
<!--                                                      <table id="example" class="display" cellspacing="0" width="50%">-->
                                                            <thead >
                                                                 <tr class="">
                                                                      <th width="5%">Sl No</th> <th width="10%" data-0="Brand"> <span></span></th><th  width="5%" data-1="Vehicle"><span></span></th> <th  width="2%" data-2="Mode"><span></span> </th><th  width="2%" data-id="123"><span></span></th><th width="2%" class="singleline"><span></span></th> <th width="2%" class="singleline"><span></span></th><th width="2%" class="singleline"><span></span></th><th width="2%" class="singleline"> <span></span></th> <th width="2%" class="singleline"><span></span></th> <th width="2%" class="singleline"> <span></span></th> 
                                                                      <th class="singleline"><span></span></th><th class="singleline" >  <span></span></th><th class="singleline" data-th="warm" data-order="DESC">  <span></span></th>
                                                                      <th class="singleline"><span></span></th>
                                                                      <th class="singleline"><span></span></th>
                                                                      <th class="singleline"><span></span></th>
                                                                      <!-- 
                                                                        <th width="5%">Sl No</th> <th width="10%" data-0="Brand">Brand <span></span></th>  <th  width="5%" data-1="Vehicle">Vehicle<span></span></th> <th  width="2%" data-2="Mode">Mode<span></span> </th><th  width="2%" data-id="123">Color<span></span></th><th width="2%" class="singleline">Fuel<span></span></th> <th width="2%" class="singleline">Mnr Year<span></span></th><th width="2%" class="singleline">Month & Year of <span></span></th><th width="2%" class="singleline">Reg no <span></span></th> <th width="2%" class="singleline">Km <span></span></th> <th width="2%" class="singleline">No.Owners <span></span></th> 
                                                                      <th class="singleline">INS Date<span></span></th><th class="singleline" >IDV  <span></span></th><th class="singleline" data-th="warm" data-order="DESC">Price  <span></span></th><th>AVG<span></span> </th><th class="singleline">HP <span></span></th>
                                                                      <th class="singleline">Options<span></span></th>
                                                                      <th class="singleline">Booking Date<span></span></th>
                                                                      <th class="singleline">Booked Staff Name<span></span></th>
                                                                      <th class="singleline">Status<span></span></th>
                                                                      -->
                                                                 </tr>
                                                            </thead>
                                                            <tbody id="ajx_contentjs"> <?php
  if (!empty($details)) {
       foreach ($details as $key => $value) {
            ?>
            <tr class="hdr singleline txtBlk">
                 <td><?php echo $key + 1;?><?php //print_r($enqs); ?></td>
                 <td><?php echo $value['brd_title']?> </td> 
                 <td><?php echo $value['mod_title']?> | <?php echo $value['var_variant_name']?></td>
                 <td><?php echo $value['val_type']==1 ? 'O':$value['val_type']==5?'O':'P'?>  <?php //echo $value['val_type']?> </td>
                 <td><?php echo $value['val_color']?>  </td>
                 <td><?php echo $value['val_fuel']?>  </td>             
                 <td><?php echo $value['val_minif_year']?>  </td>  
                  <td><?php echo $value['val_manf_date']?>  </td>  
                   <td><?php echo $value['val_veh_no']?>  </td> 
                    <td><?php echo $value['val_km']?>  </td>
                 <td><?php echo $value['val_no_of_owner']?>  </td>             
                 <td><?php echo $value['val_insurance_validity']?>  </td>  
                  <td><?php echo $value['val_insurance_idv']?>  </td>  
                   <td><?php echo $value['prd_price']?>  </td> 
                    <td><?php echo $value['vbk_added_on']?>  </td> 
                    <td><?php echo $value['booked_staff']?>  </td>  
                   <td><?php if($value['vbk_status']==28 or $value['vbk_status']==13 ){
                         $shwrm = unserialize(Showrooms)[$value['vbk_showroom']];
                         
                        echo $text='Booked-'.$shwrm;
                   } else {
                       $shwrm = unserialize(Showrooms)[$value['val_showroom']];
                         
                        echo $text='STOCK-'.$shwrm;  
                   }
?></td> 
                 <?php
            }
       }
     ?> </tbody>
                                                       </table>

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
//     $("#filterForm").submit(function (e) {
//          e.preventDefault();
//          filter_data(1);
//
//     });
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
         // alert(255);
          var form = $("#filterForm");
          $.ajax({
               url: "<?php echo site_url('reports/price_list');?>/" + page,
               method: "POST",
               dataType: "JSON",
               data: form.serialize(),
               success: function (data)
               {
                    //alert(data.tableContent);
                    $('.divLoading').hide();
                    $('#ajx_content').html(data.tableContent);
                    $('#page').val(data.uri_seg);

                   // $('#pagination_link').html(data.pagination_link);
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

  $(document).ready(function () {
 var oTable = $('#example').DataTable({
          fixedHeader: {
               header: false,
               footer: false
          },
          pagingType: "full_numbers",
          bSort: true,
          "order": [[0, "asc"]],
          "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
          initComplete: function () {
               this.api().columns().every(function () {
                  var idx = this.index();
                                // console.log(idx);
                    var thTitle=document.getElementById("id-"+idx).value;
                    //console.log(thTitle);
                    var column = this;
                    var select = $('<select style="width:100px;"><option value="">'+thTitle+'</option></select>')
                            .appendTo($(column.header()).find('span').empty())
                            .on({'change': function () {
                                      var val = $.fn.dataTable.util.escapeRegex(
                                              $(this).val()
                                              );

                                      column
                                              .search(val ? '^' + val + '$' : '', true, false)
                                              .draw();
                                 },
                                 'click': function (e) {
                                      // stop click event bubbling
                                      e.stopPropagation();
                                 }
                            });

                    column.data().unique().sort().each(function (d, j) {
                         select.append('<option value="' + d + '">' + d + '</option>')
                    });
               });
          }

     });
 
   });
 
 ///////


</script>

