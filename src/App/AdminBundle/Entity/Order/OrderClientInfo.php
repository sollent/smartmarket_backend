<?php

namespace App\AdminBundle\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderClientInfo
 * @package App\AdminBundle\Entity\Order
 * @ORM\Entity
 * @ORM\Table(name="market_order_client_info")
 */
class OrderClientInfo
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="full_name", type="string", nullable=true)
     */
    private $fullName;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", nullable=true)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="phone_number", type="string")
     */
    private $phoneNumber;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OrderClientInfo
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return OrderClientInfo
     */
    public function setFullName(string $fullName): OrderClientInfo
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return OrderClientInfo
     */
    public function setFirstName(string $firstName): OrderClientInfo
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return OrderClientInfo
     */
    public function setPhoneNumber(string $phoneNumber): OrderClientInfo
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
}