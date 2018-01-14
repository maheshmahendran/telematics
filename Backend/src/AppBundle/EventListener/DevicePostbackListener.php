<?php

namespace AppBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Device;

/**
 * Class DevicePostbackListener
 * @package AppBundle\EventListener
 */
class DevicePostbackListener
{
    private $container;

    /**
     * DevicePostbackListener constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Device) {
            //We can do whatever in event
        }
    }
}
