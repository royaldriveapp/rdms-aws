<div><?php echo $view;?></div>
<?php if (check_permission('mou', 'approval')) { ?>
     <div style="background: #ece8e8;float: left;width: 98%;margin-top: 20px;padding: 30px 6px 30px 6px;" class="hide-print">
          <div class="form-group">
               <label for="enq_cus_test_drive" style="font-size: 18px;" class="control-label col-md-8 col-sm-6 col-xs-12 lblVerify">
                    <?php if (isset($datas['master']) && empty($datas['master']['moum_approved_on'])) {?>
                         <input class="chkVerify" type="checkbox" name="chkStatus" value="1"/> I hereby accept and confirm all the terms and conditions of MOU executing digitally with M/s. RoyalDrive Pre Owned Cars LLP for selling my vehicle No. <?php echo $datas['master']['moum_reg_num']; ?>.
                         <button data-url="<?php echo site_url('mou/approval/' . $id)?>"  class="btnVerify" disabled type="submit" style="padding: 5px;">Verify</button>
                    <?php } else {?>
                         You already verified MOU, if you have query please contact concerned person.
                    <?php }?>
               </label>
          </div>
     </div>
<?php } ?>
<style>
     .hide-print { position: absolute;}
     @media print { .hide-print { display:none; }}
</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
     $(document).ready(function () {
          $(document).on('change', '.chkVerify', function (e) {
               if ($(this).prop("checked")) {
                    $('.btnVerify').prop("disabled", false);
               } else {
                    $('.btnVerify').prop("disabled", true);
               }
          });

          $(document).on('click', '.btnVerify', function () {
               var url = $(this).data('url');
               $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    success: function (resp) {
                         $('.lblVerify').html('MOU verification successfully completed, if you have query please contact concerned person.');
                    }
               });
          });
     });
</script>