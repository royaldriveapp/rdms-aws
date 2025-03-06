<style>
     .titletext {
          margin-left: 13px;
          margin-top: 8px;
          position: absolute;
          text-decoration: none;
     }
     .page {
          min-height: 29.7cm;
          background: white;
     }

     .subpage {
          height: 292mm;
     }

     @page {
          size: A4;
          margin: 0;
     }

     @media print {
          .page {
               margin: 0;
               border: initial;
               border-radius: initial;
               width: initial;
               min-height: initial;
               box-shadow: initial;
               background: initial;
               page-break-after: always;
          }
     }

     /*complaint*/
     div.gallery {
          margin: 5px;
          border: 1px solid #ccc;
          float: left;
          width: 200px;
     }

     div.gallery:hover {
          border: 1px solid #777;
     }

     div.gallery img {
          width: 100%;
          height: auto;
     }

     div.desc {
          padding: 15px;
          text-align: center;
     }

     /*complaint*/
     .table {
          margin-bottom: 0px !important;
     }

     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
          padding: 5px !important;
     }

     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th {
          border: none !important;
     }

     .x_content {
          font-size: 11px;
     }

     @media print {
          .right_col {
               margin-left: 0px !important;
          }

          .left_col {
               display: none !important;
          }

          .right_col {
               height: 400px !important;
          }

          .row {
               height: 400px !important;
          }

          .div-col-body {
               height: 400px !important;
          }

          .x_panel {
               max-height: 271px !important;
          }
     }

     @media print {

          .no-print,
          .no-print * {
               display: none!important;
          }
     }
     .refrftable td,
     .refrftable th {
          border: 1px solid black !important;
          padding: 8px !important;
     }
     .refrftable th {
          padding-top: 12px !important;
          padding-bottom: 12px !important;
          text-align: left;
          color: black !important;
     }

     .refrb-bottom-tbl>thead>tr>th {
          padding: 8px!important;
          line-height: 1.777!important;
          vertical-align: top!important;
          border-top: 0px !important;
     }
     .tblBasicDetails span{
          line-height: 32px;
          font-size: 18px;
     }
     .description{
       padding: 8px!important;    
     }
</style>
<?php
 // print_r($vehicles)
  ?>
<div class="right_col" role="main">
     <div class="row">
          <div class="div-col-body col-md-12 col-sm-12 col-xs-12">
               <div class="page">
                    <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                         </button>
                         <strong>Data updated successfully!</strong>
                    </div>
                    <!-- tab -->
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">

                         <ul id="myTab" class="nav nav-tabs bar_tabs no-print" role="tablist" style="background: none;">
                              <li role="presentation" class="tabs active" data-id="<?php echo $parent['val_id']; ?>">
                                   <a href="#tb_parent" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $parent['usr_username']; ?>  </a>
                              </li>
                              <?php                             foreach ($tabs as $k=>$value) {?>
                                  
                            
                              <li class="tabs" data-id="<?php echo $value['val_id']; ?>" role="presentation">
                                   <a href="#tb_cntnt" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $value['usr_username']; ?></a>
                              </li>
                              <?php } ?>
<!--                              <li role="presentation">
                                   <a href="#purchase" role="tab" data-toggle="tab" aria-expanded="true">KJJKK</a>
                              </li>
                              <li role="presentation">
                                   <a href="#eval-report_1-tab" role="tab" data-toggle="tab" aria-expanded="true">FGFH</a>
                              </li>
                              <?php if (check_permission('evaluation', 'tab_purchasechecklist')) { ?>
                                   <li role="presentation">
                                        <a href="#chklist2tab" role="tab" data-toggle="tab" aria-expanded="true">HFGHFGH</a>
                                   </li>
                              <?php } if (check_permission('evaluation', 'tab_refurbreq')) { ?>
                                   <li role="presentation">
                                        <a href="#refurbisheReq" role="tab" data-toggle="tab" aria-expanded="true">FGHFGHFGH</a>
                                   </li>
                              <?php }if (check_permission('evaluation', 'tab_offer_price')) { ?>
                                   <li role="presentation">
                                        <a href="#offerPrice" role="tab" data-toggle="tab" aria-expanded="true">FGHFGH</a>
                                   </li>
                              <?php } ?>
                              <li role="presentation">
                                   <a href="#booking_sts_tab" role="tab" data-toggle="tab" aria-expanded="true">HFGHGFEWRT</a>
                              </li>-->
                         </ul>

                         <!-- tab content -->
                         <div id="myTabContent" class="tab-content">
                              <br>
                              <div class="description">
                              <h2>Evaluation report </h2>
                              <p>Vehicle:<?php echo $parent['brd_title']; ?> | <?php echo $parent['mod_title']; ?> | <?php echo $parent['var_variant_name']; ?></p>
                               <p>Register No:<?php echo strtoupper($parent['val_veh_no']); ?></p>
                                                             </div>
                              <div class='myTabContent' role="tabpanel" class="tab-pane fade" id="tb_cntnt" aria-labelledby="stock">
                                  ... 
                              </div>

                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<script src='https://unpkg.com/spritespin@x.x.x/release/spritespin.js' type='text/javascript'></script>
<script type="text/javascript" src="http://localhost/royalportal/rdportal/assets/scripts/../../../assets/html5gallery/html5gallery.js"></script>
<script>

 $(document).on('click', '.tabs', function () {
         var val_id=$(this).data("id");
      loadComparison(val_id);
});
     function loadComparison(val_id){
                      var id = val_id
            var url = site_url + "evaluation/getCompare";
          $.ajax({
               type: 'get',
               url: url,
                data: {'val_id': id},
               beforeSend: function (xhr) {
                  $('.divLoading').show();
               },
               success: function (resp) {
                                       $('.divLoading').hide();
                    $('.myTabContent').html(resp);
               }
          });  
     }
     $(document).ready(function () {
          var valId='<?php echo $parent['val_id']; ?>';
          loadComparison(valId);
          $("#printBtn_rfrb").click(function () {
               window.print();
          });
          $(document).on('click', '.html5gallery-car-mask-0', function () {
               $('.html5gallery-elem-0').show();
               $('#mySpriteSpin').hide();
               $('.html5gallery-title-text-0').show();
          });
          $('#html5-watermark').hide();
          $('#html5-title').hide();
     });
     $('.360img').click(function (e) {
          $('.html5gallery-elem-0').hide();
          $('#mySpriteSpin').show();
          $('.html5gallery-title-text-0').hide();
     });
</script>
<style>
     @media only screen and (max-width: 600px) {
          .html5gallery-car-0 {
               top: 304px!important;
               zoom: 75%!important;
          }
          .threeSix {
               top: 323px!important;
               left: 400px!important;
               zoom: 75%!important;
          }
     }
     .threeSix {
          margin-left: 3px!important;
          display: block;
          overflow: hidden;
          position: absolute;
          width: 99px;height: 47px;
          top: 456px;left: 662px;
     }
     .mySpriteSpin {
          z-index: 1;top: 2px;
          width: 771px!important;
          height: 436px!important;
          position: absolute!important;
     }
</style>