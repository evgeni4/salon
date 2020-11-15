<?php


namespace App\Service\User;


use App\Entity\User;

interface UserServiceInterface
{
    public function save(User $user): bool;

    public function edit(User $user): bool;

    public function currentUser(): ?User;
}