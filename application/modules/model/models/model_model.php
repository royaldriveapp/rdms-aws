<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Model_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
       }

       function select($id = '') {
            if (!empty($id)) {
                 $this->db->where($this->tbl_model . '.mod_id', $id);
                 return $this->db->select($this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_model, false)
                                 ->join($this->tbl_brand, $this->tbl_model . '.mod_brand = ' . $this->tbl_brand . '.brd_id', 'left')
                                 ->get()->row_array();
            } else {
                 return $this->db->select($this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_model, false)
                                 ->join($this->tbl_brand, $this->tbl_model . '.mod_brand = ' . $this->tbl_brand . '.brd_id', 'left')
                                 ->get()->result_array();
            }
       }

       public function getBrands($id = '') {
            $this->db->select("branda.*, brandb.brd_title AS parent")
                    ->from($this->tbl_brand . ' branda')
                    ->join($this->tbl_brand . ' brandb', 'branda.brd_parent = brandb.brd_id', 'left');

            if (!empty($id)) {
                 $this->db->where('branda.brd_id', $id);
            }
            $this->db->order_by('branda.brd_id', 'asc');
            $brands = $this->db->get()->result_array();
            return $brands;
       }

       public function insert($datas) {
            $datas['mod_added_by'] = $this->uid;
            $datas['mod_added_on'] = date('Y-m-d H:i:s');
            if ($this->db->insert($this->tbl_model, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function update($datas) {

            $this->db->where('mod_id', $datas['mod_id']);
            unset($datas['mod_id']);
            if ($this->db->update($this->tbl_model, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function delete($id) {
            $this->db->where('mod_id', $id);
            if ($this->db->delete($this->tbl_model)) {
                 return true;
            } else {
                 return false;
            }
       }

       function getVehicleByBrand($id) {
            return $this->db->where('mod_brand', $id)->get($this->tbl_model)->result_array();
       }
       function selectPaginate($postDatas, $filterDatas) {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
      
          // Clone the database object for getting the total records without limit and offset
          $totalRecordsQuery = clone $this->db;
          if (!empty($searchValue)) {
              $totalRecordsQuery->where("(" . $this->tbl_model . ".mod_title LIKE '%" . $searchValue . "%' OR " . $this->tbl_brand . ".brd_title LIKE '%" . $searchValue . "%') ");
          }
          $totalRecordsQuery->select("COUNT(*) as total")->from($this->tbl_model, false)
              ->join($this->tbl_brand, $this->tbl_model . '.mod_brand = ' . $this->tbl_brand . '.brd_id', 'left');
          $totalRecords = $totalRecordsQuery->get()->row()->total;
      
          if ($rowperpage > 0) {
              $this->db->limit($rowperpage, $row);
          }
      
          if (!empty($searchValue)) {
              $this->db->where("(" . $this->tbl_model . ".mod_title LIKE '%" . $searchValue . "%' OR " . $this->tbl_brand . ".brd_title LIKE '%" . $searchValue . "%') ");
          }
      
          $data = $this->db->select($this->tbl_model . '.mod_id,' . $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.brd_title')
              ->from($this->tbl_model, false)
              ->join($this->tbl_brand, $this->tbl_model . '.mod_brand = ' . $this->tbl_brand . '.brd_id', 'left')
              ->get()->result_array();
      
          $response = array(
              "draw" => intval($postDatas['draw']),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecords,
              "aaData" => $data
          );
      
          return $response;
      }
      
  }  