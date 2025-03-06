<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick followup report</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Title</th>
                                        <th>Assigned by</th>
                                        <th>Assigned on</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   if (!empty($quickFollMaster)) {
                                        foreach ($quickFollMaster as $key => $value) {
                                             ?>
                                             <tr data-url="<?php echo site_url('reports/quickEnquiryFedBackDetails/' . encryptor($value['qtrm_id'])); ?>">
                                                  <td class="trVOE"><?php echo $value['qtrm_title']; ?></td>
                                                  <td class="trVOE"><?php echo $value['usr_username']; ?></td>
                                                  <td class="trVOE"><?php echo date('j M Y', strtotime($value['qtrm_added_on'])); ?></td>
                                             </tr>
                                             <?php
                                        }
                                   }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>