<?php

namespace App\AdminBundle\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderDeliveryWay
 * @package App\AdminBundle\Entity\Order
 * @ORM\Entity
 * @ORM\Table(name="market_order_delivery_way")
 */
class OrderDeliveryWay
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OrderDeliveryWay
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return OrderDeliveryWay
     */
    public function setName(string $name): OrderDeliveryWay
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return OrderDeliveryWay
     */
    public function setTitle(string $title): OrderDeliveryWay
    {
        $this->title = $title;
        return $this;
    }
}