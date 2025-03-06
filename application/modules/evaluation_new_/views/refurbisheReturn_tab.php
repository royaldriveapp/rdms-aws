
             
                    <div class="x_title">
                         <h2>Refurbish job <i style="cursor: pointer;" class="fa fa-plus btnNewRefurbishJob"></i></h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/refurbisheReturn", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>
                         <input type="hidden" name="evaluationId" value="<?php echo $vehicles['val_id']?>"/>
                         <table class="tblUpgradeDetails table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>SL NO</th>
                                        <th>Refurbish job in evaluation</th>
                                        <th>Estimated cost</th>
                                        <th>Actual job description</th>
                                        <th>Actual cost</th>
                                        <th>Description</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                  // debug($vehicles['upgradeDetails']);
                                     if (!empty($vehicles['upgradeDetails'])) {
                                          foreach ($vehicles['upgradeDetails'] as $key => $value) {
                                               ?>
                                               <tr>
                                                    <td><?php echo $key + 1;?></td>
                                                    <td><?php echo $value['upgrd_key'];?></td>
                                                    <td><?php echo $value['upgrd_value'];?></td>
                                                    <td><input type="text" name="refrubishjob[<?php echo $value['upgrd_id']?>][actual_job_desc]" value="<?php echo $value['actual_job_description']?>" class="form-control col-md-7 col-xs-12"/></td>
                                                    <td>
                                                         <input type="hidden" name="refrubishjob[<?php echo $value['upgrd_id']?>][upgrd_id]" value="<?php echo $value['upgrd_id']?>"/>
                                                         <input type="text" name="refrubishjob[<?php echo $value['upgrd_id']?>][newcost]"  value="<?php echo $value['upgrd_refurb_actual_cost']?>" class="decimalOnly form-control col-md-7 col-xs-12"/>
                                                    </td>
                                                    <td><input type="text" name="refrubishjob[<?php echo $value['upgrd_id']?>][desc]" value="<?php echo $value['upgrd_refurb_remarks']?>"  class="form-control col-md-7 col-xs-12"/></td>
                                               </tr>
                                               <?php
                                          }
                                     }
                                   ?>
                              </tbody>
                         </table>
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                         </div>
                         <?php echo form_close()?>
                    </div>




                    <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <strong>Updated successfully!</strong>
    </div>

<script>



$("#frmAccessories").submit(function(e) {

    e.preventDefault();

    var form = $(this);
   
    //var url = form.attr('action');
    var url=site_url+'<?php echo $controller ?>/refurbisheReturn';

//alert(url);
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        dataType: "json",
        beforeSend: function() {

            $('.divLoading').show();
        },
        success: function(data) {
            $('.divLoading').hide();

            if (data.status == "success") {
            
                $('.msgBox').show();
              

                setTimeout(
  function() 
  {
     $('.msgBox').fadeOut();
   
  }, 1500);
              

            } else {
                $('.ErrorMsgBox').show();
            }

        }
    });


});
</script>
             
          