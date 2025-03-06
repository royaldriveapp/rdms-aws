<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fellowship Report02</h2>
                         <ul class="nav navbar-right panel_toolbox">
                        <?php if (check_permission($controller, 'export_report')) { ?>
                            <li style="float: right;">
                                <a class="btnExport" href="javascript:void(0);">
                                    <img width="20" title="Export to excel" src="images/excel-export.png" />
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                         <!-- filter -->
                         <?php if (check_permission('fellowship', 'show_filter')) { ?>
                              <p>
                                   <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-filter"></i> Filter
                                   </a>
                              </p>
                         <?php } ?>
                         <div class="row">
                              <div class="col">
                                   <div class="collapsemulti collapse" id="multiCollapseExample1">
                                        <div class="card card-body">
                                             <form class="x_content frmValuationFilter">
                                                  <table>
                                                       <tr>
                                                            <td>
                                                                 <select data-placeholder="Lead Added By" name="staff[]" class="select2_group filter-form-control staff_id cmbMultiSelect" multiple>
                                                                      <?php foreach ((array) $fellowshipStaff as $key => $fstaff) { ?>
                                                                           <option value="<?php echo $fstaff['usr_mobile_personal']; ?>">
                                                                                <?php echo $fstaff['usr_username']; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td>
                                                                 <?php if (check_permission('fellowship', 'show_all_reports')) { ?>
                                                                      <select data-placeholder="Sales Head" name="tl[]" class="select2_group filter-form-control tl_id cmbMultiSelect" multiple>
                                                                           <?php foreach ((array) $teamLeads as $key => $TL) { ?>
                                                                                <option value="<?php echo $TL['usr_id']; ?>">
                                                                                     <?php echo $TL['usr_username']; ?></option>
                                                                           <?php } ?>
                                                                      </select>
                                                                 <?php } ?>
                                                            </td>
                                                            <td>
                                                                 <select data-placeholder="Status" name="status[]" class="select2_group filter-form-control status cmbMultiSelect" multiple>
                                                                      <?php foreach ((array) $FELLOWSHIP_STATUS as $key => $status) { ?>
                                                                           <option value="<?php echo $key; ?>">
                                                                                <?php echo $status; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td>
                                                                 <input style="width:100px;" autocomplete="off" name="validated_at" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" placeholder="Validated at" />
                                                            </td>
                                                            <td>
                                                                 <button type="submit" class="btn btn-round btn-primary btnFilter"><i class="fa fa-filter"></i> Filter</button>
                                                            </td>
                                                       </tr>
                                                  </table>
                                             </form>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- End filter -->
                    </div>
                    <div class="x_content">
                    <table id="tblPurchas" class="table table-striped table-bordered no-footer dataTable" role="grid" aria-describedby="tblPurchas_info" style="width: 1238px;">
    <thead>
        <tr role="row">
            <th colspan="2" rowspan="1">Lead Added By</th>
            <th rowspan="1" colspan="1">No of enquiries</th>
            <th rowspan="1" colspan="1">No of validated</th>
        </tr>
        <tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="tblPurchas" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" style="width: 157.333px;" aria-sort="ascending">Name</th>
            <th class="sorting" tabindex="0" aria-controls="tblPurchas" rowspan="1" colspan="1" aria-label="Contact: activate to sort column ascending" style="width: 130.333px;">Contact</th>
            <th class="sorting" tabindex="0" aria-controls="tblPurchas" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 89.3333px;"></th>
            <th class="sorting" tabindex="0" aria-controls="tblPurchas" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 87.3333px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reportData as $row): ?>
            <tr role="row">
                <td class="sorting_1"><?= $row['usr_name']; ?></td>
                <td><?= $row['usr_mobile_personal']; ?></td>
                <td><?= $row['total_enquiries']; ?></td>
                <td><?= $row['validated_enquiries']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                    </div>
               </div>
          </div>
     </div>
</div>
