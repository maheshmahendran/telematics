<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Device
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DeviceRepository")
 * @ORM\Table(name="devices")
 * @Hateoas\Relation("self", href="expr('/device/' ~ object.getId())")
 */
class Device
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false, unique=true)
     * @ORM\Id
     * @Serializer\Groups({"default"})
     * @Assert\NotNull(
     *     groups={"post"}
     * )
     * @Assert\NotBlank(
     *     groups={"post"},
     *     message="Device ID is required"
     * )
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
     * @ORM\Column(name="deviceLabel", type="datetimetz", nullable=false)
     * @Serializer\Groups({"default"})
     * @Assert\NotNull(
     *     groups={"post"}
     * )
     * @Assert\NotBlank(
     *     groups={"post"},
     *     message="Device Label should not be blank"
     * )
     */
    private $lastReportedTime;

    /**
     * @ORM\Column(name="status", type="string", length=7, nullable=false)
     * @Serializer\Groups({"default"})
     */
    private $status;

    /**
     * @var bool
     */
    private $localized = false;
}