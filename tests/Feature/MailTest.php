<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailTest extends TestCase
{
    // public function test_email_is_sent_on_user_registration() {
    //     Mail::fake();
    
    //     $email = 'teste@email.com';
    //     \App\Models\User::where('email', $email)->delete();
    
    //     $this->post('/register', [
    //         'name' => 'Teste',
    //         'email' => $email,
    //         'password' => 'senha123',
    //         'password_confirmation' => 'senha123',
    //     ]);
    
    //     Mail::assertSent(\App\Mail\NewUserRegister::class);
    
    //     \App\Models\User::where('email', $email)->delete();
    // }
}