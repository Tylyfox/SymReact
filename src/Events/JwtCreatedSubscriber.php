<?php

namespace App\Events;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber
{
    public function updateJwtData(JWTCreatedEvent $event)
    {
       // 1. récupérer l'utilisateur pour avoir son lastname et firstname
        $user = $event->getUser();
        // 2. Enrichier les data pour qu'elles contiennent ces données
        $data = $event->getData();
        $data['firstName'] = $user->getFirstName();
        $data['lastName'] = $user->getlastName();

        $event ->setData($data);

    }
}
