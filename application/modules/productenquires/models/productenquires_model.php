<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class productenquires_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_users = TABLE_PREFIX . 'users';
        
       }

       function staffsOld()
       {
            $assign[] = $this->tbl_groups . ".grp_slug = 'TC'";
            $assign[] = $this->tbl_groups . ".grp_slug = 'SE'";
            $assign[] = $this->tbl_designation . ".desig_slug = 'TPC'";
            return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_username AS col_title, ' .
                 $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
                 ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'left')
                 ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'left')
                 ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                 ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                 ->where('(' . implode(' OR ', $assign) . ')')
                 ->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->result_array();
       }
       function staffs(){
          $assign[] = $this->tbl_users . ".usr_designation_new = 14";
            $assign[] = $this->tbl_users . ".usr_designation_new = 43";
            $assign[] = $this->tbl_users . ".usr_designation_new = 59";
            return  $this->db
->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_username AS col_title')
->where('(' . implode(' OR ', $assign) . ')')
->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0, 'usr_resigned_date' => NULL))->get($this->tbl_users)->result_array(); //ixd
       }

       
  }
  