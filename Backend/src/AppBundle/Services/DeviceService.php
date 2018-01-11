<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 1/11/2018
 * Time: 12:14 PM
 */

namespace AppBundle\Services;

use AppBundle\Entity\Device;
use Doctrine\ORM\EntityManager;

/**
 * Class DeviceService
 * @package AppBundle\Services
 */
class DeviceService
{
    /** @var EntityManager */
    private $em;

    /**
     * DeviceService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Device $device
     * @return mixed
     */
    public function createDevice(Device $device)
    {
        $this->em->merge($device);
        $this->em->flush();
        return $device;
    }

}