<?php

defined('BASEPATH') or exit('No direct script access allowed');

class registration extends App_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('registration_model', 'registration');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $this->load->model('events/events_model', 'events');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('departments/departments_model', 'departments');
          $this->load->model('webenquires/webenquires_model', 'webenquires');
          $this->load->model('lms/lms_model', 'lms');
     }

     public function index()
     {
          $this->page_title = 'List vehicle registration';
          $data['enq_date_from'] = $this->input->get('enq_date_from');
          $data['enq_date_to'] = $this->input->get('enq_date_to');
          $data['mode'] = $this->input->get('mode');
          $data['showroom'] = $this->input->get('showroom');
          $data['executive'] = $this->input->get('executive');
          $data['allShowrooms'] = $this->showroom->get();
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
          $data['datas'] = $this->registration->readVehicleReg('', $_GET);
          $data['analysis'] = $this->registration->todayAnalysis();
          $data['departments'] = $this->departments->getData();
          $data['brand'] = $this->enquiry->getBrands();
          $_GET['vreg_brand'] = isset($_GET['vreg_brand']) ? $_GET['vreg_brand'] : 0;
          $_GET['vreg_model'] = isset($_GET['vreg_model']) ? $_GET['vreg_model'] : 0;
          $data['model'] = $this->enquiry->getModelByBrand($_GET['vreg_brand']);
          $data['variant'] = $this->enquiry->getVariantByModel($_GET['vreg_model']);
          $this->render_page(strtolower(__CLASS__) . '/reg_vehicle_list', $data);
     }

     public function export_excel()
     {
          $this->page_title = 'List vehicle registration';
          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for my register',
               'log_desc' => $this->session->userdata('usr_username') . ' downloaded excel report for my register on - ' . date('Y-m-d H:i:s'),
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
          $datas = $this->registration->readVehicleReg('', $_GET);
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

          $heading = array(
               'Date',
               'Customer',
               'Customer Contact No',
               'Location',
               'Profession',
               'Brand',
               'Model',
               'Variant',
               'Budget',
               'Year',
               'KM',
               'Finance',
               'Exchange',
               'Department',
               'Mode of contact',
               'Assigned by',
               'Assigned to',
               'Customer remark',
               'Executive remarks'
          );

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
          if (!empty($datas)) {
               foreach ($datas as $key => $value) {
                    $enqDate = !empty($value['vreg_entry_date']) ? date('d-m-Y', strtotime($value['vreg_entry_date'])) : '';
                    $contactMod = isset($modeOfContact[$value['vreg_contact_mode']]) ? $modeOfContact[$value['vreg_contact_mode']] : '';
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $enqDate);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['vreg_cust_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['vreg_cust_phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['vreg_cust_place']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, ''); //Profession
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['brd_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['mod_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['vreg_investment']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['vreg_year']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, ''); //KM
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, ''); //Finance
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, ''); //Exchange
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['dep_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $contactMod);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['addedby_usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['assign_usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['vreg_customer_remark']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value['vreg_last_action']);
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

     public function add_old($voxBayId = 0, $teleType = 1)
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
               if ($this->registration->create($_POST)) {
                    $this->session->set_flashdata($msgType, $msg);
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Vehicle!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $this->page_title = 'New vehicle registration';

               $this->load->model('voxbay/voxbay_model', 'voxbay');
               $voxbayContact = $this->voxbay->readVoxBayCall($voxBayId);

               $customerNumber = isset($voxbayContact['ccb_callerNumber']) ? $voxbayContact['ccb_callerNumber'] : '';
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

               $data['voxbayId'] = isset($voxbayContact['ccb_id']) ? $voxbayContact['ccb_id'] : 0;
               $data['teleType'] = isset($teleType) ? $teleType : 1; //1 = telein, 2 = teleout
               $data['events'] = $this->events->read();
               $data['brand'] = $this->enquiry->getBrands();
               $data['division'] = $this->divisions->getActiveData();
               $data['salesExe'] = $this->registration->getAllStaffInSales();
               $data['districts'] = $this->registration->getDistricts();
               $data['mod'] = isset($_GET['mod']) ? $_GET['mod'] : 0;
               $data['reghistory'] = $this->registration->matchingRegister($customerNumber);
               $data['telesalescoo'] = $this->registration->telesalesCoordinator();
               $this->render_page(strtolower(__CLASS__) . '/reg_vehicle', $data);
          }
     }

   public function add($voxBayId = 0, $teleType = 1)
     { //jsk
        //  debug($_POST);

        $msgType = 'app_success';
          $msg = 'Register successfully added!';

          // Check if dropped
          // TODO: will delete in future
          //            $isDroppedCase = $this->registration->getEnquiryByMobile($this->input->post('vreg_cust_phone'));
          //            $status = ($isDroppedCase['enq_current_status']) ? $isDroppedCase['enq_current_status'] : 0;
          //            if($status == 3) { 
          //                 $this->session->set_flashdata('app_error', "This enquiry already dropped!");
          //                 redirect(strtolower(__CLASS__));
          //            }
          // Check if dropped

          if (!empty($_POST)) {
            //
            try {
            //
               // if($this->uid==358){
               //      debug($_POST,1);
               //                }
               //      $this->form_validation->set_rules('vreg_brand', 'Brand', 'required');
               //      $this->form_validation->set_rules('vreg_model', 'Model', 'required');
               //      $this->form_validation->set_rules('vreg_cust_phone', 'Phone ', 'required');
               //      $this->form_validation->set_rules('vreg_division', 'Division ', 'required');
               //      $this->form_validation->set_rules('vreg_showroom', 'Showroom ', 'required');
               //      $this->form_validation->set_rules('vreg_department', 'Departments ', 'required');
               //      $this->form_validation->set_rules('vreg_contact_mode', 'Mode of contact', 'required');
               //      //$this->form_validation->set_rules('vreg_call_type', 'Lead type ', 'required');
               //      $this->form_validation->set_rules('vreg_entry_date', 'Entry date', 'required');

               //      $this->form_validation->set_rules('vreg_cust_name', 'Customer name', 'required');
               //      $this->form_validation->set_rules('vreg_district', 'District ', 'required');
               //      $this->form_validation->set_rules('vreg_occupation', 'Occupation', 'required');
               //      $this->form_validation->set_rules('vreg_year', 'Year', 'required|numeric|xss_clean');

               //      $this->form_validation->set_rules('vreg_assigned_to', 'Assigned to', 'required');
               //     // $this->form_validation->set_rules('vreg_customer_remark', 'Customer remarks', 'required');

               // if ($this->form_validation->run() == false) {
               //      $errs = validation_errors();
               //      $this->session->set_flashdata('f_err', $errs);
               //      redirect(current_url(), 'refresh');
               //      debug('error');
               // }
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
               $_POST['vreg_cust_phone'] = isset($_POST['vreg_cust_phone']) ? str_replace(' ', '', trim($_POST['vreg_cust_phone'])) : '';
               $_POST['vreg_cust_phone'] = str_replace('+', '', $_POST['vreg_cust_phone']);
               $duplicate = $this->registration->matchingInquiry($this->input->post('vreg_cust_phone'));
               if (!empty($duplicate)) {
                    $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                    $userId = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                    //$_POST['vreg_assigned_to'] = $userId;
                    $msg = 'Inquiry already associated with sales executive ' . $se;
                    $msgType = 'app_success_pop';
               }
               //                 }

               /*rfrl*/
               if ($_POST['referal_type'] == 4) { //Rd staff
                    // unset($_POST['referal_name1']);
                    unset($_POST['referal_name3']);
                    unset($_POST['referal_phone3']);
                    unset($_POST['referal_phone2']);
                    unset($_POST['referal_name2']);
                    $_POST['vreg_referal_name'] = $_POST['referal_name1'];
                    unset($_POST['referal_name1']);
                    $_POST['vreg_referal_phone'] = $_POST['referal_phone1'];
                    unset($_POST['referal_phone1']);
                    $_POST['vreg_referal_type'] = $_POST['referal_type'];
                    unset($_POST['referal_type']);
                    unset($_POST['referal_enq_cus_id']);
               } elseif ($_POST['referal_type'] == 5) { //RD Customer
                    unset($_POST['referal_name1']);
                    unset($_POST['referal_phone1']);
                    unset($_POST['referal_name3']);
                    unset($_POST['referal_phone3']);
                    $_POST['vreg_referal_phone'] = $_POST['referal_phone2'];
                    unset($_POST['referal_phone2']);
                    $_POST['vreg_referal_name'] = $_POST['referal_name2'];
                    unset($_POST['referal_name2']);
                    $_POST['vreg_referal_type'] = $_POST['referal_type'];
                    unset($_POST['referal_type']);
                    $_POST['vreg_referal_enq_id'] = $_POST['referal_enq_cus_id'];
                    unset($_POST['referal_enq_cus_id']);
               } else {
                    unset($_POST['referal_name1']);
                    unset($_POST['referal_phone1']);
                    unset($_POST['referal_phone2']);
                    unset($_POST['referal_name2']);
                    $_POST['vreg_referal_phone'] = $_POST['referal_phone3'];
                    unset($_POST['referal_phone3']);
                    $_POST['vreg_referal_name'] = $_POST['referal_name3'];
                    unset($_POST['referal_name3']);
                    $_POST['vreg_referal_type'] = $_POST['referal_type'];
                    unset($_POST['referal_type']);
                    unset($_POST['referal_enq_cus_id']);
               }
               /* @rfrl*/
               if ($this->registration->create($_POST)) {
                    $this->session->set_flashdata($msgType, $msg);
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Vehicle!");
               }
               /* Send WhatsApp message */
            //    if (isset($_POST['vreg_cust_phone']) && !empty($_POST['vreg_cust_phone'])) {
            //         $campaignName = 'vb_walkin';
            //         if ($_POST['vreg_contact_mode'] != 9) {
            //              $campaignName = 'vb_inbound';
            //         }
            //         $apiData = array(
            //              "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
            //              "campaignName" => $campaignName,
            //              'destination' => $_POST['vreg_cust_phone'],
            //              'userName' => 'royaldrive9090@gmail.com'
            //         );
            //         $data_string = json_encode($apiData);
            //         $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
            //         curl_setopt_array($ch, array(
            //              CURLOPT_POST => true,
            //              CURLOPT_POSTFIELDS => $data_string,
            //              CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
            //              CURLOPT_RETURNTRANSFER => true
            //         ));
            //         $result = curl_exec($ch);
            //    }
               /* Send WhatsApp message */
               redirect(strtolower(__CLASS__));
// 
}
catch (Exception $e) {
    log_message('error', $e->getMessage());
    show_error($e->getMessage(), 500);
}
// 

          } else {
               $this->page_title = 'New vehicle registration';

               $this->load->model('voxbay/voxbay_model', 'voxbay');
               $voxbayContact = $this->voxbay->readVoxBayCallForRegister($voxBayId);

               $customerNumber = isset($voxbayContact['ccb_callerNumber']) ? $voxbayContact['ccb_callerNumber'] : '';
               $getPhoneNumber = isset($_GET['phone']) ? $_GET['phone'] : '';
               $data['customerNumber'] = !empty($customerNumber) ? $customerNumber : $getPhoneNumber;

               if (isset($data['customerNumber']) && !empty($data['customerNumber'])) {
                    $duplicate = $this->registration->matchingInquiry($data['customerNumber']);
                    if (!empty($duplicate)) {
                         $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                         $sts = isset($duplicate['sts_title']) ? $duplicate['sts_title'] : '';

                         $data['usrId'] = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                         $trackCard = ' <a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($duplicate['enq_id'])) . '"><i title="Track card" class="fa fa-list"></i></a>';
                         $data['ifEnqAlready'] = 'Inquiry already associated with sales executive ' . $se . ' Track card : ' . $trackCard . '<br> current status is ' . $sts . ' if drop or lost then reopen to show in myregister';
                    }
               }

               $data['voxbayId'] = isset($voxbayContact['ccb_id']) ? $voxbayContact['ccb_id'] : 0;
               $data['teleType'] = isset($teleType) ? $teleType : 1; //1 = telein, 2 = teleout
               $data['events'] = $this->events->read();
               $data['brand'] = $this->enquiry->getBrands();
               $data['division'] = $this->divisions->getActiveData();
               $data['salesExe'] = $this->registration->getAllStaffInSales();

               $data['districts'] = $this->registration->getDistricts();
               $data['mod'] = isset($_GET['mod']) ? $_GET['mod'] : 0;
               $data['reghistory'] = $this->registration->matchingRegister($customerNumber);
               $data['telesalescoo'] = $this->registration->telesalesCoordinator();
               $data['sources'] = $this->lms->getSourceMasters();
               $data['mode_of_contact'] = $this->registration->modeOfContact();
               //  $data['mode_of_contact']=$this->registration->modeOfContact();
               //Fetch mandatory fields
               $results = array_values(array_filter($this->mandatory['fields'], function ($people) {
                    return $people['d_id'] == $this->desi_id;
               }));
               $data['mandatory'] = isset($results[0]['content']) ? explode(',', $results[0]['content']) : '';
               //print_r($data['mandatory']);
               $this->render_page(strtolower(__CLASS__) . '/reg_vehicle', $data);
          }
     }

     public function view($id)
     {
          $this->page_title = 'Edit quick vehicle registration';
          $id = encryptor($id, 'D');
          $data['events'] = $this->events->read();
          $data['brand'] = $this->enquiry->getBrands();
          $data['data'] = $this->registration->readVehicleReg($id);
          $data['model'] = $this->enquiry->getModelByBrand($data['data']['vreg_brand']);
          $data['variant'] = $this->enquiry->getVariantByModel($data['data']['vreg_model']);
          $data['division'] = $this->divisions->getData();
          $data['showroom'] = $this->registration->getShowRoomByDivision($data['data']['vreg_division']);
          $data['department'] = $this->registration->getDepartmentByDivision($data['data']['vreg_division']);
          //debug($data['department']);
          //$data['salesExe'] = $this->registration->getAllStaffInSales();
          $data['salesExe'] = $this->getStaffsByShowroom($data['data']['vreg_showroom'], false);
          $data['telesalescoo'] = $this->registration->telesalesCoordinator();
          $data['districts'] = $this->registration->getDistricts();
          $data['rdStaffs'] = $this->registration->bindAllRdStaffs();
          //debug($data);
          $this->render_page(strtolower(__CLASS__) . '/reg_vehicle_edit', $data);
     }

     public function update()
     {
          $callback = "";
          if (isset($_POST['callback'])) {
               $callback = $_POST['callback'];
               unset($_POST['callback']);
          }
          if (!empty($_POST)) {
               $vregId = isset($_POST['vreg_id']) ? $_POST['vreg_id'] : 0;
               generate_log(array(
                    'log_title' => 'Contact punching (Registration) updation',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'punch-registration-edit',
                    'log_action' => 'U',
                    'log_ref_id' => $vregId,
                    'log_added_by' => $this->uid
               ));
          }
          if ($this->registration->update($_POST)) {
               $this->session->set_flashdata('app_success', 'Row successfully updated!');
          } else {
               $this->session->set_flashdata('app_error', "Can't update row!");
          }
          if (!empty($callback)) {
               redirect($callback);
          } else {
               redirect(strtolower(__CLASS__));
          }
     }

     public function delete($id)
     {
          if ($this->registration->delete($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete row"));
          }
     }

    

     function approveReopenedInquires($enqId = '')
     {
          $this->page_title = 'Pending rescheduled inquires';

          if (!empty($_POST)) {
               $this->registration->approvalForReschedule($_POST);
               $this->session->set_flashdata('app_success', 'Registration successfully verified!');
               redirect(strtolower(__CLASS__));
          } else if (!empty($enqId)) {
               $enqId = encryptor($enqId, 'D');
               $data['salesExe'] = $this->emp_details->getAutoAssignedMenbers();
               $data['data'] = $this->registration->getPendingReopendInquires($enqId);
               $this->render_page(strtolower(__CLASS__) . '/approveReopenedInquires', $data);
          }
     }

     function registerbystatus($status = 0)
     {
          $data['datas'] = $this->registration->registerbystatus(0, array('ststus' => $status));
          $this->render_page(strtolower(__CLASS__) . '/regbystatus', $data);
     }

     function changeRegisterStatus()
     {
          //           if($this->uid==100){
          // debug($_POST);
          //           }
          if (isset($_POST['regMaster']) && !empty($_POST['regMaster'])) {
               generate_log(array(
                    'log_title' => 'Change Register Status',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'change-register-status-drop-req',
                    'log_action' => 'C',
                    'log_ref_id' => $_POST['regMaster'],
                    'log_added_by' => $this->uid
               ));
               $this->registration->reqToDropRegister($this->input->post());
               $this->session->set_flashdata('app_success', 'Dropped the register');
               echo json_encode(array('status' => 'success', 'msg' => 'Register request dropped'));
               redirect($this->input->post('callback'));
          }
     }

     function waitingForReply()
     {
          $this->page_title = 'List vehicle registration | waiting for replay';
          $data['datas'] = $this->registration->waitingForReply();
          $this->render_page(strtolower(__CLASS__) . '/waitingforreply', $data);
     }

     function informStockToCustomer()
     {
          $data['datas'] = $this->registration->informStockToCustomer();
          $this->render_page(strtolower(__CLASS__) . '/informStockToCustomer', $data);
     }

     function reassign($id)
     {
          if (!empty($_POST)) {
               $vregId = isset($_POST['vreg_id']) ? $_POST['vreg_id'] : 0;
               generate_log(array(
                    'log_title' => 'Contact reassign (Registration)',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'reassign-registration',
                    'log_action' => 'U',
                    'log_ref_id' => $vregId,
                    'log_added_by' => $this->uid
               ));

               if ($this->registration->reassign($_POST)) {
                    $this->session->set_flashdata('app_success', 'Row successfully updated!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't update row!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $id = encryptor($id, 'D');
               $data['events'] = $this->events->read();
               $data['brand'] = $this->enquiry->getBrands();
               $data['data'] = $this->registration->readVehicleReg($id);
               $data['model'] = $this->enquiry->getModelByBrand($data['data']['vreg_brand']);
               $data['variant'] = $this->enquiry->getVariantByModel($data['data']['vreg_model']);
               $data['division'] = $this->divisions->getData();
               $data['showroom'] = $this->registration->getShowRoomByDivision($data['data']['vreg_division']);
               $data['department'] = $this->registration->getDepartmentByDivision($data['data']['vreg_division']);
               $data['salesExe'] = $this->registration->getAllStaffInSales();
               $this->render_page(strtolower(__CLASS__) . '/reassign', $data);
          }
     }

     function getStaffsByShowroom($id = 0, $json = true)
     {
          // fetch staffs by showroom 
          $_POST['id'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : $id;
          $_POST['did'] = (isset($_POST['dept']) && !empty($_POST['dept'])) ? $_POST['dept'] : 0;
          if (isset($_POST['id']) && !empty($_POST['id'])) {
               $staffs = $this->registration->bindStaffsByShowroom($_POST['id'], $_POST['did']);
               if ($json) {
                    echo json_encode($staffs);
               } else {
                    return $staffs;
               }
          }
     }
     function getStaffsByShowroom_test($id = 0, $json = true)
     {
          // fetch staffs by showroom 
          $_POST['id'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : $id;
          if (isset($_POST['id']) && !empty($_POST['id'])) {
               $staffs = $this->registration->bindStaffsByShowroom_test($_POST['id']);
               if ($json) {
                    debug($staffs);
                    echo json_encode($staffs);
               } else {
                    return $staffs;
               }
          }
     }

     function reassignedregisters()
     {
          $data['reassignedcounts'] = $this->registration->reassignedregisters();
          $this->render_page(strtolower(__CLASS__) . '/reassignedregisters', $data);
     }
     function reassignedregistersdetails($id)
     {
          $id = encryptor($id, 'D');
          $data['datas'] = $this->registration->reassignedregisters($id);
          $this->render_page(strtolower(__CLASS__) . '/reassignedregistersdetails', $data);
          /* Code compare completed */
     }
     function droppedregisters()
     {
          $this->page_title = 'List vehicle registration';
          $this->load->library("pagination");

          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();
          $filter = $_GET;
          $filter['ststus'] = reg_droped;
          $data = $this->registration->registerbystatus(0, $filter, $limit, $page);
          $config['page_query_string'] = TRUE;
          $config['query_string_segment'] = 'page';
          $config["base_url"] = $link;
          $config["total_rows"] = $data['count'];
          $config["per_page"] = $limit;
          $config["uri_segment"] = 3;
          $this->pagination->initialize($config);

          $data['pageIndex'] = $page + 1;
          $data['limit'] = $page + $limit;
          $data['totalRow'] = number_format($data['count']);
          $data["links"] = $this->pagination->create_links();
          $this->render_page(strtolower(__CLASS__) . '/droppedregisters', $data);
     }

     function reopen($id = 0)
     {
          if (!empty($_POST)) {
               $this->registration->reopen($this->input->post());
               $this->session->set_flashdata('app_error', "Register successfully reopen");
               redirect(strtolower(__CLASS__) . '/droppedregisters');
          } else {
               $id = encryptor($id, 'D');
               $data['data'] = $this->registration->readVehicleRegDetails($id);
               $data['salesExe'] = $this->registration->getAllStaffInSales();
               $data['histry'] = $this->registration->getLastDroppedHistory($id);
               $this->render_page(strtolower(__CLASS__) . '/reopen', $data);
          }
     }
     function registerCourtesyCall($day = 1)
     {
          $data['datas'] = $this->registration->registerCourtesyCall($day);
          $this->render_page(strtolower(__CLASS__) . '/register_courtesy_call', $data);
     }

     function updateRegisterCourtesyCall()
     {
          $this->registration->updateRegisterCourtesyCall($this->input->post());
          redirect(strtolower(__CLASS__) . '/registerCourtesyCall');
     }

     function eventlistener()
     {
          $data['datas'] = $this->registration->eventlistener();
          $this->render_page(strtolower(__CLASS__) . '/eventlistener', $data);
     }

     function punchEnquiry($enqId = 0)
     {

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

               $_POST['vreg_cust_phone'] = isset($_POST['vreg_cust_phone']) ? str_replace(' ', '', trim($_POST['vreg_cust_phone'])) : '';
               $duplicate = $this->registration->matchingInquiry($this->input->post('vreg_cust_phone'));
               if (!empty($duplicate)) {
                    $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                    $userId = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                    $msg = 'Inquiry already associated with sales executive ' . $se;
                    $msgType = 'app_success_pop';
               }
               if ($this->registration->create($_POST)) {
                    $this->session->set_flashdata($msgType, $msg);
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Vehicle!");
               }
               redirect(strtolower(__CLASS__));
          } else {

               $this->page_title = 'New vehicle registration';

               $voxbayContact = $this->registration->readEventRegister($enqId);

               $customerNumber = isset($voxbayContact['eve_mobile']) ? $voxbayContact['eve_mobile'] : '';
               $getPhoneNumber = isset($_GET['phone']) ? $_GET['phone'] : '';
               $data['customerNumber'] = !empty($customerNumber) ? $customerNumber : $getPhoneNumber;
               $data['customerLocation'] = !empty($voxbayContact['eve_location']) ? $voxbayContact['eve_location'] : '';
               $data['customerName'] = !empty($voxbayContact['eve_name']) ? $voxbayContact['eve_name'] : '';
               $data['customerEmail'] = !empty($voxbayContact['eve_email']) ? $voxbayContact['eve_email'] : '';
               $data['mode_of_contact'] = $this->registration->modeOfContact();
               if (isset($data['customerNumber']) && !empty($data['customerNumber'])) {
                    $duplicate = $this->registration->matchingInquiry($data['customerNumber']);
                    if (!empty($duplicate)) {
                         $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                         $data['usrId'] = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                         $trackCard = ' <a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($duplicate['enq_id'])) . '"><i title="Track card" class="fa fa-list"></i></a>';
                         $data['ifEnqAlready'] = 'Inquiry already associated with sales executive ' . $se . ' Track card : ' . $trackCard;
                    }
               }

               $data['voxbayId'] = isset($voxbayContact['eve_id']) ? $voxbayContact['eve_id'] : 0;
               $data['teleType'] = isset($teleType) ? $teleType : 1; //1 = telein, 2 = teleout
               $data['events'] = $this->events->read();
               $data['reference'] = 'eve_register_id';
               $data['brand'] = $this->enquiry->getBrands();
               $data['division'] = $this->divisions->getActiveData();
               $data['salesExe'] = $this->registration->getAllStaffInSales();
               $data['districts'] = $this->registration->getDistricts();
               $data['mod'] = isset($_GET['mod']) ? $_GET['mod'] : 0;
               $data['reghistory'] = $this->registration->matchingRegister($customerNumber);
               $data['telesalescoo'] = $this->registration->telesalesCoordinator();
               $this->render_page(strtolower(__CLASS__) . '/reg_vehicle', $data);
          }
     }

     function registerSummary($regid, $enqid)
     {
          $data['trackCard'] = $this->registration->readVehicleReg($regid);
          $data['eventEnq'] = $this->registration->eventlistener($enqid);
          $this->render_page(strtolower(__CLASS__) . '/registerSummary', $data);
     }

     public function export_excel_event($type = 'lky-drw')
     {
          $this->page_title = 'List vehicle registration';
          $datas = $this->registration->eventlistener();
          $this->load->library("excel");

          if ($type == 'evnt') {
               $objPHPExcel = new PHPExcel();
               $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

               $heading = array('Entry date', 'Customer name', 'Contact IN', 'Contact NRI', 'Location', 'Email', 'Event', 'Reg no', 'Vehicle', 'Punched by', 'Comments', 'Type');

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

               if (!empty($datas['events'])) {
                    foreach ($datas['events'] as $key => $value) {
                         if ($value['eve_type'] == 1) {
                              $ips = 'Sales';
                         } else if ($value['eve_type'] == 1) {
                              $ips = 'Purchase';
                         } else {
                              $ips = 'Investment';
                         }
                         $enqDate = !empty($value['eve_added_on']) ? date('j M Y', strtotime($value['eve_added_on'])) : '';
                         $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $enqDate);
                         $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['eve_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['eve_mobile']);
                         $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['eve_mobile_non_india']);
                         $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['eve_location']);
                         $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['eve_email']);
                         $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['evnt_title']);
                         $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['eve_vehicle_selected']);
                         $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['assigedby']);
                         $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['vreg_customer_remark']);
                         $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $ips);
                         $row++;
                         $no++;
                    }
               }
               //Save as an Excel BIFF (xls) file
               $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
               header('Content-Type: application/vnd.ms-excel');
               header('Content-Disposition: attachment;filename="rdportal-eventlistner.xls"');
               header('Cache-Control: max-age=0');
               $objWriter->save('php://output');
               exit();
          } else {
               $objPHPExcel = new PHPExcel();
               $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

               $heading = array(
                    'Entry date',
                    'Customer name',
                    'Contact',
                    'Location',
                    'Email',
                    'Event',
                    'Reg no',
                    'Vehicle',
                    'Punched by',
                    'Comments',
                    'Referal name',
                    'Referal mobile NRI',
                    'Referal mobile IN',
                    'Referal location'
               );

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
               if (!empty($datas['lucky'])) {
                    foreach ($datas['lucky'] as $key => $value) {
                         $enqDate = !empty($value['eve_added_on']) ? date('j M Y', strtotime($value['eve_added_on'])) : '';
                         $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $enqDate);
                         $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['eve_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['eve_mobile']);
                         $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['eve_mobile_non_india']);
                         $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['eve_location']);
                         $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['eve_email']);
                         $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['evnt_title']);
                         $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['eve_vehicle_selected']);
                         $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['assigedby']);
                         $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['vreg_customer_remark']);
                         $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['eer_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['eer_mobile']);
                         $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['eer_mobile_in']);
                         $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['eer_location']);
                         $row++;
                         $no++;
                    }
               }
               //Save as an Excel BIFF (xls) file
               $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
               header('Content-Type: application/vnd.ms-excel');
               header('Content-Disposition: attachment;filename="rdportal-eventlistner-lucky-draw.xls"');
               header('Cache-Control: max-age=0');
               $objWriter->save('php://output');
               exit();
          }
     }

     function changesCheckBoxFields($field = 'eve_wp_sent', $prdId)
     {
          $status = ($_POST['status'] == 1) ? 0 : 1;
          if ($f = $this->registration->changesStatus($field, $prdId, $status)) {
               echo json_encode(array('status' => 'success', 'msg' => 'WhatsApp message sent'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Error"));
          }
     }

     function reassignStockMatching($id)
     {
          $this->page_title = 'Reassign Stock Matching';
          $id = encryptor($id, 'D');
          $data['events'] = $this->events->read();
          $data['brand'] = $this->enquiry->getBrands();
          $data['data'] = $this->registration->readVehicleReg($id);
          $data['model'] = $this->enquiry->getModelByBrand($data['data']['vreg_brand']);
          $data['variant'] = $this->enquiry->getVariantByModel($data['data']['vreg_model']);
          $data['division'] = $this->divisions->getData();
          $data['showroom'] = $this->registration->getShowRoomByDivision($data['data']['vreg_division']);
          $data['department'] = $this->registration->getDepartmentByDivision($data['data']['vreg_division']);
          $data['salesExe'] = $this->getStaffsByShowroom($data['data']['vreg_showroom'], false);
          $data['salesExe'] = $this->registration->getAllStaffInSales();
          $data['districts'] = $this->registration->getDistricts();
          $data['html'] = $this->load->view(strtolower(__CLASS__) . '/ajx_how_do_cust_know', $data['data'], true);
          $this->render_page(strtolower(__CLASS__) . '/reg_reassign', $data);
     }
     function customerByPhone()
     {
          // Check if dropped
          //TODO: will delete in future
          //$isDroppedCase = $this->registration->getEnquiryByMobile($this->input->post('phoneNo'));
          // $matchingRegister['reghistory'] = $this->registration->matchingRegister($this->input->post('phoneNo'));
          $matchingRegister['enq'] = $this->registration->getEnquiryByMobile($this->input->post('phoneNo'));
          //debug($matchingRegister['enq']);
          if (!empty($matchingRegister['enq'])) {
               echo json_encode(array(
                    'status' => 'success',
                    'customer_name' => $matchingRegister['enq']['enq_cus_name'],
                    'this_customer_enq_id' => $matchingRegister['enq']['enq_id']
               ));
          } else {
               echo json_encode(array('status' => 'failed', 'msg' => 'No records found'));
          }
     }
     function getAllRdStaffs($id = 0, $json = true)
     {
          $staffs = $this->registration->bindAllRdStaffs();
          echo json_encode($staffs);
     }
    // New matching enq
     function matchingInquiry()
{
    $customerId = $this->input->post('customerId'); // Replace 'phoneNo' with 'customerId'

    // Check if dropped
    $isDroppedCase = $this->registration->getEnquiryByCustomerId($customerId);
    $matchingRegister['reghistory'] = $this->registration->matchingRegister($customerId);
    $reghistory = $this->load->view(strtolower(__CLASS__) . '/view_register_history', $matchingRegister, true);

    if (empty($isDroppedCase)) {
        die(json_encode([
            'status' => 'fail',
            'msg' => 'Enquiry not found',
            'usr_id' => '',
            'se' => '',
            'isdrop' => 0,
            'regHistory' => $reghistory,
        ]));
    } elseif ($isDroppedCase['enq_current_status'] == 3) {
        $se = $isDroppedCase['usr_first_name'] ?? '';
        $trackCard = '<a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($isDroppedCase['enq_id'])) . '">
                        <i title="Track card" class="fa fa-list"></i></a>';
        $msg = 'Enquiry dropped Sales Officer ' . $se . ' Track card: ' . $trackCard;
        die(json_encode([
            'status' => 'fail',
            'msg' => $msg,
            'usr_id' => '',
            'se' => '',
            'isdrop' => 1,
            'regHistory' => $reghistory,
        ]));
    } else {
        $duplicate = $this->registration->matchingInquiry($customerId);
        if (!empty($duplicate)) {
            $se = $duplicate['usr_first_name'] ?? '';
            $sts = $duplicate['sts_title'] ?? '';
            $userId = $duplicate['usr_id'] ?? '';
            $trackCard = '<a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($duplicate['enq_id'])) . '">
                            <i title="Track card" class="fa fa-list"></i></a>';
            $msg = 'Inquiry already associated with sales executive ' . $se . ' Track card: ' . $trackCard . '<br> Current status is ' . $sts . '.';
            echo json_encode([
                'status' => 'success',
                'msg' => $msg,
                'usr_id' => $userId,
                'se' => $se,
                'isdrop' => 0,
                'regHistory' => $reghistory,
            ]);
        } else {
            echo json_encode([
                'status' => 'fail',
                'msg' => 'No inquiry found for this customer ID.',
                'usr_id' => '',
                'se' => '',
                'isdrop' => 0,
                'regHistory' => $reghistory,
            ]);
        }
    }
}

     //End New matching enq
}
