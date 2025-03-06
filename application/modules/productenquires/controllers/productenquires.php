<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class productenquires extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Webenquires';
           // $this->load->model('reports/reports_model', 'reports');
            $this->load->model('productenquires_model', 'prdEenqModel');
       
       }
       function web_enquiries() {
          $data['teleCallers'] = $this->prdEenqModel->staffs();
          $this->render_page(strtolower(__CLASS__) . '/web_enq', $data);
     }
  
      

     function vehicle_enquiries() {
          $data['teleCallers'] = $this->prdEenqModel->staffs();
          $this->render_page(strtolower(__CLASS__) . '/veh_enq', $data);
     }

     public function quickassign_web_enq() {
          // Check if executives are passed 
          if (isset($_POST['executive']) && count($_POST['executive']) > 0) {
              $executives = $_POST['executive']; // Get the array of executive IDs
      
              // Call the API to get the enquiries
              $apiUrl = "https://royaldrivesmart.in/api/rdms/website-enquiries-all";
      
              // Use CURL to call the API
              $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_URL => $apiUrl,
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET"
              ));
      
              $response = curl_exec($curl);
              $err = curl_error($curl);
              curl_close($curl);
      
              if ($err) {
                  echo "cURL Error #:" . $err;
                  return;
              } else {
                
                  $apiResponse = json_decode($response, true);
      
                  //assign the enqs equally to the executives
                  if ($apiResponse['status'] === 'success' && isset($apiResponse['data'])) {
                      $enquiries = $apiResponse['data']; // Get the list of enquiries
                      $totalEnquiries = count($enquiries);
                      $totalExecutives = count($executives);
    
                      $dataToInsert = [];
                      $refNosToUpdate = []; 
      
                      foreach ($enquiries as $index => $enquiry) {
                          // Calc which executive to assign the enq to
                          $executiveIndex = $index % $totalExecutives;
                          $assignedExecutive = $executives[$executiveIndex];
      
                          // prpr the enq data 4 insertion
                          $dataToInsert[] = [
                              'eve_ref_no' => $enquiry['id'],
                              'eve_type' => 1,
                              'eve_event' => 56, // Event enq master Id for web enq
                              'eve_name' => $enquiry['name'],
                              'eve_mobile' => $enquiry['phone'],
                              'eve_email' => $enquiry['email'],
                              'eve_vehicle' => $enquiry['vehicle_id'],
                              'eve_vehicle_string' => $enquiry['vehicleTitle'],
                              'eve_brand' => $enquiry['brand_id'],
                              'eve_added_on' => date('Y-m-d H:i:s'), 
                              'eve_assigned_to' => $assignedExecutive // Assigned executive
                          ];
      
                          // Collect ref numbers for the update API
                          $refNosToUpdate[] = $enquiry['id'];
                      }
      
                    // Insert the data 
                      if (!empty($dataToInsert)) {
                          $this->db->insert_batch('cpnl_event_enquires', $dataToInsert); // Batch insert
                    // call the updt API to set 'is_assigned' to 1
                          $apiUpdateUrl = "https://royaldrivesmart.in/api/rdms/website-enquiries-set-assigned";
                          $updateData = [
                              'ids' => implode(',', $refNosToUpdate) // array to a comma separated string
                          ];
      
                          $updateCurl = curl_init();
                          curl_setopt_array($updateCurl, array(
                              CURLOPT_URL => $apiUpdateUrl,
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_POST => true,
                              CURLOPT_POSTFIELDS => http_build_query($updateData),
                              CURLOPT_SSL_VERIFYPEER => false 
                          ));
                          $updateResponse = curl_exec($updateCurl);
                          $updateErr = curl_error($updateCurl);
                          curl_close($updateCurl);
      
                          // Check for update API errors
                          if ($updateErr) {
                              echo "Update API cURL Error #: " . $updateErr;
                          } else {
                              $updateApiResponse = json_decode($updateResponse, true);
                            //  echo "Update API Response: " . $updateResponse; 
                            if ($updateApiResponse['status'] === 'success') {
                              // Send a success response
                              die(json_encode(array('msg' => 'Successfully updated enquiries as assigned')));
                          } else {
                              // Send an error message if the API response indicates failure
                              die(json_encode(array('msg' => 'Update API error: ' . (isset($updateApiResponse['message']) ? $updateApiResponse['message'] : 'Unknown error'))));
                          }
                          
                          }
                      } else {
                          echo "No enquiries to assign.";
                      }
                  } else {
                      echo "No enquiries found or API error.";
                  }
              }
          } else {
              echo "No executives provided.";
          }
      }

      public function quickassign_veh_enq() {        if (isset($_POST['executive']) && count($_POST['executive']) > 0) {
              $executives = $_POST['executive']; // Get the array of executive IDs
              $apiUrl = "https://royaldrivesmart.in/api/rdms/vehicle-enquiries-all";
      
              // Use CURL to call the API
              $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_URL => $apiUrl,
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET"
              ));
      
              $response = curl_exec($curl);
              $err = curl_error($curl);
              curl_close($curl);
      
              if ($err) {
                  echo "cURL Error #:" . $err;
                  return;
              } else {
                
                  $apiResponse = json_decode($response, true);
      
                  if ($apiResponse['status'] === 'success' && isset($apiResponse['data'])) {
                      $enquiries = $apiResponse['data']; 
                      $totalEnquiries = count($enquiries);
                      $totalExecutives = count($executives);
                      $dataToInsert = [];
                      $refNosToUpdate = []; 
      
                      foreach ($enquiries as $index => $enquiry) {
                          $executiveIndex = $index % $totalExecutives;
                          $assignedExecutive = $executives[$executiveIndex];
      
                          $dataToInsert[] = [
                              'eve_ref_no' => $enquiry['id'],
                              'eve_type' => 1, 
                              'eve_event' => 57, //event master id for vehicle enq 
                              'eve_name' => $enquiry['name'],
                              'eve_mobile' => $enquiry['phone'],
                              'eve_email' => $enquiry['email'],
                              'eve_vehicle' => $enquiry['prdId'],
                              'eve_vehicle_string' => $enquiry['productTitle'],
                              'eve_state' => $enquiry['state'],
                              'eve_district' => $enquiry['district'],
                              'eve_added_on' => date('Y-m-d H:i:s'), // Current timestamp
                              'eve_assigned_to' => $assignedExecutive // Assigned executive
                          ];
    
                          $refNosToUpdate[] = $enquiry['id'];
                      }
      
                      if (!empty($dataToInsert)) {
                          $this->db->insert_batch('cpnl_event_enquires', $dataToInsert); // Batch insert
                          $apiUpdateUrl = "https://royaldrivesmart.in/api/rdms/vehicle-enquiries-set-assigned";
      
                          $updateData = [
                              'ids' => implode(',', $refNosToUpdate)
                          ];
    
                          $updateCurl = curl_init();
                          curl_setopt_array($updateCurl, array(
                              CURLOPT_URL => $apiUpdateUrl,
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_POST => true,
                              CURLOPT_POSTFIELDS => http_build_query($updateData),
                              CURLOPT_SSL_VERIFYPEER => false 
                          ));
      
                          $updateResponse = curl_exec($updateCurl);
                          $updateErr = curl_error($updateCurl);
                          curl_close($updateCurl);
      
                          if ($updateErr) {
                              echo "Update API cURL Error #: " . $updateErr;
                          } else {
                              $updateApiResponse = json_decode($updateResponse, true);
                            if ($updateApiResponse['status'] === 'success') {
                              die(json_encode(array('msg' => 'Successfully updated enquiries as assigned')));
                          } else {
                              die(json_encode(array('msg' => 'Update API error: ' . (isset($updateApiResponse['message']) ? $updateApiResponse['message'] : 'Unknown error'))));
                          }
                          
                          }
                      } else {
                          echo "No enquiries to assign.";
                      }
                  } else {
                      echo "No enquiries found or API error.";
                  }
              }
          } else {
              echo "No executives provided.";
          }
      }
         
} 

?>