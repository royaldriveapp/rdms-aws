<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquiry Pool Batch</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="tblPoolBatch" class="table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                              <thead>
                                   <tr>
                                        <th>Batch Id</th>
                                        <?php if (count($data[0]) <= 5) {?>
                                               <th>Description</th>
                                          <?php }?>
                                        <th>Added on</th>
                                        <th>Added by</th>
                                        <?php if (count($data[0]) > 5) {?>
                                               <th>Assigned to</th>
                                               <th>Customer name</th>
                                               <th>Customer phone</th>
                                               <th>Previous SE</th>
                                               <th>Updated on</th>
                                               <th>Updated by</th>
                                               <th>Comment</th>
                                          <?php }?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($data)) {
                                          foreach ($data as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url('enquiry/poolbatch/' . $value['enq_pool_batch']);?>">
                                                    <td class="trVOE"><?php echo $value['enq_pool_batch'];?></td>
                                                    <?php if (count($data[0]) <= 5) {?>
                                                         <td class="trVOE"><?php echo $value['enp_cmd_assign'];?></td>
                                                    <?php }?>
                                                    <td class="trVOE"><?php echo date('d-m-Y', strtotime($value['enp_added_on']));?></td>
                                                    <td class="trVOE"><?php echo $value['usr_username'];?></td>
                                                    <?php if (count($data[0]) > 5) {?>
                                                         <td class="trVOE"><?php echo $value['usr_to_username'];?></td>
                                                         <td class="trVOE"><?php echo $value['enq_cus_name'];?></td>
                                                         <td class="trVOE"><?php echo $value['enq_cus_mobile'];?></td>
                                                         <td class="trVOE"><?php echo $value['usr_from_username'];?></td>
                                                         <td class="trVOE"><?php echo!empty($value['enp_updated_on']) ? date('d-m-Y', strtotime($value['enp_updated_on'])) : '';?></td>
                                                         <td class="trVOE"><?php echo $value['usr_upd_username'];?></td>
                                                         <td class="trVOE"><?php echo $value['enp_cmd_updates'];?></td>
                                                    <?php }?>
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

<script>
     $(document).ready(function () {
          $('#tblPoolBatch').DataTable({
               "order": [[1, "asc"]],
               "scrollX": true,
               "pageLength": 20
          });
     });
</script>

<style>
     div.dataTables_wrapper {
          width: 1109px;
          margin: 0 auto;
     }
     a {color: unset;}
</style>