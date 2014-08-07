<?php
namespace billmate;

abstract class BillmateRequest
{
    protected $api;

    public function __construct(Billmate $api) {
        $this->api = $api;
    }

    public abstract function getMethod();
    public abstract function toArray();

    protected abstract function parseResult(array $result);

    public function execute() 
    {
        $response = $this->api->call($this->getMethod(), $this->toArray());
        return $this->parseResult($response);
    }

    protected function hash(array $args) 
    {
    	$data = implode(":", $args);
    	
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
}
?>
