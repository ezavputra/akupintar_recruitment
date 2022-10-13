<?php
namespace App\Http\Controllers\spi;

/**
 * Description of SC SPI Message Request<br>
 * Class for make redirect request.<br>
 * @author Reza Ishaq M <rezaishaqm@gmail.com>
 */

class SpiMessage {

    var $_bases_model = array(
        "cms" => "",
        "spi_callback" => "",
        "url_listener" => "",
        "spi_currency" => "",
        "spi_item" => [],
        "spi_is_escrow" => "",
        "spi_amount" => "",
        "spi_signature" => "",
        "spi_token" => "",
        "spi_merchant_transaction_reff" => "",
        "spi_merchant_discount" => "",
        "spi_item_expedition" => "",
        "spi_expedition_name" => "",
        "spi_expedition_type" => "",
        "spi_expedition_code" => "",
        "spi_expedition_price" => "",
        "spi_billingPhone" => "",
        "spi_billingEmail" => "",
        "spi_billingName" => "",
        "spi_billingPostalCode" => "",
        "spi_billingAddress" => "",
        "spi_billingCity" => "",
        "spi_paymentDate" => "",
        "get_link" => "no",
        "skip_spi_page" => "0",
    );

    const _spi_item_name = "name";
    const _spi_item_sku = "sku";
    const _spi_item_qty = "qty";
    const _spi_item_unitPrice = "unitPrice";
    const _spi_item_desc = "desc";
    const _spi_token = "spi_token";
    

    var $_spi_item_arr = array(
        self::_spi_item_name => "",
        self::_spi_item_desc => "",
        self::_spi_item_qty => "",
        self::_spi_item_sku => "",
        self::_spi_item_unitPrice => "",
        
    );
    var $_item_name = self::_spi_item_name;
    var $_item_sku = self::_spi_item_sku;
    var $_item_qty = self::_spi_item_qty;
    var $_item_desc = self::_spi_item_desc;
    var $_item_unit_price = self::_spi_item_unitPrice;


    var $_cms = "cms";
    var $_spi_callback = "spi_callback";
    var $_url_listener = "url_listener";
    var $_spi_currency = "spi_currency";
    var $_spi_item = "spi_item";
    var $_spi_is_escrow = "spi_is_escrow";
    var $_spi_amount = "spi_amount";
    var $_spi_token = "spi_token";
    var $_spi_merchant_transaction_reff = "spi_merchant_transaction_reff";
    var $_spi_item_expedition = "spi_item_expedition";
    var $_spi_merchant_discount = "spi_merchant_discount";
    var $_spi_expedition_name = "spi_expedition_name";
    var $_spi_expedition_type = "spi_expedition_type";
    var $_spi_expedition_code = "spi_expedition_code";
    var $_spi_expedition_price = "spi_expedition_price";
    
    var $_spi_billingPhone = "spi_billingPhone";
    var $_spi_billingEmail = "spi_billingEmail";
    var $_spi_billingCountry = "spi_billingCountry";
    var $_spi_billingState = "spi_billingState";
    var $_spi_billingName = "spi_billingName";
    var $_spi_billingPostalCode = "spi_billingPostalCode";
    var $_spi_billingAddress = "spi_billingAddress";
    var $_spi_billingCity = "spi_billingCity";
    var $_spi_paymentDate = "spi_paymentDate";
    var $_spi_signature = "spi_signature";
    
    function __construct() 
    {
        
    }
    
    function get_raw_item($object, $key)
    {
        if(array_key_exists($key, $object)){
            return $object[$key];
        }
        return "";
    }
    
    function set_item($key, $val, $parent="")
    {
        if($parent !== "")
        {
            $this->_bases_model[$parent][$key] = $val;
        }
        else
        {
            $this->_bases_model[$key] = $val;
        }
    }
    
    function get_item($key, $parent="")
    {
        if($parent !== "")
        {
            return $this->_bases_model[$parent][$key];
        } 
        else 
        {
            if(array_key_exists($key, $this->_bases_model)){
                return $this->_bases_model[$key];
            }
        }
        return "";
    }
    
    function get_spi_item($key, $index=0)
    {
        $item = $this->get_item($this->_spi_item);
        if(is_array($item))
        {    
            if(array_key_exists($key, $item[$index])){
                return $item[$index][$key];
            }
        }else{
            if($key == self::_spi_item_name){
                return $this->get_item($this->_spi_item);
            }else if($key == self::_spi_item_desc){
                return $this->get_item($this->_spi_item_description);
            }else if($key == self::_spi_item_qty){
                return $this->get_item($this->_spi_quantity);
            }else if($key == self::_spi_item_unitPrice){
                return $this->get_item($this->_spi_price);
            }
        }
        return "";
    }
    
    function create_spi_message(&$msg) 
    {
        $request = json_decode($msg, TRUE);
        if (json_last_error() == JSON_ERROR_NONE) {
            foreach($request as $key => $val)
            {
                if(array_key_exists($key, $this->_bases_model)){
                    $this->_bases_model[$key] = $val;
                }else{
                    $this->_bases_model[$key] = $val;
                }
            }
        }else{
            throw new \Exception('Not Authorized, Failed format message!');
        }
    }
    
    public function getJson(){
        return json_encode($this->_bases_model);
    }

    public function getMessage(){
        return $this->_bases_model;
    }
}
