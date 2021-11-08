<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Service\UserService;

final class UserDataPersister implements ContextAwareDataPersisterInterface {
	private UserService $service;

	public function __construct(UserService $service) {
		$this->service = $service;
	}

	public function supports($data, array $context = []): bool {
		return $data instanceof User;
	}

	public function persist($data, array $context = []) {
		return $this->service->createUser($data);
	}

	public function remove($data, array $context = []) {
	}
}