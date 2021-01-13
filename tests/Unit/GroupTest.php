<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Resources\Group;


class GroupTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /**
    * @expectedException Exception
    */

    public function testTotalPrice()
    {
        $group = new Group();
        $group->getTotalPrice();
    }
}
