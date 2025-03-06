<?php

defined('BASEPATH') or exit('No direct script access allowed');

class tracking extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'Vehcle Tracking';
          $this->load->model('evaluation/evaluation_model', 'evaluation');
          $this->load->model('emp_details/emp_details_model', 'employees');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('tracking_model', 'tracking');
     }

     public function index()
     {
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }
     public function list_ajax()
     {
          $response = $this->tracking->getTrackingPaginate($this->input->post());
          echo json_encode($response);
     }

     function out_pass()
     {
          if (!empty($_POST)) {
               if ($id = $this->tracking->insert($_POST)) {
                    $this->session->set_flashdata('app_success', 'Tracking successfully completed!');
               } else {
                    $this->session->set_flashdata('app_error', 'Error occured!');
               }
               redirect(strtolower(__CLASS__) . '/generateOutPass/' . encryptor($id));
          } else {
               $data['showrooms'] = $this->showroom->getData();
               $data['vehicles'] = $this->tracking->getEvaluation();
               if (check_permission('tracking', 'showbookingno')) {
                    $data['bookings'] = $this->tracking->getBookings();
               }
               $data['stafs'] = $this->employees->getAllEmployees();
               $this->render_page(strtolower(__CLASS__) . '/out_pass', $data);
          }
     }

     function check_in($id = '')
     {
          if (!empty($_POST)) {
               if ($this->tracking->checkinVehicle($_POST['checkin'])) {
                    $this->session->set_flashdata('app_success', 'Check in successfully completed!');
               } else {
                    $this->session->set_flashdata('app_error', 'Error occured!');
               }
               redirect(strtolower(__CLASS__));
          } else if (!empty($id)) {
               $id = encryptor($id, 'D');
               $data['showrooms'] = $this->showroom->getData();
               $data['trackingVehicles'] = $this->tracking->getTracking($id);
               $data['vehicles'] = $this->tracking->getVehicles();
               $data['stafs'] = $this->employees->getAllEmployees();
               $this->render_page(strtolower(__CLASS__) . '/check_in', $data);
          }
     }

     function generateOutPass($id)
     {
          if (!empty($id)) {
               //header('Content-Type: application/pdf');
               $showroomId = get_logged_user('usr_showroom');
               $showroom = $this->showroom->getData($showroomId);
               $id = encryptor($id, 'D');
               $data['trackingVehicles'] = $this->tracking->getTracking($id);
               $data['showRoom'] = $showroom;
               $filename = "out-pass-" . time() . ".pdf";
               $html = $this->load->view('temp_out_pass', $data, true);
               $this->load->library('m_pdf');
               $this->m_pdf->pdf->WriteHTML($html);

               $vehicleNumber = isset($data['trackingVehicles']['val_veh_no']) ? $data['trackingVehicles']['val_veh_no'] : '';
               $this->m_pdf->pdf->SetTitle('Gate pass for vehicle ' . $vehicleNumber);
               $this->m_pdf->pdf->Output("./assets/uploads/outpass/" . $filename, "I");
          }
     }

     function update($id = '')
     {

          if (!empty($id)) {
               $id = encryptor($id, 'D');
               $data['trackingVehicles'] = $this->tracking->getTracking($id);
               $data['vehicles'] = $this->evaluation->getEvaluation();
               $data['stafs'] = $this->employees->getAllEmployees();
               $data['showrooms'] = $this->showroom->getData();
               $this->render_page(strtolower(__CLASS__) . '/view', $data);
          } else if (!empty($_POST)) {
               if ($this->uid == 358) {
                    debug($_POST);
               }
               if ($this->tracking->update($_POST)) {
                    $this->session->set_flashdata('app_success', 'Tracking successfully updated!');
               } else {
                    $this->session->set_flashdata('app_error', 'Error occured!');
               }
               redirect(strtolower(__CLASS__));
          }
     }

     function trackingLog($vehId)
     {
          //            $vehId = encryptor($vehId, 'D');
          //            $data['vehicleTrackLog'] = $this->tracking->getTrackingByVehicleId($vehId);
          //            if (empty($data['vehicleTrackLog'])) {
          //                 $data['evaliationDetails'] = $this->evaluation->getEvaluation($vehId);
          //                 $this->render_page(strtolower(__CLASS__) . '/vehicleCurrentLocation', $data);
          //            } else {
          //                 $this->render_page(strtolower(__CLASS__) . '/trackingLog', $data);
          //            }
          $vehId = encryptor($vehId, 'D');
          $data['vehicleTrackLog'] = $this->tracking->getTrackingByVehicleId($vehId);
          $data['evaliationDetails'] = $this->evaluation->getEvaluation($vehId);
          //             if($this->uid==100){
          //                echo json_encode(array('status' => true,'data' => $data));
          //                exit;
          // //debug($data);
          //             }
          $this->render_page(strtolower(__CLASS__) . '/trackingLog', $data);
     }

     function tracklist()
     { //jsk
          $this->render_page(strtolower(__CLASS__) . '/tracklist');
     }
     function tracking_ajax()
     { //jsk
          $response = $this->tracking->getAllVehiclesForTrackingAjax($this->input->post());
          echo json_encode($response);
          exit;
     }
     function exportTracking()
     {
          $stsId = isset($_GET['s']) ? encryptor($_GET['s'], 'D') : 0;
          $userName = $this->session->userdata('usr_username');
          $data = date('Y-m-d H:i:s');
          generate_log(array(
               'log_title' =>  $userName . ' downloaded excel report for Tracking list on - ' . $data,
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-tracking',
               'log_action' => 'R',
               'log_ref_id' => 33,
               'log_added_by' => $this->uid
          ));
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $data = $this->tracking->getAlltracking($_GET);
          // $data = $this->booking->getAllBookings($_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $heading = array(
               'Sl.', 'Date out', 'Vehicle No.', 'Band-Model-Varient', 'Out KM reading',
               'Purpose', 'Driver', 'To Location',
               'In KM reading', 'Stock Id.', 'Gate Pass No.', 'Issued by'
          );
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }


          $row = 2;
          if (!empty($data)) {
               foreach ($data as $key => $value) {

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $key + 1);
                    //  $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, !empty($value['trk_out_pass_time']) ? date('j M Y h:i A', strtotime($value['trk_out_pass_time'])) : '');//
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['trk_out_pass_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['val_veh_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['brd_title'] . ' -' . $value['mod_title'] . ' -' . $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['trk_out_pass_km']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['trk_out_pass_purpose']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['usr_username']); //driver
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['trk_out_pass_to_place']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['trk_check_in_km']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['val_id']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['trk_number']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['added_first_name']);

                    $row++;
               }
          }

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="track-list-report.xls"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
          exit();
     }

     function exportGatePass()
     {
          $stsId = isset($_GET['s']) ? encryptor($_GET['s'], 'D') : 0;
          $userName = $this->session->userdata('usr_username');
          $data = date('Y-m-d H:i:s');
          generate_log(array(
               'log_title' =>  $userName . ' downloaded excel report for Tracking list on - ' . $data,
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-tracking',
               'log_action' => 'R',
               'log_ref_id' => 33,
               'log_added_by' => $this->uid
          ));
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $data = $this->tracking->getAlltracking($_GET);
          // $data = $this->booking->getAllBookings($_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          // $heading = array(
          //      'Sl.', 'Date out', 'Vehicle No.', 'Band-Model-Varient', 'Out KM reading',
          //      'Purpose', 'Driver', 'To Location',
          //      'In KM reading', 'Stock Id.', 'Gate Pass No.', 'Issued by'
          // );
          $heading = array(
               'Track No', 'Reg No', 'Vehicle', 'Booking No', 'Out pass on',
               'Issued by', 'Driver', 'Check in by',
               'Place', 'PURPOSE AS ON GATE PASS.', 'TO SHOWROOM'
               // , 'To Other Place',
          );
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }


          $row = 2;
          if (!empty($data)) {
//debug($data);

               foreach ($data as $key => $value) {

                  //  $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $key + 1);
                    //  $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, !empty($value['trk_out_pass_time']) ? date('j M Y h:i A', strtotime($value['trk_out_pass_time'])) : '');//
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['trk_number']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['val_veh_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['brd_title'] . ' -' . $value['mod_title'] . ' -' . $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['trk_booking_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['trk_out_pass_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['added_first_name']); //issued by
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['usr_username']);//driver
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['checkin_by_first_name']);//Check in by
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['trk_out_pass_to_place']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['trk_out_pass_purpose']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['out_pass_to_location']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['trk_out_pass_to_place']);

                    $row++;
               }
          }

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="gate-pass-list.xls"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
          exit();
     }
}
