<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class grade extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Grade';
            $this->load->library('form_validation');
            $this->load->model('grade_model', 'grade');
            $this->load->model('designation/designation_model', 'designation');
       }

       public function index() {
            $accessories['data'] = $this->grade->getData();
            $this->render_page(strtolower(__CLASS__) . '/list', $accessories);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->grade->addData($_POST)) {
                      $this->session->set_flashdata('app_success', 'Division successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add division!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['designation'] = $this->designation->getData();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function view($id) {
            $data['data'] = $this->grade->getData($id);
            $data['designation'] = $this->designation->getData();
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->grade->updateData($_POST)) {
                 $this->session->set_flashdata('app_success', 'Update successfully!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->grade->deleteData($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Delete successfully'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete"));
            }
       }

  }
  