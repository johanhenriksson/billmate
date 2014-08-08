<?php
namespace billmate;

class OrderItem
{
    /* Flag consts */
    const PRINT_1000  = 1;
    const PRINT_100   = 2;
    const PRINT_10    = 4;
    const IS_SHIPPING = 8;
    const IS_HANDLING = 16;
    const INC_VAT     = 32;

    protected $artno;
    protected $title;
    protected $quantity;
    protected $price;         /* Decimal */
    protected $vat_rate;      /* Decimal */
    protected $discount_rate; /* Decimal */

    /* Flags */
    protected $is_shipping;
    protected $inc_vat;

    public function __construct($artno, $title, $price, $quantity, $vat_rate, $discount_rate = 0.0) 
    {
        $this->artno         = $artno;
        $this->title         = $title;
        $this->price         = $price;
        $this->quantity      = $quantity;
        $this->vat_rate      = $vat_rate;
        $this->discount_rate = $discount_rate;
        $this->is_shipping   = false;
        $this->inc_vat       = true;
    }

    protected function getFlags() 
    {
        $flags = 0;
        if ($this->inc_vat)     $flags |= static::INC_VAT;
        if ($this->is_shipping) $flags |= static::IS_SHIPPING;
        return $flags;
    }

    public function toArray()
    {
        return array(
            'artno' => $this->artno,
            'title' => $this->title,
            'price' => $this->price,
            'vat' => $this->vat_rate,
            'qty' => $this->quantity,
            'discount' => $this->discount_rate,
            'flags' => $this->getFlags(),
        );
    }

    public static function fromArray(array $array) 
    {
        $address = new OrderItem();
        foreach($array as $key => $value)
            $address->$key = $value;
        return $address;
    }
}
?>
