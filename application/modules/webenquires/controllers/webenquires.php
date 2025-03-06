<?php
defined('BASEPATH') or exit('No direct script access allowed');

class webenquires extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('booking_api_model');
        $this->load->model('webenquires_model', 'api_booking');
        $this->load->model('booking/booking_model', 'booking');
        $this->load->model('evaluation/evaluation_model', 'evaluation');
    }

    public function getAll()
    {
        $data['bookings'] = $this->api_booking->get_all_bookings();
        // echo '<pre>';
        //debug($data['bookings']);
        //$this->render_page(strtolower(__CLASS__) . '/index');
        $this->render_page(strtolower(__CLASS__) . '/index', $data);
    }

    public function insert_api_data()
    { //debug(1123);
        $api_url = 'https://api.royaldrive.in/api/allbookings';
        $api_key = 'be382508-f95e-46d4-8847-5f698b3b9d6a';

        // Set up cURL
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: ' . $api_key));
        $api_response = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON response
        $api_data = json_decode($api_response, true);

        if ($api_data['message'] === 'Success') {
            foreach ($api_data['data'] as $booking) {
                $created_at = date('Y-m-d H:i:s', strtotime($booking['createdAt']));
                $data = array(
                    'ab_master_id' => $booking['_id'],
                    'ab_name' => $booking['name'],
                    'ab_address' => isset($booking['address']) ? $booking['address'] : '',
                    'ab_pin' => $booking['pin'],
                    'ab_district' => $booking['district'],
                    'ab_pan_no' => $booking['panNumber'],
                    'ab_aadhaar_no' => $booking['aadhaarNumber'],
                    'ab_pan_img' => $booking['pan'],
                    'ab_aadhaar_img' => $booking['aadhaar'],
                    'ab_advance_amount' => $booking['advanceAmount'],
                    'ab_vehicle' => $booking['vehicle'],
                    'ab_user' => $booking['user'],
                    'ab_created_at' =>  $created_at
                );

                // Insert into the database
                $insert_id = $this->api_booking->insert_booking($data);
                if ($insert_id != -1) {
                    // Data inserted successfully
                    echo 'Data inserted with ID: ' . $insert_id . '<br>';
                } else {
                    // Master ID already exists
                    echo 'Record with the same master ID already exists.<br>';
                }
            }
        } else {
            echo 'API request failed.';
        }
    }
    public function index()
    {
        $this->render_page(strtolower(__CLASS__) . '/list');
    }

    public function list_ajax()
    {
        $response = $this->api_booking->getBookingPaginate($this->input->post());
        //  debug( $response);
        echo json_encode($response);
    }

    function reserve($id)
    {
        //   $vehId = encryptor($vehId, 'D');
        //   $enqId = encryptor($enqId, 'D');
        //   $data['enquiry'] = $this->enquiry->enquires($enqId);
        //   $data['vehicles'] = $this->evaluation->getEvaluationPrint($vehId);
        $data['addressProof'] = $this->booking->getActiveAddressProof(1);
        $data['banks'] = $this->evaluation->getAllBanks();
        $data['booking'] = $this->api_booking->getData($id);
        $this->render_page(strtolower(__CLASS__) . '/reserve', $data);
    }
    function reserveVehicleView($enqId)
    {
        $enqId = encryptor($enqId, 'D');
        $data['stockVehicles'] = $this->booking->getStockVehicles();
        $data['enqId'] = $enqId;
        $html = $this->load->view(strtolower(__CLASS__) . '/popup', $data, true);
        die(json_encode(array('status' => 'success', 'msg' => 'Enquiry assigned to executive!', 'html' => $html)));
    }
    public function get_column_names()
    {
        $table_name = 'cpnl_api_booking';
        //$table_name='cpnl_valuation';

        $sql = "DESCRIBE $table_name";

        $query = $this->db->query($sql);

        // Check if the query was successful
        if ($query) {
            $result = $query->result();

            // Extract and display the column names and data types
            foreach ($result as $row) {
                echo $row->Field . " (" . $row->Type . ")<br>";
            }
        } else {
            echo "Error fetching column names: " . $this->db->error();
        }
    }
}
