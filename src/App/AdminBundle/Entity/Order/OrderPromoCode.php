<?php

namespace App\AdminBundle\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderPromoCode
 * @package App\AdminBundle\Entity\Order
 * @ORM\Entity
 * @ORM\Table(name="market_order_promo_code")
 */
class OrderPromoCode
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="promo_hash", type="string", nullable=true)
     */
    private $promoHash;

    /**
     * @var integer
     * @ORM\Column(name="marks", type="integer")
     */
    private $marks = 0;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OrderPromoCode
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPromoHash(): string
    {
        return $this->promoHash;
    }

    /**
     * @param string $promoHash
     * @return OrderPromoCode
     */
    public function setPromoHash(string $promoHash): OrderPromoCode
    {
        $this->promoHash = $promoHash;
        return $this;
    }

    /**
     * @return int
     */
    public function getMarks(): ?int
    {
        return $this->marks;
    }

    /**
     * @param int $marks
     * @return OrderPromoCode
     */
    public function setMarks(int $marks): OrderPromoCode
    {
        $this->marks = $marks;
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
     * @return OrderPromoCode
     */
    public function setCreatedAt(\DateTime $createdAt): OrderPromoCode
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        if ($this->updatedAt) {
            return $this->updatedAt->format('Y-m-d H:i:s');
        }

        return null;
    }

    /**
     * @param \DateTime $updatedAt
     * @return OrderPromoCode
     */
    public function setUpdatedAt(\DateTime $updatedAt): OrderPromoCode
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}