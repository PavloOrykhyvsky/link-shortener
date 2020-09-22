<?php

namespace App\Service\Shortener;

use App\Entity\Link;

class Shortener
{
    private Encoder $encoder;

    public function __construct(Encoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function uniqueUrlPath(Link $link)
    {
        return $this->encoder->encode($link->getId());
    }
}
