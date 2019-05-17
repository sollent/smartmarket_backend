<?php

namespace App\AdminBundle\Entity\Order;

use App\AdminBundle\Entity\Product\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderedProducts
 * @package App\AdminBundle\Entity\Order
 * @ORM\Entity
 * @ORM\Table(name="market_ordered_products")
 */
class OrderedProducts
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Order
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Order\Order", inversedBy="products")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var integer
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OrderedProducts
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return OrderedProducts
     */
    public function setOrder(Order $order): OrderedProducts
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return OrderedProducts
     */
    public function setProduct(Product $product): OrderedProducts
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return OrderedProducts
     */
    public function setCount(int $count): OrderedProducts
    {
        $this->count = $count;
        return $this;
    }
}