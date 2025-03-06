<?php

  class Sent_model extends CI_Model {

       public function __construct() {
            parent::__construct();
       }

       public function getRows($where = array()) {
            $this->db->select('tickets.id AS ticket_id, categories.categorie, products.product_name, users.user_username, tickets.ticket_title, tickets.ticket_exp, tickets.ticket_date, tickets.ticket_status');
            $this->db->from('tickets');
            $this->db->join('users', 'users.id = tickets.user_id', "INNER");
            $this->db->where($where);
            $this->db->join('products', 'products.id = tickets.product_id', "INNER");
            $this->db->join('categories', 'categories.id = tickets.categorie_id', "INNER");
            return $this->db->get()->result();
       }
  }
?>