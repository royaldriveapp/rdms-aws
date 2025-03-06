<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class google_reviews_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
       }



     
function divisions()
{
    $divisions = $this->db->select('div_id, div_name')->order_by('div_id')->get('cpnl_divisions')->result();
    return $divisions;
}

/****google review*****/
public function get_showrooms_with_divisions() {
     $this->db->select('cpnl_showroom.shr_id, cpnl_showroom.shr_location, cpnl_divisions.div_name');
     $this->db->from('cpnl_showroom');
     $this->db->join('cpnl_divisions', 'cpnl_showroom.shr_division = cpnl_divisions.div_id');
     $this->db->where('cpnl_showroom.shr_status', 1);
     $this->db->where('cpnl_divisions.div_status', 1);
     $query = $this->db->get();
     return $query->result_array();
 }

 function get_showrooms_by_div($div_id)
{
    $shr = $this->db
    ->select('shr_id,shr_location')
    ->where('shr_division', $div_id)
    ->where('shr_status', 1)
    ->get('cpnl_showroom')
    ->result(); //ixd
    return $shr;
    
}
public function storeGoogleRatig($data)
    {
      
        $date = DateTime::createFromFormat('d-m-Y', $data['date'])->format('Y-m-d');

        // Define start and end times for the date
        $date_start = $date . ' 00:00:00';
        $date_end = $date . ' 23:59:59';
        
        $shrm = $data['shrm'];
        $rating = $data['rating'];
        
        // Start transaction
        $this->db->trans_start();
        
        // Check if the record exists
        $query = $this->db->get_where('cpnl_google_rw_details', [
            'gd_shrm' => $shrm,
            'gd_added_on >=' => $date_start,
            'gd_added_on <=' => $date_end
        ]);
        
        if ($query->num_rows() > 0) {
            // If a record exists, update it
            $record = $query->row();
            
            // Update the record
            $this->db->where('gd_id', $record->gd_id);
            $this->db->update('cpnl_google_rw_details', [
                'gd_rating' => $rating,
                'gd_added_on' => $date . ' 00:00:00'
            ]);
        } else {
            // Insert a new record
            $this->db->insert('cpnl_google_rw_details', [
                'gd_shrm' => $shrm,
                'gd_rating' => $rating,
                'gd_added_on' => $date . ' 00:00:00'
            ]);
        }
        
        // Complete the transaction
        $this->db->trans_complete();
        
        // Check the transaction status
        if ($this->db->trans_status() === FALSE) {
            // Generate an error... or use the log_message() function to log your error
            log_message('error', 'Transaction failed while saving rating.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function storeGoogleRwCount($data)
    {
      
        $date = DateTime::createFromFormat('d-m-Y', $data['date'])->format('Y-m-d');

        // Define start and end times for the date
        $date_start = $date . ' 00:00:00';
        $date_end = $date . ' 23:59:59';
        
        $shrm = $data['shrm'];
        $rwCount = $data['rwCount'];
        
        // Start transaction
        $this->db->trans_start();
        
        // Check if the record exists
        $query = $this->db->get_where('cpnl_google_rw_details', [
            'gd_shrm' => $shrm,
            'gd_added_on >=' => $date_start,
            'gd_added_on <=' => $date_end
        ]);
        
        if ($query->num_rows() > 0) {
            // If a record exists, update it
            $record = $query->row();
            
            // Update the record
            $this->db->where('gd_id', $record->gd_id);
            $this->db->update('cpnl_google_rw_details', [
                'gd_no_of_rw' => $rwCount,
                'gd_added_on' => $date . ' 00:00:00'
            ]);
        } else {
            // Insert a new record
            $this->db->insert('cpnl_google_rw_details', [
                'gd_shrm' => $shrm,
                'gd_no_of_rw' => $rwCount,
                'gd_added_on' => $date . ' 00:00:00'
            ]);
        }
        
        // Complete the transaction
        $this->db->trans_complete();
        
        // Check the transaction status
        if ($this->db->trans_status() === FALSE) {
            // Generate an error... or use the log_message() function to log your error
            log_message('error', 'Transaction failed while saving rating.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function get_google_ratingBk($shrm_id, $date)
    {
        // Convert date to the correct format for datetime field
        $startDate = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d 00:00:00');
        $endDate = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d 23:59:59');
        
        $this->db->select('gd_rating,gd_no_of_rw');
        $this->db->from('cpnl_google_rw_details');
        $this->db->where('gd_shrm', $shrm_id);
        $this->db->where('gd_added_on >=', $startDate);
        $this->db->where('gd_added_on <=', $endDate);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
           // return $query->row()->gd_rating;
           return $query->row();
        } else {
            // Debugging statement
           // log_message('debug', 'No rating found for shrm_id: ' . $shrm_id . ' on date: ' . $date . ' (' . $startDate . ' to ' . $endDate . ')');
            return null;
        }
    }

    public function get_google_rating($shrm_id)
    {
     $this->db->select('gd_rating');
        $this->db->from('cpnl_google_rw_details');
        $this->db->where('gd_shrm', $shrm_id);
        $this->db->where('gd_rating IS NOT NULL');
        $this->db->order_by('gd_id', 'DESC'); // Order by gd_id in descending order
        $this->db->limit(1); // Limit to 1 record

        $query = $this->db->get();
        return $query->row(); // Return the last record
    }

    public function storeNoOfReviews($data)
    {
//debug($data);
     $master_id = $data['shrm'];
     $followers = $data['rwCount'];

        $last_count=$this->get_g_review_count($master_id, $data['date']);
 

        $date = DateTime::createFromFormat('d-m-Y', $data['date'])->format('Y-m-d');

        // Convert date to datetime format
        $date_start = $date . ' 00:00:00';
        $date_end = $date . ' 23:59:59';

        // Begin transaction
        $this->db->trans_start();

        // Check if the record exists and update or insert accordingly

// Query to fetch the followers count within the date range
$this->db->select('gd_rating,gd_no_of_rw,gd_no_of_rw_with_photo');
$this->db->from('cpnl_google_rw_details');
$this->db->where('gd_shrm', $master_id);
$this->db->where('gd_added_on >=', $date_start);
$this->db->where('gd_added_on <=', $date_end);

$query = $this->db->get();

// Return the result set as an array
 $today_count=$query->row_array();
// debug($today_count);
 if($today_count['gd_no_of_rw'] OR $today_count['gd_rating'] OR $today_count['gd_no_of_rw_with_photo']){
   // debug('upd');
     $last_count=$last_count-$today_count['gd_no_of_rw'];
     $new_foll_count=$followers-$last_count;
        $this->db->set('gd_no_of_rw', $new_foll_count);//$followers
        $this->db->where('gd_shrm', $master_id);
        $this->db->where('gd_added_on >=', $date_start);
        $this->db->where('gd_added_on <=', $date_end);
        $this->db->update('cpnl_google_rw_details');
 }else{
      //  debug('create');
       // if ($this->db->update('cpnl_social_media_followers') && $this->db->affected_rows() == 0) {
            // No rows affected, so insert new record
            $insert_data = [
                'gd_shrm' => $master_id,
                'gd_no_of_rw' => $new_foll_count,//$followers
                'gd_added_on' => $date . ' 00:00:00',
            ];
            $this->db->insert('cpnl_google_rw_details', $insert_data);
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

    public function get_g_review_count($shrm, $date,$is_yesterday='')
    {
   
     //debug($new_date);
        // Add the time part to the date to cover the entire day
        $date_end = $date . ' 23:59:59';
        if ($is_yesterday) {
          $date_end = date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date)));
      }
  
       
        // Use a direct SQL query for better performance
        $sql = "SELECT SUM(gd_no_of_rw) AS total_reviews
                FROM cpnl_google_rw_details
                WHERE gd_shrm = ?
                AND gd_added_on <= ?";
        
        $query = $this->db->query($sql, array($shrm, $date_end));
        $result = $query->row_array();

        return isset($result['total_reviews']) ? $result['total_reviews'] : 0;
    }

    public function get_g_review_count_month_wise($shrm, $date)
{
    // Extract year and month from the given date
    $year = date('Y', strtotime($date));
    $month = date('m', strtotime($date));

    // Get the first and last day of the month
    $first_day = date('Y-m-01 00:00:00', strtotime($date));
    $last_day = date('Y-m-t 23:59:59', strtotime($date));

    // SQL query to sum the number of reviews for the specified showroom and month
    $sql = "SELECT SUM(gd_no_of_rw) AS total_reviews
            FROM cpnl_google_rw_details
            WHERE gd_shrm = ?
            AND gd_added_on >= ?
            AND gd_added_on <= ?";
    
    // Execute the query with parameter binding
    $query = $this->db->query($sql, array($shrm, $first_day, $last_day));
    
    // Fetch the result as an associative array
    $result = $query->row_array();

    // Return the total number of reviews or 0 if none found
    return isset($result['total_reviews']) ? $result['total_reviews'] : 0;
}

public function storeNoOfReviewsWithPhoto($data)
{
//debug($data);
 $master_id = $data['shrm'];
 $followers = $data['rwCount'];

 //    $master_id = $data['master_id'];
 //    $followers = $data['followers'];
    $last_count=$this->get_count_g_review_with_photo($master_id, $data['date']);

    $new_foll_count=$followers-$last_count;
  //  debug($new_foll_count);
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
$this->db->select('gd_rating,gd_no_of_rw,gd_no_of_rw_with_photo');
$this->db->from('cpnl_google_rw_details');
$this->db->where('gd_shrm', $master_id);
$this->db->where('gd_added_on >=', $date_start);
$this->db->where('gd_added_on <=', $date_end);

$query = $this->db->get();

// Return the result set as an array
$today_count=$query->row_array();
// debug($today_count);
if($today_count['gd_no_of_rw'] OR $today_count['gd_rating'] OR $today_count['gd_no_of_rw_with_photo']){
// debug('upd');
 $last_count=$last_count-$today_count['gd_no_of_rw_with_photo'];
 $new_foll_count=$followers-$last_count;
    $this->db->set('gd_no_of_rw_with_photo', $new_foll_count);//$followers
    $this->db->where('gd_shrm', $master_id);
    $this->db->where('gd_added_on >=', $date_start);
    $this->db->where('gd_added_on <=', $date_end);
    $this->db->update('cpnl_google_rw_details');
}else{
  //  debug('create');
   // if ($this->db->update('cpnl_social_media_followers') && $this->db->affected_rows() == 0) {
        // No rows affected, so insert new record
        $insert_data = [
            'gd_shrm' => $master_id,
            'gd_no_of_rw_with_photo' => $new_foll_count,//$followers
            'gd_added_on' => $date . ' 00:00:00',
        ];
        $this->db->insert('cpnl_google_rw_details', $insert_data);
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

public function get_count_g_review_with_photo($shrm, $date)
{

 //debug($new_date);
    // Add the time part to the date to cover the entire day
    $date_end = $date . ' 23:59:59';
 
   
    // Use a direct SQL query for better performance
    $sql = "SELECT SUM(gd_no_of_rw_with_photo) AS total_reviews
            FROM cpnl_google_rw_details
            WHERE gd_shrm = ?
            AND gd_added_on <= ?";
    
    $query = $this->db->query($sql, array($shrm, $date_end));
    $result = $query->row_array();

    return isset($result['total_reviews']) ? $result['total_reviews'] : 0;
} 
 
  }  