<style>
     .txt{
          color: #000!important;
     }
     .enq-sts-bg-{
          background-color:#004099!important;
     }
     .panel-default>.panel-heading {
          background-color: #787b7724!important;
          border-color: #ddd!important;
     }
     .pnl-bg-color{
          background-color:#faf7f799!important;
     }
     .cusfdbkhcolor{
          background-color: #565a541a!important;   
     }
     .pnl-hgt{
          height:338px!important;
     }
     .radio-btn{
          border-radius: 50%!important;
          width: 25px !important;
          height: 25px!important;

          border: 2px solid lightskyblue!important;
          transition: 0.2s all linear!important;
          position: relative!important;
          top: 8px!important;
     }
      .glyphicon-ok{
          color: #00CC00!important;
     }
     .glyphicon-remove{
          color:#e30d0d!important;
     }
     .lbl2 {
    color: black !important;
    font-size: 13px!important;
}
.txt2{
   font-size: 13px!important;  
}
</style>
<div class='flds'>
     <div class="panel pnl-bg-color panel-default enq-sts-bg">
          <div class="panel-heading cusfdbkhcolor lbl"><center><font color='Black'>Request from:<?php echo $homeVisit['enq_added_by_name'];?> </font></center></div>
          <div class="panel-body">
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Vehicle</label> :<span class="txt"><?php echo $homeVisit['brd_title'] . ' ' . $homeVisit['mod_title'] . ' ' . $homeVisit['var_variant_name']?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Reg No</label> :<span class="txt"><?php echo $homeVisit['val_veh_no']?></span>
                    </div>
               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Required/Pitched Vehicle</label> :<span class="txt"><?php echo $homeVisit['tdrv_req_or_pitched']?'Yes':'No'?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <?php $date1 = date('d-m-yy', strtotime($homeVisit['tdrv_test_drive_date']));?>
                         <label class="lbl">Date</label> :<span class="txt"><?php echo $date1;?></span>
                    </div>

               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Place</label> :<span class="txt"><?php echo $homeVisit['tdrv_test_drive_at']?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Out KM</label> :<span class="txt"><?php echo $homeVisit['tdrv_out_km']?></span>
                    </div>

               </div>
               <div class="row">
                    <?php if ($homeVisit['tdrv_tl_remark']) {?>
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">TL Remarks</label> :<span class="txt"><?php echo $homeVisit['tdrv_tl_remark']?></span>
                           </div>
                      <?php }?>
                    <?php if ($homeVisit['tdrv_sm_remark']) {?>
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">SM Remarks</label> :<span class="txt"><?php echo $homeVisit['tdrv_sm_remark']?></span>
                           </div>
                      <?php }?>

               </div>  
               <div class="row">
                    <?php if ($homeVisit['tdrv_executive_remark']) {?>
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">Executive Remak</label> :<span class="txt"><?php echo $homeVisit['tdrv_executive_remark']?></span>
                           </div>
                      <?php }?>
               </div>  
          </div>
     </div>
     <!-- customer details -->
          <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            <?php //print_r($approval['hmva_approval_status']);?>
             <a data-toggle="collapse" data-parent="#accordion" href="#collapse_cus"><span class="glyphicon glyphicon-user"></span>  Customer info</a>
        </h4>
      </div>
      <div id="collapse_cus" class="panel-collapse collapse ">
        <div class="panel-body">
             <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <?php //print_r($homeVisit); ?>
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
                         
                         <label class="lbl">Phone</label> :<span class="txt"><?php echo $homeVisit['enq_cus_name'] ?></span>
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
      <?php if(!empty($approval)){  foreach($approval as $key=>$apprvl){?>
     <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            <?php //print_r($approval['hmva_approval_status']);?>
             <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key ?>"><span class="glyphicon <?php echo $apprvl['tdrva_approval_status']==2 ? ' glyphicon-remove':'glyphicon-ok'?>"></span>&nbsp;  <label class="lbl2"><?php echo $apprvl['tdrva_approval_status']==2 ? ' Rejected by':'Approved by'?></label>:<span class="txt2"><?php echo $apprvl['approved_by']?></span></center></a>
        </h4>
      </div>
      <div id="collapse<?php echo $key ?>" class="panel-collapse collapse ">
        <div class="panel-body"><div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Date</label> :<span class="txt"><?php echo $apprvl['tdrva_approved_date']?></span>
                    </div>
                    
               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Remark</label> :<span class="txt"><?php echo $apprvl['tdrva_remarks']?></span>
                    </div>
                    
               </div></div>
      </div>
    </div>
   
  
  </div>
      <?php } }?>
     <div class="row">

          <div class="form-group col-md-6 col-sm-6 col-xs-12">

               <label class="control-label lbl">Is approved? </label>
               <div class="form-check">
                    <input required="" class="form-check-input radio-btn" type="radio" name="is_approved"  value="1" >
                    <label class="form-check-label" for="expet_booking">
                         <span class="lbl">Yes</span>
                    </label>
                    <input required="" class="form-check-input radio-btn" type="radio" checked="" name="is_approved" value="0" >
                    <label class="form-check-label" for="approved">
                         <span class="lbl">No</span>
                    </label>
               </div>
          </div>
     </div>
     <div class="row">
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
               <label class="lbl">Remark</label> 
               <input type="text" class="form-control col-md-7 col-xs-12 " name="tdrva_remarks"  placeholder="Enter Remark">
          </div>
          <input type="hidden" name="tdrva_master_id" value="<?php echo $homeVisit['tdrv_id'];?>">

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

</div>
