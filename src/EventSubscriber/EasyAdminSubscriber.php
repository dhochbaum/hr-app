<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\User;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $passwordEncrypter;

    public function __construct()
    {
        // $this->passwordEncrypter = $passwordEncrypter;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array('setUserPassword'),
        );
    }

    public function setUserPassword(GenericEvent $event)
    {
        $entity = $event->getSubject();
        $entity->setPassword('changed password');

        // if (!($entity instanceof BlogPost)) {
        //     return;
        // }

        // $slug = $this->passwordEncrypter->slugify($entity->getTitle());
        // $entity->setSlug($slug);

        $event['entity'] = $entity;
    }
}
