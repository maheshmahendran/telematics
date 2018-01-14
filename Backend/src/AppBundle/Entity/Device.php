<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Device
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="devices")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DeviceRepository")
 * @Hateoas\Relation("self", href="expr('/device/' ~ object.getId())")
 */
class Device
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="deviceId", type="string", length=255, nullable=false)
     * @Serializer\Groups({"default"})
     * @Assert\NotNull(
     *     groups={"post"}
     * )
     * @Assert\NotBlank(
     *     groups={"post"},
     *     message="Device ID should not be blank"
     * )
     * @Assert\Length(
     *     groups={"post"},
     *     max="255",
     *     maxMessage="Device ID cannot exceed {{ limit }} characters"
     * )
     */
    private $deviceId;

    /**
     * @ORM\Column(name="deviceLabel", type="string", length=255, nullable=false)
     * @Serializer\Groups({"default"})
     * @Assert\NotNull(
     *     groups={"post"}
     * )
     * @Assert\NotBlank(
     *     groups={"post"},
     *     message="Device Label should not be blank"
     * )
     * @Assert\Length(
     *     groups={"post"},
     *     max="255",
     *     maxMessage="Device Label cannot exceed {{ limit }} characters"
     * )
     */
    private $deviceLabel;

    /**
     * @ORM\Column(name="lastReportedTime", type="datetime", nullable=false)
     * @Serializer\Groups({"default"})
     * @Assert\NotNull(
     *     groups={"post"}
     * )
     * @Assert\NotBlank(
     *     groups={"post"},
     *     message="Device LastReportedTime should not be blank"
     * )
     */
    private $lastReportedTime;

    /**
     * @var string
     * @Serializer\Groups({"default"})
     */
    private $status = 'OFFLINE';

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var bool
     */
    private $localized = false;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set deviceId
     *
     * @param string $deviceId
     *
     * @return Device
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set deviceLabel
     *
     * @param string $deviceLabel
     *
     * @return Device
     */
    public function setDeviceLabel($deviceLabel)
    {
        $this->deviceLabel = $deviceLabel;

        return $this;
    }

    /**
     * Get deviceLabel
     *
     * @return string
     */
    public function getDeviceLabel()
    {
        return $this->deviceLabel;
    }

    /**
     * Set lastReportedTime
     *
     * @param \DateTime $lastReportedTime
     *
     * @return Device
     */
    public function setLastReportedTime($lastReportedTime)
    {
        $this->lastReportedTime = $lastReportedTime;

        return $this;
    }

    /**
     * Get lastReportedTime
     *
     * @return \DateTime
     */
    public function getLastReportedTime()
    {
        return $this->lastReportedTime;
    }

    public function getStatus()
    {

    }
}
