<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
#[ApiResource(
	collectionOperations: [
		'post' => [
			'path' => '/product/create'
		]
	],
	itemOperations: [
		'get' => [
			'path' => '/product/{id}'
		],
		'patch' => [
			'path' => '/product/{id}/update'
		],
		'delete' => [
			'path' => '/product/{id}/delete'
		]
	])]
class Product {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank
	 */
	private $name;

	/**
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank
	 * @Assert\PositiveOrZero
	 */
	private $quantity;

	/**
	 * @ORM\Column(type="float")
	 * @Assert\NotBlank
	 * @Assert\PositiveOrZero
	 */
	private $price;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank
	 */
	private $description;

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

	public function getQuantity(): ?int {
		return $this->quantity;
	}

	public function setQuantity(int $quantity): self {
		$this->quantity = $quantity;

		return $this;
	}

	public function getPrice(): ?float {
		return $this->price;
	}

	public function setPrice(float $price): self {
		$this->price = $price;

		return $this;
	}

	public function getDescription(): ?string {
		return $this->description;
	}

	public function setDescription(string $description): self {
		$this->description = $description;

		return $this;
	}
}
