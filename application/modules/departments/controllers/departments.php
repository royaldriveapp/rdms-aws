<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class departments extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Departments';
            $this->load->library('form_validation');
            $this->load->model('departments_model', 'departments');
            $this->load->model('divisions/divisions_model', 'divisions');
       }

       public function index() {
            $accessories['data'] = $this->departments->getData();
            $this->render_page(strtolower(__CLASS__) . '/list', $accessories);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->departments->addData($_POST)) {
                      $this->session->set_flashdata('app_success', 'Division successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add division!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['divisions'] = $this->divisions->getData();
                 $data['parentDeptment'] = $this->departments->getParentDepartment();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function view($id) {
            $data['data'] = $this->departments->getData($id);
            $data['divisions'] = $this->divisions->getData();
            $data['parentDeptment'] = $this->departments->getParentDepartment();
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->departments->updateData($_POST)) {
                 $this->session->set_flashdata('app_success', 'Update successfully!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->departments->deleteData($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Delete successfully'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete"));
            }
       }

  }
  