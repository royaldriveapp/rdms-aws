<!-- footer content -->
<footer>
     <div class="pull-right">
          <span style="color: #fff;"><?php echo 'grp: ' . $this->usr_grp . ' shrm: ' . $this->shrm . ' usr: ' . $this->uid . ' desi ' . $this->desi . ' div ' . $this->div; ?></span> Royal portal 1.1
     </div>
     <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- Autocomplete -->
<script type="text/javascript" src="../vendors/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
<!-- General -->
<script src="js/mainjs.script.min.js"></script>

<!-- redactor editor -->
<link rel="stylesheet" href="../vendors/redactor/css/redactor.css">
<!--<script src="../vendors/redactor/js/ga.js" async="" type="text/javascript"></script>-->
<!--<script src="../vendors/redactor/js/combined.js"></script>-->
<script src="../vendors/redactor/js/redactor.js"></script>
<!--<script src="../vendors/redactor/js/table.js"></script>-->
<!--<script src="../vendors/redactor/js/video.js"></script>-->
<!-- redactor editor -->

<!-- Sumo select -->
<script src="../vendors/sumoselect/js/jquery.sumoselect.js"></script>
<link href="../vendors/sumoselect/css/sumoselect.min.css" rel="stylesheet" />
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="../vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="../vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="../vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="../vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="../vendors/Flot/jquery.flot.js"></script>
<script src="../vendors/Flot/jquery.flot.pie.js"></script>
<script src="../vendors/Flot/jquery.flot.time.js"></script>
<script src="../vendors/Flot/jquery.flot.stack.js"></script>
<script src="../vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="../vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="../vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="../vendors/moment/min/moment.min.js"></script>
<script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts -->
<script src="../assets/js/custom.min.js"></script>
<script src="../vendors/switchery/dist/switchery.min.js"></script>
<?php if ($controller == 'enquiry' || $controller == 'enquiry_new') { ?>
     <!-- jQuery Smart Wizard -->
     <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<?php } ?>
<!-- bootstrap-datetimepicker -->
<link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<!-- bootstrap-datetimepicker -->
<script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- Jquery form validation -->
<script src="js/jquery.validate.js"></script>
<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<!--  -->
<script type="text/javascript" src="../vendors/bootstrap-multiselect/js/prettify.min.js"></script>
<link type="text/css" rel="stylesheet" href="../vendors/bootstrap-multiselect/css/bootstrap-multiselect.css">
<script type="text/javascript" src="../vendors/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<!-- Input mask -->
<script src="js/jquery.mask.js"></script>

<!-- crop -->
<link href="../vendors/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
<script src="../vendors/jcrop/js/jquery.Jcrop.min.js"></script>
<script src="../vendors/jcrop/js/script1.js"></script>
<!-- crop -->

<!-- Number format -->
<script src="js/jquery.number.min.js"></script>

<!-- Malayalam translate -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
     $(document).ready(function() {
          //('.redactor-editor').addClass("trans");
     });
</script>
<script type="text/javascript">
     /*google.load("elements", "1", {
      packages: "transliteration"
      });
      
      function onLoad() {
      $('textarea.ml').prev('div').addClass('mlt');
      var options = {
      sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
      destinationLanguage: [google.elements.transliteration.LanguageCode.MALAYALAM],
      shortcutKey: 'ctrl+g',
      transliterationEnabled: true
      };
      var control = new google.elements.transliteration.TransliterationControl(options);
      var elements = document.getElementsByClassName('mlt');
      control.makeTransliteratable(elements);
      }
      google.setOnLoadCallback(onLoad);*/
</script>

<?php if ($controller == 'evaluation' || $controller == 'ev' || $controller == 'evaluation_new' || $controller == 'evaluation_mrg') { ?>
     <script type="text/javascript" src="../vendors/jwizard/js/jquery.smartWizard.min.js"></script>
     <script type="text/javascript">
          $(document).ready(function() {
               // Toolbar extra buttons
               var btnFinish = $('<button id="finish-btn" style="display:none;"></button>').text('Finish').addClass('btn btn-info').on('click', function(e) {
                    e.preventDefault();
                    var formData = new FormData($('.frmNewValuation')[0]);
                    var url = $('.frmNewValuation').data('url');
                    $.ajax({
                         url: url,
                         type: 'POST',
                         data: formData,
                         async: false,
                         beforeSend: function(xhr) {
                              //$('.divLoading').show();
                              //$('#finish-btn').prop('disabled', true);
                         },
                         success: function(data) {
                              if (data.status === 'error') {
            // Parse the HTML response to extract error messages
            var errorMessage = $(data.message).text();

            // Display error message in an alert
            alert(errorMessage);
        } else{
                              alert('Success');
                              location.href = site_url + "evaluation/";
        }
                         
                         },
                         cache: false,
                         contentType: false,
                         processData: false
                    });
               });
               var btnCancel = $('<button></button>').text('Cancel').addClass('btn btn-danger').on('click', function() {
                    $('#wizEvaluation').smartWizard("reset");
               });

               // Smart Wizard
               $('#wizEvaluation').smartWizard({
                    selected: 0,
                    theme: 'default',
                    transitionEffect: 'fade',
                    showStepURLhash: true,
                    toolbarSettings: {
                         toolbarPosition: 'bottom',
                         toolbarButtonPosition: 'right',
                         toolbarExtraButtons: [btnFinish, btnCancel]
                    }
               }).on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                    $("#finish-btn").show()
                    /*if (stepPosition === 'first') {
                         $("#prev-btn").addClass('disabled');
                         $("#finish-btn").show();
                    } else if (stepPosition === 'final') {
                         $("#next-btn").hide();
                         $("#finish-btn").show();
                    } else {
                         $("#finish-btn").show();
                         $("#next-btn").show();
                         $("#prev-btn").removeClass('disabled');
                    }*/
               }).on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
                    if (nextStepIndex == 'forward') {
                         if (formValidation(currentStepIndex)) {
                              return true;
                         } else {
                              $('#wizEvaluation').smartWizard("goToStep", currentStepIndex);
                              return false;
                         }
                    }
               });
          });

          function formValidation(index) {
               var error = {};
               var erStepOne = {};
               var error = 0;
               var inputs = '.step-' + (index + 1) + " input, select";
               $(inputs).each(function() {
                    $(this).css('border', '1px solid #ccc');
                    var ctrlName = $(this).attr('name');
                    if ($(this).is(':visible')) {
                         if ($(this).attr('required')) {
                              if ($(this).val() === '') {
                                   $(this).css('border', '1px solid red');
                                   if ($(this).hasClass('cmbSearchList')) {
                                        $(this).next('.CaptionCont').css('border', '1px solid red');
                                   }
                                   error++;
                              } else {
                                   $(this).css('border', '1px solid #ccc');
                                   if ($(this).hasClass('cmbSearchList')) {
                                        $(this).next('.CaptionCont').css('border', '1px solid #ccc');
                                   }
                              }
                         }

                         if ($(this).attr('gtrzro')) {
                              if ($(this).val() === '0' || $(this).val() === 0 || $(this).val() === '') {
                                   error++;
                                   $(this).css('border', '1px solid red');
                                   return false;
                              } else {
                                   $(this).css('border', '1px solid #ccc');
                              }
                         }
                         //Model Year should be < manf year
                         var val_model_year = $('.val_model_year').val().trim();
                         var val_minif_year = $('.val_minif_year').val().trim();

                         if (val_minif_year > val_model_year) {
                              var obj = jQuery.parseJSON('{ "msg": "Model year should be less than manufacture year" }');
                              messageBox(obj);
                              error++;
                         }
                    }
               });
               if (error <= 0) {
                    return true;
               } else {
                    return false;
               }
          }
     </script>
<?php
} ?>