<?php

defined('BASEPATH') or exit('No direct script access allowed');

class evaluation extends App_Controller
{

     public function __construct()
     {

          parent::__construct();
          $this->page_title = 'Valuation';
          $this->load->library('form_validation');
          $this->load->model('evaluation_model', 'evaluation');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
     }

     function evaluation_ajax()
     {
          //debug($this->input->post());
          $response = $this->evaluation->evaluation_ajax($this->input->post(), $this->input->get());
          // debug($response);
          echo json_encode($response);
     }

     public function index()
     {
          $data['brand'] = $this->enquiry->getBrands();
          $data['evaluators'] = $this->evaluation->getAllEvaluators();
          $data['salesExe'] = $this->evaluation->getEnquiryHandingMembers();
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }
     public function stock()
     { //stock vehicle
          $data['brand'] = $this->enquiry->getBrands();
          $data['evaluators'] = $this->evaluation->getAllEvaluators();
          $data['salesExe'] = $this->evaluation->getEnquiryHandingMembers();
          $data['allShowrooms'] = $this->showroom->get();
          $data['division'] = $this->divisions->getActiveData();
          $this->render_page(strtolower(__CLASS__) . '/list_stock_vehicles', $data);
     }

     function stock_ajax()
     {
          $response = $this->evaluation->stock_ajax($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     function xlsxStock()
     {
          $evaluaionData = $this->evaluation->stock_ajax(array(), $this->input->get());
          $evaluaionData = $evaluaionData['aaData'];

          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' downloaded excel from stock',
               'log_desc' => $this->session->userdata('usr_username') . ' downloaded excel report from stock on - ' . date('Y-m-d H:i:s'),
               'log_controller' => 'exp-excel-stock-vehicle',
               'log_action' => 'R',
               'log_ref_id' => 1006,
               'log_added_by' => $this->uid
          ));

          $this->load->library("excel");
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getActiveSheet()->setTitle('stock report');
          $heading = array(
               'Stock ID',
               'Name',
               'Phone',
               'Cust Status',
               'Reg Number',
               'Added by',
               'Evaluated by',
               'Showroom',
               'Brand',
               'Model',
               'Evaluated on',
               'Chasis no',
               'Fuel',
               'CC',
               'Booking Status'
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
          $enqStatus = unserialize(FOLLOW_UP_STATUS);
          if (!empty($evaluaionData)) {
               foreach ($evaluaionData as $key => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['val_stock_num']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['val_cust_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['val_cust_phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $enqStatus[$value['enq_cus_when_buy']]);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['val_veh_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['usr_username']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['evtr_usr_username']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['shr_location']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['brd_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['mod_title']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['val_added_date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['val_chasis_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['fuel']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['val_eng_cc']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['val_book_sts_title']);
                    $row++;
                    $no++;
               }
          }
          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          //header('Content-Type: application/vnd.ms-excel');
          //header('Content-Disposition: attachment;filename="rdportal-myregister-report.xls"');
          //header('Cache-Control: max-age=0');
          //$objWriter->save('php://output');
          $objWriter->save('../rdms/assets/uploads/rdportal-valuation-report.xls');
          die(json_encode('../assets/uploads/rdportal-valuation-report.xls'));
     }

     function view($id)
     {
          $this->load->model('registration/registration_model', 'registration');
          if (!is_numeric($id)) {
               $id = encryptor($id, 'D');
          }
          $data['division'] = $this->divisions->getActiveData();
          $data['vehicles'] = $this->evaluation->getEvaluation($id);
          $data['brand'] = $this->enquiry->getBrands();
          $data['model'] = $this->enquiry->getModelByBrand($data['vehicles']['val_brand']);
          $data['variant'] = $this->enquiry->getVariantByModel($data['vehicles']['val_model']);
          $data['banks'] = $this->evaluation->getAllBanks();
          $data['insurers'] = $this->evaluation->getInsurers();
          $data['managers'] = $this->evaluation->getAllManagers();
          $data['APMASM'] = $this->evaluation->getAllAPMASM();
          $data['evaluators'] = $this->evaluation->getAllEvaluators();
          $data['salesExe'] = $this->evaluation->getEnquiryHandingMembers();
          $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
          $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
          $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();
          $data['showroom'] = $this->registration->getShowRoomByDivision($data['vehicles']['val_division']);
          $data['purchaseAdmin'] = $this->evaluation->getStaffByGroup('usr_is_purchase_admin');
          $data['mis'] = $this->evaluation->getMISEvaluation();
          $data['delco'] = $this->evaluation->getDelco();
          $data['teleclrs'] = $this->evaluation->getTelecaller();
          $data['telslsco'] = $this->evaluation->getTelesalesCoordinator();
          $data['telprsco'] = $this->evaluation->getTelePurchaseCoordinator();
          $data['admin'] = $this->evaluation->getStaffByGroup('usr_is_sales_admin');
          $data['color'] = $this->evaluation->getColors();
          $data['tyre'] = $this->evaluation->getTyre();
          $this->render_page(strtolower(__CLASS__) . '/view', $data);
     }

     function add()
     {
          generate_log(array(
               'log_title' => 'Evaluation pre insert',
               'log_desc' => serialize($_POST),
               'log_controller' => 'evaluation-pre-insert',
               'log_action' => 'U',
               'log_ref_id' => 0,
               'log_added_by' => get_logged_user('usr_id')
          ));
          if (!empty($_POST)) {
               $this->load->library('upload');
               //if (!$this->evaluation->checkVehicleExists($_POST)) {
               if ($evId = $this->evaluation->newEvaluation($_POST['valuation'])) {
                    if (isset($_POST['complaint_title']) && !empty($_POST['complaint_title'])) {
                         foreach ($_POST['complaint_title'] as $key => $value) {
                              $complaint['comp_pic'] = '';
                              if (isset($_FILES['complaint_file']['name'][$key]) && !empty($_FILES['complaint_file']['name'][$key])) {
                                   $newFileName = rand() . $_FILES['complaint_file']['name'][$key];
                                   $config['upload_path'] = '../rdms/assets/uploads/evaluation/';
                                   $config['allowed_types'] = '*';
                                   $config['file_name'] = $newFileName;
                                   $this->upload->initialize($config);

                                   $_FILES['prd_image_tmp']['name'] = $_FILES['complaint_file']['name'][$key];
                                   $_FILES['prd_image_tmp']['type'] = $_FILES['complaint_file']['type'][$key];
                                   $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['complaint_file']['tmp_name'][$key];
                                   $_FILES['prd_image_tmp']['error'] = $_FILES['complaint_file']['error'][$key];
                                   $_FILES['prd_image_tmp']['size'] = $_FILES['complaint_file']['size'][$key];

                                   if ($this->upload->do_upload('prd_image_tmp')) {
                                        $uploadData = $this->upload->data();
                                        $complaint['comp_pic'] = $uploadData['file_name'];
                                   } else {
                                        $uploadError = $this->upload->display_errors();
                                   }
                              }
                              if (!empty($complaint['comp_pic']) || !empty($value)) {
                                   $complaint['comp_val_id'] = $evId;
                                   $complaint['comp_complaint'] = $value;
                                   $this->evaluation->newEvaluationComplaints($complaint);
                              }
                         }
                         $this->session->set_flashdata('app_success', 'Row successfully added!');
                    }
                    //features
                    if (isset($_POST['features']) && !empty($_POST['features'])) {
                         foreach ($_POST['features'] as $key => $value) {
                              $this->evaluation->newFeatures(array('vfet_valuation' => $evId, 'vfet_feature' => $value));
                         }
                    }
                    //Full body check up
                    if (isset($_POST['fulbdchk']) && !empty($_POST['fulbdchk'])) {
                         foreach ($_POST['fulbdchk'] as $key => $value) {
                              $this->evaluation->fullBodyCheckup(
                                   array(
                                        'vfbc_valuation_master' => $evId,
                                        'vfbc_chkup_master' => $key,
                                        'vfbc_chkup_details' => $value
                                   )
                              );
                         }
                    }
                    //Upgradation details
                    if (isset($_POST['upgradedetails']) && !empty($_POST['upgradedetails'])) {
                         $this->evaluation->upgradeDetails($_POST['upgradedetails'], $evId);
                    }
                    //Upload documents
                    if (
                         isset($_FILES['documents']['name'][0]) && !empty($_FILES['documents']['name'][0]) &&
                         is_array($_FILES['documents']['name'])
                    ) {
                         foreach ($_FILES['documents']['name'] as $key => $value) {
                              $newFileName = rand() . $_FILES['documents']['name'][$key];
                              $config['upload_path'] = '../rdms/assets/uploads/evaluation/';
                              $config['allowed_types'] = '*';
                              $config['file_name'] = $newFileName;
                              $this->upload->initialize($config);

                              $_FILES['tmp_doc']['name'] = $_FILES['documents']['name'][$key];
                              $_FILES['tmp_doc']['type'] = $_FILES['documents']['type'][$key];
                              $_FILES['tmp_doc']['tmp_name'] = $_FILES['documents']['tmp_name'][$key];
                              $_FILES['tmp_doc']['error'] = $_FILES['documents']['error'][$key];
                              $_FILES['tmp_doc']['size'] = $_FILES['documents']['size'][$key];

                              if ($this->upload->do_upload('tmp_doc')) {
                                   $uploadData = $this->upload->data();
                                   $complaint['comp_pic'] = $uploadData['file_name'];

                                   if (isset($uploadData['file_name']) && !empty($uploadData['file_name'])) {
                                        $docs['vdoc_val_id'] = $evId;
                                        $docs['vdoc_doc'] = $uploadData['file_name'];
                                        $docs['vdoc_doc_title'] = isset($_POST['document_title'][$key]) ? $_POST['document_title'][$key] : '';
                                        $docs['vdoc_doc_type'] = isset($_POST['document_type'][$key]) ? $_POST['document_type'][$key] : '';
                                        $this->evaluation->newEvaluationDocument($docs);
                                   }
                              } else {
                                   $f = $this->upload->display_errors();
                                   debug($f);
                              }
                         }
                    }
                    //Upload images
                    if (isset($_POST['eveimg']) && !empty($_POST['eveimg'])) {
                         foreach ($_POST['eveimg'] as $key => $value) {
                              if (!empty($value)) {
                                   $frame = explode('_', $value);
                                   $frame = isset($frame['0']) ? $frame['0'] : 0;
                                   $this->evaluation->uploadEvaluationVehicleImages(array('vvi_val_id' => $evId, 'vvi_frame_id' => $frame, 'vvi_image' => $value));
                              }
                         }
                    }
                    echo json_encode(array('status' => 'success', 'msg' => ''));
               } else {
                    $this->session->set_flashdata('app_error', 'Row successfully added!');
               }
               //} else {
               //    echo json_encode(array('status' => 'fail', 'msg' => 'Vehicle already evaluated'));
               //}
          } else {
               $data['showroom'] = $this->showroom->get();
               $data['brand'] = $this->enquiry->getBrands();
               $data['banks'] = $this->evaluation->getAllBanks();
               $data['insurers'] = $this->evaluation->getInsurers();
               $data['division'] = $this->divisions->getActiveData();
               $data['managers'] = $this->evaluation->getAllManagers();
               $data['salesExe'] = $this->evaluation->getEnquiryHandingMembers();
               $data['evaluators'] = $this->evaluation->getAllEvaluators();
               $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
               $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
               $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();
               $data['APMASM'] = $this->evaluation->getAllAPMASM();
               $data['telprsco'] = $this->evaluation->getTelePurchaseCoordinator();
               $data['mis'] = $this->evaluation->getMISEvaluation();
               $data['delco'] = $this->evaluation->getDelco();
               $data['teleclrs'] = $this->evaluation->getTelecaller();
               $data['telslsco'] = $this->evaluation->getTelesalesCoordinator();
               $data['admin'] = $this->evaluation->getStaffByGroup('usr_is_sales_admin');
               $data['purchaseAdmin'] = $this->evaluation->getStaffByGroup('usr_is_purchase_admin');
               $data['color'] = $this->evaluation->getColors();
               $this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     function update()
     {
          generate_log(array(
               'log_title' => 'Evaluation pre update',
               'log_desc' => serialize($_POST),
               'log_controller' => 'evaluation-pre-update',
               'log_action' => 'U',
               'log_ref_id' => $id,
               'log_added_by' => get_logged_user('usr_id')
          ));

          // if($this->uid=358){
          $this->form_validation->set_rules('valuation[val_division]', 'Division', 'required');
          $this->form_validation->set_rules('valuation[val_showroom]', 'Branch', 'required');
          $this->form_validation->set_rules('valuation[val_prt_1]', 'Reg No part1', 'required');
          $this->form_validation->set_rules('valuation[val_prt_2]', 'Reg No part2', 'required');
          $this->form_validation->set_rules('valuation[val_prt_4]', 'Reg No part4', 'required');
          $this->form_validation->set_rules('valuation[val_brand]', 'Brand', 'required');
          $this->form_validation->set_rules('valuation[val_model]', 'Model', 'required|callback_model_check');
          $this->form_validation->set_rules('valuation[val_variant]', 'Variant', 'required');
          $this->form_validation->set_rules('valuation[val_model_year]', 'Model Year', 'required');
          $this->form_validation->set_rules('valuation[val_color]', 'Color', 'required');
          $this->form_validation->set_rules('valuation[val_fuel]', 'Fuel', 'required');
          $this->form_validation->set_rules('valuation[val_engine_no]', 'Engine No', 'required|min_length[3]');
          $this->form_validation->set_rules('valuation[val_chasis_no]', 'Chasis no', 'required|min_length[3]');
          $this->form_validation->set_rules('valuation[val_eng_cc]', 'Eng cc', 'required');

          // Run validation
          if ($this->form_validation->run() == FALSE) {
               // Validation failed, return validation errors as JSON
               $errors = validation_errors();
               $response = array(
                    'status' => 'error',
                    'message' => $errors
               );
               header('Content-Type: application/json');
               echo json_encode($response);
               exit;
          }

          //}
          //debug($_POST); exit;
          $this->load->library('upload');
          $id = 0;
          if (isset($_POST['val_id'])) {
               $id = $_POST['val_id'];
          }

          $uploadError = '';
          if ($id > 0) {
               //if (!$this->evaluation->checkVehicleExists($_POST)) {
               if ($this->evaluation->updateEvaluation($id, $_POST['valuation'])) {
                    if (isset($_POST['complaint_title']) && !empty($_POST['complaint_title'])) {
                         foreach ($_POST['complaint_title'] as $key => $value) {
                              $complaint['comp_pic'] = '';
                              if (isset($_FILES['complaint_file']['name'][$key]) && !empty($_FILES['complaint_file']['name'][$key])) {
                                   $this->load->library('upload');
                                   $newFileName = rand() . $_FILES['complaint_file']['name'][$key];
                                   $config['upload_path'] = '../rdms/assets/uploads/evaluation/';
                                   $config['allowed_types'] = '*';
                                   $config['file_name'] = $newFileName;
                                   $this->upload->initialize($config);

                                   $_FILES['prd_image_tmp']['name'] = $_FILES['complaint_file']['name'][$key];
                                   $_FILES['prd_image_tmp']['type'] = $_FILES['complaint_file']['type'][$key];
                                   $_FILES['prd_image_tmp']['tmp_name'] = $_FILES['complaint_file']['tmp_name'][$key];
                                   $_FILES['prd_image_tmp']['error'] = $_FILES['complaint_file']['error'][$key];
                                   $_FILES['prd_image_tmp']['size'] = $_FILES['complaint_file']['size'][$key];

                                   if ($this->upload->do_upload('prd_image_tmp')) {
                                        $uploadData = $this->upload->data();
                                        $complaint['comp_pic'] = $uploadData['file_name'];
                                   } else {
                                        $uploadError = $this->upload->display_errors();
                                   }
                              }
                              if (!empty($complaint['comp_pic']) || !empty($value)) {
                                   $complaint['comp_val_id'] = $id;
                                   $complaint['comp_complaint'] = $value;
                                   $this->evaluation->newEvaluationComplaints($complaint);
                              }
                         }
                         $this->session->set_flashdata('app_success', 'Row successfully updated!');
                    }

                    //Upload documents
                    if ((isset($_FILES['documents']['name']) && !empty($_FILES['documents']['name']) &&
                         is_array($_FILES['documents']['name'])) && (isset($_FILES['documents']['name'][0]) && !empty($_FILES['documents']['name'][0]))) {
                         foreach ($_FILES['documents']['name'] as $key => $value) {
                              $newFileName = rand() . $_FILES['documents']['name'][$key];
                              $config['upload_path'] = '../rdms/assets/uploads/evaluation/';
                              $config['allowed_types'] = '*';
                              $config['file_name'] = $newFileName;
                              $this->upload->initialize($config);

                              $_FILES['tmp_doc']['name'] = $_FILES['documents']['name'][$key];
                              $_FILES['tmp_doc']['type'] = $_FILES['documents']['type'][$key];
                              $_FILES['tmp_doc']['tmp_name'] = $_FILES['documents']['tmp_name'][$key];
                              $_FILES['tmp_doc']['error'] = $_FILES['documents']['error'][$key];
                              $_FILES['tmp_doc']['size'] = $_FILES['documents']['size'][$key];

                              if ($this->upload->do_upload('tmp_doc')) {
                                   $uploadData = $this->upload->data();
                                   $complaint['comp_pic'] = $uploadData['file_name'];

                                   if (isset($uploadData['file_name']) && !empty($uploadData['file_name'])) {
                                        $docs['vdoc_val_id'] = $id;
                                        $docs['vdoc_doc'] = $uploadData['file_name'];
                                        $docs['vdoc_doc_title'] = isset($_POST['document_title'][$key]) ? $_POST['document_title'][$key] : '';
                                        $docs['vdoc_doc_type'] = isset($_POST['document_type'][$key]) ? $_POST['document_type'][$key] : '';
                                        $this->evaluation->newEvaluationDocument($docs);
                                   }
                              } else {
                                   $f = $this->upload->display_errors();
                                   debug($f);
                              }
                         }
                    }

                    //features
                    if (isset($_POST['features']) && !empty($_POST['features'])) {
                         $this->evaluation->removeFeaturesByMaster($id);
                         foreach ($_POST['features'] as $key => $value) {
                              $this->evaluation->newFeatures(array('vfet_valuation' => $id, 'vfet_feature' => $value));
                         }
                    }
                    //Full body check up
                    if (isset($_POST['fulbdchk']) && !empty($_POST['fulbdchk'])) {
                         $this->evaluation->removeBodyCheckupByMaster($id);
                         foreach ($_POST['fulbdchk'] as $key => $value) {
                              $this->evaluation->fullBodyCheckup(
                                   array(
                                        'vfbc_valuation_master' => $id,
                                        'vfbc_chkup_master' => $key,
                                        'vfbc_chkup_details' => $value
                                   )
                              );
                         }
                    }
                    //Upgradation details
                    if (isset($_POST['upgradedetails']) && !empty($_POST['upgradedetails'])) {
                         $this->evaluation->removeUpgradeDetailsByMaster($id);
                         $this->evaluation->upgradeDetails($_POST['upgradedetails'], $id);
                    }

                    //Upload images
                    if (isset($_POST['eveimg']) && !empty($_POST['eveimg'])) {
                         foreach ($_POST['eveimg'] as $key => $value) {
                              if (!empty($value)) {
                                   $frame = explode('_', $value);
                                   $frame = isset($frame['0']) ? $frame['0'] : 0;
                                   $this->evaluation->uploadEvaluationVehicleImages(array('vvi_val_id' => $id, 'vvi_frame_id' => $frame, 'vvi_image' => $value));
                              }
                         }
                    }

                    //Upload documents
                    die(json_encode(array('status' => 'success', 'msg' => '')));
               } else {
                    $this->session->set_flashdata('app_success', 'Error occured');
               }
               //} else {
               //     die(json_encode(array('status' => 'fail', 'msg' => 'Vehicle already exists')));
               //}

               if (!empty($uploadError)) {
                    $this->session->set_flashdata('app_success', $uploadError);
               }
          }
          //exit;
          redirect(__CLASS__);
     }

     function deleteImage($id)
     {
          $id = encryptor($id, 'D');
          if ($this->evaluation->deleteImage($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete this row"));
          }
     }

     function delete($id)
     {
          $id = encryptor($id, 'D');
          if ($this->evaluation->delete($id)) {
               $this->session->set_flashdata('app_success', 'Row successfully delated');
          } else {
               $this->session->set_flashdata('app_success', 'Error occured');
          }
          redirect(__CLASS__);
     }

     function autoComVehicleEvaluation()
     {
          $reply['suggestions'] = $this->evaluation->autoComVehicleEvaluation($_GET['query']);
          echo json_encode($reply);
     }

     function pending()
     {
          // $data['vehicles'] = $this->evaluation->getEvaluation('', 0);
          $data['status'] = '0';
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }

     function checkVehicleExists()
     {
          $exists = $this->evaluation->checkVehicleExists($_POST);
          if (empty($exists)) {
               echo json_encode(array('status' => 'success', 'msg' => ''));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => 'Vehicle already exists'));
          }
     }

     function deleteDocument($id)
     {
          $id = encryptor($id, 'D');
          if ($this->evaluation->deleteDocument($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Document successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete document"));
          }
     }

     function tmp_sold()
     {
          if (!empty($_POST)) {
               $this->evaluation->updateAsSold($_POST);
               redirect(__CLASS__ . '/tmp_sold');
          } else {
               $data['status'] = 1;
               $data['vehicles'] = $this->evaluation->getEvaluation('', 1);
               $this->render_page(strtolower(__CLASS__) . '/tmp_sold', $data);
          }
     }

     function autoComSE()
     {
          $reply['suggestions'] = $this->evaluation->autoComSE($_GET['query']);
          echo json_encode($reply);
     }

     function autoComCustomer()
     {
          $reply['suggestions'] = $this->evaluation->autoComCustomer($_GET['query']);
          echo json_encode($reply);
     }

     function uploadFile()
     {
          // debug($_GET);
          // debug($_FILES);
          $frame = isset($_GET['frame']) ? $_GET['frame'] : '';
          $this->load->library('upload');
          if (!empty($_FILES) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
               $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
               $fileName = $frame . '_' . rand() . '.' . $ext;
               $config['file_name'] = $fileName;
               $config['upload_path'] = '../rdms/assets/uploads/evaluation/vehicle';
               $config['allowed_types'] = 'jpg|jpeg|png|pdf|dox|docx';
               $this->upload->initialize($config);
               if ($this->upload->do_upload('file')) {
                    //$uploadData = $this->upload->data();
                    echo json_encode(array(
                         'frame' => 'frame_' . $frame,
                         'status' => 'success',
                         'file_name' => $fileName,
                         'msg' => 'Successfully image upload'
                    ));
               } else {
                    echo json_encode(array(
                         'frame' => 'frame_' . $frame,
                         'status' => 'fail',
                         'file_name' => '',
                         'msg' => 'Upload error occured'
                    ));
                    //debug($this->upload->display_errors());
               }
          }
     }

     function deleteValuationVehicleImage($id)
     {
          $id = encryptor($id, 'D');
          if ($this->evaluation->deleteValuationVehicleImage($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Evaluation vehicle image successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete the image"));
          }
     }

     function updateDocumentType($valDocId)
     {
          $valType = isset($_POST['value']) ? $_POST['value'] : 0;
          if ($this->evaluation->updateDocumentType($valDocId, $valType)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Evaluation document type successfully updated'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't change the evaluation document type"));
          }
     }

     function refurbisheReturn($id = 0)
     {
          if (!empty($_POST)) {
               $this->evaluation->refurbisheReturn($_POST);
               echo json_encode(array('status' => 'success', 'msg' => 'Row updated Successfully'));
          } else {
               $id = encryptor($id, 'D');
               $data['vehicles'] = $this->evaluation->getEvaluationForRefurbRetn($id);
               $data['vendors'] = $this->evaluation->getVendors();
               $data['expenceType'] = $this->evaluation->getExpenceType();
               $this->render_page(strtolower(__CLASS__) . '/refurbisheReturn', $data);
          }
     }

     function printevaluation($valid)
     {

          $this->load->model('registration/registration_model', 'registration');
          if (!is_numeric($valid)) {
               $valid = encryptor($valid, 'D');
          }
          $data['division'] = $this->divisions->getActiveData();
          $data['vehicles'] = $this->evaluation->getEvaluationPrint($valid);
          $data['brand'] = $this->enquiry->getBrands();
          $data['model'] = $this->enquiry->getModelByBrand($data['vehicles']['val_brand']);
          $data['variant'] = $this->enquiry->getVariantByModel($data['vehicles']['val_model']);
          $data['banks'] = $this->evaluation->getAllBanks();
          $data['insurers'] = $this->evaluation->getInsurers();
          $data['managers'] = $this->evaluation->getAllManagers();
          $data['evaluators'] = $this->evaluation->getAllEvaluators();

          //$data['salesExe'] = $this->emp_details->salesExecutivesOnly();
          $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
          $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
          $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();
          $data['showroom'] = $this->registration->getShowRoomByDivision($data['vehicles']['val_division']);
          $data['dochistry'] = $this->evaluation->getDochistry($valid);
          $prchsChkData = $this->evaluation->getPrchsChkMstrID($valid);
          $data['stk_added_date'] = isset($prchsChkData['pcl_created_at']) ? $prchsChkData['pcl_created_at'] : '';
          if (isset($prchsChkData['pcl_check_list_id'])) {
               $chk_data['result'] = $this->evaluation->getPurchase_check_list($prchsChkData['pcl_check_list_id']);
               $chk_data['purchase_type'] = $data['vehicles']['val_type'];
               $data['prchs_chk_list_vw'] = $this->load->view('purchase_check_list_print_tab', $chk_data, true);
          } else {
               $data_pcl['resultChk'] = $this->evaluation->getCheck_listItemsByCategory(1);
               $data_pcl['evaluation_details'] = $this->evaluation->getEvaluationDetails($valid);
               $data_pcl['resultChk'] = $this->evaluation->getCheck_listItemsByCategory(1);
               $data_pcl['val_id'] = $valid;
               $data_pcl['controller'] = 'evaluation';
               $data['prchs_chk_list_vw'] = $this->load->view('purchase_check_list_form_tab', $data_pcl, true); //create
          }

          //$data['refurbDetails'] = $this->evaluation->getRefurbDetails($valid);
          $data['getRefurbMaster'] = $this->evaluation->getRefurbMaster($valid);
          $this->render_page(strtolower(__CLASS__) . '/printevaluation', $data);
     }
     function createInvoice($valid)
     {
          $data['valDetails'] = $this->evaluation->getEvaluationDetails($valid);
          $data['vehicles'] = $this->evaluation->getEvaluationForRefurbRetn($valid);
          $data['vendors'] = $this->evaluation->getVendors();
          $data['expenceType'] = $this->evaluation->getExpenceType();
          $this->render_page(strtolower(__CLASS__) . '/createInvoice', $data);
     }
     public function get_all_records()
     {
          $query = $this->db->get('cpnl_valuation_upgrade_details');
          $res = $query->result();
          debug($res);
     }

     function printevaluation1($valid)
     {
          $this->load->model('registration/registration_model', 'registration');
          if (!is_numeric($valid)) {
               $valid = encryptor($valid, 'D');
          }
          $data['division'] = $this->divisions->getActiveData();
          $data['vehicles'] = $this->evaluation->getEvaluationPrint($valid);
          $data['brand'] = $this->enquiry->getBrands();
          $data['model'] = $this->enquiry->getModelByBrand($data['vehicles']['val_brand']);
          $data['variant'] = $this->enquiry->getVariantByModel($data['vehicles']['val_model']);
          $data['banks'] = $this->evaluation->getAllBanks();
          $data['insurers'] = $this->evaluation->getInsurers();
          $data['managers'] = $this->evaluation->getAllManagers();
          $data['evaluators'] = $this->evaluation->getAllEvaluators();
          $data['salesExe'] = $this->emp_details->salesExecutivesOnly();
          $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
          $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
          $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();
          $data['showroom'] = $this->registration->getShowRoomByDivision($data['vehicles']['val_division']);

          $this->render_page(strtolower(__CLASS__) . '/printevaluation_1', $data);
     }

     function newvehiclefature()
     {
          $return = $this->evaluation->newvehiclefature($this->input->post());
          echo json_encode($return);
     }

     function getaddeddate()
     {
          echo json_encode(date('d-m-Y', strtotime("+" . $_POST['nextServiceDays'] . " days")));
     }

     function printevaluation_blank()
     {
          $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
          $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
          $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();
          $this->render_page(strtolower(__CLASS__) . '/printevaluation_blank', $data);
     }

     //////// jsk
     public function purchase_check_list($category_id = '', $eval_id = '')
     {
          if ($category_id == 1 && $eval_id) {
               //$category_id==1 Allows only Purchase Agreement Docket category 
               $data['result'] = $this->evaluation->getCheck_listItemsByCategory($category_id);
               $data['evaluation_details'] = $this->evaluation->getEvaluationDetails($eval_id);
               $data['val_id'] = $eval_id;
               if (!empty($data['evaluation_details'])) {
                    $this->render_page(strtolower(__CLASS__) . '/purchase_check_list_form', $data);
               } else {
                    die('Error: No data found');
               }
          } else {
               die('Error');
          }
     }

     public function add_purchase_check_list()
     {
          generate_log(array(
               'log_title' => 'Add purchase check list details pre insert',
               'log_desc' => serialize($_POST),
               'log_controller' => 'add-purchase-check-details-pre-insert',
               'log_action' => 'C',
               'log_ref_id' => 202020,
               'log_added_by' => $this->uid
          ));
          if (isset($_POST['item']) && !empty($_POST['item'])) {
               $id = $this->evaluation->insertPurchaseCheckListMaster(
                    array(
                         'pcl_val_id' => $_POST['val_id'],
                         'pcl_var_id' => $_POST['var_id'],
                         'pcl_brd_id' => $_POST['brd_id'],
                         'pcl_mod_id' => $_POST['mod_id'],
                         'pcl_vehicle_reg_no' => $_POST['vehicle_reg_no'],
                         'pcl_chasis_number' => $_POST['chasis_number'],
                         'pcl_team_lead_id' => $_POST['team_lead_id'],
                         'pcl_description' => $_POST['description'],
                         'pcl_created_at' => date('Y-m-d H:i:s'),
                         'pcl_added_by' => $this->uid,
                         'val_stock_num' => $_POST['val_stock_num']
                    )
               );
               if ($id) {
                    foreach ($_POST['item'] as $key => $value) {
                         $this->evaluation->insertPurchaseCheckDetails(
                              array(
                                   'pcld_check_list_master_id' => $id,
                                   'pcld_check_list_item_id' => $key,
                                   'pcld_check_list_item_value' =>  $value['yn'],
                                   'pcld_remarks' => $value['desc']
                              )
                         );
                    }
                    die(json_encode(array("status" => "success", "message" => "Data submited successfully", "check_listMasterId" => $id)));
               } else {
                    die(json_encode(array("status" => "error", "message" => "Sorry Something went wrong")));
               }
          }
     }

     public function update_purchase_check_list()
     {
          generate_log(array(
               'log_title' => 'Updated purchase check list details pre insert',
               'log_desc' => serialize($_POST),
               'log_controller' => 'updated-purchase-check-details-pre-insert',
               'log_action' => 'C',
               'log_ref_id' => 101010,
               'log_added_by' => $this->uid
          ));

          if (isset($_POST['item']) && !empty($_POST['item'])) {
               foreach ($_POST['item'] as $key => $value) {
                    $res = $this->evaluation->updtPurchaseCheckDetails(
                         array(
                              'pcld_check_list_item_id' => $key,
                              'pcld_check_list_item_value' =>  $value['yn'],
                              'pcld_remarks' => $value['desc']
                         ),
                         $value['ChkDtl_id']
                    );
               }
               if ($res == 1) {
                    die(json_encode(array("status" => "success", "message" => "Data Updated successfully")));
               }
          } else {
               die(json_encode(array("status" => "error", "message" => "Sorry Something went wrong")));
          }
     }

     public function purchase_check_list_print($masterId = '')
     {
          if ($masterId) {
               $data['result'] = $this->evaluation->getPurchase_check_list($masterId);
               $this->render_page(strtolower(__CLASS__) . '/purchase_check_list_print', $data);
          } else {
               die('Error');
          }
     }

     public function edit_purchase_check_list($category_id = '', $eval_id = '', $check_list_mstrId = '')
     {
          if ($category_id == 1 && $eval_id && $check_list_mstrId) {
               //$category_id==1 Allows only Purchase Agreement Docket category 
               $data['result'] = $this->evaluation->getCheck_listItemsByCategory($category_id);
               $data['evaluation_details'] = $this->evaluation->getEvaluationDetails($eval_id);
               $data['val_id'] = $eval_id;
               $data['chkLstMstrId'] = $check_list_mstrId;
               if (!empty($data['evaluation_details'])) {
                    $this->render_page(strtolower(__CLASS__) . '/edit_purchase_check_list_form', $data);
               } else {
                    die('Error: No data found');
               }
          } else {
               die('Error');
          }
     }
     ////////// @jsk

     function xlsx_valuation()
     {
          $evaluaionData = $this->evaluation->evaluation_ajax(array(), $this->input->get());
          $evaluaionData = $evaluaionData['aaData'];

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

          if (check_permission('evaluation', 'showrefurbcostndndexportexcel')) {
               $heading = array(
                    'Customer Status',
                    'Reg Number',
                    'Added by',
                    'Evaluated by',
                    'Showroom',
                    'Brand',
                    'Model',
                    'Variant',
                    'Evaluated on',
                    'Created on',
                    'Procurement staff',
                    'Est. refurb cost',
                    'Act. refurb cost',
                    'Evaluation status',
                    'Enq date',
                    'Enq Number',
                    'Cust Name',
                    'Phone',
                    'Stock No.',
                    'Mod of contact'
               );
          } else {
               $heading = array(
                    'Customer Status',
                    'Reg Number',
                    'Added by',
                    'Evaluated by',
                    'Showroom',
                    'Brand',
                    'Model',
                    'Variant',
                    'Evaluated on',
                    'Created on',
                    'Procurement staff',
                    'Evaluation status',
                    'Enq date',
                    'Enq Number',
                    'Cust Name',
                    'Phone',
                    'Stock No.',
                    'Mod of contact'
               );
          }

          $enqStatus = unserialize(FOLLOW_UP_STATUS);

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
          if (!empty($evaluaionData)) {
               foreach ($evaluaionData as $key => $value) {
                    $valStst = "";
                    if ($value['val_status'] == "0") {
                         $valStst = "Pending";
                    } else if ($value['val_status'] == vehicle_evaluated) {
                         $valStst = "Valuation completed";
                    } else if ($value['val_status'] == add_stock) {
                         $valStst = "Stock created";
                    }

                    $cntMod = isset($cntMods[$value['enq_mode_enq']]) ? $cntMods[$value['enq_mode_enq']] : '';
                    if (check_permission('evaluation', 'showrefurbcostndndexportexcel')) {
                         $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, isset($enqStatus[$value['enq_cus_when_buy']]) ? $enqStatus[$value['enq_cus_when_buy']] : '');
                         $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['val_veh_no']);
                         $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['usr_username']);
                         $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['evtr_usr_username']);
                         $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['shr_location']);
                         $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['brd_title']);
                         $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['mod_title']);
                         $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['var_variant_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['val_valuation_date']);
                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['val_added_date']);
                         $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['so_usr_username']);
                         $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value['val_refurb_cost']);
                         $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['val_refurb_act_cost']);
                         $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $valStst);
                         $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['enq_entry_date']);
                         $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['enq_number']);
                         $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['enq_cus_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $value['enq_cus_mobile']);
                         $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value['val_stock_num']);
                         $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $cntMod);
                    } else {
                         $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, isset($enqStatus[$value['enq_cus_when_buy']]) ? $enqStatus[$value['enq_cus_when_buy']] : '');
                         $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['val_veh_no']);
                         $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['usr_username']);
                         $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['evtr_usr_username']);
                         $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['shr_location']);
                         $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['brd_title']);
                         $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['mod_title']);
                         $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['var_variant_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value['val_valuation_date']);
                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value['val_added_date']);
                         $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value['so_usr_username']);
                         $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $valStst);
                         $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value['enq_entry_date']);
                         $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value['enq_number']);
                         $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value['enq_cus_name']);
                         $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value['enq_cus_mobile']);
                         $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $value['val_stock_num']);
                         $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $cntMod);
                    }
                    $row++;
                    $no++;
               }
          }
          //Save as an Excel BIFF (xls) file
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          //header('Content-Type: application/vnd.ms-excel');
          //header('Content-Disposition: attachment;filename="rdportal-myregister-report.xls"');
          //header('Cache-Control: max-age=0');
          //$objWriter->save('php://output');
          $objWriter->save('../rdms/assets/uploads/rdportal-valuation-report.xls');
          die(json_encode('../assets/uploads/rdportal-valuation-report.xls'));
     }

     function forcedelete($id)
     {
          $id = encryptor($id, 'D');
          if ($this->evaluation->forceDelete($id)) {
               echo 'Row successfully delated';
          } else {
               echo 'Error occured';
          }
          redirect(__CLASS__);
     }

     function updateDocumentDetals()
     {
          $newData['datas'] = $this->evaluation->updateDocumentDetals($_POST);
          $html = $this->load->view(strtolower(__CLASS__) . '/ajax_document_commecnt', $newData, true);
          echo json_encode(array('status' => 'success', 'msg' => $html));
     }

     function uploadvehicledocument()
     {
          $this->load->library('upload');
          foreach ($_FILES['documents']['name'] as $key => $value) {
               $newFileName = rand() . $_FILES['documents']['name'][$key];
               $config['upload_path'] = '../rdms/assets/uploads/evaluation/';
               $config['allowed_types'] = '*';
               $config['file_name'] = $newFileName;
               $this->upload->initialize($config);

               $_FILES['tmp_doc']['name'] = $_FILES['documents']['name'][$key];
               $_FILES['tmp_doc']['type'] = $_FILES['documents']['type'][$key];
               $_FILES['tmp_doc']['tmp_name'] = $_FILES['documents']['tmp_name'][$key];
               $_FILES['tmp_doc']['error'] = $_FILES['documents']['error'][$key];
               $_FILES['tmp_doc']['size'] = $_FILES['documents']['size'][$key];

               if ($this->upload->do_upload('tmp_doc')) {
                    $uploadData = $this->upload->data();
                    $complaint['comp_pic'] = $uploadData['file_name'];

                    if (isset($uploadData['file_name']) && !empty($uploadData['file_name'])) {
                         $docs['vdoc_val_id'] = $_POST['val_id'];
                         $docs['vdoc_doc'] = $uploadData['file_name'];
                         $docs['vdoc_doc_title'] = isset($_POST['document_title'][$key]) ? $_POST['document_title'][$key] : '';
                         $docs['vdoc_doc_type'] = isset($_POST['document_type'][$key]) ? $_POST['document_type'][$key] : '';
                         $this->evaluation->newEvaluationDocument($docs);
                    }
               } else {
                    $f = $this->upload->display_errors();
                    debug($f);
               }
          }
          redirect(__CLASS__ . '/printevaluation/' . $_POST['val_id']);
     }

     function chgevstatusmanualy()
     {
          parse_str($_POST['formData'], $statusData);
          $statusData['val_id'] = isset($statusData['val_id']) ? $statusData['val_id'] : 0;
          $statusData['val_cmd'] = isset($statusData['val_cmd']) ? $statusData['val_cmd'] : '';
          $statusData['val_status'] = isset($statusData['val_status']) ? $statusData['val_status'] : 0;

          if (empty($statusData['val_id'])) {
               die(json_encode(array('msg' => 'Valuation id is empty!')));
          }
          if (empty($statusData['val_status'])) {
               die(json_encode(array('msg' => 'Status is empty!')));
          }
          if (empty($statusData['val_cmd'])) {
               die(json_encode(array('msg' => 'Comment is empty!')));
          }
          if ($this->evaluation->changeEvaluationStatus($statusData)) {
               die(json_encode(array('msg' => 'Status successfully changed!')));
          }
     }
     function pushpurchase($valId)
     {
          $vehicleDetails = $this->evaluation->getVehicleForPush($valId);
          debug($vehicleDetails);
          $purchase = array(
               "brd_title" => (string) $value['G'],
               "mod_title" => (string) $value['H'],
               "vc_color" => (string) $value['B'],
               "val_model_year" => $value['C'],
               "val_engine_no" => (string) $value['D'],
               "val_chasis_no" => (string) $value['F'],
               "val_veh_no" => (string) $value['J'],
               "val_cust_name" => (string) $value['O'],
               "enq_cus_address" => (string) $value['P'] . ', ' . (string) $value['Q'],
               "enq_cus_ofc_address" => "unknown",
               "enq_cus_state" => (string) $value['R'],
               "enq_cus_dist" => (string) $value['S'],
               "val_refurb_cost" => $value['M'],
               "val_sales_officer_name" => "unknown",
               "enq_agreement_date" => $agrDate,
               "enh_booking_amt" => $value['K'],
               "enh_adv_amt" => 0,
               "enh_discount_amt" => 0,
               "val_type_title" => (string) $value['Z'],
               "val_showroom" => (string) $value['AA'],
               "enq_trans_mode" => "C",
               "val_stock_num" => (string) $refNum,
               "var_variant_name" => (string) $stock['var_variant_name'],
               "tcS_Amt" => 0,
               "stockID" => (string) $stockNum,
               "pr_enq_id" => 0,
               "pr_id" => 0,
               'pr_val_id' => $stock['val_id']
          );
          $this->ihits_api->ihitsSource($purchase);
     }
     public function model_check($value)
     { //form valuation
          if ($value === '0' || $value === null) {
               $this->form_validation->set_message('model_check', 'The %s field must not be equal to 0 or null.');
               return false;
          }
          return true;
     }
     function consolidatedInvoice($valId)
     {
          // $data['getRefurbMaster'] = $this->evaluation->getRefurbMaster($valId);
          //$data['vehicles'] = $this->evaluation->getEvaluationPrint($valId);
          $data['vehicles'] = $this->evaluation->getEvaluationPrint($valId);
          $data['refurbDetails'] = $this->evaluation->refurbDetails($valId);
          $data['getRefurbMaster'] = $this->evaluation->getRefurbMaster($valId);
          $this->render_page(strtolower(__CLASS__) . '/consolidatedinvoice', $data);
     }
}
