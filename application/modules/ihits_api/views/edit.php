<div class="right_col" role="main">
     <div class="">
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Purchase</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                    
                              <!-- <div class="panel panel-default">
                                   <div class="panel-heading">
                                        <div><button data-url="£" class="btnBookingForm btn btn-primary">Submit</button></div>
                                        <div class="divBookingForm"></div>
                                   </div>
                                   <div class="panel-body">
    <form id="purchaseForm">
        <ul class="list-group">
            <li class="list-group-item">
                <select class="select2_group form-control cmbFollStatus" name="pr_mou_no" required="required">
                    <option value="0">Select Vehicle</option>
                    <?php foreach ($purchase_data as $item) : ?>
                        <option value="<?= $item['moum_number'] ?>" data-advance="<?= $item['moum_adv_token'] ?>"><?= "{$item['moum_number']} / {$item['moum_reg_num']}" ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li class="list-group-item">
                Total price: <input type="number" placeholder="Total Amount" name="pr_total" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Refurb job Total: <input type="number" placeholder="Refurb job Total" name="pr_refurb_total" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Advance: : <input type="number" value="" placeholder="Advance" id="advanceField" name="pr_advance" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Fine: <input type="number" placeholder="Fine" name="pr_fine" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Brokerage: <input type="number" placeholder="Brokerage" name="pr_brokerage" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Insurance: <input type="number" placeholder="Insurance" name="pr_insurance" class="form-control col-md-7 col-xs-12">
            </li>
        </ul>
    </form>
</div>

                              </div> -->

                              <div class="panel panel-default">
                                   <div class="panel-heading">
                                                                      </div>
                                   <div class="panel-body">
                                        <form action="<?php echo site_url('purchase/update');?>" method="post" accept-charset="utf-8" id="frmVehicleModel" class="form-horizontal form-label-left" onsubmit="return validateForm()" enctype="multipart/form-data"> 

                                        <input type="hidden" name="pr_id" value="<?php echo $purchase['pr_id'] ?>">
                                        
           
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle*
                                                                                               </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="text" value="<?php echo $purchase['pr_reg_no'] ?>" placeholder="Reg No" disabled class="form-control col-md-7 col-xs-12 " required>
                                             <!-- <select class="select2_group form-control cmbFollStatus" name="pr_mou_no" required="required">
<option value="0">Select Vehicle</option>
<?php foreach ($mou_data as $item) : ?>
<option value="<?= $item['moum_number'] ?>" data-advance="<?= $item['moum_adv_token'] ?>" data-reg-no="<?= $item['moum_reg_num'] ?>" ><?= "{$item['moum_number']} / {$item['moum_reg_num']}" ?></option>
<?php endforeach; ?>
</select>    -->
                                             </div>
                                        </div>
 <div class="form-group">
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Total price<span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" value="<?php echo $purchase['pr_total'] ?>" placeholder="Total Amount" name="pr_total" class="form-control col-md-7 col-xs-12 numOnly" required>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12"> Refurb job Total: <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">


                                                  <input type="number" placeholder="Refurb job Total" name="pr_refurb_total" value="<?php echo $purchase['pr_refurb_total'] ?>" class="form-control col-md-7 col-xs-12 numOnly" required>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Advance*
                                                                                               </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                              <input type="number" placeholder="Advance" id="advanceField" disabled value="<?php echo $purchase['pr_advance'] ?>" class="form-control col-md-7 col-xs-12 numOnly" required>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">  Fine
                                                                                               </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" placeholder="Fine" name="pr_fine" value="<?php echo $purchase['pr_fine'] ?>" class="form-control col-md-7 col-xs-12 numOnly" >

                                        </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">  Brokerage
                                                                                               </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                              <input type="number" placeholder="Brokerage" name="pr_brokerage" value="<?php echo $purchase['pr_brokerage'] ?>" class="form-control col-md-7 col-xs-12 numOnly" >

                                        </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">  Insurance* 
                                                                                               </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="number" placeholder="Insurance" name="pr_insurance" value="<?php echo $purchase['pr_insurance'] ?>" required class="form-control col-md-7 col-xs-12 numOnly">

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
                                                  <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                                  
                                             </div>
                                        </div>
                                        </form>                  </div>
                              </div>

                         </div>
                    </div>
               </div>
          </div>
     </div>
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
</script>
