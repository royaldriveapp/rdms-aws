<?php

defined('BASEPATH') or exit('No direct script access allowed');

class dbcall extends App_Controller
{

     public function __construct()
     {

          parent::__construct();
          $this->page_title = 'dbcall call';
          $this->load->model('dbcall_model', 'dbcall');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('registration/registration_model', 'registration');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $this->load->model('events/events_model', 'events');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('departments/departments_model', 'departments');
     }

     public function index()
     {
          $data['salesExecutives'] = $this->dbcall->teleCallers();
          $this->render_page(strtolower(__CLASS__) . '/dbcall', $data);
     }

     public function fetchData()
     {
          $response = $this->dbcall->fetchDBMaster($this->input->post());
          echo json_encode($response);
     }

     public function import()
     {
          //Set assignto field on master if choose only one member
          $_POST['master']['edm_assignto'] = (count($this->input->post('executive')) && isset($this->input->post('executive')[0])) ? serialize($this->input->post('executive')) : 0;
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();

          $this->load->library('upload');
          $newFileName = rand(9999999, 0) . clean_image_name($_FILES['uploadDocument']['name']);
          $config['upload_path'] = './../assets/uploads/documents/';
          $config['allowed_types'] = 'xls|xlsx';
          $config['file_name'] = $newFileName;
          $this->upload->initialize($config);
          if ($this->upload->do_upload('uploadDocument')) {
               $uploadData = $this->upload->data();
               $fileName = $uploadData['full_path'];

               $inputFileType = PHPExcel_IOFactory::identify($fileName);
               $objReader = PHPExcel_IOFactory::createReader($inputFileType);
               $objReader->setReadDataOnly(true);
               $objPHPExcel = $objReader->load($fileName);
               $allDataInSheet = array_filter($objPHPExcel->getActiveSheet()->toArray(null, true, true, true));
               if (!empty($allDataInSheet)) {
                    $_POST['master']['edm_file_name'] = $fileName;
                    $masterId = $this->dbcall->dbMaster($this->input->post('master'));
                    $executive = $this->input->post('executive');
                    $ids = array();
                    unset($allDataInSheet['1']);
                    //debug($allDataInSheet);
                    $duplicateNumbers[] = array();
                    $already = array();
                    foreach ($allDataInSheet as $key => $value) {
                         if ($key > 1) {
                              $value['C'] = str_replace(' ', '', $value['C']);
                              $cusMobile = substr($value['C'], -10);
                              if (!in_array($cusMobile, $already)) {
                                   $ids[] = $this->dbcall->add($value, $masterId);
                                   $already[] = $cusMobile;
                              } else {
                                   $duplicateNumbers[] = $cusMobile;
                              }
                         }
                    }
                    $div = round(count($ids) / count($executive)) + 1;
                    $assign = array_chunk($ids, $div);

                    if (!empty($assign)) {
                         foreach ($assign as $asskey => $assval) {
                              $ss = isset($executive[$asskey]) ? $executive[$asskey] : 0;
                              $this->dbcall->assignTo($ss, $assval);
                         }
                    }
               }
          }
          echo json_encode('success');
     }

     function dbdetails($id)
     {
          $data['masterId'] = $id;
          $this->render_page(strtolower(__CLASS__) . '/dbdetails', $data);
     }

     function dbdetails_ajax($id)
     {
          echo json_encode($this->dbcall->fetchDBDetails($this->input->post(), $id));
     }

     public function add($calId = 0, $teleType = 1)
     {
          $msgType = 'app_success';
          $msg = 'Register successfully added!';

          // Check if dropped
          //TODO: will delete in future
          //            $isDroppedCase = $this->registration->getEnquiryByMobile($this->input->post('vreg_cust_phone'));
          //            $status = ($isDroppedCase['enq_current_status']) ? $isDroppedCase['enq_current_status'] : 0;
          //            if($status == 3) { 
          //                 $this->session->set_flashdata('app_error', "This enquiry already dropped!");
          //                 redirect(strtolower(__CLASS__));
          //            }
          // Check if dropped

          if (!empty($_POST)) {

               if ($teleType == 2) {
                    generate_log(array(
                         'log_title' => 'Contact punching (DB call list) teleout',
                         'log_desc' => serialize($_POST),
                         'log_controller' => 'punch-registration-teleout-dblist',
                         'log_action' => 'C',
                         'log_ref_id' => 1111,
                         'log_added_by' => $this->uid
                    ));
               } else {
                    generate_log(array(
                         'log_title' => 'Contact punching (DB call list)',
                         'log_desc' => serialize($_POST),
                         'log_controller' => 'punch-registration-dblist',
                         'log_action' => 'C',
                         'log_ref_id' => 1112,
                         'log_added_by' => $this->uid
                    ));
               }
               //Auto assign case
               /* if (!isset($_POST['vreg_assigned_to'])) {
                   $referToDivision = isset($_POST['vreg_refer_division']) ? $_POST['vreg_refer_division'] : 0;
                   $referToShowroom = isset($_POST['vreg_refer_showroom']) ? $_POST['vreg_refer_showroom'] : 0;
                   if ($referToDivision > 0 && $referToShowroom > 0) {
                   $_POST['vreg_assigned_to'] = $this->registration->getAutoAssignExecutive($referToShowroom, $referToDivision);
                   } else {
                   $_POST['vreg_assigned_to'] = $this->registration->getAutoAssignExecutive($this->shrm);
                   }
                   } */
               //                 if ($this->usr_grp != 'TC') {
               //                      $assignTo = (isset($_POST['vreg_assigned_to']) && !empty($_POST['vreg_assigned_to'])) ? $_POST['vreg_assigned_to'] : $this->uid;
               //                      $_POST['vreg_assigned_to'] = $assignTo;
               //                 }
               //Auto assign case
               /* $alreadyEntered = $this->registration->alreadyEnteredToday($this->input->post('vreg_cust_phone'));
                   if (!empty($alreadyEntered)) {
                   $assignBy = isset($alreadyEntered['assignBy']) ? $alreadyEntered['assignBy'] : '';
                   $assignTo = isset($alreadyEntered['assignTo']) ? $alreadyEntered['assignTo'] : '';
                   $comments = isset($alreadyEntered['vreg_last_action']) ? 'Comments : ' . $alreadyEntered['vreg_last_action'] : '';
                   $this->session->set_flashdata('app_success_pop', $this->input->post('vreg_cust_phone') .
                   ' This is already entered today, assigned by : ' . $assignBy . ' , assigned to : ' . $assignTo . ' <br>' . $comments);
                   redirect(strtolower(__CLASS__));
                   } */
               //                 if ($this->usr_grp == 'SE') {
               $duplicate = $this->registration->matchingInquiry($this->input->post('vreg_cust_phone'));
               if (!empty($duplicate)) {
                    $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                    $userId = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                    //$_POST['vreg_assigned_to'] = $userId;
                    $msg = 'Inquiry already associated with sales executive ' . $se;
                    $msgType = 'app_success_pop';
               }
               //                 }

               if ($this->dbcall->create($_POST)) {
                    $this->session->set_flashdata($msgType, $msg);
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Vehicle!");
               }

               $calRef = isset($_POST['vreg_voxbay_ref']) ? $_POST['vreg_voxbay_ref'] : 0;
               $data['callListDetails'] = $callListDetails = $this->dbcall->readCallList($calRef);
               $masterId = isset($data['callListDetails']['edd_db_master_id']) ? $data['callListDetails']['edd_db_master_id'] : 0;

               redirect(strtolower(__CLASS__) . '/dbdetails/' . $masterId);
          } else {
               $this->page_title = 'New vehicle registration';

               $data['callListDetails'] = $callListDetails = $this->dbcall->readCallList($calId);

               $customerNumber = isset($callListDetails['edd_cust_number']) ? $callListDetails['edd_cust_number'] : '';
               $getPhoneNumber = isset($_GET['phone']) ? $_GET['phone'] : '';
               $data['customerNumber'] = !empty($customerNumber) ? $customerNumber : $getPhoneNumber;

               if (isset($data['customerNumber']) && !empty($data['customerNumber'])) {
                    $duplicate = $this->registration->matchingInquiry($data['customerNumber']);
                    if (!empty($duplicate)) {
                         $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                         $data['usrId'] = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                         $trackCard = ' <a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($duplicate['enq_id'])) . '"><i title="Track card" class="fa fa-list"></i></a>';
                         $data['ifEnqAlready'] = 'Inquiry already associated with sales executive ' . $se . ' Track card : ' . $trackCard;
                    }
               }

               $data['refId'] = isset($callListDetails['edd_id']) ? $callListDetails['edd_id'] : 0;
               $data['teleType'] = isset($teleType) ? $teleType : 1; //1 = telein, 2 = teleout
               $data['events'] = $this->events->read();
               $data['brand'] = $this->enquiry->getBrands();
               $data['division'] = $this->divisions->getActiveData();
               $data['salesExe'] = $this->registration->getAllStaffInSales();
               $data['districts'] = $this->registration->getDistricts();
               $data['mod'] = isset($_GET['mod']) ? $_GET['mod'] : 0;
               $data['reghistory'] = $this->registration->matchingRegister($customerNumber);
               $this->render_page(strtolower(__CLASS__) . '/reg_vehicle', $data);
          }
     }

     function changeStatus($id)
     {
          $this->dbcall->changeStatus($id);
          echo json_encode(array('status' => 'success', 'msg' => 'Status successfully changed'));
     }

     function delete($masterId)
     {
          $this->dbcall->delete($masterId);
          echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted!'));
     }
}
