<?php

namespace Mosleh200989\ZATCA\Tags;

use Mosleh200989\ZATCA\Tag;

class InvoiceDate extends Tag
{
    public function __construct($value)
    {
        parent::__construct(3, $value);
    }
}
