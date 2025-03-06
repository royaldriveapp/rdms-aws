<script src="../assets/js/accordion.js" type="text/javascript"></script>
<style>


     .header-default {
          box-sizing: border-box;
          width: 100%;
          padding: 10px;
          border: 1px solid #d1d1d1;
          border-radius: 4px 4px 0 0;
          background-color: #fff;
          color: #3a3a3a;
          margin-bottom: -0.9em !important;
          cursor: pointer;
     }

     .header-default:hover { background-color: #e0e0e0; }

     .header-active {
          background-color: #EDEDED !important;
          margin-bottom: 0px !important;
     }

     .header-active:hover { background-color: #EDEDED !important; }

     .content-default { display: none; }

     .right { float: right; }

     .accordion-content {
          text-align: justify;
          box-sizing: border-box;
          margin: 0px;
          padding: 15px;
          border: 1px solid #d1d1d1;
          border-bottom-left-radius: 5px;
          border-bottom-right-radius: 5px;
     }

     .inline { display: inline; }

     .btn-ordering {
          margin: 0px 10px 0px 10px;
          border: 1px solid inherit;
          background-color: #e0e0e0;
          min-width: 80px;
          border-radius: 4px;
     }

     .btn-ordering:hover {
          border-style: inset;
          background-color: #bcbcbc;
     }

     #btn-div {
          margin-top: 40px;
          text-align: right;
     }
     [data-type="accordion-search"] {
          min-height: 15px;
          border-radius: 4px;
     }
     [data-type="accordion-filter"] {
          min-height: 15px;
          border-radius: 0px;
          min-width: 120px;
          height: 20px;
     }
</style>

<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Royaldrive privacy policy</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
<!--                         <p class="inline">Search in List:</p>
                         <input type="text" placeholder="search in list" name="search" id="search" data-type="accordion-search">-->
                         <div style="margin-bottom: 20px;">
                              <section id="accordion">
                                   <!-- <div data-type="accordion-section" data-filter="type1">
                                        <h5 data-type="accordion-section-title"><i class="fa fa-car"></i> RD Travel policy</h5>
                                        <div class="accordion-content" data-type="accordion-section-body">
                                             <?php //if (!empty($travelPolicy) && (isset($travelPolicy['eligibles'])) && !empty($travelPolicy['eligibles'])) { ?>
                                                  <div class="row">
                                                       <div class="col-md-12 col-sm-12">
                                                            <div class="x_paneld tile">
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="fa fa-car"></i> Own Cars/Km</span>
                                                                      </div>
                                                                      <div style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_own_cars_per_km']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="fa fa-bicycle"></i> Own Two Wheeler/km</span>
                                                                      </div>
                                                                      <div  style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_own_two_whelr_per_km']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="fa fa-coffee"></i> Breakfast</span>
                                                                      </div>
                                                                      <div  style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_breakfast']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="glyphicon glyphicon-cutlery"></i> Lunch</span>
                                                                      </div>
                                                                      <div  style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_lunch']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="glyphicon glyphicon-cutlery"></i> Dinner</span>
                                                                      </div>
                                                                      <div  style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_dinner']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="fa fa-clock-o"></i> If above 15hrs</span>
                                                                      </div>
                                                                      <div  style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_abov_fiften_hrs']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="fa fa-bed"></i> Room Tariff With in Kerala</span>
                                                                      </div>
                                                                      <div  style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_room_tariff_in_kl']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <div class="widget_summary">
                                                                      <div class="w_left" style="width:60%;">
                                                                           <span><i class="fa fa-bed"></i> Room Tariff Outside Kerala</span>
                                                                      </div>
                                                                      <div  style="font-size:15px;">
                                                                           <span><?php echo get_in_currency_format($travelPolicy['desig_room_tariff_out_kl']); ?></span>
                                                                      </div>
                                                                      <div class="clearfix"></div>
                                                                 </div>
                                                                 <?php
                                                                 // if (isset($travelPolicy['eligibles']) && !empty($travelPolicy['eligibles'])) {
                                                                 //      foreach ($travelPolicy['eligibles'] as $key => $value) {
                                                                 //           ?>
                                                                 //           <div class="widget_summary">
                                                                 //                <div class="w_left" style="width:60%;">
                                                                 //                     <span><i class="fa fa-automobile"></i> <?php echo $value['tra_title']; ?></span>
                                                                 //                </div>
                                                                 //                <div  style="font-size:13px;">
                                                                 //                     <span><?php echo $value['modes']; ?></span>
                                                                 //                </div>
                                                                 //                <div class="clearfix"></div>
                                                                 //           </div>
                                                                 //           <?php
                                                                 //      }
                                                                 // }
                                                                 ?>
                                                            </div>
                                                       </div>
                                                  </div>
                                             <?php //} ?>
                                        </div>
                                   </div> -->

                                   <div data-type="accordion-section" data-filter="type1">
                                        <h5 data-type="accordion-section-title"><i class="fa fa-calendar"></i> RD Holidays</h5>
                                        <div class="accordion-content" data-type="accordion-section-body">
                                             <div class="row">
                                                  <div class="col-md-12 col-sm-12">
                                                       <div class="x_paneld tile">
                                                            <table id="courtcyCallList" class="table table-striped table-bordered">
                                                                 <tr>
                                                                      <th>SL.No</th>
                                                                      <th>Name of Holiday</th>
                                                                      <th>Day of the week</th>
                                                                      <th>Date</th>
                                                                      <th>Month</th>
                                                                 </tr>

                                                                 <?php foreach ($holidays as $key => $value) {
                                                                           $now = date('Y-m-d');
                                                                           $date1 = new DateTime(date('Y-m-d', strtotime($value['hrh_date_from'])));
                                                                           $date2 = new DateTime($now);
                                                                           $diff = $date2->diff($date1)->format("%r%a");
                                                                           $color = '';
                                                                           if($diff <= 0) {
                                                                                $color = 'background:#ea9c9c;color:#fff !important;';
                                                                           } else if($diff > 0) {
                                                                                $color = 'background:#24ca07;color:#fff !important;';
                                                                           }
                                                                           ?>
                                                                           <tr style="<?php echo $color;?>">
                                                                                <td><?php echo $key + 1; ?></td>
                                                                                <td><?php echo $value['hrh_title']; ?></td>
                                                                                <td><?php echo date('l', strtotime($value['hrh_date_from'])); ?></td>
                                                                                <td><?php echo date('d-m-Y', strtotime($value['hrh_date_from'])); ?></td>
                                                                                <td><?php echo date('F', strtotime($value['hrh_date_from'])); ?></td>
                                                                           </tr>
                                                                 <?php } ?>
                                                            </table>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                   <!-- Custome policies -->
                                   <?php
                                   if (!empty($policiesOther)) {
                                        foreach ($policiesOther as $key => $value) {
                                             ?>
                                             <div data-type="accordion-section" data-filter="type1">
                                                  <h5 data-type="accordion-section-title"><?php echo $value['pol_title']; ?></h5>
                                                  <div class="accordion-content" data-type="accordion-section-body">
                                                       <div class="row">
                                                            <div class="col-md-12 col-sm-12">
                                                                 <div class="x_paneld tile">
                                                                      <div class="widget_summary">
                                                                           <iframe onload="disableContextMenu();" id="fraDisabled" src="<?php echo 'https://rdms.royaldrive.in/assets/uploads/rdpolicies/' . $value['pol_doc']; ?>#toolbar=0&navpanes=0&zoom=100" 
                                                                                   width="1077" height="780" style="border: none;"></iframe>
                                                                           <div class="clearfix"></div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        <?php }
                                   }
                                   ?>
                                   <!-- -->
                              </section>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function () {
          $("#accordion").accordion();
     });
</script>