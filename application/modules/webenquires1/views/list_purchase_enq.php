<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Purchase Enquiry</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <?php if (check_permission('webenquires', 'exportPurchaseEnq')) { ?>
                                        <a href="<?php echo site_url('webenquires/exportPurchaseEnq?' . $_SERVER['QUERY_STRING']); ?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   <?php } ?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                              <table class="tblWebPurchaseEnquires table table-striped table-bordered">
                                   <thead>
                                        <tr>
                                             <th>#ID</th>
                                             <th>Date</th>
                                             <th>Customer name</th>
                                             <th>Email</th>
                                             <th>Phone</th>
                                             <th>Vehicle</th>
                                             <th>Year</th>
                                             <?php echo (check_permission('web_purchase_enq', 'delete')) ? '<th>Assigned to</th>' : ''; ?>
                                             <?php echo (check_permission('web_purchase_enq', 'delete')) ? '<th>D</th>' : ''; ?>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          if (!empty($data)) {
                                               foreach ($data as $key => $value) {
                                                    $phone  = !empty($value['phone']) ? $value['phone'] : $value['prd_usr_ph_num'];
                                                    $uri = array(
                                                        't' => encryptor('rana_products'),
                                                        'pk' => 'prd_id',
                                                        'i' => encryptor($value['prd_id']),
                                                        'ph' => encryptor($phone),
                                                        'nm' => encryptor($value['username']),
                                                    );
                                                    $url = '?' . http_build_query($uri, '', '&amp;');
                                                    $id = encryptor($value['prd_id'], 'E');
                                                    $value['brd_title'] = !empty($value['brd_title']) ? $value['brd_title'] : $value['brd_title'];
                                                    $value['mod_title'] = !empty($value['mod_title']) ? $value['mod_title'] : $value['prd_model'];
                                                    $value['var_variant_name'] = !empty($value['var_variant_name']) ? $value['var_variant_name'] : $value['prd_variant'];
                                                    ?>
                                                    <tr data-url="<?php echo site_url($controller . '/punch_purchase_enq' . $url);?>">
                                                         <td><?php echo $value['prd_id'];?></td>
                                                         <td class="trVOE"><?php echo date('d-m-Y', strtotime($value['prd_date']));?></td>
                                                         <td class="trVOE"><?php echo $value['username'];?></td>
                                                         <td class="trVOE"><?php echo $value['email'];?></td>
                                                         <td><a target="blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['usr_phone_code'] . $phone;?>"><?php echo $value['usr_phone_code'] . $phone;?></a></td>
                                                         <td class="trVOE"><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?></td>
                                                         <td class="trVOE"><?php echo $value['prd_year'];?></td>
                                                         <?php if (check_permission('web_purchase_enq', 'delete')) { ?>
                                                            <td><?php echo $value['assignedby_usr_username'];?></td>
                                                         <?php } if (check_permission('web_purchase_enq', 'delete')) { ?>
                                                            <td>
                                                                 <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                                      data-url="<?php echo site_url('webenquires/deletepurchaseenq/' . encryptor($value['prd_id']));?>">
                                                                      <i class="fa fa-remove"></i>
                                                                 </a>
                                                            </td>
                                                         <?php } ?>
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
</div>

<style>
     .table>thead>tr>th {
          white-space: nowrap;
          width: 1%;
     }
     .table>tbody>tr>td {
          white-space: nowrap;
          width: 1%;
     }
</style>

<script>
     $(document).ready(function () {
          $('.tblWebPurchaseEnquires').DataTable({
               "order": [[0, "desc"]],
               "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
               }]
          });
     });
</script>