<?php

  defined('BASEPATH') or exit('No direct script access allowed');

  class evaluation_new extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->page_title = 'Valuation_new';
            $this->load->library('form_validation');
            $this->load->model('evaluation_model', 'evaluation');
            $this->load->model('enquiry_new/enquiry_model', 'enquiry');
            $this->load->model('showroom/showroom_model', 'showroom');
            $this->load->model('divisions/divisions_model', 'divisions');
            $this->load->model('emp_details/emp_details_model', 'emp_details');
            $this->load->model('registration_1/registration_model', 'registration');
       }

       function evaluation_ajax() {
            $response = $this->evaluation->evaluation_ajax($this->input->post(), $this->input->get());
            echo json_encode($response);
       }

       public function index() {//list of stock vehicles
            $data['brand'] = $this->enquiry->getBrands();
            $data['evaluators'] = $this->evaluation->getAllEvaluators();
            $data['division'] = $this->divisions->getActiveData();
            $data['colors'] = $this->evaluation->getColors();
            $data['RTO'] = $this->evaluation->getRTO();

            $this->render_page(strtolower(__CLASS__) . '/list_stock_vehicles', $data);
       }

       function view($id) {
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
            $data['evaluators'] = $this->evaluation->getAllEvaluators();
            $data['salesExe'] = $this->emp_details->salesExecutivesOnly();
            $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
            $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
            $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();
            $data['showroom'] = $this->registration->getShowRoomByDivision($data['vehicles']['val_division']);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       function add() {
            // debug($_POST);     
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
                                     //  $config['upload_path'] = '../assets/uploads/evaluation/';
                                     $config['upload_path'] = 'assets/uploads/evaluation/';
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
                                            'vfbc_chkup_master' => $key, 'vfbc_chkup_details' => $value
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
                                // $config['upload_path'] = '../assets/uploads/evaluation/';
                                $config['upload_path'] = 'assets/uploads/evaluation/';
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
                 $data['salesExe'] = $this->emp_details->salesExecutivesOnly();
                 $data['evaluators'] = $this->evaluation->getAllEvaluators();
                 $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
                 $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
                 $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       function update() {
            // debug($_POST);
            $this->load->library('upload');
            $id = 0;
            if (isset($_POST['val_id'])) {
                 $id = $_POST['val_id'];
            }
            generate_log(array(
                'log_title' => 'Evaluation pre update',
                'log_desc' => serialize($_POST),
                'log_controller' => 'evaluation-pre-update',
                'log_action' => 'U',
                'log_ref_id' => $id,
                'log_added_by' => get_logged_user('usr_id')
            ));
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
                                     //  $config['upload_path'] = '../assets/uploads/evaluation/';
                                     $config['upload_path'] = './assets/uploads/evaluation/';
                                     $config['allowed_types'] = 'jpg|jpeg|png';
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
                                //  $config['upload_path'] = '../assets/uploads/evaluation/';
                                $config['upload_path'] = './assets/uploads/evaluation/';
                                $config['allowed_types'] = 'jpg|jpeg|png|pdf|dox|docx';
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
                                            'vfbc_chkup_master' => $key, 'vfbc_chkup_details' => $value
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
            redirect(__CLASS__);
       }

       function deleteImage($id) {
            $id = encryptor($id, 'D');
            if ($this->evaluation->deleteImage($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete this row"));
            }
       }

       function delete($id) {
            $id = encryptor($id, 'D');
            if ($this->evaluation->delete($id)) {
                 $this->session->set_flashdata('app_success', 'Row successfully delated');
            } else {
                 $this->session->set_flashdata('app_success', 'Error occured');
            }
            redirect(__CLASS__);
       }

       function autoComVehicleEvaluation() {
            $reply['suggestions'] = $this->evaluation->autoComVehicleEvaluation($_GET['query']);
            echo json_encode($reply);
       }

       function pending() {//List evaluation pending vehicles 
            //status=0;
            ini_set('memory_limit', '-1');
            $data['vehicles'] = $this->evaluation->getEvaluation('', 0);
            $data['status'] = '0';
            $this->render_page(strtolower(__CLASS__) . '/list_pending_vehicles', $data);
       }

       function checkVehicleExists() {
            $exists = $this->evaluation->checkVehicleExists($_POST);
            if (empty($exists)) {
                 echo json_encode(array('status' => 'success', 'msg' => ''));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => 'Vehicle already exists'));
            }
       }

       function deleteDocument($id) {
            $id = encryptor($id, 'D');
            if ($this->evaluation->deleteDocument($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Document successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete document"));
            }
       }

       function tmp_sold() {
            if (!empty($_POST)) {
                 $this->evaluation->updateAsSold($_POST);
                 redirect(__CLASS__ . '/tmp_sold');
            } else {
                 $data['status'] = 1;
                 $data['vehicles'] = $this->evaluation->getEvaluation('', 1);
                 $this->render_page(strtolower(__CLASS__) . '/tmp_sold', $data);
            }
       }

       function autoComSE() {
            $reply['suggestions'] = $this->evaluation->autoComSE($_GET['query']);
            echo json_encode($reply);
       }

       function autoComCustomer() {
            $reply['suggestions'] = $this->evaluation->autoComCustomer($_GET['query']);
            echo json_encode($reply);
       }

       function uploadFile() {
            $frame = isset($_GET['frame']) ? $_GET['frame'] : '';
            $this->load->library('upload');
            if (!empty($_FILES) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                 //$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                 $ext = end(explode('.', $_FILES['file']['name']));
                 $fileName = $frame . '_' . rand() . '.' . $ext;
                 $config['file_name'] = $fileName;
                 $config['upload_path'] = '../assets/uploads/evaluation/vehicle';
                 $config['allowed_types'] = 'jpg|jpeg|png|pdf|dox|docx';
                 $this->upload->initialize($config);
                 if ($this->upload->do_upload('file')) {
                      //$uploadData = $this->upload->data();
                      echo json_encode(array(
                          'frame' => 'frame_' . $frame, 'status' => 'success',
                          'file_name' => $fileName, 'msg' => 'Successfully image upload'
                      ));
                 } else {
                      echo json_encode(array(
                          'frame' => 'frame_' . $frame, 'status' => 'fail',
                          'file_name' => '', 'msg' => 'Upload error occured'
                      ));
                 }
            }
       }

       function deleteValuationVehicleImage($id) {
            $id = encryptor($id, 'D');
            if ($this->evaluation->deleteValuationVehicleImage($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Evaluation vehicle image successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete the image"));
            }
       }

       function updateDocumentType($valDocId) {
            $valType = isset($_POST['value']) ? $_POST['value'] : 0;
            if ($this->evaluation->updateDocumentType($valDocId, $valType)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Evaluation document type successfully updated'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't change the evaluation document type"));
            }
       }

       function refurbisheReturn($id = 0) {
            if (!empty($_POST)) {
                 $this->evaluation->refurbisheReturn($_POST);
                 echo json_encode(array("status" => "success", "message" => "Updated successfully"));
            } else {
                 $id = encryptor($id, 'D');
                 //$data['vehicles'] = $this->evaluation->getEvaluation($id);
                 $data['vehicles'] = $this->evaluation->getEvaluationForRefurbRetn($id);
                 $this->render_page(strtolower(__CLASS__) . '/refurbisheReturn', $data);
            }
       }

       function preview($valid) {
            $this->render_page(strtolower(__CLASS__) . '/preview');
       }

       function printevaluation($valid) {
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
            $prchsChkData = $this->evaluation->getPrchsChkMstrID($valid);
            $data['stk_added_date'] = @$prchsChkData['pcl_created_at'];
            if (isset($prchsChkData['pcl_check_list_id'])) {
                 $data['prchsChkData'] = $chk_data['result'] = $this->evaluation->getPurchase_check_list($prchsChkData['pcl_check_list_id']);
                 $chk_data['purchase_type'] = $data['vehicles']['val_type'];
                 $data['prchs_chk_list_vw'] = $this->load->view('purchase_check_list_print_tab', $chk_data, true);
            } else {
                 $data_pcl['resultChk'] = $this->evaluation->getCheck_listItemsByCategory(1);
                 $data_pcl['evaluation_details'] = $this->evaluation->getEvaluationDetails($valid);
                 $data_pcl['val_id'] = $valid;
                 $data_pcl['controller'] = 'evaluation';
                 $data['prchs_chk_list_vw'] = $this->load->view('purchase_check_list_form_tab', $data_pcl, true); //create
            }
            $data['refurbDetails'] = $this->evaluation->getRefurbDetails($valid);
            /* refurbisheReturn
              $id = encryptor($valid, 'D');
              $data_rfurb['vehicles'] = $this->evaluation->getEvaluationForRefurbRetn($id);
              $data_rfurb['controller'] = strtolower(__CLASS__);
              $data['refurbRtnForm'] = $this->load->view('refurbisheReturn_tab', $data_rfurb, true);
              @end refurbisheReturn
              refurbishment Reqst
              $chk_data['result'] = $this->evaluation->getPurchase_check_list(@$prchsChkData['pcl_check_list_id']);
              debug( $data['result'], 0);
              $data['refurbReqPrint_vw'] = $this->load->view('refurbishment_reqst_print_tab', $chk_data, true);
              @end refurbishment Request
              @endrefurbisheReturn */
            $data['enquiries'] = $this->enquiry->getLiveEnq();
            //debug($data['enquiries']);
            $this->render_page(strtolower(__CLASS__) . '/printevaluation', $data);
       }

       function newvehiclefature() {
            $return = $this->evaluation->newvehiclefature($this->input->post());
            echo json_encode($return);
       }

       // jsk
       public function purchase_check_list($category_id = '', $eval_id = '') {
            if ($category_id == 1 && $eval_id) {
                 //$category_id==1 Allows only Purchase Agreement Docket category 

                 $data['result'] = $this->evaluation->getCheck_listItemsByCategory($category_id);
                 $data['evaluation_details'] = $this->evaluation->getEvaluationDetails($eval_id);
                 $data['val_id'] = $eval_id;
                 //debug( $data['evaluation_details']);
                 if (!empty($data['evaluation_details'])) {
                      $this->render_page(strtolower(__CLASS__) . '/purchase_check_list_form', $data);
                 } else {
                      die('Error: No data found');
                 }
            } else {
                 die('Error ');
            }
       }

       public function add_purchase_check_list() {
            //JSK
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
                             'pcl_added_by' => $this->uid
                         )
                 );
                 if ($id) {
                      foreach ($_POST['item'] as $key => $value) {
                           isset($value['yn']) ? $yn = 1 : $yn = 0; // check box is cheked or not
                           $this->evaluation->insertPurchaseCheckDetails(
                                   array(
                                       'pcld_check_list_master_id' => $id,
                                       'pcld_check_list_item_id' => $key, 'pcld_check_list_item_value' => $yn, 'pcld_remarks' => $value['desc']
                                   )
                           );
                      }
                      echo json_encode(array("status" => "success", "message" => "Data submited successfully", "check_listMasterId" => $id));
                 } else {
                      echo json_encode(array("status" => "error", "message" => "Sorry Something went wrong"));
                      exit;
                 }
            }

            exit;
       }

       public function update_purchase_check_list() {
            if (isset($_POST['item']) && !empty($_POST['item'])) {
                 foreach ($_POST['item'] as $key => $value) {
                      isset($value['yn']) ? $yn = 1 : $yn = 0; // check box is cheked or not
                      $res = $this->evaluation->updtPurchaseCheckDetails(
                              array(
                                  'pcld_check_list_item_id' => $key, 'pcld_check_list_item_value' => $yn, 'pcld_remarks' => $value['desc']
                              ),
                              $value['ChkDtl_id']
                      );
                 }
                 if ($res == 1) {
                      echo json_encode(array("status" => "success", "message" => "Data Updated successfully"));
                      exit;
                 }
            } else {
                 echo json_encode(array("status" => "error", "message" => "Sorry Something went wrong"));
            }
            exit;
       }

       public function purchase_check_list_print($masterId = '') {
            if ($masterId) {
                 $data['result'] = $this->evaluation->getPurchase_check_list($masterId);
                 $this->render_page(strtolower(__CLASS__) . '/purchase_check_list_print', $data);
            } else {
                 die('Error');
            }
       }

       public function edit_purchase_check_list($category_id = '', $eval_id = '', $check_list_mstrId = '') {
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

       function evaluated() {//List evaluated vehicles 
            //status=12;
            $data['status'] = 12;
            $this->render_page(strtolower(__CLASS__) . '/list_evaluated_vehicles', $data);
       }

       function re_evaluated($valId) {//List evaluated vehicles 
            if ($valId) {
                 $data['val_id'] = encryptor($valId, 'D');
                 $data['status'] = 1;
                 $this->render_page(strtolower(__CLASS__) . '/list_re_evaluated_vehicles', $data);
            } else {
                 die('Error');
            }
            //status=12;    
       }

       function reEvaluation($valid) {
            $this->load->model('registration/registration_model', 'registration');
            if (!is_numeric($valid)) {
                 $valid = encryptor($valid, 'D');
            }
            $is_revalutaion = 1;
            $data['division'] = $this->divisions->getActiveData();
            $data['vehicles'] = $this->evaluation->getEvaluationPrint($valid, 0, $is_revalutaion);
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
            $data['parent_id'] = $valid;
            // $data['fullBodyCheckupMaster_odd'] = $this->evaluation->getFullBodyCheckupMaster('odd');
            // $data['fullBodyCheckupMaster_even'] = $this->evaluation->getFullBodyCheckupMaster('even');
            $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();

            $data['showroom'] = $this->registration->getShowRoomByDivision($data['vehicles']['val_division']);
            $prchsChkData = $this->evaluation->getPrchsChkMstrID($valid);
            $data['stk_added_date'] = @$prchsChkData['pcl_created_at'];
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
            $data['refurbDetails'] = $this->evaluation->getRefurbDetails($valid);
            /* refurbisheReturn
              $id = encryptor($valid, 'D');
              $data_rfurb['vehicles'] = $this->evaluation->getEvaluationForRefurbRetn($id);
              $data_rfurb['controller'] = strtolower(__CLASS__);
              $data['refurbRtnForm'] = $this->load->view('refurbisheReturn_tab', $data_rfurb, true);
              @end refurbisheReturn
              refurbishment Reqst
              $chk_data['result'] = $this->evaluation->getPurchase_check_list(@$prchsChkData['pcl_check_list_id']);
              debug( $data['result'], 0);
              $data['refurbReqPrint_vw'] = $this->load->view('refurbishment_reqst_print_tab', $chk_data, true);
              @end refurbishment Request
              @endrefurbisheReturn */
            $this->render_page(strtolower(__CLASS__) . '/createReEvaluation', $data);
       }

       function create_re_evluation() {
            generate_log(array(
                'log_title' => 'Re Evaluation insert',
                'log_desc' => serialize($_POST),
                'log_controller' => 're-evaluation-insert',
                'log_action' => 'C',
                'log_ref_id' => 0,
                'log_added_by' => get_logged_user('usr_id')
            ));
            if (!empty($_POST)) {
                 $this->load->library('upload');
                 if ($evId = $this->evaluation->createReEvaluation($_POST['valuation'], encryptor($_POST['val_id'], 'D'), encryptor($_POST['val_enquiry_id']), 'D')) {
                      if (isset($_POST['complaint_title']) && !empty($_POST['complaint_title'])) {
                           foreach ($_POST['complaint_title'] as $key => $value) {
                                $complaint['comp_pic'] = '';
                                if (isset($_FILES['complaint_file']['name'][$key]) && !empty($_FILES['complaint_file']['name'][$key])) {
                                     $newFileName = rand() . $_FILES['complaint_file']['name'][$key];
                                     $config['upload_path'] = '../assets/uploads/evaluation/';
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
                                            'vfbc_chkup_master' => $key, 'vfbc_chkup_details' => $value
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
                                $config['upload_path'] = '../assets/uploads/evaluation/';
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
                 $data['salesExe'] = $this->emp_details->salesExecutivesOnly();
                 $data['evaluators'] = $this->evaluation->getAllEvaluators();
                 $data['vehicleFeatures'] = $this->evaluation->getAllVehicleFeatures();
                 $data['vehicleAddOnFeatures'] = $this->evaluation->getVehicleAddOnFeatures();
                 $data['fullBodyCheckupMaster'] = $this->evaluation->getFullBodyCheckupMaster();

                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       function re_evaluation_ajax() {
            $response = $this->evaluation->re_evaluation_ajax($this->input->post(), $this->input->get());
            echo json_encode($response);
       }

       function compare($valid) {
            if ($valid) {
                 $is_re_evaluation = 1;
                 $data = $this->evaluation->getEvalCompareTabs($valid, $is_re_evaluation);
                 $this->render_page(strtolower(__CLASS__) . '/compare_evaluation', $data);
            }
       }

       function getCompare() {

            $valid = $_GET['val_id'];
            $is_re_evaluation = 1;
            $data['vehicles'] = $this->evaluation->getEvaluationCompare($valid, $is_re_evaluation);
            $result = $this->load->view('compare_evaluation_ajax', $data);
            //echo $result;
            return json_encode($result);
       }

       public function OfferPrice($id) {//list of stock vehicles
            //$data['brand'] = $this->enquiry->getBrands();
            $data['offerPrices'] = $this->evaluation->getofferPrices($id);
            //debug($data);
            $this->render_page(strtolower(__CLASS__) . '/list_offer_price', $data);
       }

       public function add_offer_price() {
            if (!empty($_POST)) {
                 //debug($_POST);
                 if ($enquiryId = $this->evaluation->addOfferPrice($_POST)) {
                      echo json_encode(array('status' => 'success', 'msg' => 'Success'));
                 }
            }
       }

       //@jsk

       function xlsx_valuation() {
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
            $heading = array('Customer Status', 'Reg Number', 'Added by', 'Evaluated by', 'Showroom', 'Brand', 'Model',
                'Variant', 'Evaluated on', 'Created on');
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

            if (!empty($evaluaionData)) {
                 foreach ($evaluaionData as $key => $value) {
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

       function forceDelete($id) {
            $id = encryptor($id, 'D');
            if ($this->evaluation->forceDelete($id)) {
                 echo 'Row successfully delated';
            } else {
                 echo 'Error occured';
            }
            //redirect(__CLASS__);
       }

       function matchingInquiry() {
            $data['enq_data'] = $this->evaluation->getEnquiryByMobile($this->input->post('phoneNo'));
            //debug($data['enq_data']);
            $data['showroom'] = $this->showroom->get();
            $data['brand'] = $this->enquiry->getBrands();
            $data['banks'] = $this->evaluation->getAllBanks();
            $data['insurers'] = $this->evaluation->getInsurers();
            $data['division'] = $this->divisions->getActiveData();
            $data['managers'] = $this->evaluation->getAllManagers();
            $data['salesExe'] = $this->emp_details->salesExecutivesOnly();
            $data['evaluators'] = $this->evaluation->getAllEvaluators();
            $data['enq'] = '';
            $data['typed_phone'] = $this->input->post('phoneNo');
            if (!empty($data['enq_data']) AND @$data['enq_current_status'] != 3) {
                 //debug($data);
                 //debug('und');
                 $data['enq'] = 1;

                 $f_url = site_url(strtolower(__CLASS__) . '/update');
                 // $form='<form class="x_content frmNewValuation" id="frm_tag" data-url="'.$f_url.'">';
                 $enq_data = $this->load->view(strtolower(__CLASS__) . '/view_enq_data', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => '', 'enq_data' => $enq_data, 'update' => 1, 'form' => $f_url));
            } else {

                 // debug('illa');
                 $f_url = site_url(strtolower(__CLASS__) . '/add');
                 // $form='<form class="x_content frmNewValuation" id="frm_tag" data-url="'.$f_url.'">';
                 $enq_data = $this->load->view(strtolower(__CLASS__) . '/view_enq_data', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => '', 'enq_data' => $enq_data, 'update' => 0, 'form' => $f_url));
            }
       }

       function update_refurb_status() {
            //debug($_POST);
            if ($this->evaluation->updateRefstatus($_POST)) {
                 $message = 'successfully Added!';
                 echo json_encode($message);
                 //return json_encode(array('status' => 'success'));    
            }
       }

       //
       ////////
       //
       function refurb_reqsj($param = '') {
            //debug(21321);
            if ($this->input->is_ajax_request()) {
                 //debug( $this->input->post('showroom'));
                 $showroom = $this->input->post('showroom');
                 $month = $this->input->post('month');
                 $filterData = $this->input->post();
                 // debug($filterData);
                 // $stock_Count = $this->reports->stock_status_count(); //debug($stock_Count);
                 //   $total_Count = $this->reports->sales_data_bankCount($showroom, $month);
                 $total_Count = 10;
                 $this->load->library('pagination');
                 $config = array();
                 $config['base_url'] = site_url('evaluation/refurb_reqs');
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
                 $page = 1;
                 $page = $this->uri->segment(3);
                 // debug($page);
                 $start = ($page - 1) * $config['per_page']; //offset
                 //  debug(44);
                 //$data['enquiries'] = $this->reports->getEnquiriesForPooll($filterData, $config["per_page"], $start, $data['date_filter']);
                 // $data['sdb'] = $this->reports->sales_data_bank($config["per_page"], $start, $showroom, $month);
                 //  debug($data['sdb'] );
                 $data = '';
                 $filter_view = $this->load->view(strtolower(__CLASS__) . '/refurb_req_ajx_vw', $data, TRUE);
                 // debug($filter_view);
                 (!$filter_view) ? $filter_view = '&nbsp No data found..' : '';

                 // $booking_veh_view = $this->load->view(strtolower(__CLASS__) . '/sales_data_bank_ajax_view', $data, TRUE);
                 // (!$booking_veh_view) ? $booking_veh_view = '&nbsp No data found..' : '';

                 $output = array(
                     'pagination_link' => $this->pagination->create_links(),
                     'tableContent' => $filter_view,
                     //  'booking_veh_view' => $booking_veh_view,
                     'total_records_count' => $total_Count,
                     'uri_seg' => $page,
                 );
                 die(json_encode($output));
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/refurb_req_vw',);
                 //$data= $this->evaluation->refurbReqs();
            }
       }

       ////////////
       ////////////////

       function refurb_reqs() {
            if ($this->input->is_ajax_request()) {
                 // debug(3132);
                 $filterData = $this->input->post();
                 $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
                 $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
                 $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
                 $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
                 $data['formFilter'] = $filterData;
                $stock_Count = $this->evaluation->refurbReqsCount();
               // debug($stock_Count);
                 $stock_Count = $stock_Count;
                 $minimum_price = $this->input->post('minimum_price');
                 $maximum_price = $this->input->post('maximum_price');
                 $brand = $this->input->post('brand');
                 $ram = $this->input->post('ram');
                 $storage = $this->input->post('storage');
                 $this->load->library('pagination');
                 $config = array();
                 $config['base_url'] = site_url('evaluation/refurb_reqs');
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
                 $data['s']=0;
                 $j=$page* $config['per_page'];
                 $data['s']=$j-$config['per_page'];
                 //debug($page);
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
                 $shrm = 1;
                 $data['refurbs'] = $this->evaluation->refurbReqs($shrm, $config["per_page"], $start);
                 //debug( $data);
                 //debug($data['reports']);
                 $data['uriseg']=$page;
                 $filter_view = $this->load->view(strtolower(__CLASS__) . '/refurb_req_ajx_vw', $data, TRUE);
                 $output = array(
                     'pagination_link' => $this->pagination->create_links(),
                     'tableContent' => $filter_view,
                     'total_records_count' => $stock_Count,
                     'uri_seg' => $page,
                     'enq_dt_filtr' => $data['date_filter'],
                 );
                 die(json_encode($output));
            } else {

                 $data['brand'] = $this->enquiry->getBrands();
                 $this->render_page(strtolower(__CLASS__) . '/refurb_req_vw', $data);
            }
       }

       //////////
       function open_refurb_req_model($id) {
            if ($this->input->is_ajax_request() && $id) {
                 //  debug($id);
                 $id = encryptor($id, 'D');

                 $data['refurbs'] = $this->evaluation->refurbReqsModel($id);
                 // debug($data);
                 $html = $this->load->view(strtolower(__CLASS__) . '/refurb_req_model_ajx', $data, true);
                 echo json_encode(array('status' => 'success', 'msg' => $html, 'approved' => !empty($data['approval']) ? '1' : null));

                 // $data['refurbs'] = $this->evaluation->refurbReqs($id);    
            }
       }

       function update_refurb_req_approval() {
                        $is_approved = $this->input->post('status');
            $upgrd_id = $this->input->post('job_id');
         $remarks=$this->input->post('remarks');
           // debug($upgrd_id);
             $dataa['refurbs'] = $this->evaluation->updateRefurbJobApproval($is_approved,$upgrd_id,$remarks);
             echo json_encode(array('status' => 'success', 'msg' => 'Job approval updated', 'jobId' => $upgrd_id, 'is_approved' => $is_approved));
            
       }
       
       ///neww////
       function approved_refurb_reqs() {
            if ($this->input->is_ajax_request()) {
                // debug(3132);
                 $filterData = $this->input->post();
                 $data['date_filter']['sales_date_from'] = $this->input->post('sales_date_from');
                 $data['date_filter']['sales_date_to'] = $this->input->post('sales_date_to');
                 $data['date_filter']['purchase_date_from'] = $this->input->post('purchase_date_from');
                 $data['date_filter']['purchase_date_to'] = $this->input->post('purchase_date_to');
                 $data['formFilter'] = $filterData;
                $stock_Count = $this->evaluation->refurbReqsCount();
               // debug($stock_Count);
                 $stock_Count = $stock_Count;
                 $minimum_price = $this->input->post('minimum_price');
                 $maximum_price = $this->input->post('maximum_price');
                 $brand = $this->input->post('brand');
                 $ram = $this->input->post('ram');
                 $storage = $this->input->post('storage');
                 $this->load->library('pagination');
                 $config = array();
                 $config['base_url'] = site_url('evaluation/approved_refurb_reqs');
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
                 $data['s']=0;
                 $j=$page* $config['per_page'];
                 $data['s']=$j-$config['per_page'];
                 //debug($page);
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
                 $shrm = 1;
                 $data['refurbs'] = $this->evaluation->approvedRefurbReqs($shrm, $config["per_page"], $start);
                 //debug( $data);
                 //debug($data['reports']);
                 $data['uriseg']=$page;
                 $filter_view = $this->load->view(strtolower(__CLASS__) . '/approved_refurb_req_ajx_vw', $data, TRUE);
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
       
       public function update_refurb_job_by_staff() {
            $job_id = $this->input->post('job_id');
              $num_of_days = $this->input->post('num_of_days');
                $service_given_date = $this->input->post('service_given_date');
                  $service_location = $this->input->post('service_location');
           //debug($service_location);
        $dataa['refurbs'] = $this->evaluation->updateRefurbJobByStaff($job_id,$num_of_days,$service_given_date,$service_location);
             echo json_encode(array('status' => 'success', 'msg' => 'Job updated'));      
       }
       
       /////@newww////

  }

?>