<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class UserService implements UserServiceInterface
{
    private $userRepository;
    private $security;

    public function __construct(UserRepository $userRepository,Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function save(User $user): bool
    {
        $this->checkRoles($user);

        return $this->userRepository->insert($user);
    }

    public function edit(User $user): bool
    {
        return $this->userRepository->update($user);
    }

    public function currentUser(): ?User
    {
        return $this->security->getUser();
    }

    /**
     * @param User $user
     */
    private function checkRoles(User $user): void
    {
        $allUser = count($this->userRepository->findAll());
        switch ($allUser) {
            case "0":
                $user->setRoles(['ROLE_ADMIN']);
                break;
            default:
                $user->setRoles(['ROLE_USER']);
                break;
        }
    }
}