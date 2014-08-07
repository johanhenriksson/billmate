<?php
namespace billmate;

use xmlrpc_client;

define('PNO_SWEDEN', 2);

class Billmate
{
    const SERVER   = '0.5.9';
    const CLIENT   = 'PHP:BillMate:0.5.8';
    const URL      = 'api.billmate.se';
    const URL_TEST = 'apitest.billmate.se';

    protected $ssl;
    protected $xmlrpc;
    protected $debug;
    protected $test;

    protected $pno_encoding = 2;

    public function __construct($eid, $key, $ssl = true, $test = false, $debug = false)
    {
        $this->eid   = $eid;
        $this->key   = $key;
        $this->ssl   = $ssl;
        $this->test  = $test;
        $this->debug = $debug;

        $this->pno_encoding = PNO_SWEDEN;

        $this->port     = $ssl  ? 443     : 80;
        $this->protocol = $ssl  ? 'https' : 'http';
        $this->url      = $test ? self::URL_TEST : self::URL;

        $this->createRPC();
    }

    public function getEID() { return $this->eid; }
    public function getKey() { return $this->key; }

    protected function createRPC() 
    {
        $this->xmlrpc = new xmlrpc_client("/", $this->url, $this->port, $this->protocol);
        $this->xmlrpc->request_charset_encoding = 'UTF-8';
    }

    protected functin ip() 
    {
        global $_SERVER;
        return $_SERVER['REMOTE_ADDR'];
    }
    
    public function call($method, array $array = array())
    {
		$this->xmlrpc->verifypeer = false;
		$this->xmlrpc->verifyhost = 0;

        /* Create new RPC message */
        $msg = new xmlrpcmsg($method);

        /* Set parameters */
        $params = array_merge(
            array(static::SERVER, static::CLIENT),
            $array
        );
        foreach ($params as $p) 
            $msg->addParam(php_xmlrpc_encode($p, array('extension_api')));

        $xml_resp = $this->xmlrpc->send($msg);
        $status = $xmlrpcresp->faultCode();
        
        if ($status !== 0) {
            /* Something went wrong */
            throw new BillmateException($xml_resp->faultString());
        }

        return php_xmlrpc_decode($xml_resp->value());
    }
}
?>
