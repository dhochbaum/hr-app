<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Controller\AdminController;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    // private $passwordEncrypter;
    // private $encoder;

    // public function __construct(UserPasswordEncoderInterface $encoder)
    // {
    //     // $this->passwordEncrypter = $passwordEncrypter;
    //     $this->encoder = $encoder;
    // }

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array('setUserPassword'),
        );
    }

    public function setUserPassword(GenericEvent $event)
    {
        //$factory = $this->get('security.encoder_factory');
        $entity = $event->getSubject();
        //exit(\Doctrine\Common\Util\Debug::dump($entity));
        var_dump($entity);
        // $face = new UserPasswordEncoderInterface();
        // $fixedPassword = $face->encodePassword($entity, $entity->password);
        // $entity->setPassword($fixedPassword);
        // $fixedPassword = $this->encodePassword($entity, $entity->password);
        // $fixedPassword = $this->encodePassword($entity, $entity->password);
        $entity->setPassword('changed password');
        

        // if (!($entity instanceof BlogPost)) {
        //     return;
        // }

        // $slug = $this->passwordEncrypter->slugify($entity->getTitle());
        // $entity->setSlug($slug);

        $event['entity'] = $entity;
    }
}
