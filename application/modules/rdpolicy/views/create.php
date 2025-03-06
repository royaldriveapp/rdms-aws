<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>RD Policies</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                         <!-- -->
                         <div class="x_content">
                              <table id="datatable" class="table table-striped table-bordered">
                                   <thead>
                                        <tr>
                                             <th>Policy title</th>
                                             <th>Description</th>
                                             <th>Document</th>
                                             <th>Delete</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        if (!empty($data)) {
                                             foreach ($data as $key => $value) {
                                                  ?>
                                                  <tr data-url="<?php echo site_url($controller . '/view/' . $value['pol_id']); ?>">
                                                       <td class="trVOE"><?php echo $value['pol_title']; ?></td>
                                                       <td class="trVOE"><?php echo $value['pol_desc']; ?></td>
                                                       <td>
                                                            <a href="<?php echo 'https://royaldrive.in/assets/uploads/rdpolicies/' . $value['pol_doc']; ?>">View</a>
                                                       </td>
                                                       <td>
                                                         <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                            data-url="<?php echo site_url($controller . '/delete/' . $value['pol_id']);?>">
                                                              <i class="fa fa-remove"></i>
                                                         </a>
                                                    </td>
                                                  </tr>
                                                  <?php
                                             }
                                        }
                                        ?>
                                   </tbody>
                              </table>
                         </div>
                         <!-- -->

                         <?php echo form_open_multipart($controller . "/create", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left")) ?>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="pol_title" id="pol_title" placeholder="Title"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="pol_desc" id="pol_desc" placeholder="Description"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Document</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="file" class="form-control col-md-7 col-xs-12" name="pol_doc" id="pol_doc"/>
                              </div>
                              <span class="help-inline">Please upload PDF format</span>
                         </div>

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>