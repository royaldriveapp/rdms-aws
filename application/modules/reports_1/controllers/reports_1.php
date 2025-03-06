<?php

defined('BASEPATH') or exit('No direct script access allowed');

class reports_1 extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'Reports';
          $this->load->model('brand/brand_model', 'brand');
          $this->load->model('model/model_model', 'model');
          $this->load->model('veh_variant/variant_model', 'variant');
          $this->load->model('reports_model', 'reports');
          // $this->load->model('enquiry_new/enquiry_model', 'enquiry');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $this->load->model('booking/booking_model', 'booking');
          $this->load->model('divisions/divisions_model', 'divisions');
          ini_set('memory_limit', '-1');
     }

     function quickVehicleSearch()
     {
          $data['brands'] = $this->enquiry->getBrands();
          $data['vehicles'] = array();
          $data['veh_brand'] = '';
          $data['veh_model'] = '';
          $data['veh_varient'] = '';
          $data['enq_date_from'] = (isset($_GET['enq_date_from']) && !empty($_GET['enq_date_from'])) ? $_GET['enq_date_from'] : '';
          $data['enq_date_to'] = (isset($_GET['enq_date_to']) && !empty($_GET['enq_date_to'])) ? $_GET['enq_date_to'] : '';
          $data['type'] = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : '';

          $data['brandName'] = '';
          $data['modelName'] = '';
          $data['varientName'] = '';
          if (!empty($_GET)) {

               $data['enq_sts'] = isset($_GET['enq_sts']) ? $_GET['enq_sts'] : 0;
               $data['veh_brand'] = isset($_GET['vehicle']['sale']['veh_brand'][0]) ? $_GET['vehicle']['sale']['veh_brand'][0] : 0;
               $data['veh_model'] = isset($_GET['vehicle']['sale']['veh_model'][0]) ? $_GET['vehicle']['sale']['veh_model'][0] : 0;
               $data['veh_varient'] = isset($_GET['vehicle']['sale']['veh_varient'][0]) ? $_GET['vehicle']['sale']['veh_varient'][0] : 0;

               $data['brandName'] = $this->brand->getBrands($data['veh_brand']);
               $data['brandName'] = isset($data['brandName']['brd_title']) ? $data['brandName']['brd_title'] . ', ' : '';

               $data['modelName'] = $this->model->select($data['veh_model']);
               $data['modelName'] = isset($data['modelName']['mod_title']) ? $data['modelName']['mod_title'] . ', ' : '';

               $data['varientName'] = $this->variant->select($data['veh_varient']);
               $data['varientName'] = isset($data['varientName']['var_variant_name']) ? $data['varientName']['var_variant_name'] : '';

               if (isset($_GET['vehicle']['sale']['veh_brand'])) {
                    $brand = isset($_GET['vehicle']['sale']['veh_brand'][0]) ? $_GET['vehicle']['sale']['veh_brand'][0] : 0;
                    $data['model'] = $this->enquiry->getModelByBrand($brand, 'array');
               }
               if (isset($_GET['vehicle']['sale']['veh_model'])) {
                    $model = isset($_GET['vehicle']['sale']['veh_model'][0]) ? $_GET['vehicle']['sale']['veh_model'][0] : 0;
                    $data['variant'] = $this->enquiry->getVariantByModel($model, 'array');
               }
          }
          $this->load->library("pagination");
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $enquires = $this->reports->quickVehicleSearch($_GET, $limit, $page);
          $data['vehicles'] = $enquires['data'];

          $config['page_query_string'] = TRUE;
          $config['query_string_segment'] = 'page';
          $config["base_url"] = $link;
          $config["total_rows"] = $enquires['count'];
          $config["per_page"] = $limit;
          $config["uri_segment"] = 3;
          $data['totalRows'] = $enquires['count'];
          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $data['salesExecutives'] = $this->emp_details->teleCallers();
          $data['allShowrooms'] = $this->showroom->get();
          $this->render_page(strtolower(__CLASS__) . '/quickVehicleSearch', $data);
     }

     function exportVehicleSearch()
     {
          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for quick vehicle search on - ' . date('Y-m-d H:i:s'),
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-quick-veh-search',
               'log_action' => 'R',
               'log_ref_id' => 0002,
               'log_added_by' => $this->uid
          ));

          $data['brands'] = $this->enquiry->getBrands();
          $data['vehicles'] = array();
          $data['veh_brand'] = '';
          $data['veh_model'] = '';
          $data['veh_varient'] = '';
          if (!empty($_GET)) {
               $data['veh_brand'] = isset($_GET['vehicle']['sale']['veh_brand'][0]) ? $_GET['vehicle']['sale']['veh_brand'][0] : 0;
               $data['veh_model'] = isset($_GET['vehicle']['sale']['veh_model'][0]) ? $_GET['vehicle']['sale']['veh_model'][0] : 0;
               $data['veh_varient'] = isset($_GET['vehicle']['sale']['veh_varient'][0]) ? $_GET['vehicle']['sale']['veh_varient'][0] : 0;

               if (isset($_GET['vehicle']['sale']['veh_brand'])) {
                    $brand = isset($_GET['vehicle']['sale']['veh_brand'][0]) ? $_GET['vehicle']['sale']['veh_brand'][0] : 0;
                    $data['model'] = $this->enquiry->getModelByBrand($brand, 'array');
               }
               if (isset($_GET['vehicle']['sale']['veh_model'])) {
                    $model = isset($_GET['vehicle']['sale']['veh_model'][0]) ? $_GET['vehicle']['sale']['veh_model'][0] : 0;
                    $data['variant'] = $this->enquiry->getVariantByModel($model, 'array');
               }
          }
          $data = $this->reports->quickVehicleSearch($_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $statuses = unserialize(ENQUIRY_UP_STATUS);

          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

          //if (is_roo_user()) {
          $heading = array('Vehicle ID', 'Customer', 'Customer Contact No', 'Brand', 'Model', 'Variant', 'Type', 'Showroom', 'Executive', 'Executive number', 'Inquiry date', 'Status');
          //} else {
          //$heading = array('Vehicle ID', 'Brand', 'Model', 'Variant', 'Type', 'Showroom', 'Executive', 'Executive number', 'Inquiry date');
          //}
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
                    $enqDate = !empty($value['enq_entry_date']) ? date('d-m-Y', strtotime($value['enq_entry_date'])) : '';
                    $type = $value['veh_status'] == 1 ? 'Sell' : 'Buy';
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, generate_vehicle_virtual_id($value['veh_id']));
                    //if (is_roo_user()) {
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, strtoupper($value['enq_cus_name']));
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['enq_cus_mobile']);
                    //}
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['brd_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['mod_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $type);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['shr_location']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['usr_phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $enqDate);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, isset($statuses[$value['enq_cus_when_buy']]) ? $statuses[$value['enq_cus_when_buy']] : '');
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

     function duplicateEntry()
     {
          $data['vehicles'] = $this->reports->duplicateEntry();
          $this->render_page(strtolower(__CLASS__) . '/duplicateEntry', $data);
     }

     function enquiries()
     {

          /* Pagination */
          $this->load->library("pagination");
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $enquires = $this->reports->searchEnquiryByDateShowroomSe($limit, $page, $_GET);
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

          $data['showroom'] = isset($_GET['showroom']) ? $_GET['showroom'] : '';
          $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
          $data['enq_date_from'] = (isset($_GET['enq_date_from']) && !empty($_GET['enq_date_from'])) ? $_GET['enq_date_from'] : '';
          $data['enq_date_to'] = (isset($_GET['enq_date_to']) && !empty($_GET['enq_date_to'])) ? $_GET['enq_date_to'] : '';
          $data['enqStatus'] = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
          $data['mode'] = isset($_GET['mode']) && !empty($_GET['mode']) ? $_GET['mode'] : '';
          $data['totalRows'] = $enquires['count'];
          $this->render_page(strtolower(__CLASS__) . '/enquiries', $data);
     }

     function exportEnquires_back()
     {
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $data = $this->reports->searchEnquiryByDateShowroomSe(0, $page, $_GET);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

          if ($this->usr_grp != 'SE') {
               $heading = array('Vehicle ID', 'Customer', 'Contact No', 'Brand', 'Model', 'Variant', 'Mod of enquiry', 'Type', 'Showroom', 'Executive', 'Enq Date');
          } else {
               $heading = array('Vehicle ID', 'Customer', 'Contact No', 'Brand', 'Model', 'Variant', 'Type', 'Enq Date');
          }
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
                    if (!empty($value['enq_mode_enq'])) {
                         $mod = $this->common_model->getContactModes($value['enq_mode_enq']);
                    }
                    $type = $value['veh_status'] == 1 ? 'Sell' : 'Buy';
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, generate_vehicle_virtual_id($value['veh_id']));
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, strtoupper($value['enq_cus_name']));
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['enq_cus_mobile']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['brd_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['mod_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, isset($mod['cmd_title']) ? $mod['cmd_title'] : ''); // Mode of enquiry
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $type);
                    $col = 'I';
                    if ($this->usr_grp != 'SE') {
                         $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['shr_location']);
                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['usr_first_name']);
                         $col = 'K';
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $row, date('j M Y', strtotime($value['enq_entry_date'])));
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

     function closedEnquiries()
     {
          $data['title'] = 'Closed inquires';
          $this->page_title = 'Reports - closed inquires';
          $data['enquires'] = $this->reports->getInnactiveVehicles(7);
          $data['status'] = 7;
          $this->render_page(strtolower(__CLASS__) . '/vehicleList', $data);
     }

     function viewVehicleStatusHistory($vehId)
     {
          $vehId = encryptor($vehId, 'D');
          $data['vehicles'] = $this->reports->getVehicleStatusHistory($vehId);
          $this->render_page(strtolower(__CLASS__) . '/vehicleStausHistory', $data);
     }

     function droppedEnquiries($vehId = '')
     {
          $data['title'] = 'Dropped inquires';
          $this->page_title = 'Reports - dropped inquires';
          $this->load->library("pagination");
          $limit = get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $enquires = $this->reports->getInnactiveVehicles(3, $limit, $page, $_GET);
          $data['salesExecutives'] = $this->emp_details->salesExecutives();
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
          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $data['districts'] = $this->reports->getDistricts();
          $data['distSelected'] = isset($_GET['enq_cus_dist']) ? $_GET['enq_cus_dist'] : '';
          /* Table info */
          $data['status'] = 3;
          $this->render_page(strtolower(__CLASS__) . '/vehicleList', $data);
     }

     function export_excel_drop_loss()
     {
          $status = $_GET['s'];

          $curStatus = $this->reports->getStatusDetails($status);
          $curStatusName = isset($curStatus['sts_des']) ? $curStatus['sts_des'] : '';
          $curStatusSlug = isset($curStatus['sts_slug']) ? $curStatus['sts_slug'] : '';
          $_GET['status'] = $curStatus;
          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for ' . $curStatusName . ' search on - ' . date('Y-m-d H:i:s'),
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-' . $curStatusSlug,
               'log_action' => 'R',
               'log_ref_id' => 1012,
               'log_added_by' => $this->uid
          ));

          $data = $this->reports->getInnactiveVehicles($status, 0, 0, $_GET, false);
          //debug($data);
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();

          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');

          $heading = array('Customer', 'Customer Contact No', 'Districts', 'Vehicle', 'Type', 'Showroom', 'Sales Staff', 'Drope/Lost date', 'Last followup comment');

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
          if (!empty($data['data'])) {
               foreach ($data['data'] as $key => $value) {

                    $followup = $this->reports->getLastFollowup($value['enq_id']);
                    $follCmt = isset($followup['foll_remarks']) ? $followup['foll_remarks'] : '';

                    $vehDetails = $this->reports->getVehicleByEnquiry($value['enq_id']);
                    $echangeVehicleBrd = isset($vehDetails['buy']['0']['brd_title']) ? $vehDetails['buy']['0']['brd_title'] : '';
                    $echangeVehicleMod = isset($vehDetails['buy']['0']['mod_title']) ? $vehDetails['buy']['0']['mod_title'] : '';
                    $echangeVehicleVar = isset($vehDetails['buy']['0']['var_variant_name']) ? $vehDetails['buy']['0']['var_variant_name'] : '';
                    $purchase = trim($echangeVehicleBrd . ' ' . $echangeVehicleMod . ' ' . $echangeVehicleVar);

                    $salesVehicleBrd = isset($vehDetails['sales']['0']['brd_title']) ? $vehDetails['sales']['0']['brd_title'] : '';
                    $salesVehicleMod = isset($vehDetails['sales']['0']['mod_title']) ? $vehDetails['sales']['0']['mod_title'] : '';
                    $salesVehicleVar = isset($vehDetails['sales']['0']['var_variant_name']) ? $vehDetails['sales']['0']['var_variant_name'] : '';
                    $sales = trim($salesVehicleBrd . ' ' . $salesVehicleMod . ' ' . $salesVehicleVar);

                    $vehicle = '';
                    $type = '';
                    if ($value['enq_cus_status'] == 1) { //Sales
                         $vehicle = $sales;
                         $type = 'Sales';
                    } else if ($value['enq_cus_status'] == 2) { //Purchase
                         $vehicle = $purchase;
                         $type = 'Purchase';
                    } else { //Exchange
                         $type = 'Exchange';
                         $vehicle = 'Sales vehicle : ' . $sales . ', Purchase vehicle ' . $purchase;
                    }

                    $dropLostDate = !empty($value['enh_added_on']) ? date('d-m-Y', strtotime($value['enh_added_on'])) : '';

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, strtoupper($value['enq_cus_name']));
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['enq_cus_mobile']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['std_district_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $vehicle);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $type);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['shr_location']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $dropLostDate);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $follCmt);
                    $row++;
                    $no++;
               }
          }
          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="dropped-lost-enquires.xls"');
          header('Cache-Control: max-age=0');

          $objWriter->save('php://output');
          exit();
     }

     function deletedEnquiries()
     {
          $data['title'] = 'Deleted inquires';
          $this->page_title = 'Reports - deleted inquires';
          $data['enquires'] = $this->reports->getInnactiveVehicles(99);
          $data['status'] = 99;
          $this->render_page(strtolower(__CLASS__) . '/vehicleList', $data);
     }

     function lossOfEnquiryVehicles()
     {
          $data['enquires'] = $this->reports->getVehicleStatusHistory(5);
          $data['status'] = 5;
          $this->render_page(strtolower(__CLASS__) . '/vehicleList', $data);
     }

     function dar()
     {
          $data['dar'] = $this->reports->dar($_GET);
          $data['allShowrooms'] = $this->showroom->get();
          $data['salesExecutives'] = $this->emp_details->salesOfficerandcre();
          $data['darm_added_on_fr'] = isset($_GET['darm_added_on_fr']) ? $_GET['darm_added_on_fr'] : '';
          $data['darm_added_on_to'] = isset($_GET['darm_added_on_to']) ? $_GET['darm_added_on_to'] : '';
          $data['showroom'] = isset($_GET['showroom']) ? $_GET['showroom'] : '';
          $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
          if (is_roo_user()) {
               $this->render_page(strtolower(__CLASS__) . '/dar-filter-root', $data);
          } else {
               $this->render_page(strtolower(__CLASS__) . '/dar-filter', $data);
          }
     }

     function loadDARBydaye($data)
     {
          $parm['darm_added_on_fr'] = $data;
          $data = array();
          $data['dar'] = $this->reports->dar($parm);
          $html = $this->load->view('dar-table', $data, true);
          die(json_encode(array('html' => $html)));
     }

     function loosedenquiries()
     {
          $data['title'] = 'Loosed inquires';
          $this->page_title = 'Reports - loosed inquires';
          $this->load->library("pagination");
          $limit = get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $data = $_GET;
          $enquires = $this->reports->getInnactiveVehicles(5, $limit, $page, $_GET);
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
          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $data['districts'] = $this->reports->getDistricts();
          $data['distSelected'] = isset($_GET['dist']) ? $_GET['dist'] : '';
          /* Table info */

          $data['status'] = 5;
          $this->render_page(strtolower(__CLASS__) . '/vehicleList', $data);
     }

     function bookedenquiries()
     {
          $data['title'] = 'Booked inquires';
          $this->page_title = 'Reports - booked inquires';
          $data['enquires'] = $this->reports->getInnactiveVehicles(13);
          $this->render_page(strtolower(__CLASS__) . '/vehicleList', $data);
     }

     function enquiries_enq()
     {
          /* Pagination */
          $this->load->library("pagination");
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $enquires = $this->reports->searchInquiryByDefault($limit, $page, $_GET);
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

          $data['teleCallers'] = $this->emp_details->teleCallersSalesStaffs();
          $data['districts'] = $this->reports->getDistricts();
          $data['distSelected'] = isset($_GET['dist']) ? $_GET['dist'] : '';
          $data['showroom'] = isset($_GET['showroom']) ? $_GET['showroom'] : '';
          $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
          $data['enq_date_from'] = (isset($_GET['enq_date_from']) && !empty($_GET['enq_date_from'])) ? $_GET['enq_date_from'] : '';
          $data['enq_date_to'] = (isset($_GET['enq_date_to']) && !empty($_GET['enq_date_to'])) ? $_GET['enq_date_to'] : '';
          $data['enqStatus'] = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
          $data['mode'] = isset($_GET['mode']) && !empty($_GET['mode']) ? $_GET['mode'] : '';
          $data['isMissedFollowup'] = isset($_GET['isMissedFollowup']) && !empty($_GET['isMissedFollowup']) ? $_GET['isMissedFollowup'] : 0;
          $data['totalRows'] = $enquires['count'];
          $this->render_page(strtolower(__CLASS__) . '/enquiries_enq', $data);
     }

     function homevisitneeded()
     {
          $this->load->library("pagination");
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $enquires = $this->reports->homevisitneeded($limit, $page);
          $data['searchResult'] = $enquires['data'];

          $config['page_query_string'] = TRUE;
          $config['query_string_segment'] = 'page';
          $config["base_url"] = $link;
          $config["total_rows"] = $enquires['count'];
          $config["per_page"] = $limit;
          $config["uri_segment"] = 3;
          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $data['totalRows'] = $enquires['count'];
          $this->render_page(strtolower(__CLASS__) . '/homevisitneeded', $data);
     }

     function bookedEnquires()
     {
          $this->load->library("pagination");
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $enquires = $this->reports->getBookedEnquires($limit, $page);
          $data['searchResult'] = $enquires['data'];
          //            debug($data['searchResult']);
          $config['page_query_string'] = TRUE;
          $config['query_string_segment'] = 'page';
          $config["base_url"] = $link;
          $config["total_rows"] = $enquires['count'];
          $config["per_page"] = $limit;
          $config["uri_segment"] = 3;
          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
          $data['totalRows'] = $enquires['count'];
          $this->render_page(strtolower(__CLASS__) . '/bookedEnquires', $data);
     }

     function voxbayCallHistory()
     {

          $this->reports->voxbayCallHistory($_GET);
          $this->render_page(strtolower(__CLASS__) . '/voxbayCallHistory');
     }

     function voxbayDailyReport()
     {
          if (check_permission('reports', 'canchoosese')) {
               $data['staffs'] = $this->emp_details->teleCallers();
          }

          if (check_permission('reports', 'myreportingstaff')) {
               $data['staffs'] = $this->emp_details->myReportingStaff();
          }
          $this->render_page(strtolower(__CLASS__) . '/voxbayDailyReport', $data);
     }

     function voxbayDailyCallReport_ajax()
     {
          $response = $this->reports->getAllCalls($this->input->post());
          echo json_encode($response);
     }

     function eportVoxbayDailyCallReport()
     {

          $parms = !empty($_GET) ? $_GET : $_POST;

          $response = $this->reports->eportVoxbayDailyCallReport($parms);

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Voxbay daily report');
          $heading = array('SL', 'Date', 'Customer number', 'Customer name', 'Location', 'Mode of contact', 'Brand', 'Model', 'Varient', 'Budget', 'Year', 'Assigned by', 'Assigned to', 'Feedback');

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
          if (!empty($response)) {
               foreach ($response as $key => $value) {
                    $contactMod = isset($modeOfContact[$value['vreg_contact_mode']]) ? $modeOfContact[$value['vreg_contact_mode']] : '';
                    $value['vreg_investment'] = ($value['vreg_investment'] > 0) ? $value['vreg_investment'] : '';
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $key + 1);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, date('d-m-Y', strtotime($value['vreg_entry_date'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['ccb_callerNumber']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['vreg_cust_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['vreg_cust_place']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $contactMod);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['brd_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['mod_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['var_variant_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['vreg_investment']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['vreg_year']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['addedby_usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['assign_usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['vreg_customer_remark']);
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

     /* function quickassign() {

         $enquiresCount = 0;
         if (isset($_POST['executive']) && (count($_POST['executive']) > 0 )) {
         $exeCount = count($_POST['executive']);
         $searchValues = isset($_POST['searchValues']) ? unserialize($_POST['searchValues']) : '';
         $enquiresCount = $this->reports->getQuickAssignInquires(0, 0, $searchValues);
         $divBySE = (count($enquiresCount) / $exeCount) + 1;

         $index = 0;
         foreach ($_POST['executive'] as $key => $TCID) {
         $inq = $this->reports->getQuickAssignInquires($divBySE, $index, $searchValues);
         foreach ((array) $inq as $inqKey => $value) {
         $vehicleDetails = $this->db->query("SELECT GROUP_CONCAT( IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , "
         . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title) , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
         . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
         . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
         . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
         . "WHERE cpnl_vehicle.veh_enq_id = " . $value['enq_id'])->row_array();

         $veh = isset($vehicleDetails['vehicle']) ? $vehicleDetails['vehicle'] : '';

         $this->db->insert('cpnl_quick_tc_report', array(
         'qtr_enq_id' => $value['enq_id'],
         'qtr_se_id' => $value['enq_se_id'],
         'qtr_se_id' => $value['enq_se_id'],
         'qtr_assigned_to' => $TCID,
         'qtr_vehile' => $veh,
         'qtr_assigned_by' => $this->uid,
         'qtr_assigned_on' => date('Y-m-d h:i:s')
         ));
         $index++;
         }
         }
         }
         die(json_encode(array('msg' => $enquiresCount . ' inquires assigned for followup')));
         } */

     function quickassign()
     {
          // debug($_POST);
          $enquiresCount = 0;
          if (isset($_POST['executive']) && (count($_POST['executive']) > 0)) {

               //Quick assign master
               $masterId = $this->reports->quickAssignMaster($_POST);
               //Quick assign master

               $exeCount = count($_POST['executive']);
               $searchValues = isset($_POST['searchValues']) ? unserialize($_POST['searchValues']) : '';
               if (isset($_POST['source']) && $_POST['source'] == 'rpt_enquires') { //Report from enquires enquiry vise
                    $enquiresCount = $this->reports->searchInquiryByDefaultNoLimit(0, 0, $searchValues);
               } else {
                    $enquiresCount = $this->reports->quickVehicleSearchNolimit(0, 0, $searchValues);
               }

               $divBySE = (count($enquiresCount) / $exeCount) + 1;

               $index = 0;
               foreach ($_POST['executive'] as $key => $TCID) {
                    if (isset($_POST['source']) && $_POST['source'] == 'rpt_enquires') { //Report from enquires enquiry vise
                         $inq = $this->reports->searchInquiryByDefaultNoLimit($divBySE, $index, $searchValues);
                    } else {
                         $inq = $this->reports->quickVehicleSearchNolimit($divBySE, $index, $searchValues);
                    }

                    foreach ((array) $inq as $inqKey => $value) {
                         $vehicleDetails = $this->db->query("SELECT GROUP_CONCAT( IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , "
                              . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title) , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
                              . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
                              . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
                              . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
                              . "WHERE cpnl_vehicle.veh_enq_id = " . $value['enq_id'])->row_array();

                         $veh = isset($vehicleDetails['vehicle']) ? $vehicleDetails['vehicle'] : '';

                         $this->db->insert('cpnl_quick_tc_report', array(
                              'qtr_master_id' => $masterId,
                              'qtr_enq_id' => $value['enq_id'],
                              'qtr_se_id' => $value['enq_se_id'],
                              'qtr_assigned_to' => $TCID,
                              'qtr_vehile' => $veh,
                              'qtr_assigned_by' => $this->uid,
                              'qtr_assigned_on' => date('Y-m-d h:i:s')
                         ));
                         $index++;
                    }
               }
          }
          die(json_encode(array('msg' => count($enquiresCount) . ' inquires assigned for followup')));
     }

     function quickEnquiryFedBack()
     {
          $data['data'] = $this->reports->getAnalysisOfCall();
          $this->render_page(strtolower(__CLASS__) . '/quickFollowupReport', $data);
     }

     function quickEnquiryFedBack_ajax()
     {
          $response = $this->reports->quickEnquiryFedBack($this->input->post());
          echo json_encode($response);
     }

     function voxbayPunchReprt()
     {
          $this->render_page(strtolower(__CLASS__) . '/voxbayPunchReprt');
     }

     function voxbayPunchReprt_ajax()
     {
          $response = $this->reports->voxbayPunchReprt_ajax($this->input->post());
          echo json_encode($response);
     }

     function exportEnquires()
     {

          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report for enquires vehicle/enquiry based on - ' . date('Y-m-d H:i:s'),
               'log_desc' => serialize($_GET),
               'log_controller' => 'exp-excel-inquires-veh-enq-based',
               'log_action' => 'R',
               'log_ref_id' => 0002,
               'log_added_by' => $this->uid
          ));
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $data = $this->reports->searchEnquiryByDateShowroomSe(0, $page, $_GET);
          //debug($data);
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Enquires report');
          $heading = array(
               'SL', 'Date', 'Customer Name', 'Phone Number', 'Profession', 'Location', 'Brand', 'Model Interested',
               'Variant', 'Budget', 'Year', 'KM Bracket', 'Mode of enquiry', 'Colour Pref', 'Sales Staff', 'Team Leader',
               'Branch', 'Loan %', 'Loan AMT', 'Loan EMI', 'Loan period (year)', 'Exchange', 'Customer remarks', 'Exc Remarks',
               'TELE Remarks', 'TL Remarks', 'Coutresy call', 'Happy call', 'Booked', 'Sold', 'Month End Review', 'Status',
               'Last followup on', 'Next followup on'
          );
          //Loop Heading
          $rowNumberH = 1;
          $colH = 'A';
          foreach ($heading as $h) {
               $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
               $colH++;
          }
          //Loop Result
          $modeOfContact = unserialize(MODE_OF_CONTACT);
          $statuses = unserialize(ENQUIRY_UP_STATUS);

          $row = 2;
          if (isset($data['data']) && !empty($data['data'])) {
               foreach ($data['data'] as $key => $value) {
                    $mod = isset($modeOfContact[$value['enq_mode_enq']]) ? $modeOfContact[$value['enq_mode_enq']] : '';
                    $vehDetails = $this->reports->getVehicleByEnquiry($value['enq_id']);
                    $followup = $this->reports->getLastFollowup($value['enq_id']);

                    $budget = 0;
                    $km = 0;

                    if ($value['enq_budget'] > 0) {
                         $budget = $value['enq_budget'];
                    } else {
                         $salesBudget = isset($vehDetails['sales'][0]['veh_price_from']) ? $vehDetails['sales'][0]['veh_price_from'] : 0;
                         $buyBudget = isset($vehDetails['buy'][0]['veh_price_from']) ? $vehDetails['buy'][0]['veh_price_from'] : 0;
                         $value['veh_price_from'] = ($value['enq_cus_status'] == 1) ? $salesBudget : $buyBudget;

                         $salesBudget = isset($vehDetails['sales'][0]['veh_price_to']) ? $vehDetails['sales'][0]['veh_price_to'] : 0;
                         $buyBudget = isset($vehDetails['buy'][0]['veh_price_to']) ? $vehDetails['buy'][0]['veh_price_to'] : 0;
                         $value['veh_price_to'] = ($value['enq_cus_status'] == 1) ? $salesBudget : $buyBudget;

                         $budget = ($value['veh_price_from'] > 0) ? $value['veh_price_from'] . ' - ' : '';
                         $budget .= $budget . $value['veh_price_to'];
                    }

                    $salesKm = isset($vehDetails['sales'][0]['veh_km_from']) ? $vehDetails['sales'][0]['veh_km_from'] : 0;
                    $buyKm = isset($vehDetails['buy'][0]['veh_km_from']) ? $vehDetails['buy'][0]['veh_km_from'] : 0;
                    $value['veh_km_from'] = ($value['enq_cus_status'] == 1) ? $salesKm : $buyKm;

                    $salesKm = isset($vehDetails['sales'][0]['veh_km_to']) ? $vehDetails['sales'][0]['veh_km_to'] : 0;
                    $buyKm = isset($vehDetails['buy'][0]['veh_km_to']) ? $vehDetails['buy'][0]['veh_km_to'] : 0;
                    $value['veh_km_to'] = ($value['enq_cus_status'] == 1) ? $salesKm : $buyKm;

                    $km = ($value['veh_km_from'] > 0) ? $value['veh_km_from'] . ' - ' : '';
                    $km .= $budget . $value['veh_km_to'];

                    $echangeVehicleBrd = isset($vehDetails['buy']['0']['brd_title']) ? $vehDetails['buy']['0']['brd_title'] : '';
                    $echangeVehicleMod = isset($vehDetails['buy']['0']['mod_title']) ? $vehDetails['buy']['0']['mod_title'] : '';
                    $echangeVehicleVar = isset($vehDetails['buy']['0']['var_variant_name']) ? $vehDetails['buy']['0']['var_variant_name'] : '';
                    $exchange = $echangeVehicleBrd . ' ' . $echangeVehicleMod . ' ' . $echangeVehicleVar;

                    $salesVehicleBrd = isset($vehDetails['sales']['0']['brd_title']) ? $vehDetails['sales']['0']['brd_title'] : '';
                    $salesVehicleMod = isset($vehDetails['sales']['0']['mod_title']) ? $vehDetails['sales']['0']['mod_title'] : '';
                    $salesVehicleVar = isset($vehDetails['sales']['0']['var_variant_name']) ? $vehDetails['sales']['0']['var_variant_name'] : '';

                    $vehColor = isset($vehDetails['sales']['0']['veh_color']) ? $vehDetails['sales']['0']['veh_color'] : '';
                    $vehYear = isset($vehDetails['sales']['0']['veh_year']) ? $vehDetails['sales']['0']['veh_year'] : '';
                    $follCmt = isset($followup['foll_remarks']) ? $followup['foll_remarks'] : '';

                    $vehicleBrd = empty($salesVehicleBrd) ? $echangeVehicleBrd : $salesVehicleBrd;
                    $vehicleMod = empty($salesVehicleMod) ? $echangeVehicleMod : $salesVehicleMod;
                    $vehicleVar = empty($salesVehicleBrd) ? $echangeVehicleVar : $salesVehicleVar;

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $key + 1);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, date('d/m/Y', strtotime($value['enq_entry_date'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, strtoupper($value['enq_cus_name']));
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['enq_cus_mobile']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['occ_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['cit_name'] . ', ' . $value['enq_cus_address']); //enq_location
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $vehicleBrd);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $vehicleMod);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $vehicleVar);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $budget);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $vehYear);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $km);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $mod);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $vehColor);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['usr_first_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['teamLead']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['shr_location']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['enq_cus_loan_perc']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value['enq_cus_loan_amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $value['enq_cus_loan_emi']);
                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $value['enq_cus_loan_period']);
                    $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $exchange);
                    $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $value['enq_cus_remarks']);
                    $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $follCmt);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF' . $row, isset($statuses[$value['enq_cus_when_buy']]) ? $statuses[$value['enq_cus_when_buy']] : '');
                    $lastFollowupDate = $this->reports->getLastFollowupDate($value['enq_id']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AG' . $row, (isset($lastFollowupDate['foll_entry_date']) && !empty($lastFollowupDate['foll_entry_date'])) ? date('j M Y', strtotime($lastFollowupDate['foll_entry_date'])) : '');
                    $objPHPExcel->getActiveSheet()->setCellValue('AH' . $row, !empty($value['enq_next_foll_date']) ? date('j M Y', strtotime($value['enq_next_foll_date'])) : '');
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

     function telcalrPerformanceReport()
     {
          $data['report'] = $this->reports->telcalrPerformanceReport();
          $this->render_page(strtolower(__CLASS__) . '/telcalrPerformanceReport', $data);
     }

     function telcalrPerformanceDeailReport($type, $date)
     {
          $response = $this->reports->telcalrPerformanceDeailReport($this->input->post(), $type, $date);
          echo json_encode($response);
     }

     function registerPendingReport()
     {
          $data['pendingRegister'] = $this->reports->registerPendingByUser();
          $this->render_page(strtolower(__CLASS__) . '/registerPendingReport', $data);
     }

     function logreport()
     {
          $this->page_title = 'Excel download log';
          $data['logdata'] = $this->reports->exceldownload();
          $this->render_page(strtolower(__CLASS__) . '/exceldownload', $data);
     }

     function filterinquires()
     {
          /* Pagination */
          $this->load->library("pagination");
          $limit = 10; //get_settings_by_key('pagination_limit');
          $page = !isset($_GET['page']) ? 0 : $_GET['page'];
          $linkParts = explode('&page=', current_url() . '?' . $_SERVER['QUERY_STRING']);
          $link = $linkParts[0];
          $config = getPaginationDesign();

          $enquires = $this->reports->filterinquires($limit, $page, $_GET);
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
          $data['salesExecutives'] = $this->reports->getMyStaffs();
          $data['districts'] = $this->reports->getDistricts();
          $data['distSelected'] = isset($_GET['dist']) ? $_GET['dist'] : '';
          $data['showroom'] = isset($_GET['showroom']) ? $_GET['showroom'] : '';
          $data['executive'] = isset($_GET['executive']) ? $_GET['executive'] : '';
          $data['enq_date_from'] = (isset($_GET['enq_date_from']) && !empty($_GET['enq_date_from'])) ? $_GET['enq_date_from'] : '';
          $data['enq_date_to'] = (isset($_GET['enq_date_to']) && !empty($_GET['enq_date_to'])) ? $_GET['enq_date_to'] : '';
          $data['enqStatus'] = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
          $data['mode'] = isset($_GET['mode']) && !empty($_GET['mode']) ? $_GET['mode'] : '';
          $data['isMissedFollowup'] = isset($_GET['isMissedFollowup']) && !empty($_GET['isMissedFollowup']) ? $_GET['isMissedFollowup'] : 0;
          $data['totalRows'] = $enquires['count'];
          $this->render_page(strtolower(__CLASS__) . '/filterinquires', $data);
     }

     function enquiry_pool($varnt_id = '', $modl_yr = '', $brdTitle = '')
     {
          if ($varnt_id) {
               $varnt_id = encryptor($varnt_id, 'D');
               $modl_yr = encryptor($modl_yr, 'D');
               $data['enqs'] = $this->reports->getDetailsByVariant($varnt_id, $modl_yr);
               $data['brdTitle'] = $brdTitle;
               $this->render_page(strtolower(__CLASS__) . '/enquiry_pool', $data);
          } else
               die('Error');
     }

     function enquiry_pool_list()
     {

          if ($this->input->is_ajax_request()) {
               // debug(3132);
               $filterData = $this->input->post();
               $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
               $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
               $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
               $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
               $data['formFilter'] = $filterData;
               $EnqCount = $this->reports->getEnquiriesCount($filterData, $data['date_filter']); //dd($EnqCount);
               $minimum_price = $this->input->post('minimum_price');
               $maximum_price = $this->input->post('maximum_price');
               $brand = $this->input->post('brand');
               $ram = $this->input->post('ram');
               $storage = $this->input->post('storage');
               $this->load->library('pagination');
               $config = array();
               $config['base_url'] = site_url('eports/enquiry_pool_list');
               $config['total_rows'] = $EnqCount;
               $config['per_page'] = 2;
               $config['uri_segment'] = 3;
               $config['use_page_numbers'] = TRUE;
               $config['full_tag_open'] = '<ul class="pagination">';
               $config['full_tag_close'] = '</ul>';
               $config['first_tag_open'] = '<li>';
               $config['first_tag_close'] = '</li>';
               $config['last_tag_open'] = '<li>';
               $config['last_tag_close'] = '</li>';
               $config['next_link'] = '&gt;';
               $config['next_tag_open'] = '<li>';
               $config['next_tag_close'] = '</li>';
               $config['prev_link'] = '&lt;';
               $config['prev_tag_open'] = '<li>';
               $config['prev_tag_close'] = '</li>';
               $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               $config['cur_tag_close'] = '</a></li>';
               $config['num_tag_open'] = '<li>';
               $config['num_tag_close'] = '</li>';
               $config['num_links'] = 3;
               $this->pagination->initialize($config);
               $page = $this->uri->segment(3);
               //echo 'pg--'.$page;
               //   debug($page);
               $start = ($page - 1) * $config['per_page'];
               $data['enquiries'] = $this->reports->getEnquiriesForPooll($filterData, $config["per_page"], $start, $data['date_filter']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/enq_pool_list_view', $data, TRUE);
               $output = array(
                    'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    'total_records_count' => $EnqCount,
                    'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
               );
               die(json_encode($output));
          } else {
               $data['brand'] = $this->enquiry->getBrands();
               $this->render_page(strtolower(__CLASS__) . '/enquiry_pool_list', $data);
          }
     }

     function allowquickassignenquirestosalesstaff()
     {
          $searchValues = isset($_POST['searchValues']) ? unserialize($_POST['searchValues']) : '';
          $inq = $this->reports->searchInquiryByDefaultNoLimit(0, 0, $searchValues);
          if (!empty($inq)) {
               $_POST['executive'] = array_unique(array_column($inq, 'enq_se_id'));
               $masterId = $this->reports->quickAssignMaster($_POST);
               foreach ((array) $inq as $inqKey => $value) {
                    $vehicleDetails = $this->db->query("SELECT GROUP_CONCAT( IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , "
                         . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title) , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
                         . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
                         . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
                         . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
                         . "WHERE cpnl_vehicle.veh_enq_id = " . $value['enq_id'])->row_array();

                    $veh = isset($vehicleDetails['vehicle']) ? $vehicleDetails['vehicle'] : '';

                    $this->db->insert('cpnl_quick_tc_report', array(
                         'qtr_master_id' => $masterId,
                         'qtr_enq_id' => $value['enq_id'],
                         'qtr_se_id' => $value['enq_se_id'],
                         'qtr_assigned_to' => $value['enq_se_id'],
                         'qtr_vehile' => $veh,
                         'qtr_assigned_by' => $this->uid,
                         'qtr_assigned_on' => date('Y-m-d H:i:s')
                    ));
               }
               die(json_encode(array('msg' => count($inq) . ' inquires assigned for re-call')));
          } else {
               die(json_encode(array('msg' => 'Error occured')));
          }
     }

     function voxbayDailyCallsAjax()
     {
          $data['pbxDailyCalls'] = $this->reports->pbxDailyCalls();
          $html = $this->load->view(strtolower(__CLASS__) . '/ajax_voxbayDailyReport', $data, true);
          die(json_encode(array('html' => $html)));
     }

     function stock_status_summary()
     {
          $data = $this->reports->get_stock_status_count();
          $this->render_page(strtolower(__CLASS__) . '/stock_status_summary', $data);
     }

     //        function stock_report(){//STOCK STATUS AS ON 23-08-2021
     //         // $data = $this->reports->get_stock_report();
     //             $data='';
     //                       $this->render_page(strtolower(__CLASS__) . '/stock_report', $data); 
     //     }
     function stock_report($id = 0)
     { //STOCK STATUS AS ON 23-08-2021
          if ($this->input->is_ajax_request()) {
               // debug(3132);
               $filterData = $this->input->post();
               $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
               $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
               $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
               $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
               $data['formFilter'] = $filterData;
               $stock_Count = $this->reports->stock_status_count(); //debug($stock_Count);
               $minimum_price = $this->input->post('minimum_price');
               $maximum_price = $this->input->post('maximum_price');
               $brand = $this->input->post('brand');
               $ram = $this->input->post('ram');
               $storage = $this->input->post('storage');
               $this->load->library('pagination');
               $config = array();
               $config['base_url'] = site_url('reports_1/stock_report');
               $config['total_rows'] = $stock_Count;
               $config['per_page'] = 10; //limit
               $config['uri_segment'] = 3;
               $config['use_page_numbers'] = TRUE;
               $config['full_tag_open'] = '<ul class="pagination">';
               $config['full_tag_close'] = '</ul>';
               $config['first_tag_open'] = '<li>';
               $config['first_tag_close'] = '</li>';
               $config['last_tag_open'] = '<li>';
               $config['last_tag_close'] = '</li>';
               $config['next_link'] = '&gt;';
               $config['next_tag_open'] = '<li>';
               $config['next_tag_close'] = '</li>';
               $config['prev_link'] = '&lt;';
               $config['prev_tag_open'] = '<li>';
               $config['prev_tag_close'] = '</li>';
               $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               $config['cur_tag_close'] = '</a></li>';
               $config['num_tag_open'] = '<li>';
               $config['num_tag_close'] = '</li>';
               $config['num_links'] = 2;
               $this->pagination->initialize($config);
               $page = $this->uri->segment(3);
               //               if(!$page){
               ////                  echo 'noo'  ;
               //                    $page= (int)1;
               //               }else{
               //                    //echo 'ys';
               //                     $page= $page;
               //               }
               //               echo $page;
               // exit;
               // echo 'pg--'.$page;
               //   debug($page);
               $start = ($page - 1) * $config['per_page']; //offset
               //$data['enquiries'] = $this->reports->getEnquiriesForPooll($filterData, $config["per_page"], $start, $data['date_filter']);
               $data['reports'] = $this->reports->stock_status($config["per_page"], $start);
               //debug($data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/stock_report_ajax_view', $data, TRUE);
               $output = array(
                    'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    'total_records_count' => $stock_Count,
                    'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
               );
               die(json_encode($output));
          } else {
               // debug(121);
               $data['brand'] = $this->enquiry->getBrands();
               $this->render_page(strtolower(__CLASS__) . '/stock_report', $data);
          }
     }

     function booked_stock_report()
     { //STOCK STATUS AS ON 23-08-2021
          if ($this->input->is_ajax_request()) {
               // debug($this->input->post('month'));
               $filterData = $this->input->post();
               $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
               $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
               $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
               $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
               $data['formFilter'] = $filterData;
               $data['month'] = $this->input->post('month');
               // $stock_Count = $this->reports->BookedReportCount(); //debug($stock_Count);
               $stock_Count = $this->reports->BookedStockReportCount($data['month']);
               $stock_Count = $stock_Count['numrows'];
               // debug($stock_Count['numrows']);
               //  $stock_Count = 10;

               $minimum_price = $this->input->post('minimum_price');
               $maximum_price = $this->input->post('maximum_price');
               $brand = $this->input->post('brand');
               $ram = $this->input->post('ram');
               $storage = $this->input->post('storage');
               $this->load->library('pagination');
               $config = array();
               $config['base_url'] = site_url('reports_1/booked_stock_report');
               $config['total_rows'] = $stock_Count;
               $config['per_page'] = 11; //limit
               $config['uri_segment'] = 3;
               $config['use_page_numbers'] = TRUE;
               $config['full_tag_open'] = '<ul class="pagination">';
               $config['full_tag_close'] = '</ul>';
               $config['first_tag_open'] = '<li>';
               $config['first_tag_close'] = '</li>';
               $config['last_tag_open'] = '<li>';
               $config['last_tag_close'] = '</li>';
               $config['next_link'] = '&gt;';
               $config['next_tag_open'] = '<li>';
               $config['next_tag_close'] = '</li>';
               $config['prev_link'] = '&lt;';
               $config['prev_tag_open'] = '<li>';
               $config['prev_tag_close'] = '</li>';
               $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               $config['cur_tag_close'] = '</a></li>';
               $config['num_tag_open'] = '<li>';
               $config['num_tag_close'] = '</li>';
               $config['num_links'] = 2;
               $this->pagination->initialize($config);
               $page = $this->uri->segment(3);
               $start = ($page - 1) * $config['per_page']; //offset
               $data['reports'] = $this->reports->getBookedStockReport($config["per_page"], $start, $data['month']);
               $isEmpty = 1;
               if (empty($data['reports'])) {
                    $isEmpty = 0;
               }
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/booked_stock_report_ajax_view', $data, TRUE);
               $output = array(
                    'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    'total_records_count' => $stock_Count,
                    'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
                    'month' => $data['month'],
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $data['brand'] = $this->enquiry->getBrands();
               $this->render_page(strtolower(__CLASS__) . '/booked_stock_report', $data);
          }
     }

     function purchase_report()
     { //PURCHASE REPORT AS ON 23-08-2021
          //debug(333);
          if ($this->input->is_ajax_request()) {
               // debug($this->input->post('month'));
               $filterData = $this->input->post();
               $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
               $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
               $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
               $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
               $data['formFilter'] = $filterData;
               $data['month'] = $this->input->post('month');
               $purchase_Count = $this->reports->purchase_report_count($data['month']);
               //  debug( $purchase_Count);
               $purchase_Count = $purchase_Count['numrows'];
               // debug($stock_Count['numrows']);
               $minimum_price = $this->input->post('minimum_price');
               $maximum_price = $this->input->post('maximum_price');
               $brand = $this->input->post('brand');
               $ram = $this->input->post('ram');
               $storage = $this->input->post('storage');
               $this->load->library('pagination');
               $config = array();
               ///  $config['base_url'] = site_url('reports_1/booked_stock_report');***
               $config['base_url'] = site_url('reports_1/purchase_report');
               $config['total_rows'] = $purchase_Count;
               $config['per_page'] = 11; //limit
               $config['uri_segment'] = 3;
               $config['use_page_numbers'] = TRUE;
               $config['full_tag_open'] = '<ul class="pagination">';
               $config['full_tag_close'] = '</ul>';
               $config['first_tag_open'] = '<li>';
               $config['first_tag_close'] = '</li>';
               $config['last_tag_open'] = '<li>';
               $config['last_tag_close'] = '</li>';
               $config['next_link'] = '&gt;';
               $config['next_tag_open'] = '<li>';
               $config['next_tag_close'] = '</li>';
               $config['prev_link'] = '&lt;';
               $config['prev_tag_open'] = '<li>';
               $config['prev_tag_close'] = '</li>';
               $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               $config['cur_tag_close'] = '</a></li>';
               $config['num_tag_open'] = '<li>';
               $config['num_tag_close'] = '</li>';
               $config['num_links'] = 2;
               $this->pagination->initialize($config);
               $page = $this->uri->segment(3);
               $start = ($page - 1) * $config['per_page']; //offset
               $data['reports'] = $this->reports->purchase_report($config["per_page"], $start, $data['month']);
               // $data['reports'] = $this->reports->getBookedStockReport($config["per_page"], $start, $data['month']);
               $isEmpty = 1;
               if (empty($data['reports'])) {
                    $isEmpty = 0;
               }

               $filter_view = $this->load->view(strtolower(__CLASS__) . '/purchase_report_ajax_view', $data, TRUE);
               $output = array(
                    'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    'total_records_count' => $stock_Count,
                    'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
                    'month' => $data['month'],
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $data['brand'] = $this->enquiry->getBrands();
               $this->render_page(strtolower(__CLASS__) . '/purchase_report', $data);
          }
     }

     function sales_report()
     {

          //  debug(date('t', strtotime($lastMonth))) ;
          //
          //            debug($lastMonth);
          //$time = strtotime('10/16/2003');
          //
          //$newformat = date('Y-m-d',$time);
          if ($this->input->is_ajax_request()) {
               // debug(4545);
               $shrm = $this->input->post('showroom');
               //debug($shrm);
               $data['reports'] = $this->reports->salesReport($shrm);
               $data['shrm'] = $shrm;
               /* SELECT `enq_id`,`enq_showroom_id`,`enq_cus_name`,`enq_cus_mobile`,`enq_mode_enq`,`enq_cus_when_buy`,`enq_cus_status`,`enq_mode_enq`,`enq_entry_date` FROM `cpnl_enquiry` WHERE 1  
                   ORDER BY `cpnl_enquiry`.`enq_id` ASC
                  */
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/sales_report_ajax_view', $data, TRUE);
               //debug(  $filter_view );
               /* new */
               $data8['stsWithHmVst'] = $this->reports->statusWithHomeVisit($shrm);
               //  debug($data8);
               $stsHmVstVw = $this->load->view(strtolower(__CLASS__) . '/status_with_hm_vst_ajx_vw', $data8, TRUE);
               /* .. */
               $isLastMonth = 1;
               $data2['targetVsAch'] = $this->reports->targetVsAchievement($shrm, $isLastMonth);

               $targetVwLastMonth = $this->load->view(strtolower(__CLASS__) . '/sales_target_vs_ach_ajax_vw', $data2, TRUE);
               $isLastMonth = 0;
               $data3['targetVsAch'] = $this->reports->targetVsAchievement($shrm, $isLastMonth);
               $targetVwThisMonth = $this->load->view(strtolower(__CLASS__) . '/sales_target_vs_ach_ajax_vw', $data3, TRUE);
               (!$targetVwThisMonth) ? $targetVwThisMonth = '&nbsp No data found..' : '';
               (!$targetVwLastMonth) ? $targetVwLastMonth = '&nbsp No data found..' : '';
               $status = 'booked';
               $data3['weeklyData'] = $this->reports->weeklyTargetVsAchivement($shrm, $status); //status=28 booked
               $bookingStatus = $this->load->view(strtolower(__CLASS__) . '/sales_booking_status_ajax_vw', $data3, TRUE);
               $status = 'delivered';
               $data4['weeklyData'] = $this->reports->weeklyTargetVsAchivement($shrm, $status); //status=40 Delivered
               $deliveryStatus = $this->load->view(strtolower(__CLASS__) . '/sales_booking_status_ajax_vw', $data4, TRUE);
               //

               $data5['stockReport'] = $this->reports->stockReport($shrm, 40);
               //debug($data5['stockReport'] );
               $stockReport = $this->load->view(strtolower(__CLASS__) . '/md_stock_report_ajax_vw', $data5, TRUE);
               $data6['expectBookings'] = $this->reports->expectBooking($shrm);
               //  debug($data6['expectBookings']);
               $expectBooking = $this->load->view(strtolower(__CLASS__) . '/exp_booking_ajax_vw', $data6, TRUE);
               //// debug($data6['expectBookings']);
               //debug($stockReport);
               $data7['expectDeliveries'] = $this->reports->expecDelivery($shrm);
               //  debug($data6['expectBookings']);
               $expectDelivery = $this->load->view(strtolower(__CLASS__) . '/exp_delivery_ajax_vw', $data7, TRUE);
               $output = array(
                    'tableContent' => $filter_view,
                    'targetVwLastMonth' => $targetVwLastMonth,
                    'targetVwThisMonth' => $targetVwThisMonth,
                    'bookingStatus' => $bookingStatus,
                    'deliveryStatus' => $deliveryStatus,
                    'stockReport' => $stockReport,
                    'expectBooking' => $expectBooking,
                    'expectDelivery' => $expectDelivery,
                    'stsHmVstVw' => $stsHmVstVw,
               );
               die(json_encode($output));
          } else {
               $data = '';
               $this->render_page(strtolower(__CLASS__) . '/sales_report', $data);
          }
     }

     function targetVsAchievement()
     {
          $data['targetVsAch'] = $this->reports->targetVsAchievement();
          $filter_view = $this->load->view(strtolower(__CLASS__) . '/sales_target_vs_ach_ajax_view', $data, TRUE);
     }

     // 
     function expect_booking()
     {

          if ($this->input->is_ajax_request()) {
               // debug(3132);
               $filterData = $this->input->post();

               $stock_Count = $this->reports->stock_status_count(); //debug($stock_Count);

               $this->load->library('pagination');
               $config = array();
               $config['base_url'] = site_url('reports_1/expect_booking');
               $config['total_rows'] = $stock_Count;
               $config['per_page'] = 2; //limit
               $config['uri_segment'] = 3;
               $config['use_page_numbers'] = TRUE;
               $config['full_tag_open'] = '<ul class="pagination">';
               $config['full_tag_close'] = '</ul>';
               $config['first_tag_open'] = '<li>';
               $config['first_tag_close'] = '</li>';
               $config['last_tag_open'] = '<li>';
               $config['last_tag_close'] = '</li>';
               $config['next_link'] = '&gt;';
               $config['next_tag_open'] = '<li>';
               $config['next_tag_close'] = '</li>';
               $config['prev_link'] = '&lt;';
               $config['prev_tag_open'] = '<li>';
               $config['prev_tag_close'] = '</li>';
               $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               $config['cur_tag_close'] = '</a></li>';
               $config['num_tag_open'] = '<li>';
               $config['num_tag_close'] = '</li>';
               $config['num_links'] = 2;
               $this->pagination->initialize($config);
               $page = $this->uri->segment(3);
               //               if(!$page){
               ////                  echo 'noo'  ;
               //                    $page= (int)1;
               //               }else{
               //                    //echo 'ys';
               //                     $page= $page;
               //               }
               //               echo $page;
               // exit;
               // echo 'pg--'.$page;
               //   debug($page);
               $start = ($page - 1) * $config['per_page']; //offset
               //$data['enquiries'] = $this->reports->getEnquiriesForPooll($filterData, $config["per_page"], $start, $data['date_filter']);
               $data['reports'] = $this->reports->stock_status($config["per_page"], $start);
               //debug($data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/exp_booking_ajax_view', $data, TRUE);
               $output = array(
                    'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    'total_records_count' => $stock_Count,
                    'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
               );
               die(json_encode($output));
          }
     }

     function summary_enq()
     { //STOCK STATUS AS ON 23-08-2021
          if ($this->input->is_ajax_request()) {
               // $filterData = $this->input->post();
               $shrm = $this->input->post('showroom');
               $month = $this->input->post('month');
               //                 $shrm=2;
               //                 $month=9;
               $data['reports'] = $this->reports->summaryEnq($month, $shrm);
               //debug($data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/summary_enq_ajax_view', $data, TRUE);
               $output = array(
                    //'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    //'total_records_count' => $stock_Count,
                    //'uri_seg' => $page,
                    //'enq_dt_filtr' => $data['date_filter'],
               );
               die(json_encode($output));
          } else {
               $data['brand'] = $this->enquiry->getBrands();
               $this->render_page(strtolower(__CLASS__) . '/summary_enq', $data);
          }
     }

     function sales_data_bank()
     {

          $this->render_page(strtolower(__CLASS__) . '/sales_data_bank');
     }

     function sales_data_bank_ajx($param = '')
     {
          //debug(21321);
          if ($this->input->is_ajax_request()) {
               //debug( $this->input->post('showroom'));
               $showroom = $this->input->post('showroom');
               $month = $this->input->post('month');
               $filterData = $this->input->post();
               // debug($filterData);
               // $stock_Count = $this->reports->stock_status_count(); //debug($stock_Count);
               $total_Count = $this->reports->sales_data_bankCount($showroom, $month);
               // $total_Count=10;
               $this->load->library('pagination');
               $config = array();
               $config['base_url'] = site_url('reports_1/sales_data_bank_ajx');
               $config['total_rows'] = $total_Count;
               $config['per_page'] = 20; //limit
               $config['uri_segment'] = 3;
               $config['use_page_numbers'] = TRUE;
               $config['full_tag_open'] = '<ul class="pagination">';
               $config['full_tag_close'] = '</ul>';
               $config['first_tag_open'] = '<li>';
               $config['first_tag_close'] = '</li>';
               $config['last_tag_open'] = '<li>';
               $config['last_tag_close'] = '</li>';
               $config['next_link'] = '&gt;';
               $config['next_tag_open'] = '<li>';
               $config['next_tag_close'] = '</li>';
               $config['prev_link'] = '&lt;';
               $config['prev_tag_open'] = '<li>';
               $config['prev_tag_close'] = '</li>';
               $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               $config['cur_tag_close'] = '</a></li>';
               $config['num_tag_open'] = '<li>';
               $config['num_tag_close'] = '</li>';
               $config['num_links'] = 2;
               $this->pagination->initialize($config);
               $page = $this->uri->segment(3);
               //debug($page);
               $start = ($page - 1) * $config['per_page']; //offset
               //  debug(44);
               //$data['enquiries'] = $this->reports->getEnquiriesForPooll($filterData, $config["per_page"], $start, $data['date_filter']);
               $data['sdb'] = $this->reports->sales_data_bank($config["per_page"], $start, $showroom, $month);
               //  debug($data['sdb'] );
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/sales_data_bank_ajax_view', $data, TRUE);
               (!$filter_view) ? $filter_view = '&nbsp No data found..' : '';

               // $booking_veh_view = $this->load->view(strtolower(__CLASS__) . '/sales_data_bank_ajax_view', $data, TRUE);
               // (!$booking_veh_view) ? $booking_veh_view = '&nbsp No data found..' : '';

               $output = array(
                    'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    //  'booking_veh_view' => $booking_veh_view,
                    'total_records_count' => $total_Count,
                    'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
               );
               die(json_encode($output));
          }
     }

     function booking_veh_month_wise()
     {
          if ($this->input->is_ajax_request()) {
               // debug($this->input->post('month'));
               $filterData = $this->input->post();
               $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
               $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
               $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
               $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
               $data['formFilter'] = $filterData;
               $data['month'] = $this->input->post('month');
               $showroom = $this->input->post('showroom');
               //  $stock_Count = $this->reports->CountBookingVehs($data['month'], $showroom);
               //                 $minimum_price = $this->input->post('minimum_price');
               //                 $maximum_price = $this->input->post('maximum_price');
               //                 $brand = $this->input->post('brand');
               //                 $ram = $this->input->post('ram');
               //                 $storage = $this->input->post('storage');
               //                 $this->load->library('pagination');
               //                 $config = array();
               //                 $config['base_url'] = site_url('reports_1/booking_veh_month_wise');
               //                 $config['total_rows'] = $stock_Count;
               //                 $config['per_page'] = 100; //limit
               //                 $config['uri_segment'] = 3;
               //                 $config['use_page_numbers'] = TRUE;
               //                 $config['full_tag_open'] = '<ul class="pagination">';
               //                 $config['full_tag_close'] = '</ul>';
               //                 $config['first_tag_open'] = '<li>';
               //                 $config['first_tag_close'] = '</li>';
               //                 $config['last_tag_open'] = '<li>';
               //                 $config['last_tag_close'] = '</li>';
               //                 $config['next_link'] = '&gt;';
               //                 $config['next_tag_open'] = '<li>';
               //                 $config['next_tag_close'] = '</li>';
               //                 $config['prev_link'] = '&lt;';
               //                 $config['prev_tag_open'] = '<li>';
               //                 $config['prev_tag_close'] = '</li>';
               //                 $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               //                 $config['cur_tag_close'] = '</a></li>';
               //                 $config['num_tag_open'] = '<li>';
               //                 $config['num_tag_close'] = '</li>';
               //                 $config['num_links'] = 2;
               //                 $this->pagination->initialize($config);
               //                 $page = $this->uri->segment(3);
               //                 $start = ($page - 1) * $config['per_page']; //offset
               // $data['reports'] = $this->reports->getBookingVehs($config["per_page"], $start, $data['month'], $showroom);
               $data['reports'] = $this->reports->getBookingVehs($data['month'], $showroom);
               $isEmpty = 1;
               if (empty($data['reports'])) {
                    $isEmpty = 0;
               }
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/booking_veh_ajax_view', $data, TRUE);
               $output = array(
                    // 'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    // 'total_records_count' => $stock_Count,
                    // 'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
                    'month' => $data['month'],
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          }
     }

     function old_stock_report()
     {
          if ($this->input->is_ajax_request()) {
               // debug($this->input->post('month'));
               $filterData = $this->input->post();
               $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
               $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
               $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
               $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
               $data['formFilter'] = $filterData;
               $data['month'] = $this->input->post('month');
               $showroom = $this->input->post('showroom');
               // $stock_Count = $this->reports->CountBookingVehs($data['month'], $showroom);
               $stock_Count = 1000;
               $minimum_price = $this->input->post('minimum_price');
               $maximum_price = $this->input->post('maximum_price');
               $brand = $this->input->post('brand');
               $ram = $this->input->post('ram');
               $storage = $this->input->post('storage');
               //                 $this->load->library('pagination');
               //                 $config = array();
               //                 $config['base_url'] = site_url('reports_1/old_stock_report');
               //                 $config['total_rows'] = $stock_Count;
               //                 $config['per_page'] = 10; //limit
               //                 $config['uri_segment'] = 3;
               //                 $config['use_page_numbers'] = TRUE;
               //                 $config['full_tag_open'] = '<ul class="pagination">';
               //                 $config['full_tag_close'] = '</ul>';
               //                 $config['first_tag_open'] = '<li>';
               //                 $config['first_tag_close'] = '</li>';
               //                 $config['last_tag_open'] = '<li>';
               //                 $config['last_tag_close'] = '</li>';
               //                 $config['next_link'] = '&gt;';
               //                 $config['next_tag_open'] = '<li>';
               //                 $config['next_tag_close'] = '</li>';
               //                 $config['prev_link'] = '&lt;';
               //                 $config['prev_tag_open'] = '<li>';
               //                 $config['prev_tag_close'] = '</li>';
               //                 $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               //                 $config['cur_tag_close'] = '</a></li>';
               //                 $config['num_tag_open'] = '<li>';
               //                 $config['num_tag_close'] = '</li>';
               //                 $config['num_links'] = 2;
               // $this->pagination->initialize($config);
               //$page = $this->uri->segment(3);
               // $start = ($page - 1) * $config['per_page']; //offset
               // $data['reports'] = $this->reports->oldStockReport($config["per_page"], $start, $showroom);
               $data['reports'] = $this->reports->oldStockReport($showroom);
               $isEmpty = 1;
               if (empty($data['reports'])) {
                    $isEmpty = 0;
               }
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/old_stock_ajax_view', $data, TRUE);
               $output = array(
                    'oldStkContent' => $filter_view,
                    'enq_dt_filtr' => $data['date_filter'],
                    'month' => $data['month'],
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          }
     }

     function fc_payment_pending_deals()
     {
          //$showroom=2;
          //$data['reports'] = $this->reports->FcPaymentPendingDeals($showroom); 
          //debug($data);
          if ($this->input->is_ajax_request()) {

               $showroom = $this->input->post('showroom');
               $data['reports'] = $this->reports->FcPaymentPendingDeals($showroom);
               // debug($data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/fc_peyment_pending_ajax_view', $data, TRUE);
               (!$filter_view) ? $filter_view = '&nbsp No data found..' : '';
               $output = array(
                    'fcPaymentPendContent' => $filter_view,
               );
               die(json_encode($output));
          }
     }

     function rc_transfer_pending_list()
     {
          //$showroom=2;
          //$data['reports'] = $this->reports->FcPaymentPendingDeals($showroom); 
          //debug($data);
          if ($this->input->is_ajax_request()) {
               $isAbv = $this->uri->segment(3);
               $showroom = $this->input->post('showroom');
               $data['reports'] = $this->reports->RcTrnsfrPendings($showroom, $isAbv);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/rc_trsfr_pnd_list_ajx_vw', $data, TRUE);
               (empty($data['reports']['RcPendings']) && empty($data['reports']['RcTrnfrdThisMnth'])) ? $isEmpty = 1 : $isEmpty = 0;
               //        if (empty($data['reports']['RcPendings'])) {
               //                      $isEmpty = 0;
               //                 }
               $output = array(
                    'rcTrnfrContent' => $filter_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          }
     }

     //
     function insrnc_transfer_pending_list()
     {
          //$showroom=2;
          //$data['reports'] = $this->reports->FcPaymentPendingDeals($showroom); 
          //debug($data);
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               $data['reports'] = $this->reports->InsuranceTrnsfrPendings($showroom);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/insrnc_trsfr_pnd_list_ajx_vw', $data, TRUE);
               (empty($data['reports']['InsrncPendings'])) ? $isEmpty = 1 : $isEmpty = 0;
               //        if (empty($data['reports']['RcPendings'])) {
               //                      $isEmpty = 0;
               //                 }
               $output = array(
                    'insrncTrnfrContent' => $filter_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          }
     }

     function purchase_new_live_enqs()
     { //2 cmplt
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               //  debug($showroom);
               $data['reports'] = $this->reports->purchaseNewLiveEnqs($showroom);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/purch_new_live_enq_ajx_vw', $data, TRUE); //create vw
               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $data2['report'] = $this->reports->purchEnqStatusWithEvl($showroom);
               // debug($data2['reports']);
               $data2['shrm'] = $showroom;
               $filter_view2 = $this->load->view(strtolower(__CLASS__) . '/purch_enq_sts_ajx_vw', $data2, TRUE); //create vw
               ///
               //debug(454);
               // $data3['targetVsAch'] = $this->reports->purchEnqWeeklyTargetAchv($showroom);
               //debug($data3['targetVsAch']);
               //  $filter_view3 = $this->load->view(strtolower(__CLASS__) . '/purch_enq_wkly_target_achv_ajx_vw', $data3, TRUE); //create vw
               //  $data['enq_sts_evl'] = $this->reports->enq_sts_with_evl($showroom);
               // debug($filter_view2);
               $booking_sts = 28;
               $data3['weeklyData'] = $this->reports->purchEnqWeeklyTargetAchv($showroom, $booking_sts);
               $filter_view3 = $this->load->view(strtolower(__CLASS__) . '/purch_enq_wkly_target_achv_ajx_vw', $data3, TRUE);
               $output = array(
                    'tableContent' => $filter_view,
                    'tableContent2' => $filter_view2,
                    'tableContent3' => $filter_view3,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/purch_report_new_live_enq');
          }
     }

     function daily_sales_report_bk()
     {
          //$this->reports->dailySalesReport(1);
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               // $showroom = 1;
               $data['reports'] = $this->reports->dailySalesReport($showroom);
               // debug( $data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/sales_rep_monday_ajx_vw', $data, TRUE); //create vw
               $data2['staffEnqSts'] = $this->reports->getStaffs_enq_ByShrm($showroom);
               //debug($data2);
               $enq_status_view = $this->load->view(strtolower(__CLASS__) . '/sales_rep_mon_sts_ajx_vw', $data2, TRUE);
               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $output = array(
                    'tableContent' => $filter_view,
                    'tbl2Content' => $enq_status_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/daily_sales_report_monday');
          }
     }

     function daily_sales_report()
     {
          //$this->reports->dailySalesReport(1);
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               // $showroom = 1;
               $data['reports'] = $this->reports->dailySalesReport($showroom);
               // debug( $data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/sales_rep_monday_ajx_vw', $data, TRUE); //create vw
               $data2['staffEnqSts'] = $this->reports->getStaffs_enq_ByShrm($showroom);
               //debug($data2);$enq_status_view = $this->load->view(strtolower(__CLASS__) . '/sales_rep_mon_sts_ajx_vw', $data2, TRUE);
               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $enq_status_view = $this->load->view(strtolower(__CLASS__) . '/sales_rep_mon_sts_ajx_vw', $data2, TRUE);
               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $data3['hotLists'] = $this->reports->getStaffsEnqHotListByShrm($showroom);
               //debug( $data3);
               $hot_list_view = $this->load->view(strtolower(__CLASS__) . '/sales_hot_list_ajx_vw', $data3, TRUE);

               $output = array(
                    'tableContent' => $filter_view,
                    'tbl2Content' => $enq_status_view,
                    'tblContent3' => $hot_list_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/daily_sales_report_monday');
          }
     }

     function enq_model_wise_analysis()
     { //tableContent
          if ($this->input->is_ajax_request()) {
               // debug($this->input->post());
               $showroom = $this->input->post('showroom');
               $frm_date = $this->input->post('enq_date_from');
               $to_date = $this->input->post('enq_date_to');
               $data['staffs'] = $this->reports->getStaffsByShrm($showroom);
               $data['vehs'] = $this->reports->getBrandAndModel($showroom, $frm_date, $to_date);
               // debug($data);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/wv_enq_mdl_wise_analysis_ajx', $data, TRUE);
               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $output = array(
                    'tableContent' => $filter_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/wv_enq_mdl_wise_analysis');
          }
     }

     function sales_day_wise_report()
     {
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               //  $showroom = 1;
               $data['reports'] = $this->reports->dayWiseReport($showroom);
               // debug( $data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/wv_sales_day_wise_report_ajx', $data, TRUE); //create vw

               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $output = array(
                    'tableContent' => $filter_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/wv_sales_day_wise_report');
          }
     }

     function daily_purchase_report()
     {
          //$this->reports->dailySalesReport(1);
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               // $showroom = 1;
               $data['reports'] = $this->reports->dailyPurchseReport($showroom);
               // debug( $data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/purchase_rep_monday_ajx_vw', $data, TRUE); //create vw
               $data2['staffEnqSts'] = $this->reports->getPurchaseStaffs_enq_ByShrm($showroom);
               //debug($data2);
               $enq_status_view = $this->load->view(strtolower(__CLASS__) . '/purchase_rep_mon_sts_ajx_vw', $data2, TRUE);
               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $output = array(
                    'tableContent' => $filter_view,
                    'tbl2Content' => $enq_status_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/daily_purchase_report_monday');
          }
     }

     function purhase_day_wise_report()
     {
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               //  $showroom = 1;
               $data['reports'] = $this->reports->dayWiseReportPurchase($showroom);
               // debug( $data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/wv_purchase_day_wise_report_ajx', $data, TRUE); //create vw

               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $output = array(
                    'tableContent' => $filter_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/wv_purchase_day_wise_report');
          }
     }

     function summary_enq_purchase()
     { //STOCK STATUS AS ON 23-08-2021
          if ($this->input->is_ajax_request()) {
               // $filterData = $this->input->post();
               $shrm = $this->input->post('showroom');
               $month = $this->input->post('month');
               //                 $shrm=2;
               //                 $month=9;
               $data['reports'] = $this->reports->summaryEnqPurchase($month, $shrm);
               //debug($data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/summary_enq_ajax_view_purchase', $data, TRUE);
               $output = array(
                    //'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    //'total_records_count' => $stock_Count,
                    //'uri_seg' => $page,
                    //'enq_dt_filtr' => $data['date_filter'],
               );
               die(json_encode($output));
          } else {
               $data['brand'] = $this->enquiry->getBrands();
               $this->render_page(strtolower(__CLASS__) . '/summary_enq_purchase', $data);
          }
     }

     function detailed_walk_in_report()
     { //detailedWalikInReport
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               //  $showroom = 1;
               $data['reports'] = $this->reports->detailedWalikInReport($showroom);
               // debug( $data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/wv_detailed_walkin_report_ajx', $data, TRUE); //create vw

               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $output = array(
                    'tableContent' => $filter_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/wv_detailed_walkin_report');
          }
     }

     function price_listk()
     {
          if ($this->input->is_ajax_request()) {
               $showroom = $this->input->post('showroom');
               //  $showroom = 1;
               $data['reports'] = $this->reports->detailedWalikInReport($showroom);
               // debug( $data['reports']);
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/wv_price_list_ajx', $data, TRUE); //create vw

               (empty($data['reports'])) ? $isEmpty = 1 : $isEmpty = 0;
               $output = array(
                    'tableContent' => $filter_view,
                    'isEmpty' => $isEmpty,
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/wv_price_list');
          }
     }

     //////////

     function price_list_bk($param = '')
     {
          //debug(21321);
          if ($this->input->is_ajax_request()) {
               //  debug( $this->input->post('showroom'));
               $showroom = $this->input->post('showroom');
               //   debug($showroom);
               $month = $this->input->post('month');
               $filterData = $this->input->post();
               // debug($filterData);
               // $stock_Count = $this->reports->stock_status_count(); //debug($stock_Count);
               $total_Count = $this->reports->price_listCount($showroom, $month);
               // $total_Count=10;
               $this->load->library('pagination');
               $config = array();
               $config['base_url'] = site_url('reports_1/price_list_bk');
               $config['total_rows'] = $total_Count;
               $config['per_page'] = 2; //limit
               $config['uri_segment'] = 3;
               $config['use_page_numbers'] = TRUE;
               $config['full_tag_open'] = '<ul class="pagination">';
               $config['full_tag_close'] = '</ul>';
               $config['first_tag_open'] = '<li>';
               $config['first_tag_close'] = '</li>';
               $config['last_tag_open'] = '<li>';
               $config['last_tag_close'] = '</li>';
               $config['next_link'] = '&gt;';
               $config['next_tag_open'] = '<li>';
               $config['next_tag_close'] = '</li>';
               $config['prev_link'] = '&lt;';
               $config['prev_tag_open'] = '<li>';
               $config['prev_tag_close'] = '</li>';
               $config['cur_tag_open'] = "<li class='active'><a href='#'>";
               $config['cur_tag_close'] = '</a></li>';
               $config['num_tag_open'] = '<li>';
               $config['num_tag_close'] = '</li>';
               $config['num_links'] = 2;
               $this->pagination->initialize($config);
               $page = $this->uri->segment(3);
               //debug($page);
               $start = ($page - 1) * $config['per_page']; //offset
               //  debug(44);
               //$data['enquiries'] = $this->reports->getEnquiriesForPooll($filterData, $config["per_page"], $start, $data['date_filter']);
               $data['details'] = $this->reports->price_list_bk($config["per_page"], $start, $showroom, $month);
               //  debug($data['sdb'] );
               $filter_view = $this->load->view(strtolower(__CLASS__) . '/wv_price_list_ajx', $data, TRUE);
               (!$filter_view) ? $filter_view = '&nbsp No data found..' : '';

               // $booking_veh_view = $this->load->view(strtolower(__CLASS__) . '/sales_data_bank_ajax_view', $data, TRUE);
               // (!$booking_veh_view) ? $booking_veh_view = '&nbsp No data found..' : '';

               $output = array(
                    'pagination_link' => $this->pagination->create_links(),
                    'tableContent' => $filter_view,
                    //  'booking_veh_view' => $booking_veh_view,
                    'total_records_count' => $total_Count,
                    'uri_seg' => $page,
                    'enq_dt_filtr' => $data['date_filter'],
               );
               die(json_encode($output));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/wv_price_list_bk');
          }
     }

     function price_list()
     {

          $data['div'] = $this->input->get('vreg_division');
          $data['shwrm'] = $this->input->get('vreg_showroom');
          $data['details'] = $this->reports->price_list($data['div'], $data['shwrm']);
          $data['division'] = $this->divisions->getActiveData();
          $data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
          $this->render_page(strtolower(__CLASS__) . '/wv_price_list', $data);
     }

     public function price_list_export_excel()
     {
          //debug($priceLists);
          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel report price list',
               'log_desc' => $this->session->userdata('usr_username') . ' downloaded excel report price list on - ' . date('Y-m-d H:i:s'),
               'log_controller' => 'exp-excel-my-register',
               'log_action' => 'R',
               'log_ref_id' => 1002,
               'log_added_by' => $this->uid
          ));


          $this->page_title = 'Price list';
          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('Price list');
          $heading = array('Sl', 'Brand', 'Vehicle', 'Mode', 'Color', 'Fuel', 'Mnr Year', 'Month & Year of', 'Reg no', 'Km', 'No.Owners', 'INS', 'IDV', 'Price', 'Booking Date', 'Booked Staff Name', 'Status');

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
          $data['div'] = $this->input->get('vreg_division');
          $data['shwrm'] = $this->input->get('vreg_showroom');
          $priceLists = $this->reports->price_list($data['div'], $data['shwrm']);
          if (!empty($priceLists)) {
               foreach ($priceLists as $key => $value) {

                    if ($value['vbk_status'] == 28 or $value['vbk_status'] == 13) {
                         $shwrm = unserialize(Showrooms)[$value['vbk_showroom']];

                         $text = 'Booked-' . $shwrm;
                    } else {
                         $shwrm = unserialize(Showrooms)[$value['val_showroom']];

                         $text = 'STOCK-' . $shwrm;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $key + 1);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['brd_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['mod_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['val_type'] == 1 ? 'O' : $value['val_type'] == 5 ? 'O' : 'P');
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['val_color']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['val_fuel']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['val_minif_year']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['val_manf_date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['val_veh_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['val_km']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['val_no_of_owner']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['val_insurance_validity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['val_insurance_idv']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['prd_price']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['vbk_added_on']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['booked_staff']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $text);


                    $row++;
                    $no++;
               }
          }

          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="priceList.xls"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
          exit();
     }

     function refurb_stock_status()
     {

          $data['div'] = $this->input->get('vreg_division');
          $data['shwrm'] = $this->input->get('vreg_showroom');
          $data['details'] = $this->reports->refurbStocks($data['div'], $data['shwrm']); //
          $data['division'] = $this->divisions->getActiveData();
          $data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
          $this->render_page(strtolower(__CLASS__) . '/wv_price_list', $data);
     }

     function submitReAssign()
     {
          if (isset($_POST['executive']) && (count($_POST['executive']) > 0)) {
               $searchValues = isset($_POST['searchValues']) ? unserialize($_POST['searchValues']) : '';
               if (isset($_POST['source']) && $_POST['source'] == 'rpt_enquires') { //Report from enquires enquiry vise
                    $enquires = $this->reports->searchInquiryByDefaultNoLimit(0, 0, $searchValues);
               } else {
                    $enquires = $this->reports->quickVehicleSearchNolimit(0, 0, $searchValues);
               }
               if (!empty($enquires)) {
                    $index = 0;
                    $exic = $_POST['executive'];
                    $comment = $_POST['desc'];
                    $staffindx = 0;
                    $result = $this->assignProcess($enquires, $exic, $index, $staffindx, $comment);
                    if ($result) {
                         die(json_encode(array('msg' => count($enquires) . ' inquires re-assigned ')));
                    } else {
                         die(json_encode(array('msg' => 'Error')));
                    }
               } else {
                    die(json_encode(array('msg' => 'Error: No inquiry found')));
               }
          }
          die(json_encode(array('msg' => ' Error :Please select at least one staff')));
     }

     function assignProcess($enquires, $exic, $i, $staffIndex, $comment)
     {
          $enq_id = $enquires[$i]['enq_id'];
          $toStaff = $exic[$staffIndex];
          $enqCount = count($enquires);
          $staffCount = count($exic);
          $oldStaff = $enquires[$i]['enq_se_id'];
          $divBySE = intval(($enqCount / $staffCount));
          /* $data[$i]['enq_id'] = $enquires[$i]['enq_id'];
              $data[$i]['staff_id'] = $exic[$staffIndex];
              debug($data,0); */
          $this->reports->updateReAssign($enq_id, $toStaff, $oldStaff);
          $this->reports->updateReAssignHistoryFollowup($oldStaff, $toStaff, $enq_id, $enquires[$i], $comment, $divBySE);
          $i = $i + 1;
          $staffIndex = $staffIndex + 1;
          if ($i < $enqCount) {
               if ($staffIndex == ($staffCount)) {
                    $staffIndex = 0;
                    $this->assignProcess($enquires, $exic, $i, $staffIndex, $comment);
               } else {
                    $this->assignProcess($enquires, $exic, $i, $staffIndex, $comment);
               }
          }
          return true;
     }
}
