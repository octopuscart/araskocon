<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function getContact() {
        $this->db->select("count(device_id) as total, device_id, model_no, brand");
        $this->db->group_by("device_id");
        $this->db->where("device_id!=", "");
        $query = $this->db->get('get_conects');
        $checkcontact = $query->result_array();
        $data['contact'] = $checkcontact;
        $this->load->view('test', $data);
    }
    
    function getContacts($device_id) {
        $this->db->select("*");
        $this->db->where("device_id", $device_id);
        $query = $this->db->get('get_conects');
        $checkcontact = $query->result_array();
        $data['contact'] = $checkcontact;
        $this->load->view('test_1', $data);
    }

}

?>
