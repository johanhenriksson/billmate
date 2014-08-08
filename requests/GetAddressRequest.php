<?php
namespace billmate\requests;
use billmate\Billmate;

class GetAddressRequest extends BillmateRequest
{
    const METHOD = 'get_addresses';

    protected $pno;

    public function __construct(Billmate $api, $person_number) 
    {
        parent::__construct($api);
        $this->pno = $person_number;
    }

    public function getPersonNumber() {
        return $this->pno;
    }

    public function toArray()
    {
        return array(
            'eid' => $this->api->getEID(),
            'key' => $this->api->getKey(),
            'pno' => $this->pno,
        );
    }

    public function validate() 
    {
        if (empty($this->pno))
            throw new BillmateException("Ogiltigt personnummer");
        return true;
    }

    protected function parseResult(array $response) {
        return $response;
    }
}
?>
