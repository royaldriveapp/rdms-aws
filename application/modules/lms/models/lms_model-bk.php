<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class lms_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_source_funnel= TABLE_PREFIX . 'source_funnel';
            $this->tbl_contact_mode= TABLE_PREFIX . 'contact_mode';  
            $this->tbl_events= TABLE_PREFIX . 'events'; 
            $this->tbl_divisions= TABLE_PREFIX . 'divisions';
            $this->tbl_showroom= TABLE_PREFIX . 'showroom';
            
       }

       public function read($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_events, array('evnt_id' => $id))->row_array();
            }
            return $this->db->order_by('evnt_date', 'DESC')->get($this->tbl_events)->result_array();
       }
       public function getFunnelMasters() {
        
          $query = $this->db->select('sfnl_id, sfnl_funnel')
                            ->from($this->tbl_source_funnel)
                            ->where('sfnl_status', 1)
                            ->get();
                            
          return $query->result_array();
      }
      public function getSourceMasters() {
        
          $query = $this->db->select('cmd_mod_id,cmd_funnel,cmd_title')
                            ->from($this->tbl_contact_mode)
                            ->where('cmd_status', 1)
                            ->get();
                            
          return $query->result_array();
      }
       public function createFunnelMaster($datas) {
            $datas['sfnl_added_by'] = $this->uid;
            $datas['sfnl_added_on'] = date('Y-m-d H:i:s');
            if ($this->db->insert($this->tbl_source_funnel, $datas)) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'createFunnelmaster',
                     'log_desc' => 'New Funnel master created',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'C',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       public function createSourceMaster($datas) {
          $datas['cmd_added_by'] = $this->uid;
          $datas['cmd_added_on'] = date('Y-m-d H:i:s');
          if ($this->db->insert($this->tbl_contact_mode, $datas)) {
               $id = $this->db->insert_id();
               generate_log(array(
                   'log_title' => 'createSourcemaster',
                   'log_desc' => 'New Source master created',
                   'log_controller' => strtolower(__CLASS__),
                   'log_action' => 'C',
                   'log_ref_id' => $id,
                   'log_added_by' => get_logged_user('usr_id')
               ));
               return true;
          } else {
               return false;
          }
     }


     public function createCampaignMaster($datas) {
          $datas['evnt_added_by'] = $this->uid;
          $datas['evnt_added_on'] = date('Y-m-d H:i:s');
          $datas['evnt_date'] = date('Y-m-d', strtotime($datas['evnt_date']));
          $datas['evnt_end_date'] = date('Y-m-d', strtotime($datas['evnt_end_date']));
          $datas['evnt_division'] = $datas['vreg_division'];
          $datas['evnt_showroom'] = $datas['vreg_showroom'];
          $datas['evnt_department'] = $datas['vreg_department'];
          unset($datas['vreg_division'], $datas['vreg_showroom'],$datas['vreg_department']);
          if ($this->db->insert($this->tbl_events, $datas)) {
               $id = $this->db->insert_id();
               generate_log(array(
                   'log_title' => 'createCampaignMaster',
                   'log_desc' => 'New Source Campaign created',
                   'log_controller' => strtolower(__CLASS__),
                   'log_action' => 'C',
                   'log_ref_id' => $id,
                   'log_added_by' => get_logged_user('usr_id')
               ));
               return true;
          } else {
               return false;
          }
     }

     function bindCampaignBySoure($id)
     {
          $return['data'] = $this->db->select($this->tbl_events . '.evnt_id AS col_id, ' . $this->tbl_events . '.evnt_title AS col_title')
               ->where(array('evnt_source' => $id))->get($this->tbl_events)->result_array();
   return $return;
     }

       public function update($datas) {
            $id = $datas['evnt_id'];
            unset($datas['evnt_id']);
            $this->db->where('evnt_id', $id);
            $datas['evnt_date'] = date('Y-m-d', strtotime($datas['evnt_date']));
            if ($this->db->update($this->tbl_events, $datas)) {
                 generate_log(array(
                     'log_title' => 'Event updated',
                     'log_desc' => 'Event updated',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

    

       public function fetchLmsReportJ($filter) {
         // debug($filter);
         if(!empty($filter)){
          debug($filter);
         }
          // Call the stored procedure to fetch data
          $res = $this->db->query("CALL sp_generate_lms_report()")->result_array();
          $this->db->reconnect();
          return $res;
      }
      public function fetchLmsReport($filter) {
        $date_from = isset($filter['date_from']) ? date('Y-m-d', strtotime($filter['date_from'])) : null;
        $date_to = isset($filter['date_to']) ? date('Y-m-d', strtotime($filter['date_to'])) : null;
        $funnel_id = isset($filter['funnel']) ? intval($filter['funnel']) : 0;
        $source_id = isset($filter['source']) ? intval($filter['source']) : 0;
        $campaign_id = isset($filter['campaign']) ? intval($filter['campaign']) : 0;
    
        // Call the stored procedure to fetch data with filters
        $query = "CALL sp_generate_lms_report(?, ?, ?, ?, ?)";
        $params = array($date_from, $date_to, $funnel_id, $source_id, $campaign_id);
    
        $res = $this->db->query($query, $params)->result_array();
        $this->db->reconnect();
        return $res;
    }
    
    

      public function getFunnelMasterj() {
        
          $query = $this->db->select('sfnl_id,sfnl_funnel')
                            ->from($this->tbl_source_funnel)
                            ->where('sfnl_status', 1)
                            ->get();
                            
          return $query->result_array();
      }

      function getFunnelMasterPaginate($postDatas)
      {
 
           error_reporting(E_ALL);
           ini_set('display_errors', 1);
 
           $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
           $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
           $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
           $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
           $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
           $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
           $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
 
        
          $totalRecords = $this->getfunnelMasterTotal($searchValue);

          // $this->db->where($this->tbl_source_funnel . '.sfnl_status', 1);
   
 
           $selArray = array(
                $this->tbl_source_funnel . '.sfnl_id',
                $this->tbl_source_funnel . '.sfnl_funnel',
                $this->tbl_source_funnel . '.sfnl_status'
                
           );
 
           if (!empty($searchValue)) {
                $this->db->where("(sfnl_funnel LIKE '%" . $searchValue . "%') ");
           }
 
           if ($rowperpage > 0) {
                $this->db->limit($rowperpage, $row);
           }
 
           $data = $this->db->select($selArray)
     
                ->get($this->tbl_source_funnel)->result_array();
           $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" => $data
           );
           return $response;
      }
      function getfunnelMasterTotal($searchValue)
      {
          $this->db->from($this->tbl_source_funnel);
          if (!empty($searchValue)) {
               $this->db->like('sfnl_funnel', $searchValue); 
           }
           return $this->db->count_all_results();
       }

      public function editFunnelMaster($id) {
        
          $query = $this->db->select('sfnl_id,sfnl_funnel,sfnl_status')
                            ->from($this->tbl_source_funnel)
                            ->where('sfnl_id', $id)
                            ->get();
                            
          return $query->row_array();
      }

      public function updateFunnelMaster($id, $data) {
          // Assuming 'funnel_master' is your table name
          $this->db->where('sfnl_id', $id);
          $this->db->update($this->tbl_source_funnel, $data);
      
          // Check if the update was successful
          if ($this->db->affected_rows() > 0) {
              return true; // Update successful
          } else {
              return false; // Update failed
          }
      }

      public function deleteFunnelMater($id) {
          $this->db->where('sfnl_id', $id);
          if ($this->db->delete($this->tbl_source_funnel)) {
          
               return true;
          } else {
               return false;
          }
     }

///Source Master/////

function getSourceMasterPaginate($postDatas)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $draw = isset($postDatas['draw']) ? intval($postDatas['draw']) : 0;
    $row = isset($postDatas['start']) ? intval($postDatas['start']) : 0;
    $rowperpage = isset($postDatas['length']) ? intval($postDatas['length']) : 0; // Rows display per page
    $columnIndex = isset($postDatas['order'][0]['column']) ? intval($postDatas['order'][0]['column']) : 0; // Column index
    $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
    $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
    $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value

    $totalRecords = $this->getSourceMasterTotal($searchValue);

    $this->db->select('cmd_mod_id, cmd_title, cmd_status, sfnl_funnel');
    $this->db->from($this->tbl_contact_mode);
    $this->db->join($this->tbl_source_funnel, $this->tbl_source_funnel . '.sfnl_id = ' . $this->tbl_contact_mode . '.cmd_funnel', 'LEFT');

    if (!empty($searchValue)) {
        $this->db->like('cmd_title', $searchValue);
    }

    if ($rowperpage > 0) {
        $this->db->limit($rowperpage, $row);
    }

    $data = $this->db->get()->result_array();

    $response = array(
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecords,
        "aaData" => $data
    );

    return $response;
}

function getSourceMasterTotal($searchValue)
{
    $this->db->from($this->tbl_contact_mode);

    if (!empty($searchValue)) {
        $this->db->like('cmd_title', $searchValue); 
    }

    return $this->db->count_all_results();
}

public function editSourceMaster($id) {
     $this->db->select('cmd_mod_id, cmd_title, cmd_status,cmd_funnel, sfnl_funnel');
     $this->db->from($this->tbl_contact_mode);
     $this->db->join($this->tbl_source_funnel, $this->tbl_source_funnel . '.sfnl_id = ' . $this->tbl_contact_mode . '.cmd_funnel', 'LEFT');
     $this->db->where('cmd_mod_id', $id);
 
     $query = $this->db->get();
 
     if ($query->num_rows() > 0) {
         return $query->row_array(); 
     } else {
         return false; // No records found
     }
 }
 
 public function updateSourceMaster($id, $data) {
 
     // Update the record
     $this->db->where('cmd_mod_id', $id);
     $this->db->update($this->tbl_contact_mode, $data);
 
     // Check if the update was successful
     return $this->db->affected_rows() > 0;
 }
 public function deleteSourceMater($id) {
     $this->db->where('cmd_mod_id', $id);
     if ($this->db->delete($this->tbl_contact_mode)) {
     
          return true;
     } else {
          return false;
     }
}
 
//Campaign Master

function getCampaignMasterPaginate($postDatas)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $draw = isset($postDatas['draw']) ? intval($postDatas['draw']) : 0;
    $row = isset($postDatas['start']) ? intval($postDatas['start']) : 0;
    $rowperpage = isset($postDatas['length']) ? intval($postDatas['length']) : 0; // Rows display per page
    $columnIndex = isset($postDatas['order'][0]['column']) ? intval($postDatas['order'][0]['column']) : 0; // Column index
    $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
    $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
    $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value

    $totalRecords = $this->getSourceCampaignTotal($searchValue);

    $this->db->select('evnt_id , evnt_title,evnt_date,evnt_end_date,evnt_status,cmd_title,div_name,shr_location');
    $selArray = array(
     $this->tbl_events . '.evnt_id',
     $this->tbl_events . '.evnt_title',

     "DATE_FORMAT(" . $this->tbl_events . ".evnt_date, '%d-%m-%Y') AS evnt_date",
     "DATE_FORMAT(" . $this->tbl_events . ".evnt_end_date, '%d-%m-%Y') AS evnt_end_date",

     $this->tbl_events . '.evnt_status',
     $this->tbl_contact_mode . '.cmd_title',
     $this->tbl_divisions . '.div_name',
     $this->tbl_showroom . '.shr_location',
);

   //$this->db->select('evnt_id, evnt_title, DATE_FORMAT(evnt_date, "%d-%m-%Y") AS evnt_date_formatted, DATE_FORMAT(evnt_end_date, "%d-%m-%Y") AS evnt_end_date_formatted, evnt_status, cmd_title, div_name, shr_location');
   $this->db->select($selArray);
   $this->db->from($this->tbl_events);
    $this->db->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_events . '.evnt_source', 'LEFT');
    $this->db->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_events . '.evnt_division', 'LEFT');
    $this->db->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_events . '.evnt_showroom', 'LEFT');

    if (!empty($searchValue)) {
        $this->db->like('evnt_title', $searchValue);
    }

    if ($rowperpage > 0) {
        $this->db->limit($rowperpage, $row);
    }

    $data = $this->db->get()->result_array();

    $response = array(
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecords,
        "aaData" => $data
    );

    return $response;
}



function getSourceCampaignTotal($searchValue) {
     // Prepare the query
     $this->db->from($this->tbl_events);
     $this->db->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_events . '.evnt_source', 'LEFT');
     $this->db->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_events . '.evnt_division', 'LEFT');
     $this->db->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_events . '.evnt_showroom', 'LEFT');
 
     // Apply search filter if applicable
     if (!empty($searchValue)) {
         $this->db->like('evnt_title', $searchValue);
     }
 
     // Get the total count of records
     $totalRecords = $this->db->count_all_results();
 
     return $totalRecords;
 }

 public function editCampaignMaster($id) {
     $this->db->select('evnt_id, evnt_title, evnt_date, evnt_end_date, evnt_status, evnt_source,evnt_division,evnt_showroom,cmd_title, div_name, shr_location');
   //  $this->db->select($selArray);
     $this->db->from($this->tbl_events);
      $this->db->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_events . '.evnt_source', 'LEFT');
      $this->db->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_events . '.evnt_division', 'LEFT');
      $this->db->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_events . '.evnt_showroom', 'LEFT');
  
     $this->db->where('evnt_id', $id);
 
     $query = $this->db->get();
 
     if ($query->num_rows() > 0) {
         return $query->row_array(); 
     } else {
         return false; // No records found
     }
 }

 public function updateCampaignMaster($id, $data) {
     // Update the record in the 'cpnl_events' table based on the provided ID
     $this->db->where('evnt_id', $id);
     $this->db->update('cpnl_events', $data);
     
     // Check if the update was successful
     if ($this->db->affected_rows() > 0) {
         return true; // Return true if the update was successful
     } else {
         return false; // Return false if the update failed
     }
 }

 public function getCampaignMaster() {//for filter
    $this->db->select('evnt_id, evnt_title');
    $this->db->from($this->tbl_events);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result_array(); 
    } else {
        return false; // No records found
    }
}
public function deleteCampaignMater($id) {
    $this->db->where('evnt_id', $id);
    if ($this->db->delete($this->tbl_events)) {
    
         return true;
    } else {
         return false;
    }
}

  }
  