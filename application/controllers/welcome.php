<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Welcome extends CI_Controller {

       /**
        * Index Page for this controller.
        *
        * Maps to the following URL
        * 		http://example.com/index.php/welcome
        * 	- or -  
        * 		http://example.com/index.php/welcome/index
        * 	- or -
        * Since this controller is set as the default controller in 
        * config/routes.php, it's displayed at http://example.com/
        *
        * So any other public methods not prefixed with an underscore will
        * map to /index.php/welcome/<method_name>
        * @see http://codeigniter.com/user_guide/general/urls.html
        */
       public function index() {
            error_reporting(E_ALL);
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            
            //Hot+
            $hotPlus = $this->db->select('enq_showroom_id, enq_cus_when_buy, COUNT(*) cnt')
                    ->where_in('enq_current_status', [1, 15, 14])
                    ->group_by('enq_cus_when_buy, enq_showroom_id')
                    ->get($this->tbl_enquiry)->result_array();
            echo $this->db->last_query();
            $lhp = 0;
            $lh = 0;
            $shp = 0;
            $sh = 0;
            foreach ($hotPlus as $key => $value) {
                 if(($value['enq_showroom_id'] == 2 || $value['enq_showroom_id'] == 4 || $value['enq_showroom_id'] == 7) && 
                         $value['enq_cus_when_buy'] == 1) { // LUX HOT+
                    $lhp = $lhp + $value['cnt'];
                 }
                 
                 if(($value['enq_showroom_id'] == 2 || $value['enq_showroom_id'] == 4 || $value['enq_showroom_id'] == 7) && 
                         $value['enq_cus_when_buy'] == 2) { // LUX HOT
                    $lh = $lh + $value['cnt'];
                 }
                 
                 if(($value['enq_showroom_id'] == 1 || $value['enq_showroom_id'] == 6 || $value['enq_showroom_id'] == 8 ) && 
                         $value['enq_cus_when_buy'] == 1) { // SMRT HOT+
                    $shp = $shp + $value['cnt'];
                 }
                 
                 if(($value['enq_showroom_id'] == 1 || $value['enq_showroom_id'] == 6 || $value['enq_showroom_id'] == 8) && 
                         $value['enq_cus_when_buy'] == 2) { // SMRT HOT
                    $sh = $sh + $value['cnt'];
                 }
            }
            
            echo 'LUX HOT+ ' . $lhp . '<br>';
            echo 'LUX HOT ' . $lh . '<br>';
            echo 'SRT HOT+ ' . $shp . '<br>';
            echo 'SRT HOT ' . $sh . '<br>';
            exit;
       }
  }

  /* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */