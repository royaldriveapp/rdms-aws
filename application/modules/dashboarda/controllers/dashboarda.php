<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class dashboarda extends App_Controller {

       public function __construct() {
            parent::__construct();
            $this->page_title = "Dashboard";
            $this->load->model('dashboarda_model', 'dashboard');
       }

       public function index() {
            
            $data['enquiresAnalysis'] = $this->dashboard->countTotalEnquires();
            $data['dashboardMeterials'] = $this->dashboard->dashboardMeterials();
            if (is_roo_user()) {
                 $data['vehicleDemandGraph'] = $this->dashboard->vehicleDemantGraph();
            }
            $this->render_page('dashboarda/dashboard', $data);
       }
  }