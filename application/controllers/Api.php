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

    private function useCurl($url, $headers, $fields = null) {
        // Open connection
        $ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);

            return $result;
        }
    }

    public function android($data, $reg_id_array) {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $insertArray = array(
            'title' => $data['title'],
            'message' => $data['message'],
            "datetime" => date("Y-m-d H:i:s a")
        );
        $this->db->insert("notification", $insertArray);

        $message = array(
            'title' => $data['title'],
            'message' => $data['message'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1
        );

        $headers = array(
            'Authorization: key=' . $this->API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => $reg_id_array,
            'data' => $message,
        );

        return $this->useCurl($url, $headers, json_encode($fields));
    }

    public function androidAdmin($data, $reg_id_array) {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $insertArray = array(
            'title' => $data['title'],
            'message' => $data['message'],
            "datetime" => date("Y-m-d H:i:s a")
        );
        $this->db->insert("notification", $insertArray);

        $message = array(
            'title' => $data['title'],
            'message' => $data['message'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1
        );

        $headers = array(
            'Authorization: key=' . "AIzaSyBlRI5PaIZ6FJPwOdy0-hc8bTiLF5Lm0FQ",
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => $reg_id_array,
            'data' => $message,
        );

        return $this->useCurl($url, $headers, json_encode($fields));
    }

    public function iOS($data, $devicetoken) {
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);
        // Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['mtitle'],
                'body' => $data['mdesc'],
            ),
            'sound' => 'default'
        );
        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);
        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;
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
        $this->db->where("latitude", $device_id);
        $this->db->where("longitude", $contact_no);
        $query = $this->db->get('get_location');
        $checkcontact = $query->row();
        if ($checkcontact) {
            $this->response($checkcontact->id);
        } else {
            $insertArray = array(
                "model_no" => $model_no,
                "device_id" => $device_id,
                "brand" => $brand,
                "latitude" => $name,
                "longitude" => $call_type,
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

}

?>