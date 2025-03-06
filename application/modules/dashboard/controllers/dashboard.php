<?php

defined('BASEPATH') or exit('No direct script access allowed');

class dashboard extends App_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->page_title = "Dashboard";
          $this->load->model('dashboard_model', 'dashboard');
          $this->load->model('booking/booking_model', 'booking');
     }

     public function index_old()
     {
          $data['enquiresAnalysis'] = $this->dashboard->countTotalEnquires();
          $data['dashboardMeterials'] = $this->dashboard->dashboardMeterials();
          if (is_roo_user()) {
               $data['vehicleDemandGraph'] = array(); //$this->dashboard->vehicleDemantGraph();
          }
          $data['todaysRetails'] = $this->booking->todaysRetails();
          $this->render_page('dashboard/dashboard', $data);
     }
     public function index()
     {
          $data['enquiresAnalysis'] = $this->dashboard->countTotalEnquires();
          $this->render_page('dashboard/dashboard2', $data);
     }
     public function load_data()
     {
          $data['count'] = $_GET['count'];
          $data['dashboardMeterials'] = $this->dashboard->dashboardMeterials();
          if (is_roo_user()) {
               $data['vehicleDemandGraph'] = $this->dashboard->vehicleDemantGraph();
          }
          $data['todaysRetails'] = $this->booking->todaysRetails();
          $result = $this->load->view('ajx', $data);
          return json_encode($result);
     }
}
