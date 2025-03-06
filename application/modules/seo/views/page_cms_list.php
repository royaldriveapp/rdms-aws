<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Page title list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Page</th>
                                        <th>Section</th>
                                        <th>Content</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   if (!empty($data)) {
                                        foreach ($data as $key => $value) {
                                             ?>
                                             <tr data-url="<?php echo site_url($controller . '/setPagecms/' . $value['seocms_id']); ?>">
                                                  <td class="trVOE"><?php echo $value['seop_name']; ?></td>
                                                  <td class="trVOE"><?php echo $value['seocms_section']; ?></td>
                                                  <td class="trVOE" title="<?php echo strip_tags($value['seocms_content']); ?>">
                                                       <?php echo get_snippet(strip_tags($value['seocms_content']), 10); ?>
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