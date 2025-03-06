<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class showroom extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Showroom';
            $this->load->library('form_validation');
            $this->load->model('showroom_model', 'showroom');
            $this->load->model('divisions/divisions_model', 'divisions');
       }

       public function index() {
            $accessories['data'] = $this->showroom->getData();
            $this->render_page(strtolower(__CLASS__) . '/list', $accessories);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->showroom->addData($_POST)) {
                      $this->session->set_flashdata('app_success', 'showroom successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add showroom!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['divisions'] = $this->divisions->getData();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function view($id) {
            $data['divisions'] = $this->divisions->getData();
            $data['data'] = $this->showroom->getData($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->showroom->updateData($_POST)) {
                 $this->session->set_flashdata('app_success', 'Update successfully!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->showroom->deleteData($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Delete successfully'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete"));
            }
       }

  }
  