<?php

namespace App\AdminBundle\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderLocation
 * @package App\AdminBundle\Entity\Order
 * @ORM\Entity
 * @ORM\Table(name="market_order_location")
 */
class OrderLocation
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var OrderLocationType
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Order\OrderLocationType")
     * @ORM\JoinColumn(name="location_type", referencedColumnName="id")
     */
    private $locationType;

    /**
     * @var string
     * @ORM\Column(name="city", type="string")
     */
    private $city = 'Minsk';

    /**
     * @var string
     * @ORM\Column(name="street",type="string")
     */
    private $street;

    /**
     * @var integer
     * @ORM\Column(name="post_index", type="integer", nullable=true)
     */
    private $postIndex;

    /**
     * @var integer
     * @ORM\Column(name="home_number", type="integer", nullable=true)
     */
    private $homeNumber;

    /**
     * @var integer
     * @ORM\Column(name="apartment_number", type="integer", nullable=true)
     */
    private $apartmentNumber;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OrderLocation
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return OrderLocationType
     */
    public function getLocationType(): ?OrderLocationType
    {
        return $this->locationType;
    }

    /**
     * @param OrderLocationType $locationType
     * @return OrderLocation
     */
    public function setLocationType(OrderLocationType $locationType): OrderLocation
    {
        $this->locationType = $locationType;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return OrderLocation
     */
    public function setStreet(string $street): OrderLocation
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return OrderLocation
     */
    public function setCity(string $city): OrderLocation
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return int
     */
    public function getPostIndex(): ?int
    {
        return $this->postIndex;
    }

    /**
     * @param int $postIndex
     * @return OrderLocation
     */
    public function setPostIndex(int $postIndex): OrderLocation
    {
        $this->postIndex = $postIndex;
        return $this;
    }

    /**
     * @return int
     */
    public function getHomeNumber(): ?int
    {
        return $this->homeNumber;
    }

    /**
     * @param int $homeNumber
     * @return OrderLocation
     */
    public function setHomeNumber(int $homeNumber): OrderLocation
    {
        $this->homeNumber = $homeNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getApartmentNumber(): ?int
    {
        return $this->apartmentNumber;
    }

    /**
     * @param int $apartmentNumber
     * @return OrderLocation
     */
    public function setApartmentNumber(int $apartmentNumber): OrderLocation
    {
        $this->apartmentNumber = $apartmentNumber;
        return $this;
    }
}