<?php

defined('BASEPATH') or exit('No direct script access allowed');

class google_reviews extends App_Controller
{

     public function __construct()
     {

          parent::__construct();
          $this->page_title = 'Google Review Report';
          $this->load->library('form_validation');
          $this->load->model('google_reviews_model', 'g_review_model');
     }

  function report()
     {
          $this->render_page(strtolower(__CLASS__) . '/report');
     }
 
     function google_rw_ajx()//new
{
    $data['date'] = '';
    $date = $this->input->get('date');
    $data['date'] = $date;
    $dateTime = DateTime::createFromFormat('d-m-Y', $date);
    $new_date = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
  //  debug($new_date);
    $dateTime->modify('month');
    $data['previousMonthName'] = $dateTime->format('F');

    $divisions = $this->g_review_model->divisions();

    // Arrays to store data for each division
    $division_data = array();

    // Fetch data for each division
    foreach ($divisions as $division) {
        $showrooms = $this->g_review_model->get_showrooms_by_div($division->div_id);

        // Array to store data for each showroom in the division
        $div_shrm_data = array();

        foreach ($showrooms as $showroom) {
            // Fetch the rating for each showroom
            $rw_data = $this->g_review_model->get_google_rating($showroom->shr_id);
            $total_reviews = $this->g_review_model->get_g_review_count($showroom->shr_id, $new_date);
            $tot_rws_yesterday = $this->g_review_model->get_g_review_count($showroom->shr_id, $new_date,1);//for getiing yesterday's records pass 3rd parameter as 1 
            $tot_motnth_wise_rws = $this->g_review_model->get_g_review_count_month_wise($showroom->shr_id, $new_date); 
            $total_rws_with_photo = $this->g_review_model->get_count_g_review_with_photo($showroom->shr_id, $new_date);
            $div_shrm_data[] = array(
                'shrm_id' => $showroom->shr_id,
                'name' => $showroom->shr_location,
                'rating' => $rw_data->gd_rating,
                'rwCount' => $total_reviews,
                'yesterdaysRws'=>$tot_rws_yesterday,
                'tot_motnth_wise_rws'=>$tot_motnth_wise_rws,
                'rws_with_photo'=>$total_rws_with_photo
            );
        }

        // Store data for the division
        $division_data[] = array(
            'name' => $division->div_name,
            'div_id' => $division->div_id,
            'shrm_data' => $div_shrm_data
        );
    }

    $data['division_data'] = $division_data;

    $html_content = $this->load->view('report_ajx', $data, true);
    echo json_encode(array('html' => $html_content));
}

     
     
      
     
     public function store_google_rating()
     { 
          if ($this->g_review_model->storeGoogleRatig($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }  public function store_todays_rw_count()
     { 
        //  if ($this->g_review_model->storeGoogleRwCount($_POST)) {
          if ($this->g_review_model->storeNoOfReviews($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }
     public function store_todays_rws_with_photo()
     { 
          if ($this->g_review_model->storeNoOfReviewsWithPhoto($_POST)) {
               $message = 'successfully Added!';
               echo json_encode($message);
          }
     }

     
}
