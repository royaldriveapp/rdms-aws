<?php
defined('BASEPATH') or exit('No direct script access allowed');
class mou extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'MOU Generation';
          $this->load->model('mou_model', 'mou');
          $this->load->library('form_validation');
          $this->load->model('ihits_api/ihits_api_model', 'ihits');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('registration/registration_model', 'registration');
          $this->load->model('evaluation/evaluation_model', 'evaluation');
     }

     public function index()
     {
          $datas['moulist'] = $this->mou->getAllRecords();
          $this->render_page(strtolower(__CLASS__) . '/list', $datas);
     }

     /*public function export($id) {
            $data['datas'] = $this->mou->getMou($id);
            $data['view'] = $this->load->view(strtolower(__CLASS__) . '/print', $data, true);
            //$this->render_page(strtolower(__CLASS__) . '/mouprint', $data);
            $this->load->library('M_pdf');
            $pdfFilePath = "product_spec.pdf";
            $this->m_pdf->pdf->WriteHTML($data['view']);
            $this->m_pdf->pdf->Output($pdfFilePath, 'D');
       }*/

     public function view($id)
     {
          $data['id'] = $id;
          $id = encryptor($id, 'D');
          $this->template->set_layout('mou');
          $data['datas'] = $this->mou->getMou($id);
          $data['view'] = $this->load->view(strtolower(__CLASS__) . '/print', $data, true);
          $this->render_page(strtolower(__CLASS__) . '/mou', $data);
     }

     function approval($id)
     {
          $id = encryptor($id, 'D');
          $this->ihitsPurchaseToken($id);
          $desc = isset($_POST['desc']) ? isset($_POST['desc']) : '';
          if ($f = $this->mou->approval($id, $desc)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Product status successfully changed'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't change product status"));
          }
     }

     function ihitsPurchaseToken($mouId)
     {
          $data['purchaseTokenDetails'] = $this->mou->getPurchaseTokenDetails($mouId);
          $data['purchaseTokenDetails']['enq_trans_mode'] = 'C';
          generate_log(array(
               'log_title' => 'ihitsPurchaseToken',
               'log_desc' => serialize($data),
               'log_controller' => 'ihitspurchasetoken',
               'log_action' => 'C',
               'log_ref_id' => 0,
               'log_added_by' => $this->uid
          ));
          $responce = $this->ihits->ihitsPurchaseToken($data['purchaseTokenDetails']);
          return true;
     }

     public function add()
     {
          generate_log(array(
               'log_title' => 'New mou',
               'log_desc' => serialize($_POST),
               'log_controller' => 'pre-new-mou',
               'log_action' => 'C',
               'log_ref_id' => 0,
               'log_added_by' => $this->uid
          ));
          if (!empty($_POST)) {
               $data = array();
               if ($this->mou->addNewMOU($_POST)) {
                    $this->session->set_flashdata('app_success', 'MOU successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't add MOU!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $states = [18, 0];
               $data['valuations'] = $this->mou->getValData();
               $data['color'] = $this->evaluation->getColors();
               $data['identComponent'] = unserialize(MOU_VEH_IDENT_COMPONENTS);
               $data['districts'] = $this->registration->getDistricts($states);
               $data['purchaseStaff'] = $this->mou->getPurchaseStaff();
               $data['brand'] = $this->enquiry->getBrands();
               $data['division'] = $this->divisions->getActiveData();
               $data['company'] = $this->mou->getCompany();
               $this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     function approve($mid = 0)
     {
          if (!empty($_POST)) {
               generate_log(array(
                    'log_title' => 'Approve mou',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'pre-approve-mou',
                    'log_action' => 'E',
                    'log_ref_id' => $_POST['moum_id'],
                    'log_added_by' => $this->uid
               ));

               if ($this->mou->approveMOU($_POST)) {
                    $this->ihitsPurchaseToken($_POST['moum_id']);
                    $this->session->set_flashdata('app_success', 'MOU approved successfully!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't approved MOU!");
               }
               redirect(strtolower(__CLASS__));
          } else {
               $states = [18, 0];
               $data['datas'] = $this->mou->getMouById($mid);
               $data['color'] = $this->evaluation->getColors();
               $data['identComponent'] = unserialize(MOU_VEH_IDENT_COMPONENTS);
               $data['districts'] = $this->registration->getDistricts($states);
               $data['purchaseStaff'] = $this->mou->getPurchaseStaff();
               $data['brand'] = $this->enquiry->getBrands();
               $data['model'] = $this->enquiry->getModelByBrand($data['datas']['master']['moum_brand']);
               $data['variant'] = $this->enquiry->getVariantByModel($data['datas']['master']['moum_model']);
               $data['division'] = $this->divisions->getActiveData();
               $data['company'] = $this->mou->getCompany();
               $data['showroom'] = $this->registration->getShowRoomByDivision($data['datas']['master']['moum_division']);
               $this->render_page(strtolower(__CLASS__) . '/approve', $data);
          }
     }

     function delete($id)
     {
          if ($this->mou->delete($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'MOU successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete row"));
          }
     }
     function alreadyExists()
     {
          if ($this->mou->alreadyExists($this->input->post()) == 1) {
               echo json_encode(array('status' => 'success', 'msg' => 'MOU already created'));
          }
     }
}
