<style>
* {
  box-sizing: border-box;
}

.columns {
  float: left;
  width: 33.3%;
  padding: 8px;
}

.price {
  list-style-type: none;
  border: 1px solid #eee;
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.price .header {
  background-color: #111;
  color: white;
  font-size: 25px;
}

.price li {
  border-bottom: 1px solid #eee;
  padding: 0px;
  text-align: center;
}

.price .grey {
  background-color: #eee;
  font-size: 20px;
}

.button {
  background-color: #04AA6D;
  border: none;
  border-radius: 12px;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
}

@media only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Grid</h2>
                         <div class="clearfix"></div>
                        
                    
                         <!-- <div style="overflow-x:auto;">
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
                         </div> -->
                    

                    </div>
                    <div class="x_content">
                    <div class="columns">
                    <form action="" method="get">
  <ul class="price">
    <li class="header" style="background-color:#04AA6D"><select required="true" style="float: center;width: 100%;" class="select2_group form-control bindToDropdown" 
                                                  data-url="<?php echo site_url('grid/bindModel');?>" 
                                                  name="brand" id="brand" data-bind="cmbEvModel" data-dflt-select="Select Brand" >
                                                  <option value="">Select Brand</option>
                                                  <?php foreach ($brands as $key => $value) {?>
                                                       <option <?php echo $_GET['brand'] == $value['brd_id'] ? 'selected="selected"' : '';?> 
                                                            value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                       <?php }?>
                                             </select></li>
    <li class="grey"> <?php //if (isset($model) && !empty($model)) {?>
                                                  <select required="true" style="float: center;width: 100%;" class="select2_group form-control cmbEvModel bindToDropdown" 
                                                            data-url="<?php echo site_url('grid/bindVarient');?>" 
                                                            name="model" id="val_model"   data-bind="cmbEvVariant" data-dflt-select="Select variant" >
                                                       <option value="">Select Model</option>
                                                       <?php foreach ($models as $key => $value) {?>
                                                            <option <?php echo $_GET['model'] == $value['gmod_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['gmod_id']?>"><?php echo $value['gmod_title']?></option>
                                                            <?php }?>
                                                  </select>
                                             <?php //}?></li>
                                             <li class="header" style="background-color:#04AA6D"><select required="true" style="float: center;width: 100%;" class="select2_group form-control cmbEvVariant bindToDropdown" 
                                                  name="variant" id="val_variant" data-dflt-select="Select Vriant" >
                                                       <option value="">Select Variant</option>
                                                       <?php foreach ($variants as $key => $value) {?>
                                                            <option <?php echo $_GET['variant'] == $value['gvar_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['gvar_id']?>"><?php echo $value['gvar_variant']?></option>
                                                            <?php }?>
                                                  </select></li>
                                                 <li class="grey"> 
        <select required="true" style="float: center;width: 100%;" class="select2_group form-control" 
                                                  name="year" id="year">
                                                  <option value="">Select Year</option>
                                                               <?php
                                                     $firstYear = (int)date('Y')-11;
                                                   
                                                    $lastYear =   $firstYear+11;
                                                       for($i=$firstYear;$i<=$lastYear;$i++)
                                                       {?>
                                                       <option <?php echo $_GET['year'] == $i ? 'selected="selected"' : '';?> value="<?php echo $i ?>"><?php echo $i;?></option>
                                                   
                                                      <?php }
                                                       ?>
                                                               
                                                               
                                                       </select>
                                                    </li>
                                                    <li class="header" style="background-color:#04AA6D">
                                                    <select required="true" style="float: center;width: 100%;"class="select2_group form-control" 
                                                  name="km" id="km">
                                                  <option value="">Select KM</option>
                                                               <option <?php echo $_GET['km'] == 25000 ? 'selected="selected"' : '';?> value="25000">25000</option>
                                                               <option <?php echo $_GET['km'] == 50000 ? 'selected="selected"' : '';?> value="50000">50000</option>
                                                               <option <?php echo $_GET['km'] == 75000 ? 'selected="selected"' : '';?> value="75000">75000</option>
                                                            </select>
                                                
                                                </li>
                                                <li class="grey">
                                                <select required="true" style="float: center;width: 100%;" class="select2_group form-control" 
                                                  name="owner" id="owner">
                                                  <option value="">Select Owner</option>
                                                               <option <?php echo $_GET['owner'] == 1 ? 'selected="selected"' : '';?> value="1">1</option>
                                                               <option <?php echo $_GET['owner'] == 2 ? 'selected="selected"' : '';?> value="2">2</option>
                                                               <option <?php echo $_GET['owner'] == 3 ? 'selected="selected"' : '';?> value="3">3</option>
                                                               <option <?php echo $_GET['owner'] == 4 ? 'selected="selected"' : '';?> value="4">4</option>
                                                               <option <?php echo $_GET['owner'] == 5 ? 'selected="selected"' : '';?> value="5">5</option>
                                                            </select>
                                                </li>
    <li class="grey">Grid Price Kerala: <?php echo $grid_data['grdtl_price'] ?> </li>
    <li class="grey">Years: <?php echo $grid_data['grdm_year_range'] ?> </li>


    <li class=""><button type="submit" class="button">Filter</button></li>
  </ul>
                    </form>
</div>

                    </div>
               </div>
          </div>
     </div>

</div>
