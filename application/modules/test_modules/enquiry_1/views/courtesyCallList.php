<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Courtesy call list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                                   <li role="presentation" class="active">
                                        <a href="#tab_3day" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">3 Day</a>
                                   </li>
                                   <li role="presentation">
                                        <a href="#tab_5day" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">5 Day</a>
                                   </li>

                                   <li role="presentation">
                                        <a href="#tab_20day" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">20 Day</a>
                                   </li>
                              </ul>
                              <div id="myTabContent" class="tab-content">
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_3day" aria-labelledby="dar-tab">
                                               <div style="float: left; width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                                    <h3></h3>
                                                    <table class="datatable-resp table table-striped table-bordered">
                                                         <thead>
                                                              <tr>
                                                                   <th>Entry date</th>
                                                                   <th>Customer name</th>
                                                                   <th>Contact</th>
                                                                   <th>Address</th>
                                                                   <th>Occupation</th>
                                                                   <th>City</th>
                                                                   <th>Contact mode</th>
                                                                   <th>Status</th>
                                                                   <th>Branch</th>
                                                                   <th>Sales staff</th>
                                                                   <th>Next followup<th>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <?php foreach ((array) $data['dataThree'] as $dk => $dvalue) { ?>
                                                                   <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($dvalue['enq_id']));?>">
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['enq_entry_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_mobile'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_address'];?></td>
                                                                        <td class="trVOE">
                                                                             <?php
                                                                             $modes = unserialize(ENQUIRY_UP_STATUS);
                                                                             echo isset($modes[$dvalue['enq_cus_when_buy']]) ? $modes[$dvalue['enq_cus_when_buy']] : '';
                                                                             ?>
                                                                        </td>
                                                                        <td class="trVOE"><?php echo $dvalue['shr_location'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['usr_first_name'];?></td>
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['enq_next_foll_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['occ_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['cit_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_remarks'];?></td>
                                                                   </tr>
                                                              <?php }?>
                                                         </tbody>
                                                    </table>
                                               </div>  
                                   </div>

                                   <div role="tabpanel" class="tab-pane fade" id="tab_5day" aria-labelledby="dar-tab">
                                               <div style="float: left; width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                                    <h3></h3>
                                                    <table class="datatable-resp table table-striped table-bordered">
                                                         <thead>
                                                              <tr>
                                                                   <th>Entry date</th>
                                                                   <th>Customer name</th>
                                                                   <th>Contact</th>
                                                                   <th>Address</th>
                                                                   <th>Occupation</th>
                                                                   <th>City</th>
                                                                   <th>Contact mode</th>
                                                                   <th>Status</th>
                                                                   <th>Branch</th>
                                                                   <th>Sales staff</th>
                                                                   <th>Next followup<th>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <?php foreach ((array) $data['dataFive'] as $dk => $dvalue) { ?>
                                                                   <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($dvalue['enq_id']));?>">
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['enq_entry_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_mobile'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_address'];?></td>
                                                                        <td class="trVOE">
                                                                             <?php
                                                                             $modes = unserialize(ENQUIRY_UP_STATUS);
                                                                             echo isset($modes[$dvalue['enq_cus_when_buy']]) ? $modes[$dvalue['enq_cus_when_buy']] : '';
                                                                             ?>
                                                                        </td>
                                                                        <td class="trVOE"><?php echo $dvalue['shr_location'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['usr_first_name'];?></td>
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['enq_next_foll_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['occ_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['cit_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_remarks'];?></td>
                                                                   </tr>
                                                              <?php }?>
                                                         </tbody>
                                                    </table>
                                               </div> 
                                   </div>
                                   <div role="tabpanel" class="tab-pane fade" id="tab_20day" aria-labelledby="dar-tab">
                                               <div style="float: left; width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                                    <h3></h3>
                                                    <table class="datatable-resp table table-striped table-bordered">
                                                         <thead>
                                                              <tr>
                                                                   <th>Entry date</th>
                                                                   <th>Customer name</th>
                                                                   <th>Contact</th>
                                                                   <th>Address</th>
                                                                   <th>Occupation</th>
                                                                   <th>City</th>
                                                                   <th>Contact mode</th>
                                                                   <th>Status</th>
                                                                   <th>Branch</th>
                                                                   <th>Sales staff</th>
                                                                   <th>Next followup<th>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <?php foreach ((array) $data['dataTwnty'] as $dk => $dvalue) { ?>
                                                                   <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($dvalue['enq_id']));?>">
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['enq_entry_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_mobile'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_address'];?></td>
                                                                        <td class="trVOE">
                                                                             <?php
                                                                             $modes = unserialize(ENQUIRY_UP_STATUS);
                                                                             echo isset($modes[$dvalue['enq_cus_when_buy']]) ? $modes[$dvalue['enq_cus_when_buy']] : '';
                                                                             ?>
                                                                        </td>
                                                                        <td class="trVOE"><?php echo $dvalue['shr_location'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['usr_first_name'];?></td>
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['enq_next_foll_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['occ_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['cit_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['enq_cus_remarks'];?></td>
                                                                   </tr>
                                                              <?php }?>
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