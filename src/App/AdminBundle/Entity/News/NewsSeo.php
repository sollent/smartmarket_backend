<?php

namespace App\AdminBundle\Entity\News;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class NewsSeo
 * @package App\AdminBundle\Entity\News
 * @ORM\Entity
 * @ORM\Table(name="news_seo")
 */
class NewsSeo
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var News
     * @ORM\OneToOne(targetEntity="App\AdminBundle\Entity\News\News", inversedBy="seoInformations")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     */
    private $news;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return NewsSeo
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return News
     */
    public function getNews(): ?News
    {
        return $this->news;
    }

    /**
     * @param News $news
     * @return NewsSeo
     */
    public function setNews(News $news): NewsSeo
    {
        $this->news = $news;
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
     * @return NewsSeo
     */
    public function setTitle(string $title): NewsSeo
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return NewsSeo
     */
    public function setDescription(string $description): NewsSeo
    {
        $this->description = $description;
        return $this;
    }

}