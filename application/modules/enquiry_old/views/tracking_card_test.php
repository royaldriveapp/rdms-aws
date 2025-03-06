<style>
     tr:hover {
          background-color:#ffcb05!important;
          color: black!important;
          /*          font-weight: 550;*/

     }
     .tbl-one tr:hover {
          background-color: white !important;
          color: black!important;
          font-weight: 21;
     }
     .tr-bg-blkj{
          background-color:#000000; 
          color: #ffffff!important;
     }
     .td-bg-valj{
          /*          background-color:#ffcb05; 
                    color: black!important;*/
          background-color:#000000; 
          color: #ffffff!important;
     }
     .tr-bg{
          background-color:#000000; 
          color: #ffffff!important;
     }
     .td-gray{
          background-color:gray; 
          color: #ffffff!important;  
     }
     .td-white{
          background-color:whitesmoke; 
          color:black!important;  
     }

     .th-bg{
          /*         background-color:#1bb877!important;*/
          background-color:#9eafbaeb!important;
          color: black!important;
          font-weight: 550;  
     }
     /*     .tb-man,th{
               color: white !important;     
          }*/
     .vehDetailsBuy {
          color: black;
          background-color: #9eafba;
          border: 4px dotted #fffffff2;
          /* padding: .5em; */
     }    
     .labl-blk{
          color: black!important;
          font-weight: 550;    
     }
     .reg-no{
          background-color: #9eafba!important;
     }
     .bg-veh{
          background-color: #090909bf!important;
          color: #fefefe!important;
     }
     .pding{
          padding: 1px!important;
     }
     .timeline .block {
          margin: 19px 0 -1px 57px!important;
          border-left: 3px solid #e8e8e8!important;
          /* overflow: visible; */
          padding: 27px 15px!important;
     }
     .timeline .tags {
          position: absolute!important;
          top: 15px!important;
          left: -49px!important;
          width: 90px!important;
     }
     .wrd-wrp{
          word-wrap: break-word;
     }
     .req_add_new{
          /*           background-color:#141213; */
          background-color:#98cdd9; 
          border: 4px dotted #fffffff2
     }
     hr.dot-line {
          border-top: 1px dotted red;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Track card for <?php echo $trackCard['enq_cus_name']; ?></h2>
                         <div style="float: right;">
                              <?php
                              if ($trackCard['sgrd_need_verification'] == 1) {
                                   if ($trackCard['enq_customer_grade_verify_by'] != 0) {
                                        echo $trackCard['sgrd_grade'];
                                   } else {
                                        echo 'Not verified';
                                   }
                              } else {
                                   echo $trackCard['sgrd_grade'];
                              }
                              ?>
                         </div>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                              <table class="table tblPrintHeader" style="border-bottom: 2px solid #ffcb05;">
                                   <tbody>
                                        <tr>
                                             <td><img src="./images/logo.jpg"/></td>
                                             <td style="text-align: center;padding-top: 50px;"><strong>TRACK CARD</strong></td>
                                             <td style="text-align: right;"><?php echo isset($showRoom['shr_address']) ? $showRoom['shr_address'] : ''; ?></td>
                                        </tr>
                                   </tbody>
                              </table>

                              <table class="table table-striped table-bordered" style="margin-left: auto; margin-right: auto;">
                                   <tbody>
                                        <tr style="height: 35px;">
                                             <td style="width: 670px; height: 35px;" colspan="7">
                                                  <p style="text-align: center;"><strong>ROYAL DRIVE Pre Owned Cars LLP <?php echo $trackCard['shr_location']; ?>...</strong></p>
                                             </td>
                                        </tr>

                                   </tbody>
                              </table>
                              <div class="row">
                                   <div class="col-md-9">
                                        <table class="table table-stripedj table-bordered tbl-one" style="margin-left: 2px; margin-right: auto;width: 70%;">

                                             <tbody>
                                                  <tr class="tr-bg">
                                                       <td class="td-gray"><b>First Touch Enq Date </b>   </td>
                                                       <td class="td-white"><?php echo date('j M Y', strtotime($trackCard['enq_entry_date'])); ?></td>
                                                       <td class="td-gray"><b>Division </b> </td>
                                                       <td class="td-white"><?php
                                                            echo $trackCard['div_name'];
                                                            ?></td>
                                                       <td class="td-gray"><b>Branch </b></td>
                                                       <td class="td-white"><?php echo $trackCard['shr_location']; ?></td>

                                                       <td  class="td-gray"><b>Mode of enquiry </b></td>
                                                       <td  class="td-white"><?php
                                                            $mod_enq = unserialize(MODE_OF_CONTACT);
                                                            echo $mod_enq[$trackCard['enq_mode_enq']];
                                                            ?>
                                                       </td>

                                                       <td class="td-gray"><b>Type Of Enguiry </b> </td>
                                                       <td  class="td-white">
                                                            <?php
                                                            if ($trackCard['enq_cus_status'] == 1) {
                                                                 echo 'Sales';
                                                            } else if ($trackCard['enq_cus_status'] == 2) {
                                                                 echo 'Purchase';
                                                            } else {
                                                                 echo 'Exchange';
                                                            }
                                                            ?>
                                                       </td>


                                                       <td class="td-gray"><b>Category Of cust</b> </td>
                                                       <td class="td-white"><?php echo $trackCard['sgrd_grade']; ?></td>


                                                  </tr>
                                                  <tr class="tr-bg">
                                                       <td class="td-gray"><b>Re Generated Enq Date </b> </td>
                                                       <td class="td-white">---</td>
                                                       <td class="td-gray"><b>Re Generated mode </b> </td>
                                                       <td class="td-white">---</td>
                                                       <td class="td-gray"><b>Refferer Name </b> </td>
                                                       <td class="td-white">Shaji </td>
                                                       <td class="td-gray"><b>Contact num</b> </td>
                                                       <td  class="td-white">96571545</td>

                                                       <td  class="td-gray"><b>Enq Status </b> </td>
                                                       <td  class="td-white"><?php
                                                            $cus_when_buy = unserialize(FOLLOW_UP_STATUS);
                                                            echo $cus_when_buy[$trackCard['enq_cus_when_buy']];
                                                            ?> </td>

                                                       <td class="td-gray"><b>Lead Status. </b></td>
                                                       <td  class="td-white">Refurbishment </td>



                                                  </tr>
                                                  <tr class="tr-bg">
                                                       <td class="td-gray"><b>Evaluation Status.   </b> </td>
                                                       <td class="td-white">Pending</td>
                                                       <td class="td-gray"><b>Executive   </b> </td>
                                                       <td class="td-white"></td>
                                                       <td class="td-gray"><b> Team Leader  </b> </td>
                                                       <td class="td-white"></td>
                                                       <td class="td-gray"><b> MIS </b> </td>
                                                       <td class="td-white"></td>
                                                       <td class="td-gray"><b> PM </b> </td>
                                                       <td class="td-white"></td>
                                                       <td class="td-gray"><b>  </b> </td>
                                                       <td class="td-white">	</td>

                                                  </tr>

                                                  <tr class="tr-bg">
                                                       <td class="td-gray"><b>Customer Name </b>   </td>
                                                       <td class="td-white"><?php echo $trackCard['enq_cus_name'] ?></td>
                                                       <td class="td-gray"><b>Mobile NO</b>   </td>
                                                       <td class="td-white"><?php echo $trackCard['enq_cus_mobile'] ?></td>
                                                       <td class="td-gray"><b>Whatapp No</b>   </td>
                                                       <td class="td-white"><?php echo $trackCard['enq_cus_whatsapp'] ?> </td>
                                                       <td class="td-gray"><b>Email ID </b>   </td>
                                                       <td class="td-white"> <?php echo $trackCard['enq_cus_email'] ?></td>
                                                       <td class="td-gray"><b>Resident Address</b>   </td>
                                                       <td class="td-white"><?php echo $trackCard['enq_cus_address'] ?> </td>
                                                       <td class="td-gray"><b>Office Address </b>   </td>
                                                       <td class="td-white"><?php echo $trackCard['enq_cus_ofc_address'] ?> </td>


                                                  </tr>
                                                  <tr class="tr-bg">
                                                       <td class="td-gray"><b>Place</b>   </td>
                                                       <td class="td-white"><?php echo $trackCard['enq_cus_city'] ?> </td>
                                                       <td class="td-gray"><b>District</b> </td>
                                                       <td class="td-white"><?php echo $trackCard['std_district_name'] ?></td>
                                                       <td class="td-gray"><b>Profession</b> </td>
                                                       <td  class="td-white"><?php echo $trackCard['occ_name'] ?></td>
                                                       <td class="td-gray"><b>Category </b> </td>
                                                       <td  class="td-white"><?php echo $trackCard['occ_cat_name'] ?></td>
          <!--                                             <td class="tr-bg-blk"><b>MIS</b>  </td>
                                                       <td class="td-bg-val">---</td>
          
                                                       <td  class="tr-bg-blk"><b>PM </b> </td>
                                                       <td  class="td-bg-val">--- </td>-->

                                                       <td class="td-gray"><b>Age </b></td>
                                                       <td  class="td-white"><?php echo $trackCard['enq_cus_age'] ?> </td>
                                                       <td class="td-gray"><b>Gender</b> </td>
                                                       <td  class="td-white"><?php
                                                            $gender = unserialize(GENDER);
                                                            echo $gender[$trackCard['enq_cus_gender']]
                                                            ?></td>   

                                                  </tr>
                                                  <tr class="tr-bg">
          <!--                                             <td class="td-gray"><b>Profession</b> </td>
                                                       <td  class="td-white"><?php echo $trackCard['occ_name'] ?></td>
                                                       <td class="td-gray"><b>Categorry </b> </td>
                                                       <td  class="td-white"><?php echo $trackCard['occ_cat_name'] ?></td>-->
                                                       <td class="td-gray"><b>Purpose of  Sales</b> </td>
                                                       <td  class="td-white">---</td>
                                                       <td class="td-gray"> </td>
                                                       <td  class="td-white"></td>

                                                       <td class="td-gray"><b>  </b></td>
                                                       <td  class="td-white"> </td>
                                                       <td class="td-gray"><b></b> </td>
                                                       <td  class="td-white"></td>
                                                  </tr>

                                             </tbody>  
                                        </table>

                                   </div><!-- @col1 -->
                                   <div class="col-md-3">
                                             <?php if (isset($trackCard['followup']) && !empty($trackCard['followup'])) { ?>
                                             <p class="labl-blk">Tele Caller Remrks  </p>
                                             <ul class="list-unstyled timeline">
                                                  <?php
                                                  $totalVehicles = count($trackCard['vehicle_sall']) + count($trackCard['vehicle_buy']);
                                                  $index = 0;
                                                  foreach ((array) $trackCard['followup'] as $key => $value) {
                                                       if (($value['foll_is_cmnt'] == 1) && ($value['foll_parent'] == 0)) {
                                                            if ((check_permission('folup_trck_comment', 'viewgeneralcomment'))) {
                                                                 ?>
                                                                 <li>
                                                                      <div class="block">
                                                                           <div class="tags" style="width: 32%;">
                                                                                <div class="profile_pic">
                                                                                     <?php
                                                                                     echo img(array('src' => './assets/uploads/avatar/' . $value['usr_avatar'], 'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                                     ?>
                                                                                </div>
                                                                           </div>
                                                                           <div class="block_content">
                                                                                <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                     <span><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d h:i:s', strtotime($value['foll_entry_date'])); ?></span>
                                                                                </p>
                                                                                <?php
                                                                                echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';
                                                                                ?>
                                                                           </div>
                                                                           <!-- Repeated contents -->
                                                                           <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;" class="wrd-wrp">
                                                                                <p class="excerpt"><?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?></p>
                                                                           </div>
                                                                                <?php if ($value['folloup_added_by_id'] != $this->uid) { ?>
                                                                                <p class="excerpt alignright">Added by : <?php
                                                                                     echo isset($value['folloup_added_by']) ?
                                                                                             $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                                     ?>
                                                                                </p>
                                                                           <?php } else { ?>
                                                                                <p class="excerpt alignright">Added by : Self</p>
                                                                 <?php } ?>
                                                                      </div>
                                                                 </li>
                                                                 <?php
                                                            }
                                                       } else {
                                                            ?>
                                                            <li>
                                                                 <div class="block">
                                                                      <?php
                                                                      if ($key % $totalVehicles == 0) {
                                                                           if ($value['foll_status'] == 1) { // Hot
                                                                                ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:red;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid red}</style> <?php
                                                                           } else if ($value['foll_status'] == 2) { // Warm
                                                                                ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:yellowgreen;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid yellowgreen}</style> <?php
                                                                           } else if ($value['foll_status'] == 3) { // Cool
                                                                                ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:green;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid green}</style> <?php }
                                                                           ?>

                                                                           <!--                                                                   <div class="tags">
                                                                                                                                                   <a data-url="<?php echo site_url('followup/getSingleFollowup') . '/' . encryptor($trackCard['enq_id']) . '/' . date('Y-m-d', strtotime($value['foll_next_foll_date'])); ?>" 
                                                                                                                                                      href="javascript:;" class="tagcolor<?php echo $value['foll_id']; ?> tag"
                                                                                                                                                      min-date="<?php echo date('D M d Y', strtotime($value['foll_next_foll_date'])); ?>">
                                                                                                                                                        <span><?php echo date('j M Y', strtotime($value['foll_next_foll_date'])); ?></span>
                                                                                                                                                   </a>
                                                                                                                                              </div>-->
                                                                           <span><?php echo date('j M Y', strtotime($value['foll_next_foll_date'])); ?></span>
               <?php } ?>
                                                                      <!--                                                              <div class="block_content">
                                                                                                                                         <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                                                                              <span><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'] ?></span>
                                                                                                                                         </p>
                                                                      <?php echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : ''; ?>
                                                                                                                                    </div>-->
                                                                      <!-- Repeated contents -->
               <?php if ((($key + 1) % $totalVehicles) == 0) { ?>
                                                                           <div style="font-style: italic;background: #E7E7E7;padding: 10px;" class="wrd-wrp">
                                                                                <p class="excerpt">Remarks : <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?></p>
                                                                                <p class="excerpt">
                                                                                     <?php
                                                                                     $mod = unserialize(MODE_OF_CONTACT);
                                                                                     echo isset($mod[$value['foll_contact']]) ? 'Mode of contact : ' . $mod[$value['foll_contact']] : ''
                                                                                     ?>
                                                                                </p>
                                                                                <p class="excerpt">Next action plan : <?php echo isset($value['foll_action_plan']) ? $value['foll_action_plan'] : ''; ?></p>
                                                                           </div>
                                                                           <?php } if ($value['folloup_added_by_id'] != $this->uid) { ?>
                                                                           <p class="excerpt alignright">Added by : <?php
                                                                                echo isset($value['folloup_added_by']) ?
                                                                                        $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                                ?>
                                                                           </p>
                                                                      <?php } else { ?>
                                                                           <p class="excerpt alignright">Added by : Self</p>
                                                                      <?php } ?>
                                                                      <!-- Load comments -->
                                                                      <?php
                                                                      if (check_permission('folup_trck_comment', 'viewindividualcomment')) {
                                                                           $comments = $this->followup->getComments($value['foll_id']);
                                                                           if (!empty($comments)) {
                                                                                foreach ($comments as $k => $cmd) {
                                                                                     ?>
                                                                                     <div style="width: 100%;float: left;">
                                                                                          <div class="block_content">
                                                                                               <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                               <div><i class="fa fa-clock-o"></i> 
                                                                                                         <?php if ($cmd['folloup_added_by_id'] != $this->uid) { ?>
                                                                                                         <p class="excerpt alignright">Added by : <?php
                                                                                                              echo isset($cmd['folloup_added_by']) ?
                                                                                                                      $cmd['folloup_added_by'] . ' (' . $cmd['shr_location'] . ')' : '';
                                                                                                              ?>
                                                                                                         </p>
                                                                                                    <?php } else { ?>
                                                                                                         <p class="excerpt alignright">Added by : Self</p>
                              <?php } ?>
                              <?php echo date('Y-m-d h:i:s', strtotime($cmd['foll_entry_date'])); ?></div>
                                                                                               </p>
                                                                                          </div>
                                                                                          <div class="tags" style="width: 25%;position: inherit;">
                                                                                               <div class="profile_pic">
                                                                                                    <?php
                                                                                                    echo img(array('src' => './assets/uploads/avatar/' . $cmd['usr_avatar'],
                                                                                                        'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                                                    ?>
                                                                                               </div>
                                                                                          </div>
                                                                                          <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;width: 90%;float: right;">
                                                                                               <p class="excerpt"><?php echo isset($cmd['foll_remarks']) ? $cmd['foll_remarks'] : ''; ?></p>
                                                                                          </div>
                                                                                     </div>
                                                                                     <?php
                                                                                }
                                                                           }
                                                                      }
                                                                      ?>
                                                                 </div>
                                                            </li>
                                                            <?php
                                                            $index++;
                                                       }
                                                  }
                                                  ?>
                                             </ul>
<?php } ?>
                                   </div><!-- @col2 -->
                              </div><!-- row1 -->

<!--                              <table class="table table-stripedj table-bordered" style="margin-left: auto; margin-right: auto;">

      <tbody>
       
           <tr class="tr-bg">
                <td class="tr-bg-blk"><b>Customer Name </b>   </td>
                <td class="td-bg-val">Jaefar sadikh</td>
                <td class="tr-bg-blk"><b>Mobile NO</b>   </td>
                <td class="td-bg-val">8129057105</td>
                <td class="tr-bg-blk"><b>Whatapp No</b>   </td>
                <td class="td-bg-val">8129057105 </td>
                <td class="tr-bg-blk"><b>Email ID </b>   </td>
                <td class="td-bg-val"> cmj@g.com</td>
                <td class="tr-bg-blk"><b>Resident Address</b>   </td>
                <td class="td-bg-val">Lorem Ipsum is simply dummy text of the printing and typesetting industry </td>
                <td class="tr-bg-blk"><b>Office Address </b>   </td>
                <td class="td-bg-val">Lorem Ipsum is simply dummy text of the pri esetting industry </td>


           </tr>
           <tr class="tr-bg">
                <td class="tr-bg-blk"><b>Place</b>   </td>
                <td class="td-bg-val">--- </td>
                <td class="tr-bg-blk"><b>District</b> </td>
                <td class="td-bg-val"></td>
                <td class="tr-bg-blk"><b>Profession</b> </td>
                <td  class="td-bg-val">---</td>
                <td class="tr-bg-blk"><b>Category </b> </td>
                <td  class="td-bg-val">---</td>
                <td class="tr-bg-blk"><b>MIS</b>  </td>
                <td class="td-bg-val">---</td>

                <td  class="tr-bg-blk"><b>PM </b> </td>
                <td  class="td-bg-val">--- </td>

                <td class="tr-bg-blk"><b>Age </b></td>
                <td  class="td-bg-val">--- </td>
                <td class="tr-bg-blk"><b>Gender</b> </td>
                <td  class="td-bg-val">---</td>

           </tr>
           <tr class="tr-bg">
                <td class="tr-bg-blk"><b>Profession</b> </td>
                <td  class="td-bg-val">---</td>
                <td class="tr-bg-blk"><b>Categorry </b> </td>
                <td  class="td-bg-val">---</td>
                <td class="tr-bg-blk"><b>Purpose of  Sales</b> </td>
                <td  class="td-bg-val">---</td>
                <td class="tr-bg-blk"> </td>
                <td  class="td-bg-val"></td>

                <td class="tr-bg-blk"><b>  </b></td>
                <td  class="td-bg-val"> </td>
                <td class="tr-bg-blk"><b></b> </td>
                <td  class="td-bg-val"></td>
           </tr>

      </tbody>
 </table>-->

                              <table class="table table-stripedj table-bordered bg-clr tb-man" style="width:72%">
                                   <thead>
                                        <tr class="th-bg">
                                             <th>MAN</th>
                                             <th>Name</th>
                                             <th>Phone</th>
                                             <th>Relation</th>
                                             <th>Remarks</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr class="tr-bg">
                                             <th class="th-bg">Money</th>
                                             <td><?php echo $trackCard['enq_money_name']; ?></td> 
                                             <td><?php echo $trackCard['enq_money_phone']; ?></td>
                                             <td><?php echo $trackCard['enq_money_relation']; ?></td>
                                             <td><?php echo $trackCard['enq_money_remarks']; ?></td>
                                        </tr>
                                        <tr class="tr-bg">
                                             <th class="th-bg">Need</th>
                                             <td><?php echo $trackCard['enq_need_name']; ?></td> 
                                             <td><?php echo $trackCard['enq_need_phone']; ?></td>
                                             <td><?php echo $trackCard['enq_need_relation']; ?></td>
                                             <td><?php echo $trackCard['enq_need_remarks']; ?></td>
                                        </tr>
                                        <tr class="tr-bg">
                                             <th class="th-bg">Authority</th>
                                             <td><?php echo $trackCard['enq_authority_name']; ?></td> 
                                             <td><?php echo $trackCard['enq_authority_phone']; ?></td>
                                             <td><?php echo $trackCard['enq_authority_relation']; ?></td>
                                             <td><?php echo $trackCard['enq_authority_remarks']; ?></td>
                                        </tr>
                                   </tbody>
                              </table>
                              <!-- vehicle details -->
                              <div class="row">
                                   <div class="col-md-9"> 
                                        <?php
                                        if (isset($trackCard['vehicle_buy']) && !empty($trackCard['vehicle_buy'])) {
                                             foreach ($trackCard['vehicle_buy'] as $key => $value) {
                                                  ?>

                                                  <div class="table-responsive divVehDetailsBuy" style="">
                                                       <table id="datatable-responsive" class="vehDetailsBuy table table-stripedj table-bordered jdt-responsive nowrapk" cellspacing="0"style="width:97%">
                                                            <thead>
                                                                 <tr class="bg-veh pding">
                                                                      <td colspan="12">                                            
                                                            <center>VEHICLE DETAILS </center>
                                                            <td>

                                                                 </tr>

                                                            <tr>
                                                                 <th class="lbl-blk">Brand</th>
                                                                 <th class="lbl-blk">Model</th>
                                                                 <th class="lbl-blk">Variant</th>
                                                                 <th class="lbl-blk">Fuel</th>
                                                                 <th class="lbl-blk">Model year</th>
                                                                 <th class="lbl-blk">Color</th>
                                                                 <th class="lbl-blk">Colour in RC</th>
                                                                 <th class="lbl-blk">KM</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="tbd">
                                                                 <tr>
                                                                      <td>
          <?php echo $value['brd_title']; ?>
                                                                      </td>
                                                                      <td><?php echo $value['mod_title']; ?></td>
                                                                      <td><?php echo $value['var_variant_name']; ?></td>
                                                                      <td>
          <?php
          $fuel = unserialize(FUAL);
          echo $fuel[$value['veh_fuel']];
          ?>
                                                                      </td>
                                                                      <td>
                                                                           <?php echo $value['veh_year']; ?>
                                                                      </td>
                                                                      <td>
                                                                           <?php
                                                                           $vehicleColor = getVehicleColors($value['veh_color']);
                                                                           print_r($vehicleColor['vc_color']);
                                                                           ?> 
                                                                      </td>
                                                                      <td><?php
                                                                 $vehicleColor = getVehicleColors($value['veh_color']);
                                                                 echo $vehicleColor['vc_color'];
                                                                 ?></td>
                                                                      <td>
          <?php echo $value['veh_km_from']; ?> 
                                                                      </td>
                                                                 </tr>
                                                                 <tr>
               <!--                                                       <td colspan="2">
                                                                           <select data-placeholder="Select Color" name="vehicle[buy][veh_color_in_rc][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks">
                                                                                <option value="">-Color in RC-</option>
                                                                                                                                                        <option value="1">Red</option>
                                                                                                                                                          <option value="2">Black</option>
                                                                                                                                                          <option value="3">Green</option>
                                                                                                                                                          <option value="4">Grey</option>
                                                                                                                                                          <option value="5">Blue</option>
                                                                                                                                                          <option value="6">White</option>
                                                                                                                                                          <option value="7">Yellow</option>
                                                                                                                                                          <option value="8">Silver</option>
                                                                                                                                                          <option value="14">Brown</option>
                                                                                                                                              </select>  
                                                                      </td>-->
                                                                      <td colspan="4">
                                                                           <p class="labl-blk">Delivery Location </p>  <?php echo $value['veh_delivery_location']; ?> 
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Delivery State </p><?php echo $value['veh_delivery_state']; ?>
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Dealership </p><?php echo $value['veh_dealership']; ?>
                                                                      </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="2">
          <?php
          $regNo = explode("-", $value['veh_reg']);
          ?>
                                                                           <p class="labl-blk">Registration: NO</p>
                                                                           <input disabled=""  style="width: 60px;text-transform:uppercase;" class="reg-no form-control col-md-3 col-xs-3" type="text" value="<?php echo $regNo[0]; ?>">
                                                                           <input disabled=""  style="width: 40px;" class="reg-no form-control col-md-3 col-xs-3 numOnly" type="text" value="<?php echo $regNo[1]; ?>">
                                                                           <input disabled=""  style="width: 50px;text-transform:uppercase;" class="reg-no form-control col-md-3 col-xs-3" type="text" value="<?php echo $regNo[2]; ?>">
                                                                           <input disabled="" style="width: 60px;" class="reg-no form-control col-md-3 col-xs-3 numOnly" type="text" value="<?php echo $regNo[3]; ?>">
                                                                      </td>
                                                                      <td colspan="1">
                                                                           <p class="labl-blk">Re Registration</p>
                                                                           <?php echo $value['veh_re_reg']; ?>
                                                                      </td>


                                                                      <td colspan="1">
                                                                           <p class="labl-blk">No Of ownes</p>
          <?php echo $value['veh_owner']; ?>
                                                                      </td>
                                                                      <td colspan="1">
                                                                           <p class="labl-blk">Comprossr</p>
          <?php echo $value['veh_comprossr']; ?>
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Chassis number</p>
          <?php echo $value['veh_chassis_number']; ?>
                                                                      </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="8">
               <!--                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                                                                           -->
                                                                           <p class="labl-blk">Remarks</p>
          <?php echo $value['veh_remarks']; ?>
                                                                      </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="2">
               <!--                                                            <input placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_delivery_date][]">
                                                                           -->
                                                                           <p class="labl-blk">First delivery date</p>
                                                                           <?php echo $value['veh_delivery_date']; ?>
                                                                      </td>
                                                                      <td colspan="2">
               <!--                                                            <input placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_first_reg][]">
                                                                           -->
                                                                           <p class="labl-blk">First reg date</p>
          <?php echo $value['veh_first_reg']; ?>
                                                                      </td>
                                                                      <td colspan="2">
               <!--                                                            <select data-placeholder="First manf year" name="vehicle[buy][veh_manf_year][]" style="width: 270px;" class="select2_group form-control cmbMultiSelectmm">
                                                                                <option value="">-Select First manf year-</option>
                                                                                                                                                        <option value="2021">2021</option>
                                                                                                                                                          <option value="2020">2020</option>
                                                                                                                                                          <option value="2019">2019</option>
                                                                                                                                            
                                                                                    
               
                                                                           </select>-->
                                                                           <p class="labl-blk">First manf year</p>  
          <?php echo $value['veh_manf_year']; ?>
                                                                      </td>
                                                                      <td colspan="1">
               <!--                                                            <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                                <option value="">Select A/C</option>
                                                                                <option value="1">W/o</option>
                                                                                <option value="2">Single</option>
                                                                                <option value="3">Dual</option>
                                                                                <option value="4">Multi</option>
                                                                           </select>-->
                                                                           <p class="labl-blk">A/C</p>
          <?php
          $AC = unserialize(AC);
          echo $AC[$value['veh_ac']];
          ?>
                                                                      </td>
                                                                      <td colspan="1">
               <!--                                                            <input placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_ac_zone][]">
                                                                           -->
                                                                           <p class="labl-blk">Ac zone</p>
                                                                           <?php echo $value['veh_ac_zone']; ?>
                                                                      </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="2">
               <!--                                                            <input placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_cc][]">-->
                                                                           <p class="labl-blk">Eng CC </p>
          <?php echo $value['veh_cc']; ?>
                                                                      </td>
                                                                      <td colspan="2">
               <!--                                                            <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                                                                                <option value="">-Vehicle type-</option>
                                                                                                                                                        <option value="1">SUV</option>
                                                                                                                                                          <option value="2">Sedan</option>
                                                                                                                                                          <option value="3">Convertible</option>
                                                                                                                                                          <option value="4">Coupe</option>
                                                                                                                                                          <option value="5">MUV-MPV</option>
                                                                                                                                                          <option value="6">Sports</option>
                                                                                                                                                          <option value="7">Hatchback</option>
                                                                                                                                                          <option value="8">Cruiser bike</option>
                                                                                                                                                          <option value="9">Sport bike</option>
                                                                                                                                                          <option value="10">Off road bike</option>
                                                                                                                                              </select>-->
                                                                           <p class="labl-blk">Vehicle Type</p>
          <?php
          $veh_type = unserialize(ENQ_VEHICLE_TYPES);
          echo $veh_type[$value['veh_vehicle_type']];
          ?>
                                                                      </td>
                                                                      <td colspan="2">
               <!--                                                            <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_engine_num][]">
                                                                           -->
                                                                           <p class="labl-blk">Engine number</p>
          <?php echo $value['veh_engine_num']; ?>
                                                                      </td>
                                                                      <td colspan="1">
               <!--                                                            <select required="" class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                                <option value="">Select Transmission</option>
                                                                                <option value="1">M/T</option>
                                                                                <option value="2">A/T</option>
                                                                                <option value="3">S/T</option>
                                                                           </select>-->
                                                                           <p class="labl-blk">Transmission</p>
                                                                           <?php
                                                                           $transmission = unserialize(transmission);
                                                                           echo $transmission[$value['veh_transmission']];
                                                                           ?>
                                                                      </td>
                                                                      <td colspan="1">
               <!--                                                            <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
                                                                           -->
                                                                           <p class="labl-blk">No of seat</p>
          <?php echo $value['veh_seat_no']; ?>
                                                                      </td>
                                                                 </tr>
                                                                 <!-- insu -->
                                                                 <tr>
                                                                      <td colspan="12"><h3><center>Insurance Details</center></h3></td>


                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="3" class="lbl-blk"><p class="labl-blk">Company name:</p><?php echo $value['val_insurance_company']; ?> </td>
                                                                      <td colspan="8"></td>


                                                                 </tr>
                                                                 <tr>

                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Comprehesive</p>    
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Valid Up to</p>
                                                                           <?php echo $value['val_insurance_comp_date']; ?>
                                                                      </td>
                                                                      <td colspan="2">

                                                                           <p class="labl-blk">IDV</p>
          <?php echo $value['val_insurance_comp_idv']; ?>
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">NCB%</p>
          <?php echo $value['val_insurance_ll_idv']; ?>
                                                                      </td>

                                                                 </tr>
                                                                 <tr>

                                                                      <td colspan="2" class="lbl-blk">
                                                                           <p class="labl-blk">Third party </p>   
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Valid Up to</p> 
          <?php echo $value['val_insurance_ll_date']; ?>
                                                                      </td>
                                                                      <td colspan="2">

          <!--                                                            <select required="" class="select2_group form-control" name="vehicle[buy][insurance_type][]">
                                                                           <option value="">Insurance Type</option>
                                                                                                                                                   <option value="1">RTI</option>
                                                                                                                                                     <option value="2">PLATINUM</option>
                                                                                                                                                     <option value="3">B2B</option>
                                                                                                                                                     <option value="4">First Class</option>
                                                                                                                                                     <option value="5">Second Class</option>
                                                                                                                                         </select>-->
                                                                           <p class="labl-blk">Insurance Type</p> 
          <?php
          $ins_type = unserialize(INSURANCE_TYPES);
          echo $ins_type[$value['val_insurance']];
          ?>

                                                                      </td>
                                                                      <td colspan="2">
               <!--                                                            <select required="" class="select2_group form-control" name="vehicle[buy][ncb_req][]">
                                                                                <option value="0">NCB Required </option>
                                                                                <option value="1">Yes</option>
                                                                                <option value="0">No</option>
                                                                           </select>-->
                                                                           <p class="labl-blk">NCB Required</p> 
          <?php echo $value['ncb_req'] ? 'YES' : 'NO'; ?>
                                                                      </td>

                                                                 </tr>
                                                                 <!-- @insu -->
                                                                 <!--- hypothi-->
                                                                 <tr>
                                                                      <td colspan="12"><h3><center>Hypothecation Details</center></h3></td>


                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="1"><p class="labl-blk">Finance Company </p>
                                                                           ---
                                                                      </td>
                                                                      <td colspan="3"><p class="labl">Bank</p><?php
                                                                           $banks = $this->evaluation->getAllBanks($value['bank']);
                                                                           echo $banks['bnk_name'];
                                                                           ?></td>
                                                                      <td colspan="2"><p class="labl-blk">Branch</p> <?php echo $value['bank_branch']; ?></td>
                                                                      <td colspan="2"> <p class="labl-blk">Hypothecation will close by </p>
                                                                           <?php echo $value['val_hypo_close_by_cust'] ? 'Customer' : 'RD'; ?>
                                                                      </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="2"> <p class="labl-blk">Loan Starting Date </p>
                                                                           <?php echo $value['loan_starting_date']; ?>
                                                                      </td>


                                                                      <td colspan="2"> <p class="labl-blk">Loan Ending Date </p>
                                                                           <?php echo $value['loan_ending_date']; ?>

                                                                      </td>

                                                                      <td colspan="1"> <p class="labl-blk">Loan amount </p>
                                                                           <?php echo $value['loan_amount']; ?>
                                                                      </td>
                                                                      <td colspan="1"> <p class="labl-blk">Forclousure value </p>
                                                                           <?php echo $value['forclousure_value']; ?> </td>
                                                                      <td colspan="2"> <p class="labl-blk">Forclousure date </p>
          <?php echo $value['forclousure_date']; ?>
                                                                      </td>

                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="2"> <p class="labl-blk">Daily Interest </p>
          <?php echo $value['daily_interest']; ?></td>
                                                                      <td colspan="2"> <p class="labl-blk">Any Top up Loan  </p>
          <?php echo $value['any_top_up_loan'] ? 'YES' : 'NO'; ?>
                                                                      </td>
                                                                 </tr>
                                                                 <!-- @hypothi --> 
                                                            </tbody>
                                                       </table>
                                                  </div>
                                                  <?php }
                                             } ?>
                                   </div>

                                   <!-- @col1 -->
                                   <div class="col-md-3">
                                             <?php
                                             if (isset($trackCard['vehicle_buy']) && !empty($trackCard['vehicle_buy'])) {
                                                  if (isset($trackCard['followup']) && !empty($trackCard['followup'])) {
                                                       ?>
                                                  <p class="labl-blk">Follow UP  Remrks  </p>
                                                  <ul class="list-unstyled timeline">
                                                                 <?php
                                                                 $totalVehicles = count($trackCard['vehicle_sall']) + count($trackCard['vehicle_buy']);
                                                                 $index = 0;
                                                                 foreach ((array) $trackCard['followup'] as $key => $value) {
                                                                      if (($value['foll_is_cmnt'] == 1) && ($value['foll_parent'] == 0)) {
                                                                           if ((check_permission('folup_trck_comment', 'viewgeneralcomment'))) {
                                                                                ?>
                                                                      <li>
                                                                           <div class="block">
                                                                                <!--                                                                   <div class="tags" style="width: 32%;">
                                                                                                                                                        <div class="profile_pic">
                         <?php
                         echo img(array('src' => './assets/uploads/avatar/' . $value['usr_avatar'], 'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                         ?>
                                                                                                                                                        </div>
                                                                                                                                                   </div>-->
                                                                                <div class="block_content">
                                                                                     <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                          <span><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d h:i:s', strtotime($value['foll_entry_date'])); ?></span>
                                                                                     </p>
                                                                                     <?php
                                                                                     echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';
                                                                                     ?>
                                                                                </div>
                                                                                <!-- Repeated contents -->
                                                                                <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;">
                                                                                     <p class="excerpt"><?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?></p>
                                                                                </div>
                                                                      <?php if ($value['folloup_added_by_id'] != $this->uid) { ?>
                                                                                     <p class="excerpt alignright">Added by : <?php
                                                                           echo isset($value['folloup_added_by']) ?
                                                                                   $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                           ?>
                                                                                     </p>
                                                                                <?php } else { ?>
                                                                                     <p class="excerpt alignright">Added by : Self</p>
                                                                                <?php } ?>
                                                                           </div>
                                                                      </li>
                                                                                <?php
                                                                           }
                                                                      } else {
                                                                           ?>
                                                                 <li>
                                                                      <div class="block">
                    <?php
                    if ($key % $totalVehicles == 0) {
                         if ($value['foll_status'] == 1) { // Hot
                              ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:red;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid red}</style> <?php
                         } else if ($value['foll_status'] == 2) { // Warm
                              ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:yellowgreen;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid yellowgreen}</style> <?php
                                                  } else if ($value['foll_status'] == 3) { // Cool
                                                       ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:green;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid green}</style> <?php }
                                                  ?>

                                                                                <div class="tags">
                                                                                     <a data-url="<?php echo site_url('followup/getSingleFollowup') . '/' . encryptor($trackCard['enq_id']) . '/' . date('Y-m-d', strtotime($value['foll_next_foll_date'])); ?>" 
                                                                                        href="javascript:;" class="tagcolor<?php echo $value['foll_id']; ?> tag"
                                                                                        min-date="<?php echo date('D M d Y', strtotime($value['foll_next_foll_date'])); ?>">
                                                                                          <span><?php echo date('j M Y', strtotime($value['foll_next_foll_date'])); ?></span>
                                                                                     </a>
                                                                                </div>
                                                                                     <?php } ?>
                                                                           <div class="block_content">
                                                                                <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                     <span><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'] ?></span>
                                                                                </p>
                    <?php echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : ''; ?>
                                                                           </div>
                                                                           <!-- Repeated contents -->
                                                                                <?php if ((($key + 1) % $totalVehicles) == 0) { ?>
                                                                                <div style="font-style: italic;background: #E7E7E7;padding: 10px;" class="wrd-wrp">
                                                                                     <p class="excerpt">Remarks : <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?></p>
                                                                                     <p class="excerpt">
                                                                                <?php
                                                                                $mod = unserialize(MODE_OF_CONTACT);
                                                                                echo isset($mod[$value['foll_contact']]) ? 'Mode of contact : ' . $mod[$value['foll_contact']] : ''
                                                                                ?>
                                                                                     </p>
                                                                                     <p class="excerpt">Next action plan : <?php echo isset($value['foll_action_plan']) ? $value['foll_action_plan'] : ''; ?></p>
                                                                                </div>
                                                                           <?php } if ($value['folloup_added_by_id'] != $this->uid) { ?>
                                                                                <p class="excerpt alignright">Added by : <?php
                                                                                echo isset($value['folloup_added_by']) ?
                                                                                        $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                                ?>
                                                                                </p>
                    <?php } else { ?>
                                                                                <p class="excerpt alignright">Added by : Self</p>
                                                                                          <?php } ?>
                                                                           <!-- Load comments -->
                                                                                               <?php
                                                                                               if (check_permission('folup_trck_comment', 'viewindividualcomment')) {
                                                                                                    $comments = $this->followup->getComments($value['foll_id']);
                                                                                                    if (!empty($comments)) {
                                                                                                         foreach ($comments as $k => $cmd) {
                                                                                                              ?>
                                                                                          <div style="width: 100%;float: left;">
                                                                                               <div class="block_content">
                                                                                                    <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                                    <div><i class="fa fa-clock-o"></i> 
                                   <?php if ($cmd['folloup_added_by_id'] != $this->uid) { ?>
                                                                                                              <p class="excerpt alignright">Added by : <?php
                                                                                                              echo isset($cmd['folloup_added_by']) ?
                                                                                                                      $cmd['folloup_added_by'] . ' (' . $cmd['shr_location'] . ')' : '';
                                                                                                              ?>
                                                                                                              </p>
                                   <?php } else { ?>
                                                                                                              <p class="excerpt alignright">Added by : Self</p>
                                   <?php } ?>
                                   <?php echo date('Y-m-d h:i:s', strtotime($cmd['foll_entry_date'])); ?></div>
                                                                                                    </p>
                                                                                               </div>
                                                                                               <div class="tags" style="width: 25%;position: inherit;">
                                                                                                    <div class="profile_pic">
                                                                                          <?php
                                                                                          echo img(array('src' => './assets/uploads/avatar/' . $cmd['usr_avatar'],
                                                                                              'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                                          ?>
                                                                                                    </div>
                                                                                               </div>
                                                                                               <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;width: 90%;float: right;">
                                                                                                    <p class="excerpt"><?php echo isset($cmd['foll_remarks']) ? $cmd['foll_remarks'] : ''; ?></p>
                                                                                               </div>
                                                                                          </div>
                                                                           <?php
                                                                      }
                                                                 }
                                                            }
                                                            ?>
                                                                      </div>
                                                                 </li>
                                                  <?php
                                                  $index++;
                                             }
                                        }
                                        ?>
                                                  </ul>
     <?php }
} ?>
                                   </div><!-- @col2 -->
                              </div>
                              <!-- @vehicle detials -->

                              <!--existing vehicle -->
<?php
if (isset($trackCard['vehicle_existing']) && !empty($trackCard['vehicle_existing'])) {
     foreach ($trackCard['vehicle_existing'] as $key => $value) {
          ?>
                                        <div class="table-responsive">
                                             <table id="datatable-responsive" class="existing_add_new vehDetailsBuy table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                  <thead>
                                                       <tr class="bg-veh">

                                                            <td colspan="12">                                            
                                                  <center>EXISTING VEHICLE</center>
                                                  <td>

                                                       </tr>
                                                  <tr>
                                                       <th>Make</th>
                                                       <th>Model</th>
                                                       <th>Variant</th>
                                                       <th>Fuel</th>
                                                       <th>Manf Year</th>
                                                       <th>Color</th>
                                                       <th>KM</th>
                                                       <th>Exchange intrested</th>

                                                  </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>
                                                                 <?php echo $value['brd_title']; ?>

                                                            </td>
                                                            <td>   <?php echo $value['mod_title']; ?></td>
                                                            <td> <?php echo $value['var_variant_name']; ?></td>
                                                            <td>
          <?php
          $fuel = unserialize(FUAL);
          echo $fuel[$value['veh_fuel']];
          ?>
                                                            </td>
                                                            <td>
          <?php echo $value['veh_year']; ?>
                                                            </td>
                                                            <td>
                                                                 <?php
                                                                 $vehicleColor = getVehicleColors($value['veh_color']);
                                                                 print_r($vehicleColor['vc_color']);
                                                                 ?> 
                                                            </td>
                                                            <td>
                                                                 <?php echo $value['veh_km_from']; ?> 

                                                            </td>
                                                            <td>
                                                                 <?php echo $value['veh_exchange_intrested'] ? 'YES' : 'NO'; ?> 
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="4">

                                                                 <p class="labl-blk">Market value</p>         
                                                                 <?php echo $value['veh_exch_dealer_value']; ?> 
                                                            </td>
                                                            <td colspan="2">

                                                                 <p class="labl-blk">Our Offer</p>
          <?php echo $value['veh_exch_estimate']; ?> 
                                                            </td>
                                                            <td colspan="2">

                                                                 <p class="labl-blk">Customer expectation</p>  
                                                                 <?php echo $value['veh_exch_cus_expect']; ?> 
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="4">
                                                                 <?php
                                                                 $regNo = explode("-", $value['veh_reg']);
                                                                 ?>
                                                                 <p class="labl-blk">Registration: NO</p>
                                                                 <input disabled=""  style="width: 60px;text-transform:uppercase;" class="reg-no form-control col-md-3 col-xs-3" type="text" value="<?php echo $regNo[0]; ?>">
                                                                 <input disabled=""  style="width: 40px;" class="reg-no form-control col-md-3 col-xs-3 numOnly" type="text" value="<?php echo $regNo[1]; ?>">
                                                                 <input disabled=""  style="width: 40px;text-transform:uppercase;" class="reg-no form-control col-md-3 col-xs-3" type="text" value="<?php echo $regNo[2]; ?>">
                                                                 <input disabled="" style="width: 60px;" class="reg-no form-control col-md-3 col-xs-3 numOnly" type="text" value="<?php echo $regNo[3]; ?>">
                                                            </td>
                                                            <td colspan="2">
                                                                 <p class="labl-blk">Ownership</p> 
                                                                 <?php echo $value['veh_owner']; ?> 
                                                            </td>
                                                            <td colspan="2">

                                                                 <p class="labl-blk">Insurance Validity</p> 
          <?php echo $value['veh_insurance_validity']; ?> 
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="2">

                                                                 <p class="labl-blk">Tyre condition</p> 
          <?php echo $value['veh_tyre_condition']; ?> 
                                                            </td>
                                                            <td colspan="6">
                                                                 <p class="labl-blk">Remarks</p> 
          <?php echo $value['veh_remarks']; ?> 
                                                            </td>
                                                       </tr>


                                                  </tbody>
                                             </table>
                                        </div>
     <?php }
} ?>
                              <!-- @existing vehicle -->
                              <!-- Lost case -->
                              <!--                                <div class="table-responsive">
                                                                      <table id="datatable-responsive" class="existing_add_new vehDetailsBuy table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                                           <thead>
                                                                               <tr class="bg-veh">
                                                                                                   <td colspan="12">                                            
                              <center>Lost case ,Details </center>
                                                                                     <td>
                               </tr>
                                                                                <tr>
                                                                                     <th>Sold through </th>
                                                                                     <th>Organisation </th>
                                                                                     <th>Concern Person</th>
                                                                                     <th>Lost date </th>
                                                                                     <th>First date of Contact </th>
                                                                                     <th>Last Date of Contact </th>
                                                                                        <th>Our Offer </th>
                                                                                     <th>Sold Rate</th>
                                                                                  
                                                                                </tr>
                                                                           </thead>
                                                                           <tbody>
                                                                                <tr>
                                                                                     <td>
                                                                                        Exchange with NVS
                                                                                          
                                                                                     </td>
                                                                                     <td>Org  bdhcbdjchb</td>
                                                                                     <td>Ratheesh</td>
                                                                                     <td>
                                                                                         06-07-2021
                                                                                     </td>
                                                                                     <td>
                                                                                         01-05-2021
                                                                                     </td>
                                                                                     <td>
                                                                                         05-05-2021
                                                                                     </td>
                                                                                     <td>
                                                                                           215565
                                                                                        
                                                                                     </td>
                                                                                     <td>
                                                                                          231545
                                                                                     </td>
                                                                                </tr>
                                                                                <tr>
                                                                                     <td colspan="4">
                                                                                      
                                                                                            <p class="labl-blk">Executive Remak</p>         
                                                                                     XVFDFGFHFH
                                                                                     </td>
                                                                                     <td colspan="2">
                                                                                        
                                                                                             <p class="labl-blk">TL Remark </p>
                                                                                     FGFGDFGDDD
                                                                                     </td>
                                                                                     <td colspan="2">
                                                                                   
                               <p class="labl-blk">PM Remark </p>  
                              SSHDFISDHFIUSDHVIH
                                                                                     </td>
                                                                                </tr>
                                                              </tbody>
                                                                      </table>
                                                                 </div>-->
                              <!-- @Lost case -->
                              <!--Req vehicle -->
                              <div class="row">
                                   <div class="col-md-9"> 
<?php
if (isset($trackCard['vehicle_sall']) && !empty($trackCard['vehicle_sall'])) {
     foreach ($trackCard['vehicle_sall'] as $key => $value) {
          ?>

                                                  <div class="table-responsive divVehDetailsBuy" style="">
                                                       <table id="datatable-responsive" class="vehDetailsBuy table table-stripedj table-bordered jdt-responsive nowrapk" cellspacing="0"style="width:97%">
                                                            <thead>
                                                                 <tr class="bg-veh pding">
                                                                      <td colspan="12">                                            
                                                            <center>Required Vehicle</center>
                                                                           <?php //print_r($trackCard['vehicle_sall']);  ?>
                                                            <td>

                                                                 </tr>

                                                            <tr>
                                                                 <th class="lbl-blk">Brand</th>
                                                                 <th class="lbl-blk">Model</th>
                                                                 <th class="lbl-blk">Variant</th>
                                                                 <th class="lbl-blk">Fuel</th>
                                                                 <th class="lbl-blk" colspan="2">Manufacturing Year </th>
                                                                 <th class="lbl-blk">Prefer Colour</th>
                                                                 <th class="lbl-blk">Km Range</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody class="tbd">
                                                                 <tr>
                                                                      <td>
                                                                           <?php echo $value['brd_title']; ?>
                                                                      </td>
                                                                      <td><?php echo $value['mod_title']; ?></td>
                                                                      <td><?php echo $value['var_variant_name']; ?></td>
                                                                      <td>
                                                                           <?php
                                                                           $fuel = unserialize(FUAL);
                                                                           echo $fuel[$value['veh_fuel']];
                                                                           ?>
                                                                      </td>
                                                                      <td>
                                                                           <p class="labl-blk">From</p>
          <?php echo $value['veh_manf_year_from']; ?>
                                                                      </td>
                                                                      <td>
                                                                           <p class="labl-blk">To</p>
                                                                           <?php echo $value['veh_manf_year_to']; ?>
                                                                      </td>
                                                                      <td>
          <?php
          $vehicleColor = getVehicleColors($value['veh_color']);
          print_r($vehicleColor['vc_color']);
          ?> 
                                                                      </td>

                                                                      <td>
          <?php
          $kms = get_km_ranges($value['veh_km_id']);
          echo $kms->kmr_range_from . '-' . $kms->kmr_range_to;
          ?> 
                                                                      </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Budget range
                                                                           </p>  <?php
                                                  $price_ranges = get_price_ranges($value['veh_price_id']);
                                                  echo $price_ranges['pr_range'];
                                                  ?> 
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Prefer Number

                                                                           </p>  <?php echo $value['veh_prefer_no']; ?> 
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Expected Date of Purchase </p><?php echo $value['veh_exptd_date_purchase']; ?>
                                                                      </td>
                                                                      <td colspan="2">
                                                                           <p class="labl-blk">Remarks </p><?php echo $value['veh_remarks']; ?>
                                                                      </td>
                                                                 </tr>

                                                            </tbody>
                                                       </table>
                                                  </div>
     <?php }
} ?>
                                   </div>

                                   <!-- @col1 -->
                                   <!-- col2 -->
                                   <div class="col-md-3">
<?php
if (isset($trackCard['vehicle_sall']) && !empty($trackCard['vehicle_sall'])) {
     if (isset($trackCard['followup']) && !empty($trackCard['followup'])) {
          ?>
                                                  <p class="labl-blk">Follow UP  Remrks  </p>
                                                  <ul class="list-unstyled timeline">
                                                                      <?php
                                                                      $totalVehicles = count($trackCard['vehicle_sall']) + count($trackCard['vehicle_buy']);
                                                                      $index = 0;
                                                                      foreach ((array) $trackCard['followup'] as $key => $value) {
                                                                           if (($value['foll_is_cmnt'] == 1) && ($value['foll_parent'] == 0)) {
                                                                                if ((check_permission('folup_trck_comment', 'viewgeneralcomment'))) {
                                                                                     ?>
                                                                      <li>
                                                                           <div class="block">
                                                                                <div class="tags" style="width: 32%;">
                                                                                     <div class="profile_pic">
                                                                                <?php
                                                                                echo img(array('src' => './assets/uploads/avatar/' . $value['usr_avatar'], 'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                                ?>
                                                                                     </div>
                                                                                </div>
                                                                                <div class="block_content">
                                                                                     <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                          <span><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d h:i:s', strtotime($value['foll_entry_date'])); ?></span>
                                                                                     </p>
                                                                      <?php
                                                                      echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';
                                                                      ?>
                                                                                </div>
                                                                                <!-- Repeated contents -->
                                                                                <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;">
                                                                                     <p class="excerpt"><?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?></p>
                                                                                </div>
                                                                                <?php if ($value['folloup_added_by_id'] != $this->uid) { ?>
                                                                                     <p class="excerpt alignright">Added by : <?php
                                                                                     echo isset($value['folloup_added_by']) ?
                                                                                             $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                                     ?>
                                                                                     </p>
                         <?php } else { ?>
                                                                                     <p class="excerpt alignright">Added by : Self</p>
                         <?php } ?>
                                                                           </div>
                                                                      </li>
                         <?php
                    }
               } else {
                    ?>
                                                                 <li>
                                                                      <div class="block">
                                                                           <?php
                                                                           if ($key % $totalVehicles == 0) {
                                                                                if ($value['foll_status'] == 1) { // Hot
                                                                                     ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:red;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid red}</style> <?php
                                                                                } else if ($value['foll_status'] == 2) { // Warm
                                                                                     ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:yellowgreen;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid yellowgreen}</style> <?php
                                                                                } else if ($value['foll_status'] == 3) { // Cool
                                                                                     ?><style>.tagcolor<?php echo $value['foll_id']; ?> {background:green;} .tagcolor<?php echo $value['foll_id']; ?>::after{border-left:11px solid green}</style> <?php }
                                                                                ?>

                                                                                <!--                                                                   <div class="tags">
                                                                                                                                                        <a data-url="<?php echo site_url('followup/getSingleFollowup') . '/' . encryptor($trackCard['enq_id']) . '/' . date('Y-m-d', strtotime($value['foll_next_foll_date'])); ?>" 
                                                                                                                                                           href="javascript:;" class="tagcolor<?php echo $value['foll_id']; ?> tag"
                                                                                                                                                           min-date="<?php echo date('D M d Y', strtotime($value['foll_next_foll_date'])); ?>">
                                                                                                                                                             <span><?php echo date('j M Y', strtotime($value['foll_next_foll_date'])); ?></span>
                                                                                                                                                        </a>
                                                                                                                                                   </div>-->
                                                                                <span><?php echo date('j M Y', strtotime($value['foll_next_foll_date'])); ?></span>
                                                                                <?php } ?>
                                                                           <!--                                                              <div class="block_content">
                                                                                                                                              <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                                                                                   <span><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'] ?></span>
                                                                                                                                              </p>
                                                                           <?php echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : ''; ?>
                                                                                                                                         </div>-->
                                                                           <!-- Repeated contents -->
                                                                           <?php if ((($key + 1) % $totalVehicles) == 0) { ?>
                                                                                <div style="font-style: italic;background: #E7E7E7;padding: 10px;" class="wrd-wrp">
                                                                                     <p class="excerpt">Remarks : <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?></p>
                                                                                     <p class="excerpt">
                                                                                <?php
                                                                                $mod = unserialize(MODE_OF_CONTACT);
                                                                                echo isset($mod[$value['foll_contact']]) ? 'Mode of contact : ' . $mod[$value['foll_contact']] : ''
                                                                                ?>
                                                                                     </p>
                                                                                     <p class="excerpt">Next action plan : <?php echo isset($value['foll_action_plan']) ? $value['foll_action_plan'] : ''; ?></p>
                                                                                </div>
                                                                                               <?php } if ($value['folloup_added_by_id'] != $this->uid) { ?>
                                                                                <p class="excerpt alignright">Added by : <?php
                                                                                                    echo isset($value['folloup_added_by']) ?
                                                                                                            $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                                                    ?>
                                                                                </p>
                                                                                          <?php } else { ?>
                                                                                <p class="excerpt alignright">Added by : Self</p>
                    <?php } ?>
                                                                           <!-- Load comments -->
                    <?php
                    if (check_permission('folup_trck_comment', 'viewindividualcomment')) {
                         $comments = $this->followup->getComments($value['foll_id']);
                         if (!empty($comments)) {
                              foreach ($comments as $k => $cmd) {
                                   ?>
                                                                                          <div style="width: 100%;float: left;">
                                                                                               <div class="block_content">
                                                                                                    <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                                    <div><i class="fa fa-clock-o"></i> 
                                   <?php if ($cmd['folloup_added_by_id'] != $this->uid) { ?>
                                                                                                              <p class="excerpt alignright">Added by : <?php
                                                                                               echo isset($cmd['folloup_added_by']) ?
                                                                                                       $cmd['folloup_added_by'] . ' (' . $cmd['shr_location'] . ')' : '';
                                                                                               ?>
                                                                                                              </p>
                                                                                          <?php } else { ?>
                                                                                                              <p class="excerpt alignright">Added by : Self</p>
                                                                                <?php } ?>
                                                                                <?php echo date('Y-m-d h:i:s', strtotime($cmd['foll_entry_date'])); ?></div>
                                                                                                    </p>
                                                                                               </div>
                                                                                               <!--                                                                                  <div class="tags" style="width: 25%;position: inherit;">
                                                                                                                                                                                      <div class="profile_pic">
                                                                           <?php
                                                                           echo img(array('src' => './assets/uploads/avatar/' . $cmd['usr_avatar'],
                                                                               'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                           ?>
                                                                                                                                                                                      </div>
                                                                                                                                                                                 </div>-->
                                                                                               <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;width: 90%;float: right;">
                                                                                                    <p class="excerpt"><?php echo isset($cmd['foll_remarks']) ? $cmd['foll_remarks'] : ''; ?></p>
                                                                                               </div>
                                                                                          </div>
                                                                           <?php
                                                                      }
                                                                 }
                                                            }
                                                            ?>
                                                                      </div>
                                                                 </li>
                    <?php
                    $index++;
               }
          }
          ?>
                                                  </ul>
     <?php }
} ?> 
                                   </div>
                                   <!-- @col2 -->
                              </div>

                              <!--@Req vehicle -->

                              <!--Pitched vehicle -->
                              <div class="row">
                                   <div class="col-md-9"> 
<?php
if (isset($trackCard['vehicle_pitched']) && !empty($trackCard['vehicle_pitched'])) {
     foreach ($trackCard['vehicle_pitched'] as $key => $value) {
          ?>

                                                  <div class="table-responsive divVehDetailsBuy" style="">
                                                       <table id="datatable-responsive" class="vehDetailsBuy table table-stripedj table-bordered jdt-responsive nowrapk" cellspacing="0"style="width:97%">
                                                            <thead>
                                                                 <tr class="bg-veh pding">
                                                                      <td colspan="12">                                            
                                                            <center>Pitched Vehicle</center>
          <?php // print_r($trackCard['vehicle_pitched']);  ?>
                                                            <td>

                                                                 </tr>

                                                            <tr>
                                                                 <th class="lbl-blk" >Reg No </th>
                                                                 <th class="lbl-blk">Brand</th>
                                                                 <th class="lbl-blk">Model</th>
                                                                 <th class="lbl-blk">Variant</th>
                                                                 <th class="lbl-blk">Fuel</th>
                                                                 <th class="lbl-blk">Manufacturing Year </th>
                                                                 <th class="lbl-blk">Our Price</th>


                                                            </tr>
                                                            </thead>
                                                            <tbody class="tbd">
                                                                 <tr>
                                                                      <td>
          <?php echo $value['val_veh_no']; ?>
                                                                      </td>
                                                                      <td>
          <?php echo $value['brd_title']; ?>
                                                                      </td>
                                                                      <td><?php echo $value['mod_title']; ?></td>
                                                                      <td><?php echo $value['var_variant_name']; ?></td>
                                                                      <td>
                                                                           <?php
                                                                           $fuel = unserialize(FUAL);
                                                                           echo $fuel[$value['val_fuel']];
                                                                           ?>
                                                                      </td>

                                                                      <td>

          <?php echo $value['val_model_year']; ?>
                                                                      </td>
                                                                      <td>
          <?php echo $value['val_price_market_est']; ?>
                                                                      </td>


                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="1">
                                                                           <p class="labl-blk">Customer Offer 

                                                                           </p>  <?php echo $value['veh_exch_cus_expect']; ?> 
                                                                      </td>
                                                                      <td colspan="4">
                                                                           <p class="labl-blk">Executive Remarks </p>
          <?php echo $value['veh_remarks']; ?>
                                                                      </td>
                                                                      <td colspan="4">
                                                                           <p class="labl-blk">TL remarks  </p><?php echo $value['veh_tl_remarks']; ?>
                                                                      </td>

                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="4">
                                                                           <p class="labl-blk">SM Remarks
                                                                           </p>  <?php echo $value['veh_sm_remarks']; ?>
                                                                      </td>
                                                                      <td colspan="4">
                                                                           <p class="labl-blk">Gm Remamrk
                                                                           </p>  <?php echo $value['veh_gm_remarks']; ?>
                                                                      </td>
                                                                 </tr>

                                                            </tbody>
                                                       </table>
                                                  </div>
     <?php }
} ?>
                                   </div>

                                   <!-- @col1 -->
                                   <!-- col2 -->

                                   <!-- @col2 -->
                              </div>
                              <!--@Pitched vehicle -->

                              <!-- Home visit -->
<?php
if (isset($trackCard['home_visits']) && !empty($trackCard['home_visits'])) {
     foreach ($trackCard['home_visits'] as $key => $value) {
          ?>
                                        <div class="table-responsive">
                                             <table id="datatable-responsive" class="existing_add_new vehDetailsBuy table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                  <thead>
                                                       <tr class="bg-veh">

                                                            <td colspan="12">                                            
                                                  <center>Home Visit Details </center>
                                                  <td>
                                                       </tr>
                                                  <tr>
                                                       <th>Date </th>
                                                       <th>Place </th>
                                                       <th>Travel With </th>
                                                       <th>Vehicle </th>
                                                       <th>Out km  </th>
                                                       <th>In Km  </th>
                                                       <th>In Date  </th>
                                                       <th>Approved</th>

                                                  </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>
          <?php echo $value['hmv_date'] ?>

                                                            </td>
                                                            <td><?php echo $value['hmv_date'] ?></td>
                                                            <td><?php echo $value['hmv_place'] ?></td>
                                                            <td>
          <?php echo $value['brd_title'] . '|' . $value['mod_title'] . '|' . $value['var_variant_name'] ?>
                                                            </td>
                                                            <td>
                                                                 24550
                                                            </td>
                                                            <td>
                                                                 26551
                                                            </td>
                                                            <td>
                                                                 06-07-2021

                                                            </td>
                                                            <td>
                                                                 Approved
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="1">

                                                                 <p class="labl-blk">Discussion Time </p>         
                                                                 2 hr
                                                            </td>
                                                            <td colspan="1">

                                                                 <p class="labl-blk">Met the Customer with Family  </p>
                                                                 Yes
                                                            </td>
                                                            <td>
                                                                 <p class="labl-blk">Executive Remak</p>  
                                                                 njjkkjkh jjhjjkhk
                                                            </td>
                                                            <td colspan="3">

                                                                 <p class="labl-blk">TL Remark </p>  
                                                                 gfhgfhhhj vdfgdfgdfg
                                                            </td>
                                                            <td colspan="3">

                                                                 <p class="labl-blk">SM Remark </p>  
                                                                 gfhgfhhhj vdfgdfgdfg
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>
     <?php }
} ?>
                              <!-- @Home visit -->

<?php if (isset($trackCard['questions']) && !empty($trackCard['questions'])) { ?>
                                   <table class="tblSale table table-stripedj table-bordered" style="width: 100%;">
                                        <tbody>
                                             <tr class="tr-bg">
                                                  <th colspan="8" style="text-align:center;">Inquiry questions</th>
                                             </tr>
     <?php
     foreach ($trackCard['questions'] as $key => $value) {
          ?>
                                                  <tr class="tr-bg">
                                                       <td><?php echo strip_tags($value['qus_question']); ?></td>
                                                       <td><?php echo $value['enqq_answer']; ?></td>
                                                  </tr>
     <?php } ?>
                                        </tbody>
                                   </table>
<?php } ?>


                              <p style="text-align: center;"><strong>&nbsp;</strong></p>
                              <p style="text-align: center;"><strong>Executive signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SM/TL Signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MD Signature :</strong></p>
                              <p style="text-align: center;"><strong>Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:</strong></p>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>

<style>
     .tblPrintHeader {display: none;}
     @media print {
          .nav_menu {display: none;}
          .x_title {display: none;}
          .x_panel {padding: 0px;border: none;}
          .tblSale {margin-top: 100px;}
          footer {display: none;}
          .tblPrintHeader {display: table;}
     }
</style>
