<?php

namespace App\AdminBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MailerService
 * @package App\AdminBundle\Service
 */
class MailerService extends Controller
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * MailerService constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function sendMessage(string $email): bool
    {
        try {
            $message = (new \Swift_Message('Статус заказа'))
                ->setFrom('smartmarket.by.company@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        '@AppClient/components/email/success-order.html.twig',
                        [ 'email' => $email ]
                    ),
                    'text/html'
                );

            $this->mailer->send($message);
            return true;
        } catch (\Exception $exception) {
            return false;
        }

    }

}