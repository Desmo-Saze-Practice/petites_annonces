<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationNotifierService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotificationToAdmin(User $user)
    {
        $email = new Email();
        $email
            ->from('noreply@cda-2021-2022.com')
            ->to('admin@cda-2021-2022.com')
            ->subject('Un utilisateur s\'est inscrit')
            ->text('L\'utilisateur ' . $user->getEmail() . ' s\'est inscrit')
        ;
        $this->mailer->send($email);
    }

    public function sendNotificationToUser(User $user)
    {
        $email = new Email();
        $email
            ->from('noreply@cda-2021-2022.com')
            ->to($user->getEmail())
            ->subject('Bienvenue sur la plateforme')
            ->text('Achetez, vendez et spéculez sur des millions des NFT')
        ;
        $this->mailer->send($email);
    }
}