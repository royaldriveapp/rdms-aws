<?php

defined('BASEPATH') or exit('No direct script access allowed');

class insurance extends App_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->model('insurance_model', 'insurance');
          $this->load->model('evaluation/evaluation_model', 'evaluation');
     }

     public function index()
     {
          $data['stockVehicle'] = $this->insurance->getData();
          $this->render_page(strtolower(__CLASS__) . '/index', $data);
     }

     public function update($id = '')
     {
          if (!empty($_POST)) {
               if ($this->model->update($_POST)) {
                    $this->session->set_flashdata('app_success', 'Color successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Color!");
               }
               redirect(strtolower(__CLASS__));
          } elseif ($id) {
               // debug($id);
               $id = encryptor($id, 'D');
               //$data['vc_id'] = $id;
               //$data['item'] = $this->model->selectData($id);
               $data['bottleNeck'] = $this->model->edit($id);
               // debug($data);
               $this->render_page(strtolower(__CLASS__) . '/edit', $data);
          }
     }

     public function delete($id)
     {
          if ($this->model->delete($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Color successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete Color"));
          }
     }

     public function add()
     {
          if (!empty($_POST)) {
               if ($this->model->insert($_POST)) {
                    $this->session->set_flashdata('app_success', 'Color successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Color!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $this->render_page(strtolower(__CLASS__) . '/add');
          }
     }
     public function requests()
     { //unsolved
          $data['bottleNecks'] = $this->model->getUnsolvedReqData();
          $this->render_page(strtolower(__CLASS__) . '/requests', $data);
     }
     public function solved_requests()
     { //unsolved
          $data['bottleNecks'] = $this->model->getSolvedReqData();
          $this->render_page(strtolower(__CLASS__) . '/requests_solved', $data);
     }

     function updateins($id = 0)
     {
          if (!empty($_POST)) {
               $yearCode = get_ihits_fin_year_code();
               $ls = !empty($_POST['val_stock_num']) ? strtolower(substr($_POST['val_stock_num'], 0, 1)) : '';
               $yearCode = isset($yearCode[$ls]) ? $yearCode[$ls] : '';

               $GstAplcble = 0;
               if (
                    !empty($_POST['insdetail']['sgstp']) || !empty($_POST['insdetail']['sgst'])
                    || !empty($_POST['insdetail']['cgstp']) || !empty($_POST['insdetail']['cgst'])
                    || !empty($_POST['insdetail']['igstp']) || !empty($_POST['insdetail']['igst'])
               ) {
                    $GstAplcble = 1;
               }

               //Upload documents
               $this->load->library('upload');
               if (isset($_FILES['documents']['name'][0]) && !empty($_FILES['documents']['name'][0]) && is_array($_FILES['documents']['name'])) {
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
                                   $docs['vdoc_doc_title'] = isset($_POST['document_title']) ? $_POST['document_title'] : '';
                                   $docs['vdoc_doc_type'] = isset($_POST['document_type']) ? $_POST['document_type'] : '';
                                   $this->evaluation->newEvaluationDocument($docs);
                              }
                         } else {
                              $f = $this->upload->display_errors();
                              debug($f);
                         }
                    }
               }
               unset($_POST['document_type']);
               unset($_POST['document_title']);
               //iHits API
               $_POST['val_ins_details'] = serialize($_POST['insdetail']);

               /*$this->ihits->ihitsSaveExpense(array(
                    'billNo' => !empty($_POST['insdetail']['aplg_bill_no']) ? $_POST['insdetail']['aplg_bill_no'] : generate_inv_number($_POST['val_id']),
                    'billDate' => date('Y-m-d', strtotime($_POST['insdetail']['aplg_bill_date'])),
                    'partyName' => $_POST['val_insurance_company'],
                    'registrationNo' => $_POST['insdetail']['val_veh_no'],
                    'expTotAmount' => (float) $_POST['insdetail']['insamount'] + (float) $_POST['insdetail']['sgst'] + (float) $_POST['insdetail']['cgst'] + (float) $_POST['insdetail']['igst'],
                    'remarks' => $_POST['val_ins_remarks'],
                    'bookingNo' => '',
                    'expType' => 'Insurance Premium',
                    'expAmount' => (float) $_POST['insdetail']['insamount'],
                    'sgstPer' => (float) $_POST['insdetail']['sgstp'],
                    'sgstAmount' => (float) $_POST['insdetail']['sgst'],
                    'cgstPer' => (float) $_POST['insdetail']['cgstp'],
                    'cgstAmount' => (float) $_POST['insdetail']['cgst'],
                    'igstPer' => (float) $_POST['insdetail']['igstp'],
                    'igstAmount' => (float) $_POST['insdetail']['igst'],
                    'totalAmount' => (float) $_POST['insdetail']['insamount'],
                    'mode' => 'C',
                    'stockID' => (string) $_POST['val_stock_num'],
                    'gcCode' => (int)$yearCode,
                    'gstAplcble' => (int)$GstAplcble
               ), 0, 0, $_POST['val_id'], 0);*/
               unset($_POST['insdetail']);
               //iHits API
               $this->insurance->updateins($_POST);
               $this->session->set_flashdata('app_success', 'Insurance renewal successfully completed!');
               redirect(strtolower(__CLASS__));
          } else {
               $id = encryptor($id, 'D');
               $data['stockVehicle'] = $this->insurance->getData($id);
               $this->render_page(strtolower(__CLASS__) . '/updateins', $data);
          }
     }

     function stockVehicle()
     {
          // $data['stockVehicle'] = $this->insurance->stockVehicle();
          // $this->render_page(strtolower(__CLASS__) . '/index', $data);
          $this->render_page(strtolower(__CLASS__) . '/index2', $data);
     }

     function updateinss($id = 0)
     {
          if (!empty($_POST)) {

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
                                   $docs['vdoc_val_id'] = $_POST['val_id'];
                                   $docs['vdoc_doc'] = $uploadData['file_name'];
                                   $docs['vdoc_doc_title'] = isset($_POST['document_title']) ? $_POST['document_title'] : '';
                                   $docs['vdoc_doc_type'] = isset($_POST['document_type']) ? $_POST['document_type'] : '';
                                   $this->evaluation->newEvaluationDocument($docs);
                              }
                         } else {
                              $f = $this->upload->display_errors();
                              debug($f);
                         }
                    }
               }
               unset($_POST['document_type']);
               unset($_POST['document_title']);
               $this->insurance->updateins($_POST);
          }
          $id = encryptor($id, 'D');
          $data['stockVehicle'] = $this->insurance->getData($id);
          $this->render_page(strtolower(__CLASS__) . '/updateinss', $data);
     }

     function insurancepending()
     {
          $data['stockVehicle'] = $this->insurance->insurancePending();
          $this->render_page(strtolower(__CLASS__) . '/insurancepending', $data);
     }
     public function stock_list()
     {
          $this->render_page(strtolower(__CLASS__) . '/index2', $data);
     }
     function stock_ajax()
     {
          $response = $this->insurance->stockVehiclePaginate($this->input->post());
          echo json_encode($response);
          exit;
     }
}
