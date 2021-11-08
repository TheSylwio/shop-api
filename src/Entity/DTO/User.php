<?php

namespace App\Entity\DTO;

class User {
	private ?int $id;

	private ?string $email;

	private array $roles = [];

	private string $username;

	private ?string $phone;

	public function getId(): ?int {
		return $this->id;
	}

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail(string $email): self {
		$this->email = $email;

		return $this;
	}

	public function getUsername(): string {
		return (string)$this->email;
	}

	public function setUsername(string $username): self {
		$this->username = $username;

		return $this;
	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array {
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	public function setRoles(array $roles): self {
		$this->roles = $roles;

		return $this;
	}

	public function getPhone(): ?string {
		return $this->phone;
	}

	public function setPhone(?string $phone): self {
		$this->phone = $phone;

		return $this;
	}
}