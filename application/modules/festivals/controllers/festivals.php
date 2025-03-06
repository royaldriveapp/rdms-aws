<?php

defined('BASEPATH') or exit('No direct script access allowed');

class festivals extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'Festival';
        
          $this->load->model('festivals_model', 'festival');
     }



     public function index() {
          $data = []; // Initialize data array if needed
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
      }
  
      public function list_ajax() {
          $response = $this->festival->getFestivalPaginate($this->input->post());
          echo json_encode($response);
      }

     function sync_festival_data() {
          echo "Starting API Call...<br>";
      
          // Step 1: Fetch data from MongoDB API
          $mongoApiUrl = 'https://royaldrivesmart.in/api/festival/synch-festival-data';
      
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $mongoApiUrl);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      
          $response = curl_exec($curl);
      
          if (curl_errno($curl)) {
              echo 'cURL Error: ' . curl_error($curl) . '<br>';
              curl_close($curl);
              exit;
          }
      
          curl_close($curl);
      
          echo "API Call Successful, Response: <br>";
          $data = json_decode($response, true);
      
          if (json_last_error() !== JSON_ERROR_NONE) {
              echo "JSON Error: " . json_last_error_msg() . "<br>";
              exit;
          }
      
          if (isset($data['data']) && is_array($data['data'])) {
              echo "Inserting data into MySQL...<br>";
      
              foreach ($data['data'] as $record) {
                  // Prepare the data for insertion, handle missing or empty fields
                  $mongoId = $record['id'] ?? null;
                  $name = $record['name'] ?? null;
                  $phone_no = $record['phone_no'] ?? null;
                  $whats_app = $record['whats_app'] ?? null;
                  $email = $record['email'] ?? null;
                  $district = !empty($record['district']) ? $record['district'] : 0; // Handle empty district
                  $existing_car = $record['existing_car'] ?? null;
                  $purchase_plan_period = !empty($record['purchase_plan_period']) ? $record['purchase_plan_period'] : null; // Handle empty purchase period
                  $is_interested = isset($record['is_interested']) ? (int) $record['is_interested'] : null;
                  $submitted_at = $record['submitted_at'] ?? null;
      
                  // Insert the record into the MySQL table
                  $insertData = [
                      'eve_ref_no' => $mongoId,
                      'eve_type' => 1, // 
                      'eve_event' => 54, // event id
                      'eve_name' => $name,
                      'eve_mobile' => $phone_no,
                      'eve_whatsapp' => $whats_app,
                      'eve_email' => $email,
                      'eve_vehicle_string' => $existing_car,
                      'eve_district' => $district, // Allow NULL or set default
                      'eve_purchase_period' => $purchase_plan_period, // Allow NULL or set default
                      'eve_interested_in_car' => $is_interested,
                      'eve_added_on' => $submitted_at
                  ];
      
                  // Insert into MySQL and handle any errors
                  try {
                      $this->db->insert('cpnl_event_enquires', $insertData);
      
                      if ($this->db->affected_rows() > 0) {
                          echo "Inserted: " . $name . "<br>";
                      } else {
                          echo "Failed to insert: " . $name . "<br>";
                      }
                  } catch (Exception $e) {
                      echo "MySQL Error: " . $e->getMessage() . "<br>";
                  }
      
                  // Prepare IDs to update MongoDB is_synch field
                  $idsToUpdate[] = $mongoId;
              }
      
              // After all records are inserted, update MongoDB is_synch field for processed records
              if (!empty($idsToUpdate)) {
                  $this->updateMongoSyncStatus($idsToUpdate);
              }
          } else {
              echo "No data found in the API response.<br>";
          }
      }
      
      function updateMongoSyncStatus($ids) {
          echo "Updating MongoDB Sync Status...<br>";
      
          $updateApiUrl = 'https://royaldrivesmart.in/api/festival/update-synch';
          $data = json_encode(['ids' => $ids]);
      
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $updateApiUrl);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

           // Disable SSL verification (not recommended for production)
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      
          $response = curl_exec($curl);
      
          if (curl_errno($curl)) {
              echo 'cURL Error: ' . curl_error($curl) . '<br>';
          } else {
              echo "Update Response: " . $response . "<br>";
          }
      
          curl_close($curl);
      }
      
}
