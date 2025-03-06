<?php

defined('BASEPATH') or exit('No direct script access allowed');

class customers extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'Vehcle customers';
    
    
          $this->load->model('customers_model', 'customers');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('registration/registration_model', 'registration');
     }

     public function index()
     { 
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }
     public function list_ajax()
     { 
          $response = $this->customers->getCustomersPaginate($this->input->post());
          echo json_encode($response);
     }

     public function create()
     {
        $data['districts'] = $this->registration->getDistricts();
          $this->render_page(strtolower(__CLASS__) . '/create', $data);
     }
  
     public function storeCustomer()
{//from registration popup
 
    $formData = [
        'cusd_name'     => $this->input->post('new_cus_name'),
        'cusd_email'    => $this->input->post('new_cus_email'),
        'cusd_place'    => $this->input->post('new_cus_location'), // Location
        'cusd_address'  => $this->input->post('new_cus_address'),
        'cusd_district' => $this->input->post('new_cus_district'),
    ];

    // Get phone numbers as an array
    $phoneNumbers = $this->input->post('new_cus_phone'); // This will be an array

    // Validate phone numbers
    if (empty($phoneNumbers) || !is_array($phoneNumbers)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please provide at least one phone number.',
        ]);
        exit;
    }

    // Pass data to model
    $result = $this->customers->storeCustomer($formData, $phoneNumbers);

    // Send JSON response to frontend
    echo json_encode($result);
    exit;
}


     public function searchCustomerByPhone()
{
    header('Content-Type: application/json');

    $phone = $this->input->get('phone');

    if (strlen($phone) >= 9) {
        $results = $this->customers->getCustomersByPhone($phone);

        if (!is_array($results)) {
            $results = [];
        }
        echo json_encode($results);
    } else {
        echo json_encode([]); // Return an empty array if the phone number invld
    }
}


   

    public function edit($id)
{
    if ($id) {
        $data['customer'] = $this->customers->getCustomersById($id);

        if (!$data['customer']) {
            show_error('Customer not found.', 404);
            return;
        }
        $data['customer']['cusd_id'] = $id;
        $data['cusPhones'] = $this->customers->getCustomerPhonesByCustomerId($id) ?? [];
        $data['districts'] = $this->registration->getDistricts();
        $this->render_page(strtolower(__CLASS__) . '/edit', $data);
    } else {
        show_error('Invalid customer ID.', 400);
    }
}

     public function searchCustomer()
{
    header('Content-Type: application/json');
    $search_term = $this->input->get('search_term');
    
    // Call the model function to fetch the customers
    $customers = $this->customers->searchCustomer($search_term);
    
    // Return the result as JSON
    echo json_encode($customers);
}


public function is_exist()
{
    $phone = $this->input->get('phone'); 
    // Validate the phone input
    if (!$phone || !preg_match('/^\d{10}$/', $phone)) { 
        echo json_encode(['exists' => false, 'message' => 'Invalid phone number format.']);
        return;
    }

    // Check if the phone exists in the Db
    $exists = $this->customers->check_phone_exists($phone);

    if ($exists) {
        echo json_encode(['exists' => true, 'message' => 'Phone number already exists.']);
    } else {
        echo json_encode(['exists' => false, 'message' => 'Phone number is available.']);
    }
} 
public function is_exist_edit() {//check phone number is exist or ot from edit form
    $phone = $this->input->get('phone'); // Get phone number from query string
    $cusd_id = $this->input->get('cusd_id'); // Get customer ID from query string

    // Check if the phone number exists for a different customer
    $exists = $this->customers->checkPhoneExistsEdit($phone, $cusd_id);

    // Return JSON response
    echo json_encode(array('exists' => $exists));
}    
     
public function add() {//detailed form
    $response = ['status' => 'error', 'message' => ''];

    // Get POST data
    $data = $this->input->post();
    
    // Validate name
    if (empty($data['cusd_name'])) {
        $response['message'] = 'Customer name is required.';
        echo json_encode($response);
        return;
    }

    // Validate phone numbers
    if (empty($data['phone']) || !is_array($data['phone'])) {
        $response['message'] = 'At least one phone number is required.';
        echo json_encode($response);
        return;
    }

    // Check for duplicate phone numbers in the database
    foreach ($data['phone'] as $phone) {
        if ($this->customers->is_phone_exists($phone)) {
            $response['message'] = "The phone number {$phone} already exists. Please enter another.";
            echo json_encode($response);
            return;
        }
    }

    // insert into master tbl
    $customerData = [
        'cusd_name' => $data['cusd_name'],
        'cusd_phone_office' => $data['cusd_phone_office'] ?? null,
        'cusd_phone_resi' => $data['cusd_phone_resi'] ?? null,
        'cusd_whatsapp' => $data['cusd_whatsapp'] ?? null,
        'cusd_email' => $data['cusd_email'] ?? null,
        'cusd_fb' => $data['cusd_fb'] ?? null,
        'cusd_age' => $data['cusd_age'] ?? 0,
        'cusd_gender' => $data['cusd_gender'] ?? null,
        'cusd_place' => $data['cusd_place'] ?? null,
        'cusd_address' => $data['cusd_address'] ?? null,
        'cusd_address_office' => $data['cusd_address_office'] ?? null,
        'cusd_company' => $data['cusd_company'] ?? null,
        'cusd_district' => $data['cusd_district'] ?? 0,
        'cusd_pin' => $data['cusd_pin'] ?? 0,
    ];
    //debug($customerData);
    $customerId = $this->customers->insert_customer($customerData);

    if ($customerId) {
        // Insrt phone numbers into the phone table
        foreach ($data['phone'] as $phone) {
            $this->customers->insert_phone([
                'cup_customer_id' => $customerId,
                'cup_phone' => $phone
            ]);
        }

        $response = ['status' => 'success', 'message' => 'Customer added successfully.'];
    } else {
        $response['message'] = 'Failed to add customer.';
    }

    echo json_encode($response);
}
     

 //Delete phone number
public function delete_phone() {
    $cup_id = $this->input->post('cup_id'); 
    if ($cup_id) {
        $this->customers->deletePhone($cup_id);
        // Return JSON response
        echo json_encode(array('status' => 'success', 'message' => 'Phone number deleted successfully.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
    }
}
     
public function update($id) {
   
    if ($id) {
        // upd customer details
     $customerData = array(
    'cusd_name' => $this->input->post('cusd_name'),
    'cusd_phone_office' => $this->input->post('cusd_phone_office'),
    'cusd_phone_resi' => $this->input->post('cusd_phone_resi'),
    'cusd_whatsapp' => $this->input->post('cusd_whatsapp'),
    'cusd_email' => $this->input->post('cusd_email'),
    'cusd_fb' => $this->input->post('cusd_fb'),
    'cusd_age' => $this->input->post('cusd_age'),
    'cusd_gender' => $this->input->post('cusd_gender'),
    'cusd_place' => $this->input->post('cusd_place'),
    'cusd_address' => $this->input->post('cusd_address'),
    'cusd_address_office' => $this->input->post('cusd_address_office'),
    'cusd_company' => $this->input->post('cusd_company'),
    'cusd_district' => $this->input->post('cusd_district'),
    'cusd_pin' => $this->input->post('cusd_pin'),
);
        $this->db->where('cusd_id', $id);
        $this->db->update('cpnl_customer_details', $customerData);

        // Update phone numbers
        $phones = $this->input->post('phone');
        $cup_ids = $this->input->post('cup_id');
        foreach ($phones as $index => $phone) {
            if (!empty($cup_ids[$index])) {
                // Update existing phone
                $this->db->where('cup_id', $cup_ids[$index]);
                $this->db->update('cpnl_customer_phones', array('cup_phone' => $phone));
            } else {
                // Add new phone
                $this->db->insert('cpnl_customer_phones', array(
                    'cup_customer_id' => $id,
                    'cup_phone' => $phone
                ));
            }
        }

        // Return JSON response
        echo json_encode(array('status' => 'success', 'message' => 'Customer updated successfully.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
    }
}

 
}
