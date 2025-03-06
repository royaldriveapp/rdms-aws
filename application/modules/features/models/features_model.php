<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Features_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_features = TABLE_PREFIX_RANA . 'features';
       }

       function getFeatures($id = '') {
            if($id) {
                 $this->db->where('ftr_id', $id);
                 return $this->db->get($this->tbl_features)->row_array();
            } else {
                 return $this->db->get($this->tbl_features)->result_array();
            }
       }
  } 