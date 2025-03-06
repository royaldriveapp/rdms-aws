<?php

  defined('BASEPATH') or exit('No direct script access allowed');

  class color extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model('color_model', 'model');
       }

       public function index() {
         
          $this->render_page(strtolower(__CLASS__) . '/index');
     }
     function index_ajax()
     { 
          $response = $this->model->getDataPaginate($this->input->post());
          echo json_encode($response);
     }

       public function update($id = '') {
            if (!empty($_POST)) {
                 if ($this->model->update($_POST)) {
                      $this->session->set_flashdata('app_success', 'Color successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Color!");
                 }
                 redirect(strtolower(__CLASS__));
            } elseif ($id) {
                 $id = encryptor($id, 'D');
                 $data['vc_id'] = $id;
                 $data['item'] = $this->model->selectData($id);
                 $this->render_page(strtolower(__CLASS__) . '/edit', $data);
            }
       }

       public function delete($id) {
            if ($this->model->delete($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Color successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete Color"));
            }
       }

       public function add() {
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

  }
  