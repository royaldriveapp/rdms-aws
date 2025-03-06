
<style>
     .prnt-btn,.addStock-btn{

          color: #fefefe!important;
     }
     .ficon{
          font-size: 17px !important;
          padding-top: 12px!important;
          padding-left: 8px!important;
     }

     a.tip {
          /* border-bottom: 1px dashed; */
          text-decoration: none
     }
     a.tip:hover {
          cursor: help;
          position: relative
     }
     a.tip span {
          display: none
     }
     a.tip:hover span {
          color: while;
          border-radius: 2cm;
          border: #c0c0c0 1px dotted;
          padding: 13px;
          padding-left: 15px;
          display: block;
          z-index: 100;
          background-color: black;
          left: 0px;
          margin: 10px;
          width: 90px;
          position: absolute;
          top: 10px;
          text-decoration: none;
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
     .modal-dialog.test_drive {

/*          width: 837px!important;*/

     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Stock Vehicle </h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if (check_permission($controller, 'xlsx_valuation')) { ?>
                                   <li style="float: right;">
                                        <a class="btnExport" href="javascript:void(0);" data-url="<?php echo site_url($controller . '/export'); ?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   </li>
                              <?php } ?>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="row">
                         <div class="col">
                              <div class="collapsemulti collapse1" id="multiCollapseExample1">
                                   <div class="card card-body">
                                        <div class="row">
                                             <div id="filter-panel" class="collapse filter-panel">
                                                  <div class="panel panel-default">
                                                       <div class="panel-body">
                                                            <form class="form-inline frmValuationFilter" role="form">
                                                                       <input type='hidden' name='status' value='39' id='status'>
                                                                 <table class="table table-striped table-bordered">
                                                                      <tr>
                                                                           <td>
                                                                                <span>Division</span>
                                                                                <select class="cmbBindShowroomByDivision" name="vreg_division" id="vreg_division" data-dflt-select="Select Showroom"
                                                                                        data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom">
                                                                                     <option value="">Select division</option>
                                                                                     <?php foreach ($division as $key => $value) { ?>
                                                                                          <option value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                                                                     <?php } ?>
                                                                                </select>
                                                                           </td>

                                                                           <td>
                                                                                <span>Showroom</span>
                                                                                <select required class="cmbShowroom shorm_stf" name="vreg_showroom" id="vreg_showroom">
                                                                                     <option value="">Select showroom</option>
                                                                                </select>
                                                                           </td>

                                                                           <td>
                                                                                <span>Brand</span>
                                                                                <select data-placeholder="Brand" multiple data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" is-multi-check="1"
                                                                                        data-dflt-select="" class="cmbMultiSelect select2_group filter-form-control bindToDropdown" 
                                                                                        name="val_brand[]" id="val_brand">
                                                                                             <?php
                                                                                             if (!empty($brand)) {
                                                                                                  foreach ($brand as $key => $value) {
                                                                                                       ?>
                                                                                               <option value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                                                                                               <?php
                                                                                          }
                                                                                     }
                                                                                     ?>
                                                                                </select>
                                                                           </td>

                                                                           <td>
                                                                                <span>Model</span>
                                                                                <select data-placeholder="Model" multiple data-url="<?php echo site_url('enquiry/bindVarient'); ?>" is-multi-check="1"
                                                                                        data-bind="cmbEvVariant" data-dflt-select="" class="select2_group cmbEvModel cmbMultiSelect
                                                                                        filter-form-control bindToDropdown" name="val_model[]" id="val_model"></select>
                                                                           </td>

                                                                           <td style="width:136px;">
                                                                                <span>Variant</span>
                                                                                <select multiple class="select2_group filter-form-control cmbEvVariant cmbMultiSelect" is-multi-check="1" 
                                                                                        data-placeholder="Varient" name="val_variant[]" id="val_variant"></select>
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>
                                                                                <span>Manf year from</span>
                                                                                <input style="width:100px;" autocomplete="off" name="val_manf_date_from" type="text" class="dtpDatePickerDMY" 
                                                                                       placeholder="Manf year from" value="<?php echo isset($_GET['val_manf_date_from']) ? $_GET['val_manf_date_from'] : ''; ?>"/>
                                                                           </td>

                                                                           <td>
                                                                                <span>Manf year to</span>
                                                                                <input style="width:100px;" autocomplete="off" name="val_manf_date_to" type="text" class="dtpDatePickerDMY" 
                                                                                       placeholder="Manf year to" value="<?php echo isset($_GET['val_manf_date_to']) ? $_GET['val_manf_date_to'] : ''; ?>"/>
                                                                           </td>

                                                                           <td>
                                                                                <span>Valuation date from</span>
                                                                                <input style="width:100px;" autocomplete="off" name="val_valuation_date_from" type="text" class="dtpDatePickerDMY" 
                                                                                       placeholder="Manf year From" value="<?php echo isset($_GET['val_valuation_date_from']) ? $_GET['val_valuation_date_from'] : ''; ?>"/>
                                                                           </td>

                                                                           <td>
                                                                                <span>Valuation date to</span>
                                                                                <input style="width:100px;" autocomplete="off" name="val_valuation_date_to" type="text" class="dtpDatePickerDMY" 
                                                                                       placeholder="Manf year to" value="<?php echo isset($_GET['val_valuation_date_to']) ? $_GET['val_valuation_date_to'] : ''; ?>"/>
                                                                           </td>
                                                                           <td>
                                                                                <span>Fuel</span>
                                                                                <select data-placeholder="Fuel" class="cmbMultiSelect select2_group filter-form-control" name="val_fuel[]" id="val_brand">
                                                                                     <?php foreach (unserialize(FUAL) as $key => $value) { ?>
                                                                                          <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                                     <?php } ?>
                                                                                </select>
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>
                                                                                <span>KM from</span>
                                                                                <input style="width:100px;" autocomplete="off" name="val_valuation_date_from" type="text" class="dtpDatePickerDMY" 
                                                                                       placeholder="KM from" value="<?php echo isset($_GET['val_valuation_date_from']) ? $_GET['val_valuation_date_from'] : ''; ?>"/>
                                                                           </td>

                                                                           <td>
                                                                                <span>KM to </span>
                                                                                <input style="width:100px;" autocomplete="off" name="val_valuation_date_to" type="text" class="dtpDatePickerDMY" 
                                                                                       placeholder="KM to" value="<?php echo isset($_GET['val_valuation_date_to']) ? $_GET['val_valuation_date_to'] : ''; ?>"/>
                                                                           </td>

                                                                           <td> 
                                                                                <span>Vehicle type </span>
                                                                                <select name="val_veh_type">
                                                                                     <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) { ?>
                                                                                          <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                                     <?php } ?>
                                                                                </select>
                                                                           </td>
                                                                           <td>
                                                                                <span>Transmission </span>
                                                                                <select name="val_transmission">
                                                                                     <option value="0">Transmission</option>
                                                                                     <option value="1">M/T</option>
                                                                                     <option value="2">A/T</option>
                                                                                     <option value="3">S/T</option>
                                                                                </select>
                                                                           </td>
                                                                           <td>
                                                                                <span>Colour </span>
                                                                                <select name="val_color">
                                                                                     <option value="0">Colour</option>
                                                                                     <?php foreach ($colors as $key => $value) { ?>
                                                                                          <option value="<?php echo $value['vc_id']; ?>"><?php echo $value['vc_color']; ?></option>
                                                                                     <?php } ?>
                                                                                </select>
                                                                           </td>
                                                                      <tr>
                                                                      <tr>
                                                                           <td>
                                                                                <span>Warranty</span>
                                                                                <input name="val_wrnty" type="checkbox"/>
                                                                                &nbsp;&nbsp;&nbsp;
                                                                                <span>Ext Warranty</span>
                                                                                <input name="val_wrnty_extra" type="checkbox"/>
                                                                           </td>
                                                                           <td>
                                                                                <span>No fo seat</span>
                                                                                <input style="width:100px;" autocomplete="off" name="val_no_of_seats" type="text" placeholder="No fo seat" 
                                                                                       value="<?php echo isset($_GET['val_valuation_date_from']) ? $_GET['val_valuation_date_from'] : ''; ?>"/>
                                                                           </td>
                                                                           <td>
                                                                                <span>RTO</span>
                                                                                <select name="val_rto">
                                                                                     <?php foreach ($RTO as $key => $value) { ?>
                                                                                          <option value="<?php echo $value['rto_id']; ?>"><?php echo $value['rto_place'] . ' (' . $value['rto_reg_num'] . ')'; ?></option>
                                                                                     <?php } ?>
                                                                                </select>
                                                                           </td>
                                                                           <td>
                                                                                <span>Status</span>
                                                                                
                                                                           </td>
                                                                      </tr>
                                                                 </table>
                                                            </form>
                                                       </div>
                                                  </div>
                                             </div>
                                             <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#filter-panel">
                                                  <span class="glyphicon glyphicon-cog"></span> Advanced Search
                                             </button>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <table id="tblValuation" class="table table-striped table-bordered">
                         <thead>
                              <tr>
                                   <th>ID</th>
                                   <th>Customer Status</th>
                                   <th>Reg Number</th>
                                   <th>Added by</th>
                                   <th>Evaluated by</th>
                                   <th>Showroom</th>
                                   <th>Brand</th>
                                   <th>Model</th>
                                   <th>Added on</th>
                                   <th>Booking Status</th>
                                   <th>Action</th>
                              </tr>
                         </thead>
                    </table>
                   <!-- comment -->
                   <!-- Test drive model -->
<div class="modal fade" id="UpdrefurbSts" role="dialog">
     <div class="modal-dialog test_drive">
          <?php echo form_open_multipart("evaluation/update_refurb_status", array('id' => "update-refurb-status", 'class' => "update-refurb-status  modal-content form-horizontal form-label-left"))?>

          <div class="modal-header bg-gray h-brd-radi">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> Update Refurb Status  <span class="msg"></span></h4>
          </div>
          <div class="modal-body bg-gray brd-radi">
               <input type="hidden" value="" name="ref_val_id" id="ref_val_id" class="ref_val_id">
               <div class="mdl_div">
                    <div class='flds'>
                         <div class="row">
<?php
   $refurbStatus = $this->evaluation->getRefurbStatus();//refurb
  ?>
                              <i class=" prefix grey-text"></i>
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                
                                   <label class="lbl">Status</label>
                                   <select  class="tdriveSearchList select2_group form-control cmbStock form-control col-md-7 col-xs-12" 
                                            name="val_refurb_status" >
                                        <option value="">Select </option>
                              <?php  foreach ($refurbStatus as $value) {?>
                                        <option value="<?php echo $value['sts_value'] ?>"><?php echo $value['sts_title'] ?> </option>
                                             <?php  } ?>
                    </select>

                              </div>
                              <!--                               <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                                 <label class="lbl">Reg No</label>
                                                                 <div>
                                                                      <input required placeholder="KL" id="enq_cus_loan_emi" style="width: 90px;text-transform:uppercase;" class="form-control col-md-7 col-xs-12" type="text" disabled="" name="veh_reg1" autocomplete="off">
                                                                                          <input required placeholder="00" id="enq_cus_loan_emi" style="width: 90px;" class="form-control col-md-7 col-xs-12 numOnly" type="text" disabled="" name="veh_reg2" autocomplete="off">
                                                                                          <input required placeholder="AA" id="enq_cus_loan_emi" style="width: 90px;text-transform:uppercase;" class="form-control col-md-7 col-xs-12" disabled="" type="text" name="veh_reg3" autocomplete="off">
                                                                                          <input required placeholder="0000" id="enq_cus_loan_emi" style="width: 115px;" class="form-control col-md-7 col-xs-12 numOnly" type="text" disabled="" name="veh_reg4" autocomplete="off">
                                                                 </div>
                                                            </div>-->
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="lbl">Remark</label>
                                   <input type="text" class="form-control col-md-7 col-xs-12 " name="val_refurb_remark" placeholder="Remark"> 
                              </div>
                         </div>

                     
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
               <?php echo form_close()?>
          </div>
     </div></div><!-- Test drive model -->
                   <!-- @comment -->
               </div>
          </div>
     </div>
</div>
<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
               aria-hidden="true">×</span></button>
     <strong>Enq Status Updated successfully!</strong>
</div>
<script>
     $(document).ready(function () {
          $('[data-toggle="tooltip"]').tooltip();
          var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
          valuationList(canDelete, $('.frmValuationFilter').serialize());
          $(document).on('submit', '.frmValuationFilter', function (e) {
               e.preventDefault();
               valuationList(canDelete, $(this).serialize());
          });

          $(document).on('click', '.btnExport', function (e) {
               $.ajax({
                    type: 'post',
                    url: site_url + "evaluation/xlsx_valuation?" + $('.frmValuationFilter').serialize(),
                    dataType: 'json',
                    success: function (resp) {

                         window.location.href = resp;
                    }
               });
          });
     });

     function valuationList(canDelete, frmData) {
          var enqStstus = <?php echo json_encode(unserialize(FOLLOW_UP_STATUS)); ?>;
          var printUrl = "<?php echo site_url('evaluation/printevaluation'); ?>";
          var prchsChkListUrl = "<?php echo site_url('evaluation/purchase_check_list'); ?>";

          $('#tblValuation').DataTable().clear().destroy();
          $('#tblValuation').DataTable({
               "order": [[1, "asc"]],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": {
                    "type": "POST",
                    "url": site_url + "evaluation/evaluation_ajax?" + frmData
               },
               "columnDefs": [
                    {
                         "targets": [0],
                         "visible": false
                    }
               ],
               'columns': [
                    {data: 'val_id'},
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function (data, type, row) {
                              if (row.enq_cus_when_buy != 'null' && row.enq_cus_when_buy > 0) {
                                   return enqStstus[row.enq_cus_when_buy];
                              } else {
                                   return '';
                              }
                         }
                    },
                    {data: 'val_veh_no'},
                    {data: 'usr_username'},
                    {data: 'evtr_usr_username'},
                    {data: 'shr_location'},
                    {data: 'brd_title'},
                    {data: 'mod_title'},
                    {data: 'val_added_date'},
                    {data: 'val_book_sts_title'},
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function (data, type, row) {
                              //return enqStstus.btn_purchs_chk_list;
                              //prchsChkListUrl 
                              //<a href="#" class="tip">Link<span>This is the CSS tooltip showing up when you mouse over the link</span></a>
                              if (data.val_status == 39) {//
                                   return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.val_id + '"><i class="fa fa-bar-chart ficon"></i><span> Evaluation Details </span></a><a  class="prnt-btn tip ref_btn" data-toggle="modal" data-id="' + data.val_id + '" data-target="#UpdrefurbSts"><i class="fa fa-edit ficon"></i><span>Update Refurb status</span></a>';
                              } else {
                                   return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.val_id + '"><i class="fa fa-bar-chart ficon"></i><span> Evaluation Details </span></a> &nbsp <a class="addStock-btn  tip addStock-' + data.val_id + '" href="' + prchsChkListUrl + '/1/' + data.val_id + '"><i class="fa fa-plus ficon"></i><span> Add Stock </span></a>';
                              }
                         }
                    }
               ],
               "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData['val_status'] == "0") {
                         $('td', nRow).css('background-color', 'Red');
                         $('td', nRow).css('color', '#fff');
                    } else if (aData['val_status'] == "1") {
                         $('td', nRow).css('background-color', 'yellowgreen');
                         $('td', nRow).css('color', '#fff');
                    } else if (aData['val_status'] == "39") {

                         $('td', nRow).css('background-color', 'gray');
                         $('td', nRow).css('color', '#fff');
                    }
               }
          });
          $('#tblValuationj tbody').on('click', 'tr', function () {
               var data = $('#tblValuation').DataTable().row(this).data();
               var url = "<?php echo site_url('evaluation/printevaluation'); ?>" + "/" + data.val_id;
               window.location.href = url;
          });
     } 
$(document).on("click", ".ref_btn", function () {// pass val_id to popup while click refurb update btn
     var ids = $(this).data('id');
     $(".modal-body #ref_val_id").val( ids );
    });
     
</script>

<style>
     .btn {
          padding: 0px 6px !important;
     }
     .filter-form-control {
          float: left;
          /*display: block;*/
          margin-left: 5px;
          padding: 5px 5px;
          font-size: 14px;
          line-height: 1.42857143;
          color: #555;
          background-color: #fff;
          background-image: none;
          border: 1px solid #ccc;
          border-radius: 4px;
          -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
          box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
          -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
          -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
          transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
     }
     .div-filter-form-control {float: left;margin-left: 5px;}
</style>