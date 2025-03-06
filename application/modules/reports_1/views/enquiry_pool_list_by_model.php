
<style>
     .filter{
          margin-bottom: 10px;
     }
     .btn-round{
          margin-left: 10px;  
     }
     .noDataMessage{
          text-align: center;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquiry Pool List</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row filter">
                              <form action="<?php echo site_url('reports/enquiry_pool_list_by_model/');?>" method="get" id="filterForm">
                                   <div class="col-md-2">
                                        <?php $kms = get_km_ranges();?>
<!--                                   <select style="float: left;width: auto;" class="select2_group form-control" name="km">-->
                                        <select data-placeholder="Select KM" name="km[]" class="select2_group filter-form-control  cmbMultiSelect" multiple>

                                             <?php foreach ($kms as $km) {?>
                                                    <option value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>

                                               <?php }?>
                                        </select>
                                   </div>
                                   <div class="col-md-2">
                                        <div class="div-filter-form-control">
                                             <select data-placeholder="Select Year" name="year[]" class="select2_group filter-form-control cmbMultiSelect" multiple>
                                                  <?php
                                        $earliest_year = YEAR_RANGE_START;
                                                    $latest_year = date('Y');
                                                    foreach (range($latest_year, $earliest_year) as $i) {
                                                         ?>
                                                         <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>  

                                             </select>
                                        </div>
                                   </div>
                                      <div class="col-md-2">
                                      <div class="div-filter-form-control">
                                                       <select data-placeholder="Brand" multiple data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" is-multi-check="1"
                                                               data-dflt-select="" class="cmbMultiSelect select2_group filter-form-control bindToDropdown" 
                                                               name="val_brand[]" id="val_brand">
                                                                    <?php
                                                                      if (!empty($brand)) {
                                                                           foreach ($brand as $key => $value) {
                                                                                ?>
                                                                        <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                                                        <?php
                                                                   }
                                                              }
                                                            ?>
                                                       </select>
                                                  </div>

                                   </div>
                                      <div class="col-md-2">
                                            <div class="div-filter-form-control">
                                                       <select data-placeholder="Model" multiple data-url="<?php echo site_url('enquiry/bindVarient');?>" is-multi-check="1"
                                                               data-bind="cmbEvVariant" data-dflt-select="Select variant" class="select2_group cmbEvModel cmbMultiSelect
                                                               filter-form-control bindToDropdown" name="val_model[]" id="val_model"></select>
                                                  </div>
                                   
                                   </div>
                                      <div class="col-md-2">
                                           <div class="div-filter-form-control">
                                                       <select  data-dflt-select="" class="select2_group filter-form-control cmbEvVariant cmbMultiSelect" is-multi-check="0" 
                                                               data-placeholder="Varient" name="val_variant" id="val_variant"></select>
                                                  </div>
                                      
                                   </div>
                                   <div class="col-md-1">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </div>
                              </form>
                         </div>
                         <div class="row">
                              <div class="table-responsive">
                                   <table class="table table-striped table-bordered "  id="rowClick">
                                        <thead style="background-color: gray; color: white;">
                                             <tr>
                                                  <th>Make</th>  <th>Model</th>  <th>Variant</th>  <th>Model Year</th> 
                                                  <th>HOT+</th><th>HOT</th><th>WARM</th><th>COLD</th><th>Inquired  veh NOS</th><th>Total Enquiry</th><th>Drop</th><th>Available in Purchase</th>
                                             </tr>
                                        </thead>
                                        <tbody id="ajx_content">           

                                             <?php
                                               //  dd($enquiries);
                                               if (!empty($enquiries)) {
                                                    foreach ($enquiries as $key => $enquery) {
                                                         $count = $this->reports->getDataCountForGrpByModel($enquery['veh_model'], $enquery['veh_year']);
                                                         ?>
                                                         <tr data-url="<?php echo site_url('reports/enquiry_pool/' . encryptor($enquery['veh_model']) . '/' . encryptor($enquery['veh_year']));?>">
                                                              <td class="details-control trVOE"">
                                                                   <?php echo $enquery['brd_title']?>
                                                                   - <?php //echo $enquery['veh_varient']?>
                                                                   - <?php echo $enquery['veh_enq_id']?>

                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php echo $enquery['mod_title']?>

                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php //echo $enquery['var_variant_name']?>

                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php
                                                                   //print_r($mod_yr_range)
                                                                   echo $enquery['veh_year']
                                                                   ?>

                                                              </td>

                                                              <td class="details-control trVOE"">
                                                                   <?php
                                                                   echo $count['hot_plus'];
                                                                   ?>

                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php
                                                                   echo $count['hot'];
                                                                   ?>

                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php
                                                                   echo $count['warm'];
                                                                   ?>
                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php
                                                                   echo $count['cold'];
                                                                   ?>
                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php echo $count['hot_plus'] + $count['hot'] + $count['warm'] + $count['cold'];?> 

                                                              </td>

                                                              <td class="details-control trVOE"">
                                                                   <?php echo $count['hot_plus'] + $count['hot'] + $count['warm'] + $count['cold'] + $count['dropCount'];?>
                                                              </td>
                                                              <td class="details-control trVOE"">    
                                                                   <?php
                                                                   echo $count['dropCount'];
                                                                   ?>
                                                              </td>
                                                              <td class="details-control trVOE"">
                                                                   <?php echo $count['purchase_count'];?>

                                                              </td>
                                                         </tr>
                                                         <?php
                                                    }
                                               }
                                             ?>

                                        </tbody>
                                   </table>
                                   <span class='noDataMessage ' style="display: none"><p>No data found</p></span>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>

     $("#filterForm").submit(function (e) {

          e.preventDefault();

          var form = $(this);
          var url = form.attr('action');

          $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(),
               dataType: "html",
               beforeSend: function () {

                    // $('.divLoading').show();
               },
               success: function (data) {
                    $('.divLoading').hide();
                    //alert(data);

                    if (data === 'No records found') {
                         $('.noDataMessage').show();
                         $('#ajx_content').html('');
                    }
                    var results = JSON.parse(data);

                    $('#ajx_content').html(results);
                    $('.noDataMessage').hide();


//                    if (data.status == "success") {
//                         //console.log(data.check_listMasterId);
//                         $('.msgBox').show();
//                         setTimeout(function () {
//                              window.location.replace(site_url + "evaluation/purchase_check_list_print/" + data.check_listMasterId);
//                         }, 1500);
//                    } else {
//                         $('.ErrorMsgBox').show();
//                    }

               }
          });
     });

</script>
