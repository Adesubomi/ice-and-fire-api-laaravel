<?php

namespace App\Services\IceAndFire;

use Illuminate\Http\Client\Response;

interface IceAndFireContract
{
    public function getBooks(?string $bookName=null): Response;
}
