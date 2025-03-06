<?php

defined('BASEPATH') or exit('No direct script access allowed');

class followup extends App_Controller
{

     public function __construct()
     {

          parent::__construct();
          $this->page_title = 'followup';
          $this->load->model('followup_model', 'followup');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('evaluation/evaluation_model', 'evaluation');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $this->load->model('registration/registration_model', 'registration');
     }

     function precurementrqstlistExpExcel()
     {
          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for precurement request list - ' . date('Y-m-d H:i:s'),
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-proc-req',
               'log_action' => 'R',
               'log_ref_id' => 5,
               'log_added_by' => $this->uid
          ));
          $list = $this->followup->getPrequrementRqst(0, $_GET);
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $statuses = unserialize(ENQUIRY_UP_STATUS);
          $objPHPExcel->getActiveSheet()->setTitle('Precurement request');
          $heading = array('Vehicle', 'Sales staff', 'Added by', 'Customer', 'Cust number', 'Purchaase period', 'Added on');
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }
          $row = 2;
          $no = 1;
          $purchasePrd = unserialize(PURCHASE_PERIOD);
          if (!empty($list)) {
               foreach ($list as $key => $value) {
                    $salesStaff = $this->followup->getSalesStaff($value['enq_se_id']);
                    $now = date('Y-m-d');
                    $vehData = $this->common_model->getVehicleName($value['proc_brand'], $value['proc_model'], $value['proc_variant']);

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $vehData);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $salesStaff);

                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, ($value['proc_addded_by'] == $this->uid) ? 'Self' : $value['enq_added_by_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['enq_cus_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['enq_cus_mobile']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $purchasePrd[$value['proc_purchase_period']]);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, date('j M Y', strtotime($value['proc_added_on'])));
                    $row++;
                    $no++;
               }
          }
          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="rdportal-enquires-report.xls"');
          header('Cache-Control: max-age=0');

          $objWriter->save('php://output');
          exit();
          debug($list);
     }

     public function index()
     {
          // debug();
          $this->page_title = 'All followup';
          $this->load->library("pagination");
          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $followups = $this->followup->getFollowupEnquires('', $limit, $page, $_GET);

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
          if (check_permission('followup', 'showstffdropdownenqpool')) {
               $data['staffs'] = $this->followup->getStaffs();
          }
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }

     function viewFollowup($enqId)
     {
          //$this->db->cache_off();
          $data['statuses'] = $this->common_model->getStatuses('vehicle');
          $data['brands'] = array();
          if (check_permission($controller, 'submitprocrmntreq')) {
               $data['brands'] = $this->enquiry->getBrands();
          }
          $enqId = encryptor($enqId, 'D');
          $data['enqid'] = $enqId;
          if (!empty($enqId)) {
               $data['vehicles'] = $this->followup->getFollowupByEnquiry($enqId);
               
               $data['stockVehicles'] = $this->followup->getStockVehicles();
               $searchFor = 1;
               $data['companyVehicles'] = array_filter($data['stockVehicles'], function ($element) use ($searchFor) {
                    return isset($element['val_comp_stock']) && $element['val_comp_stock'] == $searchFor;
               });
               $data['enqHistory'] = $this->followup->getEnquiryHistory($enqId);
               $data['preferences'] = $this->followup->getPreferences($enqId);
               $data['staffs'] = $this->followup->getStaffs();
               $data['request']['assignto'] = isset($_GET['assignto']) ? $_GET['assignto'] : 0;
               if (is_roo_user()) {
                    $this->render_page(strtolower(__CLASS__) . '/followup_admin', $data);
               } else {
                    $this->render_page(strtolower(__CLASS__) . '/followup', $data);
               }
          } else {
               //404
          }
     }
     //test//
     function viewFollowup_($enqId)//New
     {
         // $data['statuses'] = $this->common_model->getStatuses('vehicle');//
          $enqId = encryptor($enqId, 'D');
          $data['enqid'] = $enqId;
          if (!empty($enqId)) {
               $data['enqInfo'] = $this->followup->getEnqInfo($enqId);
               //  print_r($data['enqInfo']); exit;
               //
               if (is_roo_user()) {
                    $this->render_page(strtolower(__CLASS__) . '/followup_admin', $data);
               } else {
                    $this->render_page(strtolower(__CLASS__) . '/followup_new', $data);
               }
   //

          } else {
               //404
          }
     }

//ajx
function get_followups_new($enqId){
     $data['brands'] = array();
     
     $data['staffs'] = $this->followup->getStaffs();
     $data['stockVehicles'] = $this->followup->getStockVehicles();
     $searchFor = 1;
     $data['companyVehicles'] = array_filter($data['stockVehicles'], function ($element) use ($searchFor) {
          return isset($element['val_comp_stock']) && $element['val_comp_stock'] == $searchFor;
     });
     $data['statuses'] = $this->common_model->getStatuses('vehicle');//
     if (check_permission($controller, 'submitprocrmntreq')) {
          $data['brands'] = $this->enquiry->getBrands();
     }
     if (!empty($enqId)) {
         $data['vehicles'] = $this->followup->getFollowupByEnquiry($enqId);
        // print_r($data['vehicles']); exit;
       //  $data['enq_id']=$enqId;
       

         $data['enqHistory'] = $this->followup->getEnquiryHistory($enqId);
         $data['preferences'] = $this->followup->getPreferences($enqId);
    
         $data['request']['assignto'] = isset($_GET['assignto']) ? $_GET['assignto'] : 0;

        //debug($data['vehicles']);
        $result = $this->load->view('ajx/view_followup', $data);//ajx_new
          return json_encode($result);
     } else {
          //404
     }
}

     //@test//

     function getSingleFollowup($custId, $date = '')
     {
          $custId = encryptor($custId, 'D');
          $data['followup'] = $this->followup->get($custId, $date);
          $data['enqId'] = $custId;
          $data['date'] = $date;
          $data['enquiry'] = $this->followup->getSingleFollowup($custId);
          $data['follimit'] = isset($data['enquiry']['enq_next_foll_date']) ?
               date('Y/m/d', strtotime($data['enquiry']['enq_next_foll_date'])) : date('Y/m/d');
          $data['latest'] = $this->followup->getLastRegisterRelatedToEnquiry($custId);
          $data['budgetRanges'] = $this->followup->budgetRanges();
          //$data['salesExe'] = $this->emp_details->salesExecutives();
          //   $data['salesExe'] = $this->registration->salesPurchaseExecutivesMyShowroom();
          $data['salesExe'] = $this->registration->salesPurchaseExecutivesAllShowroom();
          $data['division'] = $this->divisions->getActiveData();
          $data['assignto'] = isset($_GET['assignto']) ? $_GET['assignto'] : 0;
          $data['p'] = isset($_GET['p']) ? $_GET['p'] : 0;
          $html = $this->load->view(strtolower(__CLASS__) . '/view', $data, true);
          echo json_encode(array('status' => 'success', 'msg' => $html, 'data' => $data));
     }

     /* function getFollowup($vehId, $type = '') { 
            $data['vehId'] = $vehId;
            $vehId = encryptor($vehId, 'D');
            $data['type'] = $type;
            $data['statuses'] = $this->common_model->getStatuses('vehicle');
            $data['followup'] = $this->followup->getFollowup($vehId);
            $data['vehicle'] = $this->followup->getVehicle($vehId);
            $html = $this->load->view('temp_followup', $data, true);
            echo json_encode(array('status' => 'success', 'msg' => $html));
       }*/

     function addFollowUp()
     {
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

     function editFollowUp()
     {

          /**/
          $enqId = isset($_POST['foll_cus_id']) ? $_POST['foll_cus_id'] : 0;
          if (isset($_POST['quickfollowup'])) {
               $msg = isset($_POST['followup']['foll_remarks']) ? $_POST['followup']['foll_remarks'] : '';
               $this->followup->removeRow($_POST['quickfollowup'], $msg);
          }

          $_POST['followup']['foll_budget_from'] = !empty($_POST['followup']['foll_budget_from']) ? $_POST['followup']['foll_budget_from'] : 0;
          $_POST['followup']['foll_budget_to'] = !empty($_POST['followup']['foll_budget_to']) ? $_POST['followup']['foll_budget_to'] : 0;

          $_POST['followup']['foll_model_y_from'] = !empty($_POST['followup']['foll_model_y_from']) ? $_POST['followup']['foll_model_y_from'] : 0;
          $_POST['followup']['foll_model_y_to'] = !empty($_POST['followup']['foll_model_y_to']) ? $_POST['followup']['foll_model_y_to'] : 0;

          $_POST['followup']['foll_km_from'] = !empty($_POST['followup']['foll_km_from']) ? $_POST['followup']['foll_km_from'] : 0;
          $_POST['followup']['foll_km_to'] = !empty($_POST['followup']['foll_km_to']) ? $_POST['followup']['foll_km_to'] : 0;
          /**/
          $callback = (isset($_POST['cb'])) ? site_url(str_replace('-' . '/' . $_POST['cb'])) : '';
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
               $enqId = isset($_POST['foll_cus_id']) ? $_POST['foll_cus_id'] : 0;

               //Auto assign to SE from TC
               if (check_permission('followup', 'assignenquiresfromfollowup') || check_permission('followup', 'asgnenqtoslsstffthemself')) {
                    /* if (isset($_POST['vreg_showroom']) && !empty($_POST['vreg_showroom'])) {
                        $assignTo = $this->registration->getAutoAssignExecutive($_POST['vreg_showroom']);
                        $this->followup->assignTo($assignTo, $enqId);
                        } else if ($_POST['followup']['foll_status'] == 4 || $_POST['followup']['foll_status'] == 1) { //Hot+ OR Hot
                        $assignTo = $this->registration->getAutoAssignExecutive($this->shrm);
                        $this->followup->assignTo($assignTo, $enqId);
                        } */
                    if (isset($_POST['salesOfficers']) && !empty($_POST['salesOfficers'])) {
                         $reassignDatas['old_se_id'] = isset($_POST['txtSalesOfficer']) ? $_POST['txtSalesOfficer'] : '';
                         $reassignDatas['new_se_id'] = isset($_POST['salesOfficers']) ? $_POST['salesOfficers'] : '';
                         $reassignDatas['enq_id'] = $enqId;
                         $reassignDatas['remark'] = isset($_POST['remark']) ? $_POST['remark'] : '';
                         $this->enquiry->reassignenquiry($reassignDatas);
                         //$this->followup->assignTo($_POST['salesOfficers'], $enqId); Commentd on 20-05-2021 : 11:41 AM due to shoukath enq assigned to aswathi cold call
                    }
               }
               //Auto assign to SE from TC

               if ($this->followup->editFollowUp($_POST)) {
                    $this->session->set_flashdata('app_success', 'Customer feedback successfully added!');
                    echo json_encode(array('status' => 'success', 'msg' => 'Customer feedback successfully added!', 'cb' => $callback));
               } else {
                    $this->session->set_flashdata('app_error', 'Error occured!');
                    echo json_encode(array('status' => 'fail', 'msg' => 'Error occured!', 'cb' => $callback));
               }
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => $message, 'cb' => $callback));
          }
     }

     function running()
     {
          $followupsEnq = $this->followup->running();
          $data['vehicles'] = array();
          if (isset($followupsEnq['allVehiclToFollowup'])) {
               $data['vehicles'] = $followupsEnq['allVehiclToFollowup'];
               unset($followupsEnq['allVehiclToFollowup']);
          }
          $data['enquires'] = $followupsEnq;
          $this->render_page(strtolower(__CLASS__) . '/running', $data);
     }

     function missed()
     {
          $this->page_title = 'Missed followup';
          ini_set('memory_limit', '-1');

          $search = isset($_GET['search']) ? $_GET['search'] : '';
          $salesStaff = isset($_GET['enq_se_id']) ? $_GET['enq_se_id'] : 0;
          $this->load->library("pagination");
          $limit = get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $missedFoll = $this->followup->missed($search, $limit, $page, $salesStaff);
          $data['missedFoll'] = $missedFoll['data'];
          $data['missedCount'] = array();
          $data['missedCountYTD'] = array();
          if (check_permission('followup', 'missedfolloupcount')) {
               $data['missedCount'] = $this->followup->missedCount();
               $data['missedCountYTD'] = $this->followup->missedCountYTD();
          }

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
          if (check_permission('followup', 'showstffdropdownenqpool')) {
               $data['staffs'] = $this->followup->getStaffs();
          }
          $this->render_page(strtolower(__CLASS__) . '/missed', $data);
     }

     function missedtmp()
     {
          $this->page_title = 'Missed followup temp';
          $data['enquires'] = $this->followup->missedtemp();
          $this->render_page(strtolower(__CLASS__) . '/missed', $data);
     }

     function changeStatus()
     {
          $cb = isset($_POST['cb']) ? $_POST['cb'] : '';
          unset($_POST['cb']);
          if (isset($_POST['quickfollowup'])) {
               $msg = isset($_POST['enh_remarks']) ? $_POST['enh_remarks'] : '';
               $this->followup->removeRow($_POST['quickfollowup'], $msg);
               unset($_POST['quickfollowup']);
          }
          if ($this->followup->changeStatus($_POST, '')) {
               $this->session->set_flashdata('app_success', 'Status changed successfully!');
               $msg = isset($_POST['enh_remarks']) ? $_POST['enh_remarks'] : '';
               $enqId = isset($_POST['enh_enq_id']) ? $_POST['enh_enq_id'] : '';

               $status = $this->common_model->getStatusById($_POST['enh_status']);
               $stsmsg = isset($status['sts_des']) ? $status['sts_des'] : '';

               if ($enqId > 0) {
                    $this->followup->updateComments(array(
                         'foll_is_cmnt' => 1, 'foll_remarks' => $msg . ' ' . $stsmsg,
                         'foll_cus_id' => $enqId, 'foll_parent' => 0
                    ));
               }
          } else {
               $this->session->set_flashdata('app_error', 'Error occured!');
          }
          $enqId = isset($_POST['enh_enq_id']) ? $_POST['enh_enq_id'] : 0;

          $cb = !empty($cb) ? site_url(str_replace('-', '/', $cb)) : strtolower(__CLASS__) . '/viewFollowup/' . encryptor($enqId);
          redirect($cb);
     }

     function delete($follId)
     {
          $this->followup->db->where('foll_id', $follId);
          $this->followup->db->delete(TABLE_PREFIX . 'followup');
          echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
     }

     function resetMisdFollup()
     {
          $this->followup->resetMisdFollup($this->input->get(), $this->input->post('enqId'));
          echo json_encode(array('status' => 'success', 'msg' => 'Reset the followup'));
     }

     function getfollowupByDate($enqId)
     {
          $enqId = encryptor($enqId, 'D');
          $data = $this->followup->getfollowupByDate($enqId, $this->input->post());
          die(json_encode($data));
     }

     function quickUpdateFollowup()
     {
          if ($this->followup->quickUpdateFollowup($_POST)) {
               die(json_encode(array('status' => 'success', 'msg' => 'Followup updated successfully!')));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => 'Error occured on followup updated!')));
          }
     }

     function changeTestDriveHomeVisit($enqId, $type)
     {
          $type = encryptor($type, 'D');
          $enqId = encryptor($enqId, 'D');
          $msg = 'Inquiry home visit updated!';
          if ($type == 'enq_cus_test_drive') {
               $msg = 'Inquiry test trive updated!';
          }
          if ($this->followup->changeTestDriveHomeVisit($enqId, $type, $_POST)) {
               die(json_encode(array('status' => 'success', 'msg' => $msg)));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => 'Error occured on update field!')));
          }
     }

     function editEnquiryQuestions()
     {
          if ($this->followup->updateEnquiryQuestions($this->input->post())) {
               die(json_encode(array('status' => 'success', 'msg' => 'Inquiry questions updated')));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => 'Failed to update inquiry!')));
          }
     }

     function assignTo($assignTo, $enqId)
     {
          if (!empty($this->input->post())) {
               if ($assignTo > 0 && $enqId > 0) {
                    $this->followup->assignTo($assignTo, $enqId);
                    die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!')));
               } else {
                    die(json_encode(array('status' => 'fail', 'msg' => 'Failed to assign enquiry!')));
               }
          }
     }

     function todayfollowup()
     {
          $data['followups'] = $this->followup->todayfollowup();
          $data['enquires'] = $this->followup->getInquiryByDate();
          if (check_permission('notify_todayfollowup', 'showystrdayfollowup')) {
               $data['yesterdayFollowups'] = $this->followup->yesterdayFollowups();
          }
          $data['allHotAndHotPlusInquires'] = array();
          if (check_permission('notify_todayfollowup', 'showallhothotplus')) {
               $data['allHotAndHotPlusInquires'] = $this->followup->getAllHotAndHotPlusInquires();
          }
          $this->render_page(strtolower(__CLASS__) . '/todayfollowup', $data);
     }

     function followupCommenting($enqId)
     {
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

     function updateComments()
     {
          $redirect = '';
          if (isset($_POST['redirect'])) {
               $redirect = $_POST['redirect'];
               unset($_POST['redirect']);
          }

          $this->followup->updateComments($_POST);
          redirect(strtolower(__CLASS__) . '/viewFollowup/' . encryptor($_POST['foll_cus_id']));
     }

     function changehotwarmcold()
     {
          $this->followup->updateHotWarmCold($_POST);
          redirect(strtolower(__CLASS__) . '/viewFollowup/' . encryptor($_POST['foll_new_sts_enq_id']));
     }

     function follpend()
     {
          $f = $this->followup->follwanalysis();
          debug($f);
     }

     function missedexport()
     {
          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for missed followup on - ' . date('Y-m-d H:i:s'),
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-missed-follup',
               'log_action' => 'R',
               'log_ref_id' => 1090,
               'log_added_by' => $this->uid
          ));

          $data = $this->followup->missedexport($_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $heading = array('Customer', 'Customer Contact No', 'Sales Officer', 'Next followup date');

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
          if (isset($data) && !empty($data)) {
               foreach ($data as $key => $value) {
                    $enqDate = !empty($value['enq_next_foll_date']) ? date('d-m-Y', strtotime($value['enq_next_foll_date'])) : '';
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['enq_cus_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['enq_cus_mobile']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['enq_added_by_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $enqDate);
                    $row++;
                    $no++;
               }
          }
          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="missed-followup-report.xls"');
          header('Cache-Control: max-age=0');

          $objWriter->save('php://output');
          exit();
     }

     public function add_preference()
     {
          $data['count'] = $_GET['count'];
          $result = $this->load->view('preference_ajax', $data);
          return json_encode($result);
     }

     public function append_pref_flds()
     {
          $data['preference'] = $_GET['prefernce'];
          $data['count'] = $_GET['count'];
          $data['states'] = $this->followup->getStates();
          $data['colors'] = $this->followup->getColors();
          $data['rto'] = $this->followup->getRto();
          $result = $this->load->view('pref_flds_ajax', $data);
          return json_encode($result);
     }

     public function submit_preference()
     {
          if ($this->followup->addPreference($_POST)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Success fully added!'));
          }
     }

     public function enquiryPreference()
     {
          $this->page_title = 'All customer preference';
          $data['preferences'] = $this->followup->getPreferences();
          $this->render_page(strtolower(__CLASS__) . '/preference_list', $data);
     }

     public function submitProcrmntReq()
     {
          if ($this->followup->addProcReq($_POST)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Submitted procurement request!'));
          }
     }

     public function precurementRqstList()
     {
          $this->page_title = 'Precurement requests';
          $data['precurement_rqst'] = $this->followup->getPrequrementRqst(0, $_GET);
          $data['salesExecutives'] = $this->emp_details->salesExecutivesByShowroom($this->shrm);
          $this->render_page(strtolower(__CLASS__) . '/procurement_rq_list', $data);
     }

     public function precurementRqstDetails($id)
     {
          $this->page_title = 'Precurement request details';
          if ($id) {
               $id = encryptor($id, 'D');
               $data['statuses'] = $this->common_model->getStatuses('proc-rq-sts');
               $data['precurementRqst'] = $this->followup->getPrequrementRqst($id, array());
               $data['prcStatus'] = array();
               if (check_permission('followup', 'showprocurementcomments')) {
                    $data['prcStatus'] = $this->followup->getProcStatus($data['precurementRqst']['proc_id']);
               }
               $this->followup->UpdatePrequrementRqst($data['precurementRqst']);
               $this->render_page(strtolower(__CLASS__) . '/procurement_rq_details', $data);
          }
     }

     public function procChangeStatus()
     {
          if ($this->followup->addProcStatus($_POST)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Posted your comments'));
          }
     }
     //home visit//
     function storeHomeVisit()
     {
          //debug($_POST);
          //header("Access-Control-Allow-Methods: POST, OPTIONS");
          //header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
          generate_log(array(
               'log_title' => 'Home visit Req pre insert',
               'log_desc' => serialize($_POST),
               'log_controller' => 'submit-hom-vist-pre-insert',
               'log_action' => 'C',
               'log_ref_id' => 0,
               'log_added_by' => $this->uid
          ));
          if ($this->followup->addHomeVisit($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }

     function home_visit()
     { //list_home_visit
          $data['hmv_date_from'] = (isset($_GET['hmv_date_from']) && !empty($_GET['hmv_date_from'])) ? $_GET['hmv_date_from'] : '';
          $data['hmv_date_to'] = (isset($_GET['hmv_date_to']) && !empty($_GET['hmv_date_to'])) ? $_GET['hmv_date_to'] : '';
          $data['homeVisits'] = $this->followup->getHomeVisitList($_GET);
          //debug($data['homeVisits']);
          $this->render_page(strtolower(__CLASS__) . '/list_home_visit', $data);
     }

     function edit_home_visit($hmv_id)
     {
          if ($hmv_id) {
               $id = encryptor($hmv_id, 'D');
               $data['homeVisit'] = $this->followup->getHomeVisit($id);
               $data['approval'] = $this->followup->checkHomeVisitApprovals($id);
               $html = $this->load->view(strtolower(__CLASS__) . '/update_home_visit', $data, true);
               echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));
          }
     }

     function update_home_visit()
     {
          if ($this->followup->updateHomeVisit($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }

     function home_visit_approval_req()
     { //list_home_visit
          $data['homeVisits'] = $this->followup->getHomeVisitApprovelReq();
          // debug($data['homeVisits']);getHomeVisitApprovelReq
          $this->render_page(strtolower(__CLASS__) . '/list_home_visit_approval_req', $data);
     }

     function edit_home_visit_approval($hmv_id)
     {
          if ($hmv_id) {
               $id = encryptor($hmv_id, 'D');
               $data['homeVisit'] = $this->followup->getHomeVisit($hmv_id);
               $data['approval'] = $this->followup->checkHomeVisitApprovals($id);
               //debug($data);
               $html = $this->load->view(strtolower(__CLASS__) . '/update_home_visit_approval_req', $data, true);
               echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));
          }
     }

     function update_home_visit_approval()
     {
          if ($this->followup->updateHomeVisitApproval($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }

     function home_visit_approved_req()
     { //list_home_visit
          $data['homeVisits'] = $this->followup->getHomeVisitApprovedReq();
          //debug($data['homeVisits']);
          $this->render_page(strtolower(__CLASS__) . '/list_home_visit_approved_req', $data);
     }
     function home_visit_report()
     {
          $data['staff'] = $this->emp_details->teleCallersSalesStaffs();
          $data['homeVisits'] = $this->followup->getHomeVisitReport($_GET);
          $this->render_page(strtolower(__CLASS__) . '/list_home_visit_report', $data);
     }
     //@home visit//


     public function test()
     {
          // debug();
    
          $this->render_page(strtolower(__CLASS__) . '/test');
     }
     public function test2()
     {
          // debug();
    
          $this->render_page(strtolower(__CLASS__) . '/test2');
     }

}
