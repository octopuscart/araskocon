<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    //Profile page
    public function test() {


        $this->load->view('test');
    }

    function crateContact() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $model_no = $this->post('model_no');
        $device_id = $this->post('device_id');
        $brand = $this->post('brand');
        $name = $this->post('name');
        $contact_no = $this->post('contact_no');

        $insertArray = array(
            "model_no" => $model_no,
            "device_id" => $device_id,
            "brand" => $brand,
            "name" => $name,
            "contact_no" => $contact_no,
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
        );
        $this->db->insert("get_conects", $insertArray);
    }

}

?>
