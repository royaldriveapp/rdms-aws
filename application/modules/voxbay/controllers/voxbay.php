<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class voxbay extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Voxbay';
            $this->load->model('voxbay_model', 'voxbay');
       }

       public function index() {
            $this->render_page(strtolower(__CLASS__) . '/listallcalls');
       }
       
       public function invCallList() {
            $this->render_page(strtolower(__CLASS__) . '/listinvcalls');
       }
     
       public function fetchData() {
            $response = $this->voxbay->getAllCalls($this->input->post());
            echo json_encode($response);
       }
       
       public function pendingCalls() {
            $this->render_page(strtolower(__CLASS__) . '/voxbay-pend-cal');
       }
       
       public function pendingCallsAjax() {
            $response = $this->voxbay->pendingCalls($this->input->post());
            echo json_encode($response);
       }
       
       public function calllog($phnumber) {
            $data['data'] = $this->voxbay->calllog($phnumber);
            $this->render_page(strtolower(__CLASS__) . '/calllog', $data);
       }
       
       function allconnectedcall() {
             $this->render_page(strtolower(__CLASS__) . '/allconnectedcall');
       }
       
       function allconnectedcall_ajax() {
            $this->page_title = 'Voxbay all connected calls';
            $response = $this->voxbay->getAllConnectedCall($this->input->post());
            echo json_encode($response);
       }

       function outboundByNumber($number) {
            $number = substr($number, -10);
            $response['data'] = $this->voxbay->getOutboundByNumber($number);
            $this->render_page(strtolower(__CLASS__) . '/outboundlist', $response);
       }

       function allconnectedincall() {
            $data['staff'] = $this->voxbay->getStaffs();
            $this->render_page(strtolower(__CLASS__) . '/allconnectedincall', $data);
       }

       function allconnectedincall_ajax() {
            $this->page_title = 'Voxbay all connected calls';
            $response = $this->voxbay->getAllConnectedInCall($this->input->post());
            echo json_encode($response);
       }
          
       function allconnectedoutcall() {
            $data['staff'] = $this->voxbay->getStaffs();
            $this->render_page(strtolower(__CLASS__) . '/allconnectedoutcall', $data);
       }

       function allconnectedoutcall_ajax() {
            $this->page_title = 'Voxbay all connected calls';
            $response = $this->voxbay->getAllConnectedOutCall($this->input->post());
            echo json_encode($response);
       }
  } 