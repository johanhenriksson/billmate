<?php
namespace billmate;

class Address
{
    protected $fname;
    protected $lname;
    protected $street; /* Address 1 */
    protected $zip;
    protected $city;
    protected $country;
    protected $email;
    protected $telno;
    protected $cellno;

    protected $company;
    protected $careof;
    protected $house_number;
    protected $house_extension; /* Address 2 */

    public function __construct($firstName, $lastName, $street = "", $zipcode = "", $city = "", $country = "")
    {
        $this->fname   = $firstName;
        $this->lname   = $lastName;
        $this->street  = $street;
        $this->zip     = $zipcode;
        $this->city    = $city;
        $this->country = $country;
    }

    public function getFirstName() { return $this->fname; }
    public function getLastName()  { return $this->lname; }
    public function getEmail()     { return $this->email; }
    public function getStreet()    { return $this->street; }
    public function getCity()      { return $this->city; }
    public function getZipcode()   { return $this->zipcode; }


    public function toArray()
    {
        return array(
            'fname'   => $this->fname,
            'lname'   => $this->lname,
            'street'  => $this->street,
            'zip'     => $this->zip,
            'city'    => $this->city,
            'country' => $this->country,
            'telno'   => $this->telno,
            'cellno'  => $this->cellno,
            'email'   => $this->email,

            'company'         => $this->company,
            'careof'          => $this->careof,
            'house_number'    => $this->house_number,
            'house_extension' => $this->house_extension,
        );
    }

    public static function fromArray(array $array) 
    {
        $address = new BillmateAddress();
        foreach($array as $key => $value)
            $address->$key = $value;
        return $address;
    }
}
?>
