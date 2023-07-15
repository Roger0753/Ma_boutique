<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Entity\Categorie;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

 class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class =>['setCreatedAt'],
            BeforeEntityUpdatedEvent::class =>['setUpdatedAt']
        ];
    }

    public function setCreatedAt(BeforeEntityPersistedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();

        if(!$entityInstance instanceof Product && !$entityInstance instanceof Categorie) return;

        $entityInstance->setCreatedAt(new \DateTimeImmutable);
    }

    public function setUpdatedAt(BeforeEntityUpdatedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();

        if(!$entityInstance instanceof Product && !$entityInstance instanceof Categorie) return;

        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
    }
    
}
