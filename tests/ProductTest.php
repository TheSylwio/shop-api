<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase {
	public function testCreateProduct(): void {
		$client = static::createClient();
		$userRepository = static::getContainer()->get(UserRepository::class);
		$user = $userRepository->findOneBy(['email' => 'johndoe@example.com']);
		$content = json_encode([
			'name' => 'Test Product 1',
			'price' => 29.99,
			'quantity' => 30,
			'description' => 'Test Product 1 description',
		]);

		$client->loginUser($user);
		$client->request('POST', '/api/product/create', [], [], ['CONTENT_TYPE' => 'application/json'], $content);
		$response = $client->getResponse();
		$content = json_decode($response->getContent());

		$this->assertSame(201, $response->getStatusCode());
		$this->assertIsInt($content->id);
		$this->assertIsString($content->name);
		$this->assertIsInt($content->quantity);
		$this->assertIsFloat($content->price);
		$this->assertIsString($content->description);
	}
}
