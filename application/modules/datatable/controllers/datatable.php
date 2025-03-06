<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class datatable extends App_Controller {

     public function __construct() {

          parent::__construct();
          $this->page_title = 'Datatable';
          $this->load->model('datatable_model', 'datatable');
     }

     public function index() {
          $data['fields'] = $this->datatable->getTableFields();
          $this->render_page(strtolower(__CLASS__) . '/datatable', $data);
     }

     public function fetchData() {
          $response = $this->datatable->fetchDBDetails($this->input->post());
          echo json_encode($response);
     }

     function export() {
          $response = $this->datatable->export();
          
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();

          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $heading = $this->datatable->getTableFields();
         
          //Loop Heading
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }

          //Loop Result
          $row = 2;
          if (isset($response) && !empty($response)) {
               foreach ($response as $key => $value) {
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['vreg_id']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['vreg_division']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['vreg_is_effective']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['vreg_department']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['vreg_showroom']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['vreg_contact_mode']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['vreg_event']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['vreg_assigned_to']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['vreg_entry_date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['vreg_cust_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['vreg_address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['vreg_occupation']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['vreg_company']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['vreg_existing_vehicle']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['vreg_cust_phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['vreg_ownership']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['vreg_km']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['vreg_cust_place']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value['vreg_district']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $value['vreg_customer_remark']);
                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $value['vreg_last_action']);
                    $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $value['vreg_brand']);
                    $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $value['vreg_model']);
                    $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $value['vreg_varient']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Y' . $row, $value['vreg_added_by']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $row, $value['vreg_added_on']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AA' . $row, $value['vreg_status']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $row, $value['vreg_inquiry']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AC' . $row, $value['vreg_is_punched']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $value['vreg_is_verified']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AE' . $row, $value['vreg_verified_by']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF' . $row, $value['vreg_year']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AG' . $row, $value['vreg_customer_status']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AH' . $row, $value['vreg_investment']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AI' . $row, $value['vreg_refer_division']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $value['vreg_refer_showroom']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AK' . $row, $value['vreg_voxbay_ref']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AL' . $row, $value['vreg_call_type']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AM' . $row, $value['vreg_first_owner']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AN' . $row, $value['vreg_first_added_on']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AO' . $row, $value['vreg_se_commented_on']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AP' . $row, $value['vreg_tele_type']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $row, $value['vreg_next_followup']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AR' . $row, $value['vreg_next_followup_cont']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AS' . $row, $value['vreg_how_do_you_know_abt_rd']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AT' . $row, $value['flg']);
                    $row++;
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

}
