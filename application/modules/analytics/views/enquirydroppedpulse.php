<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date from" value="<?php echo $enq_date_from; ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date to" value="<?php echo $enq_date_to ?>"/>
                                        </td>

                                        <td style="padding-left: 10px;">
                                             <input <?php echo ($isRequestToDrop == 2) ? 'checked' : ''; ?> type="checkbox" name="isRequestToDrop" value="2"/> Request for drop
                                        </td>

                                        <td style="padding-left: 10px;">
                                             <input <?php echo ($isDrop == 3) ? 'checked' : ''; ?> type="checkbox" name="isDrop" value="3"/> Dropped
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <?php
                         $totalHP = 0;
                         $totalH = 0;
                         $totalW = 0;
                         $totalC = 0;
                         ?>
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Sales Staff</th>
                                        <th>Hot + </th>
                                        <th>Hot</th>
                                        <th>Warm</th>
                                        <th>Cold</th>
                                        <th>Total</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   foreach ((array) $enqpulse as $key => $val) {
                                        $totalHP += $val['hotp'];
                                        $totalH += $val['hot'];
                                        $totalW += $val['warm'];
                                        $totalC += $val['cold'];
                                        ?>
                                        <tr>
                                             <th><?php echo $val['salesStaff']; ?></th>
                                             <th><?php echo $val['hotp']; ?></th>
                                             <th><?php echo $val['hot']; ?></th>
                                             <th><?php echo $val['warm']; ?></th>
                                             <th><?php echo $val['cold']; ?></th>

                                             <th><?php echo $val['hotp'] + $val['hot'] + $val['warm'] + $val['cold']; ?></th>
                                        </tr>
                                   <?php } ?>
                              </tbody>
                              <tfoot>
                                   <tr>
                                        <td></td>
                                        <td><?php echo $totalHP; ?></td>
                                        <td><?php echo $totalH; ?></td>
                                        <td><?php echo $totalW; ?></td>
                                        <td><?php echo $totalC; ?></td>
                                   </tr>
                              </tfoot>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>