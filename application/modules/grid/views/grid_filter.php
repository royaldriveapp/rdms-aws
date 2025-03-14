<style>
     .lbl {
          color: black !Important;
     }

     .modal-dialog {
          width: 1111px !important;
          margin: 30px auto !important;
     }

     .bg-gray {
          background-color: #cacaca !important;
     }

     .brd-radi {
          border-radius: 0px !important;
          border-top-left-radius: 0px !important;
          border-top-right-radius: 0px !important;
          border-bottom-right-radius: 35px !important;
          border-bottom-left-radius: 35px !important;
     }

     .h-brd-radi {
          border-radius: 0px !important;
          border-top-left-radius: 35px !important;
          border-top-right-radius: 35px !important;
          border-bottom-right-radius: 0px !important;
          border-bottom-left-radius: 0px !important;

     }

     .modal-content {
          border: 7px solid rgba(0, 0, 0, .2) !important;
          border-radius: 42px !important;
     }


     table td {
          width: 100px;
          white-space: nowrap;
          text-align: center;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Grid</h2>
                         <div class="clearfix"></div>
                        
                    
                         <div style="overflow-x:auto;">
                         <form action="" method="get">
                              <table>
                                   <tr>
                                        <td style="margin: 10px;">
                                        <?php //print($brands); ?>
                                             <select required="true" style="float: left;width: auto;" class="select2_group form-control bindToDropdown" 
                                                  data-url="<?php echo site_url('grid/bindModel');?>" 
                                                  name="brand" id="brand" data-bind="cmbEvModel" data-dflt-select="Select Brand" >
                                                  <option value="">Select Brand</option>
                                                  <?php foreach ($brands as $key => $value) {?>
                                                       <option <?php echo $_GET['brand'] == $value['brd_id'] ? 'selected="selected"' : '';?> 
                                                            value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                       <?php }?>
                                             </select>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <?php //if (isset($model) && !empty($model)) {?>
                                                  <select required="true" style="float: left;width: auto;" class="select2_group form-control cmbEvModel bindToDropdown" 
                                                            data-url="<?php echo site_url('grid/bindVarient');?>" 
                                                            name="model" id="val_model"   data-bind="cmbEvVariant" data-dflt-select="Select Model" >
                                                       <option value="">Select Model</option>
                                                       <?php foreach ($models as $key => $value) {?>
                                                            <option <?php echo $_GET['model'] == $value['gmod_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['gmod_id']?>"><?php echo $value['gmod_title']?></option>
                                                            <?php }?>
                                                  </select>
                                             <?php //}?>
                                        </td>
                                        <td style="padding-left: 10px;">
                                       
                                             <?php 
                                              //print_r($variants);
                                             // if (isset($variant) && !empty($variant)) {?>
                                                  <select required="true" style="float: left;width: auto;" class="select2_group form-control cmbEvVariant bindToDropdown" 
                                                  name="variant" id="val_variant" data-dflt-select="Select Vriant" >
                                                       <option value="">Select Variant--</option>
                                                       <?php foreach ($variants as $key => $value) {?>
                                                            <option <?php echo $_GET['variant'] == $value['gvar_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['gvar_id']?>"><?php echo $value['gvar_variant']?></option>
                                                            <?php }?>
                                                  </select>
                                             <?php //}?>
                                        </td>
                                        <td>
                                        <select required="true" style="float: left;width: auto;" class="select2_group form-control" 
                                                  name="year" id="year">
                                                  <option value="">Year</option>
                                                               <?php
                                                     $firstYear = (int)date('Y')-11;
                                                   
                                                    $lastYear =   $firstYear+11;
                                                       for($i=$firstYear;$i<=$lastYear;$i++)
                                                       {?>
                                                       <option <?php echo $_GET['year'] == $i ? 'selected="selected"' : '';?> value="<?php echo $i ?>"><?php echo $i;?></option>
                                                   
                                                      <?php }
                                                       ?>
                                                               
                                                               
                                                       </select>
                                                               </td>

                                                               <td>
                                                               <select required="true" style="float: left;width: auto;" class="select2_group form-control" 
                                                  name="km" id="km">
                                                  <option value="">KM</option>
                                                               <option <?php echo $_GET['km'] == 25000 ? 'selected="selected"' : '';?> value="25000">25000</option>
                                                               <option <?php echo $_GET['km'] == 50000 ? 'selected="selected"' : '';?> value="50000">50000</option>
                                                               <option <?php echo $_GET['km'] == 75000 ? 'selected="selected"' : '';?> value="75000">75000</option>
                                                            </select>
                                                               </td>
                                                               <td>
                                                               <select required="true" style="float: left;width: auto;" class="select2_group form-control" 
                                                  name="owner" id="owner">
                                                  <option value="">Owner</option>
                                                               <option <?php echo $_GET['owner'] == 1 ? 'selected="selected"' : '';?> value="1">1</option>
                                                               <option <?php echo $_GET['owner'] == 2 ? 'selected="selected"' : '';?> value="2">2</option>
                                                               <option <?php echo $_GET['owner'] == 3 ? 'selected="selected"' : '';?> value="3">3</option>
                                                               <option <?php echo $_GET['owner'] == 4 ? 'selected="selected"' : '';?> value="4">4</option>
                                                               <option <?php echo $_GET['owner'] == 5 ? 'selected="selected"' : '';?> value="5">5</option>
                                                            </select>
                                                               </td>
                                
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                                 
                              </table>
                         </form>
                    </div>
                    

                    </div>
                    <div class="x_content">
                         <div style="overflow-x:auto;">
                              <table id="datatable" class="table table-striped table-bordered cw-table-list">
                                   <thead>
                                        <tr>
                                             <th>ID</th>
                                             <th>Make</th>

                                             <th>Model</th>
                                             <th>Variant</th>
                                             <th>Year</th>
                                             <th>Owner</th>
                                             <th>%</th>


                                             <?php
                                             $firstYear = (int)date('Y') - 10;//old 9

                                             $lastYear =   $firstYear + 10;
                                             for ($i = $firstYear; $i <= $lastYear; $i++) { ?>
                                                  <th>25000</th>
                                                  <th>50000</th>
                                                  <th>75000</th>

                                             <?php }
                                             ?>





                                        </tr>

                                   </thead>
                                   <?php if($_GET){?>
                                   <tbody>




                                        <tr>

                                             <td class=""></td>
                                             <td class=""></td>
                                             <td class=""></td>
                                             <td class=""></td>
                                             <td class=""></td>
                                             <td class=""></td>
                                             <td class=""></td>

                                             <?php

                                             for ($i = $firstYear; $i <= $lastYear; $i++) { ?>
                                                  <td class="td_bg" data-td="td1-" data-clicks="1" colspan="3" style="background-color: white;">
                                                       <?php echo $i ?>
                                                  </td>

                                             <?php }
                                             ?>



                                        </tr>



                                        <?php
                                       //print_r(@$_GET);
                                        // $gData = $this->grid->getDataNew(1);
                                        $gData = $this->grid->getVehDataNew(@$_GET);
                                       // print_r($gData);
                                        if (!empty($gData)) {
                                             foreach ($gData as $key => $value) {
                                                  $firstOwner = $value['grdtl_owner'] == 1 ? $value['grdm_id'] : 0;
                                        ?>
                                                  <tr>

                                                       <td data-clicks="1" class="tr_bg "><?php echo $value['grdm_id']; ?></td>
                                                       <td class="td_bg "><?php echo $value['brd_title']; ?></td>
                                                       <td class="td_bg "><?php echo $value['gmod_title']; ?></td>
                                                       <td class="td_bg "><?php echo $value['var_variant_name']; ?></td>
                                                       <td class="td_bg "><?php //echo $firstOwner?$value['grdm_year_range']:''; 
                                                       echo $value['grdm_year_range'];
                                                                           ?></td>

                                                       <td class="td_bg "><?php

                                                                           echo $value['grdtl_owner'];
                                                                         

                                                                           ?></td>
                                                       <td class="td_bg "><?php echo $value['grdtl_depreciation']; ?></td>
                                                       <!--                                                    <td class=""><?php //echo $value['desig_title']; 
                                                                                                                             ?></td>-->

                                                       <?php
                                                       //   foreach ($months as $month_id => $month) {
                                                       for ($i = $firstYear; $i <= $lastYear; $i++) {

                                                       ?>
                                                            <td class="td2" <?php echo ($i==$_GET['year'] && $_GET['km']==25000)?'style="background-color: #E4EA0C;"':'' ?> >
                                                                 <?php

                                                                 if($_GET['km']==25000 && $_GET['year']==$i){
                                                           $details1 = $this->grid->getDetailsNew($value['grdm_id'],100, $i, 25000);
                                                                 if($firstOwner){
                                                                      echo $details1['grdtl_price'];
                                                                    // echo $value['grdtl_price'].'jj';
                                                           
                                                                   }else{
                                                            
                                                             //echo $value['grdtl_depreciation'].'jjj';
                                                                echo ($value['grdtl_depreciation']/100)*$details1['grdtl_price'];
                                                                // echo $value['grdtl_price'];
                                                                   }
                                                                 }
                                                             
                                                                 ?> </td>
                                                            <td class="td2" <?php echo ($i==$_GET['year'] && $_GET['km']==50000)?'style="background-color: #E4EA0C;"':'' ?> >
                                                                 <?php
                                                                if($_GET['km']==50000 && $_GET['year']==$i){
                                                                $details2 = $this->grid->getDetailsNew($value['grdm_id'],100, $i, 50000);
                                                                 if ($firstOwner) {
                                                                   echo $details2['grdtl_price'];
                                                                     //echo 'und';
                                                                 } else {
                                                                      echo ($value['grdtl_depreciation']/100)*$details2['grdtl_price'];
                                                                     // echo 'illa';
                                                                 }
                                                            }
                                                                 ?> </td>
                                                            <td class="td2" <?php echo ($i==$_GET['year'] && $_GET['km']==75000)?'style="background-color: #E4EA0C;"':'' ?> >
                                                                 <?php
                                                                    if($_GET['km']==75000 && $_GET['year']==$i){
                                                                 $details3 = $this->grid->getDetailsNew($value['grdm_id'],100, $i, 75000);
                                                                 if ($firstOwner) {
                                                                      echo $details3['grdtl_price'];
                                                                        //echo 'und';
                                                                    } else {
                                                                         echo ($value['grdtl_depreciation']/100)*$details3['grdtl_price'];
                                                                        // echo 'illa';
                                                                    }
                                                                 }
                                                                 ?></td>



                                                       <?php } ?>


                                                  </tr>
                                        <?php
                                             }
                                        }
                                        ?>
                                   </tbody>
                                <?php } ?>
                              </table>
                         </div>
                    </div>
               </div>
          </div>
     </div>

</div>
