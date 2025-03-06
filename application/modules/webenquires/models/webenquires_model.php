<?php
class webenquires_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl_api_booking = TABLE_PREFIX . 'api_booking';
    }

    public function insert_booking($data)
    {
        $master_id = $data['ab_master_id'];

        // Check if the master ID already exists
        $existing_record = $this->db->get_where('cpnl_api_booking', array('ab_master_id' => $master_id))->row();

        if (!$existing_record) {
            // Master ID doesn't exist, proceed with insertion
            $this->db->insert('cpnl_api_booking', $data);
            return $this->db->insert_id();
        } else {
            // Master ID already exists, return -1 or handle accordingly
            return -1;
        }
    }
    public function get_all_bookings()
    {
        // Fetch all records from the cpnl_api_booking table
        $query = $this->db->get('cpnl_api_booking');
        return $query->result();
    }

    function getBookingPaginate($postDatas)
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


        $totalRecords = $this->getBookingTotal($searchValue);


        $selArray = array(
            $this->tbl_api_booking . '.ab_id',
            $this->tbl_api_booking . '.ab_master_id',
            $this->tbl_api_booking . '.ab_name',
            $this->tbl_api_booking . '.ab_address',
            $this->tbl_api_booking . '.ab_pin',
            $this->tbl_api_booking . '.ab_district',
            $this->tbl_api_booking . '.ab_pan_no',
            $this->tbl_api_booking . '.ab_aadhaar_no',
            $this->tbl_api_booking . '.ab_pan_img',
            $this->tbl_api_booking . '.ab_aadhaar_img',
            $this->tbl_api_booking . '.ab_advance_amount',
            $this->tbl_api_booking . '.ab_vehicle',
            $this->tbl_api_booking . '.ab_user',
            "DATE_FORMAT(" . $this->tbl_api_booking . ".ab_created_at, '%d-%m-%Y %H:%i:%s') AS ab_created_at",
        );

        if ($rowperpage > 0) {
            $this->db->limit($rowperpage, $row);
        }

        $data = $this->db->select($selArray)
            ->get($this->tbl_api_booking)->result_array();
        //  echo $this->db->last_query();
        // debug( $data);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
        return $response;
    }

    function getBookingTotal($searchValue)
    {
        $this->db->from($this->tbl_api_booking);
        return $this->db->count_all_results();
    }

    function getData($id)
    {
        $selArray = array(
            $this->tbl_api_booking . '.ab_id',
            $this->tbl_api_booking . '.ab_master_id',
            $this->tbl_api_booking . '.ab_name',
            $this->tbl_api_booking . '.ab_address',
            $this->tbl_api_booking . '.ab_pin',
            $this->tbl_api_booking . '.ab_district',
            $this->tbl_api_booking . '.ab_pan_no',
            $this->tbl_api_booking . '.ab_aadhaar_no',
            $this->tbl_api_booking . '.ab_pan_img',
            $this->tbl_api_booking . '.ab_aadhaar_img',
            $this->tbl_api_booking . '.ab_advance_amount',
            $this->tbl_api_booking . '.ab_vehicle',
            $this->tbl_api_booking . '.ab_user',
            "DATE_FORMAT(" . $this->tbl_api_booking . ".ab_created_at, '%d-%m-%Y %H:%i:%s') AS ab_created_at",
        );

        $this->db->select($selArray)->where($this->tbl_api_booking . '.ab_id', $id);
        return $this->db->get($this->tbl_api_booking)->row_array();
    }
}
