<style>
     .noDataMessage{
          text-align: center;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">                      
                         <h2>Enquiry Pool Details </h2>                        
                         <div class="clearfix"></div>
                         <h5><?php
                                echo $brdTitle = str_replace('_', ' ', $brdTitle);
                              ?></h5>
                    </div>
                    <div class="x_content">
                         <?php
                           if (!empty($enqs)) {
                                $count = $this->reports->getDataCount_detail_pg($enqs['vehicle_details']['veh_varient'], $enqs['vehicle_details']['veh_year']);

                                // print_r($enqs);
                                //    foreach ($enqs as $enq) {
                                ?>
                                <div class="row">
                                     <div class="col-md-3">
                                          <p><b>Brand:</b> <?php echo $enqs['vehicle_details']['brd_title']?></p>
                                          <p><b>Model:</b> <?php echo $enqs['vehicle_details']['mod_title']?></p>
                                          <p><b>Variant:</b> <?php echo $enqs['vehicle_details']['var_variant_name']?></p>
                                          <p><b>Model Year:</b> <?php echo $enqs['vehicle_details']['veh_year']?></p>
                                     </div>

                                     <div class="col-md-3"> 
                                          <p><b>HOT+:</b> <?php echo $count['hot_plus'];?></p>
                                          <p><b>HOT:</b> <?php echo $count['hot'];?></p>
                                          <p><b>WARM:</b> <?php echo $count['warm'];?></p>
                                          <p><b>COLD:</b> <?php echo $count['cold'];?></p>
                                          



                                     </div>
                                     <div class="col-md-3"> 

                                          <p><b>Inquired veh NOS:</b><?php echo $count['hot_plus'] + $count['hot'] + $count['warm'] + $count['cold'];?></p>
                                           <p><b>Total Enquiry	:</b>  <?php echo $count['hot_plus'] + $count['hot'] + $count['warm'] + $count['cold'] + $count['dropCount'];?></p>
                                          <p><b>Drop:</b> <?php echo $count['dropCount'];?></p>
                                          <p><b>Available in Purchase	:</b> <?php echo $count['purchase_count'];?></p>



                                     </div>
                                </div>

                                <div class="table-responsive">
                                     <table class="table table-striped table-bordered ">
                                          <thead style="background-color: gray; color: white;"></thead>
                                          <tbody>
                                               <?php //if (sizeof($enqData['sale']=1)) {?>
                                               <tr data-url="jhjghj">
                                                    <td class="details-control">
                                                         <img src="images/details_open.png" class="btnOpenClose" style="cursor: pointer;">
                                                         <?php //echo $model['mod_title'];?></td>
                                                    <td></td>
                                               </tr>
                                               <?php //}?>
                                               <tr style="display: none;">
                                                    <td class="details-control">
                                                         <h5>No Of Purchase Enq: <?php echo sizeof($enqs['purchase']);
                                               ?> </h5>
                                                         <table class="table table-striped table-bordered">
                                                              <tbody><tr>
                                                                        <th>Customer</th>
                                                                        <th>Phone</th>
                                                                        <th>Sales Exicutive</th>
                                                                        <th>Status</th>
                                                                   </tr>
                                                                   <?php
                                                                   if (sizeof($enqs['purchase'])) {
                                                                        foreach ($enqs['purchase'] as $enqPurchase) {
                                                                             $salesExctv = $this->reports->getSalesEctvName($enqPurchase['salesExictvID']);
                                                                             $status = unserialize(ENQUIRY_UP_STATUS)
                                                                             ?>
                                                                             <tr>
                                                                                  <td><?php echo $enqPurchase['enq_cus_name']?></td>
                                                                                  <td><?php echo $enqPurchase['enq_cus_mobile']?></td>
                                                                                  <td><?php echo $salesExctv->usr_username?></td>
                                                                                  <td><?php echo $status[$enqPurchase['enq_cus_when_buy']];?></td>
                                                                             </tr>
                                                                             <?php
                                                                        }
                                                                   }
                                                                   ?>


                                                              </tbody>
                                                         </table>
                                                         <?php if (sizeof($enqs['purchase']) == 0) {?>
                                                              <span class='noDataMessage' ><p>No data found</p></span>
                                                         <?php }?>
                                                    </td>
                                                    <td>
                                                         <h4>No Of Sale Enq: <?php echo sizeof($enqs['sale'])?></h4>
                                                         <table class="table table-striped table-bordered">
                                                              <tbody><tr>
                                                                        <th>Customer</th>
                                                                        <th>Phone</th>
                                                                        <th>Sales Exicutive</th>
                                                                        <th>Status</th>
                                                                   </tr>
                                                                   <?php
                                                                   foreach ($enqs['sale'] as $enqSale) {
                                                                        $salesExctv = $this->reports->getSalesEctvName($enqSale['salesExictvID']);
                                                                        $status = unserialize(ENQUIRY_UP_STATUS)
                                                                        ?>
                                                                        <tr>
                                                                             <td><?php echo $enqSale['enq_cus_name']?></td>
                                                                             <td><?php echo $enqSale['enq_cus_mobile']?></td>
                                                                             <td><?php echo $salesExctv->usr_username?></td>
                                                                             <td><?php echo $status[$enqSale['enq_cus_when_buy']];?></td>
                                                                        </tr>
                                                                   <?php }?>
                                                              </tbody>
                                                         </table>
                                                         <?php if (sizeof($enqs['sale']) == 0) {?>
                                                              <span class='noDataMessage' ><p>No data found</p></span>
                                                         <?php }?>
                                                    </td>
                                               </tr>
                                          </tbody>
                                     </table>
                                </div>
                                <?php
                                //}
                           }
                         ?>  
                    </div>
               </div>
          </div>
     </div>
</div>

<?php

  function status($status_id) {
       if ($status_id == 1) {
            $status = 'Hot+';
       } elseif ($status_id == 2) {
            $status = 'Hot';
       } elseif ($status_id == 3) {
            $status = 'Warm';
       } elseif ($status_id == 4) {
            $status = 'Cold';
            return $status;
       }
  }
?>