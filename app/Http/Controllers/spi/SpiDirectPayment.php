<?php
namespace App\Http\Controllers\spi;

/**
 * Description of SpiDirectPayment<br>
 * Class for make direct request.<br>
 * @author Zainul Alim <za.mi213@gmail.com>
 */

use App\Http\Controllers\spi\SpiSender;
use App\Http\Controllers\spi\SpiMessage;
use App\Http\Controllers\spi\SpiHelper;

class SpiDirectPayment extends SpiSender {
	var $spiMessage;
	var $token;
	var $encrypt_method;
	var $PRIVATE_KEY1 = "";
	var $PRIVATE_KEY2 = "";
	

	public function __construct() {
		$this->spiMessage = new SpiMessage();
		$this->encrypt_method = 0;
	} 
	
	public function setPrivateKey($pk1 = "", $pk2 = "") {
    	$this->PRIVATE_KEY1 = $pk1;
    	$this->PRIVATE_KEY2 = $pk2;
    }

	public function setEncryptMethod ($method = 0){
		$this->encrypt_method = $method;
	}

	public function setMessageFromJson($json){
		$this->spiMessage->create_spi_message($json);
		$this->spiMessage->set_item($this->spiMessage->_spi_token, $this->PRIVATE_KEY1.$this->PRIVATE_KEY2);
	}

	public function setToken ($token = ""){
		$this->token = $token;
	}

	public function getPaymentMessage() {
		$messagePay = array();
		$message = $this->spiMessage->getJson();
		if($this->encrypt_method == 0){
			$messageEncrypted = SpiHelper::encrypt($message, $this->token);
			$messageEncrypted = substr($messageEncrypted, 0, 10). $this->token. substr($messageEncrypted, 10);
			$messagePay = array("orderdata" => $messageEncrypted);
		} else {
			$messageEncrypted = SpiHelper::OpenSSLEncrypt($message, $this->token);
			$messageEncrypted = substr($messageEncrypted, 0, 10). $this->token. substr($messageEncrypted, 10);
			$messagePay = array("orderdata" => $messageEncrypted);
		}
		return $messagePay;
	}
}