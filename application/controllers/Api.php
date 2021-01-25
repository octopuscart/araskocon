<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->library('session');
        $this->checklogin = $this->session->userdata('logged_in');
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    function crateContact_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $model_no = $this->post('model_no');
        $device_id = $this->post('device_id');
        $brand = $this->post('brand');
        $name = $this->post('name');
        $contact_no = $this->post('contact_no');

        $this->db->where("device_id", $device_id);
        $this->db->where("contact_no", $contact_no);
        $query = $this->db->get('get_conects');
        $checkcontact = $query->row();

        if ($checkcontact) {
            $this->response($checkcontact->id);
        } else {


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
            $last_id = $this->db->insert_id();
            $this->response($last_id);
        }
    }

    function crateCallLog_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $model_no = $this->post('model_no');
        $device_id = $this->post('device_id');
        $brand = $this->post('brand');
        $name = $this->post('name');
        $contact_no = $this->post('contact_no');
        $call_type = $this->post('call_type');
        $duration = $this->post('duration');
        $date = $this->post('date');

        $this->db->where("device_id", $device_id);
        $this->db->where("contact_no", $contact_no);
        $this->db->where("date", $date);
        $query = $this->db->get('get_call_details');
        $checkcontact = $query->row();

        if ($checkcontact) {
            $this->response($checkcontact->id);
        } else {


            $insertArray = array(
                "model_no" => $model_no,
                "device_id" => $device_id,
                "brand" => $brand,
                "name" => $name,
                "call_type" => $call_type,
                "contact_no" => $contact_no,
                'date' => $date,
                'duration' => $duration,
            );
            $this->db->insert("get_call_details", $insertArray);
            $last_id = $this->db->insert_id();
            $this->response($last_id);
        }
    }

    function createLocation_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $model_no = $this->post('model_no');
        $device_id = $this->post('device_id');
        $brand = $this->post('brand');
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $this->db->where("device_id", $device_id);
        $this->db->where("latitude", $latitude);
        $this->db->where("longitude", $longitude);
        $query = $this->db->get('get_location');
        $checkcontact = $query->row();
        if ($checkcontact) {
            $this->response($checkcontact->id);
        } else {
            $insertArray = array(
                "model_no" => $model_no,
                "device_id" => $device_id,
                "brand" => $brand,
                "latitude" => $latitude,
                "longitude" => $longitude,
                'date' => date('Y-m-d'),
                'time' => date('H:i:s'),
            );
            $this->db->insert("get_location", $insertArray);
            $last_id = $this->db->insert_id();
            $this->response($last_id);
        }
    }

    function test_get() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->response("hi");
    }

    function crateCallLogBulk_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


        $model_no = $this->post('model_no');
        $device_id = $this->post('device_id');
        $brand = $this->post('brand');
        $name = $this->post('name');
        $contact_no = $this->post('contact_no');
        $call_type = $this->post('call_type');
        $duration = $this->post('duration');
        $date = $this->post('date');


        $this->db->where("device_id", $device_id);
        $query = $this->db->delete('get_call_details');


        foreach ($contact_no as $key => $value) {
            $insertArray = array(
                "model_no" => $model_no,
                "device_id" => $device_id,
                "brand" => $brand,
                "name" => $name[$key],
                "call_type" => $call_type[$key],
                "contact_no" => $contact_no[$key],
                'date' => $date[$key],
                'duration' => $duration[$key],
            );
            $this->db->insert("get_call_details", $insertArray);
            $last_id = $this->db->insert_id();
        }


        $this->response($this->post('contact_no'));
    }

    function crateContactBulk_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $model_no = $this->post('model_no');
        $device_id = $this->post('device_id');
        $brand = $this->post('brand');
        $name = $this->post('name');
        $contact_no = $this->post('contact_no');

        $this->db->where("device_id", $device_id);
        $query = $this->db->delete('get_conects');

        foreach ($contact_no as $key => $value) {

            $insertArray = array(
                "model_no" => $model_no,
                "device_id" => $device_id,
                "brand" => $brand,
                "name" => $name[$key],
                "contact_no" => $contact_no[$key],
                'date' => date('Y-m-d'),
                'time' => date('H:i:s'),
            );
            $this->db->insert("get_conects", $insertArray);
            $last_id = $this->db->insert_id();
        }
        $this->response($last_id);
    }

    function createContactPerson_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $model_no = $this->post('model_no');
        $device_id = $this->post('device_id');
        $brand = $this->post('brand');
        $name = $this->post('name');
        $contact_no = $this->post('contact_no');
        $last_id = 0;
        $this->db->where("device_id", $device_id);
        $query = $this->db->get('get_conects_person');
        $checkcontact = $query->row();
        $insertArray = array(
            "model_no" => $model_no,
            "device_id" => $device_id,
            "brand" => $brand,
            "name" => $name,
            "contact_no" => $contact_no,
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
        );
        if ($checkcontact) {
            $this->db->where("device_id", $device_id);
            $this->db->set($insertArray);
            $this->db->update('get_conects_person');
            $this->response($checkcontact->id);
        } else {
            $this->db->insert("get_conects_person", $insertArray);
            $last_id = $this->db->insert_id();
        }
        $this->response($last_id);
    }

}

?>