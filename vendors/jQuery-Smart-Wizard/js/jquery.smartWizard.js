/*
 * SmartWizard 3.3.1 plugin
 * jQuery Wizard control Plugin
 * by Dipu
 *
 * Refactored and extended:
 * https://github.com/mstratman/jQuery-Smart-Wizard
 *
 * Original URLs:
 * http://www.techlaboratory.net
 * http://tech-laboratory.blogspot.com
 */

function SmartWizard(target, options) {
     this.target = target;
     this.options = options;
     this.curStepIdx = options.selected;
     this.steps = $(target).children("ul").children("li").children("a"); // Get all anchors
     this.contentWidth = 0;
     this.msgBox = $('<div class="msgBox"><div class="content"></div><a href="#" class="close">X</a></div>');
     this.elmStepContainer = $('<div></div>').addClass("stepContainer");
     this.loader = $('<div>Loading</div>').addClass("loader");
     this.buttons = {
          next: $('<a>' + options.labelNext + '</a>').attr("href", "#").addClass("buttonNext"),
          previous: $('<a>' + options.labelPrevious + '</a>').attr("href", "#").addClass("buttonPrevious"),
          finish: $('<a class="btnFinish">' + options.labelFinish + '</a>').attr("href", "#").addClass("buttonFinish")
     };

     /*
      * Private functions
      */

     var _init = function ($this) {
          var elmActionBar = $('<div></div>').addClass("actionBar");
          elmActionBar.append($this.msgBox);
          $('.close', $this.msgBox).click(function () {
               $this.msgBox.fadeOut("normal");
               return false;
          });

          var allDivs = $this.target.children('div');
          $this.target.children('ul').addClass("anchor");
          allDivs.addClass("content");

          // highlight steps with errors
          if ($this.options.errorSteps && $this.options.errorSteps.length > 0) {
               $.each($this.options.errorSteps, function (i, n) {
                    $this.setError({
                         stepnum: n,
                         iserror: true
                    });
               });
          }

          $this.elmStepContainer.append(allDivs);
          elmActionBar.append($this.loader);
          $this.target.append($this.elmStepContainer);
          elmActionBar.append($this.buttons.previous)
                  .append($this.buttons.next)
                  .append($this.buttons.finish);
          $this.target.append(elmActionBar);
          this.contentWidth = $this.elmStepContainer.width();

          $($this.buttons.next).click(function () {
               if ($this.validation()) {
                    $("html, body").animate({
                         scrollTop: 0
                    }, "slow");
                    $this.goForward();
               }
               return false;
          });
          $($this.buttons.previous).click(function () {
               $("html, body").animate({
                    scrollTop: 0
               }, "slow");
               $this.goBackward();
               return false;
          });
          $($this.buttons.finish).click(function () {
               if ($this.validation()) {
                    $('.btnFinish').html('Please wait...');
                    if (!$(this).hasClass('buttonDisabled')) {
                         if ($.isFunction($this.options.onFinish)) {
                              var context = {
                                   fromStep: $this.curStepIdx + 1
                              };
                              if (!$this.options.onFinish.call(this, $($this.steps), context)) {
                                   return false;
                              }
                              $('.btnFinish').html($this.options.labelFinish);
                         } else {
                              var frm = $this.target.parents('form');
                              if (frm && frm.length) {
                                   $(this).addClass('buttonDisabled');
                                   $('.btnFinish').html('Please wait...');
                                   frm.submit();
                              }
                         }
                    }
               }
               return false;
          });

          $($this.steps).bind("click", function (e) {
               if ($this.steps.index(this) == $this.curStepIdx) {
                    return false;
               }
               var nextStepIdx = $this.steps.index(this);
               var isDone = $this.steps.eq(nextStepIdx).attr("isDone") - 0;
               if (isDone == 1) {
                    _loadContent($this, nextStepIdx);
               }
               return false;
          });

          // Enable keyboard navigation
          if ($this.options.keyNavigation) {
               $(document).keyup(function (e) {
                    if (e.which == 39) { // Right Arrow
                         if ($this.validation()) {
                              $this.goForward();
                         }
                    } else if (e.which == 37) { // Left Arrow
                         if ($this.validation()) {
                              $this.goBackward();
                         }
                    }
               });
          }
          //  Prepare the steps
          _prepareSteps($this);
          // Show the first slected step
          _loadContent($this, $this.curStepIdx);
     };

     var _prepareSteps = function ($this) {
          if (!$this.options.enableAllSteps) {
               $($this.steps, $this.target).removeClass("selected").removeClass("done").addClass("disabled");
               $($this.steps, $this.target).attr("isDone", 0);
          } else {
               $($this.steps, $this.target).removeClass("selected").removeClass("disabled").addClass("done");
               $($this.steps, $this.target).attr("isDone", 1);
          }

          $($this.steps, $this.target).each(function (i) {
               $($(this).attr("href").replace(/^.+#/, '#'), $this.target).hide();
               $(this).attr("rel", i + 1);
          });
     };

     var _step = function ($this, selStep) {
          return $(
                  $(selStep, $this.target).attr("href").replace(/^.+#/, '#'),
                  $this.target
                  );
     };

     var _loadContent = function ($this, stepIdx) {
          var selStep = $this.steps.eq(stepIdx);
          var ajaxurl = $this.options.contentURL;
          var ajaxurl_data = $this.options.contentURLData;
          var hasContent = selStep.data('hasContent');
          var stepNum = stepIdx + 1;
          if (ajaxurl && ajaxurl.length > 0) {
               if ($this.options.contentCache && hasContent) {
                    _showStep($this, stepIdx);
               } else {
                    var ajax_args = {
                         url: ajaxurl,
                         type: "POST",
                         data: ({
                              step_number: stepNum
                         }),
                         dataType: "text",
                         beforeSend: function () {
                              $this.loader.show();
                         },
                         error: function () {
                              $this.loader.hide();
                         },
                         success: function (res) {
                              $this.loader.hide();
                              if (res && res.length > 0) {
                                   selStep.data('hasContent', true);
                                   _step($this, selStep).html(res);
                                   _showStep($this, stepIdx);
                              }
                         }
                    };
                    if (ajaxurl_data) {
                         ajax_args = $.extend(ajax_args, ajaxurl_data(stepNum));
                    }
                    $.ajax(ajax_args);
               }
          } else {
               _showStep($this, stepIdx);
          }
     };

     var _showStep = function ($this, stepIdx) {
          var selStep = $this.steps.eq(stepIdx);
          var curStep = $this.steps.eq($this.curStepIdx);
          if (stepIdx != $this.curStepIdx) {
               if ($.isFunction($this.options.onLeaveStep)) {
                    var context = {
                         fromStep: $this.curStepIdx + 1,
                         toStep: stepIdx + 1
                    };
                    if (!$this.options.onLeaveStep.call($this, $(curStep), context)) {
                         return false;
                    }
               }
          }
          //$this.elmStepContainer.height(_step($this, selStep).outerHeight());
          var prevCurStepIdx = $this.curStepIdx;
          $this.curStepIdx = stepIdx;
          if ($this.options.transitionEffect == 'slide') {
               _step($this, curStep).slideUp("fast", function (e) {
                    _step($this, selStep).slideDown("fast");
                    _setupStep($this, curStep, selStep);
               });
          } else if ($this.options.transitionEffect == 'fade') {
               _step($this, curStep).fadeOut("fast", function (e) {
                    _step($this, selStep).fadeIn("fast");
                    _setupStep($this, curStep, selStep);
               });
          } else if ($this.options.transitionEffect == 'slideleft') {
               var nextElmLeft = 0;
               var nextElmLeft1 = null;
               var nextElmLeft = null;
               var curElementLeft = 0;
               if (stepIdx > prevCurStepIdx) {
                    nextElmLeft1 = $this.contentWidth + 10;
                    nextElmLeft2 = 0;
                    curElementLeft = 0 - _step($this, curStep).outerWidth();
               } else {
                    nextElmLeft1 = 0 - _step($this, selStep).outerWidth() + 20;
                    nextElmLeft2 = 0;
                    curElementLeft = 10 + _step($this, curStep).outerWidth();
               }
               if (stepIdx == prevCurStepIdx) {
                    nextElmLeft1 = $($(selStep, $this.target).attr("href"), $this.target).outerWidth() + 20;
                    nextElmLeft2 = 0;
                    curElementLeft = 0 - $($(curStep, $this.target).attr("href"), $this.target).outerWidth();
               } else {
                    $($(curStep, $this.target).attr("href"), $this.target).animate({
                         left: curElementLeft
                    }, "fast", function (e) {
                         $($(curStep, $this.target).attr("href"), $this.target).hide();
                    });
               }

               _step($this, selStep).css("left", nextElmLeft1).show().animate({
                    left: nextElmLeft2
               }, "fast", function (e) {
                    _setupStep($this, curStep, selStep);
               });
          } else {
               _step($this, curStep).hide();
               _step($this, selStep).show();
               _setupStep($this, curStep, selStep);
          }
          return true;
     };

     var _setupStep = function ($this, curStep, selStep) {
          $(curStep, $this.target).removeClass("selected");
          $(curStep, $this.target).addClass("done");

          $(selStep, $this.target).removeClass("disabled");
          $(selStep, $this.target).removeClass("done");
          $(selStep, $this.target).addClass("selected");

          $(selStep, $this.target).attr("isDone", 1);

          _adjustButton($this);

          if ($.isFunction($this.options.onShowStep)) {
               var context = {
                    fromStep: parseInt($(curStep).attr('rel')),
                    toStep: parseInt($(selStep).attr('rel'))
               };
               if (!$this.options.onShowStep.call(this, $(selStep), context)) {
                    return false;
               }
          }
          if ($this.options.noForwardJumping) {
               // +2 == +1 (for index to step num) +1 (for next step)
               for (var i = $this.curStepIdx + 2; i <= $this.steps.length; i++) {
                    $this.disableStep(i);
               }
          }
     };

     var _adjustButton = function ($this) {
          if (!$this.options.cycleSteps) {
               if (0 >= $this.curStepIdx) {
                    $($this.buttons.previous).addClass("buttonDisabled");
                    if ($this.options.hideButtonsOnDisabled) {
                         $($this.buttons.previous).hide();
                    }
               } else {
                    $($this.buttons.previous).removeClass("buttonDisabled");
                    if ($this.options.hideButtonsOnDisabled) {
                         $($this.buttons.previous).show();
                    }
               }
               if (($this.steps.length - 1) <= $this.curStepIdx) {
                    $($this.buttons.next).addClass("buttonDisabled");
                    if ($this.options.hideButtonsOnDisabled) {
                         $($this.buttons.next).hide();
                    }
               } else {
                    $($this.buttons.next).removeClass("buttonDisabled");
                    if ($this.options.hideButtonsOnDisabled) {
                         $($this.buttons.next).show();
                    }
               }
          }
          // Finish Button
          if (!$this.steps.hasClass('disabled') || $this.options.enableFinishButton) {
               $($this.buttons.finish).removeClass("buttonDisabled");
               if ($this.options.hideButtonsOnDisabled) {
                    $($this.buttons.finish).show();
               }
          } else {
               $($this.buttons.finish).addClass("buttonDisabled");
               if ($this.options.hideButtonsOnDisabled) {
                    $($this.buttons.finish).hide();
               }
          }
     };

     /*
      * Public methods
      */

     SmartWizard.prototype.validation = function () {
          $('.lblError').remove();
          var error = {};
          if (this.curStepIdx == 0) { // Basic info
               var erStepOne = {};
               var error = 0;
               /*Check phone number exists on register*/
               /*var phoneno = $('.enq_cus_mobile').val();
                if (phoneno.length >= 10) {
                var url = $('.enq_cus_mobile').data('url');
                $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data: {'phoneNo': phoneno},
                success: function (resp) {
                $('.er_enq_cus_mobile').remove();
                erStepOne[enq_cus_mobile] = 1;
                if (resp.status === 'success') {
                $('.enq_cus_mobile').css('border', '1px solid red');
                $('.enq_cus_mobile').after('<label class="er_enq_cus_mobile lblError">' + resp.msg + '</label>');
                erStepOne[enq_cus_mobile] = 1;
                } else {
                $('.enq_cus_mobile').css('border', '1px solid #ccc');
                $('.er_enq_cus_mobile').remove();
                erStepOne[enq_cus_mobile] = 0;
                }
                }
                });
                }*/
               /*End check phone number exists on register*/
               if ($('.enq_se_id').length) {
                    if ($('.enq_se_id').val() == '') {
                         $('.SelectBox').css('border', '1px solid red');
                         $('.enq_se_id').after('<label class="er_enq_se_id lblError">Please select sales executive</label>');
                         erStepOne['enq_se_id'] = 1;
                    } else {
                         erStepOne['enq_se_id'] = 0;
                         $('.er_enq_se_id').remove();
                         $('.SelectBox').css('border', '1px solid #ccc');
                    }
               }

               $("#step-1 select, input").each(function () {
                    var ctrlName = $(this).attr('name');
                    if ($(this).is(':visible')) {
                         if ($(this).attr('required')) {
                              if ($(this).val() === '') {
                                   $(this).css('border', '1px solid red');
                                   $('.stepTwoError').html('');
                                   $('#step-1').prepend('<label class="stepTwoError lblError">Please fill mandatory fields!</label>');
                                   erStepOne[ctrlName] = 1;
                              } else {
                                   $(this).css('border', '1px solid #ccc');
                                   $('.stepTwoError').html('');
                                   erStepOne[ctrlName] = 0;
                              }
                         }
                         
                         if ($(this).attr('gtrzro')) {
                              if ($(this).val() === '0' || $(this).val() === 0 || $(this).val() === '') {
                                   $(this).css('border', '1px solid red');
                                   $('.stepTwoError').html('');
                                   erStepOne[ctrlName] = 1;
                              } else {
                                   $(this).css('border', '1px solid #ccc');
                                   $('.stepTwoError').html('');
                                   erStepOne[ctrlName] = 0;
                              }
                         }
                    }
               });
               $.each(erStepOne, function (index, val) {
                    error = error + erStepOne[index];
               });
               if (error > 0) {
                    return false;
               } else {
                    return true;
               }
          } /*else if (this.curStepIdx == 1) { // Questions
               var erStepOne = {};
               var error = 0;
               $('.step2 input,textarea,select').filter('[required]:visible').each(function () {
                    var ctrlName = $(this).attr('name');
                    if ($(this).attr('type') == 'checkbox') {
                         if ($(this).prop("checked") == true) {
                              $(this).css('border', '1px solid #ccc');
                              $('.stepTwoError').html('');
                              erStepOne[ctrlName] = 0;
                         } else {
                              $(this).after('<br><label class="lblError">Please fill this fields!</label>');
                              $('.stepTwoError').html('');
                              $('#step-2').prepend('<label class="stepTwoError lblError">Please fill mandatory fields!</label>');
                              erStepOne[ctrlName] = 1;
                         }
                    } else if ($(this).attr('type') == 'text') {
                         if ($(this).val().trim() === '') {
                              $(this).css('border', '1px solid red');
                              $('.stepTwoError').html('');
                              $('#step-2').prepend('<label class="stepTwoError lblError">Please fill mandatory fields!</label>');
                              erStepOne[ctrlName] = 1;
                         } else {
                              $(this).css('border', '1px solid #ccc');
                              $('.stepTwoError').html('');
                              erStepOne[ctrlName] = 0;
                         }
                    }
               });
               $.each(erStepOne, function (index, val) {
                    error = error + erStepOne[index];
               });
               if (error > 0) {
                    return false;
               } else {
                    return true;
               }
          }*/
           else if (this.curStepIdx == 1) { // Vehicle details.
               var erStepOne = {};
               var error = 0;
               $('.step3 input,textarea,select').filter('[required]:visible').each(function () {
                    var ctrlName = $(this).attr('name');
                    if ($(this).attr('required')) {
                         if ($(this).val() === '0') {
                              $(this).css('border', '1px solid red');
                              $('.stepTwoError').html('');
                              $('#step-3').prepend('<label class="stepTwoError lblError">Please fill mandatory fields!</label>');
                              erStepOne[ctrlName] = 1;
                         } else {
                              $(this).css('border', '1px solid #ccc');
                              $('.stepTwoError').html('');
                              erStepOne[ctrlName] = 0;
                         }
                    }
               });
               $.each(erStepOne, function (index, val) {
                    error = error + erStepOne[index];
               });
               if (error > 0) {
                    return false;
               } else {
                    return true;
               }
          } else if (this.curStepIdx == 2) { // Vehicle details
               var erStepOne = {};
               var error = 0;
               $("#step-4 input, select").each(function () {
                    if ($(this).is(':visible')) {
                         if ($(this).attr('required')) {
                              var ctrlId = $(this).attr('id');
                              if ($(this).val() == '') {
                                   $(this).css('border', '1px solid red');
                                   $('.stepFourError').html('');
                                   $('#step-4').prepend('<label class="stepFourError lblError">Please fill mandatory fields!</label>');
                                   erStepOne[ctrlId] = 1;
                              } else {
                                   $(this).css('border', '1px solid #ccc');
                                   $('.stepFourError').html('');
                                   erStepOne[ctrlId] = 0;
                              }
                         }
                    }
               });
               $.each(erStepOne, function (index, val) {
                    error = error + erStepOne[index];
               });
               if (error > 0) {
                    return false;
               } else {
                    return true;
               }
          } else if (this.curStepIdx == 3) { // Followup
               var erStepOne = {};
               var error = 0;
               $("#step-5 input, select").each(function () {
                    if ($(this).is(':visible')) {
                         if ($(this).attr('required')) {
                              var ctrlId = $(this).attr('id');
                              if ($(this).val() == '') {
                                   $(this).css('border', '1px solid red');
                                   $('.stepFourError').html('');
                                   $('#step-5').prepend('<label class="stepFourError lblError">Please fill mandatory fields!</label>');
                                   erStepOne[ctrlId] = 1;
                              } else {
                                   $(this).css('border', '1px solid #ccc');
                                   $('.stepFourError').html('');
                                   erStepOne[ctrlId] = 0;
                              }
                         }
                    }
               });
               $.each(erStepOne, function (index, val) {
                    error = error + erStepOne[index];
               });
               if (error > 0) {
                    return false;
               } else {
                    return true;
               }
          } else {
               return true;
          }
     };
     SmartWizard.prototype.goForward = function () {
          var nextStepIdx = this.curStepIdx + 1;
          if (this.steps.length <= nextStepIdx) {
               if (!this.options.cycleSteps) {
                    return false;
               }
               nextStepIdx = 0;
          }
          _loadContent(this, nextStepIdx);
     };

     SmartWizard.prototype.goBackward = function () {
          var nextStepIdx = this.curStepIdx - 1;
          if (0 > nextStepIdx) {
               if (!this.options.cycleSteps) {
                    return false;
               }
               nextStepIdx = this.steps.length - 1;
          }
          _loadContent(this, nextStepIdx);
     };

     SmartWizard.prototype.goToStep = function (stepNum) {
          var stepIdx = stepNum - 1;
          if (stepIdx >= 0 && stepIdx < this.steps.length) {
               _loadContent(this, stepIdx);
          }
     };
     SmartWizard.prototype.enableStep = function (stepNum) {
          var stepIdx = stepNum - 1;
          if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
               return false;
          }
          var step = this.steps.eq(stepIdx);
          $(step, this.target).attr("isDone", 1);
          $(step, this.target).removeClass("disabled").removeClass("selected").addClass("done");
     }
     SmartWizard.prototype.disableStep = function (stepNum) {
          var stepIdx = stepNum - 1;
          if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
               return false;
          }
          var step = this.steps.eq(stepIdx);
          $(step, this.target).attr("isDone", 0);
          $(step, this.target).removeClass("done").removeClass("selected").addClass("disabled");
     }
     SmartWizard.prototype.currentStep = function () {
          return this.curStepIdx + 1;
     }

     SmartWizard.prototype.showMessage = function (msg) {
          $('.content', this.msgBox).html(msg);
          this.msgBox.show();
     }
     SmartWizard.prototype.hideMessage = function () {
          this.msgBox.fadeOut("normal");
     }
     SmartWizard.prototype.showError = function (stepnum) {
          this.setError(stepnum, true);
     }
     SmartWizard.prototype.hideError = function (stepnum) {
          this.setError(stepnum, false);
     }
     SmartWizard.prototype.setError = function (stepnum, iserror) {
          if (typeof stepnum == "object") {
               iserror = stepnum.iserror;
               stepnum = stepnum.stepnum;
          }

          if (iserror) {
               $(this.steps.eq(stepnum - 1), this.target).addClass('error')
          } else {
               $(this.steps.eq(stepnum - 1), this.target).removeClass("error");
          }
     }

     SmartWizard.prototype.fixHeight = function () {
          var height = 0;

          var selStep = this.steps.eq(this.curStepIdx);
          var stepContainer = _step(this, selStep);
          stepContainer.children().each(function () {
               height += $(this).outerHeight();
          });

          // These values (5 and 20) are experimentally chosen.
          stepContainer.height(height + 5);
          this.elmStepContainer.height(height + 20);
     }

     _init(this);
}
;



(function ($) {

     $.fn.smartWizard = function (method) {
          var args = arguments;
          var rv = undefined;
          var allObjs = this.each(function () {
               var wiz = $(this).data('smartWizard');
               if (typeof method == 'object' || !method || !wiz) {
                    var options = $.extend({}, $.fn.smartWizard.defaults, method || {});
                    if (!wiz) {
                         wiz = new SmartWizard($(this), options);
                         $(this).data('smartWizard', wiz);
                    }
               } else {
                    if (typeof SmartWizard.prototype[method] == "function") {
                         rv = SmartWizard.prototype[method].apply(wiz, Array.prototype.slice.call(args, 1));
                         return rv;
                    } else {
                         $.error('Method ' + method + ' does not exist on jQuery.smartWizard');
                    }
               }
          });
          if (rv === undefined) {
               return allObjs;
          } else {
               return rv;
          }
     };

     // Default Properties and Events
     $.fn.smartWizard.defaults = {
          selected: 0, // Selected Step, 0 = first step
          keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
          enableAllSteps: false,
          transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
          contentURL: null, // content url, Enables Ajax content loading
          contentCache: true, // cache step contents, if false content is fetched always from ajax url
          cycleSteps: false, // cycle step navigation
          enableFinishButton: false, // make finish button enabled always
          hideButtonsOnDisabled: true, // when the previous/next/finish buttons are disabled, hide them instead?
          errorSteps: [], // Array Steps with errors
          labelNext: 'Next',
          labelPrevious: 'Previous',
          labelFinish: 'Finish',
          noForwardJumping: false,
          onLeaveStep: null, // triggers when leaving a step
          onShowStep: function (res, steps) { // triggers when showing a step
               var currentStep = steps.toStep;
               var totalSteps = $('[id^="step-"]').length;
               if (currentStep) {
                    if (currentStep === totalSteps) {
                         $('.btnFinish').show();
                    } else {
                         $('.btnFinish').hide();
                    }
               }
          }, // triggers when showing a step
          onFinish: function () {
               var isOnLine = navigator.onLine;
               if (isOnLine) {
                    if (SmartWizard.prototype.validation()) {
                         var url = $('#wizard').attr('data-url');
                         $('.btnFinish').prop("disabled", true);
                         $.ajax({
                              dataType: "json",
                              url: url,
                              data: $('#wizard').serialize(),
                              beforeSend: function (xhr) {
                                   $('.divLoading').show();
                              },
                              success: function (resp) {
                                   if (resp.status === 'success') {
                                        location.href = site_url + 'enquiry';
                                   } else {
                                        messageBox(resp);
                                   }
                              },
                              type: 'POST'
                         });
                    }
               } else {
                    alert('No internet! please try again');
               }
          }
     };
})(jQuery);