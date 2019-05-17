<?php

namespace App\AdminBundle\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductCharacteristicSection
 * @package App\AdminBundle\Entity\Product
 * @ORM\Entity
 * @ORM\Table(name="product_characteristic_section")
 */
class ProductCharacteristicSection
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\AdminBundle\Entity\Product\ProductCharacteristic", mappedBy="parentSection")
     */
    private $childCharacteristics;

    /**
     * ProductCharacteristicSection constructor.
     */
    public function __construct()
    {
        $this->childCharacteristics = new ArrayCollection();
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
     * @return ProductCharacteristicSection
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ProductCharacteristicSection
     */
    public function setName(string $name): ProductCharacteristicSection
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return ProductCharacteristicSection
     */
    public function setProduct(Product $product): ProductCharacteristicSection
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildCharacteristics()
    {
        return $this->childCharacteristics;
    }

    /**
     * @param mixed $childCharacteristics
     * @return ProductCharacteristicSection
     */
    public function setChildCharacteristics($childCharacteristics)
    {
        $this->childCharacteristics = $childCharacteristics;
        return $this;
    }

}