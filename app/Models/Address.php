<?php

class Address extends Model
{
    private ?int $address_id;
    private ?string $street;
    private ?string $city;

    public function __construct(
        Database $db = new Database(),
        ?int $address_id = null,
        ?string $street = null,
        ?string $city = null
    ) {
        parent::__construct($db);
        $this->address_id = $address_id;
        $this->street = $street;
        $this->city = $city;
    }

    public function createAddress() : int
    {
        try {
            return $this->insert('address', [
                'street' => $this->street,
                'city' => $this->city
            ]);
        } catch (PDOException $e) {
            print $e->getMessage();
            return 0;
        }
    }

    public function getAddressId(): ?int
    {
        return $this->address_id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
}
