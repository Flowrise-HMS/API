<?php

namespace Modules\Api\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    private const string PASSWORD = 'secret-password';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'api-test@example.com',
            'password' => Hash::make(self::PASSWORD),
            'branch_id' => null,
        ]);
    }

    public function test_login_with_valid_credentials_returns_token(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => self::PASSWORD,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => ['token', 'user' => ['id', 'name', 'email']],
        ]);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.user.id', $this->user->id);
    }

    public function test_login_with_invalid_credentials_returns_401(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertJsonPath('success', false);
    }

    public function test_logout_requires_authentication(): void
    {
        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertStatus(401);
    }

    public function test_logout_deletes_token(): void
    {
        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertCount(0, $this->user->tokens);
    }

    public function test_unauthenticated_request_gets_envelope_error(): void
    {
        $response = $this->getJson('/api/v1/drugs');

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_getting_drugs_without_branch_returns_403(): void
    {
        $userWithoutBranch = User::factory()->create([
            'email' => 'nobranch@example.com',
            'password' => Hash::make(self::PASSWORD),
            'branch_id' => null,
        ]);

        $token = $userWithoutBranch->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/v1/drugs');

        $response->assertStatus(403);
        $response->assertJson(['success' => false]);
    }
}
