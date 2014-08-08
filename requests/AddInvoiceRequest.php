<?php
namespace billmate\requests;
use billmate\Billmate;
use billmate\Address;
use billmate\OrderItem;

class AddInvoiceRequest extends BillmateRequest
{
    const METHOD = 'addInvoice';

    const AUTO_ACTIVATE = 0;

    protected $person_number;
    protected $reference;
    protected $reference_code;
    protected $order_id1;
    protected $order_id2;
    protected $flags;
    protected $country;
    protected $currency;
    protected $language;
    protected $pclass;

    protected $shippingAddress;
    protected $billingAddress;
    protected $orderItems;

    public function __construct(Billmate $api, $personNumber)
    {
        parent::__construct($api);
        $this->person_number = $personNumber;

        $this->orderItems = array();
        $this->flags      = 0;
        $this->pclass     = -1;
        $this->currency   = 'SEK';
        $this->language   = 'sv';
    }

    public function addItem(OrderItem $item) {
        $this->orderItems[] = $item;
    }

    public function toArray()
    {
        /* Order items */
        $items = array();
        foreach($this->orderItems as $item)
            $items[] = $item->toArray();

        return array(
            'personnumber'    => $this->person_number,
            'orderid1'        => $this->order_id1,
            'orderid2'        => $this->order_id2,
            'reference'       => $this->reference,
            'reference_code'  => $this->reference_code,
            'currency'        => $this->currency,
            'country'         => $this->country,
            'language'        => $this->language,
            'pclass'          => $this->pclass,

            'goodsList'       => $items,
            'flags'           => $this->getFlags(),
            'shippingaddress' => $this->shippingAddress->toArray(),
            'billingaddress'  => $this->billingAddress->toArray(),
        );
    }

    protected function getFlags() {
    }
}
?>
