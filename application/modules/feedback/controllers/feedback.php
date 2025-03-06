<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class feedback extends App_Controller {

     public function __construct() {
          parent::__construct();
          $this->body_class[] = 'skin-blue';
          $this->page_title = 'Feedback';
          $this->load->model('feedback_model', 'feedback');
     }

     public function index() {
          $data['all'] = $this->feedback->getAllAppFeedback();
          $data['live'] = $this->feedback->getLiveAppFeedback();
          $this->render_page(strtolower(__CLASS__) . '/list', $data);
     }

     public function view($id) {
          $id = encryptor($id, 'D');
          $data['data'] = $this->feedback->getAllAppFeedback($id);
          $this->render_page(strtolower(__CLASS__) . '/view', $data);
     }

     public function update() {
          if ($this->feedback->updateFeedback($this->input->post())) {
               $this->session->set_flashdata('app_success', 'News successfully updated!');
          } else {
               $this->session->set_flashdata('app_error', "Can't update news!");
          }
          redirect(strtolower(__CLASS__));
     }
}