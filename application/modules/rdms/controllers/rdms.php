<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class rdms extends App_Controller {

     public function __construct() {
          parent::__construct();
          $this->template->set_layout('rdms');
          $this->template->set_partial('footer', 'partials/rdms_footer');
     }

     function index() {
          $this->render_page(strtolower(__CLASS__) . '/index');
     }
}