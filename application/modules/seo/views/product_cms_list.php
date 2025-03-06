<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Product title list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Product number</th>
                                        <th>Vehicle</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Web page</th>
                                        <th>Set title</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php if (!empty($products)) {
                                        foreach ($products as $key => $value) { ?>
                                             <tr>
                                                  <td><?php echo $value['prd_number']; ?></td>
                                                  <td><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?>
                                                  </td>
                                                  <td title="<?php echo strip_tags($value['prd_page_title']); ?>">
                                                       <?php echo get_snippet(strip_tags($value['prd_page_title']), 10); ?>
                                                  </td>
                                                  <td title="<?php echo get_snippet($value['prd_page_title']); ?>">
                                                       <?php echo get_snippet(strip_tags($value['prd_meta_desc']), 10); ?>
                                                  </td>
                                                  <td>
                                                       <?php
                                                       $name = $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'];
                                                       //$url = 'https://www.royaldrive.in/' . $value['brd_slug'] . '/' . get_url_string($name) . '-' . $value['prd_id'];

                                                       if ($value['prd_rd_mini'] == 1) {
                                                            $url = 'https://www.royaldrivesmart.in/vehicle/' . $value['prd_id'] . '-' . get_url_string($name);
                                                       } else {
                                                            $url = 'https://royaldrive.in/' . $value['brd_slug'] . '/' . get_url_string($name) . '-' . $value['prd_id'];
                                                       }
                                                       ?>
                                                       <a href="<?php echo $url; ?>"><i class="fa fa-link"></i></a>
                                                  </td>
                                                  <td>
                                                       <a href="<?php echo site_url('seo/productTitle/' . $value['prd_id']); ?>">
                                                            <i class='fa fa-arrow-right'></i></a>
                                                  </td>
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