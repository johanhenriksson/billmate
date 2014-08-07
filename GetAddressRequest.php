<?php
namespace billmate;

class GetAddressRequest extends BillmateRequest
{
    protected $pno;

    public function __construct(Billmate $api, $person_number) 
    {
        parent::__construct($api);
        $this->pno = $person_number;
    }

    public function getMethod() {
        return 'get_Address';
    }

    public function toArray() {
        return array(
            'eid' => $this->api->getEID(),
            'key' => $this->api->getKey(),

            'pno' => $this->pno;
        );
    }
}
?>
