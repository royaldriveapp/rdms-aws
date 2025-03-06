<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class rdenquiry extends App_Controller {

       public $myEnquiry = '';

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Enquiry';
            $this->load->model('enquiry_model', 'enquiry');
            $this->load->model('emp_details/emp_details_model', 'emp_details');
            $this->load->model('evaluation/evaluation_model', 'evaluation');
            $this->load->model('followup/followup_model', 'followup');
            $this->load->model('showroom/showroom_model', 'showroom');
            $this->load->model('customer_grade/customer_grade_model', 'customer_grade');
            $this->load->model('departments/departments_model', 'departments');
            $this->load->model('registration/registration_model', 'registration');
            $this->myEnquiry = $this;
       }

       public function index() {
            $filterStatus = isset($_GET['status']) ? $_GET['status'] : 0;

            $this->load->library("pagination");
            $limit = get_settings_by_key('pagination_limit');
            $page = !isset($_GET['page']) ? 0 : $_GET['page'];
            $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
            $link = $linkParts[0];
            $config = getPaginationDesign();

            $data = $_GET;
            $enquires = $this->enquiry->enquires('', array(), $limit, $page, $_GET);
            $data['enquires'] = $enquires['data'];

            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config["base_url"] = $link;
            $config["total_rows"] = $enquires['count'];
            $config["per_page"] = $limit;
            $config["uri_segment"] = 3;

            /* Table info */
            $data['pageIndex'] = $page + 1;
            $data['limit'] = $page + $limit;
            $data['totalRow'] = number_format($enquires['count']);
            /* Table info */

            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();
            $data['staffs'] = $this->enquiry->staffCanAssignEnquires();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add() {

            if (!empty($_POST)) {
                 /* Login */
                 generate_log(array(
                     'log_title' => 'Create new enquiry',
                     'log_desc' => serialize($_POST),
                     'log_controller' => 'new-enq-from-ctrl',
                     'log_action' => 'C',
                     'log_ref_id' => 1003,
                     'log_added_by' => $this->uid
                 ));
                 /* Login */

                 $message = '';
                 if (isset($_POST['enquiry']['enq_entry_date']) && empty($_POST['enquiry']['enq_entry_date'])) {
                      $message = 'Please select inquiry date';
                 }
                 if (isset($_POST['enquiry']['enq_cus_name']) && empty($_POST['enquiry']['enq_cus_name'])) {
                      $message .= ' Please enter customer name';
                 }

                 if (isset($_POST['enquiry']['enq_cus_mobile']) && empty($_POST['enquiry']['enq_cus_mobile'])) {
                      $message .= ' Please enter valid mobile number';
                 }

                 if (isset($_POST['enquiry']['enq_cus_city']) && empty($_POST['enquiry']['enq_cus_city'])) {
                      $message .= ' Please enter place';
                 }
                 if (isset($_POST['enquiry']['enq_mode_enq']) && empty($_POST['enquiry']['enq_mode_enq'])) {
                      $message .= 'Please select mode of inquiry';
                 }
                 if (isset($_POST['enquiry']['enq_cus_when_buy']) && empty($_POST['enquiry']['enq_cus_when_buy'])) {
                      $message .= ' Please choose when would customer like to buy';
                 }
//                 $duplicate = $this->enquiry->registerExists($_POST['enquiry']['enq_cus_mobile']);
//                 if(!empty($duplicate)) {
//                      $message .= ' Inquiry already associated with register';
//                 }
                 if (empty($message)) {
                      $myname = get_logged_user('usr_username');
                      $mynumber = get_logged_user('usr_phone');
                      $mycustmr = trim($_POST['enquiry']['enq_cus_name']);
		     $applink = get_logged_user('usr_appdownloadlink');
                      $message = "Hi Mr.$mycustmr
Greetings from Royal Drive South India's Largest Pre-Owned Luxury Car Showroom Thank you for the visit, We are grateful for serving you. 
My self $myname, Please feel free to contact me @ $mynumber. Regards, $myname info@royaldrive.in, www.royaldrive.in App Link: " . $applink;

                      if ($this->enquiry->newEnquiry($_POST)) {
                           if ($mobile_number = is_indian_number($_POST['enquiry']['enq_cus_mobile'])) {
                                send_sms($message, $mobile_number, 'sms-enquiry');
                           } else if ($mobile_number = is_indian_number($_POST['enquiry']['enq_cus_whatsapp'])) {
                                send_sms($message, $mobile_number, 'sms-enquiry');
                           }
                           $this->session->set_flashdata('app_success', 'New enguiry successfully added!');
                           echo json_encode(array('status' => 'success', 'msg' => 'New enguiry successfully added!'));
                      } else {
                           $this->session->set_flashdata('app_error', 'Error while create new enguiry!');
                           echo json_encode(array('status' => 'fail', 'msg' => 'Error while create new enguiry!'));
                      }
                 } else {
                      echo json_encode(array('status' => 'fail', 'msg' => $message));
                 }
            } else {
                 $data['brands'] = $this->enquiry->getBrands();
                 $data['questions'] = $this->enquiry->getInquiryQuestions();
                 $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
                 $data['salesExe'] = $this->emp_details->salesExecutives();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       function update() {
            if ($this->enquiry->updateEnquiry($_POST)) {
                 $this->session->set_flashdata('app_success', 'Enguiry successfully updated!');
                 echo json_encode(array('status' => "success", 'msg' => 'Enguiry successfully updated!'));
            } else {
                 $this->session->set_flashdata('app_error', 'Error while update enguiry!');
                 echo json_encode(array('status' => 'fail', 'msg' => 'Error while update enguiry!'));
            }
       }

       function view($id) {
            if (!empty($id)) {
                 $id = encryptor($id, 'D');
                 $data['customerGrades'] = $this->customer_grade->get();
                 $data['questions'] = $this->enquiry->getInquiryQuestions();
                 $data['brands'] = $this->enquiry->getBrands();
                 $data['enquiry'] = $this->enquiry->enquires($id);
                 $data['followStatus'] = unserialize(FOLLOW_UP_STATUS);
                 $data['modOfContact'] = unserialize(MODE_OF_CONTACT_FOLLOW_UP);
                 $data['salesExe'] = $this->emp_details->salesExecutives();
                 $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
                 $data['districts'] = $this->registration->getDistricts();
                 $this->render_page(strtolower(__CLASS__) . '/view', $data);
            } else {
                 //404 redirect here
            }
       }

       function autoComPlace() {
            $reply['suggestions'] = $this->enquiry->autoComPlace($_GET['query']);
            echo json_encode($reply);
       }

       function autoComOccupation() {
            $reply['suggestions'] = $this->enquiry->autoComOccupation($_GET['query']);
            echo json_encode($reply);
       }

       function autoComCountry() {
            $reply['suggestions'] = $this->enquiry->autoComCountry($_GET['query']);
            echo json_encode($reply);
       }

       function autoComCity() {
            $reply['suggestions'] = $this->enquiry->autoComCity($_GET['query']);
            echo json_encode($reply);
       }

       function autoComDistrict() {
            $reply['suggestions'] = $this->enquiry->autoComDistrict($_GET['query']);
            echo json_encode($reply);
       }

       function autoComState() {
            $reply['suggestions'] = $this->enquiry->autoComState($_GET['query']);
            echo json_encode($reply);
       }

       function delete($enqId, $callBack) {
            $enqId = encryptor($enqId, 'D');
            $callBack = encryptor($callBack, 'D');
            if (!empty($enqId) && $this->enquiry->permenentDelete($enqId)) {
                 $this->session->set_flashdata('app_success', 'Enguiry permenently deleted!');
            } else {
                 $this->session->set_flashdata('app_error', 'Error while delete enguiry!');
            }
            redirect($callBack);
       }

       public function bindModel($brdId = '', $dataType = 'json') {
            $id = isset($_POST['id']) ? $_POST['id'] : $brdId;
            $vehicle = $this->enquiry->getModelByBrand($id);
            if ($dataType == 'json') {
                 echo json_encode($vehicle);
            } else {
                 return $vehicle;
            }
       }

       function bindVarient($modelId = '', $dataType = 'json') {
            $id = isset($_POST['id']) ? $_POST['id'] : $modelId;
            $vehicle = $this->enquiry->getVariantByModel($id);
            if ($dataType == 'json') {
                 echo json_encode($vehicle);
            } else {
                 return $vehicle;
            }
       }

       function removeSaleOrPurchase($id) {

            if (!empty($id)) {
                 if ($this->enquiry->removeSaleOrPurchase($id)) {
                      echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
                 } else {
                      echo json_encode(array('status' => 'fail', 'msg' => "Can't delete this row"));
                 }
            } else {
                 return false;
            }
       }

       function bindSalesTable($id) {
            $data['vehicle'] = $this->evaluation->getEvaluation($id);
            $data['brands'] = $this->enquiry->getBrands();
            $msg = $this->load->view(__CLASS__ . '/tmp_' . __FUNCTION__, $data, true);
            echo json_encode(array('status' => 'success', 'msg' => $msg));
       }

       function changeStatus($enqId) {
            if (isset($_POST['status']) && !empty($_POST['status'])) {
                 $this->enquiry->changeStatus($enqId, $_POST['status']);
                 $this->session->set_flashdata('app_success', 'Status successfully changed!');
            } else {
                 $this->session->set_flashdata('app_error', 'Error while change status!');
            }
            echo json_encode(array('status' => 'success'));
       }

       function changeStatusRequest($status) {
            if ($status == 2) {
                 $data['title'] = 'Request for drop';
                 $this->page_title = 'Enquiry - Request for drop';
            } else if ($status == 4) {
                 $data['title'] = 'Request loss of sale or purchase';
                 $this->page_title = 'Enquiry - Request loss of sale or purchase';
            } else if ($status == 6) {
                 $data['title'] = 'Request for close';
                 $this->page_title = 'Enquiry - Request for close';
            } else if ($status == 8) {
                 $data['title'] = 'Request for delete';
                 $this->page_title = 'Enquiry - Request for delete';
            }
            $data['showroom'] = isset($_GET['showroom']) ? $_GET['showroom'] : '';
            $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
            $data['enq_date_from'] = (isset($_GET['enq_date_from']) && !empty($_GET['enq_date_from'])) ? $_GET['enq_date_from'] : '';
            $data['enq_date_to'] = (isset($_GET['enq_date_to']) && !empty($_GET['enq_date_to'])) ? $_GET['enq_date_to'] : '';
            $data['enqStatus'] = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
            $data['mode'] = isset($_GET['mode']) && !empty($_GET['mode']) ? $_GET['mode'] : '';
            $data['enquires'] = $this->enquiry->getRequestedEnquires('', $status, $_GET);
            $data['salesExecutives'] = $this->emp_details->salesExecutives();
            $data['allShowrooms'] = $this->showroom->get();
            $data['status'] = $status;
            $this->render_page(strtolower(__CLASS__) . '/specialRequestsList', $data);
       }

       function viewVehicleStatus($enq, $status = '') {
            if (!empty($enq)) {
                 $enq = encryptor($enq, 'D');
                 $data['enquiryDetails'] = $this->enquiry->getRequestedEnquires($enq, '');
                 $data['valuationVehicles'] = $this->evaluation->getOwnParkAndSaleCars();
                 $data['statusButtons'] = array();
                 if ($status == 8) {
                      $data['statusButtons'] = array(
                          array('id' => 1, 'title' => 'Cancel Request', 'buttonClass' => 'danger'),
                          array('id' => 99, 'title' => 'Delete', 'buttonClass' => 'success')
                      );
                 } else if ($status == 2) {
                      $data['statusButtons'] = array(
                          array('id' => 1, 'title' => 'Cancel Request', 'buttonClass' => 'danger'),
                          array('id' => 3, 'title' => 'Drop', 'buttonClass' => 'success')
                      );
                 } else if ($status == 6) {
                      $data['statusButtons'] = array(
                          array('id' => 1, 'title' => 'Cancel Request', 'buttonClass' => 'danger'),
                          array('id' => 7, 'title' => 'Close', 'buttonClass' => 'success')
                      );
                 } else if ($status == 4) {
                      $data['statusButtons'] = array(
                          array('id' => 1, 'title' => 'Loss confirmed', 'buttonClass' => 'danger'),
                          array('id' => 5, 'title' => 'Close', 'buttonClass' => 'success')
                      );
                 } else if(isset($data['enquiryDetails']['enq_current_status']) && $data['enquiryDetails']['enq_current_status'] == 3) { // Dropped case
                      $data['statusButtons'] = array(
                          array('id' => 1, 'title' => 'Reopening enquires', 'buttonClass' => 'danger')
                      );
                 }
                 $this->render_page(strtolower(__CLASS__) . '/vehicleStatus', $data);
            } if (!empty($_POST)) {
                 if ($this->followup->changeStatus($_POST)) {
                      $this->session->set_flashdata('app_success', 'Status changed successfully!');
                 } else {
                      $this->session->set_flashdata('app_error', 'Error occured!');
                 }
                 redirect(strtolower(__CLASS__) . '/viewVehicleStatus/' . encryptor($_POST['enh_enq_id']));
            } else {
                 //404
            }
       }

       function printTrackCard($enqid) {
            if (!is_numeric($enqid)) {
                 $enqid = encryptor($enqid, 'D');
            }
            $data['trackCard'] = $this->enquiry->getTrackCardDetails($enqid);
            $showroomId = get_logged_user('usr_showroom');
            $data['showRoom'] = $this->showroom->get($showroomId);
            $this->render_page(strtolower(__CLASS__) . '/tracking_card', $data);
       }

       function freezedEnquires() {
            $data['enquires'] = $this->enquiry->getFreezedEnquires();
            $this->render_page(strtolower(__CLASS__) . '/freezed', $data);
       }

       function freezeVehicle($enqId) {
            $enqId = encryptor($enqId, 'D');
            if (isset($_POST['status']) && !empty($_POST['status'])) {
                 $this->enquiry->changeStatus($enqId, $_POST['status']);
            } else {
                 $this->enquiry->changeStatus($enqId, 1);
            }
            echo json_encode(array('status' => 'success', 'msg' => 'Status successfully changed!'));
       }

       function assignenquires() {
            if (!empty($_POST)) {
                 $this->enquiry->assignEnquires($this->input->post());
                 die(json_encode(array('status' => 'success', 'msg' => 'Enquires moved successfully!')));
            } else {
                 $filterStatus = isset($_GET['status']) ? $_GET['status'] : 0;

                 $this->load->library("pagination");
                 $limit = 500;
                 $page = !isset($_GET['page']) ? 0 : $_GET['page'];
                 $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
                 $link = $linkParts[0];
                 $config = getPaginationDesign();

                 $data = $_GET;
                 $enquires = $this->enquiry->listEnqForAssign('', array(), $limit, $page, $_GET);
                 $data['enquires'] = $enquires['data'];

                 $config['page_query_string'] = TRUE;
                 $config['query_string_segment'] = 'page';
                 $config["base_url"] = $link;
                 $config["total_rows"] = $enquires['count'];
                 $config["per_page"] = $limit;
                 $config["uri_segment"] = 3;

                 /* Table info */
                 $page = empty($page) ? 30 : $page + 30;
                 $data['pageIndex'] = ($page) / 30;
                 $data['limit'] = $limit;
                 $data['totalRow'] = $enquires['count'];
                 /* Table info */

                 $this->pagination->initialize($config);
                 $data["links"] = $this->pagination->create_links();
                 $data['allShowrooms'] = $this->showroom->get();
                 $data['salesExecutives'] = $this->emp_details->salesExecutives();
                 $data['showroom'] = isset($_GET['showroom']) ? $_GET['showroom'] : '';
                 $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
                 $this->render_page(strtolower(__CLASS__) . '/assignenquires', $data);
            }
       }

       function permenentDelete($enqId) {
            $enqId = encryptor($enqId, 'D');
            if ($this->enquiry->permenentDelete($enqId)) {
                 echo json_encode(array('status' => 'success', 'msg' => "Enguiry permenently deleted!"));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Error occured!"));
            }
       }

       function myregister() {
            $this->page_title = "My register";
            $this->load->library("pagination");

            $limit = 10;
            $page = !isset($_GET['page']) ? 0 : $_GET['page'];
            $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
            $link = $linkParts[0];
            $config = getPaginationDesign();

            $data = $_GET;
            if (check_permission('enquiry', 'myregistercallanalysis')) {
                 $data['tc'] = $this->enquiry->registerTodaysanalysis();
                 $data['salesStaff'] = $this->registration->bindStaffsByShowroom(0);
            }
            $enquires = $this->enquiry->readVehicleReg(0, $limit, $page, $_GET);
            $data['datas'] = $enquires['data'];

            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config["base_url"] = $link;
            $config["total_rows"] = $enquires['count'];
            $config["per_page"] = $limit;
            $config["uri_segment"] = 3;

            /* Table info */
            $data['pageIndex'] = $page + 1;
            $data['limit'] = $page + $limit;
            $data['totalRow'] = number_format($enquires['count']);
            /* Table info */

            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();
            $data['departments'] = $this->departments->getData();
            $data['brand'] = $this->enquiry->getBrands();
            $data['staff'] = $this->emp_details->teleCallersSalesStaffs();
            $data['teleCallers'] = $this->emp_details->teleCallers();
            $this->render_page(strtolower(__CLASS__) . '/myregister', $data);
       }

       function regiter_2_inquiry($id) {
            $id = encryptor($id, 'D');
            $data['questions'] = $this->enquiry->getInquiryQuestions();
            $data['brands'] = $this->enquiry->getBrands();
            $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
            $data['salesExe'] = $this->emp_details->salesExecutives();
            $data['datas'] = $this->enquiry->readVehicleReg($id);
            $data['customerGrades'] = $this->customer_grade->get();
            $data['districts'] = $this->registration->getDistricts();
            $data['model'] = $this->enquiry->getModelByBrand($data['datas']['vreg_brand']);
            $data['variant'] = $this->enquiry->getVariantByModel($data['datas']['vreg_model']);
            $this->render_page(strtolower(__CLASS__) . '/regiter_2_inquiry', $data);
       }

       function registerExists() {
            $duplicate = $this->enquiry->registerExists($this->input->post('phoneNo'));
            if (!empty($duplicate)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Inquiry already associated with register'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => 'No inquiry already associated with this contact number'));
            }
       }

       function specialcomments($enqid) {
            $enqid = encryptor($enqid, 'D');
            $data['trackCard'] = $this->enquiry->getTrackCardDetails($enqid);
            $showroomId = get_logged_user('usr_showroom');
            $data['showRoom'] = $this->showroom->get($showroomId);
            $data['questions'] = $this->enquiry->getInquiryQuestions();
            //debug($data['questions']);
            $this->render_page(strtolower(__CLASS__) . '/specialcomments', $data);
       }

       public function punchEnquiry() {
            if (!empty($_POST)) {
                 generate_log(array(
                     'log_title' => 'Punch inquiry from register',
                     'log_desc' => serialize($_POST),
                     'log_controller' => 'punch-enq-from-reg',
                     'log_action' => 'C',
                     'log_ref_id' => 1212,
                     'log_added_by' => $this->uid
                 ));
                 $regAssignTo = isset($_POST['vreg_assigned_to']) ? $_POST['vreg_assigned_to'] : $this->uid;
                 $message = '';
                 if (isset($_POST['enquiry']['enq_entry_date']) && empty($_POST['enquiry']['enq_entry_date'])) {
                      $message = ' Please select inquiry date';
                 }
                 if (isset($_POST['enquiry']['enq_cus_name']) && empty($_POST['enquiry']['enq_cus_name'])) {
                      $message .= ' Please enter customer name';
                 }
                 if (isset($_POST['enquiry']['enq_cus_mobile']) && empty($_POST['enquiry']['enq_cus_mobile'])) {
                      $message .= ' Please enter valid mobile number';
                 }
                 if (isset($_POST['enquiry']['enq_cus_city']) && empty($_POST['enquiry']['enq_cus_city'])) {
                      $message .= ' Please enter place';
                 }
                 if (isset($_POST['enquiry']['enq_mode_enq']) && empty($_POST['enquiry']['enq_mode_enq'])) {
                      $message .= ' Please select mode of inquiry';
                 }
                 if (isset($_POST['enquiry']['enq_cus_when_buy']) && empty($_POST['enquiry']['enq_cus_when_buy'])) {
                      $message .= ' Please choose when would customer like to buy';
                 }
//                 $duplicate = $this->enquiry->registerExists($_POST['enquiry']['enq_cus_mobile']);
//                 if(!empty($duplicate)) {
//                      $message .= ' Inquiry already associated with register';
//                 }
                 if (empty($message)) {
                      $myname = get_logged_user('usr_username');
                      $mynumber = get_logged_user('usr_phone');
                      $mycustmr = trim($_POST['enquiry']['enq_cus_name']);
                      $message = "Hi Mr.$mycustmr
Greetings from Royal Drive South India's Largest Pre-Owned Luxury Car Showroom Thank you for the visit, We are grateful for serving you. 
My self $myname, Please feel free to contact me @ $mynumber. Regards, $myname info@royaldrive.in www.royaldrive.in App Link: http://onelink.to/p4z8q2";

                      if ($enquiryId = $this->enquiry->newEnquiry($_POST)) {
                           $this->enquiry->addEnquiryHistory(
                                   array(
                                       'enh_status' => 1,
                                       'enh_enq_id' => $enquiryId,
                                       'enh_added_by' => $this->uid,
                                       'enh_added_on' => date('Y-m-d h:i:s'),
                                       'enh_remarks' => 'Contact punched to enquiry',
                                       'enh_current_sales_executive' => $regAssignTo,
                                   )
                           );

                           if ($mobile_number = is_indian_number($_POST['enquiry']['enq_cus_mobile'])) {
                                send_sms($message, $mobile_number, 'sms-enquiry');
                           } else if ($mobile_number = is_indian_number($_POST['enquiry']['enq_cus_whatsapp'])) {
                                send_sms($message, $mobile_number, 'sms-enquiry');
                           }
                           $this->session->set_flashdata('app_success', 'New enguiry successfully added!');
                           echo json_encode(array('status' => 'success', 'msg' => 'New enguiry successfully added!'));
                      } else {
                           $this->session->set_flashdata('app_error', 'Error while create new enguiry!');
                           echo json_encode(array('status' => 'fail', 'msg' => 'Error while create new enguiry!'));
                      }
                 } else {
                      echo json_encode(array('status' => 'fail', 'msg' => $message));
                 }
            } else {
                 $data['brands'] = $this->enquiry->getBrands();
                 $data['questions'] = $this->enquiry->getInquiryQuestions();
                 $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
                 $data['salesExe'] = $this->emp_details->salesExecutives();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       function bindBrand($divisionId = '', $dataType = 'json') {
            $id = isset($_POST['id']) ? $_POST['id'] : $divisionId;
            $vehicle = $this->enquiry->getBrandByDivision($id);
            if ($dataType == 'json') {
                 echo json_encode($vehicle);
            } else {
                 return $vehicle;
            }
       }

       function bindShowroomByDivision() {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                 $showroom = $this->enquiry->bindShowroomByDivision($_POST['id']);
                 echo json_encode($showroom);
            }
       }

       function sendBackRegister() {
            generate_log(array(
                'log_title' => 'Send back register',
                'log_desc' => serialize($_POST),
                'log_controller' => 'reg-send-back',
                'log_action' => 'C',
                'log_ref_id' => 101010,
                'log_added_by' => $this->uid
            ));
            $this->enquiry->sendBackRegister($this->input->post());
            $this->session->set_flashdata('app_success', 'Register reassigned to telecaller, please inform them!');
            redirect(strtolower(__CLASS__) . '/myregister');
       }

       function quickfollowup() {
            $data['quickFollMaster'] = $this->enquiry->getQuickFollowupMaster();
            $this->render_page(strtolower(__CLASS__) . '/quickfollowupmaster', $data);
       }

       function quickfollowupDetails($id = 0) {
            $id = encryptor($id, 'D');
            $data['enquires'] = $this->enquiry->getQuickFollowupLeads($id);
            $this->render_page(strtolower(__CLASS__) . '/quickfollowup', $data);
       }

       function quickupdate() {
            if ($this->enquiry->quickupdate($_POST)) {
                 echo json_encode(array('msg' => 'Updated successfully'));
            } else {
                 echo json_encode(array('msg' => 'Error occure'));
            }
       }

       function myinquiresByStatus() {
            /* Pagination */
            $this->load->library("pagination");
            $limit = 10; //get_settings_by_key('pagination_limit');
            $page = !isset($_GET['page']) ? 0 : $_GET['page'];
            $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
            $link = $linkParts[0];
            $config = getPaginationDesign();

            $enquires = $this->enquiry->searchEnquiryByDateShowroomSe($limit, $page, $_GET);
            $data['searchResult'] = $enquires['data'];
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config["base_url"] = $link;
            $config["total_rows"] = $enquires['count'];
            $config["per_page"] = $limit;
            $config["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();
            $data['allShowrooms'] = $this->showroom->get();
            $data['salesExecutives'] = $this->emp_details->salesExecutives();
            $data['totalRows'] = $enquires['count'];

            $this->render_page(strtolower(__CLASS__) . '/myinquiresbystatus', $data);
       }

       function myinquiresByStatusExpExcel() {
            $enquires = $this->enquiry->myinquiresByStatusExpExcel($_GET);
            $this->load->library("excel");
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

            $heading = array('Customer', 'Customer Contact No', 'Mode of contact', 'Sales officer');

            //Loop Heading
            $rowNumberH = 1;
            $colH = 'A';
            foreach ($heading as $h) {
                 $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
                 $colH++;
            }

            //Loop Result
            $row = 2;
            $no = 1;
            $modeOfContact = unserialize(MODE_OF_CONTACT);
            if (!empty($enquires)) {
                 foreach ($enquires as $key => $value) {
                      $mod = isset($modeOfContact[$value['enq_mode_enq']]) ? $modeOfContact[$value['enq_mode_enq']] : '';
                      $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['enq_cus_name']);
                      $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['enq_cus_mobile']);
                      $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $mod);
                      $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['usr_username']);
                      $row++;
                      $no++;
                 }
            }
            //Save as an Excel BIFF (xls) file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="rdportal-myregister-report.xls"');
            header('Cache-Control: max-age=0');

            $objWriter->save('php://output');
            exit();
       }
       function selfregister() {
            $data['datas'] = $this->enquiry->selfregister();
            $this->render_page(strtolower(__CLASS__) . '/selfregister', $data);
       }
       
       function setRegisterFollowup() {
            if(isset($_POST['regfoll']) && !empty($_POST['regfoll'])) {
                 $this->enquiry->setRegisterFollowup($_POST);
                 echo json_encode(array('msg' => 'Register followup successfully updated'));
            }
       }

       public function export_excel() {

          generate_log(array(
              'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for my register on - ' . date('Y-m-d H:i:s'),
              'log_desc' => serialize($_GET),
              'log_controller' => 'exp-excel-my-register',
              'log_action' => 'R',
              'log_ref_id' => 1002,
              'log_added_by' => $this->uid
          ));

          $data['enq_date_from'] = $this->input->get('enq_date_from');
          $data['enq_date_to'] = $this->input->get('enq_date_to');
          $data['mode'] = $this->input->get('mode');
          $data['showroom'] = $this->input->get('showroom');
          $data['executive'] = $this->input->get('executive');
          $data['allShowrooms'] = $this->showroom->get();
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
          $this->page_title = 'List vehicle registration';
          $datas = $this->enquiry->readVehicleReg(0, 0, 0, $_GET);
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('My register');
          $heading = array('Entry date', 'Customer name', 'Contact', 'Location', 'Disctrict', 'Contact mode', 'Brand', 'Model', 'Variant',
              'Year', 'Investment', 'Call type', 'Department', 'Added by', 'Assigned to', 'Remarks', 'Sales officer comment');

          //Loop Heading
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }

          //Loop Result
          $row = 2;
          $no = 1;
          $modeOfContact = unserialize(MODE_OF_CONTACT);
          $callTypes = unserialize(CALL_TYPE);
                                                            
          if (isset($datas['data']) && !empty($datas['data'])) {
               foreach ($datas['data'] as $key => $value) {
                    $enqDate = !empty($value['vreg_entry_date']) ? date('j M Y', strtotime($value['vreg_entry_date'])) : '';
                    $contactMod = isset($modeOfContact[$value['vreg_contact_mode']]) ? $modeOfContact[$value['vreg_contact_mode']] : '';
                    $calType = isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $enqDate);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['vreg_cust_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['vreg_cust_phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['vreg_cust_place']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['std_district_name']); //Profession
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $contactMod); //Profession
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['brd_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['mod_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['vreg_year']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['vreg_investment']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $calType); //KM
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['dep_name']); //Finance
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['addedby_usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['assign_usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['vreg_customer_remark']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['vreg_last_action']);
                    $row++;
                    $no++;
               }
          }
          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="rdportal-myregister-report.xls"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
          exit();
     }

     function reassignenquiry() {
          $this->enquiry->reassignenquiry($_POST);
          redirect(strtolower(__CLASS__) . '/enquiry');
     }

     function chngquickfollowupsts($carId) {
          $carId = encryptor($carId, 'D');
          $ischecked = isset($_POST['ischecked']) ? $_POST['ischecked'] : 0;
          if ($this->common_model->changeStatus($carId, $ischecked, 'quick_tc_report_master', 'qtrm_status', 'qtrm_id')) {
               $logMessage = ($ischecked == 1) ? 'RD tele out for existing followup status activated' : 'RD tele out for existing followup status de-activated';
               generate_log(array(
                   'log_title' => 'Status changed',
                   'log_desc' => $logMessage,
                   'log_controller' => 'quick-followup-status-changed',
                   'log_action' => 'U',
                   'log_ref_id' => $carId,
                   'log_added_by' => $this->uid
               ));

               $msg = ($ischecked == 1) ? "Activated this record successfully" : "De-activated this record successfully";
               die(json_encode(array('status' => 'success', 'msg' => $msg)));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => "Error occured")));
          }
     }

     function getquickfollowupanalysis($masterId) {
          $data['enquires'] = $this->enquiry->getQuickFollowupLeadsAnalysis($masterId);
          $this->render_page(strtolower(__CLASS__) . '/quickfollowupanalysis', $data);
     }
} 