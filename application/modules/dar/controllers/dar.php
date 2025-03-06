<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class dar extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->page_title = 'DAR';
            $this->load->model('dar_model', 'dar');
            $this->load->model('followup/followup_model', 'followup');
            $this->load->model('reports/reports_model', 'reports');
       }

       public function index() {
           // $data['dar'] = $this->dar->getDarInformation();
            $this->render_page('dar/list');
       }

       function view($darId) {
            $darId = encryptor($darId, 'D');
            $dar = $this->dar->getDarInformation($darId);
            //debug($dar);
            $data['dar'] = isset($dar['0']) ? $dar['0'] : array();
            $this->render_page('dar/view', $data);
       }

       public function submit_dar() {
            $todayDAR = $this->dar->getDarInformation('', true);
            if (empty($todayDAR)) {
                 if ($this->usr_grp == 'TC' || $this->usr_grp == 'SE' || $this->usr_grp == 'TL' || $this->usr_grp == 'MG' || $this->usr_grp == 'EV' || $this->usr_grp == 'DE') {
                      
                      $data['todaysEnquires'] = $this->dar->todaysEnquires();
                      $data['todaysFollowups'] = $this->dar->todaysFollowups();
                      $data['todaysRegistrations'] = $this->dar->todaysRegistrations();
                      $data['todaysRegFollowup'] = $this->dar->todaysRegFollowup();
                      $this->render_page('dar/dar_SE', $data);
                 } else if ($this->usr_grp == 'DE') {
                      $enquires = $this->dar->todaysEnquires();
                      $data['todaysEnquires'] = isset($enquires['enquires']) ? $enquires['enquires'] : array();
                      $data['hwc'] = isset($enquires['hwc']) ? $enquires['hwc'] : array();
                      $data['hwcTotal'] = isset($enquires['hwcTotal']) ? $enquires['hwcTotal'] : array();
                      $this->render_page('dar/dar_SE', $data);
                 }
            } else {
                 $id = isset($todayDAR[0]['darm_id']) ? $todayDAR[0]['darm_id'] : 0;
                 redirect('dar/view/' . encryptor($id));
            }
       }

       function processDar() {
            if ($this->dar->processDar($_POST)) {
                 $this->session->set_flashdata('app_success', 'DAR successfully submitted');
            } else {
                 $this->session->set_flashdata('app_error', 'Error while add DAR!');
            }
            redirect('dar');
       }

       function verifydar($darid = '') {
            if (!empty($_POST)) {
                 $this->dar->verifyByTeamLead($_POST);
                 $darId = isset($_POST['darm_id']) ? $_POST['darm_id'] : '';
                 $this->session->set_flashdata('app_success', 'DAR successfully verified');
//                 redirect('dar/verifydar/' . encryptor($darId));
                 redirect('reports/dar');
            } else {
                 $darid = encryptor($darid, 'D');
                 $dar = $this->dar->getDarInformation($darid);
                 $data['dar'] = isset($dar['0']) ? $dar['0'] : array();
                 $data['dar']['mod_of_contact'] = isset($dar[0]['darm_cnt_mod']) ? unserialize($dar[0]['darm_cnt_mod']) : array();
                 $data['dar']['hwc'] = isset($dar[0]['darm_cnt_status']) ? unserialize($dar[0]['darm_cnt_status']) : array();
                 $data['dar']['type'] = isset($dar[0]['darm_cnt_type']) ? unserialize($dar[0]['darm_cnt_type']) : array();
                 $data['dar']['td_mv'] = isset($dar[0]['darm_cnt_td_mv']) ? unserialize($dar[0]['darm_cnt_td_mv']) : array();
                 $this->render_page('dar/verifydar', $data);
            }
       }

       function verifyDARajax($darid) {
            $status = isset($_POST['status']) ? $_POST['status'] : 0;
            $msg = ($status == 1) ? 'DAR Verified' : 'DAR Un Verified';
            if (!empty($darid)) {
                 if ($this->dar->verifyDAR($darid, $status)) {
                      echo json_encode(array('status' => 'success', 'msg' => $msg));
                 } else {
                      echo json_encode(array('status' => 'fail', 'msg' => "Error occured"));
                 }
            } else {
                 echo json_encode(array('status' => 'fail', 'msg' => "Error occured"));
            }
       }
       public function list() {
          $this->render_page('dar/listAjx');
     }
     function dar_ajax()
     { 
          $response = $this->dar->getDarInformationPaginate($this->input->post());
         // debug($response);
          echo json_encode($response);
     }
  }
  