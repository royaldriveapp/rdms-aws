<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class investors extends App_Controller {

     public function __construct() {
          parent::__construct();
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          $this->load->model('investors_model', 'registration');
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $this->load->model('events/events_model', 'events');
          $this->load->model('showroom/showroom_model', 'showroom');
          $this->load->model('divisions/divisions_model', 'divisions');
          $this->load->model('departments/departments_model', 'departments');
          $this->load->model('webenquires/webenquires_model', 'webenquires');
          $this->load->model('followup/followup_model', 'followup');
          $this->load->model('booking/booking_model', 'booking');
     }

     public function index($id = 0) {
          $this->page_title = 'List investers';
          $data['data'] = $this->registration->getInvester($id);
          $this->render_page(strtolower(__CLASS__) . '/investers', $data);
     }

     function webinvestors($id = 0) {
          $data['datas'] = $this->registration->getWebInvestors($id);
          $this->render_page(strtolower(__CLASS__) . '/eventlistener', $data);
     }

     public function newInvestor($voxbayId = 0, $investorId = 0) {
          if (!empty($_POST)) {
               if ($investerId = $this->registration->createLead($_POST)) {
                    $this->session->set_flashdata('app_success', 'Row successfully updated!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't update row!");
               }

               if ($voxbayId > 0) {
                    redirect('investors/newContribution/' . $voxbayId . '/' . $investerId);
               }

               redirect(strtolower(__CLASS__));
          }
          $this->page_title = 'List investers';
          $data['brand'] = $this->enquiry->getBrands();
          $data['districts'] = $this->registration->getDistricts();
          $data['addressProof'] = $this->booking->getActiveAddressProof(1);
          $data['voxBay'] = $voxbayId;
          $data['investor'] = $investorId;
          $data['voxBayDetails'] = $this->registration->getVoxBayDetails($voxbayId);
          $this->render_page(strtolower(__CLASS__) . '/newInvester', $data);
     }

     public function view($id) {
          $this->page_title = 'Edit investor';
          $id = encryptor($id, 'D');
          $data = $this->registration->getInvester($id);
          $data['brand'] = $this->enquiry->getBrands();
          $data['districts'] = $this->registration->getDistricts();
          $data['addressProof'] = $this->booking->getActiveAddressProof(1);
          $data['staff'] = $this->registration->bindAllRdStaffs();
          $this->render_page(strtolower(__CLASS__) . '/editInvestor', $data);
     }

     public function update() {
          if (!empty($_POST)) {
               if ($this->registration->update($_POST)) {
                    $this->session->set_flashdata('app_success', 'Row successfully updated!');
               } else {
                    $this->session->set_flashdata('app_error', "Can't update row!");
               }
               redirect(strtolower(__CLASS__));
          }
     }

     public function delete($id) {
          if ($this->registration->delete($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Row successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete row"));
          }
     }

     function makeInvest($invstrId = 0) {
          if (!empty($_POST)) {
               $this->registration->makeInvest($_POST);
               redirect(strtolower(__CLASS__) . '/makeInvest/' . $_POST['details']['invd_investor']);
          }
          $data = $this->registration->getInvester($invstrId);
          $data['investments'] = $this->registration->getInvestments($invstrId);
          $data['followup'] = $this->registration->getInvestmentFollowup($invstrId);
          $this->render_page(strtolower(__CLASS__) . '/makeInvest', $data);
     }

     function updateFollowup($invester) {
          $newData['datas'] = $this->registration->updateFollowup($_POST, $invester);
          $html = $this->load->view(strtolower(__CLASS__) . '/ajax_commecnt', $newData, true);
          echo json_encode(array('status' => 'success', 'msg' => $html));
     }

     function newContribution($voxbayId = 0, $investorId = 0) {

          if (!empty($_POST)) {
               $this->registration->makeInvest($_POST);
          }

          $data['voxbayDetails'] = $this->registration->getVoxBayDetails($voxbayId);
          $data['investors'] = $this->registration->getInvester();
          $data['voxBay'] = $voxbayId;
          $data['investor'] = $investorId;
          $this->render_page(strtolower(__CLASS__) . '/newContribution', $data);
     }

     function bindToDiv() {
          $data['rand'] = rand(0, 9999999);
          $data['brand'] = $this->enquiry->getBrands();
          $html = $this->load->view(strtolower(__CLASS__) . '/tmp_new_vehicle', $data, true);
          die(json_encode(array('html' => $html)));
     }

     function getAllRdStaffs($id = 0, $json = true) {
          $staffs = $this->registration->bindAllRdStaffs();
          echo json_encode($staffs);
     }

     public function calllog() {
          $this->render_page(strtolower(__CLASS__) . '/listallcalls');
     }

     public function fetchData() {
          $response = $this->registration->getAllCalls($this->input->post());
          echo json_encode($response);
     }
     
     function customerByPhone() {
          $matchingRegister['enq'] = $this->registration->getEnquiryByMobile($this->input->post('phoneNo'));
          if (!empty($matchingRegister['enq'])) {
               echo json_encode(array('status' => 'success',
                   'customer_name' => $matchingRegister['enq']['enq_cus_name'], 'this_customer_enq_id' => $matchingRegister['enq']['enq_id']));
          } else {
               echo json_encode(array('status' => 'failed', 'msg' => 'No records found'));
          }
     }
}