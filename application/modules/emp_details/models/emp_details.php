<?php

defined('BASEPATH') or exit('No direct script access allowed');

class emp_details extends App_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->page_title = 'New employe';
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('emp_details_model', 'emp_details');
          $this->load->model('designation/designation_model', 'designation');
          $this->load->model('departments/departments_model', 'departments');
          $this->load->model('user_permission/user_permission_model', 'user_permission');
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('divisions/divisions_model', 'divisions');
     }
     function pendingapp()
     {
          $this->render_page(strtolower(__CLASS__) . '/newstaff');
     }
     function pendingappAjax()
     {
          $response = $this->emp_details->getNewStaffRequest($this->input->post());
          echo json_encode($response);
     }

     public function index()
     {
          $data['designation'] = $this->designation->getData();
          $data['division'] = $this->divisions->getActiveData();
          $data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }
     public function list_ajax()
     {
          $response = $this->emp_details->getUsersPaginate($this->input->post(), $this->input->get());
          echo json_encode($response);
     }
     function add()
     {
          if (!empty($_POST)) {
               generate_log(array(
                    'log_title' => 'ssssssss',
                    'log_desc' => serialize($_POST),
                    'log_controller' => 'new-division',
                    'log_action' => 'C',
                    'log_ref_id' => 1,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               if (isset($_FILES['usr_avatar']['name'])) {
                    $this->load->library('upload');
                    $newFileName = rand(9999999, 0) . clean_image_name($_FILES['usr_avatar']['name']);
                    $config['upload_path'] = './assets/uploads/avatar/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['file_name'] = $newFileName;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('usr_avatar')) {
                         $uploadData = $this->upload->data();
                         $_POST['usr_avatar'] = $uploadData['file_name'];
                    }
               }
               if ($this->emp_details->register($_POST)) {
                    $this->session->set_flashdata('app_success', 'Row successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', 'Row successfully added!');
               }
               redirect(strtolower(__CLASS__));
          } else {
               $data['designationOld'] = $this->designation->getDataOld();
               $data['designation'] = $this->designation->getData();
               $data['departments'] = $this->departments->getData();
               $data['group'] = $this->ion_auth->groups()->result_array();
               $data['showroom'] = $this->showroom->getData(0, array(1, 2));
               $defaultShowroom = isset($data['showroom']['0']['shr_id']) ? $data['showroom']['0']['shr_id'] : 0;
               $data['teamLeads'] = $this->emp_details->getTeamLeads($defaultShowroom);
               $data['roles'] = $this->user_permission->getRole();
               $this->render_page(strtolower(__CLASS__) . '/add', $data);
          }
     }

     function view($id)
     {
          $id = encryptor($id, 'D');
          $data['designationOld'] = $this->designation->getDataOld();
          $data['designation'] = $this->designation->getData();
          $data['departments'] = $this->departments->getData();
          $data['group'] = $this->ion_auth->groups()->result_array();
          $data['showroom'] = $this->showroom->getData(0, array(1, 2));
          $data['userDetails'] = $this->ion_auth->user($id)->row_array();
          $data['user_group'] = $this->ion_auth->get_users_groups($id)->row_array();
          $defaultShowroom = isset($data['userDetails']['usr_showroom']) ? $data['userDetails']['usr_showroom'] : 0;
          $data['teamLeads'] = $this->emp_details->getTeamLeads($defaultShowroom);
          $data['currDesignation'] = isset($data['user_group']['id']) ? $data['user_group']['id'] : 0;
          $data['grades'] = $this->emp_details->bindDesignationGrades($data['currDesignation']);
          $data['districts'] = $this->common_model->getDistricts();
          $data['roles'] = $this->user_permission->getRole();
          $this->render_page(strtolower(__CLASS__) . '/view', $data);
     }

     function update()
     {
          if (isset($_FILES['usr_avatar']['name'])) {
               $this->load->library('upload');
               $newFileName = rand(9999999, 0) . clean_image_name($_FILES['usr_avatar']['name']);
               $config['upload_path'] = './assets/uploads/avatar/';
               $config['allowed_types'] = 'jpg|jpeg|png';
               $config['file_name'] = $newFileName;
               $this->upload->initialize($config);
               if ($this->upload->do_upload('usr_avatar')) {
                    $uploadData = $this->upload->data();
                    $_POST['usr_avatar'] = $uploadData['file_name'];
               }
          }
          if ($this->emp_details->update($_POST)) {
               $this->session->set_flashdata('app_success', 'Row successfully updated!');
          } else {
               $this->session->set_flashdata('app_error', 'Row successfully updated!');
          }
          redirect(strtolower(__CLASS__));
     }

     function updateProfile($id = '')
     {
          if (!empty($_POST)) {
               if (isset($_FILES['usr_avatar']['name'])) {
                    $this->load->library('upload');
                    $newFileName = rand(9999999, 0) . clean_image_name($_FILES['usr_avatar']['name']);
                    $config['upload_path'] = './assets/uploads/avatar/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['file_name'] = $newFileName;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('usr_avatar')) {
                         $uploadData = $this->upload->data();
                         $_POST['usr_avatar'] = $uploadData['file_name'];
                    }
               }
               if ($this->emp_details->update($_POST)) {
                    $this->session->set_flashdata('app_success', 'Row successfully updated!');
               } else {
                    $this->session->set_flashdata('app_error', 'Row successfully updated!');
               }
               redirect(__CLASS__ . '/updateProfile/' . encryptor($_POST['usr_id']));
          } else {
               $id = encryptor($id, 'D');
               $data['userDetails'] = $this->ion_auth->user($id)->row_array();
               $data['user_group'] = $this->ion_auth->get_users_groups($id)->row_array();
               $data['districts'] = $this->common_model->getDistricts();
               $this->render_page(strtolower(__CLASS__) . '/update_profile', $data);
          }
     }

     function delete($id)
     {
          $this->ion_auth->deactivate($id);
          echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deactivated'));
     }

     function salesExecutivesByShowroom()
     {
          $showroomId = isset($_POST['id']) ? $_POST['id'] : 0;
          echo json_encode($this->emp_details->salesExecutivesByShowroom($showroomId));
     }

     function getTeamLeads()
     {
          echo json_encode($this->emp_details->getTeamLeads($this->input->post('showroom')));
     }

     /**
      * Change employee status
      * @param type $userId
      * Author : jk
      */
     function changeuserstatus($userId)
     {
          $userId = encryptor($userId, 'D');
          $ischecked = isset($_POST['ischecked']) ? $_POST['ischecked'] : 0;
          if ($this->common_model->changeStatus($userId, $ischecked, 'users', 'usr_active', 'usr_id')) {
               $logMessage = ($ischecked == 1) ? 'User status activated' : 'User status de-activated';
               generate_log(array(
                    'log_title' => 'Status changed',
                    'log_desc' => $logMessage,
                    'log_controller' => 'user-status-changed',
                    'log_action' => 'U',
                    'log_ref_id' => $userId,
                    'log_added_by' => $this->uid
               ));

               $msg = ($ischecked == 1) ? "Activated this record successfully" : "De-activated this record successfully";
               die(json_encode(array('status' => 'success', 'msg' => $msg)));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => "Error occured")));
          }
     }

     function canautoassign($userId)
     {
          $userId = encryptor($userId, 'D');
          $ischecked = isset($_POST['ischecked']) ? $_POST['ischecked'] : 0;
          if ($this->common_model->changeStatus($userId, $ischecked, 'users', 'usr_can_auto_assign', 'usr_id')) {
               $logMessage = ($ischecked == 1) ? 'User added as auto assign' : 'User removed as auto assign';
               generate_log(array(
                    'log_title' => 'Auto assign',
                    'log_desc' => $logMessage,
                    'log_controller' => 'user-auto-assign',
                    'log_action' => 'U',
                    'log_ref_id' => $userId,
                    'log_added_by' => $this->uid
               ));
               die(json_encode(array('status' => 'success', 'msg' => 'Row updated successfully')));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => "Error occured")));
          }
     }

     function bindDesignationGrades()
     {
          $id = $_POST['id'];
          $grades = $this->emp_details->bindDesignationGrades($id);
          echo json_encode($grades);
     }

     function teleCallers()
     {
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               ->where(array($this->tbl_groups . '.grp_slug' => 'TC'))->where(array($this->tbl_users . '.usr_active' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
     }

     function myReportingStaff()
     {
          return $this->db->select($this->tbl_users . '.usr_id, ' . $this->tbl_users . '.usr_username')
               ->get_where($this->tbl_users, array('usr_tl' => $this->uid))->result_array();
     }

     function excelload()
     {
          if (!empty($_FILES)) {
               $this->load->library("excel");
               $objPHPExcel = new PHPExcel();

               $this->load->library('upload');
               $newFileName = rand(9999999, 0) . clean_image_name($_FILES['uploadDocument']['name']);
               $config['upload_path'] = '../';
               $config['allowed_types'] = 'xls|xlsx';
               $config['file_name'] = $newFileName;
               $this->upload->initialize($config);
               if ($this->upload->do_upload('uploadDocument')) {
                    $uploadData = $this->upload->data();
                    $fileName = $uploadData['full_path'];

                    $inputFileType = PHPExcel_IOFactory::identify($fileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objReader->setReadDataOnly(true);
                    $objPHPExcel = $objReader->load($fileName);
                    $allDataInSheet = array_filter($objPHPExcel->getActiveSheet()->toArray(null, true, true, true));
                    foreach ($allDataInSheet as $key => $value) {
                         $ud = $this->db->select('usr_id, usr_emp_code, usr_username')->get_where('cpnl_users', array('usr_emp_code' => trim($value['B'])))->row_array();
                         $designation = $this->db->select('desig_id')->like('desig_title', trim(strtolower($value['D'])), 'both')->get('cpnl_designation')->row_array();
                         $msts = (strtolower($value['Q']) == 'married') ? 1 : 0;
                         $value['O'] = !empty($value['O']) ? $value['O'] : 0;
                         if (!empty($value['H'])) { //DOJ
                              $excel_date = $value['H'];
                              $unix_date = ($excel_date - 25569) * 86400;
                              $excel_date = 25569 + ($unix_date / 86400);
                              $mrg = ($excel_date - 25569) * 86400;
                              $arrayUpdate['usr_doj'] = gmdate("Y-m-d", $mrg);
                         }
                         if (!empty($value['J'])) { //DOB
                              $excel_date = $value['J'];
                              $unix_date = ($excel_date - 25569) * 86400;
                              $excel_date = 25569 + ($unix_date / 86400);
                              $mrg = ($excel_date - 25569) * 86400;
                              $arrayUpdate['usr_dob'] = gmdate("Y-m-d", $mrg);
                         }
                         if (!empty($value['T'])) {  //Marriage anniversay Date
                              $excel_date = $value['T'];
                              $unix_date = ($excel_date - 25569) * 86400;
                              $excel_date = 25569 + ($unix_date / 86400);
                              $mrg = ($excel_date - 25569) * 86400;
                              $arrayUpdate['usr_marriage_date'] = gmdate("Y-m-d", $mrg);
                         }
                         if (strtolower(trim($value['G'])) == 'cochin') {
                              $arrayUpdate['usr_showroom'] = 4;
                         } else if (strtolower(trim($value['G'])) == 'kozhikode') {
                              $arrayUpdate['usr_showroom'] = 2;
                         } else {
                              $arrayUpdate['usr_showroom'] = 1;
                         }
                         $arrayUpdate['usr_designation_new'] = isset($designation['desig_id']) ? $designation['desig_id'] : 0;
                         $arrayUpdate['usr_emp_code'] = trim($value['B']);
                         $arrayUpdate['usr_username'] = trim($value['C']);
                         $arrayUpdate['usr_city'] = '';
                         $arrayUpdate['usr_address'] = trim($value['M']);
                         $arrayUpdate['usr_address1'] = trim($value['N']);
                         $arrayUpdate['usr_mobile_personal'] = trim($value['O']);
                         $arrayUpdate['usr_emergency_no'] = trim($value['P']);
                         $arrayUpdate['usr_spouse_name'] = trim($value['R']);
                         $arrayUpdate['usr_father_name'] = trim($value['S']);
                         $arrayUpdate['usr_marital_status'] = $msts;
                         $arrayUpdate['usr_edu_quali'] = trim($value['U']);
                         $arrayUpdate['usr_tech_quali'] = trim($value['V']);
                         $arrayUpdate['usr_previous_exp'] = trim($value['W']);
                         $arrayUpdate['usr_industry_exp'] = trim($value['X']);
                         $arrayUpdate['usr_bank_acc_no'] = trim($value['Y']);
                         $arrayUpdate['usr_bank_ifsc'] = trim($value['Z']);
                         $arrayUpdate['usr_phone'] = trim($value['AG']);
                         $arrayUpdate['usr_whatsapp'] = trim($value['AG']);
                         if (empty($ud)) {
                              $this->db->insert('cpnl_users', $arrayUpdate);
                         } else if (isset($ud['usr_id'])) { //Update
                              $this->db->where('usr_id', $ud['usr_id'])->update('cpnl_users', $arrayUpdate);
                         }
                    }
                    redirect(strtolower(__CLASS__) . '/newstaffrequest');
               } else {
                    debug($this->upload->display_errors());
               }
          } else {
               $this->render_page(strtolower(__CLASS__) . '/excelload');
          }
     }

     function newstaffrequest()
     {
          if (!empty($_POST)) {
               if (isset($_FILES['usr_avatar']['name'])) {
                    $this->load->library('upload');
                    $newFileName = rand(9999999, 0) . clean_image_name($_FILES['usr_avatar']['name']);
                    $config['upload_path'] = './assets/uploads/avatar/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['file_name'] = $newFileName;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('usr_avatar')) {
                         $uploadData = $this->upload->data();
                         $_POST['usr_avatar'] = $uploadData['file_name'];
                    }
               }
               if ($this->emp_details->staffRegisterRequest($_POST)) {
                    $this->session->set_flashdata('app_success', 'Row successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', 'Row successfully added!');
               }
               redirect(strtolower(__CLASS__) . '/newstaffrequest');
          } else {
               $data['upcomClib'] = $this->emp_details->upcomingCelebrations();
               $data['designationOld'] = $this->designation->getDataOld();
               $data['designation'] = $this->designation->getData();
               $data['departments'] = $this->departments->getData();
               //  $data['employeMaster'] = $this->emp_details->getStaffMaster();
               $data['districts'] = $this->common_model->getDistricts();
               $data['group'] = $this->ion_auth->groups()->result_array();
               $data['showroom'] = $this->showroom->getData(0, array(1, 2, 3));
               $data['extensions'] = $this->emp_details->getExtensions();
               $data['designation'] = $this->designation->getData();
               $data['division'] = $this->divisions->getActiveData();
               //$data['showroom'] = $this->enquiry->bindShowroomByDivision($this->input->get('vreg_division'));
               $this->render_page(strtolower(__CLASS__) . '/newstaffrequest', $data);
          }
     }
     function newstaffrequestAjax()
     {
          $response = $this->emp_details->getStaffMasterPaginate($this->input->post(), $this->input->get());
          echo json_encode($response);
     }
     function quickupdate($id = 0)
     {
          if (!empty($_POST)) {
               if ($this->emp_details->staffQuickupdate($_POST)) {
                    $this->session->set_flashdata('app_success', 'Row successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', 'Row successfully added!');
               }
               redirect(strtolower(__CLASS__) . '/newstaffrequest');
          }
          $id = encryptor($id, 'D');
          $data['designationOld'] = $this->designation->getDataOld();
          $data['designation'] = $this->designation->getData();
          $data['departments'] = $this->departments->getData();
          $data['group'] = $this->ion_auth->groups()->result_array();
          $data['showroom'] = $this->showroom->getData(0, array(1, 2));
          $data['userDetails'] = $this->ion_auth->user($id)->row_array();
          $data['user_group'] = $this->ion_auth->get_users_groups($id)->row_array();
          $defaultShowroom = isset($data['userDetails']['usr_showroom']) ? $data['userDetails']['usr_showroom'] : 0;
          $data['teamLeads'] = $this->emp_details->getTeamLeads($defaultShowroom);
          $data['currDesignation'] = isset($data['user_group']['id']) ? $data['user_group']['id'] : 0;
          $data['grades'] = $this->emp_details->bindDesignationGrades($data['currDesignation']);
          $data['districts'] = $this->common_model->getDistricts();
          $this->render_page(strtolower(__CLASS__) . '/view_all_details', $data);
     }
     //target
     public function staff_target($category = 1)
     {
          $data['allShowrooms'] = $this->showroom->getData(0, array(1, 2));
          $shrm = !empty($_GET['showroom']) ? $_GET['showroom'] : 1;
          $data['showroom'] = $shrm;
          $data['users'] = $this->emp_details->getSaleStaffs($shrm);
          $data['trgt_category'] = $category;
          $this->render_page(strtolower(__CLASS__) . '/staff_target_list', $data);
     }
     public function storeTargets()
     {
          if ($this->emp_details->storeTargets($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }
     //@target

     /**
      * Resignation of staff {jk}{13.7.23}
      */

     function resignation()
     {
          if ($this->emp_details->resignation($_POST)) {
               die(json_encode(array('status' => 'success', 'msg' => 'Row updated successfully')));
          } else {
               die(json_encode(array('status' => 'fail', 'msg' => "Error occured")));
          }
     }
}
