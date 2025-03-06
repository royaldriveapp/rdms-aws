<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Grid </h2>
                        
                     <!--- -->
                     <div class="x_content">
                     <form class="frmFilter">
                              <table>
                                   <tbody><tr>
                                        
                                   <td>
                                                       <select data-placeholder="Brand" multiple data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" is-multi-check="1"
                                                               data-dflt-select="" class="cmbMultiSelect select2_group filter-form-control bindToDropdown" 
                                                               name="brand[]" id="brand">
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
                                   </td>
                                               

                                   <td>
                                                       <select data-placeholder="Model" multiple data-url="<?php echo site_url('enquiry/bindVarient');?>" is-multi-check="1"
                                                               data-bind="cmbEvVariant" data-dflt-select="" class="select2_group cmbEvModel cmbMultiSelect
                                                               filter-form-control bindToDropdown" name="model[]" id="val_model"></select>
                                   </td>

                                                  <td>
                                                       <select multiple class="select2_group filter-form-control cmbEvVariant cmbMultiSelect" is-multi-check="1" 
                                                               data-placeholder="Varient" name="variant[]" id="val_variant"></select>
                                                               </td>
                                                               <td>
                                                               <select data-placeholder="Year" multiple  is-multi-check="1"
                                                               data-dflt-select="" class="cmbMultiSelect select2_group filter-form-control bindToDropdown" 
                                                               name="year[]" id="year">
                                                               <?php
                                                     $firstYear = (int)date('Y')-11;
                                                   
                                                    $lastYear =   $firstYear+11;
                                                       for($i=$firstYear;$i<=$lastYear;$i++)
                                                       {?>
                                                       <option value="<?php echo $i ?>"><?php echo $i;?></option>
                                                   
                                                      <?php }
                                                       ?>
                                                               
                                                               
                                                       </select>
                                                               </td>

                                                               <td>
                                                       <select multiple class="select2_group filter-form-control  cmbMultiSelect" is-multi-check="1" 
                                                               data-placeholder="KM" name="km[]" id="km">
                                                               <option value="25000">25000</option>
                                                               <option value="50000">50000</option>
                                                               <option value="50000">75000</option>
                                                            </select>
                                                               </td>
                                                               <td>
                                                       <select multiple class="select2_group filter-form-control  cmbMultiSelect" is-multi-check="1" 
                                                               data-placeholder="No.Owner" name="owner[]" id="owner">
                                                               <option value="1">1</option>
                                                               <option value="2">2</option>
                                                               <option value="3">3</option>
                                                               <option value="4">4</option>
                                                               <option value="5">5</option>
                                                            </select>
                                                               </td>

                                                      
                                        <!-- <td>
                                             <input autocomplete="off" name="enq_pool_entry_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Pool date from" value="">
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_pool_entry_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Pool date to" value="">
                                        </td>

                                        <td>
                                             <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" placeholder="Search" value="">
                                        </td> -->
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Search</button>
                                        </td>

                                   </tr>
                              </tbody></table>
                         </form>
                    </div>
                    <!-- -->  

                         <div class="clearfix"></div>
                    </div>
                   
                    <div class="x_content">
                         <table id="track-table" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Sl</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Variant</th>
                                        <th>Year</th>
                                        <th>KM</th>
                                        <th>Owner</th>
                                        <th>Price</th>
                                        <th>%</th>

                                   </tr>
                              </thead>
                         </table>

                    </div>
               </div>
          </div>
     </div>
</div>
<script>
     $(document).ready(function() {
          valuationList();
          function valuationList(frmData='') {
               $('#track-table').DataTable().clear().destroy();
          $('#track-table').dataTable({
               "order": [],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               //"url": site_url + "evaluation/evaluation_ajax?" + frmData
               "ajax": site_url + "grid/grid_ajax?"+ frmData,
      
               'columns': [{
                         sortable: false,
                         "render": function(data, type, full, meta) {
                              var sl= meta.row+1;
                              var url = "<?php echo site_url('grid/gridLog'); ?>/" + full.grdm_id     ;
                              return "<a href=''>" + sl ; + "</a>";

                         }
                    },
                    //{data: 'val_veh_no'},
                    {
                         data: 'brd_title'
                    },
                    {
                         data: 'mod_title'
                    },
                    {
                         data: 'var_variant_name'
                    }
                    ,
                    {
                         data: 'grdtl_grdm_year'
                    }
                    ,
                    {
                         data: 'grdtl_km'
                    }
                    ,
                    {
                         data: 'grdtl_owner'
                    }
                    ,
                    {
                         data: 'grdtl_grdm_price'
                    }   
                    ,
                    {
                         data: 'grdtl_percentage'
                    }    
 

               ],
          });
     }
          
          $(document).on('submit', '.frmFilter', function (e) {
               e.preventDefault();
               valuationList($(this).serialize());
          });
     });

</script>