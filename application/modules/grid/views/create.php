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
                        
                         <ul class="nav navbar-right panel_toolbox">
                             
                                   <li style="float: right;">
                                        <a class="btnExport" href="javascript:void(0);">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   </li>
                            
                         </ul>
                      
                         

                    </div>
                    <div class="x_content">
                    <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Create Grid</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/store", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>
                         <table>
                                   <tr>
                                        <td style="margin: 10px;">
                                        <?php //print($brands); ?>
                                             <select required="true" style="float: left;width: auto;" class="select2_group form-control bindToDropdown" 
                                                  data-url="<?php echo site_url('enquiry/bindModel');?>" 
                                                  name="brand" id="brand" data-bind="cmbEvModel" data-dflt-select="Select Brand" >
                                                  <option value="0">Select Brand</option>
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
                                                       <option value="0">Select Model</option>
                                                       <?php foreach ($models as $key => $value) {?>
                                                            <option <?php echo $_GET['model'] == $value['mod_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                            <?php }?>
                                                  </select>
                                             <?php //}?>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <?php // if (isset($variant) && !empty($variant)) {?>
                                                  <select required="true" style="float: left;width: auto;" class="select2_group form-control cmbEvVariant bindToDropdownj" 
                                                  name="variant" id="val_variant" data-dflt-select="Select Vriant" >
                                                       <option value="0">Select Variant</option>
                                                       <?php foreach ($variants as $key => $value) {?>
                                                            <option <?php echo $_GET['variant'] == $value['var_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                            <?php }?>
                                                  </select>
                                             <?php //}?>
                                        </td>

                                        <td><p id="message"> </p></td>
                                        

                                                         
                                                            
                                
                                       
                                   </tr>
                                 
                              </table>
                             <br>
                         <table class="tblUpgradeDetails table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Owner</th>
                                        <th>1 </th> 
                                        <th>2</th>
                                        <th>3</th>
                                        
                                   </tr>
                              </thead>
                              <tbody>
                                 
                                    
                                               <tr>
                                                       <td>Depreciation (%)</td>
                                                       <td><input type="text" value="100" name="depre_owner1" class="form-control col-md-7 col-xs-12"/></td>
                                                       <td><input type="text" name="depre_owner2" class="decimalOnly form-control col-md-7 col-xs-12"/></td>
                                                       <td><input type="text" name="depre_owner3" class="form-control col-md-7 col-xs-12"/></td>
                                                       
                                               </tr>
                                   
                              </tbody>
                         </table>
                         <table class="tblUpgradeDetails table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Date Ranges</th>
                                        <th><input type="text" name="date_ranges" class="form-control col-md-7 col-xs-12"/></th> 
                                        
                                        
                                   </tr>
                              </thead>
                             
                         </table>
                         <table class="tblUpgradeDetails table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Year</th>
                                        <th>25000 KM</th>
                                        <th>50000 KM</th>
                                        <th>75000 KM</th>
                                       
                                   </tr>
                              </thead>
                              <tbody>
                                 
                              <?php
                                                     $firstYear = (int)date('Y')-9;
                                                   
                                                    $lastYear =   $firstYear+9;
                                                       for($i=$firstYear;$i<=$lastYear;$i++)
                                                       {?>
                                               <tr>
                                                       <td><?php echo $i; ?></td>
                                                       <input type="hidden" value="<?php echo $i; ?>" name="cost[year][]" />
                                                       <td><input type="text" name="cost[50000][]" placehoder='Price' value='0' class="decimalOnly form-control col-md-7 col-xs-12"/></td>
                                                       <td><input type="text" name="cost[25000][]" placehoder='Price' value='0' class="decimalOnly form-control col-md-7 col-xs-12"/></td>
                                                       <td><input type="text" name="cost[75000][]" placehoder='Price' value='0' class="decimalOnly form-control col-md-7 col-xs-12"/></td>
                                                    
                                               </tr>
                                               <?php } ?>
                                   
                              </tbody>
                         </table>
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success submit-btn">Submit</button>
                              </div>
                         </div>
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
                    </div>
               </div>
          </div>
     </div>

</div>
<script>
     var img_url = '<?php echo base_url('assets/images/loading.gif'); ?>';


     function saveToDatabase(editableObj, wk, month_id, stff_id) {
          $(editableObj).css("background", "#FFF url(https://www.royaldrive.in/rdportal/assets/images/loaderIcon.gif) no-repeat center right 5px");
          $.ajax({
               url: site_url + "emp_details/storeTargets",
               type: "POST",
               data: 'wk=' + wk + '&target=' + parseInt(editableObj.innerHTML) +
                    '&month_id=' + month_id + '&stff_id=' + stff_id + '&tagetCategory=' + trgt_category,
               success: function(data) {
                    $(editableObj).css("background", "#42f57e");
               },
               error: function(error) {
                    $(editableObj).css("background", "#f54242");
               }
          });
     }
     $('.tr_bg').bind('click', function(e) {
          var click = $(this).data('clicks');
          if (click % 2 == 1) {
               $(e.target).closest('tr').children('td,th').css('background-color', '#f2ca16');
          } else {
               $(e.target).closest('tr').children('td,th').css('background-color', '#fff');
          };
          $(this).data('clicks', click + 1);

     });

     $('.td_bg').bind('click', function(e) {
          var td_class = $(this).data('td');
          var click = $(this).data('clicks');
          if (click % 2 == 1) {
               $(e.target).closest('td').css('background-color', '#f2ca16');
               $('.' + td_class).closest('td').css('background-color', '#f2ca16');
          } else {
               $(e.target).closest('td').css('background-color', '#fff');
               $('.' + td_class).closest('td').css('background-color', '#fff');
          };
          $(this).data('clicks', click + 1);

     });



     $(document).on('change', '.cmbEvVariant', function () {
        var id = $(this).val();
        
        var url ="<?php echo site_url('grid/isExist')?>";
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            data: {
                id: id
            },
            success: function (resp) {
              if(resp){
               alert(resp);
                $('#message').html("&nbsp;<font color='red'> This record already exists. </font>");
                $('.submit-btn').hide();
              }else{
               $('#message').html("");
               $('.submit-btn').show();
              }
            
            }
        });
    });
</script>

<script>
     $(document).ready(function () {
      
          $(document).on('click', '.btnExport', function (e) {
               alert(121);
               $.ajax({
                    type: 'post',
                    url: site_url + "grid/exportExl",
                    dataType: 'json',
                    success: function (resp) {
                         window.location.href = resp;
                    }
               });
          });
     });
     </script>