<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Stock against enquiry</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Customer name</th>
                                        <th>Customer Contact</th>
                                        <th>Reg no</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Variant</th>
                                        <th>Sales staff</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   if (!empty($data)) {
                                        foreach ($data as $key => $value) {
                                             ?>
                                             <tr>
                                                  <td><?php echo $value['enq_cus_name']; ?></td>
                                                  <td><?php echo $value['enq_cus_mobile']; ?></td>
                                                  <td><?php echo $value['val_prt_1'] . '-' . $value['val_prt_2'] . '-' . $value['val_prt_3'] . '-' . $value['val_prt_4']; ?></td>
                                                  <td><?php echo $value['brd_title']; ?></td>
                                                  <td><?php echo $value['mod_title']; ?></td>
                                                  <td><?php echo $value['var_variant_name']; ?></td>
                                                  <td><?php echo $value['usr_first_name'] . ' ' . $value['usr_last_name']; ?></td>
                                             </tr>
                                             <?php
                                        }
                                   }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>