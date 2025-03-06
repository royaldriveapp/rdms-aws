<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Features extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->body_class[] = 'skin-blue';
            $this->page_title = 'Brand';
            $this->load->library('form_validation');
            $this->load->model('Features_model', 'features_model');
       }
  }
  