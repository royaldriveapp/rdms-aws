<?php
//use function Psy\debug;
defined('BASEPATH') or exit('No direct script access allowed');
class fellowship extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'fellowship';
          $this->load->model('fellowship_model', 'fellowship');
          $this->load->model('followup/followup_model', 'followup');
          $this->load->model('ihits_api/ihits_api_model', 'ihits_api_model');
          $this->load->model('registration/registration_model', 'registration');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
     }

     function report()
     {
          $data['fellowshipStaff'] = $this->fellowship->FellowshipStaffsForReport();
          $data['teamLeads'] = $this->fellowship->getTeamLead();
          $data['FELLOWSHIP_STATUS'] = unserialize(FELLOWSHIP_STATUS);
          $data['salesStaff'] = $this->fellowship->staffCanAssignEnquires();
          $this->render_page(strtolower(__CLASS__) . '/report', $data);
     }

     public function report_ajax()
     {
          $response = $this->fellowship->getReport($this->input->post(), $this->input->get());
          echo json_encode($response);
     }
     function export_report()
     {
          $response = $this->fellowship->getReport($this->input->post(), $this->input->get());
          // debug($response);
          // $evaluaionData = $this->evaluation->evaluation_ajax(array(), $this->input->get());
          $response = $response['aaData'];

          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel from valuation',
               'log_desc' => $this->session->userdata('usr_username') . ' downloaded excel report from valuation on - ' . date('Y-m-d H:i:s'),
               'log_controller' => 'exp-excel-valuation-vehicle',
               'log_action' => 'R',
               'log_ref_id' => 1006,
               'log_added_by' => $this->uid
          ));

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

          // if (check_permission('evaluation', 'showrefurbcostndndexportexcel')) {
          $heading = array(
               'Customer Name', 'Contact No', 'Type',
               'Category',
               'Added on', 'Lead Added Staff', 'Added Staff Contact No', 'Sales Head	',
               'Sales Staff', 'Status', 'Validated on', 'Remarks', 'Revenue'
          );
          //  }

          $FELLOWSHIP_STATUS = unserialize(FELLOWSHIP_STATUS);
          $purchase_type = unserialize(WEB_FORM_ENQ_TYPE);
          $revenue = '0.00';
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
          $cntMods = unserialize(MODE_OF_CONTACT);
          if (!empty($response)) {
               foreach ($response as $key => $value) {

                    $enqCategory = $value['web_category'] == 1 ? 'Luxury' : ($value['web_category'] == 2 ? 'Smart' : '');
                    //$webStatus = $value['web_status'] ?? 0; 
                    //$fellStatus = ($webStatus != 0) ? ($FELLOWSHIP_STATUS[$webStatus] ?? 'Unknown Status') : 'Pending';
                    $fellStatus = 'Pending';


                    /// debug( $purchase_type[$value['web_enq_type']]);
                    // $valStst = "";
                    // if ($value['val_status'] == "0") {
                    //      $valStst = "Pending";
                    // } else if ($value['val_status'] == vehicle_evaluated) {
                    //      $valStst = "Valuation completed";
                    // } else if ($value['val_status'] == add_stock) {
                    //      $valStst = "Stock created";
                    // }

                    // $cntMod = isset($cntMods[$value['enq_mode_enq']]) ? $cntMods[$value['enq_mode_enq']] : '';
                    //  if (check_permission('evaluation', 'showrefurbcostndndexportexcel')) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['web_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['webph_phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $purchase_type[$value['web_enq_type']]);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $enqCategory);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['web_created_at']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['added_usr_username']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['web_usr_phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['team_lead_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['sales_staff']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $fellStatus);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['web_validated_on']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['web_status_cmd']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $revenue);
                    // $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['enq_entry_date']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['enq_number']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['enq_cus_name']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['enq_cus_mobile']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value['val_stock_num']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $cntMod);
                    // }
                    $row++;
                    $no++;
               }
          }
          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          $objWriter->save('../rdms/assets/uploads/rdportal-fellowship-report.xls');
          die(json_encode('../assets/uploads/rdportal-fellowship-report.xls'));
     }
     function report2()
     {
          $data['fellowshipStaff'] = $this->fellowship->FellowshipStaffsForReport();
          $data['teamLeads'] = $this->fellowship->getTeamLead();
          $data['FELLOWSHIP_STATUS'] = unserialize(FELLOWSHIP_STATUS);
          $this->render_page(strtolower(__CLASS__) . '/report2', $data);
     }

     public function count_based_report_ajax()
     {
          //     $tableFields = $this->fellowship->getTableFields();
          //     debug($tableFields);

          $response = $this->fellowship->getCountBasedReport($this->input->post(), $this->input->get());
          // debug($response);
          echo json_encode($response);
     }

     public function staffReport()
     {

          $reportData = $this->fellowship->getCountBasedReportBk();

          // Pass data to view
          $data['reportData'] = $reportData;
          //    / debug($data);
          $this->render_page(strtolower(__CLASS__) . '/report2', $data);
     }
}
