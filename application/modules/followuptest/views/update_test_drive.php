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
          <div class="panel-heading cusfdbkhcolor lbl"><span class="glyphicon glyphicon-user"></span>&nbsp;<font color='Black'><?php echo $testDrive['enq_added_by_name']; ?> </font><center><font color='red'><?php echo (empty($approval))? 'Your request is not approved.!':'' ?> </font></center></div>
          <div class="panel-body">
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Vehicle</label> :<span class="txt"><?php echo $testDrive['brd_title'] . ' ' . $testDrive['mod_title'] . ' ' . $testDrive['var_variant_name']?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Reg No</label> :<span class="txt"><?php echo $testDrive['val_veh_no']?></span>
                    </div>
               </div>
               <div class="row">
               <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Required/Pitched Vehicle </label> :<span class="txt"><?php echo $testDrive['tdrv_req_or_pitched'] ? 'YES' : 'NO';?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <?php $date1 = date('d-m-yy', strtotime(@$testDrive['tdrv_test_drive_date']));?>
                         <label class="lbl">Date</label> :<span class="txt"><?php echo $date1;?></span>
                    </div>

               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Place</label> :<span class="txt"><?php echo $testDrive['tdrv_test_drive_at']?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Out KM</label> :<span class="txt"><?php echo $testDrive['tdrv_out_km']?></span>
                    </div>

               </div>
          

               <div class="row">
                    <?php if ($testDrive['tdrv_tl_remark']) {?>
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">TL Remarks</label> :<span class="txt"><?php echo $testDrive['tdrv_tl_remark']?></span>
                           </div>
                      <?php }?>
                    <?php if ($testDrive['tdrv_sm_remark']) {?>
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">SM Remarks</label> :<span class="txt"><?php echo $testDrive['tdrv_sm_remark']?></span>
                           </div>
                      <?php }?>

               </div>  
                <div class="row">
                    <?php if ($testDrive['tdrv_executive_remark']) {?>
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">Executive Remak</label> :<span class="txt"><?php echo $testDrive['tdrv_executive_remark']?></span>
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
                         <?php //print_r($testDrive); ?>
                         <label class="lbl">Name</label> :<span class="txt"><?php echo $testDrive['enq_cus_name'] ?></span>
                    </div>
                    
               </div>
             <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                        
                         <label class="lbl">Age</label> :<span class="txt"><?php echo $testDrive['enq_cus_age'] ?></span>
                    </div>
                    
               </div>
             <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         
                         <label class="lbl">Phone</label> :<span class="txt"><?php echo $testDrive['enq_cus_name'] ?></span>
                    </div>
                    
               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Address</label> :<span class="txt"><?php echo $testDrive['enq_cus_address'] ?></span>
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
            
             <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key ?>"><span class="glyphicon glyphicon-ok"></span>&nbsp;  <label class="lbl2">Approved by</label>:<span class="txt2"><?php echo $apprvl['approved_by']?></span></center></a>
        </h4>
      </div>
      <div id="collapse<?php echo $key ?>" class="panel-collapse collapse ">
        <div class="panel-body"><div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Approved date</label> :<span class="txt"><?php echo $apprvl['tdrva_approved_date']?></span>
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
    <?php } ?>
     <div class="row">
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
               <label class="control-label lbl">Stage of Lead</label>
             
                                             <select  class="select2_group form-control cmbStock form-control col-md-7 col-xs-12" 
                                                                    name="tdrv_stage_of_lead" >
                                                                 <option>-Select-</option>
                                                                 <option value="1">Yes</option>
                                                                   <option value="0">No</option>
                                                    
                                                            </select>

          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
               <label class="lbl">In Km</label>
               <input required="" type="text" class="form-control col-md-7 col-xs-12 numOnly" name="tdrv_in_km"  placeholder="In km" value="<?php echo $testDrive['tdrv_in_km']?>" autocomplete="off"> 
          </div>
     </div>

     <div class="row">

          <div class="form-group col-md-6 col-sm-6 col-xs-12">

               <label class="control-label lbl">Expecting Booking</label>
               <div class="form-check">
                    <input required="" class="form-check-input radio-btn" type="radio" <?php echo $testDrive['tdrv_expet_booking']==1 ? 'checked':''?>   name="tdrv_expet_booking"  value="1" >
                    <label class="form-check-label" for="expet_booking">
                         <span class="lbl">Yes</span>
                    </label>
                    <input required="" class="form-check-input radio-btn" type="radio" <?php echo $testDrive['tdrv_expet_booking']==2 ? 'checked':''?> name="tdrv_expet_booking" value="0" >
                    <label class="form-check-label" for="ehmv_met_cus_with_family">
                         <span class="lbl">No</span>
                    </label>
               </div>
          </div>

          <div class="form-group col-md-6 col-sm-6 col-xs-12">
               <label class=" lbl">Price Difference after Test Drive</label>

               <input type="text" class="form-control col-md-7 col-xs-12 " name="tdrv_price_diff"  placeholder="Price Difference" value="<?php echo $testDrive['tdrv_price_diff']?>"> 
          </div>

     </div>
     <div class="row">
         <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label class="lbl">Remark</label> 
                                 <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_remarks2" value="<?php echo $testDrive['tdrv_remarks2']?>"  placeholder="Enter Remark">
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
