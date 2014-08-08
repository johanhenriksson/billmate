<?php
namespace billmate;

/**
 * Billmate Card Pay Request
 * @author Johan Henriksson
 */
class CardPayRequest extends BillmateRequest
{
    const METHOD = 'cardPay';

    const CARD = 'CARD';
    const BANK = 'BANK';
    const BOTH = 'PAYWIN';

    protected static $__PaymentMethods = array(static::CARD, static::BANK, static::BOTH);

    protected $order_id;
    protected $amount;
    protected $currency;
    protected $payment_method;
    protected $return_method;
    protected $prompt_name_entry;
    protected $do_3d_secure;
    protected $capture_now;
    protected $result_redirect;

    public function __construct(Billmate $api, $order_id, $amount, $currency = 'SEK') 
    {
        $this->order_id = $order_id;
        $this->amount   = intval($amount);
        $this->currency = $currency;

        /* Default settings */
        $this->return_method       = 'POST';
        $this->payment_method      = static::BOTH;
        $this->prompt_name_entry   = false;
        $this->do_3d_secure        = true;
        $this->capture_now         = true;
        $this->result_redirect     = true;
        $this->create_subscription = false;
    }

    public function getPaymentMethod()  { return $this->payment_method; }
    public function getResultRedirect() { return $this->result_redirect; }
    public function getCaptureNow()     { return $this->capture_now; }

    public function setPaymentMethod($method) 
    {
        if (!in_array($method, static::$__PaymentMethods))
            throw new \BillmateException("Invalid payment method: $method");

        $this->payment_method = $method;
        return $this;
    }

    public function setResultRedirect($redirect) 
    {
        $this->result_redirect = boolval($redirect);
        return $this;
    }

    public function setCaptureNow($capture_now) 
    {
        $this->capture_now = boolval($capture_now);
        return $this;
    }

    protected function validate()
    {
        if ($this->amount < 0)
            throw new \BillmateException("Total amount must be a positive integer (was: {$this->amount})");
        return true;
    }

    public function toArray()
    { 
        return array(
            /* Fields */
            'merchant_id'   => $this->api->getEID(),
            'order_id'      => $this->order_id,
            'amount'        => $this->amount,
            'pay_method'    => $this->payment_method,
            'return_method' => $this->return_method,

            /* Urls */
            'accept_url'    => $this->api->getAcceptUrl(),
            'cancel_url'    => $this->api->getCancelUrl(),
            'callback_url'  => $this->api->getCallbackUrl(),
            
            /* Bool settings */
            'prompt_name_entry'   => Billmate::boolstr($this->prompt_name_entry),
            'do_3d_secure'        => Billmate::boolstr($this->do_3d_secure),
            'capture_now'         => Billmate::boolstr($this->capture_now),
            'result_redirect'     => Billmate::boolstr($this->result_redirect),
            'create_subscription' => Billmate::boolstr($this->create_subscription),

            /* Compute checksum */
            'mac' => $this->computeMac(),
        );
    }

    protected function computeMac()
    {
        return hash('sha256', implode('', array(
            $this->api->getAcceptUrl(),
            $this->amount,
            $this->api->getCallbackUrl(),
            $this->currency,
            $this->api->getEID(),
            $this->order_id,
            $this->payment_method,
            $this->api->getKey(),
        )));
    }
}
?>
