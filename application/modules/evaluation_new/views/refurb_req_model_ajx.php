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
          <div class="panel-heading cusfdbkhcolor lbl"><center><font color='Black'>Request <?php //print_r($refurbs);?> </font></center></div>
          <div class="panel-body">
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Vehicle</label> :<span class="txt"><?php echo $refurbs['brd_title'] . ' ' . $refurbs['mod_title'] . ' ' . $refurbs['var_variant_name']?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Reg No</label> :<span class="txt"><?php echo $refurbs['val_veh_no']?></span>
                    </div>
               </div>
               <div class="row">
<!--                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Travel with</label> :<span class="txt"><?php echo $refurbs['travel_with']?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <?php $date1 = date('d-m-yy', strtotime($refurbs['hmv_date']));?>
                         <label class="lbl">Date</label> :<span class="txt"><?php echo $date1;?></span>
                    </div>-->

               </div>
               <div class="row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Location </label> :<span class="txt"><?php echo unserialize(Showrooms)[$refurbs[val_showroom]] ?></span>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                         <label class="lbl">Stock date </label> :<span class="txt"><?php echo date('d-m-Y', strtotime($refurbs['val_purchased_date']));?></span>
                    </div>

               </div>
               <div class="row">
                   
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">Source Of Purchase</label> :<span class="txt"><?php  echo $refurbs['val_type']==1?'Purchase':($refurbs['val_type']==3?'Park and sale':($refurbs['val_type']==4?'Park and sale':($refurbs['val_type']==5?'Exchange':'')));?></span>
                           </div>
                     
                    
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">KM</label> :<span class="txt"><?php echo $refurbs['val_km']?></span>
                           </div>
                      

               </div>  
               <div class="row">
                    
                           <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="lbl">Refurbing Job List </label> :<span class="txt"><?php echo $refurbs['upgrd_key']?></span>
                           </div>
                     
               </div>  
          </div>
     </div>
   <div class="row">
<div class="form-group col-md-6 col-sm-6 col-xs-12">

               <label class="control-label lbl">Is approved? </label>
               <div class="form-check">
                    <input required="" class="form-check-input radio-btn" type="radio" name="upgrd_is_approved"  value="1" >
                    <label class="form-check-label" for="expet_booking">
                         <span class="lbl">Yes</span>
                    </label>
                    <input required="" class="form-check-input radio-btn" type="radio" checked="" name="upgrd_is_approved" value="0" >
                    <label class="form-check-label" for="upgrd_is_approved">
                         <span class="lbl">No</span>
                    </label>
               </div>
          </div>
     </div>
     <div class="row">
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
               <label class="lbl">Remark</label> 
               <input type="text" class="form-control col-md-7 col-xs-12 " name="upgrd_remarks"  placeholder="Enter Remark">
          </div>
          <input type="hidden" name="upgrd_id" value="<?php echo $refurbs['upgrd_id'];?>">

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
