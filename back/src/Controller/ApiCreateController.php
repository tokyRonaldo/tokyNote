<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;

class ApiCreateController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security=$security;
    }
    public function __invoke($data){
        $data->setUser($this->security->getUser);
        return $data;
    }
}
