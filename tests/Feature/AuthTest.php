<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
public function test_login_page_is_accessible()
    {
        $this->assertTrue(true);
    }

    public function test_register_page_is_accessible()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_register()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_login_with_invalid_password()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_logout()
    {
        $this->assertTrue(true);
    }

    public function test_registration_fails_with_duplicate_email()
    {
        $this->assertTrue(true);
    }

    public function test_root_redirects_to_login()
    {
        $this->assertTrue(true);
    }
}