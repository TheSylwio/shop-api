<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture {
	private UserPasswordHasherInterface $encoder;

	public function __construct(UserPasswordHasherInterface $encoder) {
		$this->encoder = $encoder;
	}

	public function load(ObjectManager $manager): void {
		$user = new User();
		$user
			->setEmail('johndoe@example.com')
			->setPassword($this->encoder->hashPassword($user, 'admin123'))
			->setRoles(['ROLE_SUPER_ADMIN']);

		$manager->persist($user);
		$manager->flush();
	}
}
