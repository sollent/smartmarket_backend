<?php

namespace App\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class BaseController
 * @package App\AdminBundle\Controller
 */
abstract class BaseController extends Controller
{
    /**
     * @return Serializer
     */
    protected function getSerializer()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = new ObjectNormalizer();
        $normalizers->setCircularReferenceLimit(2)
            ->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
        return new Serializer(array($normalizers, new DateTimeNormalizer()), $encoders);
    }

}