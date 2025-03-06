<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class inquiry_schedule extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Inquiry schedule';
            $this->load->library('form_validation');
            $this->load->model('designation/designation_model', 'designation');
            $this->load->model('inquiry_schedule_model', 'inquiry_schedule');
       }

       public function index() {
            $accessories['data'] = $this->inquiry_schedule->getData();
            $this->render_page(strtolower(__CLASS__) . '/list', $accessories);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->inquiry_schedule->addData($_POST)) {
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
            $data['designation'] = $this->designation->getData();
            $data['data'] = $this->inquiry_schedule->getData($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->inquiry_schedule->updateData($_POST)) {
                 $this->session->set_flashdata('app_success', 'Update successfully!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->inquiry_schedule->deleteData($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Delete successfully'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete"));
            }
       }

  }
  