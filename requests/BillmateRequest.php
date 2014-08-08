<?php
namespace billmate\requests;
use billmate\Billmate;

abstract class BillmateRequest
{
    const METHOD = 'none';

    protected $api;

    public function __construct(Billmate $api) {
        $this->api = $api;
    }

    public abstract function toArray();

    public function execute() 
    {
        $response = $this->api->call($this->getMethod(), $this->toArray());
        return $this->parseResult($response);
    }

    public function getMethod() {
        return static::METHOD;
    }

    protected function hash(array $args) 
    {
    	$data = implode(':', $args);
    	
    	$preferred = array(
            'sha512',
            'sha384',
            'sha256',
            'sha224',
            'md5'
        );

        $hashes = array_intersect($preferred, hash_algos());
        $hash   = array_shift($hashes);

    	return base64_encode(pack("H*", hash($hash, $data)));
    }

    protected functin ip() 
    {
        global $_SERVER;
        return $_SERVER['REMOTE_ADDR'];
    }
}
?>
