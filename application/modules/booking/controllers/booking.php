<?php
defined('BASEPATH') or exit('No direct script access allowed');
class booking extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'Booking';
          $this->load->model('booking_model', 'booking');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('ihits_api/ihits_api_model', 'ihits');
          $this->load->model('evaluation/evaluation_model', 'evaluation');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $this->load->model('webenquires/webenquires_model', 'api_booking');
     }

     public function index()
     {
          $data['salesExecutives'] = $this->booking->salesExecutives();
          $data['showroom'] = $this->booking->showroom();
          $data['division'] = $this->booking->getDivision(true);
          $this->render_page(strtolower(__CLASS__) . '/index', $data);
     }
     function index_ajax()
     {
          $response =  $this->booking->getAllBookingsPaginate($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     // function deliverdvehicle()
     // {
     //      $this->page_title = 'Deliverd vehicles';
     //      $data['salesExecutives'] = $this->emp_details->salesExecutives();
     //      $data['bookedVehicle'] = $this->booking->getDeliverdVehicle(0, 40, $_GET);
     //      $data['districts'] = $this->booking->getDistricts();
     //      $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
     //      $data['distSelected'] = isset($_GET['dist']) ? $_GET['dist'] : '';
     //      $this->render_page(strtolower(__CLASS__) . '/deliverdvehicle', $data);
     // }

     public function deliverdvehicle()
     {
          $data['salesExecutives'] = $this->booking->salesExecutives();
          $data['showroom'] = $this->booking->showroom();
          $data['division'] = $this->booking->getDivision(true);
          $this->render_page(strtolower(__CLASS__) . '/deliverdvehicle', $data);
     }

     function deliverdvehicleAjax()
     {
          $response =  $this->booking->getAllDeliveryPaginate($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     function index_demo()
     {
          $data['bookingVehicles'] = $this->booking->getAllBookings($_GET);
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
          $this->render_page(strtolower(__CLASS__) . '/index_demo', $data);
     }

     function reserveVehicleView($enqId)
     {
          $enqId = encryptor($enqId, 'D');
          $data['stockVehicles'] = $this->booking->getStockVehicles();
          $data['enqId'] = $enqId;
          $html = $this->load->view(strtolower(__CLASS__) . '/ajx_reservationform_1', $data, true);
          die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
     }
     function reserveVehicleViewApi($ab_id)
     {
          $enqId = encryptor($enqId, 'D');
          $data['stockVehicles'] = $this->booking->getStockVehicles();
          //  debug(   $data['stockVehicles']);
          $data['enqId'] = 0;
          $data['ab_id'] = $ab_id;
          $html = $this->load->view(strtolower(__CLASS__) . '/ajx_reservationform_1', $data, true);
          die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
     }

     function bindVehicleDetails($vehId, $enqId, $ab_id = '')
     {
          // if($this->uid){
          $data['is_api'] = 0;
          if ($enqId == 0) {
               $data['is_api'] = 1;
               $data['booking'] = $this->api_booking->getData($ab_id);
          } else {
               $data['enquiry'] = $this->enquiry->enquires($enqId);
               if ($data['enquiry']['enq_cus_status'] == 3) {
                    $data['purchaseVeh'] = $this->booking->getPurchaseVeh($enqId);
               }
          }

          //  }
          $vehId = encryptor($vehId, 'D');
          $enqId = encryptor($enqId, 'D');

          $data['vehicles'] = $this->evaluation->getEvaluationPrint($vehId);
          $data['addressProof'] = $this->booking->getActiveAddressProof(1);
          $data['banks'] = $this->evaluation->getAllBanks();
          $data['company'] = $this->booking->getCompany();
          //$html = $this->load->view(strtolower(__CLASS__) . '/ajx_reservationform_2', $data, true);
          //die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
          $this->render_page(strtolower(__CLASS__) . '/ajx_reservationform_2', $data);
     }

     function reserveVehicle()
     {
          // if($this->uid==358){
          //     debug($_POST);
          //                  foreach($_POST['bm'] as $k=>$vals ){
          // echo $val='bm['.$k.']:'.$vals.' <br>';

          //           }
          //  exit;
          // }
          $ttlAmt = (($_POST['bm']['vbk_vehicle_amt']) && !empty($_POST['bm']['vbk_vehicle_amt'])) ? (int) $_POST['bm']['vbk_vehicle_amt'] : 0;
          $advAmt = (($_POST['bm']['vbk_advance_amt']) && !empty($_POST['bm']['vbk_advance_amt'])) ? (int) $_POST['bm']['vbk_advance_amt'] : 0;
          if ($ttlAmt > 0 && $advAmt > 0) {
               $reserveMasterId = $this->booking->reserveVehicle($_POST);
               $this->load->library('upload');
               $docNos = isset($_POST['ap']['vbd_doc_type']) ? count($_POST['ap']['vbd_doc_type']) : 0;
               $newFileName = '';
               if ($docNos > 0) {
                    for ($i = 0; $i < $docNos; $i++) {
                         if (isset($_FILES['vbd_doc_file']['name'][$i]) && !empty($_FILES['vbd_doc_file']['name'][$i])) {
                              $newFileName = rand() . time();
                              $config['upload_path'] = '../rdms/assets/uploads/documents/booking/';
                              $config['allowed_types'] = '*';
                              // $config['file_name'] = $newFileName;
                              $config['encrypt_name'] = TRUE;
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
                                   //debug($uploadData); 
                              }
                         }
                         $this->booking->uploadDocuments(
                              array(
                                   'vbd_doc_file' => $uploadData['file_name'],
                                   'vbd_master_id' => $reserveMasterId,
                                   'vbd_doc_type' => isset($_POST['ap']['vbd_doc_type'][$i]) ? $_POST['ap']['vbd_doc_type'][$i] : 0,
                                   'vbd_doc_number' => isset($_POST['ap']['vbd_doc_number'][$i]) ? $_POST['ap']['vbd_doc_number'][$i] : 0
                              )
                         );
                    }
               }
               $this->session->set_flashdata('app_success', 'New booking successfully added!');
               //redirect(__CLASS__);
               redirect(__CLASS__ . '/print_obf/' . $reserveMasterId);
               //die(json_encode(array('status' => 'success', 'msg' => 'New booking')));
          } else {
               echo 'Please enter vehicle price';
          }
     }

     function bookedvehicles()
     {
          $this->page_title = 'Booked vehicles';
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
          $stsId = isset($_GET['s']) ? encryptor($_GET['s'], 'D') : 0;
          $data['bookedVehicle'] = $this->booking->getBookedVehicle(0, $stsId);
          $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
          $this->render_page(strtolower(__CLASS__) . '/bookedvehicle', $data);
     }

     function bookingcancelledlist($stsId)
     {
          $this->page_title = 'Cancelled vehicles';
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
          $data['bookingCancelled'] = $this->booking->getDeliverdVehicle(0, $stsId, $_GET);
          $data['districts'] = $this->booking->getDistricts();
          $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
          $data['distSelected'] = isset($_GET['dist']) ? $_GET['dist'] : '';
          //$this->render_page(strtolower(__CLASS__) . '/deliverdvehicle', $data);
          $this->render_page(strtolower(__CLASS__) . '/cancelledvehicle', $data);
     }

     /**
      * Export booking enquires
      */
     function exportBookedVehicles()
     {
          $stsId = isset($_GET['s']) ? encryptor($_GET['s'], 'D') : 0;
          $userName = $this->session->userdata('usr_username');
          $data = date('Y-m-d H:i:s');
          generate_log(array(
               'log_title' =>  $userName . ' downloaded excel report for deliverd vehicle on - ' . $data,
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-book-deliverd',
               'log_action' => 'R',
               'log_ref_id' => 29,
               'log_added_by' => $this->uid
          ));
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $data = $this->booking->getAllBookings($_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $heading = array(
               'Booking ID',
               'Registration',
               'Customer Name',
               'Booked by',
               'Phone number (Official)',
               'Phone number (Personal)',
               'Permanent address',
               'RC Transfer address',
               'Booked on',
               'Expect delivery on',
               'Delivery on',
               'Insurance status',
               'RC Transfer status',
               'RFI Status',
               'Vehicle',
               'Chassis',
               'Enq No',
               'Customer Source',
               'Sales staff',
               'Booking status',
               'Division',
               'Enquiry Date',
               'Enq Added on',
               'Showroom'
          );
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }

          $mod = unserialize(MODE_OF_CONTACT);
          $statuses = unserialize(ENQUIRY_UP_STATUS);

          $row = 2;
          if (!empty($data)) {
               foreach ($data as $key => $value) {
                    $rctrnsPIN = !empty($value['vbk_rc_trns_pin']) ? ', PIN :' . $value['vbk_rc_trns_pin'] : '';
                    $perPIN = !empty($value['vbk_pin']) ? ', PIN :' . $value['vbk_pin'] : '';
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['vbk_ref_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['val_veh_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['enq_cus_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['bkdby_first_name'] . ' ' . $value['btdby_last_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['vbk_off_ph_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['vbk_per_ph_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['vbk_per_address'] . $perPIN); //enq_location
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['vbk_rd_trans_address'] . $rctrnsPIN);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, date(DATE_FORMAT_COMMON, strtotime($value['vbk_added_on']))); //j M Y h:i A
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, !empty($value['vbk_expect_delivery']) ? date(DATE_FORMAT_COMMON, strtotime($value['vbk_expect_delivery'])) : ''); //j M Y h:i A
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, !empty($value['vbk_delivery_date']) ? date(DATE_FORMAT_COMMON, strtotime($value['vbk_delivery_date'])) : ''); //j M Y h:i A
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['rfi_in_sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['rfi_rc_sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['rfi_sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['val_chasis_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['enq_number']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, isset($mod[$value['enq_mode_enq']]) ? $mod[$value['enq_mode_enq']] : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value['salesstaff_first_name'] . ' ' . $value['salesstaff_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $value['sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $value['div_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, date(DATE_FORMAT_COMMON, strtotime($value['enq_entry_date'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, date(DATE_FORMAT_COMMON, strtotime($value['enq_added_on'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $value['shr_location']);
                    $row++;
               }
          }

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="rdportal-enquires-report.xls"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
          exit();
     }

     /**
      * Export deliverd vehicle
      */
     function exportExcelBookings()
     {
          $stsId = isset($_GET['s']) ? encryptor($_GET['s'], 'D') : 0;
          $userName = $this->session->userdata('usr_username');
          $data = date('Y-m-d H:i:s');
          generate_log(array(
               'log_title' =>  $userName . ' downloaded excel report for deliverd vehicle on - ' . $data,
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-book-deliverd',
               'log_action' => 'R',
               'log_ref_id' => 29,
               'log_added_by' => $this->uid
          ));
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $data = $this->booking->getDeliverdVehicle(0, $stsId, $_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $heading = array(
               'Booking ID',
               'Registration',
               'Customer Name',
               'Booked by',
               'Phone number (Official)',
               'Phone number (Personal)',
               'Permanent address',
               'RC Transfer address',
               'Booked on',
               'Expect delivery on',
               'Delivery on',
               'Insurance status',
               'RC Transfer status',
               'RFI Status',
               'Vehicle',
               'Chassis',
               'Showroom',
               'Booking status',
               'Enquiry Date',
               'Enq Added on',
               'Enquiry Number'
          );
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }

          $modeOfContact = unserialize(MODE_OF_CONTACT);
          $statuses = unserialize(ENQUIRY_UP_STATUS);

          $row = 2;
          if (!empty($data)) {
               foreach ($data as $key => $value) {
                    $rctrnsPIN = !empty($value['vbk_rc_trns_pin']) ? ', PIN :' . $value['vbk_rc_trns_pin'] : '';
                    $perPIN = !empty($value['vbk_pin']) ? ', PIN :' . $value['vbk_pin'] : '';

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['vbk_ref_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['val_veh_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['enq_cus_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['bkdby_first_name'] . ' ' . $value['btdby_last_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['vbk_off_ph_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['vbk_per_ph_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['vbk_per_address']); //enq_location
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['vbk_rd_trans_address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, date(DATE_FORMAT_COMMON, strtotime($value['vbk_added_on'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, !empty($value['vbk_expect_delivery']) ? date(DATE_FORMAT_COMMON, strtotime($value['vbk_expect_delivery'])) : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, !empty($value['vbk_delivery_date']) ? date(DATE_FORMAT_COMMON, strtotime($value['vbk_delivery_date'])) : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['rfi_in_sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['rfi_rc_sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['rfi_sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['val_chasis_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['shr_location']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['sts_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, date(DATE_FORMAT_COMMON, strtotime($value['enq_entry_date'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, date(DATE_FORMAT_COMMON, strtotime($value['enq_added_on'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $value['enq_number']);
                    $row++;
               }
          }

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="rdportal-enquires-report.xls"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
          exit();
     }

     function bookingDetails($id)
     {
          $bookId = encryptor($id, 'D');
          $data['addressProof'] = $this->booking->getActiveAddressProof(1);
          $data['bookingDetails'] = $this->booking->getBookedVehicle($bookId);
          $this->booking->pendingDocs($bookId);
          $data['history'] = $this->load->view(strtolower(__CLASS__) . '/bookinghistory', $data['bookingDetails'], true);
          $this->render_page(strtolower(__CLASS__) . '/bookingdetails', $data);
     }

     function bookingDetails_rfi($id)
     {
          $bookId = encryptor($id, 'D');
          $data['banks'] = $this->evaluation->getAllBanks();
          $data['addressProof'] = $this->booking->getActiveAddressProof(2);
          $data['bookingDetails'] = $this->booking->getBookedVehicle($bookId);
          $data['rcTransferStatuses'] = $this->common_model->getStatuses('rfi-rc-trans');
          $data['rcTransferInsurnce'] = $this->common_model->getStatuses('rfi-ins-trans');
          $data['fileTransferStatuses'] = $this->common_model->getStatuses('rfi-file-sts');
          $data['rfiStatus'] = $this->common_model->getStatuses('rfi-sts');
          $data['bookingFollowup'] = $this->booking->getBookingFollowup();
          $data['RTO'] = $this->booking->getRTO();
          $data['history'] = $this->load->view(strtolower(__CLASS__) . '/bookinghistory', $data['bookingDetails'], true);
          $this->render_page(strtolower(__CLASS__) . '/bookingdetails_rfi', $data);
     }

     function bookingDetails_dc($id)
     {
          $bookId = encryptor($id, 'D');
          $data['banks'] = $this->evaluation->getAllBanks();
          $data['addressProof'] = $this->booking->getActiveAddressProof();
          $data['bookingDetails'] = $this->booking->getBookedVehicle($bookId);
          $data['rcTransferStatuses'] = $this->common_model->getStatuses('rfi-rc-trans');
          $data['rcTransferInsurnce'] = $this->common_model->getStatuses('rfi-ins-trans');
          $data['bookingFollowup'] = $this->booking->getBookingFollowup();
          $data['history'] = $this->load->view(strtolower(__CLASS__) . '/bookinghistory', $data['bookingDetails'], true);
          $this->render_page(strtolower(__CLASS__) . '/bookingdetails_dc', $data);
     }

     function decisionmaking()
     {
          //iHits Booking API
          $saleData = array();
          $finYearCode = get_ihits_fin_year_code();
          if ($_POST['status'] == 28) {
               $postData = unserialize($_POST['vehicleDetails']);
               $finYearCode = isset($postData['vbk_fin_year_code']) ? $postData['vbk_fin_year_code'] : 0;
               $salesCategory = '';
               if ($postData['brd_category'] == 0) { // Bikes
                    $salesCategory = 'Bikes';
               }
               if ($postData['brd_category'] == 1 && $postData['div_id'] == 1) { //Smart
                    $salesCategory = 'Budjected Cars';
               }
               if ($postData['brd_category'] == 1 && $postData['div_id'] == 2) { //Luxury
                    $salesCategory = 'Luxury Cars';
               }
               //$saleData['tcs'] = isset($postData['vbk_tcs']) ? (int) $postData['vbk_tcs'] : 0;
               /*$saleData['brd_title'] = $postData['brd_title'];
               $saleData['mod_title'] = $postData['mod_title'];
               $saleData['var_variant_name'] = $postData['var_variant_name'];
               $saleData['vc_color'] = !empty($postData['val_color']) ? $postData['val_color'] : "";
               $saleData['val_model_year'] = (int) $postData['val_model_year'];
               $saleData['val_engine_no'] = $postData['val_engine_no'];
               $saleData['val_chasis_no'] = $postData['val_chasis_no'];
               $saleData['val_veh_no'] = str_replace('-', '', $postData['val_veh_no']);
               $saleData['vbk_cust_name'] = $postData['vbk_cust_name'];
               $saleData['vbk_per_address'] = $postData['vbk_per_address'];
               $saleData['vbk_rd_trans_address'] = $postData['vbk_rd_trans_address'];
               $saleData['vbk_state'] = $postData['sts_name'];
               $saleData['vbk_dist'] = $postData['std_district_name'];
               $saleData['vbk_sales_staff_name'] = $postData['bkdby_username'];
               $saleData['vbk_added_on'] = date('Y-m-d', strtotime($postData['vbk_added_on']));
               $saleData['vbk_ttl_sale_amt'] = (int) $postData['vbk_ttl_sale_amt'] - (int) $postData['vbk_bl_amt'];
               $saleData['vbk_advance_amt'] = (int) $postData['vbk_advance_amt'];
               $saleData['vbk_discount'] = (int) $postData['vbk_bl_amt'];
               $saleData['vbk_sale_type'] = $salesCategory;
               $saleData['shr_location'] = $postData['shr_location'];
               $saleData['enq_trans_mode'] = 'C';
               $saleData['vbk_ref_no'] = $postData['vbk_ref_no'];
               $saleData['stockID'] = $postData['val_stock_num'];
               $enq = isset($postData['confim']['vbc_enq_id']) ? $postData['confim']['vbc_enq_id'] : 0;
               $bkid = isset($postData['confim']['vbc_book_master']) ? $postData['confim']['vbc_book_master'] : 0;
               $val = isset($postData['vbk_evaluation_veh_id']) ? $postData['vbk_evaluation_veh_id'] : 0;
               $this->ihits->ihitsSales($saleData, $enq, $bkid, $val);*/

               //Token API
               // $saleData['brd_title'] = $postData['brd_title'];
               // $saleData['mod_title'] = $postData['mod_title'];
               // $saleData['vc_color'] = !empty($postData['val_color']) ? $postData['val_color'] : "";
               // $saleData['val_model_year'] = (int) $postData['val_model_year'];
               // $saleData['val_engine_no'] = $postData['val_engine_no'];
               // $saleData['val_chasis_no'] = $postData['val_chasis_no'];
               // $saleData['val_veh_no'] = str_replace('-', '', $postData['val_veh_no']);
               // $saleData['vbk_cust_name'] = $postData['vbk_cust_name'];
               // $saleData['vbk_per_address'] = $postData['vbk_per_address'];
               // $saleData['vbk_rd_trans_address'] = $postData['vbk_rd_trans_address'];
               // $saleData['vbk_state'] = $postData['sts_name'];
               // $saleData['vbk_dist'] = $postData['std_district_name'];
               // $saleData['vbk_sales_staff_name'] = $postData['bkdby_username'];
               // $saleData['vbk_added_on'] = date('Y-m-d', strtotime($postData['vbk_added_on']));
               // //$saleData['vbk_ttl_sale_amt'] = (int) $postData['vbk_ttl_sale_amt'] - (int) $postData['vbk_bl_amt'];
               // $saleData['vbk_ttl_sale_amt'] = (int) $postData['vbk_vehicle_amt'];
               // $saleData['vbk_advance_amt'] = (int) $postData['vbk_advance_amt'];
               // $saleData['vbk_sale_type'] = $salesCategory;
               // $saleData['shr_location'] = $postData['shr_location'];
               // $saleData['enq_trans_mode'] = 'C';
               // $saleData['var_variant_name'] = $postData['var_variant_name'];
               // $saleData['stockID'] = $postData['val_stock_num'];
               // $saleData['dueDate'] = date('Y-m-d');
               // $saleData['gcCode'] = (int) $finYearCode;
               // $enq = isset($postData['confim']['vbc_enq_id']) ? $postData['confim']['vbc_enq_id'] : 0;
               // $bkid = isset($postData['confim']['vbc_book_master']) ? $postData['confim']['vbc_book_master'] : 0;
               // $val = isset($postData['vbk_evaluation_veh_id']) ? $postData['vbk_evaluation_veh_id'] : 0;
               //$this->ihits->ihitsSalesToken($saleData, $enq, $bkid, $val);
          }
          //iHits Booking API
          $this->load->library('upload');
          $masterId = isset($_POST['confim']['vbc_book_master']) ? $_POST['confim']['vbc_book_master'] : 0;
          if ($masterId > 0) {
               $docNos = isset($_FILES['papers']['name']) ? count($_FILES['papers']['name']) : 0;
               $newFileName = '';
               if ($docNos > 0 && (isset($_FILES['papers']['name'][0]) && !empty($_FILES['papers']['name'][0]))) {
                    for ($i = 0; $i < $docNos; $i++) {
                         if (isset($_FILES['papers']['name'][$i]) && !empty($_FILES['papers']['name'][$i])) {
                              $ext = explode(".", $_FILES['papers']['name'][$i]);
                              $ext = '.' . end($ext);
                              $newFileName = rand() . time() . $ext;
                              $config['upload_path'] = '../rdms/assets/uploads/documents/booking/';
                              $config['allowed_types'] = '*';
                              $config['file_name'] = $newFileName;
                              $this->upload->initialize($config);
                              $_FILES['prd_image_tmp']['name'] = $_FILES['papers']['name'][$i];
                              $_FILES['prd_image_tmp']['type'] = $_FILES['papers']['type'][$i];
                              $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['papers']['tmp_name'][$i];
                              $_FILES['prd_image_tmp']['error'] = $_FILES['papers']['error'][$i];
                              $_FILES['prd_image_tmp']['size'] = $_FILES['papers']['size'][$i];

                              if ($this->upload->do_upload('prd_image_tmp')) {
                                   $uploadData = $this->upload->data();
                              } else {
                                   $uploadData = $this->upload->display_errors();
                              }
                         }
                         $this->booking->uploadDocuments(
                              array(
                                   'vbd_doc_file' => $newFileName,
                                   'vbd_master_id' => $masterId,
                                   'vbd_doc_type' => isset($_POST['docs']['type'][$i]) ? $_POST['docs']['type'][$i] : 0,
                                   'vbd_doc_number' => isset($_POST['docs']['number'][$i]) ? $_POST['docs']['number'][$i] : 0
                              )
                         );
                    }
               }
          }
          $this->booking->decisionmaking($this->input->post());
          redirect(__CLASS__ . '/bookedvehicles');
     }

     function getRejectedBooking()
     {
          $data['rejectedBooking'] = $this->booking->getRejectBooking();
          $this->render_page(strtolower(__CLASS__) . '/rejectedBooking', $data);
     }

     function rejectedBookingDetails($id)
     {
          $bookId = encryptor($id, 'D');
          $data['bookingDetails'] = $this->booking->getBookedVehicle($bookId);
          $enqId = $data['bookingDetails']['vbk_enq_id'];
          $vehId = $data['bookingDetails']['vbk_evaluation_veh_id'];
          $data['enquiry'] = $this->enquiry->enquires($enqId);
          $data['vehicles'] = $this->evaluation->getEvaluationPrint($vehId);
          $data['addressProof'] = $this->booking->getActiveAddressProof();
          $data['history'] = $this->load->view(strtolower(__CLASS__) . '/bookinghistory', $data['bookingDetails'], true);
          $this->render_page(strtolower(__CLASS__) . '/rejectedBookingDetails', $data);
     }

     function removeDocuments($fileId)
     {
          $fileId = encryptor($fileId, 'D');
          $this->booking->removeDocuments($fileId);
          die(json_encode(array('status' => 'success', 'msg' => 'Row deleted!')));
     }

     function resubmitReserveVehicle()
     {
          $this->load->library('upload');
          $docNos = isset($_POST['ap_new']['vbd_doc_type']) ? count($_POST['ap_new']['vbd_doc_type']) : 0;
          $masterId = isset($_POST['bm']['vbk_id']) ? $_POST['bm']['vbk_id'] : 0;
          $newFileName = '';
          if ($docNos > 0) {
               for ($i = 0; $i < $docNos; $i++) {
                    if (isset($_FILES['vbd_doc_file']['name'][$i]) && !empty($_FILES['vbd_doc_file']['name'][$i])) {
                         $ext = explode(".", $_FILES['vbd_doc_file']['name'][$i]);
                         $ext = '.' . end($ext);
                         $newFileName = rand() . time() . $ext;
                         $config['upload_path'] = '../rdms/assets/uploads/documents/booking/';
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
                    $this->booking->uploadDocuments(
                         array(
                              'vbd_doc_file' => $newFileName,
                              'vbd_master_id' => $masterId,
                              'vbd_doc_type' => isset($_POST['ap_new']['vbd_doc_type'][$i]) ? $_POST['ap_new']['vbd_doc_type'][$i] : 0,
                              'vbd_doc_number' => isset($_POST['ap_new']['vbd_doc_number'][$i]) ? $_POST['ap_new']['vbd_doc_number'][$i] : 0
                         )
                    );
               }
          }
          $this->booking->resubmitReserveVehicle($this->input->post());
          redirect(__CLASS__ . '/bookedvehicles');
     }

     function permenentdeletebooking($bkid)
     {
          $bkid = encryptor($bkid, 'D');
          $this->booking->permenentdeletebooking($bkid);
          die(json_encode(array('status' => 'success', 'msg' => 'Row deleted!')));
     }

     function submitBookingFollowup()
     {
          $this->booking->bookingFollowup($this->input->post());
     }

     function bookingCancelled()
     {
          $stsId = isset($_GET['s']) ? encryptor($_GET['s'], 'D') : 0;
          $data['bookingCancelled'] = $this->booking->cancelledBookings();
          $this->render_page(strtolower(__CLASS__) . '/cancelledvehicle', $data);
     }

     function editBooking($bookId = 0)
     {
          error_reporting(E_ALL);
          if (!empty($_POST)) {

               $_POST['bm']['vbk_insurance_idv'] = (isset($_POST['bm']['vbk_insurance_idv']) && ($_POST['bm']['vbk_insurance_idv'] != '')) ? $_POST['bm']['vbk_insurance_idv'] : 0.00;
               $_POST['bm']['vbk_insurance_amt'] = (isset($_POST['bm']['vbk_insurance_amt']) && ($_POST['bm']['vbk_insurance_amt'] != '')) ? $_POST['bm']['vbk_insurance_amt'] : 0.00;
               $_POST['bm']['vbk_vehicle_amt'] = (isset($_POST['bm']['vbk_vehicle_amt']) && ($_POST['bm']['vbk_vehicle_amt'] != '')) ? $_POST['bm']['vbk_vehicle_amt'] : 0.00;
               $_POST['bm']['vbk_tcs'] = (isset($_POST['bm']['vbk_tcs']) && ($_POST['bm']['vbk_tcs'] != '')) ? $_POST['bm']['vbk_tcs'] : 0.00;
               $_POST['bm']['vbk_rto_charges'] = (isset($_POST['bm']['vbk_rto_charges']) && ($_POST['bm']['vbk_rto_charges'] != '')) ? $_POST['bm']['vbk_rto_charges'] : 0.00;
               $_POST['bm']['vbk_refurbish_cost'] = (isset($_POST['bm']['vbk_refurbish_cost']) && ($_POST['bm']['vbk_refurbish_cost'] != '')) ? $_POST['bm']['vbk_refurbish_cost'] : 0.00;
               $_POST['bm']['vbk_accessories_cost'] = (isset($_POST['bm']['vbk_accessories_cost']) && ($_POST['bm']['vbk_accessories_cost'] != '')) ? $_POST['bm']['vbk_accessories_cost'] : 0.00;
               $_POST['bm']['vbk_ttl_sale_amt'] = (isset($_POST['bm']['vbk_ttl_sale_amt']) && ($_POST['bm']['vbk_ttl_sale_amt'] != '')) ? $_POST['bm']['vbk_ttl_sale_amt'] : 0.00;
               $_POST['bm']['vbk_advance_amt'] = (isset($_POST['bm']['vbk_advance_amt']) && ($_POST['bm']['vbk_advance_amt'] != '')) ? $_POST['bm']['vbk_advance_amt'] : 0.00;
               $_POST['bm']['vbk_balance'] = (isset($_POST['bm']['vbk_balance']) && ($_POST['bm']['vbk_balance'] != '')) ? $_POST['bm']['vbk_balance'] : 0.00;

               $masterId = $_POST['bm']['vbk_id'];
               $docNos = isset($_FILES['papers']['name']) ? count($_FILES['papers']['name']) : 0;
               $newFileName = '';
               if ($docNos > 0 && (isset($_FILES['papers']['name'][0]) && !empty($_FILES['papers']['name'][0]))) {
                    $this->load->library('upload');
                    for ($i = 0; $i < $docNos; $i++) {
                         if (isset($_FILES['papers']['name'][$i]) && !empty($_FILES['papers']['name'][$i])) {
                              $ext = explode(".", $_FILES['papers']['name'][$i]);
                              $ext = '.' . end($ext);
                              $newFileName = rand() . time() . $ext;
                              $config['upload_path'] = '../rdms/assets/uploads/documents/booking/';
                              $config['allowed_types'] = '*';
                              $config['file_name'] = $newFileName;
                              $this->upload->initialize($config);
                              $_FILES['prd_image_tmp']['name'] = $_FILES['papers']['name'][$i];
                              $_FILES['prd_image_tmp']['type'] = $_FILES['papers']['type'][$i];
                              $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['papers']['tmp_name'][$i];
                              $_FILES['prd_image_tmp']['error'] = $_FILES['papers']['error'][$i];
                              $_FILES['prd_image_tmp']['size'] = $_FILES['papers']['size'][$i];

                              if ($this->upload->do_upload('prd_image_tmp')) {
                                   $uploadData = $this->upload->data();
                              } else {
                                   $uploadData = $this->upload->display_errors();
                                   debug($uploadData);
                              }
                         }
                         $this->booking->uploadDocuments(
                              array(
                                   'vbd_doc_file' => $newFileName,
                                   'vbd_master_id' => $masterId,
                                   'vbd_doc_type' => isset($_POST['docs']['type'][$i]) ? $_POST['docs']['type'][$i] : 0,
                                   'vbd_doc_number' => isset($_POST['docs']['number'][$i]) ? $_POST['docs']['number'][$i] : 0
                              )
                         );
                    }
               }

               $this->booking->editBooking($_POST);
               if (isset($_POST['bm']['vbk_delivery_date']) && !empty($_POST['bm']['vbk_delivery_date'])) { //iHits Sales API
                    $postData = unserialize($_POST['vehicleDetails']);
                    $finYearCode = isset($postData['vbk_fin_year_code']) ? $postData['vbk_fin_year_code'] : 0;
                    $salesCategory = '';
                    if ($postData['brd_category'] == 0) { // Bikes
                         $salesCategory = 'Bikes';
                    }
                    if ($postData['brd_category'] == 1 && $postData['div_id'] == 1) { //Smart
                         $salesCategory = 'Budjected Cars';
                    }
                    if ($postData['brd_category'] == 1 && $postData['div_id'] == 2) { //Luxury
                         $salesCategory = 'Luxury Cars';
                    }
                    $saleData['tcS_Amt'] = isset($postData['vbk_tcs']) ? (int) $postData['vbk_tcs'] : 0;
                    $saleData['brd_title'] = $postData['brd_title'];
                    $saleData['mod_title'] = $postData['mod_title'];
                    $saleData['var_variant_name'] = $postData['var_variant_name'];
                    $saleData['vc_color'] = !empty($postData['val_color']) ? $postData['val_color'] : "";
                    $saleData['val_model_year'] = (int) $postData['val_model_year'];
                    $saleData['val_engine_no'] = $postData['val_engine_no'];
                    $saleData['val_chasis_no'] = $postData['val_chasis_no'];
                    $saleData['val_veh_no'] = str_replace('-', '', $postData['val_veh_no']);
                    $saleData['vbk_cust_name'] = $postData['vbk_cust_name'];
                    $saleData['vbk_per_address'] = $postData['vbk_per_address'];
                    $saleData['vbk_rd_trans_address'] = $postData['vbk_rd_trans_address'];
                    $saleData['vbk_state'] = $postData['sts_name'];
                    $saleData['vbk_dist'] = $postData['std_district_name'];
                    $saleData['vbk_sales_staff_name'] = $postData['bkdby_username'];
                    $saleData['vbk_added_on'] = date('Y-m-d', strtotime($postData['vbk_added_on']));
                    //$saleData['vbk_ttl_sale_amt'] = (int) $postData['vbk_ttl_sale_amt'] - (int) $postData['vbk_bl_amt'];
                    $saleData['vbk_ttl_sale_amt'] = (int) $postData['vbk_vehicle_amt'];
                    $saleData['vbk_advance_amt'] = (int) $postData['vbk_advance_amt'];
                    $saleData['vbk_discount'] = (int) $postData['vbk_bl_amt'];
                    $saleData['vbk_sale_type'] = $salesCategory;
                    $saleData['shr_location'] = $postData['shr_location'];
                    $saleData['enq_trans_mode'] = 'C';
                    $saleData['vbk_ref_no'] = $postData['vbk_ref_no'];
                    $saleData['stockID'] = $postData['val_stock_num'];
                    $saleData['gcCode'] = (int) $finYearCode;
                    $enq = isset($postData['enq_id']) ? $postData['enq_id'] : 0;
                    $bkid = isset($postData['vbk_id']) ? $postData['vbk_id'] : 0;
                    $val = isset($postData['vbk_evaluation_veh_id']) ? $postData['vbk_evaluation_veh_id'] : 0;
                    //$this->ihits->ihitsSales($saleData, $enq, $bkid, $val);
               }
               redirect(__CLASS__ . '/editbooking/' . encryptor($_POST['bm']['vbk_id']));
          }
          $bookId = encryptor($bookId, 'D');
          $data['bookingDetails'] = $this->booking->getBookedVehicle($bookId);
          $data['addressProof'] = $this->booking->getActiveAddressProof(1);
          $data['vehicles'] = $this->evaluation->getEvaluationPrint($data['bookingDetails']['vbk_evaluation_veh_id']);
          $data['history'] = $this->load->view(strtolower(__CLASS__) . '/bookinghistory', $data['bookingDetails'], true);
          $this->render_page(strtolower(__CLASS__) . '/editBookingDetails', $data);
     }
     function print_obf($id)
     {
          $bookId = encryptor($id, 'D');
          $data['addressProof'] = $this->booking->getActiveAddressProof(1);
          $data['bookingDetails'] = $this->booking->getBookedVehicle($bookId);
          $data['panCard'] = $this->booking->getPanCard($bookId);
          $this->booking->pendingDocs($bookId);
          $data['history'] = $this->load->view(strtolower(__CLASS__) . '/bookinghistory', $data['bookingDetails'], true);
          $this->render_page(strtolower(__CLASS__) . '/print_bookingdetails', $data);
     }

     function allreservation()
     {
          $data['bookingVehicles'] = $this->booking->getAllReservation($_GET);
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
          $this->render_page(strtolower(__CLASS__) . '/allreservation', $data);
     }
     function todaysRetails()
     {
          if (check_permission('booking', 'showall')) {
          } else if (check_permission('booking', 'mybking')) {
               $this->db->where('vbk_added_by', $this->uid);
          } else if (check_permission('booking', 'mystaffbking')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if (check_permission('booking', 'myshowroombking')) {
               $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
          } else if (check_permission('booking', 'mydivisionbking')) {
               $this->db->where($this->tbl_divisions . '.div_id', $this->div);
          } else {
               return false;
          }

          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.vbk_id',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               'bkdby.usr_first_name AS bkdby_first_name',
               'bkdby.usr_last_name AS bkdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name',
               'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_divisions . '.div_name',
               $this->tbl_showroom . '.shr_location'
          );

          $today = date('Y-m-d'); // Get current date
          $currentTime = date('Y-m-d H:i:s'); // Get current datetime
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               // ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT') //  AND vbk_rfi_rc_trans_sts > 0
               //->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT') //  AND vbk_ins_trans_sts > 0
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->where($this->tbl_vehicle_booking_master . '.vbk_added_on >=', $today . ' 00:00:00')
               ->where($this->tbl_vehicle_booking_master . '.vbk_added_on <=', $currentTime)
               ->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del, book_delvry))
               ->order_by("vbk_added_on", "desc")
               ->get($this->tbl_vehicle_booking_master)->result_array();
          return $bookedVehicle;
     }

     function pushsalespreview($bkId)
     {
          $bookingDetails = $this->booking->BookingDetailsPushsales($bkId);
          $finYearCode = isset($bookingDetails['vbk_fin_year_code']) ? $bookingDetails['vbk_fin_year_code'] : 0;
          $this->load->model('ihits_api/ihits_api_model', 'ihits');
          //if ($bookingDetails['brd_category'] == 0) { // Bikes
          $salesCategory = 'Bikes';
          //}
          if ($bookingDetails['brd_category'] == 1 && $bookingDetails['div_id'] == 1) { //Smart
               $salesCategory = 'Smart';
          }
          if ($bookingDetails['brd_category'] == 1 && $bookingDetails['div_id'] == 2) { //Luxury
               $salesCategory = 'Luxury Cars';
          }
          $data['saleData']['brd_title'] = (string) $bookingDetails['brd_title'];
          $data['saleData']['mod_title'] = (string) $bookingDetails['mod_title'];
          $data['saleData']['var_variant_name'] = (string) $bookingDetails['var_variant_name'];
          $data['saleData']['vc_color'] = !empty($bookingDetails['val_color']) ? (string) $bookingDetails['val_color'] : "";
          $data['saleData']['val_model_year'] = (int) $bookingDetails['val_model_year'];
          $data['saleData']['val_engine_no'] = (string) strtoupper($bookingDetails['val_engine_no']);
          $data['saleData']['val_chasis_no'] = (string) strtoupper($bookingDetails['val_chasis_no']);
          $data['saleData']['val_veh_no'] = str_replace('-', '', $bookingDetails['val_veh_no']);
          $data['saleData']['vbk_cust_name'] = (string) $bookingDetails['vbk_cust_name'];
          $data['saleData']['vbk_per_address'] = (string) $bookingDetails['vbk_per_address'];
          $data['saleData']['vbk_rd_trans_address'] = (string) $bookingDetails['vbk_rd_trans_address'];
          $data['saleData']['vbk_state'] = (string) $bookingDetails['sts_name'];
          $data['saleData']['vbk_dist'] = (string) $bookingDetails['std_district_name'];
          $data['saleData']['vbk_sales_staff_name'] = (string) $bookingDetails['bkdby_username'];
          $data['saleData']['vbk_added_on'] = date(DATE_FORMAT_COMMON, strtotime($bookingDetails['vbk_added_on']));
          $data['saleData']['vbk_ttl_sale_amt'] = (int) $bookingDetails['vbk_ttl_sale_amt'];
          $data['saleData']['vbk_advance_amt'] = (int) $bookingDetails['vbk_advance_amt'];
          $data['saleData']['vbk_discount'] = (int) $bookingDetails['vbk_discount'];
          $data['saleData']['vbk_sale_type'] = (string) $salesCategory;
          $data['saleData']['shr_location'] = (string) $bookingDetails['shr_location'];
          $data['saleData']['enq_trans_mode'] = 'C';
          $data['saleData']['vbk_ref_no'] = (string) $bookingDetails['vbk_ref_no'];
          $data['saleData']['stockID'] = (string) $bookingDetails['val_stock_num'];
          $data['saleData']['gcCode'] = (int) $finYearCode;
          $data['saleData']['tcS_Amt'] = (int) $bookingDetails['vbk_tcs'];
          $data['bkId'] = $bkId;
          $data['company'] = $this->booking->getCompany();
          $this->render_page(strtolower(__CLASS__) . '/pushsalespreview', $data);
     }

     function pushsalestokenpreview($bkId)
     {
          $bookingDetails = $this->booking->BookingDetailsPushsales($bkId);
          $this->load->model('ihits_api/ihits_api_model', 'ihits');
          //if ($bookingDetails['brd_category'] == 0) { // Bikes
          $salesCategory = 'Bikes';
          //}
          if ($bookingDetails['brd_category'] == 1 && $bookingDetails['div_id'] == 1) { //Smart
               $salesCategory = 'Smart';
          }
          if ($bookingDetails['brd_category'] == 1 && $bookingDetails['div_id'] == 2) { //Luxury
               $salesCategory = 'Luxury Cars';
          }
          $data['saleData']['brd_title'] = (string) $bookingDetails['brd_title'];
          $data['saleData']['mod_title'] = (string) $bookingDetails['mod_title'];
          $data['saleData']['var_variant_name'] = (string) $bookingDetails['var_variant_name'];
          $data['saleData']['vc_color'] = !empty($bookingDetails['val_color']) ? (string) $bookingDetails['val_color'] : "";
          $data['saleData']['val_model_year'] = (int) $bookingDetails['val_model_year'];
          $data['saleData']['val_engine_no'] = (string) strtoupper($bookingDetails['val_engine_no']);
          $data['saleData']['val_chasis_no'] = (string) strtoupper($bookingDetails['val_chasis_no']);
          $data['saleData']['val_veh_no'] = str_replace('-', '', $bookingDetails['val_veh_no']);
          $data['saleData']['vbk_cust_name'] = (string) $bookingDetails['vbk_cust_name'];
          $data['saleData']['vbk_per_address'] = (string) $bookingDetails['vbk_per_address'];
          $data['saleData']['vbk_rd_trans_address'] = (string) $bookingDetails['vbk_rd_trans_address'];
          $data['saleData']['vbk_state'] = (string) $bookingDetails['sts_name'];
          $data['saleData']['vbk_dist'] = (string) $bookingDetails['std_district_name'];
          $data['saleData']['vbk_sales_staff_name'] = (string) $bookingDetails['bkdby_username'];
          $data['saleData']['vbk_added_on'] = date(DATE_FORMAT_COMMON, strtotime($bookingDetails['vbk_added_on']));
          $data['saleData']['vbk_ttl_sale_amt'] = (int) $bookingDetails['vbk_ttl_sale_amt'];
          $data['saleData']['vbk_advance_amt'] = (int) $bookingDetails['vbk_advance_amt'];
          $data['saleData']['dc'] = (int) $bookingDetails['vbk_discount'];
          $data['saleData']['vbk_sale_type'] = (string) $salesCategory;
          $data['saleData']['shr_location'] = (string) $bookingDetails['shr_location'];
          $data['saleData']['enq_trans_mode'] = 'C';
          //$data['saleData']['vbk_ref_no'] = (string) $bookingDetails['vbk_ref_no'];
          $data['saleData']['stockID'] = (string) $bookingDetails['val_stock_num'];
          $data['saleData']['gcCode'] = (int) $bookingDetails['vbk_fin_year_code'];
          $date['saleData']['dueDate'] = date(DATE_FORMAT_COMMON, strtotime($bookingDetails['vbk_added_on']));
          $data['bkId'] = $bkId;
          $data['company'] = $this->booking->getCompany();
          $this->render_page(strtolower(__CLASS__) . '/pushsalestokenpreview', $data);
     }

     function pushsales()
     {
          $bkId = $this->input->post('bkId');
          $bookingData = $this->booking->BookingDetailsPushsales($bkId);

          $bookingDetails = $this->input->post('postfields');
          //RTO Charges
          /*if (isset($bookingData['vbk_rto_charges']) &&  ((int) $bookingData['vbk_rto_charges'] > 0)) {
               $this->ihits->ihitsSaveExpense(array(
                    'billNo' => 'RD-' . rand(100, 9999999),
                    'billDate' => date('Y-m-d'),
                    'partyName' => 'RTO Charges',
                    'registrationNo' => $bookingDetails['val_veh_no'],
                    'expTotAmount' => (float) $bookingData['vbk_rto_charges'],
                    'remarks' => 'Paid RTO charges for ' . $bookingDetails['val_veh_no'],
                    'bookingNo' => '',
                    'expType' => 'RTO Charges',
                    'expAmount' => 0,
                    'sgstPer' => 0,
                    'sgstAmount' => 0,
                    'cgstPer' => 0,
                    'cgstAmount' => 0,
                    'igstPer' => 0,
                    'igstAmount' => 0,
                    'totalAmount' => (float) $bookingData['vbk_rto_charges'],
                    'mode' => 'C',
               ));
          }*/

          $this->load->model('ihits_api/ihits_api_model', 'ihits');
          $saleData['brd_title'] = (string) $bookingDetails['brd_title'];
          $saleData['mod_title'] = (string) $bookingDetails['mod_title'];
          $saleData['var_variant_name'] = (string) $bookingDetails['var_variant_name'];
          $saleData['vc_color'] = !empty($bookingDetails['vc_color']) ? (string) $bookingDetails['vc_color'] : "";
          $saleData['val_model_year'] = (int) $bookingDetails['val_model_year'];
          $saleData['val_engine_no'] = (string) $bookingDetails['val_engine_no'];
          $saleData['val_chasis_no'] = (string) $bookingDetails['val_chasis_no'];
          $saleData['val_veh_no'] = $bookingDetails['val_veh_no'];
          $saleData['vbk_cust_name'] = (string) $bookingDetails['vbk_cust_name'];
          $saleData['vbk_per_address'] = (string) $bookingDetails['vbk_per_address'];
          $saleData['vbk_rd_trans_address'] = (string) $bookingDetails['vbk_rd_trans_address'];
          $saleData['vbk_state'] = (string) $bookingDetails['vbk_state'];
          $saleData['vbk_dist'] = (string) $bookingDetails['vbk_dist'];
          $saleData['vbk_sales_staff_name'] = (string) $bookingDetails['vbk_sales_staff_name'];
          $saleData['vbk_added_on'] = $bookingDetails['vbk_added_on'];
          $saleData['vbk_ttl_sale_amt'] = (int) $bookingDetails['vbk_ttl_sale_amt'];
          $saleData['vbk_advance_amt'] = (int) $bookingDetails['vbk_advance_amt'];
          $saleData['vbk_discount'] = (int) $bookingDetails['vbk_discount'];
          $saleData['vbk_sale_type'] = (string)$bookingDetails['vbk_sale_type'];
          $saleData['shr_location'] = (string) $bookingDetails['shr_location'];
          $saleData['enq_trans_mode'] = (string) $bookingDetails['enq_trans_mode'];
          $saleData['vbk_ref_no'] = (string) $bookingDetails['vbk_ref_no'];
          $saleData['gcCode'] = (int) $bookingDetails['gcCode'];
          $saleData['TCS_Amt'] = (int) $bookingDetails['tcS_Amt'];
          $saleData['stockID'] = (string) $bookingDetails['stockID'];
          //debug($saleData, 0);
          $responce = unserialize($this->ihits->ihitsSales($saleData));
          // echo 'Stock ID : ' . $saleData['stockID'] . '<br>';
          // echo 'Booking ID : ' . $bkId . '<br>';
          // echo 'Registration : ' . $saleData['val_veh_no'] . '<br>';
          $message = isset($responce->message) ? $responce->message : '';
          $this->booking->updatedSaleApproval($this->input->post(), $bkId);
          if (isset($responce->success) && ($responce->success == 1)) {
               $this->session->set_flashdata('app_success', $message);
               redirect(__CLASS__ . '/pendningbookingapproval');
          } else {
               $this->session->set_flashdata('app_success', $message);
               redirect(__CLASS__ . '/pushsalespreview/' . $bkId);
          }
     }

     function pushsalestoken()
     {
          $bookingDetails = $this->input->post('postfields');
          $bkId = $this->input->post('bkId');
          $this->load->model('ihits_api/ihits_api_model', 'ihits');
          $saleData['brd_title'] = (string) $bookingDetails['brd_title'];
          $saleData['mod_title'] = (string) $bookingDetails['mod_title'];
          $saleData['var_variant_name'] = (string) $bookingDetails['var_variant_name'];
          $saleData['vc_color'] = !empty($bookingDetails['vc_color']) ? (string) $bookingDetails['vc_color'] : "";
          $saleData['val_model_year'] = (int) $bookingDetails['val_model_year'];
          $saleData['val_engine_no'] = (string) $bookingDetails['val_engine_no'];
          $saleData['val_chasis_no'] = (string) $bookingDetails['val_chasis_no'];
          $saleData['val_veh_no'] = $bookingDetails['val_veh_no'];
          $saleData['vbk_cust_name'] = (string) $bookingDetails['vbk_cust_name'];
          $saleData['vbk_per_address'] = (string) $bookingDetails['vbk_per_address'];
          $saleData['vbk_rd_trans_address'] = (string) $bookingDetails['vbk_rd_trans_address'];
          $saleData['vbk_state'] = (string) $bookingDetails['vbk_state'];
          $saleData['vbk_dist'] = (string) $bookingDetails['vbk_dist'];
          $saleData['vbk_sales_staff_name'] = (string) $bookingDetails['vbk_sales_staff_name'];
          $saleData['vbk_added_on'] = $bookingDetails['vbk_added_on'];
          $saleData['vbk_ttl_sale_amt'] = (int) $bookingDetails['vbk_ttl_sale_amt'];
          $saleData['vbk_advance_amt'] = (int) $bookingDetails['vbk_advance_amt'];
          $saleData['dc'] = (int) $bookingDetails['dc'];
          $saleData['vbk_sale_type'] = (string)$bookingDetails['vbk_sale_type'];
          $saleData['shr_location'] = (string) $bookingDetails['shr_location'];
          $saleData['enq_trans_mode'] = (string) $bookingDetails['enq_trans_mode'];
          //$saleData['vbk_ref_no'] = (string) $bookingDetails['vbk_ref_no'];
          $saleData['stockID'] = (string) $bookingDetails['stockID'];
          $saleData['dueDate'] = (string) $bookingDetails['dueDate'];
          $saleData['gcCode'] = (int) $bookingDetails['gcCode'];
          //echo count($saleData);
          //debug($saleData, 0);
          //echo json_encode($saleData);
          //debug($responce, 0);
          // echo 'Stock ID : ' . $saleData['stockID'] . '<br>';
          // echo 'Booking ID : ' . $bkId . '<br>';
          // echo 'Registration : ' . $saleData['val_veh_no'] . '<br>';
          $responce = unserialize($this->ihits->ihitsSalesToken($saleData));
          $message = isset($responce->message) ? $responce->message : '';
          $this->booking->updatedSaleTokenApproval($this->input->post(), $bkId);
          if (isset($responce->success) && ($responce->success == 1)) {
               $this->session->set_flashdata('app_success', $message);
               redirect(__CLASS__ . '/pendningbookingapproval');
          } else {
               $this->session->set_flashdata('app_success', $message);
               redirect(__CLASS__ . '/pushsalestokenpreview/' . $bkId);
          }
     }

     function tokenreceived()
     {
          $data['salesExecutives'] = $this->booking->salesExecutives();
          $data['showroom'] = $this->booking->showroom();
          $this->render_page(strtolower(__CLASS__) . '/tokenreceived', $data);
     }

     function tokenReceivedAjax()
     {
          $this->page_title = 'Token received';
          $response =  $this->booking->tokenReceivedAjax($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     function pendningbookingapproval()
     {
          $this->render_page(strtolower(__CLASS__) . '/pendningbookingapproval');
     }

     function pendningbookingapprovalAjax()
     {
          echo json_encode($this->booking->pendningbookingapprovalAjax($this->input->post(), $this->input->get()));
     }

     function deletesales($category,  $bkId)
     {
          $this->page_title = 'Delete sales ' . $category;
          if (!empty($_POST)) {
               $bookingDetails = $this->input->post('postfields');
               $bkId = $this->input->post('bkId');
               $this->load->model('ihits_api/ihits_api_model', 'ihits');
               if ($category == 'token') {
                    $saleData['brd_title'] = (string) $bookingDetails['brd_title'];
                    $saleData['mod_title'] = (string) $bookingDetails['mod_title'];
                    $saleData['var_variant_name'] = (string) $bookingDetails['var_variant_name'];
                    $saleData['vc_color'] = !empty($bookingDetails['vc_color']) ? (string) $bookingDetails['vc_color'] : "";
                    $saleData['val_model_year'] = (int) $bookingDetails['val_model_year'];
                    $saleData['val_engine_no'] = (string) $bookingDetails['val_engine_no'];
                    $saleData['val_chasis_no'] = (string) $bookingDetails['val_chasis_no'];
                    $saleData['val_veh_no'] = $bookingDetails['val_veh_no'];
                    $saleData['vbk_cust_name'] = (string) $bookingDetails['vbk_cust_name'];
                    $saleData['vbk_per_address'] = (string) $bookingDetails['vbk_per_address'];
                    $saleData['vbk_rd_trans_address'] = (string) $bookingDetails['vbk_rd_trans_address'];
                    $saleData['vbk_state'] = (string) $bookingDetails['vbk_state'];
                    $saleData['vbk_dist'] = (string) $bookingDetails['vbk_dist'];
                    $saleData['vbk_sales_staff_name'] = (string) $bookingDetails['vbk_sales_staff_name'];
                    $saleData['vbk_added_on'] = $bookingDetails['vbk_added_on'];
                    $saleData['vbk_ttl_sale_amt'] = (int) $bookingDetails['vbk_ttl_sale_amt'];
                    $saleData['vbk_advance_amt'] = (int) $bookingDetails['vbk_advance_amt'];
                    $saleData['dc'] = (int) $bookingDetails['dc'];
                    $saleData['vbk_sale_type'] = (string)$bookingDetails['vbk_sale_type'];
                    $saleData['shr_location'] = (string) $bookingDetails['shr_location'];
                    $saleData['enq_trans_mode'] = (string) $bookingDetails['enq_trans_mode'];
                    $saleData['stockID'] = (string) $bookingDetails['stockID'];
                    $saleData['dueDate'] = (string) $bookingDetails['dueDate'];
                    $saleData['gcCode'] = (int) $bookingDetails['gcCode'];
                    $responce = unserialize($this->ihits->ihitsSalesToken($saleData));
                    debug($responce);
                    $message = isset($responce->message) ? $responce->message : '';
                    $this->session->set_flashdata('app_success', $message);
                    redirect(__CLASS__ . '/deletesales/' . $category . '/' .  $bkId);
               } else if ($category == 'sales') {
                    $saleData['brd_title'] = (string) $bookingDetails['brd_title'];
                    $saleData['mod_title'] = (string) $bookingDetails['mod_title'];
                    $saleData['var_variant_name'] = (string) $bookingDetails['var_variant_name'];
                    $saleData['vc_color'] = !empty($bookingDetails['vc_color']) ? (string) $bookingDetails['vc_color'] : "";
                    $saleData['val_model_year'] = (int) $bookingDetails['val_model_year'];
                    $saleData['val_engine_no'] = (string) $bookingDetails['val_engine_no'];
                    $saleData['val_chasis_no'] = (string) $bookingDetails['val_chasis_no'];
                    $saleData['val_veh_no'] = $bookingDetails['val_veh_no'];
                    $saleData['vbk_cust_name'] = (string) $bookingDetails['vbk_cust_name'];
                    $saleData['vbk_per_address'] = (string) $bookingDetails['vbk_per_address'];
                    $saleData['vbk_rd_trans_address'] = (string) $bookingDetails['vbk_rd_trans_address'];
                    $saleData['vbk_state'] = (string) $bookingDetails['vbk_state'];
                    $saleData['vbk_dist'] = (string) $bookingDetails['vbk_dist'];
                    $saleData['vbk_sales_staff_name'] = (string) $bookingDetails['vbk_sales_staff_name'];
                    $saleData['vbk_added_on'] = $bookingDetails['vbk_added_on'];
                    $saleData['vbk_ttl_sale_amt'] = (int) $bookingDetails['vbk_ttl_sale_amt'];
                    $saleData['vbk_advance_amt'] = (int) $bookingDetails['vbk_advance_amt'];
                    $saleData['vbk_discount'] = (int) $bookingDetails['vbk_discount'];
                    $saleData['vbk_sale_type'] = (string)$bookingDetails['vbk_sale_type'];
                    $saleData['shr_location'] = (string) $bookingDetails['shr_location'];
                    $saleData['enq_trans_mode'] = (string) $bookingDetails['enq_trans_mode'];
                    $saleData['vbk_ref_no'] = (string) $bookingDetails['vbk_ref_no'];
                    $saleData['gcCode'] = (int) $bookingDetails['gcCode'];
                    $saleData['TCS_Amt'] = (int) $bookingDetails['tcS_Amt'];
                    $saleData['stockID'] = (string) $bookingDetails['stockID'];
                    // $saleData['dc'] = (int) $bookingDetails['dc'];
                    debug($saleData, 0);
                    $responce = unserialize($this->ihits->ihitsSales($saleData));
                    debug($responce);
                    $message = isset($responce->message) ? $responce->message : '';
                    $this->session->set_flashdata('app_success', $message);
                    redirect(__CLASS__ . '/deletesales/' . $category . '/' .  $bkId);
               }
          }
          $bookingDetails = $this->booking->BookingDetailsPushsales($bkId);
          $this->load->model('ihits_api/ihits_api_model', 'ihits');
          //if ($bookingDetails['brd_category'] == 0) { // Bikes
          $salesCategory = 'Bikes';
          //}
          if ($bookingDetails['brd_category'] == 1 && $bookingDetails['div_id'] == 1) { //Smart
               $salesCategory = 'Smart';
          }
          if ($bookingDetails['brd_category'] == 1 && $bookingDetails['div_id'] == 2) { //Luxury
               $salesCategory = 'Luxury Cars';
          }
          $data['saleData']['brd_title'] = (string) $bookingDetails['brd_title'];
          $data['saleData']['mod_title'] = (string) $bookingDetails['mod_title'];
          $data['saleData']['var_variant_name'] = (string) $bookingDetails['var_variant_name'];
          $data['saleData']['vc_color'] = !empty($bookingDetails['val_color']) ? (string) $bookingDetails['val_color'] : "";
          $data['saleData']['val_model_year'] = (int) $bookingDetails['val_model_year'];
          $data['saleData']['val_engine_no'] = (string) strtoupper($bookingDetails['val_engine_no']);
          $data['saleData']['val_chasis_no'] = (string) strtoupper($bookingDetails['val_chasis_no']);
          $data['saleData']['val_veh_no'] = str_replace('-', '', $bookingDetails['val_veh_no']);
          $data['saleData']['vbk_cust_name'] = (string) $bookingDetails['vbk_cust_name'];
          $data['saleData']['vbk_per_address'] = (string) $bookingDetails['vbk_per_address'];
          $data['saleData']['vbk_rd_trans_address'] = (string) $bookingDetails['vbk_rd_trans_address'];
          $data['saleData']['vbk_state'] = (string) $bookingDetails['sts_name'];
          $data['saleData']['vbk_dist'] = (string) $bookingDetails['std_district_name'];
          $data['saleData']['vbk_sales_staff_name'] = (string) $bookingDetails['bkdby_username'];
          $data['saleData']['vbk_added_on'] = date('Y-m-d', strtotime($bookingDetails['vbk_added_on']));
          $data['saleData']['vbk_ttl_sale_amt'] = (int) $bookingDetails['vbk_ttl_sale_amt'];
          $data['saleData']['vbk_advance_amt'] = (int) $bookingDetails['vbk_advance_amt'];
          $data['saleData']['dc'] = (int) $bookingDetails['vbk_discount'];
          $data['saleData']['vbk_sale_type'] = (string) $salesCategory;
          $data['saleData']['shr_location'] = (string) $bookingDetails['shr_location'];
          $data['saleData']['enq_trans_mode'] = 'D';
          $data['saleData']['vbk_ref_no'] = (string) $bookingDetails['vbk_ref_no'];
          $data['saleData']['stockID'] = (string) $bookingDetails['val_stock_num'];
          $data['saleData']['gcCode'] = (int) $bookingDetails['vbk_fin_year_code'];
          $date['saleData']['dueDate'] = date('Y-m-d', strtotime($bookingDetails['vbk_added_on']));
          $data['bkId'] = $bkId;
          $data['company'] = $this->booking->getCompany();
          $data['category'] = $category;

          $this->render_page(strtolower(__CLASS__) . '/deletesales', $data);
     }
}
