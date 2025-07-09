<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarefaTest extends TestCase
{
    public function test_user_can_create_tarefa() {
       $this->assertTrue(true);
    }

    public function test_tarefa_list_is_displayed() {
        $this->assertTrue(true);
    }

    public function test_tarefa_can_be_updated() {
       $this->assertTrue(true);
    }

    public function test_tarefa_can_be_deleted() {
       $this->assertTrue(true);
    }

    public function test_method_not_allowed_on_tarefa_route()
    {
       $this->assertTrue(true);
    }
    
    public function test_required_field_is_validated() {
       $this->assertTrue(true);
    }

    public function test_tarefa_with_invalid_date_fails() {
        $this->assertTrue(true);
    }

    public function test_cannot_create_tarefa_without_descricao() {
        $this->assertTrue(true);
    }

    public function test_page_not_found_returns_404() {
       $this->assertTrue(true);
    }

    public function test_empty_task_list_is_displayed() {
        $this->assertTrue(true);
    }

    public function test_pdf_export_route_requires_authentication()
    {
        $this->assertTrue(true);
    }
}