<?php

namespace AppBundle\Representation;

use JMS\Serializer\Annotation as Serializer;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/** @Serializer\XmlRoot("devices") */
class Devices implements RepresentationInterface
{
    /**
     * @Serializer\XmlKeyValuePairs
     * @Serializer\Groups({"succinct_relationships", "public"})
     */
    public $meta;

    /**
     * @Serializer\Type("array<AppBundle\Entity\Device>")
     * @Serializer\XmlList(inline=false, entry = "device")
     * @Serializer\SerializedName("devices")
     * @Serializer\Groups({"succinct_relationships", "public"})
     */
    public $data;

    public function __construct($query, $total, $limit = 25, $page = 1)
    {
        if ($limit > 50) {
            $limit = 50;
        }
        $pager = new Pagerfanta(new DoctrineORMAdapter($query, true ,false));
        $pager->setMaxPerPage((int)$limit);
        $pager->setCurrentPage($page);
        $this->addMeta('limit', $pager->getMaxPerPage());
        $this->addMeta('page', $page);
        $this->addMeta('current_devices', $pager->getNbResults());
        $this->addMeta('total_devices', (int)$total);
        $this->data = $pager;
    }

    public function addMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMeta($key)
    {
        return $this->meta[$key];
    }
}
