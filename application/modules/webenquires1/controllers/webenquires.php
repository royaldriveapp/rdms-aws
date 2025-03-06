<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class webenquires extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Webenquires';
            $this->load->library('form_validation');
            $this->load->model('webenquires_model', 'webenquires');

            $this->load->model('enquiry/enquiry_model', 'enquiry');
            $this->load->model('registration/registration_model', 'registration');
            $this->load->model('emp_details/emp_details_model', 'emp_details');
            $this->load->model('events/events_model', 'events');
            $this->load->model('showroom/showroom_model', 'showroom');
            $this->load->model('divisions/divisions_model', 'divisions');
       }

       public function index() {
            $this->section = "Webenquires";
            $data['data'] = $this->webenquires->getAllWebSiteInquires();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function punch($teleType = 0) {
            if (!empty($_GET)) {
                 $_GET['t'] = isset($_GET['t']) ? encryptor($_GET['t'], 'D') : '';
                 $_GET['i'] = isset($_GET['i']) ? encryptor($_GET['i'], 'D') : '';

                 $msgType = 'app_success';
                 $msg = 'Register successfully added!';

                 if (!empty($_POST)) {
                      generate_log(array(
                          'log_title' => 'Contact punching (Registration) web inquires',
                          'log_desc' => serialize($_POST),
                          'log_controller' => 'punch-registration-web-inquires',
                          'log_action' => 'C',
                          'log_ref_id' => 1011,
                          'log_added_by' => $this->uid
                      ));
                      //Auto assign case
                      $duplicate = $this->registration->matchingInquiry($this->input->post('vreg_cust_phone'));
                      if (!empty($duplicate)) {
                           $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                           $userId = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                           //$_POST['vreg_assigned_to'] = $userId;
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
                      $alreadyAssociated = $this->webenquires->readCustomeTaleData($_GET);
                      $data['customerNumber'] = isset($alreadyAssociated['phone']) ? $alreadyAssociated['phone'] : '';
                      $data['customerName'] = isset($alreadyAssociated['name']) ? $alreadyAssociated['name'] : '';
                      $id = isset($_GET['i']) ? trim($_GET['i']) : 0;
                      $data['fulldata'] = $this->webenquires->getAllWebSiteInquires($id);

                      if (!empty($data['fulldata'])) {
                           $data['brand'] = $this->enquiry->getBrands();
                           $data['model'] = $this->enquiry->getModelByBrand($data['fulldata']['brd_id']);
                           $data['variant'] = $this->enquiry->getVariantByModel($data['fulldata']['mod_id']);

                           $data['brd_sel'] = isset($data['fulldata']['brd_id']) ? $data['fulldata']['brd_id'] : 0;
                           $data['mod_sel'] = isset($data['fulldata']['mod_id']) ? $data['fulldata']['mod_id'] : 0;
                           $data['var_sel'] = isset($data['fulldata']['var_id']) ? $data['fulldata']['var_id'] : 0;
                      } else {
                           $data['brd_sel'] = 0;
                           $data['mod_sel'] = 0;
                           $data['var_sel'] = 0;

                           $data['variant'] = array();
                           $data['model'] = array();
                           $data['brand'] = $this->enquiry->getBrands();
                      }
                      if (isset($data['customerNumber']) && !empty($data['customerNumber'])) {
                           $duplicate = $this->registration->matchingInquiry($data['customerNumber']);
                           $data['reghistory'] = $this->registration->matchingRegister($data['customerNumber']);
                           if (!empty($duplicate)) {
                                $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                                $data['usrId'] = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                                $trackCard = ' <a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($duplicate['enq_id'])) . '"><i title="Track card" class="fa fa-list"></i></a>';
                                $data['ifEnqAlready'] = 'Inquiry already associated with sales executive ' . $se . ' Track card : ' . $trackCard;
                           }
                      }

                      $data['hid'] = !empty($_GET) ? serialize($_GET) : '';
                      $data['teleType'] = isset($teleType) ? $teleType : 1; //1 = telein, 2 = teleout
                      $data['events'] = $this->events->read();

                      $data['division'] = $this->divisions->getActiveData();
                      $data['salesExe'] = $this->registration->getAllStaffInSales();
                      $data['mod'] = isset($_GET['mod']) ? $_GET['mod'] : 0;
                      $this->render_page(strtolower(__CLASS__) . '/reg_vehicle', $data);
                 }
            }
       }

       function add() {
            $msgType = 'app_success';
            $msg = 'Register successfully added!';

            if (!empty($_POST)) {
                 generate_log(array(
                     'log_title' => 'Contact punching (Registration) web inquires',
                     'log_desc' => serialize($_POST),
                     'log_controller' => 'punch-registration-web-inquires',
                     'log_action' => 'C',
                     'log_ref_id' => 1011,
                     'log_added_by' => $this->uid
                 ));
                 $duplicate = $this->registration->matchingInquiry($this->input->post('vreg_cust_phone'));
                 if (!empty($duplicate)) {
                      $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                      $userId = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                      //$_POST['vreg_assigned_to'] = $userId;
                      $msg = 'Inquiry already associated with sales executive ' . $se;
                      $msgType = 'app_success_pop';
                 }
                 if ($this->webenquires->create($_POST)) {
                      $this->session->set_flashdata($msgType, $msg);
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Vehicle!");
                 }
                 redirect(strtolower(__CLASS__));
            }
       }

       public function purchase_enq() {
          $this->section = "Purchase Enquiries";
          $data['data'] = $this->webenquires->getAllPurchgaseInquires();
          $this->render_page(strtolower(__CLASS__) . '/list_purchase_enq', $data);
     }

     public function punch_purchase_enq($teleType = 0) {
          if (!empty($_GET)) {
               $_GET['t'] = isset($_GET['t']) ? encryptor($_GET['t'], 'D') : '';
               $_GET['i'] = isset($_GET['i']) ? encryptor($_GET['i'], 'D') : '';

               $msgType = 'app_success';
               $msg = 'Register successfully added!';

               if (!empty($_POST)) {
                    generate_log(array(
                        'log_title' => 'Contact punching (Registration) purchase inquires',
                        'log_desc' => serialize($_POST),
                        'log_controller' => 'punch-registration-purchase-inquires',
                        'log_action' => 'C',
                        'log_ref_id' => 1011,
                        'log_added_by' => $this->uid
                    ));
                    //Auto assign case
                    $duplicate = $this->registration->matchingInquiry($this->input->post('vreg_cust_phone'));
                    if (!empty($duplicate)) {
                         $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                         $userId = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                         //$_POST['vreg_assigned_to'] = $userId;
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
                    // debug($_GET);
                    $this->page_title = 'New vehicle registration';
                    // $alreadyAssociated = $this->webenquires->readCustomeTaleData($_GET);
                    $data['customerNumber'] = isset($_GET['ph']) ? encryptor($_GET['ph'], 'D') : '';
                    $data['customerName'] = isset($_GET['nm']) ? encryptor($_GET['nm'], 'D') : '';
                    $id = isset($_GET['i']) ? trim($_GET['i']) : 0;
                    $data['fulldata'] = $this->webenquires->getAllPurchgaseInquires($id);
                    
                    if (!empty($data['fulldata'])) {

                         $data['brand'] = $this->enquiry->getBrands();
                         $data['fulldata']['brd_id'] = isset($data['fulldata']['brd_id']) ? $data['fulldata']['brd_id'] : 0;
                         $data['fulldata']['mod_id'] = isset($data['fulldata']['mod_id']) ? $data['fulldata']['mod_id'] : 0;
                         $data['model'] = $this->enquiry->getModelByBrand($data['fulldata']['brd_id']);
                         $data['variant'] = $this->enquiry->getVariantByModel($data['fulldata']['mod_id']);

                         $data['brd_sel'] = isset($data['fulldata']['brd_id']) ? $data['fulldata']['brd_id'] : 0;
                         $data['mod_sel'] = isset($data['fulldata']['mod_id']) ? $data['fulldata']['mod_id'] : 0;
                         $data['var_sel'] = isset($data['fulldata']['var_id']) ? $data['fulldata']['var_id'] : 0;
                    } else {
                         $data['brd_sel'] = 0;
                         $data['mod_sel'] = 0;
                         $data['var_sel'] = 0;

                         $data['variant'] = array();
                         $data['model'] = array();
                         $data['brand'] = $this->enquiry->getBrands();
                    }
                    if (isset($data['customerNumber']) && !empty($data['customerNumber'])) {
                         $data['reghistory'] = $this->registration->matchingRegister($data['customerNumber']);
                         $duplicate = $this->registration->matchingInquiry($data['customerNumber']);
                         if (!empty($duplicate)) {
                              $se = isset($duplicate['usr_first_name']) ? $duplicate['usr_first_name'] : '';
                              $data['usrId'] = isset($duplicate['usr_id']) ? $duplicate['usr_id'] : '';
                              $trackCard = ' <a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($duplicate['enq_id'])) . '"><i title="Track card" class="fa fa-list"></i></a>';
                              $data['ifEnqAlready'] = 'Inquiry already associated with sales executive ' . $se . ' Track card : ' . $trackCard;
                         }
                    }

                    $data['hid'] = !empty($_GET) ? serialize($_GET) : '';
                    $data['teleType'] = isset($teleType) ? $teleType : 1; //1 = telein, 2 = teleout
                    $data['events'] = $this->events->read();

                    $data['division'] = $this->divisions->getActiveData();
                    $data['salesExe'] = $this->registration->getAllStaffInSales();
                    $data['mod'] = isset($_GET['mod']) ? $_GET['mod'] : 0;
                    $data['purchase_enq'] = 1;
                    
                    $this->render_page(strtolower(__CLASS__) . '/reg_vehicle', $data);
               }
          }
      }

      public function exportPurchaseEnq() {
          generate_log(array(
              'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for web purchase enquires - ' . date('Y-m-d H:i:s'),
              'log_desc' => $this->session->userdata('usr_username') . ' downloaded excel report for web purchase enquires - ' . date('Y-m-d H:i:s'),
              'log_controller' => 'exp-excel-web-pur-enquires',
              'log_action' => 'R',
              'log_ref_id' => 3003,
              'log_added_by' => $this->uid
          ));

          $data['data'] = $this->webenquires->exportPurchaseEnq();

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $heading = array('Product No', 'Name', 'Phone', 'Email', 'Brand', 'Model', 'Variant', 'Color', 'Expect Price', 'Added on');

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
          if (isset($data['data']) && !empty($data['data'])) {
               foreach ($data['data'] as $key => $value) {
                    $brand = is_numeric($value['prd_brand']) ? $value['brd_title'] : $value['prd_brand'];
                    $model = is_numeric($value['prd_model']) ? $value['mod_title'] : $value['prd_model'];
                    $varnt = is_numeric($value['prd_variant']) ? $value['var_variant_name'] : $value['prd_variant'];
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['prd_number']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['username']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['email']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $brand);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $model);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $varnt);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['prd_color']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['prd_price']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, date('d-m-Y', strtotime($value['prd_date'])));
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
     }

     function deletepurchaseenq($enqId) {
          $enqId = encryptor($enqId, 'D');
          if ($this->webenquires->deletepurchaseenq($enqId)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Enquiry successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete enquiry"));
          }
     }
} 