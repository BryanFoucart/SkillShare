<?php

declare(strict_types=1);

namespace App\core;

class corsMiddleWare
{
    public function handle()
    {
        header('Access-Control-Allow-Origin: http://localhost:3001');
    }
}
