<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Promotional Inquiries</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                                   <li role="presentation" class="active">
                                        <a href="#tab_enq" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Promotional Inquiries</a>
                                   </li>
                              </ul>
                              <div id="myTabContent" class="tab-content">
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_enq" aria-labelledby="dar-tab">
                                        <!-- <h3> 
                                             <a href="<?php //echo site_url('registration/export_excel_event/evnt'); ?>">
                                             <img style="float:right;" width="20" title="Export to excel" src="images/excel-export.png"/></a>
                                        </h3> -->
                                        <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                             <table class="datatable-resp table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th>Entry date</th>
                                                            <th>Customer name</th>
                                                            <th>Contact</th>
                                                            <th>Alternate contact</th>
                                                            <th>Location</th>
                                                            <th>Email</th>
                                                            <th>Event</th>
                                                            <th>Profession</th>
                                                            <th>Work</th>
                                                            <th>Invest plan</th>
                                                            <?php if (check_permission('investors', 'canchangecontacted')) { ?>
                                                                 <th>Contacted</th>
                                                            <?php } ?>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <?php foreach ((array) $datas as $key => $value) { 
                                                            $invAmt = (isset($value['eve_inv_amount']) && $value['eve_inv_amount'] == 2) ? '50 Lac - 1 Cr' : '1 Cr & Above'; ?>
                                                            <tr style="<?php echo ($value['eve_register_id'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>">
                                                                 <td><?php echo date('j M Y', strtotime($value['eve_added_on'])); ?></td>
                                                                 <td><?php echo $value['eve_name']; ?></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile'] . '"'; ?> > <?php echo $value['eve_mobile']; ?> </a></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_alt_mobile'] . '"'; ?> > <?php echo $value['eve_alt_mobile']; ?> </a></td>
                                                                 <td><?php echo $value['eve_location']; ?></td>
                                                                 <td><?php echo $value['eve_email']; ?></td>
                                                                 <td><?php echo $value['evnt_title']; ?></td>
                                                                 <td><?php echo $value['eve_profession']; ?></td>
                                                                 <td><?php echo $value['eve_work_ind']; ?></td>
                                                                 <td><?php echo $invAmt;?></td>
                                                                 <?php if (check_permission('investors', 'canchangecontacted')) { ?>
                                                                      <td>
                                                                           <input for="Latest" data-url="<?php echo site_url('registration/changesCheckBoxFields/eve_wp_sent/' . $value['eve_id']) ?>" 
                                                                                     class="chkStatus" type="checkbox" name="chkStatus" value="<?php echo $value['eve_wp_sent']; ?>" 
                                                                                <?php echo ($value['eve_wp_sent'] == 1) ? "checked" : ''; ?> <?php echo ($value['eve_wp_sent'] == 1) ? "disabled" : ''; ?>/>
                                                                      </td>
                                                                 <?php } ?>
                                                            </tr>
                                                       <?php } ?>
                                                  </tbody> 
                                             </table>
                                        </div>
                                   </div>
                              </div>
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