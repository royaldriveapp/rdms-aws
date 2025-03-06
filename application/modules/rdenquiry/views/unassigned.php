<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquiry</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Whatsapp</th>
                                        <?php echo $this->usr_grp != 'SE' ? '<th>Delete</th>' : '';?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url('enquiry/view/' . encryptor($value['enq_id']));?>">
                                                    <td class="trVOE"><?php echo $value['enq_cus_name'];?></td>
                                                    <td class="trVOE"><?php echo $value['enq_cus_mobile'];?></td>
                                                    <td class="trVOE"><?php echo $value['enq_cus_email'];?></td>
                                                    <td class="trVOE"><?php echo $value['enq_cus_whatsapp'];?></td>
                                                    <?php if ($this->usr_grp != 'SE') {?>
                                                         <td>
                                                              <a class="pencile edit" onclick="return confirm('Are you sure want to delete?')"
                                                                 href="<?php echo site_url('enquiry/delete/' . encryptor($value['enq_id']));?>">
                                                                   <i class="fa fa-remove"></i>
                                                              </a>
                                                         </td>
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