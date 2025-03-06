<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>
                              Add New Customer <a href="<?php echo site_url($controller); ?>" class="btn btn-success">List</a>
                         </h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-7 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">Customer

                                   </div>
                                   <div class="panel-body">
                                        <?php
                                        echo form_open_multipart($controller . "/add", array('id' => "frmCustmer", 'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                                        ?>


                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span> </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required type="text" class="form-control col-md-7 col-xs-12" name="cusd_name" id="cusd_name" value="<?php echo isset($customerName) ? $customerName : ''; ?>" autocomplete="off" placeholder="Customer name" />
                                             </div>
                                        </div>

                                        <!-- Phone -->

                                        <div id="phoneContainer">
                                             <div class="form-group phoneField">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                                       <input required type="text" class="form-control col-md-7 col-xs-12 numOnly cus_phone" name="phone[]" data-url="<?php echo site_url('customers/is_exist'); ?>" autocomplete="off" placeholder="Customer phone" value="<?php echo $customerNumber; ?>" />
                                                       <h6 class="cust_phone_msg"></h6>
                                                  </div>
                                               
                                                  <button type="button" class="addPhone btn btn-warning" id="addPhone">+Add
                                                       <!-- Button stays here -->
                                                  </button>
                                             </div>
                                        </div>
                                        <!-- End Phone -->
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Office </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 numOnly cusd_phone_office" name="cusd_phone_office" id="cusd_phone_office" autocomplete="off" placeholder="Phone Office">
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Resi </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 numOnly cusd_phone_resi" name="cusd_phone_resi" id="cusd_phone_resi" autocomplete="off" placeholder="Phone Resi">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">WhatSApp </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 numOnly cusd_whatsapp" name="cusd_whatsapp" id="cusd_whatsapp" autocomplete="off" placeholder="WhatsApp No">
                                             </div>
                                        </div>


                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 cusd_email " name="cusd_email" id="cusd_email " placeholder="Email" />
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Fb </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 cusd_fb " name="cusd_fb" id="cusd_fb " placeholder="Facebook" />
                                             </div>
                                        </div>
                                    <!-- End new -->
                                        <div class="form-group">
                                             <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Age group</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control form-control-enq" name="cusd_age" id="cusd_age">
                                                       <?php foreach (unserialize(CUST_AGE_GROUP) as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>">
                                                                 <?php echo $value; ?>
                                                            </option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group"><?php // print_r($Profession); 
                                                                 ?>
                                             <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Profession<span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required="true" class="select2 select2_group form-control form-control-enq" name="cusd_profession">
                                                       <option value="">-Select-</option>
                                                       <?php foreach ((array) $Profession as $value) { ?>
                                                            <option value="<?php echo $value['occ_id']; ?>">
                                                                 <?php echo $value['occ_name']; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="cusd_company" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Company</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="text" class="form-control col-md-7 col-xs-12" name="cusd_company" id="cusd_company" autocomplete="off" placeholder="Company" />
                                             </div>
                                        </div>

                                        <div class="form-group">
                                                    <label for="enq_cus_gender" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Gender</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="select2_group form-control form-control-enq" name="cusd_gender">
                                                            <option value="0">- Select -</option>
                                                            <?php foreach (unserialize(GENDER) as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>">
                                                                    <?php echo $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                        <!-- End new -->
                                        <div class="form-group">
                                             <label for="cusd_gender" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Place</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="cusd_place" id="cusd_place" autocomplete="off" placeholder="Customer location" />
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="cusd_gender" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">
                                                  <Address>Address</Address>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="cusd_address" id="cusd_address" autocomplete="off" placeholder="Address" />
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="cusd_gender" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">
                                                  <Address>Office Address</Address>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="cusd_address_office" id="cusd_address_office" autocomplete="off" placeholder="Office Address" />
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="cusd_gender" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">District</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select name="cusd_district" id="cusd_district" class="form-control col-md-6 col-xs-6 cusd_district">
                                                       <option value="0">-Select-</option>
                                                       <?php foreach ($districts as $key => $value) : ?>
                                                            <option value="<?php echo $value['std_id']; ?>"><?php echo $value['std_district_name']; ?></option>
                                                       <?php endforeach; ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="cusd_gender" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Pin</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="cusd_pin" id="cusd_pin" autocomplete="off" value="0" placeholder="Pin" />
                                             </div>
                                        </div>


                                        <div class="form-group">
                                             <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                                  <button class="btn btn-primary" type="reset">Reset</button>
                                             </div>
                                        </div>
                                        <?php echo form_close() ?>
                                   </div>
                              </div>
                         </div>


                    </div>
               </div>
          </div>
     </div>
</div>




<script>
     document.addEventListener('DOMContentLoaded', function() {
          const phoneContainer = document.getElementById('phoneContainer');
          const addPhoneButton = document.getElementById('addPhone');

          // Debounce function to limit API calls
          function debounce(func, delay) {
               let timeout;
               return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
               };
          }

          // Add phone input field
          addPhoneButton.addEventListener('click', function() {
               const phoneField = document.createElement('div');
               phoneField.classList.add('form-group', 'phoneField');
               phoneField.style.marginTop = '10px'; // Add spacing between fields
               phoneField.innerHTML = `
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <input required type="text" 
                       class="form-control col-md-7 col-xs-12 numOnly cus_phone" 
                       name="phone[]" 
                       data-url="<?php echo site_url('customers/is_exist'); ?>" 
                       autocomplete="off" 
                       placeholder="Customer phone" />
                <h6 class="cust_phone_msg" style="color: red;"></h6>
            </div>
            <button type="button" class="removePhone btn btn-danger" style="margin-left: 10px;">-</button>
        `;

               // Append the new phone field below the original one
               phoneContainer.appendChild(phoneField);

               // Add validation to the new phone input
               const inputElement = phoneField.querySelector('.cus_phone');
               addValidation(inputElement);
          });

          // Validate phone input
          function addValidation(inputElement) {
               let lastValue = ''; // Store the last checked value

               inputElement.addEventListener(
                    'blur',
                    debounce(function() {
                         const phoneNumber = this.value.trim();
                         const errorMsgElement = this.closest('.form-group').querySelector('.cust_phone_msg');
                         const url = this.getAttribute('data-url');

                         // Prevent empty or duplicate API calls
                         if (phoneNumber && phoneNumber !== lastValue) {
                              lastValue = phoneNumber; // Update last checked value
                              fetch(`${url}?phone=${phoneNumber}`)
                                   .then(response => response.json())
                                   .then(data => {
                                        if (data.exists) {
                                             errorMsgElement.innerHTML = '<span style="color: red;">This phone number already exists. Please enter another.</span>';
                                             this.value = ''; // Clear input value
                                        } else {
                                             errorMsgElement.innerHTML = '<span style="color: green;">Valid phone number</span>';
                                        }
                                   })
                                   .catch(err => console.error('Error:', err));
                         }
                    }, 300) // Debounce delay of 300ms
               );
          }

          // Add validation to the initial input field
          document.querySelectorAll('.cus_phone').forEach(addValidation);

          // Remove newly added phone input fields
          phoneContainer.addEventListener('click', function(e) {
               if (e.target.classList.contains('removePhone')) {
                    e.target.closest('.phoneField').remove();
               }
          });
     });

     $('#frmCustmer').on('submit', function(e) {
          e.preventDefault(); // Prevent default form submission

          $.ajax({
               url: $(this).attr('action'), // Form action URL
               type: 'POST',
               data: $(this).serialize(), // Serialize form data
               dataType: 'json',
               success: function(response) {
                    if (response.status === 'success') {
                         alert(response.message); // Show success message
                         $('#frmCustmer')[0].reset(); // Reset form
                    } else {
                         alert(response.message); // Show error message
                    }
               },
               error: function() {
                    alert('An error occurred. Please try again.');
               }
          });
     });
</script>