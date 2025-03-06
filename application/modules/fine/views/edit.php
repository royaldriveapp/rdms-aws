<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fine <i style="cursor: pointer;" class="fa fa-plus btnNewFine"></i></h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/update/" . encryptor($data['masterData']['finm_id'], 'E'), array('id' => "frmBrand", 'class' => "form-horizontal form-label-left frmEmployee"))?>
                         <input type="hidden" value="<?php echo $data['masterData']['finm_id']?>" name="master_id" ?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php if (!empty($stocks)) {?>
                                          <select name="fin_val_id" id="fin_val_id" class="cmbSearchList select2_group form-control cmbUser" required="required">
                                               <option value="">Select stock</option>
                                               <?php foreach ($stocks as $stock) { ?>
                                                    <option value="<?php echo $stock['val_id'];?>" <?php echo ($stock['val_id'] == $data['masterData']['finm_stock_id']) ? 'selected' : ''; ?>>
                                                        <?php echo $stock['val_stock_num'] . ' - ' . $stock['val_veh_no']?>
                                                    </option>
                                               <?php } ?>
                                          </select>
                                     <?php }?>
                              </div>
                         </div>
                         <div style="width:100%;overflow-x: scroll;">
                              <table cellpadding="0"; cellspacing="0" class="tblUpgradeDetails tblRefurb" style="width:100%;white-space: nowrap;">
                                   <tr>
                                        <th>Bill no</th>
                                        <th>Bill date</th>
                                        <th>Fine category</th>
                                        <th>Fine without GST</th>
                                        <th>SGST(%)</th>
                                        <th>SGST</th>
                                        <th>CGST(%)</th>
                                        <th>CGST</th>
                                        <th>IGST(%)</th>
                                        <th>IGST</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        
                                   </tr>
                                   <?php foreach ($data['detailsData'] as $detail) { ?>
                                       <tr>
                                       <input type="hidden" value="<?php echo $detail['find_id']; ?>" name="fine[find_id][]">
                                            <td><input type="text" name="fine[find_billno][]" required="required" value="<?php echo $detail['find_billno']; ?>"/></td>
                                            <td><input type="text" name="fine[find_billl_date][]" class="dtpDMY" value="<?php echo date('d-m-Y', strtotime($detail['find_billl_date'])); ?>"/></td>
                                            <td>
                                                 <select name="fine[find_fine_category][]" id="find_fine_category" style="border: none;" required="required">
                                                      <option value="">Select fine category</option>
                                                      <?php foreach (unserialize(FINE_CATEGORY) as $key => $value) { ?>
                                                           <option value="<?php echo $key; ?>" <?php echo ($key == $detail['find_fine_category']) ? 'selected' : ''; ?>>
                                                               <?php echo $value; ?>
                                                           </option>
                                                      <?php } ?>
                                                 </select>
                                            </td>
                                           
                                            <td><input type="text" name="fine[find_amount][]" class="decimalOnly" value="<?php echo $detail['find_amount']; ?>"/></td>
                                            <td><input type="text" name="fine[find_sgst][]" class="sgstp" value="<?php echo $detail['find_sgst']; ?>"/></td>
                                            <td><input type="text" name="fine[find_sgst_amt][]" class="gst" value="<?php echo $detail['find_sgst_amt']; ?>"/></td>
                                            <td><input type="text" name="fine[find_cgst][]" class="cgstp" value="<?php echo $detail['find_cgst']; ?>"/></td>
                                            <td><input type="text" name="fine[find_cgst_amt][]" class="cgst" value="<?php echo $detail['find_cgst_amt']; ?>"/></td>
                                            <td><input type="text" name="fine[find_igst][]" class="igstp" value="<?php echo $detail['find_igst']; ?>"/></td>
                                            <td><input type="text" name="fine[find_igst_amt][]" class="igst" value="<?php echo $detail['find_igst_amt']; ?>"/></td>
                                            <td><input type="text" name="fine[find_narration][]" value="<?php echo $detail['find_narration']; ?>"/></td>
                                            <td><button type="button" data-id="<?php echo $detail['find_id']; ?>" class="btnDeleteExisting dlt"> <i class="fa fa-remove"></i> </button></td>
                                       </tr>
                                   <?php } ?>
                              </table>
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
<script>
<?php
  $sstations = unserialize(SERVICE_STATION);
  $sstationsJson = json_encode($sstations);
  echo "var sstations = " . $sstationsJson . ";\n";
?>
     $(document).ready(function () {
          $('.dtpDMY').datetimepicker({format: "DD-MM-YYYY"});
     });

     $(document).on('click', '.btnNewFine', function (e) {
    var fineCategoryOptions = '';
    <?php foreach (unserialize(FINE_CATEGORY) as $key => $value) { ?>
        fineCategoryOptions += '<option value="<?php echo $key; ?>"><?php echo $value; ?></option>';
    <?php } ?>

    var newRow = '<tr>' +
        '<td><input type="hidden" name="fine[find_id][]" value="new" /><input type="text" name="fine[find_billno][]" required="required"/></td>' +
        '<td><input type="text" name="fine[find_billl_date][]" class="dtpDMY"/></td>' +
        '<td>' +
        '    <select name="fine[find_fine_category][]" id="find_fine_category" style="border: none;" required="required">' +
        '        <option value="">Select fine category</option>' +
        fineCategoryOptions +
        '    </select>' +
        '</td>' +
        '<td><input type="text" name="fine[find_amount][]" class="decimalOnly"/></td>' +
        '<td><input type="text" name="fine[find_sgst][]" class="sgstp"/></td>' +
        '<td><input type="text" name="fine[find_sgst_amt][]" class="gst"/></td>' +
        '<td><input type="text" name="fine[find_cgst][]" class="cgstp"/></td>' +
        '<td><input type="text" name="fine[find_cgst_amt][]" class="cgst"/></td>' +
        '<td><input type="text" name="fine[find_igst][]" class="igstp"/></td>' +
        '<td><input type="text" name="fine[find_igst_amt][]" class="igst"/></td>' +
        '<td><input type="text" name="fine[find_narration][]"/></td>' +
        '<td><button type="button" class="btnDeleteRow dlt"> <i class="fa fa-remove"></i> </button></td>' +
        '</tr>';

    $('.tblUpgradeDetails tbody tr:last').after(newRow);
    $('.dtpDMY').datetimepicker({format: "DD-MM-YYYY"});
});

$(document).on('click', '.btnDeleteRow', function () {
    $(this).closest('tr').remove();
});

$("#frmAccessories").submit(function (e) {
          e.preventDefault();
          var form = $(this);
          //var url = form.attr('action');
          var url = site_url + '<?php echo $controller?>/refurbisheReturn';
          //alert(url);
          $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(),
               dataType: "json",
               beforeSend: function () {
                    $('.divLoading').show();
                    //$(".btn-success").attr("disabled", true);
               },
               success: function (data) {
                    $('.divLoading').hide();
                    if (data.status == "success") {
                         $('.msgBox').show();
                         setTimeout(function () {
                              $('.msgBox').fadeOut();
                         }, 1500);
                    } else {
                         $('.ErrorMsgBox').show();
                    }
               }
          });
     });
     $(document).on('keyup', '.sgstp', function (e) {
          var p = parseFloat($(this).val());
          if (p > 0) {
               var amt = parseFloat($(this).closest('td').prev('td').find('input').val());
               var sgst = (amt * p) / 100;
               $(this).closest('td').next('td').find('input').val(sgst);
          } else {
               $(this).closest('td').next('td').find('input').val(0.00);
          }
     });
     $(document).on('keyup', '.cgstp', function (e) {
          var p = parseFloat($(this).val());
          if (p > 0) {
               var amt = parseFloat($(this).closest('td').prev('td').prev('td').prev('td').find('input').val());
               var cgst = (amt * p) / 100;
               $(this).closest('td').next('td').find('input').val(cgst);
          } else {
               $(this).closest('td').next('td').find('input').val(0.00);
          }
     });

     $(document).on('keyup', '.igstp', function (e) {
          var p = parseFloat($(this).val());
          if (p > 0) {
               var amt = parseFloat($(this).closest('td').prev('td').prev('td').prev('td').prev('td').prev('td').find('input').val());
               var igst = (amt * p) / 100;
               $(this).closest('td').next('td').find('input').val(igst);
          } else {
               $(this).closest('td').next('td').find('input').val(0.00);
          }
     });


     $(document).on('click', '.btnDeleteExisting', function () {// delete
    var url = site_url + '<?php echo $controller?>/delete_fine_dtls';
    var fineId = $(this).data('id'); // Get the fine ID from the data attribute
    var $rowToDelete = $(this).closest('tr'); // Store a reference to the row to delete

    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            type: 'POST',
            url: url,
            data: { fine_id: fineId },
            success: function (response) {
                var responseObject = JSON.parse(response); // Parse the JSON string
                if (responseObject.status === 'success') {
                    // Remove the deleted record from the table using the stored reference
                    $rowToDelete.remove();
                    alert('Record deleted successfully.');
                } else {
                    alert('Failed to delete the record.');
                }
            }
        });
    }
});







</script>

<style>
     .tblRefurb {width: 100%;}
     input{border:0px solid #000; margin:0; background:transparent;width: -webkit-fill-available;}
     .tblUpgradeDetails tr td{border:1px solid #000;padding: 0px 5px 0px 5px;white-space: nowrap;}
     .tblUpgradeDetails tr th{border:1px solid #000;padding: 3px;text-align: center;background:#eee;}
     .dlt {
    margin-top: 5px;
    margin-bottom: 5px;
    margin-right: 5px;
}
</style>


