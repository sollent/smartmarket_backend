<?php

namespace App\AdminBundle\Service;

/**
 * Class PromoCodeService
 * @package App\AdminBundle\Service
 */
class PromoCodeService
{
    /**
     * @var string
     */
    const CHARTS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @return string
     */
    public function generateOrderPromoCode(): ?string
    {
        $promoHash = '';

        for ($i = 0; $i < 10; $i++) {
            $promoHash .= self::CHARTS[mt_rand(0, strlen(self::CHARTS) - 1)];
        }

        return $promoHash;
    }
}