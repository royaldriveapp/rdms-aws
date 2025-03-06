<style>
     .txt {
          color: #000 !important;
     }

     .enq-sts-bg- {
          background-color: #004099 !important;
     }

     .panel-default>.panel-heading {
          background-color: #787b7724 !important;
          border-color: #ddd !important;
     }

     .pnl-bg-color {
          background-color: #faf7f799 !important;
     }

     .cusfdbkhcolor {
          background-color: #565a541a !important;
     }

     .pnl-hgt {
          height: 338px !important;
     }

     .radio-btn {
          border-radius: 50% !important;
          width: 25px !important;
          height: 25px !important;

          border: 2px solid lightskyblue !important;
          transition: 0.2s all linear !important;
          position: relative !important;
          top: 8px !important;
     }

     .glyphicon-ok {
          color: #00CC00 !important;
     }

     .lbl2 {
          color: black !important;
          font-size: 13px !important;
     }

     .txt2 {
          font-size: 13px !important;
     }

     .glyphicon-remove {
          color: #e30d0d !important;
     }
</style>
<div class='flds'>
     <div class="panel pnl-bg-color panel-default enq-sts-bg">
          <div class="panel-heading cusfdbkhcolor lbl"><span class="glyphicon glyphicon-user"></span>&nbsp;<font color='Black'><?php echo $homeVisit['enq_added_by_name']; ?> </font>
               <center>
                    <font color='red'><?php echo (empty($approval)) ? 'Your request is not approved.!' : '' ?> </font>
               </center>
          </div>
          <div class="panel-body">
               <input type="hidden" name="hmv_enq_id" value="<?php echo $homeVisit['hmv_enq_id'] ?>">
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Vehicle</label> :<span class="txt"><?php
                                                                                if ($homeVisit['hmv_travel_mod'] == 13) {

                                                                                     if ($homeVisit['hmv_fleet_veh'] == 1) {
                                                                                          $vehnm = $homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name'];
                                                                                          $veh_type = 'Company veh';
                                                                                          $veh_no = $homeVisit['val_veh_no'];
                                                                                          echo $vehnm . '(' . $veh_type . ')';
                                                                                     } else if ($homeVisit['hmv_fleet_veh'] == 2) {
                                                                                          $vehnm = $homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name'];
                                                                                          $veh_type = 'Stock veh';
                                                                                          $veh_no = $homeVisit['val_veh_no'];
                                                                                          echo $vehnm . '(' . $veh_type . ')';
                                                                                     } else if ($homeVisit['hmv_fleet_veh'] == 3) {
                                                                                          $veh_type = 'Own vehicle';
                                                                                          $veh_no = $homeVisit['hmv_veh_no'];
                                                                                          echo $veh_type;
                                                                                     }
                                                                                } else {
                                                                                     echo $homeVisit['dtm_title'];
                                                                                }
                                                                                //echo $homeVisit['brd_title'] . ' ' . $homeVisit['mod_title'] . ' ' . $homeVisit['var_variant_name']
                                                                                ?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Reg No</label> :<span class="txt"><?php echo @$veh_no ?></span>
                    </div>
               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Travel with</label> :<span class="txt"><?php echo $homeVisit['travel_with'] ?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <?php $date1 = date('d-m-yy', strtotime($homeVisit['hmv_date'])); ?>
                         <label class="lbl">Date</label> :<span class="txt"><?php echo $date1; ?></span>
                    </div>

               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Place</label> :<span class="txt"><?php echo $homeVisit['hmv_place'] ?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Out KM</label> :<span class="txt"><?php echo $homeVisit['hmv_out_km'] ?></span>
                    </div>

               </div>


               <div class="row">
                    <?php if ($homeVisit['hmv_tl_remark']) { ?>
                         <div class="form-group col-md-6 col-sm-6 col-xs-12">
                              <label class="lbl">TL Remarks</label> :<span class="txt"><?php echo $homeVisit['hmv_tl_remark'] ?></span>
                         </div>
                    <?php } ?>
                    <?php if ($homeVisit['hmv_sm_remark']) { ?>
                         <div class="form-group col-md-6 col-sm-6 col-xs-12">
                              <label class="lbl">SM Remarks</label> :<span class="txt"><?php echo $homeVisit['hmv_sm_remark'] ?></span>
                         </div>
                    <?php } ?>

               </div>
               <div class="row">
                    <?php if ($homeVisit['hmv_executive_remark']) { ?>
                         <div class="form-group col-md-6 col-sm-6 col-xs-12">
                              <label class="lbl">Executive Remarks</label> :<span class="txt"><?php echo $homeVisit['hmv_executive_remark'] ?></span>
                         </div>
                    <?php } ?>

                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Track card:</label> :<a title="Print track card" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($homeVisit['hmv_enq_id'])); ?>">
                              <span class="glyphicon glyphicon-print"></span>
                         </a>
                         &nbsp;
                         <label class="lbl">Followup:</label> :<a title="Followup" href="<?php echo site_url('followup/viewFollowup/' . encryptor($homeVisit['hmv_enq_id'])); ?>">
                              <span class="fa fa-calendar-check-o"></span>
                         </a>
                    </div>
               </div>


          </div>
     </div>
     <!-- customer details -->
     <div class="panel-group" id="accordion">
          <div class="panel panel-default">
               <div class="panel-heading">
                    <h4 class="panel-title">
                         <?php //print_r($approval['hmva_approval_status']);
                         ?>
                         <a data-toggle="collapse" data-parent="#accordion" href="#collapse_cus"><span class="glyphicon glyphicon-user"></span> Customer info</a>
                    </h4>
               </div>
               <div id="collapse_cus" class="panel-collapse collapse ">
                    <div class="panel-body">
                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <?php //print_r($homeVisit); 
                                   ?>
                                   <label class="lbl">Name</label> :<span class="txt"><?php echo $homeVisit['enq_cus_name'] ?></span>
                              </div>

                         </div>
                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">

                                   <label class="lbl">Age</label> :<span class="txt"><?php echo $homeVisit['enq_cus_age'] ?></span>
                              </div>

                         </div>
                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">

                                   <label class="lbl">Phone</label> :<span class="txt"><?php echo $homeVisit['enq_cus_mobile'] ?></span>
                              </div>

                         </div>
                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="lbl">Address</label> :<span class="txt"><?php echo $homeVisit['enq_cus_address'] ?></span>
                              </div>

                         </div>

                    </div>
               </div>
          </div>


     </div>
     <!-- @customer details -->
     <?php if (!empty($approval)) {
          foreach ($approval as $key => $apprvl) { ?>
               <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                         <div class="panel-heading">
                              <h4 class="panel-title">
                                   <?php if ($apprvl['hmva_approval_status'] == 1) { ?>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key ?>"><span class="glyphicon glyphicon-ok"></span>&nbsp; <label class="lbl2">Approved by</label>:<span class="txt2"><?php echo $apprvl['approved_by'] ?></span></center></a>
                                   <?php } elseif ($apprvl['hmva_approval_status'] == 2) { ?>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key ?>"><span class="glyphicon glyphicon-remove"></span>&nbsp; <label class="lbl2">Rejected by</label>:<span class="txt2"><?php echo $apprvl['approved_by'] ?></span></center></a>
                                   <?php } ?>

                              </h4>
                         </div>
                         <div id="collapse<?php echo $key ?>" class="panel-collapse collapse">
                              <div class="panel-body">
                                   <div class="row">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                             <label class="lbl">Date</label> :<span class="txt"><?php echo $apprvl['hmva_approved_date'] ?></span>
                                        </div>

                                   </div>
                                   <div class="row">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                             <label class="lbl">Remark</label> :<span class="txt"><?php echo $apprvl['hmva_remarks'] ?></span>
                                        </div>

                                   </div>
                              </div>
                         </div>
                    </div>


               </div>
          <?php } ?>
          <div class="row">
               <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="hmv_id" value="<?php echo $homeVisit['hmv_id']; ?>">
                    <label class="lbl">In Date</label>
                    <input required="" type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerHmVstDMY" name="hmv_in_date" id="date" placeholder="In Date " value="<?php echo $homeVisit['hmv_in_date'] ?>" autocomplete="off">

               </div>
               <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="lbl">In Km</label>
                    <input required="" type="text" class="form-control col-md-7 col-xs-12 numOnly" name="hmv_in_km" placeholder="In km" value="<?php echo $homeVisit['hmv_in_km'] ?>" autocomplete="off">
               </div>
          </div>

          <div class="row">

               <div class="form-group col-md-6 col-sm-6 col-xs-12">

                    <label class="control-label lbl">Met the Customer with Family </label>
                    <div class="form-check">
                         <input required="" class="form-check-input radio-btn" type="radio" <?php echo $homeVisit['hmv_met_cus_with_family'] == 1 ? 'checked' : '' ?> name="hmv_met_cus_with_family" value="1">
                         <label class="form-check-label" for="expet_booking">
                              <span class="lbl">Yes</span>
                         </label>
                         <input required="" class="form-check-input radio-btn" type="radio" <?php echo $homeVisit['hmv_met_cus_with_family'] == 2 ? 'checked' : '' ?> name="hmv_met_cus_with_family" value="2">
                         <label class="form-check-label" for="ehmv_met_cus_with_family">
                              <span class="lbl">No</span>
                         </label>
                    </div>
               </div>

               <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class=" lbl">Discussion Time</label>

                    <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_discussion_time" placeholder="Discussion Time " value="<?php echo $homeVisit['hmv_discussion_time'] ?>">
               </div>

          </div>
          <div class="row">
               <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <label class="lbl">Remark</label>
                    <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_remarks2" value="<?php echo $homeVisit['hmv_remarks2'] ?>" placeholder="Enter Remark">
               </div>

          </div>
          <!--                         <div class="row">
                                  
                                     <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="lbl">Met the Customer with Family</label>
                                        <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_met_cus_with_family" placeholder="Met the Customer with Family"> 
                                   </div>
                                     <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label class="control-label lbl">Executive Remak</label>
                                      
                                            <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_executive_remark"  placeholder="Executive Remak">
                                      
                                   </div>
                                    </div>
                              <div class="row">
                                  
                                     <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label class="lbl">TL Remark</label>
                                        <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_tl_remark" placeholder="TL Remark"> 
                                   </div>
                                     <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label class="lbl">SM Remark</label>
                                      
                                            <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_sm_remark"  placeholder="SM Remark">
                                      
                                   </div>
                                    </div>-->


          <!--                         <div class="row">
                                   <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label class="control-label lbl">Approved home visit</label>
                                      
                                             <input type="text" class="form-control col-md-7 col-xs-12 " name="approved"  placeholder="Approved home visit">
                                   </div>
                                            
            
                         </div>-->
     <?php } ?>
</div>