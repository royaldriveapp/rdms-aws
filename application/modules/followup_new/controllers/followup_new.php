<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class followup_new extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'followup';
            $this->load->model('followup_model', 'followup');
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            $this->load->model('divisions/divisions_model', 'divisions');
            $this->load->model('evaluation_new/evaluation_model', 'evaluation');
            $this->load->model('emp_details/emp_details_model', 'emp_details');
            $this->load->model('registration/registration_model', 'registration');
       }

       public function indexOld() {
            $this->page_title = 'All followup';
            $data['enquires'] = $this->followup->getFollowupEnquires();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }
       public function index() {
          //debug(2132);
          $this->page_title = 'All followup';
          $this->load->library("pagination");
          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $followups = $this->followup->getFollowupEnquires('', $limit, $page);

          $data['enquires'] = $followups['data'];
          $config['page_query_string'] = TRUE;
          $config['query_string_segment'] = 'page';
          $config["base_url"] = $link;
          $config["total_rows"] = $followups['count'];
          $config["per_page"] = $limit;
          $config["uri_segment"] = 3;

          /* Table info */
          $data['pageIndex'] = $page + 1;
          $data['limit'] = $page + $limit;
          $data['totalRow'] = number_format($followups['count']);
          /* Table info */

          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }

       function viewFollowup($enqId) {
            $data['statuses'] = $this->common_model->getStatuses(array('vehicle', 'inquiry'));
            $data['brands'] = $this->enquiry->getBrands();
            $enqId = encryptor($enqId, 'D');
            $data['enqid'] = $enqId;
            $data['states'] = $this->followup->getStates();
            if (!empty($enqId)) {
                 $data['vehicles'] = $this->followup->getFollowupByEnquiry($enqId);
                 //debug($data['vehicles']);
                 $data['enqHistory'] = $this->followup->getEnquiryHistory($enqId);
                 $data['preferences'] = $this->followup->getPreferences($enqId);
                 $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
                 $data['staffs'] = $this->followup->getStaffs();
                 if (is_roo_user()) {
                      $this->render_page(strtolower(__CLASS__) . '/followup_admin', $data);
                 } else {
                      $this->render_page(strtolower(__CLASS__) . '/followup', $data);
                 }
            } else {
                 //404
            }
       }

       function getSingleFollowup($custId, $date = '', $enqType = '') {
            $custId = encryptor($custId, 'D');
            $data['followup'] = $this->followup->get($custId, $date);
            $data['enqId'] = $custId;
            $data['date'] = $date;
            $data['enquiry'] = $this->enquiry->enquires($custId);
            $data['latest'] = $this->followup->getLastRegisterRelatedToEnquiry($custId);
            //$data['salesExe'] = $this->emp_details->salesExecutives();
            $data['salesExe'] = $this->registration->getAllStaffInSales();
            $data['division'] = $this->divisions->getActiveData();
            $data['controller'] = strtolower(__CLASS__);
            $data['statuses'] = $this->common_model->getStatuses(array('vehicle', 'inquiry'));
            $data['enqType'] = $enqType;
            $html = $this->load->view(strtolower(__CLASS__) . '/view', $data, true);
            echo json_encode(array('status' => 'success', 'msg' => $html));
       }

       function getFollowup($vehId, $type = '') {
            $data['vehId'] = $vehId;
            $vehId = encryptor($vehId, 'D');
            $data['type'] = $type;
            $data['statuses'] = $this->common_model->getStatuses('vehicle');
            $data['followup'] = $this->followup->getFollowup($vehId);
            $data['vehicle'] = $this->followup->getVehicle($vehId);
            $html = $this->load->view('temp_followup', $data, true);
            echo json_encode(array('status' => 'success', 'msg' => $html));
       }

       function addFollowUp() {
            $type = '';
            if (isset($_POST['type'])) {
                 $type = $_POST['type'];
                 unset($_POST['type']);
            }

            if ($this->followup->addFollowUp($this->input->post('followup'))) {
                 $this->session->set_flashdata('app_success', 'Row successfully added!');
            } else {
                 $this->session->set_flashdata('app_error', 'Error occured!');
            }
            $enqId = isset($_POST['followup']['foll_cus_id']) ? $_POST['followup']['foll_cus_id'] : 0;
            $vehId = isset($_POST['followup']['foll_cus_vehicle_id']) ? $_POST['followup']['foll_cus_vehicle_id'] : 0;
            redirect(strtolower(__CLASS__) . '/viewFollowup/' . encryptor($enqId) . '/' . encryptor($vehId) . '/' . $type);
       }

       function editFollowUp() {

            /**/
            $enqId = isset($_POST['foll_cus_id']) ? $_POST['foll_cus_id'] : 0;
            if (isset($_POST['quickfollowup'])) {
                 //$msg = isset($_POST['followup']['foll_remarks']) ? $_POST['followup']['foll_remarks'] : '';
                 $msg = @array_values($_POST['foll_customer_feedback'])[0];
                 $this->followup->removeRow($_POST['quickfollowup'], $msg);
            }
            /**/

            if (isset($_POST['quickfollowup'])) {
                 $message = '';
                 if (!isset($_POST['followup']['foll_status']) || empty($_POST['followup']['foll_status'])) {
                      $message = 'Please select any status';
                 }
                 if (!isset($_POST['followup']['foll_contact']) || empty($_POST['followup']['foll_contact'])) {
                      $message .= ' Please select any mode of contact';
                 }
                 if (!isset($_POST['followup']['foll_action_plan']) || empty($_POST['followup']['foll_action_plan'])) {
                      $message .= ' Please enter action plan';
                 }
                 if (!isset($_POST['followup']['foll_next_foll_date']) || empty($_POST['followup']['foll_next_foll_date'])) {
                      $message .= ' Please enter next folloup date';
                 }
                 if (!isset($_POST['followup']['foll_remarks']) || empty($_POST['followup']['foll_remarks'])) {
                      $message .= ' Please enter remark';
                 }
                 if (empty($message)) {
                      //Auto assign to SE from TC
                      if (check_permission('followup', 'assignenquiresfromfollowup')) {
                           /* if (isset($_POST['vreg_showroom']) && !empty($_POST['vreg_showroom'])) {
                             $assignTo = $this->registration->getAutoAssignExecutive($_POST['vreg_showroom']);
                             $this->followup->assignTo($assignTo, $enqId);
                             } else if ($_POST['followup']['foll_status'] == 4 || $_POST['followup']['foll_status'] == 1) { //Hot+ OR Hot
                             $assignTo = $this->registration->getAutoAssignExecutive($this->shrm);
                             $this->followup->assignTo($assignTo, $enqId);
                             } */
                           if (isset($_POST['salesOfficers']) && !empty($_POST['salesOfficers'])) {
                                $this->followup->assignTo($_POST['salesOfficers'], $enqId);
                           }
                      }
                      //Auto assign to SE from TC

                      if ($this->followup->editFollowUp($_POST)) {
                           $this->session->set_flashdata('app_success', 'Customer feedback successfully added!');
                           echo json_encode(array('status' => 'success', 'msg' => 'Customer feedback successfully added!'));
                      } else {
                           $this->session->set_flashdata('app_error', 'Error occured!');
                           echo json_encode(array('status' => 'fail', 'msg' => 'Error occured!'));
                      }
                 } else {
                      echo json_encode(array('status' => 'fail', 'msg' => $message));
                 }
            }
       }

       function running() {
            $followupsEnq = $this->followup->running();
            $data['vehicles'] = array();
            if (isset($followupsEnq['allVehiclToFollowup'])) {
                 $data['vehicles'] = $followupsEnq['allVehiclToFollowup'];
                 unset($followupsEnq['allVehiclToFollowup']);
            }
            $data['enquires'] = $followupsEnq;
            $this->render_page(strtolower(__CLASS__) . '/running', $data);
       }

       function missedtmp() {
            $this->page_title = 'Missed followup temp';
            $data['enquires'] = $this->followup->missedtemp();
            $this->render_page(strtolower(__CLASS__) . '/missed', $data);
       }

       function changeStatus() {
            $cb = isset($_POST['cb']) ? $_POST['cb'] : '';
            unset($_POST['cb']);
            if (isset($_POST['quickfollowup'])) {
                 $msg = isset($_POST['enh_remarks']) ? $_POST['enh_remarks'] : '';
                 $this->followup->removeRow($_POST['quickfollowup'], $msg);
                 unset($_POST['quickfollowup']);
            }
            if ($this->followup->changeStatus($_POST)) {
                 $this->session->set_flashdata('app_success', 'Status changed successfully!');
                 $msg = isset($_POST['enh_remarks']) ? $_POST['enh_remarks'] : '';
                 $enqId = isset($_POST['enh_enq_id']) ? $_POST['enh_enq_id'] : '';

                 $status = $this->common_model->getStatusById($_POST['enh_status']);
                 $stsmsg = isset($status['sts_des']) ? $status['sts_des'] : '';

                 if ($enqId > 0) {
                      $this->followup->updateComments(array('foll_is_cmnt' => 1, 'foll_remarks' => $msg . ' ' . $stsmsg,
                          'foll_cus_id' => $enqId, 'foll_parent' => 0));
                 }
            } else {
                 $this->session->set_flashdata('app_error', 'Error occured!');
            }
            $enqId = isset($_POST['enh_enq_id']) ? $_POST['enh_enq_id'] : 0;

            $cb = !empty($cb) ? site_url(str_replace('-', '/', $cb)) : strtolower(__CLASS__) . '/viewFollowup/' . encryptor($enqId);
            redirect($cb);
       }

       function delete($follId) {
            $this->followup->db->where('foll_id', $follId);
            $this->followup->db->delete(TABLE_PREFIX . 'followup');
            echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
       }

       function resetMisdFollup() {
            $this->followup->resetMisdFollup($this->input->get(), $this->input->post('enqId'));
            echo json_encode(array('status' => 'success', 'msg' => 'Reset the followup'));
       }

       function getfollowupByDate($enqId) {
            $enqId = encryptor($enqId, 'D');
            $data = $this->followup->getfollowupByDate($enqId, $this->input->post());
            die(json_encode($data));
       }

       function quickUpdateFollowup() {
            if ($this->followup->quickUpdateFollowup($_POST)) {
                 die(json_encode(array('status' => 'success', 'msg' => 'Followup updated successfully!')));
            } else {
                 die(json_encode(array('status' => 'fail', 'msg' => 'Error occured on followup updated!')));
            }
       }

       function changeTestDriveHomeVisit($enqId, $type) {
            $type = encryptor($type, 'D');
            $enqId = encryptor($enqId, 'D');
            $msg = 'Inquiry home visit updated!';
            if ($type == 'enq_cus_test_drive') {
                 $msg = '<h5 class="lbl">Inquiry test drive updated!</h5>';
            }
            if ($this->followup->changeTestDriveHomeVisit($enqId, $type, $_POST)) {
                 die(json_encode(array('status' => 'success', 'msg' => $msg)));
            } else {
                 die(json_encode(array('status' => 'fail', 'msg' => 'Error occured on update field!')));
            }
       }

       function editEnquiryQuestions() {
            if ($this->followup->updateEnquiryQuestions($this->input->post())) {
                 die(json_encode(array('status' => 'success', 'msg' => 'Inquiry questions updated')));
            } else {
                 die(json_encode(array('status' => 'fail', 'msg' => 'Failed to update inquiry!')));
            }
       }

       function assignTo($assignTo, $enqId) {
            if (!empty($this->input->post())) {
                 if ($assignTo > 0 && $enqId > 0) {
                      $this->followup->assignTo($assignTo, $enqId);
                      die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!')));
                 } else {
                      die(json_encode(array('status' => 'fail', 'msg' => 'Failed to assign enquiry!')));
                 }
            }
       }

       function todayfollowup() {
            $data['followups'] = $this->followup->todayfollowup();
            $data['enquires'] = $this->followup->getInquiryByDate();
            $data['allHotAndHotPlusInquires'] = array();
            if (check_permission('notify_todayfollowup', 'showallhothotplus')) {
                 $data['allHotAndHotPlusInquires'] = $this->followup->getAllHotAndHotPlusInquires();
            }
            $this->render_page(strtolower(__CLASS__) . '/todayfollowup', $data);
       }

       function followupCommenting($enqId) {
            $this->page_title = 'Followup comments';
            $this->load->model('designation/designation_model', 'designation');
            $enqId = encryptor($enqId, 'D');
            $data['enqid'] = $enqId;
            if (!empty($enqId)) {
                 $data['vehicles'] = $this->followup->getFollowupByEnquiry($enqId);
                 $data['stockVehicles'] = $this->followup->getStockVehicles();
                 $data['designation'] = $this->designation->getData();
                 $data['enqHistory'] = $this->followup->getEnquiryHistory($enqId);
                 $this->render_page(strtolower(__CLASS__) . '/followupCommenting', $data);
            } else {
                 //404
            }
       }

       function updateComments() {
            $redirect = '';
            if (isset($_POST['redirect'])) {
                 $redirect = $_POST['redirect'];
                 unset($_POST['redirect']);
            }

            $this->followup->updateComments($_POST);
            redirect(strtolower(__CLASS__) . '/viewFollowup/' . encryptor($_POST['foll_cus_id']));
       }

       function changehotwarmcold() {
            $this->followup->updateHotWarmCold($_POST);
            redirect(strtolower(__CLASS__) . '/viewFollowup/' . encryptor($_POST['foll_new_sts_enq_id']));
       }

       function changevehicle() {
            $enqId = isset($_POST['newvehicle']['enq_id']) ? $_POST['newvehicle']['enq_id'] : 0;
            $this->followup->changevehicle($_POST);
            redirect(strtolower(__CLASS__) . '/viewFollowup/' . encryptor($enqId));
       }

       function missed() {
            $this->page_title = 'Missed followup';
            ini_set('memory_limit', '-1');

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $this->load->library("pagination");
            $limit = get_settings_by_key('pagination_limit');
            $page = !isset($_GET['page']) ? 0 : $_GET['page'];
            $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
            $link = $linkParts[0];
            $config = getPaginationDesign();

            $data = $_GET;
            $missedFoll = $this->followup->missed($search, $limit, $page);
            $data['missedFoll'] = $missedFoll['data'];
            $data['missedCount'] = $this->followup->missedCount();

            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config["base_url"] = $link;
            $config["total_rows"] = $missedFoll['count'];
            $config["per_page"] = $limit;
            $config["uri_segment"] = 3;
            /* Table info */
            $data['pageIndex'] = $page + 1;
            $data['limit'] = $page + $limit;
            $data['totalRow'] = number_format($missedFoll['count']);
            /* Table info */
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();
            $this->render_page(strtolower(__CLASS__) . '/missed', $data);
       }

       function reserveVehicleView($enqId) {
            $enqId = encryptor($enqId, 'D');
            $data['stockVehicles'] = $this->followup->getStockVehicles();
            $data['enqId'] = $enqId;
            $html = $this->load->view(strtolower(__CLASS__) . '/ajx_reservationform_1', $data, true);
            die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
       }

       function bindVehicleDetails($vehId, $enqId) {
            $vehId = encryptor($vehId, 'D');
            $enqId = encryptor($enqId, 'D');
            $this->load->model('evaluation/evaluation_model', 'evaluation');
            $data['enquiry'] = $this->enquiry->enquires($enqId);
            $data['vehicles'] = $this->evaluation->getEvaluationPrint($vehId);
            $data['addressProof'] = $this->followup->getActiveAddressProof();
            $html = $this->load->view(strtolower(__CLASS__) . '/ajx_reservationform_2', $data, true);
            die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
       }

       function reserveVehicle() {
            $reserveMasterId = $this->followup->reserveVehicle($_POST);
            if (!empty($_FILES)) {
                 $docNos = isset($_FILES['vbd_doc_file']['name']) ? $_FILES['vbd_doc_file']['name'] : 0;
                 if ($docNos > 0) {
                      for ($i = 0; $i < $docNos; $i++) {
                           $newFileName = rand() . $_FILES['vbd_doc_file']['name'][$i];
                           $config['upload_path'] = '../assets/uploads/documents/inquiry/';
                           $config['allowed_types'] = '*';
                           $config['file_name'] = $newFileName;
                           $this->upload->initialize($config);
                           $_FILES['prd_image_tmp']['name'] = $_FILES['vbd_doc_file']['name'][$i];
                           $_FILES['prd_image_tmp']['type'] = $_FILES['vbd_doc_file']['type'][$i];
                           $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['vbd_doc_file']['tmp_name'][$i];
                           $_FILES['prd_image_tmp']['error'] = $_FILES['vbd_doc_file']['error'][$i];
                           $_FILES['prd_image_tmp']['size'] = $_FILES['vbd_doc_file']['size'][$i];

                           if ($this->upload->do_upload('prd_image_tmp')) {
                                $uploadData = $this->upload->data();
                           } else {
                                $uploadData = $this->upload->display_errors();
                                debug($uploadData);
                           }
                      }
                 }
            }
       }

       public function add_preference() {
            $data['count'] = $_GET['count'];
            $result = $this->load->view('preference_ajax', $data);
            return json_encode($result);
       }

       public function append_pref_flds() {
            $data['preference'] = $_GET['prefernce'];
            $data['count'] = $_GET['count'];
            $data['states'] = $this->followup->getStates();
            $data['colors'] = $this->followup->getColors();
            $data['rto'] = $this->followup->getRto();
            // debug($data['rto']);
            $result = $this->load->view('pref_flds_ajax', $data);
            return json_encode($result);
       }

       public function submit_preference() {
            if ($this->followup->addPreference($_POST)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Success fully added!'));
            }
       }

       public function enquiryPreference() {
            $this->page_title = 'All customer preference';
            $data['preferences'] = $this->followup->getPreferences();
            $this->render_page(strtolower(__CLASS__) . '/preference_list', $data);
       }

       public function submitProcrmntReq() {
            if ($this->followup->addProcReq($_POST)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Submitted procurement request!'));
            }
       }

       public function precurementRqstList() {
            $this->page_title = 'Precurement requests';
            $data['precurement_rqst'] = $this->followup->getPrequrementRqst();
            $this->render_page(strtolower(__CLASS__) . '/procurement_rq_list', $data);
       }

       public function precurementRqstDetails($id) {
            if ($id) {
                 $id = encryptor($id, 'D');
                 $data['statuses'] = $this->common_model->getStatuses('proc-rq-sts');
                 $this->page_title = 'Precurement request details';
                 $data['precurementRqst'] = $this->followup->getPrequrementRqst($id);
                 $data['prcStatus'] = array();
                 if (check_permission('followup', 'showprocurementcomments')) {
                      $data['prcStatus'] = $this->followup->getProcStatus($data['precurementRqst']['proc_id']);
                 }
                 $this->followup->UpdatePrequrementRqst($data['precurementRqst']);
                 $this->render_page(strtolower(__CLASS__) . '/procurement_rq_details', $data);
            }
       }

       public function procChangeStatus() {
            if ($this->followup->addProcStatus($_POST)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Posted your comments'));
            }
       }

       function changeEnqStatus() {
            //echo json_encode(array('status' => 'jhjhj', 'msg' =>  'hsadhsaj'));
            //exit;
            //debug($_POST);
            $cb = isset($_POST['cb']) ? $_POST['cb'] : '';
            unset($_POST['cb']);
            if (isset($_POST['quickfollowup'])) {
                 $msg = isset($_POST['enh_remarks']) ? $_POST['enh_remarks'] : '';
                 $this->followup->removeRow($_POST['quickfollowup'], $msg);
                 unset($_POST['quickfollowup']);
            }
            if ($this->followup->changeEnqStatus($_POST)) {
                 //$this->session->set_flashdata('app_success', 'Status changed successfully!');
                 $message = 'Status changed successfully!';

                 $msg = isset($_POST['enh_remarks']) ? $_POST['enh_remarks'] : '';
                 $enqId = isset($_POST['enh_enq_id']) ? $_POST['enh_enq_id'] : '';

                 $status = $this->common_model->getStatusById($_POST['enh_status']);
                 $stsmsg = isset($status['sts_des']) ? $status['sts_des'] : '';
                 $status = 'success';
                 if ($enqId > 0) {
                      $this->followup->updateComments(array('foll_is_cmnt' => 1, 'foll_remarks' => $msg . ' ' . $stsmsg,
                          'foll_cus_id' => $enqId, 'foll_parent' => 0));
                 }
            } else {

                 //$this->session->set_flashdata('app_error', 'Error occured!');
                 $message = 'Error occured!!';
                 $status = 'Error';
            }
            $enqId = isset($_POST['enh_enq_id']) ? $_POST['enh_enq_id'] : 0;
            echo json_encode(array('status' => $status, 'msg' => $message));

//          $cb = !empty($cb) ? site_url(str_replace('-', '/', $cb)) : strtolower(__CLASS__) . '/viewFollowup/' . encryptor($enqId);
//          redirect($cb);
       }

       function append_lost_flds() {
            // debug($_GET['enqType']);
            $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
            $data['enqType'] = $_GET['enqType'];
            $data['brands'] = $this->enquiry->getBrands();
            $html = $this->load->view(strtolower(__CLASS__) . '/ajx_lost_flds', $data);
            return json_encode($html);
       }

       function storeHomeVisit() {
            if ($this->followup->addHomeVisit($_POST)) {
                 $message = 'successfully Added!';

                 echo json_encode($message);
            }
       }

       function home_visit() {//list_home_visit
            $data['homeVisits'] = $this->followup->getHomeVisit();
            //debug($data['homeVisits']);
            $this->render_page(strtolower(__CLASS__) . '/list_home_visit', $data);
       }

       function edit_home_visit($hmv_id) {
            if ($hmv_id) {
                 $id = encryptor($hmv_id, 'D');
                 $data['homeVisit'] = $this->followup->getHomeVisit($id);
                 $data['approval'] = $this->followup->checkHomeVisitApprovals($id);
                 $html = $this->load->view(strtolower(__CLASS__) . '/update_home_visit', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));
            }
       }

       function update_home_visit() {
           // debug($_POST);
            if ($this->followup->updateHomeVisit($_POST)) {
                 $message = 'successfully Added!';
                 echo json_encode($message);
            }
       }

       function home_visit_approval_req() {//list_home_visit
            $data['homeVisits'] = $this->followup->getHomeVisitApprovelReq();
            // debug($data['homeVisits']);getHomeVisitApprovelReq
            $this->render_page(strtolower(__CLASS__) . '/list_home_visit_approval_req', $data);
       }

       function edit_home_visit_approval($hmv_id) {
                        if ($hmv_id) {
                 $id = encryptor($hmv_id, 'D');
                 $data['homeVisit'] = $this->followup->getHomeVisit($hmv_id);
                 $data['approval'] = $this->followup->checkHomeVisitApprovals($id);
                 //debug($data);
                 $html = $this->load->view(strtolower(__CLASS__) . '/update_home_visit_approval_req', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));
            }
       }

       function update_home_visit_approval() {
            if ($this->followup->updateHomeVisitApproval($_POST)) {
                 $message = 'successfully Added!';
                 echo json_encode($message);
            }
       }

       function home_visit_approved_req() {//list_home_visit
            $data['homeVisits'] = $this->followup->getHomeVisitApprovedReq();
            //debug($data['homeVisits']);
            $this->render_page(strtolower(__CLASS__) . '/list_home_visit_approved_req', $data);
       }

       function change_veh_form($veh_type, $veh_id, $veh_enq_id, $veh_brand, $veh_model, $veh_varient, $veh_details, $veh_reg_no = '') {
            if ($veh_type) {
                 $id = encryptor($veh_type, 'D');
                 $data['veh_type'] = encryptor($veh_type, 'D');
                 $data['veh_id'] = encryptor($veh_id, 'D');
                 $data['veh_enq_id'] = encryptor($veh_enq_id, 'D');
                 $data['veh_brand'] = encryptor($veh_brand, 'D');
                 $data['veh_model'] = encryptor($veh_model, 'D');
                 $data['veh_varient'] = encryptor($veh_varient, 'D');
                 $data['veh_details'] = encryptor($veh_details, 'D');
                 $data['veh_reg_no'] = encryptor($veh_reg_no, 'D');
                 $data['brands'] = $this->enquiry->getBrands();
                 $html = $this->load->view(strtolower(__CLASS__) . '/ajx_frorm_change_veh', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));
            }
       }

       function bindPitchedVehForm($id) {
            $data['vehicle'] = $this->evaluation->getEvaluation($id);
            // debug($data['vehicle'] );
            $data['brands'] = $this->enquiry->getBrands();
            $html = $this->load->view(__CLASS__ . '/ajx_pitched_veh_form', $data, true);
            echo json_encode(array('status' => 'success', 'msg' => $html));
       }

       function store_change_vehicle() {
            if ($this->followup->addChangedVehicle($_POST)) {
                 $message = 'successfully Added!';
                 echo json_encode($message);
            }
       }

       function storeTestDrive() {
            if ($this->followup->addTestDrive($_POST)) {
                 $message = 'successfully Added!';
                 echo json_encode($message);
            }
       }

       function test_drive_approval_req() {
            $data['testDrives'] = $this->followup->getTestDriveApprovelReq();
            //debug($data['testDrives']);
            $this->render_page(strtolower(__CLASS__) . '/list_test_drive_approval_req', $data);
       }

       function edit_test_drive_approval($tdrv_id) {
            if ($tdrv_id) {
                 $id = encryptor($tdrv_id, 'D');
                 $data['homeVisit'] = $this->followup->getTestDriveApprovelReq($tdrv_id);
                 $data['approval'] = $this->followup->checkTestDriveApprovals($id);
                 $html = $this->load->view(strtolower(__CLASS__) . '/update_test_drive_approval_req', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));
            }
       }

       function update_test_drive_approval() {
            if ($this->followup->updateTestDriveApproval($_POST)) {
                 $message = 'successfully Added!';
                 echo json_encode($message);
            }
       }

       function test_drive() {//list_home_visit
            $data['testDrives'] = $this->followup->getTestDrive();
            //debug($data['testDrives']);
            $this->render_page(strtolower(__CLASS__) . '/list_test_drive', $data);
       }

       function edit_test_drive($hmv_id) {
            if ($hmv_id) {
                 $id = encryptor($hmv_id, 'D');
                 $data['testDrive'] = $this->followup->getTestDrive($id);
                 // debug( $data['testDrive']);
                 $data['approval'] = $this->followup->checkTestDriveApprovals($id);
                 $html = $this->load->view(strtolower(__CLASS__) . '/update_test_drive', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));
            }
       }

       function placesApi($param = '') {

            //https://maps.googleapis.com/maps/api/place/autocomplete/json?input=1600+Amphitheatre&key=<API_KEY>&sessiontoken=1234567890
            //  https://maps.googleapis.com/maps/api/place/autocomplete/json?input=india+kerala+malappuram+tirur&key=AIzaSyAf3gJYTfwcOwOzxarOZy1gZ8sglHVCkKk
            //AIzaSyAf3gJYTfwcOwOzxarOZy1gZ8sglHVCkKk
            //https://maps.googleapis.com/maps/api/geocode/json?address=vailathur+malappuram&key=AIzaSyAf3gJYTfwcOwOzxarOZy1gZ8sglHVCkKk
            //$terms = $_GET['data'];
            // $terms="india+kerala+malappuram+tanalur";
            $terms = "tirur";
//$data = file_get_contents("https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".$terms."&types=geocode&key=AIzaSyAf3gJYTfwcOwOzxarOZy1gZ8sglHVCkKk");
//json_decode($data)->predictions;
            $data = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $terms . "&key=AIzaSyAf3gJYTfwcOwOzxarOZy1gZ8sglHVCkKk");
            debug($data);
            $arr = array();
            $i = 0;
            foreach (json_decode($data)->predictions as $item) {
                 $arr[$i] = array(
// 'id' => $i,
                     'id' => $item->place_id,
                     'text' => $item->description
                 );
                 $i++;
            }
            debug($arr);
            echo json_encode($arr);
       }

       function placeid_to_lat_long($param = '') {//geometry details from placeid
            $data = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJwVaf2WiypzsRGM3OAhEhUSE&key=AIzaSyAf3gJYTfwcOwOzxarOZy1gZ8sglHVCkKk");
            debug(json_decode($data)->result->geometry->location);
       }

       function enquiryfollowup() {
            $this->page_title = "Register followup";
            $this->render_page(strtolower(__CLASS__) . '/enquiryfollowup');
       }

       function enquiryfollowup_ajax() {
            $response = $this->followup->enquiryfollowup_ajax($this->input->post());
            echo json_encode($response);
       }
        function home_visit_report() {
                $data['staff'] = $this->emp_details->teleCallersSalesStaffs();
                    $data['homeVisits'] = $this->followup->getHomeVisitReport($_GET);
            //debug($data['homeVisits']);
            $this->render_page(strtolower(__CLASS__) . '/list_home_visit_report', $data);
       }
         function home_visit_against_enq() {
                    $data['homeVisits'] = $this->followup->getHomeVisitVsEnq();
            //debug($data['homeVisits']);
            $this->render_page(strtolower(__CLASS__) . '/list_home_visit_report', $data);
       }

  }
  