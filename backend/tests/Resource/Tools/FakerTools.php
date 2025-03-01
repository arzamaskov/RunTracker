<?php

namespace App\Tests\Resource\Tools;

use Faker\{Factory, Generator};

trait FakerTools
{
    public function getFaker(): Generator
    {
        return Factory::create();
    }
}
