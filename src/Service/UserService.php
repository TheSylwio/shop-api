<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService {
	private UserPasswordHasherInterface $encoder;
	private EntityManagerInterface $em;

	public function __construct(UserPasswordHasherInterface $encoder, EntityManagerInterface $em) {
		$this->encoder = $encoder;
		$this->em = $em;
	}

	public function createUser(User $user): User {
		$user
			->setPassword($this->encoder->hashPassword($user, $user->getPassword()))
			->setRoles([...$user->getRoles(), 'ROLE_USER']);

		$this->em->persist($user);
		$this->em->flush();

		return $user;
	}
}