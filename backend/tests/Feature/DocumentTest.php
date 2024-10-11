<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_document_with_jwt()
    {
        // Create new user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'), 
        ]);

        // Login and getting token
        $loginResponse = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password', 
        ]);

        // checking logging
        $loginResponse->assertStatus(200);

        // get token with response
        $token = $loginResponse->json('token');

        // send request to upload document using token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token, // add token into header
        ])->post('/api/documents', [
            'title' => 'Test Document',
            'documentType' => 'doc',
            'document' => UploadedFile::fake()->create('document.pdf', 100), // محاكاة رفع الملف
        ]);

        // response
        $response->assertStatus(201);

        // Check if the document sent succesfully
        $this->assertDatabaseHas('documents', [
            'title' => 'Test Document'
        ]);
    }
}
