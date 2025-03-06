<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class customers_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_customer_details = TABLE_PREFIX . 'customer_details';
          $this->tbl_customer_phones = TABLE_PREFIX . 'customer_phones';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_city = TABLE_PREFIX . 'city';
          $this->tbl_occupation = TABLE_PREFIX . 'occupation';
   
       
     }
 
    public function getCustomersPaginate($postDatas) {
        //debug($postDatas['length']);
        $draw = $postDatas['draw'];
        $row = $postDatas['start'];
        $rowperpage = $postDatas['length']; // Rows display per page
        $searchValue = $postDatas['search']['value']; // Search value
    
        // Base SQL query
        $sql = "
            SELECT 
                cd.cusd_id,
                cd.cusd_name,
                cd.cusd_address,
                cd.cusd_whatsapp,
                cd.cusd_email,
                cd.cusd_place,
                ds.std_district_name AS district,
                c.cit_name AS city,
                o.occ_name AS occupation,
                GROUP_CONCAT(cp.cup_phone SEPARATOR ', ') AS phoneNumbers
            FROM 
                cpnl_customer_details AS cd
            LEFT JOIN 
                cpnl_customer_phones AS cp ON cp.cup_customer_id = cd.cusd_id
            LEFT JOIN 
                cpnl_district_statewise AS ds ON ds.std_id = cd.cusd_district
            LEFT JOIN 
                cpnl_city AS c ON c.cit_id = cd.cusd_place
            LEFT JOIN 
                cpnl_occupation AS o ON o.occ_id = cd.cusd_profession
        ";
    
        // Applying search filter if any
        $searchArray = array();
        if (!empty($searchValue)) {
            $sql .= " WHERE cd.cusd_name LIKE ? OR cd.cusd_address LIKE ? OR cp.cup_phone LIKE ?";
            $searchArray = array('%'.$searchValue.'%', '%'.$searchValue.'%', '%'.$searchValue.'%');
        }
    
        // Group by and order by clauses
        $sql .= " GROUP BY cd.cusd_id ORDER BY cd.cusd_id DESC";
    
        // Applying pagination limits
        if ($rowperpage > 0) {
            $sql .= " LIMIT ?, ?";
            array_push($searchArray, intval($row), intval($rowperpage));
        }
    
        // Execute the query
        $query = $this->db->query($sql, $searchArray);
        $data = $query->result_array();
    
        // Get total records count
        $this->db->from('cpnl_customer_details');
        $totalRecords = $this->db->count_all_results();
    
        // Prepare the response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
    
        return $response;
    }
    
   
     public function storeCustomer($data, $phoneNumbers)
{
    $this->db->trans_start(); // Start transaction

    // Check if any of the phone numbers already exist
    $this->db->where_in('cup_phone', $phoneNumbers);
    $query = $this->db->get('cpnl_customer_phones');

    if ($query->num_rows() > 0) {
        // Customer already exists with one of the phone numbers
        $this->db->trans_complete();
        return [
            'success' => false,
            'message' => 'A customer with one or more of these phone numbers already exists.',
        ];
    }

    // Insert main customer data
    $insert = $this->db->insert('cpnl_customer_details', $data);

    if (!$insert) {
        $this->db->trans_rollback(); // Rollback transaction
        return [
            'success' => false,
            'message' => 'Failed to add customer. Please try again.',
        ];
    }

    // Get the newly inserted customer ID
    $customerId = $this->db->insert_id();

    // Prepare phone data for batch insert
    $phoneData = [];
    foreach ($phoneNumbers as $phone) {
        $phoneData[] = [
            'cup_customer_id' => $customerId,
            'cup_phone' => $phone,
        ];
    }

    // Insert phone numbers into the `cpnl_customer_phones` table
    $insertPhones = $this->db->insert_batch('cpnl_customer_phones', $phoneData);

    if (!$insertPhones) {
        $this->db->trans_rollback(); // Rollback transaction
        return [
            'success' => false,
            'message' => 'Failed to add phone numbers. Please try again.',
        ];
    }

    $this->db->trans_complete(); // Commit transaction

    return [
        'success' => true,
        'message' => 'Customer and phone numbers added successfully.',
        'customer_id' => $customerId,
    ];
}


    
    public function getCustomersByPhone($phone)
{
    $phone = substr($phone, -10); // Extract last 10 digits of the phone number
    $this->db->select('cd.cusd_id, cd.cusd_name, cd.cusd_place, cd.cusd_district');
    $this->db->from('cpnl_customer_phones as cp');
    $this->db->join('cpnl_customer_details as cd', 'cp.cup_customer_id = cd.cusd_id', 'inner');
    $this->db->like('cp.cup_phone', $phone, 'before'); // Match phone number
    $query = $this->db->get();
    return $query->row_array(); // Return a single result
}

    public function getCustomersById($cusd_id)
    {
        return $this->db->select('cusd_name,cusd_phone_office, cusd_phone_resi,cusd_whatsapp,cusd_email,cusd_fb,cusd_age,cusd_gender,cusd_place,cusd_address,cusd_address_office,cusd_profession,cusd_company,cusd_district,cusd_pin')
        ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_customer_details . '.cusd_place', 'left')
        ->from($this->tbl_customer_details)
        ->where('cusd_id', $cusd_id)
        ->get()
        ->row_array();
    }
    public function getCustomerPhonesByCustomerId($customerId)
    {
        return $this->db->select('cup_id, cup_phone')
            ->from($this->tbl_customer_phones)
            ->where('cup_customer_id', $customerId)
            ->get()
            ->result_array();
    }


public function searchCustomer($search_term)
{
    if (strlen($search_term) >= 3) {
        // SQL query to fetch all phone numbers for matched customers
        $sql = "
            SELECT 
                cd.cusd_id, 
                cd.cusd_name, 
                cd.cusd_address, 
                GROUP_CONCAT(cp.cup_phone SEPARATOR ', ') AS phoneNumbers
            FROM 
                cpnl_customer_details AS cd
            INNER JOIN 
                cpnl_customer_phones AS cp 
            ON 
                cp.cup_customer_id = cd.cusd_id
            WHERE 
                cd.cusd_id IN (
                    SELECT 
                        cd_inner.cusd_id 
                    FROM 
                        cpnl_customer_details AS cd_inner
                    LEFT JOIN 
                        cpnl_customer_phones AS cp_inner 
                    ON 
                        cp_inner.cup_customer_id = cd_inner.cusd_id
                    WHERE 
                        cd_inner.cusd_name LIKE ? 
                        OR cd_inner.cusd_address LIKE ? 
                        OR cp_inner.cup_phone LIKE ?
                )
            GROUP BY 
                cd.cusd_id
        ";

        // Use placeholders for security
        $query = $this->db->query($sql, [
            '%' . $search_term . '%',
            '%' . $search_term . '%',
            '%' . $search_term . '%'
        ]);

        $customers = $query->result_array();

        // Prepare the result array
        $result = [];
        foreach ($customers as $customer) {
            $phoneNumbers = explode(', ', $customer['phoneNumbers']);
            $phoneNumbers = array_map('trim', $phoneNumbers); // Clean up spaces
            
            $result[] = [
                'cusd_name' => $customer['cusd_name'],
                'cusd_id' => $customer['cusd_id'],
                'cusd_address' => $customer['cusd_address'],
                'phoneNumbers' => $phoneNumbers
            ];
        }

        return $result;
    } else {
        return [];
    }
}

public function check_phone_exists($phone)
    {
        $this->db->select('cup_id'); // Select only the `cup_id` field for minimal data
        $this->db->from('cpnl_customer_phones');
        $this->db->where('cup_phone', $phone);
        $query = $this->db->get();

        // If rows are returned, the phone exists
        return $query->num_rows() > 0;
    }

    public function insert_customer($data) {
        $this->db->insert('cpnl_customer_details', $data);
        return $this->db->insert_id(); // Return the inserted customer ID
    }

    public function insert_phone($data) {
        return $this->db->insert('cpnl_customer_phones', $data);
    }

    public function is_phone_exists($phone) {
        $this->db->where('cup_phone', $phone);
        $query = $this->db->get('cpnl_customer_phones');
        return $query->num_rows() > 0;
    }
  // Delete a phone number by ID
  public function deletePhone($cup_id) {
    $this->db->where('cup_id', $cup_id);
    $this->db->delete($this->tbl_customer_phones);
}
public function checkPhoneExistsEdit($phone, $cusd_id) {
    return $this->db->where('cup_phone', $phone)
                    ->where('cup_customer_id !=', $cusd_id) // Exclude the current customer
                    ->from('cpnl_customer_phones')
                    ->count_all_results() > 0;
}
}
