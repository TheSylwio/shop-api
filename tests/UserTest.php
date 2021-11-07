<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class UserTest extends ApiTestCase {
	public function testRegister(): void {
		$response = static::createClient()->request('POST', '/api/register', [
			'body' => [
				'email' => 'exampleuser@example.com',
				'password' => 'admin123',
			],
		]);

		$this->assertEquals(201, $response->getStatusCode());
	}
}
