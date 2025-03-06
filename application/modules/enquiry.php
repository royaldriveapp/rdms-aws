<?php

defined('BASEPATH') or exit('No direct script access allowed');

class enquiry extends App_Controller
{

     public $myEnquiry = '';

     public function __construct()
     {

          parent::__construct();
          $this->page_title = 'Enquiry';
          $this->load->model('enquiry_model', 'enquiry');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $this->load->model('evaluation_new/evaluation_model', 'evaluation');
          $this->load->model('followup_new/followup_model', 'followup');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('customer_grade/customer_grade_model', 'customer_grade');
          $this->load->model('departments/departments_model', 'departments');
          $this->load->model('registration/registration_model', 'registration');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('reports/reports_model', 'reports');
          $this->myEnquiry = $this;
          //  error_reporting(1);
     }
     function exportExcelStatus($status)
     {
          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report request for drop/lost on - ' . date('Y-m-d H:i:s'),
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-enq-status-' . $status,
               'log_action' => 'R',
               'log_ref_id' => 1002,
               'log_added_by' => $this->uid
          ));
          $enquires = $this->enquiry->getRequestedEnquires('', $status, $_GET);
          $vehDetails = $this->reports->getVehicleInformation($value['enq_id']);
          //debug($enquires);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $cntMods = unserialize(MODE_OF_CONTACT);

          $heading = array(
               'Enq number', 'Customer', 'Customer Contact No', 'Mode of enquiry', 'Sales officer', 'Vehicle', 'Drop remark',
               'Staff', 'Color', 'Cust Expected', 'Entry date', 'Request date', 'Division', 'Branch', 'District',
               'Addedby', 'Home Visit', 'Last customer folloup', 'Last SM remarks', 'Last ASM remarks', 'Last MIM remarks',
               'Enquiry created Date', 'Team Leader', 'Enq Type'
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
          if (!empty($enquires['data'])) {
               foreach ($enquires['data'] as $key => $value) {

                    if ($value['enq_cus_status'] == 1) {
                         $enqType = 'Sales';
                    } else if ($value['enq_cus_status'] == 2) {
                         $enqType = 'Purchase';
                    } else {
                         $enqType = 'Exchange';
                    }
                    $vehicle = $this->reports->getVehicleDetails($value['enq_id']);
                    $mod = isset($modeOfContact[$value['enq_mode_enq']]) ? $modeOfContact[$value['enq_mode_enq']] : '';
                    $color = isset($vehDetails['0']['veh_color']) ? $vehDetails['0']['veh_color'] : '';
                    $custExp = isset($vehDetails['0']['veh_exch_cus_expect']) ? $vehDetails['0']['veh_exch_cus_expect'] : '';

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['enq_number']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['enq_cus_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['enq_cus_mobile']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $mod);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $vehicle);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['enh_remarks']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $color);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $custExp);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, !empty($value['enq_entry_date']) ? date('j M Y', strtotime($value['enq_entry_date'])) : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, !empty($value['enh_added_on']) ? date('j M Y', strtotime($value['enh_added_on'])) : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['div_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['shr_location']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['std_district_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['enq_added_by_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, !empty($value['enq_home_visit_date']) ? date('j M Y', strtotime($value['enq_home_visit_date'])) : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['enq_last_foll_cust_rmk']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value['enq_sm_rmk']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $value['enq_asm_rmk']);
                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $value['enq_mis_rmk']);
                    $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, !empty($value['enq_added_on']) ? date('j M Y', strtotime($value['enq_added_on'])) : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $value['tl_usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $enqType);
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
     function test()
     {
          // $this->render_page(strtolower(__CLASS__) . '/myregisterReport', $data);
     }
     function myregisterReport()
     {
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
          $enquires = $this->enquiry->readVehicleRegReport(0, $limit, $page, $_GET);
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
          $data['totalActiveStaff'] = $this->enquiry->getTotalActiveStaff();
          $data['division'] = $this->divisions->getActiveData();
          $data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
          $this->render_page(strtolower(__CLASS__) . '/myregisterReport', $data);
     }

     function exportRegisterReportExl()
     {
          ini_set('memory_limit', '-1');
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
          $this->page_title = 'List vehicle registration';
          $datas = $this->enquiry->readVehicleRegReport(0, 0, 0, $_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('My register');
          $heading = array(
               'Entry date', 'Customer name', 'Contact', 'Location', 'Disctrict', 'Contact mode', 'Brand', 'Model', 'Variant',
               'Year', 'Investment', 'Call type', 'Department', 'Added by', 'Assigned to', 'Remarks', 'Sales officer comment'
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
     public function index()
     {
          //debug(1212);
          $filterStatus = isset($_GET['status']) ? $_GET['status'] : 0;
          $this->load->library("pagination");
          $limit = get_settings_by_key('pagination_limit');
          // debug($limit);
          //$limit=5;
          //  debug($limit);
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $enquires = $this->enquiry->enquires('', array(), $limit, $page, $_GET);
          //debug($enquires);
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
          // debug(145455);
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }
     public function indexERROR()
     {
          ///debug(21312);
          $filterStatus = isset($_GET['status']) ? $_GET['status'] : 0;

          $this->load->library("pagination");
          $limit = get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $enquires = $this->enquiry->enquires('', array(), $limit, $page, $_GET);
          //debug(2131);
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

     public function add()
     {
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

     function update()
     {
          if ($this->enquiry->updateEnquiry($_POST)) {
               $this->session->set_flashdata('app_success', 'Enguiry successfully updated!');
               echo json_encode(array('status' => "success", 'msg' => 'Enguiry successfully updated!'));
          } else {
               $this->session->set_flashdata('app_error', 'Error while update enguiry!');
               echo json_encode(array('status' => 'fail', 'msg' => 'Error while update enguiry!'));
          }
     }

     function update_enq_and_change_veh()
     { //jchange latest update enq
          // debug($_POST,1);

          //     vreg_inquiry
          //vreg_status
          //vreg_is_punched reg master table update
          ////http://localhost/royalportal/rdportal/index.php/enquiry/myregister
          // debug($_POST);
          //$is_stock_veh = isset($_POST['is_stock_veh']) ? $_POST['is_stock_veh'] : 0; //Check vehicle  selected from Select box
          if ($this->enquiry->updateEnqAndChangeVeh($_POST)) {
               $this->session->set_flashdata('app_success', 'Enguiry successfully updated!');
               echo json_encode(array('status' => "success", 'msg' => 'Enguiry successfully updated!'));
          } else {
               $this->session->set_flashdata('app_error', 'Error while update enguiry!');
               echo json_encode(array('status' => 'fail', 'msg' => 'Error while update enguiry!'));
          }
     }

     function view($id)
     {

          if (!empty($id)) {
               $id = encryptor($id, 'D');
               $data['customerGrades'] = $this->customer_grade->get();
               $data['questions'] = $this->enquiry->getInquiryQuestions();
               $data['brands'] = $this->enquiry->getBrands();
               $data['enquiry'] = $this->enquiry->enquires($id);
               //  debug($data['enquiry']);
               $data['followStatus'] = unserialize(FOLLOW_UP_STATUS);
               $data['modOfContact'] = unserialize(MODE_OF_CONTACT_FOLLOW_UP);
               $data['salesExe'] = $this->emp_details->salesExecutives();
               $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
               $data['districts'] = $this->registration->getDistricts($data['enquiry']['enq_cus_state']);
               $data['Profession'] = $this->enquiry->getProfession();
               $data['Profession_cat'] = $this->enquiry->getProfessionCategory();
               $data['puposes'] = $this->enquiry->getpurposeOfPurchase();
               $data['states'] = $this->followup->getStates();
               $data['countries'] = $this->followup->getCountries();
               //  debug($data);
               // debug($data['evaluation']);

               $this->render_page(strtolower(__CLASS__) . '/view', $data);
          } else {
               //404 redirect here
          }
     }

     function view_test($id)
     {

          if (!empty($id)) {
               $id = encryptor($id, 'D');
               $data['customerGrades'] = $this->customer_grade->get();
               $data['questions'] = $this->enquiry->getInquiryQuestions();
               $data['brands'] = $this->enquiry->getBrands();
               $data['enquiry'] = $this->enquiry->enquires($id);
               //debug($data['enquiry']['vehicle_pitched']);
               $data['followStatus'] = unserialize(FOLLOW_UP_STATUS);
               $data['modOfContact'] = unserialize(MODE_OF_CONTACT_FOLLOW_UP);
               $data['salesExe'] = $this->emp_details->salesExecutives();
               $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
               $data['districts'] = $this->registration->getDistricts($data['enquiry']['enq_cus_state']);
               $data['Profession'] = $this->enquiry->getProfession();
               $data['Profession_cat'] = $this->enquiry->getProfessionCategory();
               $data['puposes'] = $this->enquiry->getpurposeOfPurchase();
               $data['states'] = $this->followup->getStates();
               $data['countries'] = $this->followup->getCountries();
               $data['banks'] = $this->evaluation->getAllBanks();
               // debug($data['evaluation']);
               $data['datas'] = $this->enquiry->readVehicleReg($id);
               $data['model'] = $this->enquiry->getModelByBrand(isset($data['datas']['vreg_brand']) ? $data['datas']['vreg_brand'] : 0);
               $data['variant'] = $this->enquiry->getVariantByModel(isset($data['datas']['vreg_model']) ? $data['datas']['vreg_model'] : 0);

               $this->render_page(strtolower(__CLASS__) . '/view_test', $data);
          } else {
               //404 redirect here
          }
     }

     function view_change($enq_id, $vreg_department = '', $reg_id = '')
     {
          if (!empty($enq_id)) {
               //   debug(12313);
               $id = encryptor($enq_id, 'D');
               $data['vreg_department'] = encryptor($vreg_department, 'D');
               $data['reg_id'] = encryptor($reg_id, 'D');

               $data['customerGrades'] = $this->customer_grade->get();
               $data['questions'] = $this->enquiry->getInquiryQuestions();
               $data['brands'] = $this->enquiry->getBrands();
               // debug($data['brands'] );
               //debug(464);
               $data['enquiry'] = $this->enquiry->enquires($enq_id);
               if ($this->uid == 100) {
                    //debug($data['enquiry']);
               }
               //  debug($data['enquiry']);
               //debug(7412365);
               //debug($data['enquiry']['vehicle_pitched']);

               $data['followStatus'] = unserialize(FOLLOW_UP_STATUS);
               $data['modOfContact'] = unserialize(MODE_OF_CONTACT_FOLLOW_UP);
               $data['salesExe'] = $this->emp_details->salesExecutives();
               $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
               //debug(  $data['evaluation']);
               // $data['districts'] = $this->registration->getDistricts($data['enquiry']['enq_cus_state']);
               $data['Profession'] = $this->enquiry->getProfession();
               $data['Profession_cat'] = $this->enquiry->getProfessionCategory();
               $data['puposes'] = $this->enquiry->getpurposeOfPurchase();
               $data['states'] = $this->followup->getStates();
               $states = [1, 0];
               $data['districts'] = $this->registration->getDistricts($states);
               $data['countries'] = $this->followup->getCountries();
               $data['banks'] = $this->evaluation->getAllBanks();
               // debug($data['evaluation']);
               //debug($enq_id);
               // $data['datas'] = $this->enquiry->readVehicleReg($vreg_id); 
               $data['datas'] = $this->enquiry->readVehicleRegEnq($enq_id);
               //debug($data['datas']);
               $data['model'] = $this->enquiry->getModelByBrand(isset($data['datas']['vreg_brand']) ? $data['datas']['vreg_brand'] : 0);
               $data['variant'] = $this->enquiry->getVariantByModel(isset($data['datas']['vreg_model']) ? $data['datas']['vreg_model'] : 0);
               // debug($data);
               $this->render_page(strtolower(__CLASS__) . '/view_change', $data);
          } else {
               //404 redirect here
          }
     }

     function autoComPlace()
     {
          $reply['suggestions'] = $this->enquiry->autoComPlace($_GET['query']);
          echo json_encode($reply);
     }

     function autoComOccupation()
     {
          $reply['suggestions'] = $this->enquiry->autoComOccupation($_GET['query']);
          echo json_encode($reply);
     }

     function autoComCountry()
     {
          $reply['suggestions'] = $this->enquiry->autoComCountry($_GET['query']);
          echo json_encode($reply);
     }

     function autoComCity()
     {
          $reply['suggestions'] = $this->enquiry->autoComCity($_GET['query']);
          echo json_encode($reply);
     }

     function autoComDistrict()
     {
          $reply['suggestions'] = $this->enquiry->autoComDistrict($_GET['query']);
          echo json_encode($reply);
     }

     function autoComState()
     {
          $reply['suggestions'] = $this->enquiry->autoComState($_GET['query']);
          echo json_encode($reply);
     }

     function delete($enqId, $callBack)
     {
          $enqId = encryptor($enqId, 'D');
          $callBack = encryptor($callBack, 'D');
          if (!empty($enqId) && $this->enquiry->permenentDelete($enqId)) {
               $this->session->set_flashdata('app_success', 'Enguiry permenently deleted!');
          } else {
               $this->session->set_flashdata('app_error', 'Error while delete enguiry!');
          }
          redirect($callBack);
     }

     public function bindModel($brdId = '', $dataType = 'json')
     {

          $id = isset($_POST['id']) ? $_POST['id'] : $brdId;
          $vehicle = $this->enquiry->getModelByBrand($id);
          if ($dataType == 'json') {
               echo json_encode($vehicle);
          } else {
               return $vehicle;
          }
     }

     function bindVarient($modelId = '', $dataType = 'json')
     {
          $id = isset($_POST['id']) ? $_POST['id'] : $modelId;
          $vehicle = $this->enquiry->getVariantByModel($id);
          if ($dataType == 'json') {
               echo json_encode($vehicle);
          } else {
               return $vehicle;
          }
     }

     function removeSaleOrPurchase($id)
     {

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

     function bindSalesTable($id)
     {
          $data['vehicle'] = $this->evaluation->getEvaluation($id);
          $data['brands'] = $this->enquiry->getBrands();
          $msg = $this->load->view(__CLASS__ . '/tmp_' . __FUNCTION__, $data, true);
          echo json_encode(array('status' => 'success', 'msg' => $msg));
     }

     function changeStatus($enqId)
     {
          if (isset($_POST['status']) && !empty($_POST['status'])) {
               $this->enquiry->changeStatus($enqId, $_POST['status']);
               $this->session->set_flashdata('app_success', 'Status successfully changed!');
          } else {
               $this->session->set_flashdata('app_error', 'Error while change status!');
          }
          echo json_encode(array('status' => 'success'));
     }

     function changeStatusRequest_old($status)
     {
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
     function changeStatusRequest($status)
     {
          $this->load->library("pagination");
          //$limit = get_settings_by_key('pagination_limit');
          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();
          $data = $_GET;
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
          $enquires = $this->enquiry->getRequestedEnquires('', $status, $_GET, $limit, $page);
          //     if($this->uid==100){
          //      debug($enquires);

          //  }
          /*pagination*/
          $data['enq_ids'] = $enquires['enq_ids'];
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
          /*@pagination*/
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
          $data['allShowrooms'] = $this->showroom->get();
          $data['status'] = $status;
          $data['teleCallers'] = $this->emp_details->teleCallersSalesStaffs();
          // debug($data['teleCallers']);
          $this->render_page(strtolower(__CLASS__) . '/specialRequestsList', $data);
     }

     function viewVehicleStatus($enq, $status = '')
     {
          if (!empty($enq)) {
               $enq = encryptor($enq, 'D');
               $data['enquiryDetails'] = $this->enquiry->getRequestedEnquires($enq, '');
               $data['valuationVehicles'] = $this->evaluation->getOwnParkAndSaleCars();
               $data['statusButtons'] = array();
               $data['sts'] = $status;
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
                         array('id' => 5, 'title' => 'Lost confirmed', 'buttonClass' => 'danger'),
                         array('id' => 1, 'title' => 'Cancel Request', 'buttonClass' => 'success')
                    );
               } else if (isset($data['enquiryDetails']['enq_current_status']) && $data['enquiryDetails']['enq_current_status'] == 3) { // Dropped case
                    $data['statusButtons'] = array(
                         array('id' => 1, 'title' => 'Reopening enquires', 'buttonClass' => 'danger')
                    );
               }
               $this->render_page(strtolower(__CLASS__) . '/vehicleStatus', $data);
          }
          if (!empty($_POST)) {

               if ($this->followup->changeStatus($_POST, $_GET)) {
                    $this->session->set_flashdata('app_success', 'Status changed successfully!');
               } else {
                    $this->session->set_flashdata('app_error', 'Error occured!');
               }
               redirect(strtolower(__CLASS__) . '/viewVehicleStatus/' . encryptor($_POST['enh_enq_id']));
          } else {
               //404
          }
     }

     function submitdroplost($enq, $status = '')
     {
          if (!empty($_POST)) {
               if ($this->enquiry->changeStatusDropLost($_POST, $_GET)) {
                    $this->session->set_flashdata('app_success', 'Status changed successfully!');
               } else {
                    $this->session->set_flashdata('app_error', 'Error occured!');
               }
               redirect(strtolower(__CLASS__) . '/viewVehicleStatus/' . encryptor($_POST['enh_enq_id']));
          } else {
               //404
          }
     }

     function printTrackCard($enqid)
     {
          if (!is_numeric($enqid)) {
               $enqid = encryptor($enqid, 'D');
          }
          $data['trackCard'] = $this->enquiry->getTrackCardDetails($enqid);
          $showroomId = get_logged_user('usr_showroom');
          $data['showRoom'] = $this->showroom->get($showroomId);
          $this->render_page(strtolower(__CLASS__) . '/tracking_card', $data);
     }

     function printTrackCard_test($enqid)
     {
          //debug($enqid);
          if (!is_numeric($enqid)) {
               $enqid = encryptor($enqid, 'D');
          }
          $data['trackCard'] = $this->enquiry->getTrackCardDetails_test($enqid);
          // debug( $data['trackCard']['vehicle_buy']);
          // debug( $data['trackCard']['vehicle_existing']);
          // debug($data['trackCard']['vehicle_pitched']);//vehicle_pitched
          // debug($data['trackCard']['home_visits']);//home_visits
          $showroomId = get_logged_user('usr_showroom');
          $data['showRoom'] = $this->showroom->get($showroomId);
          $this->render_page(strtolower(__CLASS__) . '/tracking_card_test', $data);
     }

     function freezedEnquires()
     {
          $data['enquires'] = $this->enquiry->getFreezedEnquires();
          $this->render_page(strtolower(__CLASS__) . '/freezed', $data);
     }

     function freezeVehicle($enqId)
     {
          $enqId = encryptor($enqId, 'D');
          if (isset($_POST['status']) && !empty($_POST['status'])) {
               $this->enquiry->changeStatus($enqId, $_POST['status']);
          } else {
               $this->enquiry->changeStatus($enqId, 1);
          }
          echo json_encode(array('status' => 'success', 'msg' => 'Status successfully changed!'));
     }

     function assignenquires()
     {
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

     function permenentDelete($enqId)
     {
          $enqId = encryptor($enqId, 'D');
          $this->enquiry->permenentDelete($enqId);
          $this->session->set_flashdata('app_success', 'Status changed successfully!');
          redirect(strtolower(__CLASS__) . '/enquiry');
     }

     function myregister($test = '')
     {
          $this->page_title = "My register";
          $this->load->library("pagination");

          //$pendingReg = $this->enquiry->pendingRegByStaff($_GET);
          // debug($pendingReg);
          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          //   if (check_permission('enquiry', 'myregistercallanalysis')) {
          //        $data['tc'] = $this->enquiry->registerTodaysanalysis();
          //   }
          //debug($page);
          //$start = microtime(true);///
          $enquires = $this->enquiry->readVehicleReg(0, $limit, $page, $_GET);
          //$end = microtime(true);
          //$exec_time = ($end - $start);
          //echo "The execution time of the PHP script is : ".$exec_time." sec";  
          //exit;
          //debug($enquires,1);

          $data['datas'] = $enquires['data'];
          // debug($enquires['data']);

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
          $data['salesStaff'] = $this->enquiry->staffCanAssignEnquires();
          $data['teleCallers'] = $this->emp_details->teleCallers();
          $data['division'] = $this->divisions->getActiveData();
          if ($this->input->get('vreg_division')) {
               $data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
          }
          $data['teleCallers'] = $this->emp_details->teleCallersSalesStaffs();
          //  $end = microtime(true);
          //$exec_time = ($end - $start);
          //echo "The execution time of the PHP script is : ".$exec_time." sec";
          //debug($data);
          if ($test == 'test') {
               //debug($test);
               $this->render_page(strtolower(__CLASS__) . '/myreg_test', $data);
               return true;
               //exit;
          } elseif ($test == 'test2') {
               //debug($test);
               $this->render_page(strtolower(__CLASS__) . '/myreg_test2', $data);
               return true;
               //exit;
          }
          $this->render_page(strtolower(__CLASS__) . '/myregister', $data);
          // $this->render_page(strtolower(__CLASS__) . '/myreg_test', $data);
     }

     function regiter_2_inquiry($id)
     {

          $id = encryptor($id, 'D');
          //  echo $this->uid ;
          // echo '<br>'.$this->usr_grp;
          //exit;
          $data['questions'] = $this->enquiry->getInquiryQuestions();
          $data['brands'] = $this->enquiry->getBrands();
          $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
          // debug(count($data['evaluation']));
          $data['salesExe'] = $this->emp_details->salesExecutives();
          $data['datas'] = $this->enquiry->readVehicleReg($id);

          //  debug(   $data['datas'] );
          $data['Profession'] = $this->enquiry->getProfession();

          $data['Profession_cat'] = $this->enquiry->getProfessionCategory();
          $data['puposes'] = $this->enquiry->getpurposeOfPurchase();

          $data['customerGrades'] = $this->customer_grade->get();

          $data['districts'] = $this->registration->getDistricts();
          $data['model'] = $this->enquiry->getModelByBrand(isset($data['datas']['vreg_brand']) ? $data['datas']['vreg_brand'] : 0);
          $data['variant'] = $this->enquiry->getVariantByModel(isset($data['datas']['vreg_model']) ? $data['datas']['vreg_model'] : 0);
          //  $data['states'] = $this->followup->getStates($states);
          // $data['countries'] = $this->followup->getCountries();

          $states = [1, 0];
          $data['districts'] = $this->registration->getDistricts($states);
          $data['banks'] = $this->evaluation->getAllBanks();
          //debug($data);
          $this->render_page(strtolower(__CLASS__) . '/regiter_2_inquiry', $data);
     }

     function registerExists()
     {
          $duplicate = $this->enquiry->registerExists($this->input->post('phoneNo'));
          if (!empty($duplicate)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Inquiry already associated with register'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => 'No inquiry already associated with this contact number'));
          }
     }

     function specialcomments($enqid)
     {
          $enqid = encryptor($enqid, 'D');
          $data['trackCard'] = $this->enquiry->getTrackCardDetails($enqid);
          $showroomId = get_logged_user('usr_showroom');
          $data['showRoom'] = $this->showroom->get($showroomId);
          $data['questions'] = $this->enquiry->getInquiryQuestions();
          //debug($data['questions']);
          $this->render_page(strtolower(__CLASS__) . '/specialcomments', $data);
     }

     public function punchEnquiry()
     {
          //echo $this->uid;
          //exit;
          //debug($_POST,1);
          // debug($_POST['vehicle']['sale'],1);
          // $_POST = json_decode(file_get_contents('php://input'), true);
          // echo  $_POST;
          //echo json_encode($_POST);
          // exit;
          // if($this->uid==358){
          //debug($this->div,1);
          // debug($_POST,1);

          //}
          if (!empty($_POST)) {
               generate_log(array(
                    'log_title' => 'Punch inquiry from register',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'punch-enq-from-reg',
                    'log_action' => 'C',
                    'log_ref_id' => 1212,
                    'log_added_by' => $this->uid
               ));
               $valId = isset($_POST['valId']) ? $_POST['valId'] : 0; //Check if vehicle is selected from existing or not
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
               //debug(121231,1);
               // debug($_POST['enquiry']['enq_mode_enq']);
               //debug($message);
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
                    if ($enquiryId = $this->enquiry->newEnquiry($_POST, $valId)) { //$valId == cpnl_valuation table master id
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
               //$this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     public function punchEnquiry_test()
     {
          // $j='a:9:{s:7:"vreg_id";s:5:"94954";s:16:"vreg_assigned_to";s:3:"635";s:7:"enquiry";a:31:{s:18:"enq_customer_grade";s:1:"3";s:14:"enq_cus_status";s:1:"1";s:14:"enq_entry_date";s:10:"13-09-2022";s:12:"enq_cus_name";s:4:"John";s:15:"enq_cus_address";s:2:"Gc";s:19:"enq_cus_ofc_address";s:3:"Gch";s:14:"enq_cus_mobile";s:10:"9808844444";s:17:"enq_cus_office_no";s:4:"1357";s:12:"enq_cus_city";s:10:"Ernakulam ";s:13:"enq_cus_email";s:0:"";s:16:"enq_cus_whatsapp";s:0:"";s:12:"enq_cus_fbid";s:0:"";s:17:"enq_cus_age_group";s:5:"20-30";s:14:"enq_cus_gender";s:1:"1";s:12:"enq_cus_occu";s:1:"7";s:15:"enq_cus_company";s:0:"";s:17:"enq_cus_phone_res";s:0:"";s:12:"enq_cus_dist";s:1:"2";s:11:"enq_cus_pin";s:0:"";s:12:"enq_mode_enq";s:1:"7";s:12:"enq_ref_type";s:1:"0";s:12:"enq_ref_name";s:0:"";s:13:"enq_ref_phone";s:0:"";s:14:"enq_ref_enq_id";s:0:"";s:15:"enq_cus_remarks";s:43:"Looking for A4 .Tele appointment on today .";s:15:"enq_cus_purpose";s:2:"18";s:13:"other_purpose";s:0:"";s:17:"enq_cus_loan_perc";s:1:"0";s:19:"enq_cus_loan_amount";s:0:"";s:16:"enq_cus_loan_emi";s:0:"";s:19:"enq_cus_loan_period";s:0:"";}s:5:"money";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:4:"need";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:9:"authority";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:7:"vehicle";a:3:{s:4:"sale";a:14:{s:9:"veh_brand";a:1:{i:0;s:1:"3";}s:9:"veh_model";a:1:{i:0;s:2:"12";}s:11:"veh_varient";a:1:{i:0;s:1:"0";}s:8:"veh_fuel";a:1:{i:0;s:1:"2";}s:18:"veh_manf_year_from";a:1:{i:0;s:4:"2017";}s:16:"veh_manf_year_to";a:1:{i:0;s:4:"2017";}s:9:"veh_color";a:1:{i:0;s:0:"";}s:12:"veh_price_id";a:1:{i:0;s:0:"";}s:9:"veh_km_id";a:1:{i:0;s:0:"";}s:17:"veh_prefer_number";a:1:{i:0;s:0:"";}s:23:"veh_exptd_date_purchase";a:1:{i:0;s:0:"";}s:11:"veh_remarks";a:1:{i:0;s:0:"";}s:17:"proc_purchase_prd";a:1:{i:0;s:0:"";}s:9:"proc_desc";a:1:{i:0;s:0:"";}}s:7:"pitched";a:6:{s:10:"veh_val_id";a:1:{i:0;s:3:"246";}s:18:"veh_customer_offer";a:1:{i:0;s:0:"";}s:11:"veh_remarks";a:1:{i:0;s:0:"";}s:14:"veh_tl_remarks";a:1:{i:0;s:0:"";}s:14:"veh_sm_remarks";a:1:{i:0;s:0:"";}s:14:"veh_gm_remarks";a:1:{i:0;s:0:"";}}s:3:"buy";a:46:{s:9:"veh_brand";a:1:{i:0;s:1:"0";}s:11:"veh_varient";a:1:{i:0;s:2:"39";}s:8:"veh_fuel";a:1:{i:0;s:1:"2";}s:8:"veh_year";a:1:{i:0;s:4:"2017";}s:9:"veh_color";a:1:{i:0;s:0:"";}s:12:"veh_price_id";a:1:{i:0;s:0:"";}s:11:"veh_km_from";a:1:{i:0;s:1:"0";}s:15:"veh_color_in_rc";a:1:{i:0;s:0:"";}s:21:"veh_delivery_location";a:1:{i:0;s:0:"";}s:18:"veh_delivery_state";a:1:{i:0;s:0:"";}s:14:"veh_dealership";a:1:{i:0;s:0:"";}s:8:"veh_reg1";a:1:{i:0;s:0:"";}s:8:"veh_reg2";a:1:{i:0;s:0:"";}s:8:"veh_reg3";a:1:{i:0;s:0:"";}s:8:"veh_reg4";a:1:{i:0;s:0:"";}s:10:"veh_re_reg";a:1:{i:0;s:0:"";}s:9:"veh_owner";a:1:{i:0;s:0:"";}s:13:"veh_comprossr";a:1:{i:0;s:1:"0";}s:18:"veh_chassis_number";a:1:{i:0;s:0:"";}s:11:"veh_remarks";a:1:{i:0;s:0:"";}s:17:"veh_delivery_date";a:1:{i:0;s:0:"";}s:13:"veh_first_reg";a:1:{i:0;s:0:"";}s:13:"veh_manf_year";a:1:{i:0;s:0:"";}s:6:"veh_ac";a:1:{i:0;s:0:"";}s:11:"veh_ac_zone";a:1:{i:0;s:0:"";}s:6:"veh_cc";a:1:{i:0;s:0:"";}s:16:"veh_vehicle_type";a:1:{i:0;s:0:"";}s:14:"veh_engine_num";a:1:{i:0;s:0:"";}s:16:"veh_transmission";a:1:{i:0;s:0:"";}s:11:"veh_seat_no";a:1:{i:0;s:0:"";}s:17:"insurance_company";a:1:{i:0;s:0:"";}s:11:"valid_up_to";a:1:{i:0;s:0:"";}s:3:"idv";a:1:{i:0;s:0:"";}s:14:"ncb_percentage";a:1:{i:0;s:0:"";}s:21:"val_insurance_ll_date";a:1:{i:0;s:0:"";}s:14:"insurance_type";a:1:{i:0;s:0:"";}s:7:"ncb_req";a:1:{i:0;s:1:"0";}s:15:"finance_company";a:1:{i:0;s:0:"";}s:4:"bank";a:1:{i:0;s:0:"";}s:11:"bank_branch";a:1:{i:0;s:0:"";}s:18:"loan_starting_date";a:1:{i:0;s:0:"";}s:16:"loan_ending_date";a:1:{i:0;s:0:"";}s:11:"loan_amount";a:1:{i:0;s:0:"";}s:17:"forclousure_value";a:1:{i:0;s:0:"";}s:16:"forclousure_date";a:1:{i:0;s:0:"";}s:14:"daily_interest";a:1:{i:0;s:0:"";}}}s:12:"veh_stock_id";s:3:"246";s:8:"followup";a:5:{s:11:"foll_status";s:1:"3";s:12:"foll_remarks";s:47:"Looking for A4 .Gave details, under discussion.";s:12:"foll_contact";s:1:"1";s:16:"foll_action_plan";s:9:"Follow ip";s:19:"foll_next_foll_date";s:10:"14-09-2022";}}';
          $j = 'a:9:{s:7:"vreg_id";s:5:"92885";s:16:"vreg_assigned_to";s:3:"890";s:7:"enquiry";a:32:{s:18:"enq_customer_grade";s:1:"3";s:14:"enq_cus_status";s:1:"1";s:14:"enq_entry_date";s:10:"29-08-2022";s:12:"enq_cus_name";s:16:"Dr.Jijo Varghese";s:15:"enq_cus_address";s:10:"Trivandrum";s:19:"enq_cus_ofc_address";s:10:"Mavelikara";s:14:"enq_cus_mobile";s:10:"6238753972";s:17:"enq_cus_office_no";s:2:"62";s:12:"enq_cus_city";s:11:"MAVELIKKARA";s:13:"enq_cus_email";s:0:"";s:16:"enq_cus_whatsapp";s:0:"";s:12:"enq_cus_fbid";s:0:"";s:17:"enq_cus_age_group";s:5:"30-40";s:14:"enq_cus_gender";s:1:"1";s:12:"enq_cus_occu";s:1:"4";s:21:"enq_cus_occu_category";s:0:"";s:15:"enq_cus_company";s:0:"";s:17:"enq_cus_phone_res";s:0:"";s:12:"enq_cus_dist";s:1:"2";s:11:"enq_cus_pin";s:0:"";s:12:"enq_mode_enq";s:1:"6";s:12:"enq_ref_type";s:1:"0";s:12:"enq_ref_name";s:0:"";s:13:"enq_ref_phone";s:0:"";s:14:"enq_ref_enq_id";s:0:"";s:15:"enq_cus_remarks";s:77:"Customer is looking 20-25 lakh budget Luxury models, Purchase plan December  ";s:15:"enq_cus_purpose";s:0:"";s:13:"other_purpose";s:0:"";s:17:"enq_cus_loan_perc";s:0:"";s:19:"enq_cus_loan_amount";s:0:"";s:16:"enq_cus_loan_emi";s:0:"";s:19:"enq_cus_loan_period";s:0:"";}s:5:"money";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:4:"need";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:9:"authority";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:7:"vehicle";a:2:{s:4:"sale";a:13:{s:9:"veh_brand";a:1:{i:0;s:1:"0";}s:11:"veh_varient";a:1:{i:0;s:4:"3789";}s:8:"veh_fuel";a:1:{i:0;s:1:"2";}s:18:"veh_manf_year_from";a:1:{i:0;s:0:"";}s:16:"veh_manf_year_to";a:1:{i:0;s:0:"";}s:9:"veh_color";a:1:{i:0;s:0:"";}s:12:"veh_price_id";a:1:{i:0;s:0:"";}s:9:"veh_km_id";a:1:{i:0;s:0:"";}s:17:"veh_prefer_number";a:1:{i:0;s:0:"";}s:23:"veh_exptd_date_purchase";a:1:{i:0;s:0:"";}s:11:"veh_remarks";a:1:{i:0;s:0:"";}s:17:"proc_purchase_prd";a:1:{i:0;s:0:"";}s:9:"proc_desc";a:1:{i:0;s:0:"";}}s:3:"buy";a:46:{s:9:"veh_brand";a:1:{i:0;s:1:"0";}s:11:"veh_varient";a:1:{i:0;s:4:"3789";}s:8:"veh_fuel";a:1:{i:0;s:1:"2";}s:8:"veh_year";a:1:{i:0;s:0:"";}s:9:"veh_color";a:1:{i:0;s:0:"";}s:12:"veh_price_id";a:1:{i:0;s:0:"";}s:11:"veh_km_from";a:1:{i:0;s:0:"";}s:15:"veh_color_in_rc";a:1:{i:0;s:0:"";}s:21:"veh_delivery_location";a:1:{i:0;s:0:"";}s:18:"veh_delivery_state";a:1:{i:0;s:0:"";}s:14:"veh_dealership";a:1:{i:0;s:0:"";}s:8:"veh_reg1";a:1:{i:0;s:0:"";}s:8:"veh_reg2";a:1:{i:0;s:0:"";}s:8:"veh_reg3";a:1:{i:0;s:0:"";}s:8:"veh_reg4";a:1:{i:0;s:0:"";}s:10:"veh_re_reg";a:1:{i:0;s:0:"";}s:9:"veh_owner";a:1:{i:0;s:0:"";}s:13:"veh_comprossr";a:1:{i:0;s:0:"";}s:18:"veh_chassis_number";a:1:{i:0;s:0:"";}s:11:"veh_remarks";a:1:{i:0;s:0:"";}s:17:"veh_delivery_date";a:1:{i:0;s:0:"";}s:13:"veh_first_reg";a:1:{i:0;s:0:"";}s:13:"veh_manf_year";a:1:{i:0;s:0:"";}s:6:"veh_ac";a:1:{i:0;s:0:"";}s:11:"veh_ac_zone";a:1:{i:0;s:0:"";}s:6:"veh_cc";a:1:{i:0;s:0:"";}s:16:"veh_vehicle_type";a:1:{i:0;s:0:"";}s:14:"veh_engine_num";a:1:{i:0;s:0:"";}s:16:"veh_transmission";a:1:{i:0;s:0:"";}s:11:"veh_seat_no";a:1:{i:0;s:0:"";}s:17:"insurance_company";a:1:{i:0;s:0:"";}s:11:"valid_up_to";a:1:{i:0;s:0:"";}s:3:"idv";a:1:{i:0;s:0:"";}s:14:"ncb_percentage";a:1:{i:0;s:0:"";}s:21:"val_insurance_ll_date";a:1:{i:0;s:0:"";}s:14:"insurance_type";a:1:{i:0;s:0:"";}s:7:"ncb_req";a:1:{i:0;s:1:"0";}s:15:"finance_company";a:1:{i:0;s:0:"";}s:4:"bank";a:1:{i:0;s:0:"";}s:11:"bank_branch";a:1:{i:0;s:0:"";}s:18:"loan_starting_date";a:1:{i:0;s:0:"";}s:16:"loan_ending_date";a:1:{i:0;s:0:"";}s:11:"loan_amount";a:1:{i:0;s:0:"";}s:17:"forclousure_value";a:1:{i:0;s:0:"";}s:16:"forclousure_date";a:1:{i:0;s:0:"";}s:14:"daily_interest";a:1:{i:0;s:0:"";}}}s:12:"veh_stock_id";s:1:"0";s:8:"followup";a:5:{s:11:"foll_status";s:1:"3";s:12:"foll_remarks";s:77:"Customer is looking 20-25 lakh budget Luxury models, Purchase plan December  ";s:12:"foll_contact";s:1:"1";s:16:"foll_action_plan";s:7:"Followp";s:19:"foll_next_foll_date";s:10:"20-09-2022";}}';
          $post_data = unserialize($j);
          //debug($post_data);
          // debug($post_data['vehicle']['sale'],1);
          if (!empty($post_data)) {
               generate_log(array(
                    'log_title' => 'Punch inquiry from register',
                    'log_desc' => serialize($post_data),
                    'log_controller' => 'punch-enq-from-reg',
                    'log_action' => 'C',
                    'log_ref_id' => 1212,
                    'log_added_by' => $this->uid
               ));
               $valId = isset($post_data['valId']) ? $post_data['valId'] : 0; //Check if vehicle is selected from existing or not
               $regAssignTo = isset($post_data['vreg_assigned_to']) ? $post_data['vreg_assigned_to'] : $this->uid;
               $message = '';
               if (isset($post_data['enquiry']['enq_entry_date']) && empty($post_data['enquiry']['enq_entry_date'])) {
                    $message = ' Please select inquiry date';
               }
               if (isset($post_data['enquiry']['enq_cus_name']) && empty($post_data['enquiry']['enq_cus_name'])) {
                    $message .= ' Please enter customer name';
               }
               if (isset($post_data['enquiry']['enq_cus_mobile']) && empty($post_data['enquiry']['enq_cus_mobile'])) {
                    $message .= ' Please enter valid mobile number';
               }
               if (isset($post_data['enquiry']['enq_cus_city']) && empty($post_data['enquiry']['enq_cus_city'])) {
                    $message .= ' Please enter place';
               }
               if (isset($post_data['enquiry']['enq_mode_enq']) && empty($post_data['enquiry']['enq_mode_enq'])) {
                    $message .= ' Please select mode of inquiry';
               }
               if (isset($post_data['enquiry']['enq_cus_when_buy']) && empty($post_data['enquiry']['enq_cus_when_buy'])) {
                    $message .= ' Please choose when would customer like to buy';
               }
               //debug(121231,1);
               // debug($post_data['enquiry']['enq_mode_enq']);
               //debug($message);
               //                 $duplicate = $this->enquiry->registerExists($post_data['enquiry']['enq_cus_mobile']);
               //                 if(!empty($duplicate)) {
               //                      $message .= ' Inquiry already associated with register';
               //                 }
               if (empty($message)) {
                    $myname = get_logged_user('usr_username');
                    $mynumber = get_logged_user('usr_phone');
                    $mycustmr = trim($post_data['enquiry']['enq_cus_name']);
                    $message = "Hi Mr.$mycustmr
      Greetings from Royal Drive South India's Largest Pre-Owned Luxury Car Showroom Thank you for the visit, We are grateful for serving you. 
      My self $myname, Please feel free to contact me @ $mynumber. Regards, $myname info@royaldrive.in www.royaldrive.in App Link: http://onelink.to/p4z8q2";
                    if ($enquiryId = $this->enquiry->newEnquiry($post_data, $valId)) { //$valId == cpnl_valuation table master id
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

                         if ($mobile_number = is_indian_number($post_data['enquiry']['enq_cus_mobile'])) {
                              send_sms($message, $mobile_number, 'sms-enquiry');
                         } else if ($mobile_number = is_indian_number($post_data['enquiry']['enq_cus_whatsapp'])) {
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
               //$this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     function bindBrand($divisionId = '', $dataType = 'json')
     {
          $id = isset($_POST['id']) ? $_POST['id'] : $divisionId;
          $vehicle = $this->enquiry->getBrandByDivision($id);
          if ($dataType == 'json') {
               echo json_encode($vehicle);
          } else {
               return $vehicle;
          }
     }

     function bindShowroomByDivision()
     {
          if (isset($_POST['id']) && !empty($_POST['id'])) {
               $showroom = $this->enquiry->bindShowroomByDivision($_POST['id']);
               echo json_encode($showroom);
          }
     }

     function sendBackRegister()
     {
          // if($this->uid==100){
          //      debug($_POST);
          //      exit;

          // }

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

     function quickfollowup()
     {
          $data['quickFollMaster'] = $this->enquiry->getQuickFollowupMaster();
          $this->render_page(strtolower(__CLASS__) . '/quickfollowupmaster', $data);
     }

     function quickfollowupDetails($id = 0)
     {
          $id = encryptor($id, 'D');
          $data['enquires'] = $this->enquiry->getQuickFollowupLeads($id);
          $this->render_page(strtolower(__CLASS__) . '/quickfollowup', $data);
     }

     function quickupdate()
     {
          if ($this->enquiry->quickupdate($_POST)) {
               echo json_encode(array('msg' => 'Updated successfully'));
          } else {
               echo json_encode(array('msg' => 'Error occure'));
          }
     }

     function myinquiresByStatus()
     {
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

     function myinquiresByStatusExpExcel()
     {

          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for enquires by status',
               'log_desc' => $this->session->userdata('usr_username') . ' downloaded excel report for enquires by status on - ' . date('Y-m-d H:i:s'),
               'log_controller' => 'exp-excel-myinquires-by-status',
               'log_action' => 'R',
               'log_ref_id' => 0002,
               'log_added_by' => $this->uid
          ));

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

     function selfregister()
     {
          $data['datas'] = $this->enquiry->selfregister();
          $this->render_page(strtolower(__CLASS__) . '/selfregister', $data);
     }

     function setRegisterFollowup()
     {


          if (isset($_POST['regfoll']) && !empty($_POST['regfoll'])) {
               $this->enquiry->setRegisterFollowup($_POST);
               echo json_encode(array('msg' => 'Register followup successfully updated'));
          }
     }

     function bindPurchaseTable($id)
     {
          // debug($id);
          $data['vehicle'] = $this->evaluation->getEvaluation($id);
          $data['brands'] = $this->enquiry->getBrands();
          $msg = $this->load->view(__CLASS__ . '/tmp_' . __FUNCTION__, $data, true);
          echo json_encode(array('status' => 'success', 'msg' => $msg));
     }

     public function export_excel()
     {

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
          $this->page_title = 'List vehicle registration';
          $datas = $this->enquiry->readVehicleReg(0, 0, 0, $_GET);
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('My register');
          $heading = array(
               'Entry date', 'Customer name', 'Contact', 'Location', 'Disctrict', 'Contact mode', 'Brand', 'Model', 'Variant',
               'Year', 'Investment', 'Call type', 'Department', 'Added by', 'Assigned to', 'Remarks', 'Sales officer comment', 'Second day courtsey comments'
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
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['vreg_last_action']);
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

     public function add_offer_price()
     {
          if (!empty($_POST)) {
               //debug($_POST);
               if ($enquiryId = $this->enquiry->addOfferPrice($_POST)) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Success'));
               }
          }
     }

     function reassignenquiry()
     {
          $this->enquiry->reassignenquiry($_POST);
          redirect(strtolower(__CLASS__) . '/enquiry');
     }

     function chngquickfollowupsts($carId)
     {
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

     function add_existing_veh_details()
     {
          $data['count'] = $_GET['count'];
          $data['brands'] = $this->enquiry->getBrands();
          $result = $this->load->view('existing_veh_ajax', $data);
          return json_encode($result);
     }

     function bindPitchedVehTable($id)
     {
          $data['vehicle'] = $this->evaluation->getEvaluation($id);
          $data['brands'] = $this->enquiry->getBrands();
          $msg = $this->load->view(__CLASS__ . '/tmp_' . __FUNCTION__, $data, true);
          echo json_encode(array('status' => 'success', 'msg' => $msg));
     }

     function add_req_veh_details()
     {
          $data['count'] = $_GET['count'];
          $data['brands'] = $this->enquiry->getBrands();
          //debug($data['brands']);
          $result = $this->load->view('req_veh_ajax', $data);
          return json_encode($result);
     }

     function add_pitched_veh_details()
     {
          $data['count'] = $_GET['count'];
          $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
          //debug($data['brands']);
          $result = $this->load->view('pitched_veh_ajax', $data);
          return json_encode($result);
     }

     public function bindDistrict($distId = '', $dataType = 'json')
     {
          $id = isset($_POST['id']) ? $_POST['id'] : $distId;
          $districts = $this->registration->getDistricts($id);
          if ($dataType == 'json') {
               echo json_encode($districts);
          } else {
               return $$districts;
          }
     }

     function add_purchase_veh_details()
     {
          $data['count'] = $_GET['count'];
          $data['brands'] = $this->enquiry->getBrands();
          $data['evaluation'] = $this->evaluation->getOwnParkAndSaleCars();
          $data['banks'] = $this->evaluation->getAllBanks();
          //debug($data['brands']);
          $result = $this->load->view('purchase_veh_ajax', $data);
          return json_encode($result);
     }

     public function purchase_enq_list()
     {
          //  $response = $this->enquiry->pr_purchase_enq();
          $data['status'] = 12;
          $this->render_page(strtolower(__CLASS__) . '/purchase_enq_list', $data);
     }

     function purchase_enq_ajax()
     {
          $response = $this->enquiry->purchase_enq_ajax($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     function reassigntosalesstaff()
     {
          $this->enquiry->reassigntosalesstaff($_POST);
          $this->session->set_flashdata('app_success', 'Register reassigned to sales staff, please inform them!');
          redirect(strtolower(__CLASS__) . '/myregister');
     }

     function bindEnqVeh()
     {
          $enq_id = $this->input->get('enq_id');
          $res = $this->enquiry->bindEnqVeh($enq_id);
          // debug($res['vehData']);
          //$result = $this->load->view('expect_booking_ajax_hidden', $res['enqData']);
          //echo json_encode(array('status' => 'success', 'vehData' => $res['vehData'],'hiddenData'=>$result));
          echo json_encode(array('status' => 'success', 'vehData' => $res['vehData'], 'hiddenData' => $res['enqData']));
          //debug($vehicle); 
          // echo json_encode($vehicle);
     }

     function getVehDtls()
     {
          $veh_id = $this->input->get('veh_id');
          //  debug($veh_id);
          $res = $this->enquiry->getEnqVehById($veh_id);
          echo json_encode(array('status' => 'success', 'vehData' => $res));
     }

     function pendingReg()
     { //?type=&vreg_division=2&vreg_showroom=2
          // debug($_GET);
          $this->page_title = "My register";
          $this->load->library("pagination");

          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();
          $pendingReg = $this->enquiry->pendingRegByStaff($limit, $page, $_GET);
          //debug($pendingReg);
          // $enquires = $this->enquiry->readVehicleReg(0, $limit, $page, $_GET);
          $data['datas'] = $pendingReg['data'];
          $config['page_query_string'] = TRUE;
          $config['query_string_segment'] = 'page';
          $config["base_url"] = $link;
          $config["total_rows"] = $pendingReg['count'];
          $config["per_page"] = $limit;
          $config["uri_segment"] = 3;

          /* Table info */
          $data['pageIndex'] = $page + 1;
          $data['limit'] = $page + $limit;
          $data['totalRow'] = number_format($pendingReg['count']);
          /* Table info */

          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $data['division'] = $this->divisions->getActiveData();
          $data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
          $this->render_page(strtolower(__CLASS__) . '/pending_register_count', $data); //myregisterReport
          //debug($pendingReg);    
     }

     function detailed_walk_in_report()
     { //2do
          $this->page_title = "My register";
          $this->load->library("pagination");

          //$pendingReg = $this->enquiry->pendingRegByStaff($_GET);
          // debug($pendingReg);
          $limit = 10;
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          if (check_permission('enquiry', 'myregistercallanalysis')) {
               $data['tc'] = $this->enquiry->registerTodaysanalysis();
          }
          $enquires = $this->enquiry->readVehicleReg(0, $limit, $page, $_GET);
          // debug($enquires);
          $data['datas'] = $enquires['data'];
          // debug($enquires['data']);

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
          $data['salesStaff'] = $this->enquiry->staffCanAssignEnquires();
          $data['teleCallers'] = $this->emp_details->teleCallers();
          $data['division'] = $this->divisions->getActiveData();
          $data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
          $this->render_page(strtolower(__CLASS__) . '/myregister', $data);
     }

     public function export_excel_j()
     {

          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for my register',
               'log_desc' => $this->session->userdata('usr_username') . ' downloaded excel report for my register on - ' . date('Y-m-d H:i:s'),
               'log_controller' => 'exp-excel-my-register',
               'log_action' => 'R',
               'log_ref_id' => 1002,
               'log_added_by' => $this->uid
          ));


          $this->page_title = 'List vehicle registration';
          $datas = $this->enquiry->readVehicleReg(0, 0, 0, $_GET);
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('My register');
          $heading = array('Entry date', 'Customer name', 'Contact');

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



          $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '11-07-2021');
          $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Jaefar');
          $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, '9656557105');

          $row++;
          $no++;


          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="jsktest.xls"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
          exit();
     }
     function submitReAssign()
     {
          error_reporting(E_ALL);
          if (isset($_POST['executive']) && (count($_POST['executive']) > 0)) {
               $enquires = unserialize($_POST['enq_ids']);
               if (!empty($enquires)) {
                    $index = 0;
                    $exic = $_POST['executive'];
                    $comment = $_POST['desc'];
                    $staffindx = 0;
                    $result = $this->assignProcess($enquires, $exic, $index, $staffindx, $comment, time());
                    if ($result) {
                         die(json_encode(array('msg' => 'Successfully reassigned ' . count($enquires) . ' inquires')));
                    } else {
                         die(json_encode(array('msg' => 'Error')));
                    }
               } else {
                    die(json_encode(array('msg' => 'Error: No inquiry found')));
               }
          }
          die(json_encode(array('msg' => ' Error :Please select at least one staff')));
     }

     //jsk
     function assignProcess($enquires, $exic, $i, $staffIndex, $comment, $batch)
     {
          $enq_id = $enquires[$i]['enq_id'];
          $toStaff = $exic[$staffIndex];
          $enqCount = count($enquires);
          $staffCount = count($exic);
          $oldStaff = $enquires[$i]['enq_se_id'];
          $divBySE = intval(($enqCount / $staffCount));
          $this->reports->updateReAssignHistoryFollowup($oldStaff, $toStaff, $enq_id, $enquires[$i], $comment, $divBySE, $batch);
          $i = $i + 1;
          $staffIndex = $staffIndex + 1;
          if ($i < $enqCount) {
               if ($staffIndex == ($staffCount)) {
                    $staffIndex = 0;
                    $this->assignProcess($enquires, $exic, $i, $staffIndex, $comment, $batch);
               } else {
                    $this->assignProcess($enquires, $exic, $i, $staffIndex, $comment, $batch);
               }
          }
          return true;
     }

     function pool()
     {
          $filterStatus = isset($_GET['status']) ? $_GET['status'] : 0;
          $this->load->library("pagination");
          $limit = get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $enquires = $this->enquiry->poolEnquires($limit, $page, $_GET);
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

          $this->render_page(strtolower(__CLASS__) . '/enq_pool_list', $data);
     }

     function reassignregister()
     {
          if (!empty($_POST['executive'])) {
               $result = $this->enquiry->readVehicleReg(0, 0, 0, unserialize($_POST['searchValues']), true);
               if (isset($result['data']) && !empty($result['data'])) {
                    $desc = $_POST['desc'];
                    $cnt = count($_POST['executive']);
                    $data = $result['data'];
                    $div = is_float(count($data) / $cnt) ? (int) (count($data) / $cnt) + 1 : (count($data) / $cnt);
                    $divdedData = array_chunk($data, $div);
                    foreach ($_POST['executive'] as $key => $user) {
                         $toName = $this->enquiry->getUserNameById($user);
                         $regHistory = [];
                         array_walk_recursive($divdedData[$key], function ($a) use (&$regHistory, $user, $toName, $desc) {
                              $exp = explode('-', $a);
                              $regHistory[] = array(
                                   'regh_phone_num' => $exp['1'],
                                   'regh_register_master' => $exp['0'],
                                   'regh_assigned_by' => $this->uid,
                                   'regh_assigned_to' => $user,
                                   'regh_added_date' => date('Y-m-d H:i:s'),
                                   'regh_added_by' => $this->uid,
                                   'regh_remarks' => $desc,
                                   'regh_system_cmd' => "Reassigned myregister of " . $exp['2'] . " registers to " . $toName . ", reassigned by " . $this->session->userdata('usr_username')
                              );
                         });

                         $vregIds = 'vreg_id = ' . implode(array_column($regHistory, 'regh_register_master'), ' OR vreg_id = ');
                         $this->enquiry->updateRegisterMaster($vregIds, $user);
                         $this->enquiry->registerHistoryBatch($regHistory);
                         generate_log(array(
                              'log_title' => 'Quick assign register master',
                              'log_desc' => serialize($regHistory),
                              'log_controller' => 'quick-assign-register-master',
                              'log_action' => 'C',
                              'log_ref_id' => 0,
                              'log_added_by' => $this->uid
                         ));
                    }
               } else {
                    die(json_encode(array('status' => 'fail', 'msg' => 'Empty register')));
               }
               die(json_encode(array('status' => 'success', 'msg' => 'Completed')));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => 'Please select staff')));
          }
     }

     function poolbatch($batch = '')
     {
          $data['data'] = $this->enquiry->poolBatch($batch);
          $this->render_page(strtolower(__CLASS__) . '/poolbatch', $data);
     }
}

  //