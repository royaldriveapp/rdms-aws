<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Model</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("", array('id' => "frmCar", 'class' => "form-horizontal form-label-left"))?>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                          <select name="mod_brand" id="rcn_brand" class="select2 form-control col-md-7 col-xs-12" required="required">
                                                <option value="1">Select</option> 
                                                <option value="2">Car</option> 
                                                <option value="3">Bike</option> 
                                                <option value="4">Scooter</option> 
                                                <option value="5">Cycle</option> 
                                                <option value="6">Horse</option> 
                                          </select>
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

<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $('.select2').select2();
</script>