<?php
namespace App\Http\Controllers\spi;

use App\Http\Controllers\spi\SCApiConstant;
use App\Http\Controllers\spi\SCApiContentType;

/**
 * Description of SpiSender<br>
 * Main class for Spi Sender.<br>
 * @author Zainul Alim <za.mi213@gmail.com>
 */
class SpiSender {

    var $URL = "";
    var $PATH = "";
    var $RESULT = array();
    var $DATA = array();
    var $RC = "";
    var $RD = "";
    
    var $ERROR = TRUE;

    const DATA_API = "data";
    const RC_API = "rc";
    const RD_API = "rd";

    public function __construct($url = "") {
        $this->URL = $url;
    }
    function getPATH() {
        return $this->PATH;
    }

    function setPATH($PATH) {
        $this->PATH = $PATH;
    }

        function getURL() {
        return $this->URL;
    }

    function getRESULT() {
        return $this->RESULT;
    }

    function getDATA() {
        return $this->DATA;
    }

    function getRC() {
        return $this->RC;
    }

    function getRD() {
        return $this->RD;
    }

    function setURL($URL) {
        $this->URL = $URL;
    }

    function setRESULT($RESULT) {
        $this->RESULT = $RESULT;
    }

    function setDATA($DATA) {
        $this->DATA = $DATA;
    }

    function setRC($RC) {
        $this->RC = $RC;
    }

    function setRD($RD) {
        $this->RD = $RD;
    }
    
    function isERROR() {
        return $this->ERROR;
    }

    function setERROR($ERROR) {
        $this->ERROR = $ERROR;
    }

        
    private function parseJson($json) {
        if ($json != "") {
            $this->RESULT = $json;
            $result = json_decode($json);
            if (json_last_error() == JSON_ERROR_NONE) {
                if (key_exists(self::RC_API, $result)) {
                    $this->RC = $result->{self::RC_API};
                }
                if (key_exists(self::RD_API, $result)) {
                    $this->RD = $result->{self::RD_API};
                }
                if (key_exists(self::DATA_API, $result)) {
                    $this->DATA = $result->{self::DATA_API};
                }
                $this->ERROR = FALSE;
            }
        }
    }

    public function doGet($path = "", $content = "", $content_type = SCApiContentType::RAW, $basic_auth = "") {
        if (is_array($content)) {
            $content = http_build_query($content);
        }
        $this->PATH = $path;
        $result = file_get_contents($this->URL . $path . "?" . $content, false, $this->createContext("GET", $content, $basic_auth, $content_type));
        $this->parseJson($result);
    }

    public function doPost($path = "", $content = "", $content_type = SCApiContentType::RAW, $basic_auth = "") {
        if (is_array($content) && $content_type == SCApiContentType::JSON) {
            $content = json_encode($content);
        }
        $this->PATH = $path;
        $result = file_get_contents($this->URL . $path, false, $this->createContext("POST", $content, $basic_auth, $content_type));
        $this->parseJson($result);
    }

    public function doCurlGet($path = "", $content = "", $content_type = SCApiContentType::RAW, $basic_auth = "") {
        $this->PATH = $path;
        $result = $this->curlRequest($this->URL . $path, "GET", $content, $content_type, $basic_auth);
        $this->parseJson($result);
    }

    public function doCurlPost($path = "", $content = "", $content_type = SCApiContentType::RAW, $basic_auth = "") {
        if (is_array($content) && $content_type == SCApiContentType::JSON) {
            $content = json_encode($content);
        }
        $this->PATH = $path;
        $result = $this->curlRequest($this->URL . $path, "POST", $content, $content_type, $basic_auth);
        $this->parseJson($result);
    }

    private function curlRequest($url, $method = "GET", $message = "", $content_type = SCApiContentType::RAW, $basic_auth = ""){

        if($method == "GET"){
            $message = http_build_query($message);
            $url = $url . "?" . $message;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        // for security reason please set true in production
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $headers = array(
            "Content-Type: " . $content_type
        );

        if ($basic_auth != "") {
            $headers[] = "Authorization: Basic " . base64_encode($basic_auth);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        if($method == "POST"){
            if (is_array($message) && $content_type == SCApiContentType::JSON) {
                $message = json_encode($message);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
            } else {
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($message));
            }
            
        }

        $response = curl_exec($curl);
        return $response;
    }

    private function createContext($method, $content = "", $basic_auth = "", $content_type = SCApiContentType::RAW) {
        if (is_array($content)) {
            $content = http_build_query($content);
        }

        $opts = array(
            'http' => array(
                'method' => $method,
                'header' => "Content-Type: $content_type\r\n" .
                ($basic_auth != "" ? 'Authorization: Basic ' . base64_encode($basic_auth) . "\r\n" : ""),
                'content' => $content
            ),
            "ssl" => array(
                "verify_peer" => false, // for production please set true
                "verify_peer_name" => false, // for production please set true
            ),
        );
        return stream_context_create($opts);
    }

}