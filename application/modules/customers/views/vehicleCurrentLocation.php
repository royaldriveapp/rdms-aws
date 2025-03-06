<div class="right_col" role="main">
     <div class="">
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">

                              <?php
                                $brand = isset($evaliationDetails['brd_title']) ? $evaliationDetails['brd_title'] : '';
                                $model = isset($evaliationDetails['mod_title']) ? $evaliationDetails['mod_title'] : '';
                                $varnt = isset($evaliationDetails['var_variant_name']) ? $evaliationDetails['var_variant_name'] : '';
                              ?>

                              <h2>Vehicle tracking log of <?php echo $brand . ', ' . $model . ', ' . $varnt;?></h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <ul class="list-unstyled timeline">
                                   <li>
                                        <div class="block" style="margin-left: 180px;">
                                             <div class="tags" style="width: 150px;">
                                                  <a href="" class="tag">
                                                       <span><?php echo strtoupper($evaliationDetails['val_veh_no']);?></span>
                                                  </a>
                                             </div>
                                             <div class="block_content">
                                                  <h2 class="title">
                                                       <a>
                                                            <i>Location</i> : <?php
                                                              echo $evaliationDetails['shr_address'];
                                                            ?>
                                                       </a>
                                                  </h2>
                                                  <div class="excerpt">
                                                       <div><i>KM</i> : <?php echo $evaliationDetails['val_km'];?></div>
                                                       <div><i>Vehicle Evaluated By </i> : <?php echo $evaliationDetails['usr_first_name'];?></div>
                                                       <div><i>Evaluated On</i> : <?php echo $evaliationDetails['val_added_date'];?></div>
                                                  </div>
                                             </div>
                                        </div>
                                   </li>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>