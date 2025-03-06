
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
     .lbl-blk{
          color: black !important; 
     }
     .tbl{ overflow-x: auto;
      overflow-y: hidden;
     }
       .tb-man,th{
          color: white !important;     
     }
     .tbl-blk{
                 background-color:#98cdd9; 
               border: 3px dotted #fffffff2;
     }
     .tbl-pitch{
          background-color:#474a56; 
              border: 4px dotted #fffffff2;
     }
     .SumoSelect {
          display: inline-block!important;
          position: relative!important;
          outline: 0!important;
          color: #57705a!important;
     }
     .x_panel {
          width: 100%!important;
          padding: 10px 7px!important;
          display: inline-block!important;
          background: #a9aaac42!important;
          border: 7px dotted #fffffff2!important;
          -webkit-column-break-inside: avoid!important;
          -moz-column-break-inside: avoid!important;
          column-break-inside: avoid!important;
          opacity: 1;
          transition: all .2s ease!important;
     }
.form-control-enq {
    display: block;
    width: 100%!important;
    height: 34px!important;
    padding: 6px 12px!important;
    font-size: 14px!important;
    line-height: 1.42857143!important;
    color: #f7f7f7;
    background-color: #7f80998a!important;
    background-image: none!important;
    border: 1px dotted #191b24!important;
    border-radius: 4px!important;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: 1px 1px 0px 12px rgb(138 146 149 / 15%);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color cubic-bezier(0.76, -0.21, 0.58, -0.23) .15s,box-shadow ease-in-out .15s;
}

.bg-clr {
    background-color: #2b27271c !important;
    border: 1px solid #dfe1e6 !important;
    padding: 20px !important;
    box-shadow: 14px 1px 14px 3px #6f81a8f5 !important;
}
.lbl {
    color: #1c1a1a !important;
    font-family: ui-monospace !important;
}
.tb-man {
    color: #222020 !important;
}
.bg_abv_60{
      background-color: #e91111!important;
}
.bg_45_60{
      background-color: #e1ac16 !important;
}
.bg_30_45{
      background-color: #52bf3ec7 !important;
}
.bg_less_30{
      background-color: #257c23e0 !important;
}
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <?php $ldType=unserialize(HOW_DO_U_ABT_RD);
                                                    //print_r($ldType)     ?>
                         <h2>Stock Status Report <!-- stock status summary --> </h2>
                         <div class="clearfix"></div>
                    </div>
                    <p>
<!--                         <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" 
                            role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-filter"></i> Filter
                         </a>-->
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
                                                       <option value="-1">All Status</option>
                                                       <option value="0">Pending</option>
                                                       <option value="12">Active</option>
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



                    <div class="tbl table-responsive">
                    <!-- rw2 --> <div>
                                                  <table class="table table-striped table-bordered bg-clr">
                                                       <thead>
                                                            <tr>
                                                                 <th class="lbl-blk"></th>
                                                                 <th class="lbl-blk">Refurb Stock </th>
                                                                 <th class="lbl-blk">Booked Stock </th>
                                                                 <th class="lbl-blk">Ready to sell </th>
                                                                 <th class="lbl-blk">Total</th>
                                                                 <th class="lbl-blk">Delivered (<small>Delivery of the month</small>)</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <tr>
                                                                 <th class="lbl-blk">Purchased Stock </th>
                                                                 <td><?php echo $purch_refurb_stock;  ?></td> 
                                                                 <td><?php echo $purch_booked_stock;  ?></td>
                                                                 <td><?php echo $purch_ready_to_sell;  ?></td>
                                                                 <td><?php echo $purch_total;  ?></td>
                                                             <td><?php echo $purch_stock_delivered_this_month;  ?></td>
                                                            </tr>
                                                            <tr>
                                                                 <th class="lbl-blk">Park & Sell</th>
                                                                <td><?php echo $park_refurb_stock;  ?></td> 
                                                                 <td><?php echo $park_booked_stock;  ?></td>
                                                                 <td><?php echo $park_ready_to_sell;  ?></td>
                                                                 <td><?php echo $park_total;?></td>
                                                             <td><?php echo $park_stock_delivered_this_month;  ?></td>
                                                            </tr>
                                                            <tr>
                                                                                                                               <th class="lbl-blk">Total</th>
                                                                 <td class="lbl-blk"><?php echo $total_refurb_stock;  ?></td> 
                                                                 <td class="lbl-blk"><?php echo $total_booked_stock;  ?></td>
                                                                 <td class="lbl-blk"><?php echo $total_ready_to_sell;  ?></td>
                                                                 <td class="lbl-blk"><?php echo $total;?></td>
                                                                  <td class="lbl-blk"><?php echo $total_delivered_this_mont;  ?></td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div><!-- @rw2 -->
               </div>
                    <center><h3>Ageing stock Report</h3> </center>
                     <div class="tbl table-responsive">
                    <!-- rw2 --> <div>
                                                  <table class="table table-striped table-bordered bg-clr">
                                                       <thead>
                                                            <tr class="lbl-blk">
                                                                 <th class="lbl-blk"></th>
                                                                 <th class="lbl-blk">Above 60 </th>
                                                                 <th class="lbl-blk">45-60Days </th>
                                                                 <th class="lbl-blk">30-45 Days </th>
                                                                 <th class="lbl-blk">Less than 30</th>
                                                                 <th class="lbl-blk">Total </th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <tr class="lbl-blk">
                                                                 <th class="lbl-blk">Purchased Stock </th>
                                                                 <td  class="bg_abv_60"><?php echo $purch_age_above_60?></td> 
                                                                 <td class="bg_45_60"><?php echo $purch_ag45_60?></td>
                                                                 <td class="bg_30_45"><?php echo $purch_ag30_45?></td>
                                                                 <td class="bg_less_30"><?php echo $purch_age_lessthan_30?></td>
                                                             <td><?php echo $total_purch_ageing?></td>
                                                            </tr>
                                                            <tr class="lbl-blk">
                                                                 <th class="lbl-blk">Park & Sell</th>
                                                                 <td class="bg_abv_60"><?php echo $park_age_above_60?></td> 
                                                                 <td class="bg_45_60"><?php echo $park_ag45_60?></td>
                                                                 <td class="bg_30_45"><?php echo $park_ag30_45?></td>
                                                                 <td class="bg_less_30"><?php echo $park_age_lessthan_30?></td>
                                                             <td><?php echo $total_park_ageing?></td>
                                                            </tr>
                                                            <tr>
                                                                 <th class="lbl-blk">Total</th>
                                                                 <td  class="lbl-blk bg_abv_60"><?php echo $total_age_above_60?></td> 
                                                                 <td  class="lbl-blk bg_45_60"><?php echo $total_ag45_60?></td>
                                                                 <td class="lbl-blk bg_30_45"><?php echo $total_ag30_45?></td>
                                                                 <td class="lbl-blk bg_less_30"><?php echo $total_age_lessthan_30?></td>
                                                             <td class="lbl-blk"><?php echo $grand_total?></td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div><!-- @rw2 -->
               </div>
               </div>
          </div>
     </div>
</div>


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