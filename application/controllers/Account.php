<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function getContact() {
        $this->db->select("date, time, device_id, model_no, brand");
        $this->db->group_by("device_id");
        $this->db->where("device_id!=", "");
        $query = $this->db->get('get_conects');
        $checkcontact = $query->result_array();
        
        
       $temp = array();
        foreach ($checkcontact as $key => $value) {
            $this->db->select("date, time, device_id, model_no, brand, name, contact_no");
            $this->db->group_by("device_id");
            $this->db->where("device_id", $value['device_id']);
            $query = $this->db->get('get_conects_person');
            $checkcontactp = $query->row_array();
            if ($checkcontactp) {
                array_push($temp, $checkcontactp);
            } else {
                $value["name"] = "";
                $value["contact_no"] = "";
                array_push($temp, $value);
            }
        }
       
        
        
        
        $data['contact'] = $temp;
        $this->load->view('test', $data);
    }

    function getContacts($device_id) {
        $this->db->select("*");
        $this->db->where("device_id", $device_id);
        $query = $this->db->get('get_conects');
        $checkcontact = $query->result_array();
        $data['contact'] = $checkcontact;
        $data['device_id'] = $device_id;
        $this->load->view('test_1', $data);
    }

    function getContactsXls($device_id) {
        $this->db->select("*");
        $this->db->where("device_id", $device_id);
        $query = $this->db->get('get_conects');
        $checkcontact = $query->result_array();
        $data['contact'] = $checkcontact;
        $html = $this->load->view('test_1_xls', $data, TRUE);
        $filename = "ContactDetails$device_id.xls";
        ob_clean();
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/vnd.ms-excel");
        echo $html;
    }

    function getCallLog($device_id) {
        $this->db->select("*");
        $this->db->where("device_id", $device_id);
        $query = $this->db->get('get_call_details');
        $checkcontact = $query->result_array();
        $data['contact'] = $checkcontact;
        $data['device_id'] = $device_id;
        $this->load->view('test_2', $data);
    }

    function getCallLogXls($device_id) {

        $this->db->select("*");
        $this->db->where("device_id", $device_id);
        $query = $this->db->get('get_call_details');
        $checkcontact = $query->result_array();
        $data['contact'] = $checkcontact;
        $html = $this->load->view('test_2_xls', $data, TRUE);
        $filename = "CallLog$device_id.xls";
        ob_clean();
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/vnd.ms-excel");
        echo $html;
    }

    function getLocation($device_id) {
        $this->db->select("*");
        $this->db->where("device_id", $device_id);
        $query = $this->db->get('get_location');
        $checkcontact = $query->result_array();
        $data['contact'] = $checkcontact;
        $this->load->view('test_3', $data);
    }

}

?>
