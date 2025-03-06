<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Evaluation / stock vehicle</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if (check_permission($controller, 'xlsx_valuation')) { ?>
                                   <li style="float: right;">
                                        <a class="btnExport" href="javascript:void(0);">
                                             <img width="20" title="Export to excel" src="images/excel-export.png" />
                                        </a>
                                   </li>
                              <?php } ?>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <p>
                         <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1"
                              role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-filter"></i> Filter
                         </a>
                    </p>
                    <div class="row">
                         <div class="col">
                              <div class="collapsemulti collapse" id="multiCollapseExample1">
                                   <div class="card card-body">
                                        <form class="x_content frmValuationFilter">
                                             <div style="float: left;width: 100%;">
                                                  <input type="hidden" name="status" value="39">
                                                  <select class="select2_group filter-form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division" data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" data-dflt-select="Select Showroom">
                                                       <option value="">Select division</option>
                                                       <?php foreach ($division as $key => $value) { ?>
                                                            <option <?php
                                                                      echo (isset($_GET['vreg_division']) && ($_GET['vreg_division'] == $value['div_id'])) ?
                                                                           'selected="selected"' : '';
                                                                      ?> value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                                       <?php } ?>
                                                  </select>
                                                  <select class="select2_group filter-form-control cmbShowroom shorm_stf" name="showroom" id="vreg_showroom">
                                                       <option value="0">All</option>
                                                  </select>
                                                  <!---@ -->
                                                  <select name="type" class="select2_group filter-form-control cmbType">
                                                       <option value="0">All Type</option>
                                                       <option value="1">Our own</option>
                                                       <option value="2">Park and sale</option>
                                                       <option value="3">Park and sale with customer</option>
                                                       <option value="1,2">Our own and Park and sale</option>
                                                  </select>

                                                  <div class="div-filter-form-control">
                                                       <select data-placeholder="Enquiry status" name="enqStatus[]" class="select2_group filter-form-control enq_se_id cmbMultiSelect" multiple>
                                                            <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) { ?>
                                                                 <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                            <?php } ?>
                                                       </select>
                                                  </div>

                                                  <div class="div-filter-form-control">
                                                       <select data-placeholder="Evaluator" name="val_evaluator[]" class="select2_group filter-form-control enq_se_id cmbMultiSelect" multiple>
                                                            <?php
                                                            if (!empty($evaluators)) {
                                                                 foreach ($evaluators as $key => $value) {
                                                            ?>
                                                                      <option value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title']; ?></option>
                                                            <?php
                                                                 }
                                                            }
                                                            ?>
                                                       </select>
                                                  </div>

                                                  <div class="div-filter-form-control">
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
                                                  </div>

                                                  <div class="div-filter-form-control">
                                                       <select data-placeholder="Model" multiple data-url="<?php echo site_url('enquiry/bindVarient'); ?>" is-multi-check="1"
                                                            data-bind="cmbEvVariant" data-dflt-select="" class="select2_group cmbEvModel cmbMultiSelect
                                                               filter-form-control bindToDropdown" name="val_model[]" id="val_model"></select>
                                                  </div>

                                                  <div class="div-filter-form-control">
                                                       <select multiple class="select2_group filter-form-control cmbEvVariant cmbMultiSelect" is-multi-check="1"
                                                            data-placeholder="Varient" name="val_variant[]" id="val_variant"></select>
                                                  </div>

                                                  <div class="div-filter-form-control">
                                                       <input style="width:100px;" autocomplete="off" name="val_valuation_date_from" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12"
                                                            placeholder="Evaluate from" value="<?php echo isset($_GET['val_valuation_date_from']) ? $_GET['val_valuation_date_from'] : ''; ?>" />
                                                  </div>
                                                  <div class="div-filter-form-control">
                                                       <input style="width:100px;" autocomplete="off" name="val_valuation_date_to" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12"
                                                            placeholder="Evaluate to" value="<?php echo isset($_GET['val_valuation_date_to']) ? $_GET['val_valuation_date_to'] : ''; ?>" />
                                                  </div>
                                                  <div class="div-filter-form-control">
                                                       <select data-placeholder="Procurement Staff" name="val_evaluator[]" class="select2_group filter-form-control enq_se_id cmbMultiSelect" multiple>
                                                            <?php
                                                            if (!empty($salesExe)) {
                                                                 foreach ($salesExe as $key => $value) {
                                                            ?>
                                                                      <option value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_username']; ?></option>
                                                            <?php
                                                                 }
                                                            }
                                                            ?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div style="float: left;margin-top: 10px;">
                                                  <button type="submit" class="btn btn-round btn-primary btnFilter"><i class="fa fa-filter"></i> Filter</button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- -->
                    <table id="tblValuation" class="table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                         <thead>
                              <tr>
                                   <th>ID</th>
                                   <th>Stock ID</th>
                                   <th>Name</th>
                                   <th>Phone</th>
                                   <th>Cust Status</th>
                                   <th>Reg Number</th>
                                   <th>Added by</th>
                                   <th>Evaluated by</th>
                                   <th>Showroom</th>
                                   <th>Brand</th>
                                   <th>Model</th>
                                   <th>Evaluated on</th>
                                   <th>Chasis no</th>
                                   <th>Fuel</th>
                                   <th>CC</th>
                                   <th>Booking Status</th>
                                   <th>Action</th>
                              </tr>
                         </thead>
                    </table>
               </div>
          </div>
     </div>
</div>
<script>
     $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();
          var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
          console.log($('.frmValuationFilter').serialize());
          valuationList(canDelete, $('.frmValuationFilter').serialize());
          $(document).on('submit', '.frmValuationFilter', function(e) {
               e.preventDefault();
               valuationList(canDelete, $(this).serialize());
          });
          $(document).on('click', '.btnExport', function(e) {
               $.ajax({
                    type: 'post',
                    url: site_url + "evaluation/xlsxStock?" + $('.frmValuationFilter').serialize(),
                    dataType: 'json',
                    success: function(resp) {
                         window.location.href = resp;
                    }
               });
          });
     });

     function valuationList(canDelete, frmData) {
          //alert(frmData);
          var enqStstus = <?php echo json_encode(unserialize(FOLLOW_UP_STATUS)); ?>;
          var printUrl = "<?php echo site_url('evaluation/printevaluation'); ?>";
          var followupUrl = "<?php echo site_url('followup/viewFollowup'); ?>";
          var prchsChkListUrl = "<?php echo site_url('evaluation/purchase_check_list'); ?>";
          var canAddStock = "<?php echo check_permission('evaluation', 'purchase_check_list') ? true : false; ?>";

          $('#tblValuation').DataTable().clear().destroy();
          $('#tblValuation').DataTable({
               "order": [
                    [1, "asc"]
               ],
               "scrollX": true,
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": {
                    "type": "POST",
                    "url": site_url + "evaluation/stock_ajax?" + frmData
               },
               "columnDefs": [{
                    "targets": [0],
                    "visible": false
               }],
               'columns': [{
                         data: 'val_id'
                    },
                    {
                         data: 'val_stock_num'
                    },
                    {
                         data: 'val_cust_name'
                    },
                    {
                         data: 'val_cust_phone'
                    },
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              if (row.enq_cus_when_buy != 'null' && row.enq_cus_when_buy > 0) {
                                   //return enqStstus[row.enq_cus_when_buy];
                                   return '<a class="prnt-btn tip" href="' + followupUrl + '/' + data.enq_id + '">' + enqStstus[row.enq_cus_when_buy] + '</a>';
                              } else {
                                   return '';
                              }
                         }
                    },
                    {
                         data: 'val_veh_no'
                    },
                    {
                         data: 'usr_username'
                    },
                    {
                         data: 'evtr_usr_username'
                    },
                    {
                         data: 'shr_location'
                    },
                    {
                         data: 'brd_title'
                    },
                    {
                         data: 'mod_title'
                    },
                    {
                         data: 'val_added_date'
                    },
                    {
                         data: 'val_chasis_no'
                    },
                    {
                         data: 'fuel'
                    }, //Fuel
                    {
                         data: 'val_eng_cc'
                    },
                    {
                         data: 'val_book_sts_title'
                    },
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              // return enqStstus.btn_purchs_chk_list;
                              //prchsChkListUrl 
                              //  <a href="#" class="tip">Link<span>This is the CSS tooltip showing up when you mouse over the link</span></a>
                              if (data.val_status == 39) {
                                   return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.val_id + '"><i class="fa fa-print ficon "></i><span> Evaluation details </span></a>';
                              } else {
                                   if (canAddStock) {
                                        return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.val_id + '"><i class="fa fa-print ficon "></i><span> Evaluation details </span></a> &nbsp <a class="addStock-btn  tip addStock-' + data.val_id + '" href="' + prchsChkListUrl + '/1/' + data.val_id + '"><i class="fa fa-plus ficon"></i><span> Add Stock </span></a>';
                                   } else {
                                        return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.val_id + '"><i class="fa fa-print ficon "></i><span> Evaluation details </span></a>';
                                   }
                              }
                         }
                    },
               ],
               "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData['val_status'] == "0") {
                         $('td', nRow).css('background-color', 'Red');
                         $('td', nRow).css('color', '#fff');
                    } else if (aData['val_status'] == "12") {
                         $('td', nRow).css('background-color', 'yellowgreen');
                         $('td', nRow).css('color', '#fff');
                    } else if (aData['val_status'] == "39") {
                         $('td', nRow).css('background-color', 'gray');
                         $('td', nRow).css('color', '#fff');
                    }
               }
          });
          $('#tblValuation tbody').on('click', 'tr', function() {
               var data = $('#tblValuation').DataTable().row(this).data();
               var url = "<?php echo site_url('evaluation/printevaluation'); ?>" + "/" + data.val_id;
               //window.location.href = url;
          });
     }
</script>

<style>
     div.dataTables_wrapper {
          width: 1109px;
          margin: 0 auto;
     }

     a {
          color: unset;
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
          -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
          -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
          transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
     }

     .div-filter-form-control {
          float: left;
          margin-left: 5px;
     }

     .prnt-btn,
     .addStock-btn {

          /* color: #fefefe!important; */
     }

     .ficon {
          font-size: 17px !important;
          padding-top: 12px !important;
          padding-left: 8px !important;
     }

     a.tip {
          /* border-bottom: 1px dashed; */
          text-decoration: none
     }

     a.tip:hover {
          cursor: pointer;
          position: relative
     }

     a.tip span {
          display: none;
          color: #fff;
     }

     a.tip:hover span {
          color: while;
          border-radius: 9px;
          border: #c0c0c0 1px dotted;

          padding: 5px;
          display: block;
          z-index: 100;

          background-color: black;
          left: 0px;
          margin: 10px;
          width: auto;
          position: absolute;
          top: 10px;
          text-decoration: none
     }
</style>