<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class divisions extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Division';
            $this->load->library('form_validation');
            $this->load->model('divisions_model', 'divisions');
       }

       public function index() {
            $accessories['data'] = $this->divisions->getData();
            $this->render_page(strtolower(__CLASS__) . '/list', $accessories);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->divisions->addData($_POST)) {
                      $this->session->set_flashdata('app_success', 'Division successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add division!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/add');
            }
       }

       public function view($id) {
            $accessories['data'] = $this->divisions->getData($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $accessories);
       }

       public function update() {
            if ($this->divisions->updateData($_POST)) {
                 $this->session->set_flashdata('app_success', 'Update successfully!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->divisions->deleteData($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Delete successfully'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete"));
            }
       }

  }
  