<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class events extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Events';
            $this->load->library('form_validation');
            $this->load->model('events_model', 'events');
       }

       public function index() {
            $data['datas'] = $this->events->read();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->events->create($_POST)) {
                      $this->session->set_flashdata('app_success', 'Brand successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Brand!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/add');
            }
       }

       public function view($id) {
            $id = encryptor($id, 'D');
            $data['data'] = $this->events->read($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() {
            if ($this->events->update($_POST)) {
                 $this->session->set_flashdata('app_success', 'Brand successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add Brand!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->events->delete($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Brand successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete brand"));
            }
       }

  }
  