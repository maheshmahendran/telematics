<?php

namespace AppBundle\Representation;

interface RepresentationInterface
{
    public function getData();
    public function addMeta($key, $value);
}