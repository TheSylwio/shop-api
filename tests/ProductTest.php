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

	public function testUpdateProduct() {
		$client = static::createClient();
		$content = json_encode([
			'name' => 'Test Product 2',
			'price' => 129.99,
			'quantity' => 50,
			'description' => 'Test Product 2 description',
		]);
		$userRepository = static::getContainer()->get(UserRepository::class);
		$user = $userRepository->findOneBy(['email' => 'johndoe@example.com']);
		$client->loginUser($user);

		// Save product
		$client->request('POST', '/api/product/create', [], [], ['CONTENT_TYPE' => 'application/json'], $content);
		$response = $client->getResponse();
		$createdRecord = json_decode($response->getContent());
		$this->assertSame(201, $response->getStatusCode());

		$updateContent = json_encode([
			'name' => 'Test Product 2 New',
			'price' => 150,
			'quantity' => 30,
			'description' => 'Test Product 2 new description',
		]);

		// Update product
		$client->request('PATCH', '/api/product/' . $createdRecord->id . '/update', [], [], ['CONTENT_TYPE' => 'application/json'], $updateContent);
		$newResponse = $client->getResponse();
		$updatedRecord = json_decode($newResponse->getContent());

		$this->assertSame(150, $updatedRecord->price);
		$this->assertSame(30, $updatedRecord->quantity);
	}

	public function testDeleteProduct() {
		// FIXME: Lack of time :(
	}
}
