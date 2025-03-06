<?php

defined('BASEPATH') or exit('No direct script access allowed');

class user_permission extends App_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->body_class[] = 'skin-blue';
          $this->load->model('user_permission_model');
     }

     function access_denied()
     {
          $this->render_page(strtolower(__CLASS__) . '/nop');
     }

     public function index()
     {
          if (is_roo_user()) {
               $data['designations'] = $this->user_permission_model->getAllUserGroups();
               $data['modules'] = $this->config->item('modules');
               $this->render_page(strtolower(__CLASS__) . '/index', $data);
          } else {
               redirect(strtolower(__CLASS__) . '/access_denied');
          }
     }
 function setPermission()
     {
          $this->user_permission_model->addUserPermission($this->input->post());
          $this->session->set_flashdata('app_success', 'User permission successfully completed!');
          redirect(strtolower(__CLASS__));
     }

     function getPermission()
     {
          $userpermission = $this->user_permission_model->getUserPermission($this->input->post('userid'));
          $permissionArray['permissions'] = array();
          if (isset($userpermission['cua_access']) && !empty($userpermission['cua_access'])) {
               $tmp = unserialize($userpermission['cua_access']);
               if (!empty($tmp) && is_array($tmp)) {
                    foreach ($tmp as $k => $v) {
                         foreach ($v as $l => $w) {
                              array_push($permissionArray['permissions'], $k . '-' . $w);
                         }
                    }
               }
          }
          echo json_encode($permissionArray);
     }
     /*Role and permission*/
     public function create_role()
     {//jsk
          if (is_roo_user()) {
               $data['roles'] = $this->user_permission_model->getRole();
               $data['modules'] = $this->config->item('modules');
               $this->render_page(strtolower(__CLASS__) . '/add_role', $data);
          } else {
               redirect(strtolower(__CLASS__) . '/access_denied');
          }
     }
     public function edit_role() {//jsk
          if (is_roo_user()) {
               $data['roles'] = $this->user_permission_model->getRole();
               $data['modules'] = $this->config->item('modules');
               $this->render_page(strtolower(__CLASS__) . '/edit_role', $data);
          } else {
               redirect(strtolower(__CLASS__) . '/access_denied');
          }
     }
     function addRole() {//jsk
          $this->user_permission_model->addRole($this->input->post());
              if($this->input->post('rol_id')){
      $this->session->set_flashdata('app_success', 'Role And Permission Updated successfully!');
        redirect(strtolower(__CLASS__) . '/edit_role');
  } else {
   $this->session->set_flashdata('app_success', 'Role created successfully!');
redirect(strtolower(__CLASS__).'/create_role'); 
  }
}

function getRolePermission() {//jsk
$userpermission = $this->user_permission_model->getRolePermission($this->input->post('roleid'));
$permissionArray['permissions'] = array();
if (isset($userpermission['rol_access']) && !empty($userpermission['rol_access'])) {
     $tmp = unserialize($userpermission['rol_access']);
     if (!empty($tmp) && is_array($tmp)) {
          foreach ($tmp as $k => $v) {
               foreach ($v as $l => $w) {
                    array_push($permissionArray['permissions'], $k . '-' . $w);
               }
          }
     }
}
echo json_encode($permissionArray);
}
/*@Role and permission*/
}
