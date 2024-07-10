<?php

namespace App\EntityListener;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::prePersist, entity: Mission::class)]
class MissionEntityListener {
    public function __construct(private Security $security)
    {
        
    }

    public function prePersist(Mission $mission, LifecycleEventArgs $events)
    {
        $mission->setUser($this->security->getUser());
    }
}