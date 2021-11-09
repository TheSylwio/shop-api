<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase {
	public function testAuthorization() {
		$client = static::createClient();
		$content = json_encode([
			'email' => 'johndoe@example.com',
			'password' => 'admin123'
		]);

		$client->request('POST', '/api/authentication_token', [], [], ['CONTENT_TYPE' => 'application/json'], $content);
		$response = $client->getResponse();

		$this->assertSame(200, $response->getStatusCode());
		$this->assertJson($response->getContent());
		$this->assertArrayHasKey('token', json_decode($response->getContent(), true));
	}

	public function testRegister(): void {
		$client = static::createClient();
		$userRepository = static::getContainer()->get(UserRepository::class);
		$user = $userRepository->findOneBy(['email' => 'johndoe@example.com']);

		$now = time();
		$content = json_encode([
			'email' => 'test_' . $now . '@example.com',
			'password' => 'test123',
			'username' => 'testuser_' . $now
		]);

		$client->loginUser($user);
		$client->request('POST', '/api/user/register', [], [], ['CONTENT_TYPE' => 'application/json'], $content);

		$this->assertResponseIsSuccessful();
		$this->assertNotNull($userRepository->findOneBy(['email' => 'test_' . $now . '@example.com']));
	}
}
