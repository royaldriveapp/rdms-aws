<?php

use AWS\CRT\HTTP\Response;

  defined('BASEPATH') OR exit('No direct script access allowed');

  class lms extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Events';
            $this->load->library('form_validation');
            $this->load->model('lms_model', 'lms');
            $this->load->model('divisions/divisions_model', 'divisions');
       }

       public function list_funnel_master() {
          //  $data['datas'] = $this->lms->getFunnelMaster();
            $this->render_page(strtolower(__CLASS__) . '/list_funnel_master');
       }
       
       public function list_funnel_master_ajax()
       {
            $response = $this->lms->getFunnelMasterPaginate($this->input->post());
           //   debug( $response);
            echo json_encode($response);
       }

       public function edit_funnel_master($id){
       //  debug($id);
          $response['data'] = $this->lms->editFunnelMaster($id);
      //    debug($response);
          $this->render_page(strtolower(__CLASS__) . '/edit_funnel_master', $response);
       }
       public function update_funnel_master(){
          // Check if the form is submitted
         // debug($_POST);
          if ($_POST) {
              // Retrieve the form data
              $form_data = array(
                  'sfnl_funnel' =>$_POST['sfnl_funnel'],
                  'sfnl_status' => $_POST['sfnl_status'] ? 1 : 0 // Convert checkbox value to 0 or 1
              );
      
              // Assuming you have a model function to update the record in the database, let's call it updateFunnelMaster
              $update_result = $this->lms->updateFunnelMaster($_POST['id'],$form_data,);
      
              if ($update_result) {
                  // Update successful, redirect to a success page or show a success message
                  redirect(strtolower(__CLASS__) . '/list_funnel_master');
              } 
          } 
      }

      public function delete_funnel_master($id) {
          if ($this->lms->deleteFunnelMater($id)) {
               redirect(strtolower(__CLASS__) . '/list_funnel_master');
          } 
     }

       public function lmsReport() {
          $filert=array();
          $filert=$_GET;
          $data['funnels'] = $this->lms->getFunnelMasters();
          $data['sources'] = $this->lms->getSourceMasters();
          $data['campaigns'] = $this->lms->getCampaignMaster(); //debug( $data['campaigns']);
        $data['reports'] = $this->lms->fetchLmsReport($filert);
         // debug(  $data['reports']);
      
         $this->render_page(strtolower(__CLASS__) . '/report', $data);
        

       }

       public function create_funnel_master() {
            if (!empty($_POST)) {
               $_POST['sfnl_status']= $_POST['sfnl_status'] ? 1 : 0 ;
                 if ($this->lms->createFunnelMaster($_POST)) {
                      $this->session->set_flashdata('app_success', 'Brand successfully added!');
                 } else {
                      $this->session->set_flashdata('app_error', "Can't add Brand!");
                 }
                // redirect(strtolower(__CLASS__));
                $this->render_page(strtolower(__CLASS__) . '/create_funnel_master');
            } else {
                 $this->render_page(strtolower(__CLASS__) . '/create_funnel_master');
            }
       }
       
     //   Source Master //
       public function create_source_master() {
          $data['funnelMasters'] = $this->lms->getFunnelMasters();
          if (!empty($_POST)) {
               if ($this->lms->createSourceMaster($_POST)) {
                    $this->session->set_flashdata('app_success', 'Brand successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Brand!");
               }
              $this->render_page(strtolower(__CLASS__) . '/create_source_master',$data);
          } else {
               
              
               $this->render_page(strtolower(__CLASS__) . '/create_source_master',$data);
          }
     }
     public function list_source_master() {
          //  $data['datas'] = $this->lms->getFunnelMaster();
            $this->render_page(strtolower(__CLASS__) . '/list_source_master');
       }
       
       public function list_source_master_ajax()
       {
            $response = $this->lms->getSourceMasterPaginate($this->input->post());
         //  debug( $response);
            echo json_encode($response);
       }

       public function edit_source_master($id){
          $response['funnelMasters'] = $this->lms->getFunnelMasters();
          //  debug($id);
             $response['data'] = $this->lms->editSourceMaster($id);
        // debug($response);
             $this->render_page(strtolower(__CLASS__) . '/edit_source_master', $response);
          }
        

          public function update_source_master() {
               // Get the form data
               $id = $this->input->post('id');
              // debug($id);
             // $_POST['sfnl_status'] ? 1 : 0;
             $j=$this->input->post('cmd_status') == '1' ? 1 : 0;
            // debug($j);
               $data = array(
                   'cmd_title' => $this->input->post('cmd_title'),
                   'cmd_funnel' => $this->input->post('cmd_funnel'),
                   'cmd_status' =>  $this->input->post('cmd_status') == '1' ? 1 : 0
               );
           
               // Call the model method to update the record
               $success = $this->lms->updateSourceMaster($id, $data);
           
               if ($success) {
                    redirect(strtolower(__CLASS__) . '/list_source_master');
               } else {
                   // Redirect back to the edit form with an error message
               }
           }
           

         

         public function delete_source_master($id) {
          if ($this->lms->deleteSourceMater($id)) {
               redirect(strtolower(__CLASS__) . '/list_source_master');
          } 
     }
     //End Source Master

     //Campain master


     public function create_campaign_master() {
          $data['sources'] = $this->lms->getSourceMasters();
          $data['division'] = $this->divisions->getActiveData();
          if (!empty($_POST)) {
               if ($this->lms->createCampaignMaster($_POST)) {
                    $this->session->set_flashdata('app_success', 'Brand successfully added!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't add Brand!");
               }
              $this->render_page(strtolower(__CLASS__) . '/create_campaign_master',$data);
          } else {
               
              
               $this->render_page(strtolower(__CLASS__) . '/create_campaign_master',$data);
          }
     }

     public function list_campaign_master() {
          //  $data['datas'] = $this->lms->getFunnelMaster();
            $this->render_page(strtolower(__CLASS__) . '/list_campaign_master');
       }
       
       public function list_campaign_master_ajax()
       {
            $response = $this->lms->getCampaignMasterPaginate($this->input->post());
           //   debug( $response); exit;
            echo json_encode($response);
       }

       public function edit_campaign_master($id){
          $response['sources'] = $this->lms->getSourceMasters();
          $response['division'] = $this->divisions->getActiveData();
          //  debug($id);
             $response['data'] = $this->lms->editCampaignMaster($id);
        //debug($response);
             $this->render_page(strtolower(__CLASS__) . '/edit_campaign_master', $response);
          }
   // Inside your controller file (e.g., Lms.php)

public function update_campaign_master() {
     // Check if the form is submitted
     if ($this->input->post()) {
         // Get the form data
         $data = array(
             'evnt_title' => $this->input->post('evnt_title'),
             'evnt_source' => $this->input->post('evnt_source'),
             'evnt_date' => date('Y-m-d', strtotime($this->input->post('evnt_date'))),
             'evnt_end_date' => date('Y-m-d', strtotime($this->input->post('evnt_end_date'))),
             'evnt_division' => $this->input->post('vreg_division'),
             'evnt_showroom' => $this->input->post('vreg_showroom'),
             'evnt_status' => $this->input->post('evnt_status') ? 1 : 0 // Check if the checkbox is checked
         );
 
         // Get the ID of the campaign master to update
         $id = $this->input->post('id');

        
         $result = $this->lms->updateCampaignMaster($id, $data);
 
         if ($result) {
            
             $this->render_page(strtolower(__CLASS__) . '/list_campaign_master');
         } else {
             // Error occurred while updating
             // Show an error message
             echo "Error updating campaign master";
         }
     } 
 }
 public function delete_campaign_master($id) {
     if ($this->lms->deleteCampaignMater($id)) {
          $this->render_page(strtolower(__CLASS__) . '/list_campaign_master');
     } 
}

       function bindCampaignBySoure()
       {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                 $data = $this->lms->bindCampaignBySoure($_POST['id']);
                 echo json_encode($data);
            }
       }


  }
  