
<style>
     .prnt-btn,.addStock-btn,.reEvl-btn{

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
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Evaluated Vehicles</h2>
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

<!--                                                  <select name="status" class="select2_group filter-form-control cmbStatus">
                                                       <option value="-1">All Status</option>
                                                       <option value="0">Pending</option>
                                                       <option value="1">Active</option>
                                                  </select>-->
<!--                                                  <input type='hidden' name='status' value='12' id='status'>-->
                                                  <select name="status" class="select2_group filter-form-control cmbStatus">
                                                       <option <?php echo $status==-1?'selected':'' ?> value="-1">All Status</option>
                                                       <option <?php echo $status==0?'selected':'' ?> value="0">Pending</option>
                                                       <option <?php echo $status==12?'selected':'' ?> value="12">Active</option>
                                                  </select>

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
                                             </div>
                                             <div style="float: left;margin-top: 10px;">
                                                  <button type="submit" class="btn btn-round btn-primary btnFilter"><i class="fa fa-filter"></i> Filter</button>
                                             </div>
                                        </form>
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
                                   <th>Action</th>
                              </tr>
                         </thead>
                    </table>
               </div>
          </div>
     </div>
</div>
<script>
     $(document).ready(function () {
          navigator.mediaDevices.enumerateDevices().then(function(devices) { 
               console.log('devices');
               console.log(devices);
          
     });

          $('[data-toggle="tooltip"]').tooltip();
          var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
          valuationList(canDelete, $('.frmValuationFilter').serialize());
          $(document).on('submit', '.frmValuationFilter', function (e) {
               e.preventDefault();
               valuationList(canDelete, $(this).serialize());
          });


     });

     function valuationList(canDelete, frmData) {
        //  alert(5465);
          var enqStstus = <?php echo json_encode(unserialize(FOLLOW_UP_STATUS)); ?>;
          var printUrl = "<?php echo site_url('evaluation/printevaluation'); ?>";
          var prchsChkListUrl = "<?php echo site_url('evaluation/purchase_check_list'); ?>";
          //var reEvaluationUrl = "<?php echo site_url('evaluation/reEvaluation'); ?>"  ;
          var reEvaluationUrl = "<?php echo site_url('evaluation/re_evaluated'); ?>";
          var compareUrl = "<?php echo site_url('evaluation/compare'); ?>";

          // alert(enqStstus);
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
                    {data: 'val_added_date'}
                    ,
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function (data, type, row) {
                              // return enqStstus.btn_purchs_chk_list;
                              //prchsChkListUrl 
                              //  <a href="#" class="tip">Link<span>This is the CSS tooltip showing up when you mouse over the link</span></a>
                              if (data.val_status == 39) {
                                   return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.val_id + '"><i class="fa fa-bar-chart ficon"></i><span> Evaluation Details </span></a>';
                              } else {
                                   //return '<a class="prnt-btn tip" href="'+printUrl+'/'+ data.val_id+'"><i class="fa fa-bar-chart ficon"></i><span> Evaluation Details </span></a> &nbsp <a class="addStock-btn  tip addStock-'+data.val_id+'" href="'+prchsChkListUrl+'/1/'+ data.val_id+'"><i class="fa fa-plus ficon"></i><span> Add Stock </span></a>&nbsp <a class="reEvl-btn  tip reEvl-'+data.val_id+'" href="'+reEvaluationUrl+'/'+ data.val_id+'"><i class="fa fa-tasks ficon"></i><span> Re Evaluate </span></a>';      
                                   return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.val_id + '"><i class="fa fa-bar-chart ficon"></i><span> Evaluation Details </span></a> &nbsp <a class="addStock-btn  tip addStock-' + data.val_id + '" href="' + prchsChkListUrl + '/1/' + data.val_id + '"><i class="fa fa-plus ficon"></i><span> Add Stock </span></a>&nbsp <a class="reEvl-btn  tip reEvl-' + data.val_id + '" href="' + reEvaluationUrl + '/' + data.val_id + '"><i class="fa fa-tasks ficon"></i><span> Re Evaluate </span></a> &nbsp <a class="reEvl-btn  tip reEvl-' + data.val_id + '" href="' + compareUrl + '/' + data.val_id + '"><i class="fa fa-sliders ficon"></i><span> Compare </span></a>';
                              }
                         }
                    },
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
                    } else if (aData['val_status'] == "12") {

                         $('td', nRow).css('background-color', 'green');
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
</script>

<style>
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