<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class variant_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->db->query("SET time_zone = '+05:30'");
            
            $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
       }

       function select($id = '') {
            if (!empty($id)) {
                 $this->db->where($this->tbl_variant . '.var_id', $id);
                 return $this->db->select($this->tbl_variant . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_variant)
                                 ->join($this->tbl_model, $this->tbl_variant . '.var_model_id = ' . $this->tbl_model . '.mod_id', 'left')
                                 ->join($this->tbl_brand, $this->tbl_variant . '.var_brand_id = ' . $this->tbl_brand . '.brd_id', 'left')
                                 ->get()->row_array();
            } else {
                 return $this->db->select($this->tbl_variant . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_variant)
                                 ->join($this->tbl_model, $this->tbl_variant . '.var_model_id = ' . $this->tbl_model . '.mod_id', 'left')
                                 ->join($this->tbl_brand, $this->tbl_variant . '.var_brand_id = ' . $this->tbl_brand . '.brd_id', 'left')
                                 ->get()->result_array();
            }
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
              $totalRecordsQuery->where("(" . $this->tbl_variant . ".var_variant_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_model . ".mod_title LIKE '%" . $searchValue . "%' OR "
                  . $this->tbl_brand . ".brd_title LIKE '%" . $searchValue . "%') ");
          }
          $totalRecordsQuery->select("COUNT(*) as total")->from($this->tbl_variant)
              ->join($this->tbl_model, $this->tbl_variant . '.var_model_id = ' . $this->tbl_model . '.mod_id', 'left')
              ->join($this->tbl_brand, $this->tbl_variant . '.var_brand_id = ' . $this->tbl_brand . '.brd_id', 'left');
          $totalRecords = $totalRecordsQuery->get()->row()->total;
      
          if ($rowperpage > 0) {
              $this->db->limit($rowperpage, $row);
          }
      
          if (!empty($searchValue)) {
              $this->db->where("(" . $this->tbl_variant . ".var_variant_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_model . ".mod_title LIKE '%" . $searchValue . "%' OR "
                  . $this->tbl_brand . ".brd_title LIKE '%" . $searchValue . "%') ");
          }
      
          $data = $this->db->select($this->tbl_variant . '.var_id,' . $this->tbl_variant . '.var_variant_name,' . $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.brd_title')
              ->from($this->tbl_variant)
              ->join($this->tbl_model, $this->tbl_variant . '.var_model_id = ' . $this->tbl_model . '.mod_id', 'left')
              ->join($this->tbl_brand, $this->tbl_variant . '.var_brand_id = ' . $this->tbl_brand . '.brd_id', 'left')
              ->get()->result_array();
      
          $response = array(
              "draw" => intval($postDatas['draw']),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecords,
              "aaData" => $data
          );
      
          return $response;
      }
       public function insert($datas) {
            $datas['var_added_by'] = $this->uid;
            $datas['var_added_on'] = date('Y-m-d H:i:s');
            if ($this->db->insert($this->tbl_variant, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function update($datas) {

            $this->db->where('var_id', $datas['var_id']);
            unset($datas['var_id']);
            if ($this->db->update($this->tbl_variant, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function delete($id) {
            $this->db->where('var_id', $id);
            if ($this->db->delete($this->tbl_variant)) {
                 return true;
            } else {
                 return false;
            }
       }

       function getVariantByModel($id) {
            return $this->db->where('var_model_id', $id)->get($this->tbl_variant)->result_array();
       }

  }

  