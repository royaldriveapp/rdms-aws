<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Edit Customer <a href="<?php echo site_url('customers'); ?>" class="btn btn-success">List</a>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Customer <?php echo $customer['cusd_id']; ?></div>
                            <div class="panel-body">
                                <?php
                                echo form_open_multipart('customers/update/' . $customer['cusd_id'], array('id' => "frmCustomer", 'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                                ?>

                                <!-- Customer Name -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input required type="text" class="form-control col-md-7 col-xs-12" name="cusd_name" id="cusd_name" value="<?php echo isset($customer['cusd_name']) ? $customer['cusd_name'] : ''; ?>" autocomplete="off" placeholder="Customer name" />
                                    </div>
                                </div>

                                <!-- Phone Numbers -->
                                <div id="phoneContainer">
                                    <?php if (!empty($cusPhones)) : ?>
                                        <?php foreach ($cusPhones as $phone) : ?>
                                            <div class="form-group phoneField">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input required type="text" class="form-control col-md-7 col-xs-12 numOnly cus_phone" name="phone[]" data-url="<?php echo site_url('customers/is_exist_edit'); ?>" autocomplete="off" placeholder="Customer phone" value="<?php echo $phone['cup_phone']; ?>" />
                                                    <input type="hidden" name="cup_id[]" value="<?php echo $phone['cup_id']; ?>" />
                                                    <h6 class="cust_phone_msg"></h6>
                                                </div>
                                                <button type="button" class="removePhone btn btn-danger" style="margin-left: 10px;">-</button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="form-group phoneField">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input required type="text" class="form-control col-md-7 col-xs-12 numOnly cus_phone" name="phone[]" data-url="<?php echo site_url('customers/is_exist_edit'); ?>" autocomplete="off" placeholder="Customer phone" />
                                                <h6 class="cust_phone_msg"></h6>
                                            </div>
                                            <button type="button" class="removePhone btn btn-danger" style="margin-left: 10px;">-</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="addPhone btn btn-warning" id="addPhone">+Phone</button>

                                <!-- Phone Office -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Office</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 numOnly cusd_phone_office" name="cusd_phone_office" id="cusd_phone_office" autocomplete="off" placeholder="Phone Office" value="<?php echo isset($customer['cusd_phone_office']) ? $customer['cusd_phone_office'] : ''; ?>" />
                                    </div>
                                </div>

                                <!-- Phone Resi -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Resi</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 numOnly cusd_phone_resi" name="cusd_phone_resi" id="cusd_phone_resi" autocomplete="off" placeholder="Phone Resi" value="<?php echo isset($customer['cusd_phone_resi']) ? $customer['cusd_phone_resi'] : ''; ?>" />
                                    </div>
                                </div>

                                <!-- WhatsApp -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">WhatsApp</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 numOnly cusd_whatsapp" name="cusd_whatsapp" id="cusd_whatsapp" autocomplete="off" placeholder="WhatsApp No" value="<?php echo isset($customer['cusd_whatsapp']) ? $customer['cusd_whatsapp'] : ''; ?>" />
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 cusd_email" name="cusd_email" id="cusd_email" placeholder="Email" value="<?php echo isset($customer['cusd_email']) ? $customer['cusd_email'] : ''; ?>" />
                                    </div>
                                </div>

                                <!-- Facebook -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 cusd_fb" name="cusd_fb" id="cusd_fb" placeholder="Facebook" value="<?php echo isset($customer['cusd_fb']) ? $customer['cusd_fb'] : ''; ?>" />
                                    </div>
                                </div>

                                <!-- Age -->
                                <!-- <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Age</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 numOnly cusd_age" name="cusd_age" id="cusd_age" placeholder="Age" value="<?php echo isset($customer['cusd_age']) ? $customer['cusd_age'] : ''; ?>" />
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Age group</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2_group form-control form-control-enq" name="cusd_age" id="cusd_age">
                                            <?php foreach (unserialize(CUST_AGE_GROUP) as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>" <?php echo (isset($customer['cusd_age']) && $key == $customer['cusd_age']) ? 'selected' : ''; ?>>
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
                                                <option value="<?php echo $value['occ_id']; ?>" <?php echo (isset($customer['cusd_profession']) && $value['occ_id'] == $customer['cusd_profession']) ? 'selected' : ''; ?>>
                                                    <?php echo $value['occ_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cusd_company" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Company</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="cusd_company" value="<?php echo isset($customer['cusd_company']) ? $customer['cusd_company'] : ''; ?>" class="form-control form-control-enq col-md-7 col-xs-12" type="text" name="cusd_company" placeholder="Company">
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="form-group">
                                    <label for="enq_cus_gender" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Gender</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2_group form-control form-control-enq" name="cusd_gender">
                                            <option value="0">- Select -</option>
                                            <?php foreach (unserialize(GENDER) as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>" <?php echo (isset($customer['cusd_gender']) && $key == $customer['cusd_gender']) ? 'selected' : ''; ?>>
                                                    <?php echo $value; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Place -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Place</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="cusd_place" id="cusd_place" autocomplete="off" placeholder="Customer location" value="<?php echo isset($customer['cusd_place']) ? $customer['cusd_place'] : ''; ?>" />
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="cusd_address" id="cusd_address" autocomplete="off" placeholder="Address" value="<?php echo isset($customer['cusd_address']) ? $customer['cusd_address'] : ''; ?>" />
                                    </div>
                                </div>

                                <!-- Office Address -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Office Address</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="cusd_address_office" id="cusd_address_office" autocomplete="off" placeholder="Office Address" value="<?php echo isset($customer['cusd_address_office']) ? $customer['cusd_address_office'] : ''; ?>" />
                                    </div>
                                </div>
                                <!-- District -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control cusd_district" name="cusd_district">
                                            <option value="0">- Select -</option>
                                            <?php foreach ($districts as $district) : ?>
                                                <option value="<?php echo $district['std_id']; ?>" <?php echo ($customer['cusd_district'] == $district['std_id']) ? 'selected' : ''; ?>>
                                                    <?php echo $district['std_district_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Pin -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pin</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="cusd_pin" id="cusd_pin" autocomplete="off" placeholder="Pin" value="<?php echo isset($customer['cusd_pin']) ? $customer['cusd_pin'] : 0; ?>" />
                                    </div>
                                </div>

                                <!-- Submit and Reset Buttons -->
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success btnSubmitRegister">Update</button>
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
        const form = document.getElementById('frmCustomer');

        // Debounce function to limit API calls
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Validate phone input
        function addValidation(inputElement) {
            let lastValue = ''; // Store the last checked value

            inputElement.addEventListener(
                'blur',
                debounce(function() {
                    const phoneNumber = this.value.trim();
                    const errorMsgElement = this.closest('.form-group').querySelector('.cust_phone_msg');
                    const url = this.getAttribute('data-url');
                    const cusdId = '<?php echo $customer["cusd_id"]; ?>'; // Get the current customer ID

                    // Prevent empty or duplicate API calls
                    if (phoneNumber && phoneNumber !== lastValue) {
                        lastValue = phoneNumber; // Update last checked value
                        fetch(`${url}?phone=${phoneNumber}&cusd_id=${cusdId}`) // Pass cusd_id to the server
                            .then(response => response.json())
                            .then(data => {
                                if (data.exists) {
                                    errorMsgElement.innerHTML = '<span style="color: red;">This phone number already exists for another customer. Please enter another.</span>';
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

        // Add phone input field
        addPhoneButton.addEventListener('click', function() {
            const phoneField = document.createElement('div');
            phoneField.classList.add('form-group', 'phoneField');
            phoneField.style.marginTop = '10px';
            phoneField.innerHTML = `
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input required type="text" class="form-control col-md-7 col-xs-12 numOnly cus_phone" name="phone[]" data-url="<?php echo site_url('customers/is_exist_edit'); ?>" autocomplete="off" placeholder="Customer phone" />
                <h6 class="cust_phone_msg" style="color: red;"></h6>
            </div>
            <button type="button" class="removePhone btn btn-danger" style="margin-left: 10px;">-</button>
        `;
            phoneContainer.appendChild(phoneField);

            // Add validation to the new phone input
            const inputElement = phoneField.querySelector('.cus_phone');
            addValidation(inputElement);
        });

        // Add validation to existing phone input fields
        document.querySelectorAll('.cus_phone').forEach(addValidation);

        // Remove phone input field
        phoneContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('removePhone')) {
                const phoneField = e.target.closest('.phoneField');
                const cupId = phoneField.querySelector('input[name="cup_id[]"]')?.value;

                if (cupId) {
                    // Show confirmation popup
                    if (confirm('Are you sure you want to delete this phone number?')) {
                        // AJAX request to delete phone number
                        const formData = new FormData();
                        formData.append('cup_id', cupId);

                        fetch('<?php echo site_url("customers/delete_phone"); ?>', {
                                method: 'POST',
                                body: formData,
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    phoneField.remove(); // Remove the phone field from the DOM
                                    alert('Phone number deleted successfully.');
                                } else {
                                    alert('Failed to delete phone number.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred. Please try again.');
                            });
                    }
                } else {
                    // Remove the phone field if it's not yet saved in the database
                    phoneField.remove();
                }
            }
        });

        // AJAX form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form); // Create FormData object from the frm

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Customer updated successfully.');
                        window.location.href = '<?php echo site_url("customers"); ?>'; // rdrct to customer list
                    } else {
                        alert('Failed to update customer: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });
</script>