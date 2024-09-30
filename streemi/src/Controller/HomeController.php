<?php

declare(strict_types=1);

namespace App\Controller;
class HomeController
{
    #[Route('/coucou')]
    public function homepage() : string {
        return new Response('Welcome to Streemi !');
    }
}