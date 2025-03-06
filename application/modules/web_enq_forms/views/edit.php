<div class="right_col" role="main">
     <div class="">
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Edit Fellowship</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">

                         <?php
// Define the array
$categories = [
     ['id' => 1, 'title' => 'Luxury'],
     ['id' => 2, 'title' => 'Smart']
 ];
$genders = [
    ['id' => 1, 'title' => 'Male'],
    ['id' => 2, 'title' => 'Female']
];
?>     

                              <div class="panel panel-default">
                                   <div class="panel-heading">
                                   </div>
                                   <div class="panel-body">
                                        <form action="<?php echo site_url('web_enq_forms/updateFellowship'); ?>" method="post" accept-charset="utf-8" id="frmVehicleModel" class="form-horizontal form-label-left submitApproval"  enctype="multipart/form-data">

                                             <input type="hidden" name="web_id" value="<?php echo $master['web_id'] ?>">
                                             <input type="hidden" name="web_enq_type" value="<?php echo $master['web_enq_type'] ?>">
                                             


                                             <div class="form-group">
                                                  <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Category*
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                     
                                                  <select class="select2_group form-control" name="category" required="required">
    <?php foreach ($categories as $category) : ?>
        <option value="<?= $category['id'] ?>" <?= $master['web_category'] == $category['id'] ? 'selected' : '' ?>>
            <?= $category['title'] ?>
        </option>
    <?php endforeach; ?>
</select>

                                                  </div>
                                             </div>



                                             <div class="form-group">
                                                  <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Gender*
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                     
                                                  <select class="select2_group form-control" name="gender" required="required">
                                                  <?php foreach ($genders as $gender) : ?>
                <option value="<?= $gender['id'] ?>" <?= $master['web_gender'] == $gender['id'] ? 'selected' : '' ?>>
                    <?= $gender['title'] ?>
                </option>
            <?php endforeach; ?>
</select>

                                                  </div>
                                             </div>




                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Customer Name: <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">


                                                       <input type="text" placeholder="Name" name="name" value="<?php echo $master['web_name'] ?>" class="form-control col-md-7 col-xs-12 numOnly" required>
                                                  </div>
                                             </div>



                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Phone Numbers: <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <?php foreach ($phone_numbers as $key => $phone) : ?>

                                                       <input type="text" name="phone_no[]" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $phone['webph_phone']; ?>" required>
                        <input type="hidden" name="phone_id[]" value="<?php echo $phone['webph_id']; ?>">
                                                       
                                                       <?php endforeach; ?>
                                                  </div>
                                             </div>


                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Email
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="email" placeholder="Email" name="email" value="<?php echo $master['web_email'] ?>" class="form-control col-md-7 col-xs-12">

                                                  </div>
                                             </div>

                                      

                                             <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Instagram</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" placeholder="instagram" name="instagram" value="<?php echo $master['web_insta']; ?>" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">YouTube Channel</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" placeholder="YouTube Channel" name="youtube_channel" value="<?php echo $master['web_youtube']; ?>" class="form-control col-md-7 col-xs-12">
        </div>
    </div>

    <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" placeholder="Facebook" name="fb" value="<?php echo $master['web_fb']; ?>"  class="form-control col-md-7 col-xs-12">
        </div>
    </div>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> WhatsApp
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="number" placeholder="WhatsApp No" name="whats_app" value="<?php echo $master['web_whatsapp'] ?>"  class="form-control col-md-7 col-xs-12 numOnly">

                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Pin*
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="number" placeholder="Pin" name="pin" value="<?php echo $master['web_pin'] ?>" required  class="form-control col-md-7 col-xs-12 numOnly">

                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">District*
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                     
                                                  <select class="select2_group form-control" name="district" required="required">
    <?php foreach ($districts as $district) : ?>
        <option value="<?= $district['std_id'] ?>" <?= $master['web_district'] == $district['std_id'] ? 'selected' : '' ?>>
            <?= $district['std_district_name'] ?>
        </option>
    <?php endforeach; ?>
</select>

                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Address*
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" placeholder="Address" name="address" value="<?php echo $master['web_address'] ?>" required  class="form-control col-md-7 col-xs-12">

                                                  </div>
                                             </div>


                                             <!-- <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks <span class="required"></span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea required="" class="form-control col-md-7 col-xs-12" name="pr_remarks" placeholder="Remarks"></textarea>
                                             </div>
                                        </div> -->

                                             <div class="ln_solid"></div>
                                             <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button type="submit" class="btn btn-success">Submit</button>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                              </div>

                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong> Updated successfully!</strong>
</div>

<div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong>Error:Could not be submitted successfully!</strong>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
     $('.select2').select2();
</script>
<script>
     //     document.addEventListener('DOMContentLoaded', function () {
     //         var mouNoSelect = document.querySelector('select[name="pr_mou_no"]');
     //         var advanceField = document.querySelector('input[name="pr_advance"]');
     //         var totalField = document.querySelector('input[name="pr_total"]');
     //         var refurbTotalField = document.querySelector('input[name="pr_refurb_total"]');
     //         var RegField = document.querySelector('input[name="pr_reg_no"]');

     //         mouNoSelect.addEventListener('change', function () {
     //             var selectedOption = mouNoSelect.options[mouNoSelect.selectedIndex];
     //             var advanceValue = selectedOption.getAttribute('data-advance');
     //             var totalValue = selectedOption.getAttribute('data-total');
     //             var refurbTotalValue = selectedOption.getAttribute('data-refurb-total');
     //             var regValue = selectedOption.getAttribute('data-reg-no');

     //             advanceField.value = advanceValue || '';
     //             totalField.value = totalValue || '';
     //             refurbTotalField.value = refurbTotalValue || '';
     //             RegField.value = regValue || '';
     //         });
     //     });

     $(document).on('submit', ".submitApproval", function(e) {
          e.preventDefault();
          var url = $(this).attr('action');
          var formData = new FormData($(this)[0]);
          $.ajax({
               type: 'post',
               url: url,
               dataType: 'json',
               data: formData,
               async: false,
               cache: false,
               contentType: false,
               processData: false,
               beforeSend: function(xhr) {
                    //  $('.divLoading').show();
               },
               success: function(resp) {
                    $('.divLoading').hide();
                    $('.msgBox').show();
                    setTimeout(function() {
                         $('.msgBox').fadeOut();
                    }, 1500);
                    $("#approval-modal").trigger("reset");
                    $("#approvalModal").modal("hide");
                    var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
                    puchaseList(canDelete);
               }
          });
     });
</script>