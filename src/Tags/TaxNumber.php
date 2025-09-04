<?php

namespace Mosleh200989\ZATCA\Tags;

use Mosleh200989\ZATCA\Tag;

class TaxNumber extends Tag
{
    public function __construct($value)
    {
        parent::__construct(2, $value);
    }
}
