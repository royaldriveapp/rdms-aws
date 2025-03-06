<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class help_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
       }

       function tables() {
            return $this->db->query("SHOW tables")->result_array();
       }

       function tableFields($table) {
            return $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->database . 
                    "' AND TABLE_NAME = '$table'")->result_array();
       }

  }
  