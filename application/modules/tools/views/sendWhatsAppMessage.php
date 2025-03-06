<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>

                    <form action="<?php echo site_url($controller . '/sendMessage');?>" method="post" enctype="multipart/form-data">
                         <div class="x_content">
                              <table>
                                   <tr>
                                        <td>
                                             <textarea name="message"></textarea>

                                        </td>
                                   </tr>
                                   <tr>
                                        <td style="padding-top: 10px;">
                                             <input type="file" name="image"/>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td  style="padding-top: 10px;">
                                             <button type="submit" class="btn btn-primary">Send</button>
                                        </td>
                                   </tr>
                              </table>
                         </div>
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th><input type="checkbox" data-child="chkEnquires" class="chkChain"/></th>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Sales Executive</th>' : '';?>
                                        <th>Name</th>
                                        <th>Whatsapp</th>
                                        <th>Enquiry Date</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?> 
                                               <tr>
                                                    <td><input class="chkEnquires" type="checkbox" name="enq_id[]" value="<?php echo $value['enq_id'];?>"/></td>
                                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : '';?>
                                                    <td><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                    <td> <a target="blank"> <?php echo clean_whatsapp_num($value['enq_cus_whatsapp']);?> </a></td>
                                                    <td><?php echo date('j M Y', strtotime($value['enq_entry_date']));?></td>
                                               </tr>
                                               <?php
                                          }
                                     }
                                   ?>
                              </tbody>
                         </table>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex;?> to <?php echo $limit;?> of <?php echo $totalRow;?> entries</div>
                         <div style="float: right;">
                              <?php echo $links;?>
                         </div>
                    </form>
               </div>
          </div>
     </div>
</div>
