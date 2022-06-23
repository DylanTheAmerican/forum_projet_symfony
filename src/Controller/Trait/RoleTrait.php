<?php

namespace App\Controller\Trait;

Trait RoleTrait
{
    protected function checkRole(string $role)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if (!in_array($role, $this->getUser()->getRoles())) {
            return $this->redirectToRoute('main', ['errors' => 'not_right']);
        }
        return null;
    }
}