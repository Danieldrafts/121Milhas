<?php
namespace App\Models\Resources;


class Group
{
    public $uniqueId;
    public $totalPrice;
    public $outbound = [];
    public $inbound = [];

    public function __construct()
    {
        $this->uniqueId = uniqid();
    }

}

?>