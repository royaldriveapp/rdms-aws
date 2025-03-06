<?php

defined('BASEPATH') or exit('No direct script access allowed');

class socialmedia extends App_Controller
{

     public function __construct()
     {

          parent::__construct();
          $this->page_title = 'Social Media Report';
          $this->load->library('form_validation');
          $this->load->model('socialmedia_model', 'socialmedia');
     }





     function report()
     {
          $this->render_page(strtolower(__CLASS__) . '/sm_report');
     }



     function sm_report_ajx()
     {
          $data['date'] = '';
          $date = $this->input->get('date');
          $data['date'] =  $date;
          $dateTime = DateTime::createFromFormat('d-m-Y', $date);

          $dateTime->modify('-1 month');
          $data['previousMonthName'] = $dateTime->format('F');

          $dateObj = DateTime::createFromFormat('d-m-Y', $date);

          $dateObj->modify('first day of this month');
          $dateObj->modify('last day of previous month');
          $data['last_month_date'] = $dateObj->format('Y-m-d');

          $result = $this->load->view('/sm_report_ajx2', $data);
          return json_encode($result);
     }


     public function get_test(){
          $query = $this->db->get('cpnl_exchange_vehicles');

          // Return the result as an array
          $data= $query->result_array();
          debug($data);

     }
     public function store_followers()
     {
          if ($this->socialmedia->storeFollowers($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }
}
