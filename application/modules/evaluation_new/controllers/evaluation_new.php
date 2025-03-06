<?php

defined('BASEPATH') or exit('No direct script access allowed');

class evaluation_new extends App_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'Valuation';
          $this->load->library('form_validation');
          $this->load->model('evaluation_model', 'evaluation');
          // $this->load->model('enquiry_new/enquiry_model', 'enquiry');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          // $this->load->model('registration_1/registration_model', 'registration');
          $this->load->model('registration/registration_model', 'registration');
     }

     function evaluation_ajax()
     {
          // debug($this->input->post(),1);
          // debug($this->input->get(),1);
          // $this->input->post(); //['order'][0]['dir']
          $response = $this->evaluation->evaluation_ajax($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     public function index()
     { //list of stock vehicles
          $data['brand'] = $this->enquiry->getBrands();
          $data['evaluators'] = $this->evaluation->getAllEvaluators();
          $data['division'] = $this->divisions->getActiveData();
          $data['colors'] = $this->evaluation->getColors();
          $data['RTO'] = $this->evaluation->getRTO();
          $this->render_page(strtolower(__CLASS__) . '/list_stock_vehicles', $data);
     }

     function view($id)
     {
          //  debug(12123);
          // $this->load->model('registration_1/registration_model', 'registration');
          
          $this->load->model('registration/registration_model', 'registration');
          if (!is_numeric($id)) {
               $id = encryptor($id, 'D');
          }
          $data['division'] = $this->divisions->getActiveData();
          $data['vehicles'] = $this->evaluation->getEvaluation($id);
          //echo json_encode(array('documents' => $data['vehicles']['documents'])); 
         // print_r($data['vehicles']);
        // echo json_encode(array('upgradeDetails' => $data['vehicles']['upgradeDetails']));
         // exit;
         // debug( $data['vehicles']);
        // echo json_encode(array('valVehImages' => $data['vehicles']['valVehImages'])); 
        //  print_r($data['vehicles']);
      //  echo json_encode(array('features' => $data['vehicles']['features'])); 
      // exit;
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
          $data['rdStaffs'] = $this->registration->bindAllRdStaffs();
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
               //debug($_POST);     
              // exit;
               $this->load->library('upload');
               //if (!$this->evaluation->checkVehicleExists($_POST)) {
               if ($evId = $this->evaluation->newEvaluation($_POST['valuation'])) {
                    if (isset($_POST['complaint_title']) && !empty($_POST['complaint_title'])) {
                         foreach ($_POST['complaint_title'] as $key => $value) {
                              $complaint['comp_pic'] = '';
                              if (isset($_FILES['complaint_file']['name'][$key]) && !empty($_FILES['complaint_file']['name'][$key])) {
                                   $newFileName = rand() . $_FILES['complaint_file']['name'][$key];
                                   //  $config['upload_path'] = '../assets/uploads/evaluation/';
                                   $config['upload_path'] = 'assets/uploads/evaluation/'; //evaluation_new?
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
               //new
               $data['APMASM'] = $this->evaluation->getAllAPMASM();
               $data['telprsco'] = $this->evaluation->getTelePurchaseCoordinator();
               $data['mis'] = $this->evaluation->getMISEvaluation();
               $data['delco'] = $this->evaluation->getDelco();
               $data['teleclrs'] = $this->evaluation->getTelecaller();
               $data['telslsco'] = $this->evaluation->getTelesalesCoordinator();
               $data['admin'] = $this->evaluation->getStaffByGroup('usr_is_sales_admin');
               $data['purchaseAdmin'] = $this->evaluation->getStaffByGroup('usr_is_purchase_admin');
               //EndNew
               $this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     function update()
     {
//debug($_FILES);exit;
          //debug($_POST,1); exit;
          //           foreach($_POST['valuation'] as $k=>$vals ){
          // echo $val='valuation['.$k.']:'.$vals.' <br>';

          //           }
          // foreach($_POST['features'] as $k=>$vals ){
          //      echo $val='features['.$k.']:'.$vals.' <br>';

          //                }
          //                foreach($_POST['fulbdchk'] as $k=>$vals ){
          //                     echo $val='fulbdchk['.$k.']:'.$vals.' <br>';

          //                               }

          // foreach($_POST['upgradedetails']['upgrd_key'] as $k=>$vals ){
          //      echo $val='upgradedetails[upgrd_key][]:'.$vals.' <br>';

          //                }
          //                foreach($_POST['upgradedetails']['upgrd_value'] as $k=>$vals ){
          //                     echo $val='upgradedetails[upgrd_value][]:'.$vals.' <br>';

          //                               }
          foreach ($_POST['eveimg'] as $k => $vals) {
               echo $val = 'eveimg[' . $k . ']:' . $vals . ' <br>';
          }

          exit;

          //debug($_POST['upgradedetails'],1);
          if ($_POST['valuation']['val_refferal_type'] == 4) { //Rd staff
               // unset($_POST['referal_name1']);
               unset($_POST['referal_name3']);
               unset($_POST['referal_phone3']);
               unset($_POST['referal_phone2']);
               unset($_POST['referal_name2']);
               $_POST['val_refferer_name'] = $_POST['referal_name1'];
               unset($_POST['referal_name1']);
               $_POST['val_refferal_phone'] = $_POST['referal_phone1'];
               unset($_POST['referal_phone1']);
               $_POST['val_refferal_type'] = $_POST['valuation']['val_refferal_type'];
               unset($_POST['valuation']['val_refferal_type']);
               // unset($_POST['referal_enq_cus_id']);
          } elseif ($_POST['valuation']['val_refferal_type'] == 5) { //RD Customer
               unset($_POST['referal_name1']);
               unset($_POST['referal_phone1']);
               unset($_POST['referal_name3']);
               unset($_POST['referal_phone3']);
               $_POST['val_refferal_phone'] = $_POST['referal_phone2'];
               unset($_POST['referal_phone2']);
               $_POST['val_refferer_name'] = $_POST['referal_name2'];
               unset($_POST['referal_name2']);
               $_POST['val_refferal_type'] = $_POST['valuation']['val_refferal_type'];
               unset($_POST['valuation']['val_refferal_type']);
               //   $_POST['vreg_referal_enq_id'] = $_POST['referal_enq_cus_id'];
               // unset($_POST['referal_enq_cus_id']);
          } else {
               unset($_POST['referal_name1']);
               unset($_POST['referal_phone1']);
               unset($_POST['referal_phone2']);
               unset($_POST['referal_name2']);
               $_POST['val_refferal_phone'] = $_POST['referal_phone3'];
               unset($_POST['referal_phone3']);
               $_POST['val_refferer_name'] = $_POST['referal_name3'];
               unset($_POST['referal_name3']);
               $_POST['val_refferal_type'] = $_POST['valuation']['val_refferal_type'];
               unset($_POST['valuation']['val_refferal_type']);
               // unset($_POST['referal_enq_cus_id']);
          }
          // debug($_POST['val_refferal_phone'],1);
          // debug($_POST['valuation']['val_refferal_type'],1);
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
               if (isset($_POST['upgradedetails']) && !empty($_POST['upgradedetails'])) {
                    $_POST['valuation']['val_refurb_status'] = 66;
                    //debug($_POST['val_refurb_status'],1);
               }
               // debug($_POST['valuation'],1);
               //if (!$this->evaluation->checkVehicleExists($_POST)) {
               if ($this->evaluation->updateEvaluation($id, $_POST['valuation'])) {
                    echo 'updateEvaluation <br>';
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
                              echo 'complaint_title <br>';
                         }
                         $this->session->set_flashdata('app_success', 'Row successfully updated!');
                    }

                    //Upload documents
                    if ((isset($_FILES['documents']['name']) && !empty($_FILES['documents']['name']) &&
                         is_array($_FILES['documents']['name'])) && (isset($_FILES['documents']['name'][0]) && !empty($_FILES['documents']['name'][0]))) {
                         foreach ($_FILES['documents']['name'] as $key => $value) {
                              $newFileName = rand() . $_FILES['documents']['name'][$key];
                              //  $config['upload_path'] = '../assets/uploads/evaluation/';
                              $config['upload_path'] = '../assets/uploads/evaluation/';
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
                                   echo 'do_upload <br>';
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
                         echo 'newFeatures <br>';
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
                         echo 'Body chkp <br>';
                    }
                    //Upgradation details
                    if (isset($_POST['upgradedetails']) && !empty($_POST['upgradedetails'])) {
                         $this->evaluation->removeUpgradeDetailsByMaster($id);
                         $this->evaluation->upgradeDetails($_POST['upgradedetails'], $id);
                         echo 'upgrd dtls-- <br>';
                    }

                    //Upload images
                    if (isset($_POST['eveimg']) && !empty($_POST['eveimg'])) {
                         foreach ($_POST['eveimg'] as $key => $value) {
                              if (!empty($value)) {
                                   $frame = explode('_', $value);
                                   $frame = isset($frame['0']) ? $frame['0'] : 0;
                                   $this->evaluation->uploadEvaluationVehicleImages(array('vvi_val_id' => $id, 'vvi_frame_id' => $frame, 'vvi_image' => $value));
                                   echo 'uploadEvaluationVehicleImages <br>';
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
     { //List evaluation pending vehicles 
          //status=0;
          ini_set('memory_limit', '-1');
          $data['vehicles'] = $this->evaluation->getEvaluation('', 0);
          //debug($data);
          $data['status'] = '0';
          //debug($data);
          $this->render_page(strtolower(__CLASS__) . '/list_pending_vehicles', $data);
          //$this->render_page(strtolower(__CLASS__) . '/list', $data);
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
          debug($_POST);
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
               echo json_encode(array("status" => "success", "message" => "Updated successfully"));
          } else {
               $id = encryptor($id, 'D');
               //$data['vehicles'] = $this->evaluation->getEvaluation($id);
               $data['vehicles'] = $this->evaluation->getEvaluationForRefurbRetn($id);
               $this->render_page(strtolower(__CLASS__) . '/refurbisheReturn', $data);
          }
     }

     function preview($valid)
     {
          $this->render_page(strtolower(__CLASS__) . '/preview');
     }

     function printevaluation($valid)
     {
          $this->load->model('registration_1/registration_model', 'registration');
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
               $data_pcl['controller'] = 'evaluation_new';
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

     function newvehiclefature()
     {
          $return = $this->evaluation->newvehiclefature($this->input->post());
          echo json_encode($return);
     }

     // jsk
     public function purchase_check_list($category_id = '', $eval_id = '')
     {
          if ($category_id == 1 && $eval_id) {
               //$category_id==1 Allows only Purchase Agreement Docket category 

               $data['result'] = $this->evaluation->getCheck_listItemsByCategory($category_id);
               $data['evaluation_details'] = $this->evaluation->getEvaluationDetails($eval_id);
               $data['val_id'] = $eval_id;
               //debug($data['evaluation_details']);
               if (!empty($data['evaluation_details'])) {
                    $this->render_page(strtolower(__CLASS__) . '/purchase_check_list_form', $data);
               } else {
                    die('Error: No data found');
               }
          } else {
               die('Error ');
          }
     }

     public function add_purchase_check_list()
     {          //JSK 
          //  debug($_POST['val_id']);
          // debug($_POST['var_id'],1);
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

     public function update_purchase_check_list()
     {
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

     function evaluated()
     { //List evaluated vehicles 
          //                       $sql="ALTER TABLE cpnl_valuation_upgrade_details_1
          // ADD COLUMN upgrd_service_location VARCHAR(255)";    
          //    $query = $this->db->query($sql);
          //    debug($query);
          //    exit;
          //status=12;
          $data['status'] = 12;
          $this->render_page(strtolower(__CLASS__) . '/list_evaluated_vehicles', $data);
     }

     function re_evaluated($valId)
     { //List evaluated vehicles 
          if ($valId) {
               $data['val_id'] = encryptor($valId, 'D');
               $data['status'] = 1;
               $this->render_page(strtolower(__CLASS__) . '/list_re_evaluated_vehicles', $data);
          } else {
               die('Error');
          }
          //status=12;    
     }

     function reEvaluation($valid)
     {
          $this->load->model('registration_1/registration_model', 'registration');
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

     function create_re_evluation()
     {
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

     function re_evaluation_ajax()
     {
          $response = $this->evaluation->re_evaluation_ajax($this->input->post(), $this->input->get());
          echo json_encode($response);
     }

     function compare($valid)
     {
          if ($valid) {
               $is_re_evaluation = 1;
               $data = $this->evaluation->getEvalCompareTabs($valid, $is_re_evaluation);
               $this->render_page(strtolower(__CLASS__) . '/compare_evaluation', $data);
          }
     }

     function getCompare()
     {

          $valid = $_GET['val_id'];
          $is_re_evaluation = 1;
          $data['vehicles'] = $this->evaluation->getEvaluationCompare($valid, $is_re_evaluation);
          $result = $this->load->view('compare_evaluation_ajax', $data);
          //echo $result;
          return json_encode($result);
     }

     public function OfferPrice($id)
     { //list of stock vehicles
          //$data['brand'] = $this->enquiry->getBrands();
          $data['offerPrices'] = $this->evaluation->getofferPrices($id);
          //debug($data);
          $this->render_page(strtolower(__CLASS__) . '/list_offer_price', $data);
     }

     public function add_offer_price()
     {
          if (!empty($_POST)) {
               //debug($_POST);
               if ($enquiryId = $this->evaluation->addOfferPrice($_POST)) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Success'));
               }
          }
     }

     //@jsk

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
          $heading = array(
               'Customer Status', 'Reg Number', 'Added by', 'Evaluated by', 'Showroom', 'Brand', 'Model',
               'Variant', 'Evaluated on', 'Created on'
          );
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

     function forceDelete($id)
     {
          $id = encryptor($id, 'D');
          if ($this->evaluation->forceDelete($id)) {
               echo 'Row successfully delated';
          } else {
               echo 'Error occured';
          }
          //redirect(__CLASS__);
     }

     function matchingInquiry()
     {
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
          if (!empty($data['enq_data']) and @$data['enq_current_status'] != 3) {
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

     function update_refurb_status()
     {
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
     function refurb_reqsj($param = '')
     {
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
               $config['base_url'] = site_url('evaluation_new/refurb_reqs');
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

     function refurb_reqs()
     {
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
               $config['base_url'] = site_url('evaluation_new/refurb_reqs');
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
               $data['s'] = 0;
               $j = $page * $config['per_page'];
               $data['s'] = $j - $config['per_page'];
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
               $data['uriseg'] = $page;
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
     function open_refurb_req_model($id)
     {
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

     function update_refurb_req_approval()
     {
          $is_approved = $this->input->post('status');
          $upgrd_id = $this->input->post('job_id');
          $remarks = $this->input->post('remarks');
          // debug($upgrd_id);
          $dataa['refurbs'] = $this->evaluation->updateRefurbJobApproval($is_approved, $upgrd_id, $remarks);
          echo json_encode(array('status' => 'success', 'msg' => 'Job approval updated', 'jobId' => $upgrd_id, 'is_approved' => $is_approved));
     }

     ///neww////
     function approved_refurb_reqs()
     {
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
               $config['base_url'] = site_url('evaluation_new/approved_refurb_reqs');
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
               $data['s'] = 0;
               $j = $page * $config['per_page'];
               $data['s'] = $j - $config['per_page'];
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
               $data['uriseg'] = $page;
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

     public function update_refurb_job_by_staff()
     {
          $job_id = $this->input->post('job_id');
          $num_of_days = $this->input->post('num_of_days');
          $service_given_date = $this->input->post('service_given_date');
          $service_location = $this->input->post('service_location');
          //debug($service_location);
          $dataa['refurbs'] = $this->evaluation->updateRefurbJobByStaff($job_id, $num_of_days, $service_given_date, $service_location);
          echo json_encode(array('status' => 'success', 'msg' => 'Job updated'));
     }
     public function exi_qry()
     {
         // $val= $this->db->where('val_id', 10030)->get('cpnl_valuation')->row_array();
     //    $val= $this->db->order_by('val_id','DESC')->limit(10)->get('cpnl_valuation')->result_array();
         //$this->db->order_by("prd_reg_id", "desc")->get('rana_products')->row_array();
       //  $val= $this->db->order_by('apt_id','DESC')->get('cpnl_apptest')->result_array();//apt_id
      // $app= $this->db->order_by("vreg_id", "desc")->get('cpnl_register_master')->row_array();
 // debug($app);
       $val= $this->db->where('apt_id',627)->get('cpnl_apptest')->row_array();
        $res= unserialize($val['apt_res']);
          debug($res);
        //  $foll= $this->db->where('foll_cus_id', 60084)->get('cpnl_followup')->row_array();
//debug($foll);
          $data=unserialize('a:10:{s:6:"enq_id";s:5:"27556";s:7:"vreg_id";s:6:"124298";s:16:"vreg_assigned_to";s:3:"949";s:18:"enq_cus_status_old";s:1:"2";s:7:"enquiry";a:25:{s:18:"enq_customer_grade";s:1:"3";s:14:"enq_cus_status";s:1:"2";s:14:"enq_entry_date";s:10:"11-02-2023";s:12:"enq_cus_name";s:5:"Niyas";s:15:"enq_cus_address";s:9:"alappuzha";s:19:"enq_cus_ofc_address";s:9:"alappuzha";s:17:"enq_cus_office_no";s:0:"";s:12:"enq_cus_city";s:10:"Alappuzha ";s:13:"enq_cus_email";s:0:"";s:16:"enq_cus_whatsapp";s:0:"";s:12:"enq_cus_fbid";s:0:"";s:17:"enq_cus_age_group";s:5:"20-30";s:14:"enq_cus_gender";s:1:"1";s:12:"enq_cus_occu";s:1:"7";s:15:"enq_cus_company";s:3:"NIL";s:17:"enq_cus_phone_res";s:0:"";s:12:"enq_cus_dist";s:1:"1";s:11:"enq_cus_pin";s:1:"0";s:12:"enq_mode_enq";s:1:"9";s:15:"enq_cus_remarks";s:55:"harley davidson fat bob model-2016 model, 2nd ownership";s:15:"enq_cus_purpose";s:2:"15";s:17:"enq_cus_loan_perc";s:1:"0";s:19:"enq_cus_loan_amount";s:1:"0";s:16:"enq_cus_loan_emi";s:1:"0";s:19:"enq_cus_loan_period";s:1:"0";}s:3:"enq";a:1:{s:13:"other_purpose";s:0:"";}s:5:"money";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:4:"need";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:9:"authority";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:7:"vehicle";a:1:{s:3:"buy";a:38:{s:6:"val_id";a:1:{i:0;s:0:"";}s:6:"veh_id";a:1:{i:0;s:5:"50727";}s:10:"veh_delete";a:1:{i:0;s:1:"0";}s:9:"veh_brand";a:1:{i:0;s:2:"37";}s:9:"veh_model";a:1:{i:0;s:3:"326";}s:11:"veh_varient";a:1:{i:0;s:4:"4073";}s:8:"veh_fuel";a:1:{i:0;s:1:"1";}s:8:"veh_year";a:1:{i:0;s:4:"2016";}s:9:"veh_color";a:1:{i:0;s:1:"0";}s:12:"veh_price_id";a:1:{i:0;s:1:"0";}s:11:"veh_km_from";a:1:{i:0;s:1:"0";}s:15:"veh_color_in_rc";a:1:{i:0;s:3:"135";}s:21:"veh_delivery_location";a:1:{i:0;s:0:"";}s:18:"veh_delivery_state";a:1:{i:0;s:0:"";}s:14:"veh_dealership";a:1:{i:0;s:0:"";}s:8:"veh_reg1";a:1:{i:0;s:2:"kl";}s:8:"veh_reg2";a:1:{i:0;s:2:"04";}s:8:"veh_reg3";a:1:{i:0;s:2:"at";}s:8:"veh_reg4";a:1:{i:0;s:4:"3327";}s:10:"veh_re_reg";a:1:{i:0;s:0:"";}s:9:"veh_owner";a:1:{i:0;s:1:"2";}s:13:"veh_comprossr";a:1:{i:0;s:1:"0";}s:18:"veh_chassis_number";a:1:{i:0;s:0:"";}s:11:"veh_remarks";a:1:{i:0;s:0:"";}s:17:"veh_delivery_date";a:1:{i:0;s:0:"";}s:13:"veh_first_reg";a:1:{i:0;s:0:"";}s:13:"veh_manf_year";a:1:{i:0;s:1:"0";}s:6:"veh_ac";a:1:{i:0;s:1:"0";}s:11:"veh_ac_zone";a:1:{i:0;s:1:"0";}s:6:"veh_cc";a:1:{i:0;s:1:"0";}s:16:"veh_vehicle_type";a:1:{i:0;s:1:"0";}s:14:"veh_engine_num";a:1:{i:0;s:1:"0";}s:16:"veh_transmission";a:1:{i:0;s:0:"";}s:11:"veh_seat_no";a:1:{i:0;s:1:"0";}s:14:"insurance_type";a:1:{i:0;s:0:"";}s:7:"ncb_req";a:1:{i:0;s:1:"0";}s:15:"finance_company";a:1:{i:0;s:0:"";}s:4:"bank";a:1:{i:0;s:1:"0";}}}}');
          $enquiry=$data['enquiry'];
          //debug($data['enquiry']);
//exit;
          $vehs= $this->db->where('veh_enq_id', 27556)->get('cpnl_vehicle')->result_array();
         // debug($vehs);



          foreach($vehs as $buy){
               //////////
               $enquiryId=$buy['veh_enq_id'];
               $valuationDetails['val_vehicle_id'] = $buy['veh_id'];
               $valuationDetails['val_enquiry_id'] = $enquiryId;
               $valuationDetails['val_veh_no'] = isset($buy['veh_reg']) ? $buy['veh_reg'] : '';
               $valuationDetails['val_showroom'] =$buy['veh_showroom_id'];
               $valuationDetails['val_division'] = $this->div;
               $valuationDetails['val_brand'] = $buy['veh_brand'];
               $valuationDetails['val_model'] = $buy['veh_model'];
               $valuationDetails['val_variant'] = $buy['veh_varient'];
               $valuationDetails['val_fuel'] = $buy['veh_fuel'];
               $valuationDetails['val_color'] = 135;
               $valuationDetails['val_chasis_no'] = $buy['veh_chassis_number'];
               $valuationDetails['val_added_by'] = $buy['veh_added_by'];
               
               $valuationDetails['val_type'] = 3;
               $valuationDetails['val_km'] = !empty($buy['veh_km_from']) ? $buy['veh_km_from'] : $buy['veh_km_to'];

               $valuationDetails['val_model_year'] = $buy['veh_year'];
               $valuationDetails['val_delv_date'] = !empty($buy['veh_delivery_date']) ? date('Y-m-d', strtotime($buy['veh_delivery_date'])) :NULL;
               $valuationDetails['val_reg_date'] = !empty($buy['veh_first_reg']) ? date('Y-m-d', strtotime($buy['veh_first_reg'])) : NULL;
               $valuationDetails['val_minif_year'] = $buy['veh_manf_year'];
               $valuationDetails['val_ac'] = $buy['veh_ac'];
               $valuationDetails['val_ac_zone'] = $buy['veh_ac_zone'];
               $valuationDetails['val_eng_cc'] = $buy['veh_cc'];
               $valuationDetails['val_veh_type'] = $buy['veh_vehicle_type'];
               $valuationDetails['val_model_year'] = $buy['veh_year'];
               $valuationDetails['val_engine_no'] = $buy['veh_engine_num'];
               $valuationDetails['val_transmission'] = $buy['veh_transmission'];
               $valuationDetails['val_no_of_seats'] = $buy['veh_seat_no'];
               //$valuationDetails['val_delv_date'] = !empty($buy['veh_delivery_date']) ? date('Y-m-d', strtotime($buy['veh_delivery_date'])) :'';
               //$valuationDetails['val_reg_date'] = !empty($buy['veh_first_reg']) ? date('Y-m-d', strtotime($buy['veh_first_reg'])) : '';
               $valuationDetails['val_cust_name'] = isset($enquiry['enq_cus_name']) ? $enquiry['enq_cus_name'] : '';
               $valuationDetails['val_cust_phone'] = isset($enquiry['enq_cus_mobile']) ? $enquiry['enq_cus_mobile'] : '';
               $valuationDetails['val_cust_email'] = isset($enquiry['enq_cus_email']) ? $enquiry['enq_cus_email'] : '';
               $valuationDetails['val_cust_source'] = isset($enquiry['enq_mode_enq']) ? $enquiry['enq_mode_enq'] : '';
               $valuationDetails['val_veh_color_in_rc'] = $buy['veh_color_in_rc'];
               //   $valuationDetails['val_veh_delivery_location'] = $data['veh_delivery_location'][$i];
               //   $valuationDetails['val_veh_delivery_state'] = $data['veh_delivery_state'][$i];
               //   $valuationDetails['val_veh_comprossr'] = $data['veh_comprossr'][$i];
               //   $valuationDetails['val_veh_dealership'] = $data['veh_dealership'][$i];
               $valuationDetails['val_first_dlvry_location'] = $buy['veh_delivery_location'];
               $valuationDetails['val_first_dlvry_state'] = $buy['veh_delivery_state'];
               $valuationDetails['val_ac_compressor'] = $buy['veh_comprossr'];
               $valuationDetails['val_first_dlvry_dlrship'] = $buy['veh_dealership'];
               $valuationDetails['val_veh_re_reg'] = $buy['veh_re_reg'];

               $vhNum = (isset($buy['veh_reg']) && !empty($buy['veh_reg'])) ? explode('-', str_replace(' ', '-', $buy['veh_reg'])) : '';
               $valuationDetails['val_prt_1'] = isset($vhNum['0']) ? $vhNum['0'] : '';
               $valuationDetails['val_prt_2'] = isset($vhNum['1']) ? $vhNum['1'] : '';
               $valuationDetails['val_prt_3'] = isset($vhNum['2']) ? $vhNum['2'] : '';
               $valuationDetails['val_prt_4'] = isset($vhNum['3']) ? $vhNum['3'] : '';
               $valuationDetails['val_insurance_company'] = isset($data['insurance_company'][$i]) ? $data['insurance_company'][$i] : '';
               $valuationDetails['val_insurance_comp_date'] = !empty($data['valid_up_to'][$i]) ? date('Y-m-d', strtotime($data['valid_up_to'][$i])) : NULL; //isset($data['vehicle']['buy']['valid_up_to'][$i]) ? $data['vehicle']['buy']['valid_up_to'][$i] : '';
               $valuationDetails['val_insurance_ll_date'] = !empty($data['val_insurance_ll_date'][$i]) ? date('Y-m-d', strtotime($data['val_insurance_ll_date'][$i])) : NULL; //isset($data['vehicle']['buy']['val_insurance_ll_date'][$i]) ? $data['vehicle']['buy']['val_insurance_ll_date'][$i] : '';
               $valuationDetails['val_insurance_comp_idv'] = !empty($data['idv'][$i]) ? $data['idv'][$i] :0;
               //debug($valuationDetails['val_insurance_comp_idv']);
               $valuationDetails['val_insurance_ll_idv'] = !empty($data['ncb_percentage'][$i]) ? $data['ncb_percentage'][$i] : 0;
               //$valuationDetails['val_insurance_need_ncb'] = isset($data['vehicle']['buy']['ncb_req'][$i]) ? $data['vehicle']['buy']['ncb_req'][$i] : '';
               $valuationDetails['val_insurance_need_ncb'] = $data['ncb_req'][0] ? 1 : 0;
               $valuationDetails['val_insurance'] = !empty($data['insurance_type'][$i]) ? $data['insurance_type'][$i] : 0;
               //hypothication
               $valuationDetails['val_hypo_bank'] = !empty($data['bank'][$i]) ? $data['bank'][$i] : 0;
               $valuationDetails['val_hypo_bank_branch'] = !empty($data['bank_branch'][$i]) ? $data['bank_branch'][$i] : NULL;
               //$valuationDetails['val_hypo_close_by_cust'] = isset($data['vehicle']['buy']['val_hypo_close_by_cust'][$i]) ? $data['vehicle']['buy']['val_hypo_close_by_cust'][$i] : '';
               $valuationDetails['val_hypo_loan_date'] = !empty($data['loan_starting_date'][$i]) ? date('Y-m-d', strtotime($data['loan_starting_date'][$i])) : NULL; //isset($data['vehicle']['buy']['loan_starting_date'][$i]) ? $data['vehicle']['buy']['loan_starting_date'][$i] : '';
               $valuationDetails['val_hypo_loan_end_date'] = !empty($data['loan_ending_date'][$i]) ? date('Y-m-d', strtotime($data['loan_ending_date'][$i])) : NULL; //isset($data['vehicle']['buy']['loan_ending_date'][$i]) ? $data['vehicle']['buy']['loan_ending_date'][$i] : '';
               $valuationDetails['val_hypo_daily_int'] = !empty($data['daily_interest'][$i]) ? $data['daily_interest'][$i] : NULL;
               $valuationDetails['val_hypo_frclos_val'] = !empty($data['forclousure_value'][$i]) ? $data['forclousure_value'][$i] : NULL;
               $valuationDetails['val_hypo_frclos_val'] = !empty($data['forclousure_value'][$i]) ? $data['forclousure_value'][$i] : NULL;
               $valuationDetails['val_hypo_frclos_date'] = !empty($data['forclousure_date'][$i]) ? date('Y-m-d', strtotime($data['forclousure_date'][$i])) : NULL; //isset($data['vehicle']['buy']['forclousure_date'][$i]) ? $data['vehicle']['buy']['forclousure_date'][$i] : '';
               $valuationDetails['val_top_up_loan'] = isset($data['any_top_up_loan'][$i]) ? 1 : 0;
               $valuationDetails['val_hypo_close_by_cust'] = isset($data['val_hypo_close_by_cust'][$i]) ? 1 : 0;
               $valuationDetails['val_hypo_loan_amt'] = !empty($data['loan_amount'][$i]) ? $data['loan_amount'][$i] : 0;
               // if (isset($data['val_id'][$i])) { //Check if Selected already added vehicle from the select box
               //      //debug($data['val_id'][$i]);
               //      $this->db->where('val_id', $data['val_id'][$i]);
               //      //$this->db->update($this->tbl_valuation, ['val_enquiry_id' => $enquiryId]);
               //      $this->db->update($this->tbl_valuation, $valuationDetails);
               // } else { //Newly added vehicle
               //      //debug('new');
               //      $valuationDetails['val_status'] = 0;
               //      $this->db->insert($this->tbl_valuation, $valuationDetails);
               // }

               $valuationDetails['val_status'] = 0;
                    $this->db->insert('cpnl_valuation', $valuationDetails);//oly fr ths

/////////////////////End//////////////////////
          }
         // debug($valuationDetails);

exit;


          //$zd=unserialize('a:10:{s:6:"enq_id";s:5:"27556";s:7:"vreg_id";s:6:"124298";s:16:"vreg_assigned_to";s:3:"949";s:18:"enq_cus_status_old";s:1:"2";s:7:"enquiry";a:25:{s:18:"enq_customer_grade";s:1:"3";s:14:"enq_cus_status";s:1:"2";s:14:"enq_entry_date";s:10:"11-02-2023";s:12:"enq_cus_name";s:5:"Niyas";s:15:"enq_cus_address";s:9:"alappuzha";s:19:"enq_cus_ofc_address";s:9:"alappuzha";s:17:"enq_cus_office_no";s:0:"";s:12:"enq_cus_city";s:10:"Alappuzha ";s:13:"enq_cus_email";s:0:"";s:16:"enq_cus_whatsapp";s:0:"";s:12:"enq_cus_fbid";s:0:"";s:17:"enq_cus_age_group";s:5:"20-30";s:14:"enq_cus_gender";s:1:"1";s:12:"enq_cus_occu";s:1:"7";s:15:"enq_cus_company";s:3:"NIL";s:17:"enq_cus_phone_res";s:0:"";s:12:"enq_cus_dist";s:1:"1";s:11:"enq_cus_pin";s:1:"0";s:12:"enq_mode_enq";s:1:"9";s:15:"enq_cus_remarks";s:55:"harley davidson fat bob model-2016 model, 2nd ownership";s:15:"enq_cus_purpose";s:2:"15";s:17:"enq_cus_loan_perc";s:1:"0";s:19:"enq_cus_loan_amount";s:1:"0";s:16:"enq_cus_loan_emi";s:1:"0";s:19:"enq_cus_loan_period";s:1:"0";}s:3:"enq";a:1:{s:13:"other_purpose";s:0:"";}s:5:"money";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:4:"need";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:9:"authority";a:4:{s:4:"name";s:0:"";s:5:"phone";s:0:"";s:8:"relation";s:0:"";s:7:"remarks";s:0:"";}s:7:"vehicle";a:1:{s:3:"buy";a:38:{s:6:"val_id";a:1:{i:0;s:0:"";}s:6:"veh_id";a:1:{i:0;s:5:"50727";}s:10:"veh_delete";a:1:{i:0;s:1:"0";}s:9:"veh_brand";a:1:{i:0;s:2:"37";}s:9:"veh_model";a:1:{i:0;s:3:"326";}s:11:"veh_varient";a:1:{i:0;s:4:"4073";}s:8:"veh_fuel";a:1:{i:0;s:1:"1";}s:8:"veh_year";a:1:{i:0;s:4:"2016";}s:9:"veh_color";a:1:{i:0;s:1:"0";}s:12:"veh_price_id";a:1:{i:0;s:1:"0";}s:11:"veh_km_from";a:1:{i:0;s:1:"0";}s:15:"veh_color_in_rc";a:1:{i:0;s:3:"135";}s:21:"veh_delivery_location";a:1:{i:0;s:0:"";}s:18:"veh_delivery_state";a:1:{i:0;s:0:"";}s:14:"veh_dealership";a:1:{i:0;s:0:"";}s:8:"veh_reg1";a:1:{i:0;s:2:"kl";}s:8:"veh_reg2";a:1:{i:0;s:2:"04";}s:8:"veh_reg3";a:1:{i:0;s:2:"at";}s:8:"veh_reg4";a:1:{i:0;s:4:"3327";}s:10:"veh_re_reg";a:1:{i:0;s:0:"";}s:9:"veh_owner";a:1:{i:0;s:1:"2";}s:13:"veh_comprossr";a:1:{i:0;s:1:"0";}s:18:"veh_chassis_number";a:1:{i:0;s:0:"";}s:11:"veh_remarks";a:1:{i:0;s:0:"";}s:17:"veh_delivery_date";a:1:{i:0;s:0:"";}s:13:"veh_first_reg";a:1:{i:0;s:0:"";}s:13:"veh_manf_year";a:1:{i:0;s:1:"0";}s:6:"veh_ac";a:1:{i:0;s:1:"0";}s:11:"veh_ac_zone";a:1:{i:0;s:1:"0";}s:6:"veh_cc";a:1:{i:0;s:1:"0";}s:16:"veh_vehicle_type";a:1:{i:0;s:1:"0";}s:14:"veh_engine_num";a:1:{i:0;s:1:"0";}s:16:"veh_transmission";a:1:{i:0;s:0:"";}s:11:"veh_seat_no";a:1:{i:0;s:1:"0";}s:14:"insurance_type";a:1:{i:0;s:0:"";}s:7:"ncb_req";a:1:{i:0;s:1:"0";}s:15:"finance_company";a:1:{i:0;s:0:"";}s:4:"bank";a:1:{i:0;s:1:"0";}}}}');
//debug($zd);
          // $this->db->delete('cpnl_km_ranges', array('kmr_id' =>37));
          // exit;
          // for($i=37000; $i < 100000; $i += 1000){
          //      $to= $i+1000;
          //      echo $i .'-'.$to ;
          //      echo '<br>';
          //      $data = array(
          //           'kmr_range_from' => $i,
          //           'kmr_range_to' => $to,
          //           );
          //      $this->db->insert('cpnl_km_ranges', $data);

          // }
          $data = array(
               'kmr_range_from' => 100000,
               'kmr_range_to' => 1000000,
          );
          $this->db->insert('cpnl_km_ranges', $data);

          //echo $i;
          exit;
          // $query = $this->db->query("SELECT * FROM cpnl_enquiry ORDER BY enq_id DESC LIMIT 1");

          //$data=$this->db->select('*')->get('cpnl_valuation')->result_array();
          $tables = $this->db->query("SELECT t.TABLE_NAME AS myTables FROM INFORMATION_SCHEMA.TABLES AS t WHERE t.TABLE_SCHEMA = 'royaldri_royaldrive' AND t.TABLE_NAME LIKE '%a%' ")->result_array();
          foreach ($tables as $key => $val) {
               echo $val['myTables'] . "<br>"; // myTables is the alias used in query.
          }
          exit;


          // $data=$this->db->select('*')->get('cpnl_vehicle_status')->result_array();
          // debug($data);
          //for testing
          // $sql="ALTER TABLE cpnl_valuation_1
          // ADD COLUMN val_refurb_remark TEXT";    
          //     $query = $this->db->query($sql);
          //     debug($query);
          //     exit;

          //   $sql="ALTER TABLE cpnl_valuation
          //           ADD COLUMN val_parent_id int(11)";    
          //               $query = $this->db->query($sql);
          //               debug($query);
          //               exit;
          //$data=$this->db->where('val_id',2821)->get('cpnl_valuation')->row_array();

          //$data=$this->db->get('cpnl_statuses')->result_array();
          //$data=$this->db->where('sts_value',43)->get('cpnl_statuses')->result_array();
          $data = $this->db->select(array('cpnl_user_access.cua_group_id', 'cpnl_users.usr_id', 'cpnl_users.usr_username', 'cpnl_user_access.cua_access', 'cpnl_user_access.cua_desig'))->join('cpnl_users', 'cpnl_users.usr_id =cpnl_user_access.cua_user_id', 'left')->where('cua_user_id', 870)->get('cpnl_user_access')->row_array();

          $data2 = array(
               'rol_name' => 'MIS Coordinator',
               'rol_access' => $data['cua_access'],
               'rol_date' => date("Y-m-21 17:42:44"),
               'rol_desig' => $data['cua_desig'],
               'rol_group_id' => $data['cua_group_id']
          );
          // $this->db->where('rol_id', 35);
          //$this->db->update('cpnl_role', $data2);
          ///// $this->db->insert('cpnl_role',$data2);
          debug($data2, 1);
          // $this->tbl_valuation='cpnl_valuation_1';
          //$data=$this->db->where('(' . $this->tbl_valuation . ".val_status=39  OR " . $this->tbl_valuation . ".val_status =43 OR " . $this->tbl_valuation . ".val_status =66 )")->get('cpnl_valuation_1')->result_array();
          // $data=$this->db->where('var_id',1)->get('cpnl_variant')->result_array();
          // $data=$this->db->where('pcl_val_id',14)->get('cpnl_purchase_check_list_1')->result_array();
          // $data=$this->db->where('pcld_check_list_master_id',579)->get('cpnl_purchase_check_list_details_1')->result_array();
          //$data=$this->db->select('val_id,val_veh_no,val_cust_name,val_status,val_refurb_status')->order_by('val_id', 'desc')->get('cpnl_valuation_1')->result_array();
          //  $data=$this->db->where('sts_value',40)->get('cpnl_statuses')->result_array();//13 booking//28/ booking confrmd//40 Vehicle delivered.
          //$data=$this->db->get('cpnl_valuation_complaint_1')->result_array();
          // $data=$this->db->get('cpnl_vehicle_booking_master_1')->result_array();
          //$data=$this->db->order_by("prd_reg_id", "desc")->get('rana_products')->row_array();//

          //$data=$this->db->get('cpnl_groups')->result_array();

          //$data=$this->db->truncate('cpnl_role');

          //  $data=$this->db->select(array('cpnl_user_access.cua_group_id','cpnl_groups.name','cpnl_user_access.cua_access','cpnl_user_access.cua_desig'))->order_by("cua_group_id", "asc")->group_by('cua_group_id') ->join('cpnl_groups','cpnl_groups.id =cpnl_user_access.cua_group_id', 'left')->get('cpnl_user_access')->result_array();
          //    foreach($data as $value){
          //      $data2 = array(
          //           'rol_name'=>$value['name'],
          //           'rol_access'=>$value['cua_access'],
          //           'rol_date'=>date("Y-m-27 17:42:44"),
          //           'rol_desig'=>$value['cua_desig'],
          //           'rol_group_id'=>$value['cua_group_id']
          //       );

          //       $this->db->insert('cpnl_role',$data2);

          //    }
          // $data=$this->db->get('cpnl_role')->result_array();\
          //$data=$this->db->select(array('cpnl_user_access.cua_group_id','cpnl_groups.name','cpnl_user_access.cua_access','cpnl_user_access.cua_desig'))->order_by("cua_group_id", "asc")->group_by('cua_group_id') ->join('cpnl_groups','cpnl_groups.id =cpnl_user_access.cua_group_id', 'left')->get('cpnl_user_access')->result_array();
          // $data=$this->db->get('cpnl_users_groups')->result_array();


          //$data=$this->db->select(array('cpnl_role.rol_id','cpnl_users_groups.group_id','cpnl_users_groups.user_id','cpnl_role.rol_name','cpnl_role.rol_desig','cpnl_role.rol_group_id'))->order_by("cpnl_role.rol_id", "asc")->join('cpnl_role','cpnl_users_groups.group_id = cpnl_role.rol_group_id', 'left')->get('cpnl_users_groups')->result_array();
          // $data=$this->db->select(array('cpnl_role.rol_id','cpnl_users_groups.group_id','cpnl_users_groups.user_id','cpnl_role.rol_name','cpnl_role.rol_desig','cpnl_role.rol_group_id','cpnl_users.usr_username','cpnl_users.usr_id','cpnl_users.usr_active','cpnl_users.usr_resigned'))->order_by("cpnl_role.rol_id", "asc")
          // ->join('cpnl_role','cpnl_users_groups.group_id = cpnl_role.rol_group_id', 'left')
          // ->join('cpnl_users','cpnl_users_groups.user_id = cpnl_users.usr_id', 'left')
          // ->where('cpnl_users.usr_active',1)->where('cpnl_users.usr_resigned',0)
          // ->get('cpnl_users_groups')->result_array();


          // Exicuted $data=$this->db->select(array('cpnl_role.rol_id','cpnl_users_groups.group_id','cpnl_users_groups.user_id','cpnl_role.rol_name','cpnl_role.rol_desig','cpnl_role.rol_group_id','cpnl_users.usr_username','cpnl_users.usr_id','cpnl_users.usr_active','cpnl_users.usr_resigned'))->order_by("cpnl_users.usr_id", "asc")
          // ->join('cpnl_role','cpnl_users_groups.group_id = cpnl_role.rol_group_id', 'left')
          // ->join('cpnl_users','cpnl_users_groups.user_id = cpnl_users.usr_id', 'left')
          // ->where('cpnl_users.usr_active',1)->where('cpnl_users.usr_resigned',0)->where('rol_id is NOT NULL', NULL, FALSE)
          // ->get('cpnl_users_groups')->result_array();

          // $data=$this->db->select(array('cpnl_users.usr_id','cpnl_users.usr_username','cpnl_users.usr_active','cpnl_users.usr_resigned'))->order_by("cpnl_users.usr_id", "asc")
          // ->join('cpnl_role','cpnl_users_groups.group_id = cpnl_role.rol_group_id', 'left')
          // ->join('cpnl_users','cpnl_users_groups.user_id = cpnl_users.usr_id', 'left')
          // ->where('cpnl_users.usr_active',1)->where('cpnl_users.usr_resigned',0)
          // ->get('cpnl_users_groups')->result_array();

          // foreach($data as $value){
          //      $data2 = array(
          //           'usr_rol'=>$value['rol_id']
          //                );

          //       $this->db->where('usr_id', $value['user_id']);
          //       $this->db->update('cpnl_users', $data2);

          //    }
          //$data=$this->db->select('usr_id,usr_username,usr_rol,usr_active,usr_resigned')->where('usr_active',1)->where('usr_resigned',0)->order_by("cpnl_users.usr_id", "asc")->get('cpnl_users')->result_array();        
          //$data=$this->db->select('usr_id,usr_username,usr_active,usr_resigned,usr_rol')->where('usr_active',1)->where('usr_resigned',0)->order_by("cpnl_users.usr_id", "asc")->get('cpnl_users')->result_array();      


          debug($data);
     }

     function upd_parent_val_form()
     {
          $this->render_page(strtolower(__CLASS__) . '/wv_temp_parnt_form');
     }
     function upd_parent_val()
     {
          //debug($_GET);
          $val_id = $_GET['val_d'];
          $parent_id = $_GET['parent_id'];
          $data = array(
               'val_parent_id' => $parent_id,
               'val_re_evaluated' => 1,
          );
          $res = $this->db->where('val_id', $val_id)->update('cpnl_valuation', $data);
          // $data= array(
          //      'val_parent_id'=>2587,
          //      'val_re_evaluated'=> 1,
          //           );
          // $res= $this->db->where('val_id',2889)->update('cpnl_valuation',$data);
          //debug($res);

          $this->render_page(strtolower(__CLASS__) . '/wv_temp_parnt_form');
     }


     function re_upd_parent_val()
     { ///j
          //debug($_GET);
          $val_id = $_GET['val_d']; //latest recrd remv revl fld
          $parent_id = $_GET['parent_id'];
          $data = array(
               'val_re_evaluated' => 1,
          );
          $res = $this->db->where('val_id', $parent_id)->update('cpnl_valuation', $data);
          //
          $data2 = array(
               'val_re_evaluated' => 0,
          );
          $res2 = $this->db->where('val_id', $val_id)->update('cpnl_valuation', $data2);
          $this->render_page(strtolower(__CLASS__) . '/wv_temp_parnt_form');
     }
     /////@newww////

}
