<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class payroll extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Payroll';
       }

       public function apply_leave() {
            $this->render_page(strtolower(__CLASS__) . '/apply_leave');
       }
       
       public function compose_leave() {
            $this->render_page(strtolower(__CLASS__) . '/compose_leave');
       }
  }  