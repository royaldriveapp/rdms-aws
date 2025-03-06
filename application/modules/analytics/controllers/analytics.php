<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class analytics extends App_Controller {

     public function __construct() {
          parent::__construct();
          $this->page_title = 'Analytics';
          $this->load->model('analytics_model', 'analytics');
     }

     public function enquirydroppedpulse() {
          
          $data['enqpulse'] = $this->analytics->enquirydroppedpulse($_GET);

          $data['enq_date_from'] = isset($_GET['enq_date_from']) ? $_GET['enq_date_from'] : '';
          $data['enq_date_to'] = isset($_GET['enq_date_to']) ? $_GET['enq_date_to'] : '';

          $data['isRequestToDrop'] = isset($_GET['isRequestToDrop']) ? $_GET['isRequestToDrop'] : '';
          $data['isDrop'] = isset($_GET['isDrop']) ? $_GET['isDrop'] : '';

          $this->render_page(strtolower(__CLASS__) . '/enquirydroppedpulse', $data);
     }

}
