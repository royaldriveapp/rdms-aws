<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class welcomekit extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Welcome kit';
            $this->load->library('form_validation');
            $this->load->model('welcomekit_model', 'welcomekit');
       }

       public function index() {
            $data['datas'] = $this->welcomekit->read();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->welcomekit->create($_POST)) {
                      $this->session->set_flashdata('app_success', 'New welcome kit successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add welcome kit!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/add');
            }
       }

       public function view($id) {
            $id = encryptor($id, 'D');
            $data['data'] = $this->welcomekit->read($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->welcomekit->update($_POST)) {
                 $this->session->set_flashdata('app_success', 'Welcome kit successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add welcome kit!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->welcomekit->delete($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Welcome kit successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete welcome kit"));
            }
       }
  } 