<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class questions extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Questions';
            $this->load->model('questions_model', 'questions');
       }

       public function index() {
            $this->page_title = 'Questions';
            $data['questions'] = $this->questions->get();
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->questions->add($_POST)) {
                      $this->session->set_flashdata('app_success', 'Category successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add category!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $this->page_title = 'New questions';
                 $data['order'] = $this->questions->getNextOrder();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function update() {
            if ($this->questions->update($_POST)) {
                 $this->session->set_flashdata('app_success', 'Category successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't update category!");
            }
            redirect(strtolower(__CLASS__));
       }

       public function delete($id) {
            if ($this->questions->delete($id)) {
                 echo json_encode(array('status' => 'success', 'msg' => 'Category successfully deleted'));
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Can't delete category"));
            }
       }

       public function view($id) {
            $id = encryptor($id, 'D');
            $this->page_title = "Edit question";
            $data['order'] = $this->questions->getNextOrder(true);
            $data['question'] = $this->questions->get($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }
  }
  