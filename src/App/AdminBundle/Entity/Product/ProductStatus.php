<?php

namespace App\AdminBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductStatus
 * @package App\AdminBundle\Entity\Product
 * @ORM\Entity
 * @ORM\Table(name="product_status")
 */
class ProductStatus
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
     * @return ProductStatus
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
     * @return ProductStatus
     */
    public function setName(string $name): ProductStatus
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ProductStatus
     */
    public function setTitle(string $title): ProductStatus
    {
        $this->title = $title;
        return $this;
    }
    
}