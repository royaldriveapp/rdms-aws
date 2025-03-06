<div class="right_col" role="main">
     <div class="">
          <div class="clearfix"></div>
          <div class="row">
               <div class="col-md-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Compose Leave</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <div class="row">
                                   <div class="col-sm-3 mail_list_column">
                                        <a href="<?php echo site_url('payroll/apply_leave');?>" id="compose" class="btn btn-sm btn-success btn-block" 
                                           type="button">LEAVE INBOX</a>
                                        <a href="javascript:;">
                                             <div class="mail_list">
                                                  <div class="left">
                                                       <i class="fa fa-circle" style="color: yellowgreen;" title="Leave granted"></i>
                                                  </div>

                                                  <div class="right">
                                                       <h3>Leave for... <small>10 Jun 2018</small></h3>
                                                       <p>Leave due to marriage function...</p>
                                                  </div>

                                                  <div class="left">
                                                       <i class="fa fa-edit" title="Leave granted"></i>
                                                  </div>

                                                  <div class="right"><p>Dulkar salman</p></div>
                                             </div>
                                        </a>
                                        <a href="javascript:;">
                                             <div class="mail_list">
                                                  <div class="left">
                                                       <i class="fa fa-circle" style="color: red;" title="Leave rejected"></i>
                                                  </div>

                                                  <div class="right">
                                                       <h3>Leave for... <small>10 Jun 2018</small></h3>
                                                       <p>Leave due to marriage function...</p>
                                                  </div>

                                                  <div class="left">
                                                       <i class="fa fa-edit" title="Leave granted"></i>
                                                  </div>

                                                  <div class="right"><p>Dulkar salman</p></div>
                                             </div>
                                        </a>
                                        <a href="javascript:;">
                                             <div class="mail_list">
                                                  <div class="left">
                                                       <i class="fa fa-circle" title="Leave preceed"></i>
                                                  </div>

                                                  <div class="right">
                                                       <h3>Leave for... <small>10 Jun 2018</small></h3>
                                                       <p>Leave due to marriage function...</p>
                                                  </div>

                                                  <div class="left">
                                                       <i class="fa fa-edit" title="Leave granted"></i>
                                                  </div>

                                                  <div class="right"><p>Dulkar salman</p></div>
                                             </div>
                                        </a>
                                   </div>
                                   <!-- /MAIL LIST -->

                                   <!-- CONTENT MAIL -->
                                   <div class="col-sm-9 mail_view">
                                        <div class="inbox-body">
                                             <?php echo form_open_multipart("product/add", array('id' => "frmProduct", 'class' => "form-horizontal form-label-left"))?>
                                             <div class="form-group">
                                                  <label class="control-label col-md-2 col-sm-3 col-xs-12">Leave Start</label>
                                                  <div class="col-md-10 col-sm-6 col-xs-12">
                                                       <input required type="text" class="form-control col-md-7 col-xs-12 dtpLeaveDateFrom" name="product[prd_number]" id="prd_number"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-2 col-sm-3 col-xs-12">Leave End</label>
                                                  <div class="col-md-10 col-sm-6 col-xs-12">
                                                       <input required type="text" class="form-control col-md-7 col-xs-12 dtpLeaveDateFrom" name="product[prd_number]" id="prd_number"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-2 col-sm-3 col-xs-12">Title</label>
                                                  <div class="col-md-10 col-sm-6 col-xs-12">
                                                       <input required type="text" class="form-control col-md-7 col-xs-12" name="product[prd_number]" id="prd_number"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-2 col-sm-3 col-xs-12">Purpose</label>
                                                  <div class="col-md-10 col-sm-6 col-xs-12">
                                                       <textarea class="form-control col-md-7 col-xs-12 editor"></textarea>
                                                  </div>
                                             </div>

                                             <div class="ln_solid"></div>
                                             <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                       <button type="submit" class="btn btn-success">Submit</button>
                                                       <button class="btn btn-primary" type="reset">Reset</button>
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