<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Socialmedia_model extends CI_Model {

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

       //

       
     function getReAssignData($date = null)
     {

          $today_date = date('Y-m-d');
          // Get the first day of the current month
          $first_day_of_month = date('Y-m-01');
          if ($date) {
               $today_date = date('Y-m-d', strtotime($date));
               // Get the first day of the filtered month from the date parameter
               $first_day_of_month = date('Y-m-01', strtotime($date));
          }


          $showrooms = $this->db->select('shr_id, shr_location')->order_by('shr_division')->get('cpnl_showroom')->result(); //ixd
          $total_today_count = 0;
          $total_this_count = 0;

          $total_today_count_asm = 0;
          $total_this_count_asm = 0;

          foreach ($showrooms as $showroom) {
               $today_count = 0;
               $this_month_count = 0;

               //  $today_count_asm = 0;
               // $this_month_count_asm = 0;

               $enquiry_count = 0;
               $salesManagers = $this->db
                    ->select('usr_id,usr_username')
                    ->where_in('usr_designation_new', [5, 25, 83, 42])
                    ->where('usr_showroom', $showroom->shr_id)
                    ->where('usr_active', 1)->where('usr_resigned', 0) //jsk
                    ->get('cpnl_users')
                    ->result(); //ixd
               //      echo $this->db->last_query();
               // debug($salesManagers, 0);
               foreach ($salesManagers as $salesManager) {
                    $salesManager->total_sales_consultants = 0;
                    $asms = $this->db
                         ->select('usr_id,usr_username')
                         // ->where('(usr_designation_new = 6)') //  OR usr_designation_new = 5
                         ->where_in('usr_designation_new', [6, 18, 110]) //jsk
                         ->where('usr_tl', $salesManager->usr_id)
                         ->where('usr_active', 1)->where('usr_resigned', 0) //
                         ->get('cpnl_users')
                         ->result(); //idx 


                    foreach ($asms as $asm) {

                         $countSalesConsultants = 0;
                         $salesConsultants = $this->db
                              ->select('usr_id,usr_username')
                              ->where_in('usr_designation_new', [79, 18, 12, 11, 100])
                              ->where('usr_tl', $asm->usr_id)
                              ->where('usr_active', 1)->where('usr_resigned', 0) //
                              ->get('cpnl_users')
                              ->result(); //idx

                         if (empty($salesConsultants)) {
                              $asm->sales_consultants[] = [];
                              $countSalesConsultants = $countSalesConsultants + 1;
                         }

                         foreach ($salesConsultants as $salesConsultant) {

                              $this->db->select('cpnl_re_assign_reports.re_added_by,
                        SUM(DATE(cpnl_re_assign_reports.re_added_on) = "' . $today_date . '") as TodayCount,
                        SUM(DATE(cpnl_re_assign_reports.re_added_on) >= "' . $first_day_of_month . '") as ThisMonthCount');
                              $this->db->from('cpnl_re_assign_reports');
                              $this->db->where('cpnl_re_assign_reports.re_staff', $salesConsultant->usr_id);
                              if (check_permission('reports', 'reassignreport_showmyself')) {
                                   $this->db->where('cpnl_re_assign_reports.re_added_by', $this->uid);
                              }
                              $query =  $this->db->get();
                              $row = $query->row();

                              $salesConsultant->today_count = $row->TodayCount;
                              $today_count = $today_count + $salesConsultant->today_count; //
                              $salesConsultant->this_month_count = $row->ThisMonthCount;
                              $this_month_count = $this_month_count + $salesConsultant->this_month_count; //
                              $salesConsultant->addedBy = $row->re_added_by;

                              // echo "Today's inserted records count: " . $row->TodayCount . "<br>";
                              // echo "This month's inserted records count: " . $row->ThisMonthCount. "<br>";
                              // debug($row);
                              /*End Booking & delivered enq*/
                              if (!isset($salesConsultant->enquiry_count)) {
                                   $salesConsultant->enquiry_count = 0;
                              }

                              $asm->sales_consultants[] = $salesConsultant;

                              $countSalesConsultants = $countSalesConsultants + 1;
                         }

                         $salesManager->asm[] = $asm;
                         $salesManager->total_sales_consultants = $salesManager->total_sales_consultants + $countSalesConsultants;
                    }

                    $showroom->sales_managers[] = $salesManager;
               }

               $infos[] = [
                    'shr_id' => $showroom->shr_id,
                    'name' => $showroom->shr_location,
                    'sales_managers' => $showroom->sales_managers ?? [],
                    'enquiry_count' => $enquiry_count,
                    'today_count' => $today_count,
                    'this_month_count' => $this_month_count,


               ];


               $total_today_count += $today_count;
               $total_this_count +=  $this_month_count;
          }

          $total_count_info = [
               'today_count' => $total_today_count,
               'this_month_count' => $total_this_count,
          ];
          return [
               'infos' => $infos,
               'total_count_info' => $total_count_info,
          ];
     }

     
function divisions()
{
    $divisions = $this->db->select('div_id, div_name')->order_by('div_id')->get('cpnl_divisions')->result();
    return $divisions;
}

function sm($div_id)
{
    $sm = $this->db
    ->select('sm_id,sm_div,sm_name,sm_url')
    ->where('sm_div ', $div_id)
    ->where('sm_div !=', 0)
    ->get('cpnl_social_medias')
    ->result(); //ixd
    return $sm;
    
}

function sm_common()
{
    $sm = $this->db
    ->select('sm_id,sm_div,sm_name,sm_url')
    ->where('sm_div', 0)
    ->get('cpnl_social_medias')
    ->result(); //ixd
    return $sm;
    
}


// function get_followers_count($sm_id, $date)
// {
  
//     $this->db->select_sum('smf_no_of_followers');
//     $this->db->where('smf_master_id', $sm_id);
//     $this->db->where('smf_added_on <=', $date);
//     $query = $this->db->get('cpnl_social_media_followers');
//     $result = $query->row_array();
//     return $result['smf_no_of_followers'];
// }

public function get_followers_count($sm_id, $date)
    {
        // Add the time part to the date to cover the entire day
        $date_end = $date . ' 23:59:59';

        // Use a direct SQL query for better performance
        $sql = "SELECT SUM(smf_no_of_followers) AS total_followers
                FROM cpnl_social_media_followers
                WHERE smf_master_id = ?
                AND smf_added_on <= ?";
        
        $query = $this->db->query($sql, array($sm_id, $date_end));
        $result = $query->row_array();

        return isset($result['total_followers']) ? $result['total_followers'] : 0;
    }

// Function to calculate the growth between two follower counts
function calculate_growth($current_followers, $last_month_followers)
{
    if ($last_month_followers == 0) {
        return '';
    } else {
        $growth_percentage = (($current_followers - $last_month_followers) / $last_month_followers) * 100;
        return number_format($growth_percentage, 2);
    }
}

/*
function today_followers_count($sm_id)
{

$start_of_day = date('Y-m-d 00:00:00', strtotime('2024-05-16'));
$end_of_day = date('Y-m-d 23:59:59', strtotime('2024-05-16'));


$this->db->select_sum('smf_no_of_followers');
$this->db->from('cpnl_social_media_followers');
$this->db->where('smf_master_id', $sm_id);
$this->db->where('smf_added_on >=', $start_of_day);
$this->db->where('smf_added_on <=', $end_of_day);
$query = $this->db->get();

$result = $query->row_array();
return $result['smf_no_of_followers'];
}
function this_month_followers_count($sm_id){
     $start_of_month = date('Y-m-01 00:00:00');
$end_of_month = date('Y-m-t 23:59:59');


$this->db->select_sum('smf_no_of_followers');
$this->db->from('cpnl_social_media_followers');
$this->db->where('smf_master_id', $sm_id);
$this->db->where('smf_added_on >=', $start_of_month);
$this->db->where('smf_added_on <=', $end_of_month);
$query = $this->db->get();

$result = $query->row_array();
return $result['smf_no_of_followers'];
}*/


public function storeFollowers($data)
    {
        $master_id = $data['master_id'];
        $followers = $data['followers'];
       $last_count=$this->get_followers_count_up_to_yesterday($master_id);
       //$last_count=$this->get_followers_count($master_id, $data['date']);
      //  echo $last_count; exit;
        $new_foll_count=$followers-$last_count;
      //  echo $new_foll_count; exit;
     //  / debug($data['date']);
        //if($new_foll_count>0){
        $date = DateTime::createFromFormat('d-m-Y', $data['date'])->format('Y-m-d');

        // Convert date to datetime format
        $date_start = $date . ' 00:00:00';
        $date_end = $date . ' 23:59:59';

        // Begin transaction
        $this->db->trans_start();

        // Check if the record exists and update or insert accordingly

// Query to fetch the followers count within the date range
$this->db->select('smf_no_of_followers');
$this->db->from('cpnl_social_media_followers');
$this->db->where('smf_master_id', $master_id);
$this->db->where('smf_added_on >=', $date_start);
$this->db->where('smf_added_on <=', $date_end);

$query = $this->db->get();

// Return the result set as an array
 $today_count=$query->row_array();
//print_r($today_count);
// debug($today_count);
 if($today_count['smf_no_of_followers']!=Null){
   //echo 'und'; exit;
   //  $last_count=$last_count-$today_count['smf_no_of_followers'];
//$new_foll_count=$followers-$last_count;
        $this->db->set('smf_no_of_followers', $new_foll_count);//$followers
        $this->db->where('smf_master_id', $master_id);
        $this->db->where('smf_added_on >=', $date_start);
        $this->db->where('smf_added_on <=', $date_end);
        $this->db->update('cpnl_social_media_followers');
 }else{
  //  echo 'illa'; exit;
 // echo $new_foll_count; exit;
       // if ($this->db->update('cpnl_social_media_followers') && $this->db->affected_rows() == 0) {
            // No rows affected, so insert new record
            $insert_data = [
                'smf_master_id' => $master_id,
                'smf_no_of_followers' => $new_foll_count,//$followers
                'smf_added_on' => $date . ' 00:00:00',
            ];
            $this->db->insert('cpnl_social_media_followers', $insert_data);
        //}
          }
        // Complete transaction
        $this->db->trans_complete();

        // Check transaction status
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    // }
     return false;
    }
    public function get_followers_count_up_to_yesterday($sm_id)
    {
        // Get the current date and time
        $current_date = date('Y-m-d');
        $yesterday_end = date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($current_date)));
    
        // Use a direct SQL query for better performance
        $sql = "SELECT SUM(smf_no_of_followers) AS total_followers
                FROM cpnl_social_media_followers
                WHERE smf_master_id = ?
                AND smf_added_on <= ?";
        
        $query = $this->db->query($sql, array($sm_id, $yesterday_end));
        $result = $query->row_array();
    
        return isset($result['total_followers']) ? $result['total_followers'] : 0;
    }

  }  