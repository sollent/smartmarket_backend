<?php

namespace App\AdminBundle\Entity\Order;

use App\AdminBundle\Entity\Product\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 * @package App\AdminBundle\Entity\Order
 * @ORM\Entity
 * @ORM\Table(name="marker_order")
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var OrderClientInfo
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Order\OrderClientInfo")
     * @ORM\JoinColumn(name="client_info_id", referencedColumnName="id")
     */
    private $clientInfo;

    /**
     * @var OrderLocation
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Order\OrderLocation")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    private $location;

    /**
     * @var OrderDeliveryWay
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Order\OrderDeliveryWay")
     * @ORM\JoinColumn(name="delivery_way_id", referencedColumnName="id")
     */
    private $deliveryWay;

    /**
     * @var \DateTime
     * @ORM\Column(name="order_date", type="date")
     */
    private $orderDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="order_time", type="time", nullable=true)
     */
    private $orderTime;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var integer
     * @ORM\Column(name="total_cost", type="integer")
     */
    private $totalCost;

    /**
     * @var integer
     * @ORM\Column(name="order_cost", type="integer")
     */
    private $orderCost;

    /**
     * @var integer
     * @ORM\Column(name="delivery_cost", type="integer")
     */
    private $deliveryCost;

    /**
     * @var OrderPromoCode
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Order\OrderPromoCode")
     * @ORM\JoinColumn(name="promo_code_id", referencedColumnName="id")
     */
    private $promoCode;

    /**
     * @var mixed
     * @ORM\OneToMany(targetEntity="App\AdminBundle\Entity\Order\OrderedProducts", mappedBy="order")
     */
    private $products;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return OrderClientInfo
     */
    public function getClientInfo(): ?OrderClientInfo
    {
        return $this->clientInfo;
    }

    /**
     * @param OrderClientInfo $clientInfo
     * @return Order
     */
    public function setClientInfo(OrderClientInfo $clientInfo): Order
    {
        $this->clientInfo = $clientInfo;
        return $this;
    }

    /**
     * @return OrderLocation
     */
    public function getLocation(): ?OrderLocation
    {
        return $this->location;
    }

    /**
     * @param OrderLocation $location
     * @return Order
     */
    public function setLocation(OrderLocation $location): Order
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return OrderDeliveryWay
     */
    public function getDeliveryWay(): ?OrderDeliveryWay
    {
        return $this->deliveryWay;
    }

    /**
     * @param OrderDeliveryWay $deliveryWay
     * @return Order
     */
    public function setDeliveryWay(OrderDeliveryWay $deliveryWay): Order
    {
        $this->deliveryWay = $deliveryWay;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderDate(): ?string
    {
        return $this->orderDate->format('Y-m-d H:i:s');
    }

    /**
     * @param \DateTime $orderDate
     * @return Order
     */
    public function setOrderDate(\DateTime $orderDate): Order
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    /**
     * @param \DateTime $createdAt
     * @return Order
     */
    public function setCreatedAt(\DateTime $createdAt): Order
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCost(): ?int
    {
        return $this->totalCost;
    }

    /**
     * @param int $totalCost
     * @return Order
     */
    public function setTotalCost(int $totalCost): Order
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrderCost(): ?int
    {
        return $this->orderCost;
    }

    /**
     * @param int $orderCost
     * @return Order
     */
    public function setOrderCost(int $orderCost): Order
    {
        $this->orderCost = $orderCost;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeliveryCost(): ?int
    {
        return $this->deliveryCost;
    }

    /**
     * @param int $deliveryCost
     * @return Order
     */
    public function setDeliveryCost(int $deliveryCost): Order
    {
        $this->deliveryCost = $deliveryCost;
        return $this;
    }

    /**
     * @return OrderPromoCode
     */
    public function getPromoCode(): ?OrderPromoCode
    {
        return $this->promoCode;
    }

    /**
     * @param OrderPromoCode $promoCode
     * @return Order
     */
    public function setPromoCode(OrderPromoCode $promoCode): Order
    {
        $this->promoCode = $promoCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     * @return Order
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Order
     */
    public function setUpdatedAt(\DateTime $updatedAt): Order
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderTime(): ?string
    {
        if (!$this->orderTime) {
            return null;
        }

        return $this->orderTime->format('H:i');
    }

    /**
     * @param \DateTime $orderTime
     * @return Order
     */
    public function setOrderTime(\DateTime $orderTime): Order
    {
        $this->orderTime = $orderTime;
        return $this;
    }
}