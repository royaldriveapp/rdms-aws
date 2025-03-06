<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Mode of contact</th>
                                        <th>New mode of contact</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?> 
                                               <tr>
                                                    <td><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                    <td> <a target="blank"> <?php echo $value['enq_cus_mobile'];?> </a></td>
                                                    <td><?php
                                                         $mod = unserialize(MODE_OF_CONTACT);
                                                         echo isset($mod[$value['enq_mode_enq']]) ? $mod[$value['enq_mode_enq']] : '';
                                                         ?>
                                                    </td>

                                                    <td>
                                                         <select class="cmbCommon select2_group form-control" name="enquiry[enq_mode_enq]" 
                                                                 data-url="<?php echo site_url('general/missingContactModes/' . encryptor($value['enq_id']));?>">
                                                              <option value="">Select one</option>
                                                              <?php
                                                              foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                   if (in_array($key, array(18, 17, 6, 19, 20))) {
                                                                        ?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php
                                                                   }
                                                              }
                                                              ?>
                                                         </select>
                                                    </td>
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
