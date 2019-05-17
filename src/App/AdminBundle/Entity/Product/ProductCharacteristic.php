<?php

namespace App\AdminBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductCharacteristic
 * @package App\AdminBundle\Entity\Product
 * @ORM\Entity
 * @ORM\Table(name="product_characteristic")
 */
class ProductCharacteristic
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ProductCharacteristicSection
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\ProductCharacteristicSection")
     * @ORM\JoinColumn(name="parent_section", referencedColumnName="id")
     */
    private $parentSection;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProductCharacteristic
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ProductCharacteristicSection
     */
    public function getParentSection(): ProductCharacteristicSection
    {
        return $this->parentSection;
    }

    /**
     * @param ProductCharacteristicSection $parentSection
     * @return ProductCharacteristic
     */
    public function setParentSection(ProductCharacteristicSection $parentSection): ProductCharacteristic
    {
        $this->parentSection = $parentSection;
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
     * @return ProductCharacteristic
     */
    public function setName(string $name): ProductCharacteristic
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return ProductCharacteristic
     */
    public function setValue(string $value): ProductCharacteristic
    {
        $this->value = $value;
        return $this;
    }

}