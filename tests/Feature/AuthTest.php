<?php

// namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    // public function test_login_page_is_accessible() {
    //     $response = $this->get('/login');
    //     $response->assertStatus(200);
    // }

    // public function test_register_page_is_accessible() {
    //     $response = $this->get('/register');
    //     $response->assertStatus(200);
    // }

    // public function test_user_can_register() {
    //     $email = 'teste@example.com';
    
    //     \App\Models\User::where('email', $email)->delete();
    
    //     $response = $this->post('/register', [
    //         'name' => 'Teste',
    //         'email' => $email,
    //         'password' => 'senha123',
    //         'password_confirmation' => 'senha123',
    //     ]);
    
    //     $response->assertRedirect('/tarefas');
    //     $this->assertAuthenticated();
    
    //     \App\Models\User::where('email', $email)->delete();
    // }

    // public function test_user_can_login_with_valid_credentials() {
    //     $user = \App\Models\User::factory()->create([
    //         'password' => bcrypt('senha123'),
    //     ]);
    
    //     $response = $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => 'senha123',
    //     ]);
    
    //     $response->assertRedirect('/tarefas');
    //     $this->assertAuthenticatedAs($user);
    
    //     $user->delete();
    // }

    // public function test_user_cannot_login_with_invalid_password() {
    //     $user = \App\Models\User::factory()->create();
    
    //     $response = $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => 'errado123',
    //     ]);
    
    //     $this->assertGuest();
    
    //     $user->delete();
    // }

    // public function test_user_can_logout() {
    //     $user = \App\Models\User::factory()->create();
    //     $this->actingAs($user);
    
    //     $response = $this->post('/logout');
    //     $response->assertRedirect('/login');
    //     $this->assertGuest();
    
    //     $user->delete();
    // }

    // public function test_registration_fails_with_duplicate_email() {
    //     $email = 'duplicado@example.com';
    
    //     \App\Models\User::factory()->create(['email' => $email]);
    
    //     $response = $this->post('/register', [
    //         'name' => 'Teste',
    //         'email' => $email,
    //         'password' => 'senha123',
    //         'password_confirmation' => 'senha123',
    //     ]);
    
    //     $response->assertSessionHasErrors('email');
    
    //     \App\Models\User::where('email', $email)->delete();
    // }

    // public function test_root_redirects_to_login() {
    //     $response = $this->get('/');
    //     $response->assertRedirect('/login');
    // }
}