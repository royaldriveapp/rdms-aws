<?php
//use function Psy\debug;

use function Psy\debug;

defined('BASEPATH') or exit('No direct script access allowed');
class web_enq_forms extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'web_enq_forms';
          $this->load->model('web_enq_forms_model', 'web_enq_forms');
          $this->load->model('followup/followup_model', 'followup');
          $this->load->model('ihits_api/ihits_api_model', 'ihits_api_model');
          $this->load->model('registration/registration_model', 'registration');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
     }

     public function index()
     {
          $data['salesStaff'] = $this->web_enq_forms->staffCanAssignEnquires();
          $data['fellowshipStaff'] = $this->web_enq_forms->staffFellowship();
          if (check_permission('web_enq_forms', 'analysis')) {
               $data['analysis'] = $this->web_enq_forms->analysis();
          }
          //debug($data['fellowshipStaff']);
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }
     public function list_ajax()
     {
          $response = $this->web_enq_forms->getDataPaginate($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     public function details($web_enq_id = '')
     {
          if ($web_enq_id) {

               $data = $this->web_enq_forms->getData($web_enq_id);
               $results = array_values(array_filter($this->mandatory['fields'], function ($people) {
                    return $people['d_id'] == $this->desi_id;
               }));
               $data['mandatory'] = isset($results[0]['content']) ? explode(',', $results[0]['content']) : '';
               $data['division'] = $this->divisions->getActiveData();
               $data['salesExe'] = $this->web_enq_forms->getAllStaffInSales();
               $this->render_page(strtolower(__CLASS__) . '/view', $data);
          }
     }
     public function edit($web_enq_id = '')
     {
          if ($web_enq_id) {
               $data = $this->web_enq_forms->getData($web_enq_id);
               // echo '<pre>';
               // print_r($data);
               // echo '</pre>';
               // exit;
               $results = array_values(array_filter($this->mandatory['fields'], function ($people) {
                    return $people['d_id'] == $this->desi_id;
               }));
               $data['mandatory'] = isset($results[0]['content']) ? explode(',', $results[0]['content']) : '';
               $state_id = 18; //kerala
               $data['districts'] = $this->web_enq_forms->getDistricts($state_id);
               $this->render_page(strtolower(__CLASS__) . '/edit', $data);
          }
     }
     public function updateFellowship()
     {
          //  print_r($_POST); exit;
          // $this->restorePhoneNumber(); exit;
          $message = 'Error';
          if ($this->input->is_ajax_request() && $this->input->post('web_id')) {
               if ($this->web_enq_forms->updateFellowship($_POST)) {
                    $message = 'successfully Updated!';
               }
               echo json_encode($message);
          }
     }

     public function restorePhoneNumber()
     {
          // Example data to reinstate
          $webph_master_id = 230;
          $webph_phone = '9446021988';
          $webph_created_at = date('Y-m-d H:i:s');

          // Load the model if not already loaded
          $this->load->model('web_enq_forms');

          // Call the method to reinstate the phone number
          if ($this->web_enq_forms->reinstatePhoneNumber($webph_master_id, $webph_phone, $webph_created_at)) {
               echo json_encode(array('status' => true, 'message' => 'Phone number successfully reinstated.'));
          } else {
               echo json_encode(array('status' => false, 'message' => 'Failed to reinstate phone number.'));
          }
     }

     public function addToReg()
     {
          if ($_POST) {
               $data = $this->web_enq_forms->AddToReg($_POST);
               $this->render_page(strtolower(__CLASS__) . '/list');
          }
     }

     public function create($enq_id = '', $val_id = '')
     {
          if ($enq_id) {
               if ($val_id == '') {
                    $res = $this->web_enq_forms->getValIdByEnq($enq_id);
                    $val_id = $res['val_id'];
               }
               $data['web_enq_forms_data'] = $this->web_enq_forms->getData($val_id);
               $data['valuations'] = $this->web_enq_forms->getValData();
               $data['enq_id'] = $enq_id;
               $data['val_id'] = $val_id;
               $data['states'] = $this->web_enq_forms->getStates();
               $this->render_page(strtolower(__CLASS__) . '/view', $data);
          }
     }

     public function addold()
     {
          if (!empty($_POST)) {

               $_POST['pr_ref_no'] = generate_inv_number($_POST['pr_val_id']);
               if ($this->web_enq_forms->insert($_POST)) {
                    $data['enh_enq_id'] = $_POST['pr_enq_id'];
                    $data['quickfollowup'] = '';
                    $data['cb'] = '';
                    $data['enh_status'] = 6;
                    $data['enh_booked_vehicle'] = $_POST['pr_val_id']; //val_id
                    $data['enh_booking_amt'] = $_POST['pr_total'];
                    $data['enh_remarks'] = 'wwsewqe';
                    $this->changeStatus($data);
                    $this->session->set_flashdata('app_success', 'Successfully added!');
               }
          }
          redirect(strtolower(__CLASS__));
     }

     function changeStatus($data)
     {
          $cb = isset($data['cb']) ? $data['cb'] : '';
          unset($data['cb']);
          if (isset($data['quickfollowup'])) {
               $msg = isset($data['enh_remarks']) ? $data['enh_remarks'] : '';
               $this->followup->removeRow($data['quickfollowup'], $msg);
               unset($data['quickfollowup']);
          }
          if ($this->followup->changeStatus($data)) {
               $msg = isset($data['enh_remarks']) ? $data['enh_remarks'] : '';
               $enqId = isset($data['enh_enq_id']) ? $data['enh_enq_id'] : '';
               $status = $this->common_model->getStatusById($data['enh_status']);
               $stsmsg = isset($status['sts_des']) ? $status['sts_des'] : '';
               if ($enqId > 0) {
                    $this->followup->updateComments(array(
                         'foll_is_cmnt' => 1, 'foll_remarks' => $msg . ' ' . $stsmsg,
                         'foll_cus_id' => $enqId, 'foll_parent' => 0
                    ));
               }
          }
     }

     public function update_approval()
     {
          if (!empty($_POST) && $this->web_enq_forms->updateApproval($_POST)) {
               $message = 'successfully Updated!';
               if ($_POST['pr_approve']) {
                    $purchas_data = $this->web_enq_forms->web_enq_formsApi($_POST['pr_val_id'], $_POST['pr_id'], $_POST['pr_enq_id']);
                    $this->ihits_api_model->ihitsSource($purchas_data);
                    $message = 'successfully Approved!';
               }
               echo json_encode($message);
          } else {
               $message = 'Error';
               echo json_encode($message);
          }
     }

     public function approved_list()
     {
          $this->render_page(strtolower(__CLASS__) . '/list_approved');
     }
     public function approved_list_ajax()
     {
          $response = $this->web_enq_forms->getApprovedPaginate($this->input->post());
          echo json_encode($response);
     }


     public function update()
     {
          if (!empty($_POST)) {
               if ($this->web_enq_forms->update($_POST)) {
                    $this->session->set_flashdata('app_success', 'Successfully added!');
               }
          }
          redirect(strtolower(__CLASS__));
     }
     /*
    */
     public function get_column_names()
     {
          $sql = "DESCRIBE $table_name";
          $query = $this->db->query($sql);
          if ($query) {
               $result = $query->result();
               foreach ($result as $row) {
                    echo $row->Field . " (" . $row->Type . ")<br>";
               }
          } else {
               echo "Error fetching column names: " . $this->db->error();
          }
     }
     public function getAll()
     {
          $table_name = 'cpnl_register_master';
          $this->db->from($table_name);
          $this->db->order_by('vreg_id', 'DESC'); // Assuming 'id' is the primary key or a column with timestamp
          //$this->db->order_by('web_id', 'DESC'); // Assuming 'id' is the primary key or a column with timestamp
          $this->db->limit(20);
          $query = $this->db->get();

          if ($query->num_rows() > 0) {
               $result = $query->result_array();
               // Process the result
               echo '<pre>';
               print_r($result);
               echo '</pre>';
          } else {
               echo "No records found.";
          }
     }

     public function add_column_to_web_enquiry()
     {
          // Define the SQL query to add the new column
          $sql = "ALTER TABLE web_enquiry ADD COLUMN web_rdms_reg_id INT DEFAULT 0 AFTER web_rdms_enq_id";

          // Execute the SQL query
          $this->db->query($sql);

          // Check if the query was successful
          if ($this->db->affected_rows() > 0) {
               echo "New column added successfully.";
          } else {
               echo "Error adding new column.";
          }
     }

     public function web_enq_forms_api()
     {
          $data = $this->web_enq_forms->web_enq_formsApi();
          debug($data);
     }
     function bindDistrictBystate()
     {
          if (isset($_GET['state_id']) && !empty($_GET['state_id'])) {
               $district = $this->web_enq_forms->bindDistrictBystate($_GET['state_id']);
               echo json_encode($district);
          }
     }

     public function insertDistricts()
     {
          //$this->web_enq_forms->insertDistricts();    
          //$this->web_enq_forms->updateStatus();
     }

     // function delete($prId)
     // {
     //      if ($prId != 0) {
     //           $this->web_enq_forms->delete($prId);
     //           $this->session->set_flashdata('app_success', 'Row deleted!');
     //           redirect('web_enq_forms');
     //      }
     // }


     public function convertj($web_enq_id)
     { //jsk

          $data = $this->web_enq_forms->getData($web_enq_id);
          debug($web_enq_id);
          $msgType = 'app_success';
          $msg = 'Register successfully added!';


          if (!empty($_POST)) {

               if ($teleType == 2) {
                    generate_log(array(
                         'log_title' => 'Contact punching (Registration) teleout',
                         'log_desc' => serialize($_POST),
                         'log_controller' => 'punch-registration-teleout',
                         'log_action' => 'C',
                         'log_ref_id' => 1011,
                         'log_added_by' => $this->uid
                    ));
               } else {
                    generate_log(array(
                         'log_title' => 'Contact punching (Registration)',
                         'log_desc' => serialize($_POST),
                         'log_controller' => 'punch-registration',
                         'log_action' => 'C',
                         'log_ref_id' => 1001,
                         'log_added_by' => $this->uid
                    ));
               }
               //Auto assign case

               //                 if ($this->usr_grp == 'SE') {
               $_POST['vreg_cust_phone'] = isset($_POST['vreg_cust_phone']) ? str_replace(' ', '', trim($_POST['vreg_cust_phone'])) : '';
               $duplicate = $this->registration->matchingInquiry($this->input->post('vreg_cust_phone'));
               if (!empty($duplicate)) {
                    $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                    $userId = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                    //$_POST['vreg_assigned_to'] = $userId;
                    $msg = 'Inquiry already associated with sales executive ' . $se;
                    $msgType = 'app_success_pop';
               }
               //                 }


               /* @rfrl*/
               if ($this->web_enq_forms->convertAsReg($_POST)) {
                    $this->session->set_flashdata($msgType, $msg);
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Vehicle!");
               }
               redirect(strtolower(__CLASS__));
          }
     }

     public function delete($web_id)
     {
          if ($this->input->is_ajax_request()) {
               $web_id = $this->input->post('web_id');
               log_message('debug', 'Web ID: ' . $web_id); // Debug log
               if ($this->web_enq_forms->deleteRecord($web_id)) {
                    echo json_encode(['status' => 'success']);
               } else {
                    echo json_encode(['status' => 'error']);
               }
          } else {
               show_error('No direct script access allowed');
          }
     }
     public function validate()
     {
          //debug($_POST);

          $message = 'Error';
          if ($this->input->is_ajax_request() && $this->input->post('web_id')) {
               if ($this->web_enq_forms->validate($_POST)) {
                    $message = 'successfully Updated!';
               }
               echo json_encode($message);
          }
     }

     function assignToStaff()
     {
          $data = explode(",", $this->input->post('txtWebEnqId'));

          $executives = $_POST['executive'];
          //debug($executives);
          if (!empty($executives)) {
               if (isset($data) && !empty($data)) {
                    $desc = $this->input->post('desc');
                    $cnt = count($executives);
                    $div = is_float(count($data) / $cnt) ? (int) (count($data) / $cnt) + 1 : (count($data) / $cnt);
                    $divdedData = array_chunk($data, $div);
                    foreach ($executives as $key => $assignTo) {
                         // $toName='jaefar';
                         $toName = $this->enquiry->getUserNameById($assignTo);
                         $fellowshipData = [];
                         array_walk_recursive($divdedData[$key], function ($a) use (&$fellowshipData, $assignTo, $toName, $desc) {
                              $exp = explode('-', $a);
                              $fellowshipData[] = array(
                                   'web_id' => $exp['0'],
                                   'web_assigned_by' => $this->uid,
                                   'web_assigned_to' => $assignTo,
                                   'web_added_date' => date('Y-m-d H:i:s'),
                                   'we_remarks' => $desc,
                                   'web_system_cmd' => "Reassigned Fellowship" . $exp['2'] . " to " . $toName . ", reassigned by " . $this->session->userdata('usr_username')
                              );
                         });
                         $webIDs = 'web_id = ' . implode(array_column($fellowshipData, 'web_id'), ' OR web_id = ');
                         // debug( $fellowshipData);
                         $this->web_enq_forms->assignToStaff($webIDs, $assignTo, $desc);
                         generate_log(array(
                              'log_title' => 'Quick assign Fellowship',
                              'log_desc' => serialize($fellowshipData),
                              'log_controller' => 'quick-assign-fellowship',
                              'log_action' => 'C',
                              'log_ref_id' => 0,
                              'log_added_by' => $this->uid
                         ));
                    }
               } else {
                    die(json_encode(array('status' => 'fail', 'msg' => 'Empty enquiry')));
               }
               die(json_encode(array('status' => 'success', 'msg' => 'Completed')));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => 'Please select staff')));
          }
     }

     function testd()
     {

          //           $this->db->set('web_assign_to', 0)
          //     ->update('web_enquiry');

          //     exit;
          $data = $this->db->select('*')
               // ->where('web_enquiry.web_assign_to',849)//849//11017
               ->order_by('web_enquiry.web_id', 'DESC')
               ->get('web_enquiry')
               ->result_array();
          echo '<pre>';
          print_r($data);
          echo '</pre>';
          exit;
          exit;
          //debug($data);


     }
}
