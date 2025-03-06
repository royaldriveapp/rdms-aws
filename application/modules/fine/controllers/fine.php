<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class fine extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Vehicle Fine';
            $this->load->model('fine_model', 'fine');
            $this->load->model('ihits_api/ihits_api_model', 'ihits_api_model');
       }

       public function index() {
            $data['fines'] = $this->fine->read();
            //debug($data);
            $this->render_page(strtolower(__CLASS__) . '/list', $data);
       }

       public function add() {
            if (!empty($_POST)) {
                 if ($this->fine->create($_POST)) {
                    
                      $this->session->set_flashdata('app_success', 'Brand successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Brand!");
                 }
                 redirect(strtolower(__CLASS__));
            } else {
                 $data['stocks'] = $this->fine->getStockes();
                 $this->render_page(strtolower(__CLASS__) . '/add', $data);
            }
       }

       public function edit($id) {
          $id = encryptor($id, 'D');
          $data['data'] = $this->fine->read($id);
          $data['stocks'] = $this->fine->getStockes();
          $this->render_page(strtolower(__CLASS__) . '/edit', $data);
     }

       public function view($id) {
            $id = encryptor($id, 'D');
            $data['data'] = $this->fine->read($id);
            $this->render_page(strtolower(__CLASS__) . '/view', $data);
       }

       public function update() { 
            if ($this->fine->update($_POST)) {
                 $this->session->set_flashdata('app_success', 'Brand successfully updated!');
            } else {
                 $this->session->set_flashdata('app_error', "Can't add Brand!");
            }
            redirect(strtolower(__CLASS__));
       }

      // FineController.php

      public function delete($id)
      {
      
          if ($this->fine->delete($id)) {
              echo json_encode(array('status' => 'success'));
          } else {
              echo json_encode(array('status' => 'error'));
          }
      }

public function delete_fine_dtls()
{
    $fineId = $this->input->post('fine_id'); // Get the fine ID from the AJAX request

    if ($this->fine->delete_fine_detail($fineId)) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
}

  }