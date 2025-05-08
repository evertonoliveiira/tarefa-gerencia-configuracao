<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarefaTest extends TestCase
{
    public function test_user_can_create_tarefa() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->post('/tarefas', [
            'descricao' => 'Nova tarefa',
            'data_prevista' => '2025-12-01',
        ]);
    
        $response->assertRedirect('/tarefas');
        $this->assertDatabaseHas('tarefas', ['descricao' => 'Nova tarefa']);
    
        \App\Models\Tarefa::where('descricao', 'Nova tarefa')->delete();
        $user->delete();
    }

    public function test_tarefa_list_is_displayed() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->get('/tarefas');
        $response->assertStatus(200);
        $response->assertSee('Tarefas');
    
        $user->delete();
    }

    public function test_tarefa_can_be_updated() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $tarefa = \App\Models\Tarefa::factory()->create();
    
        $response = $this->put("/tarefas/{$tarefa->id}", [
            'descricao' => 'Atualizada',
            'data_prevista' => now()->addDay(),
            'status' => 'concluida',
        ]);
    
        $response->assertRedirect('/tarefas');
        $this->assertDatabaseHas('tarefas', ['descricao' => 'Atualizada']);
    
        $tarefa->delete();
        $user->delete();
    }

    public function test_tarefa_can_be_deleted() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $tarefa = \App\Models\Tarefa::factory()->create();
    
        $response = $this->delete("/tarefas/{$tarefa->id}");
    
        $response->assertRedirect('/tarefas');
        $this->assertDatabaseMissing('tarefas', ['id' => $tarefa->id]);
    
        $user->delete();
    }

    public function test_method_not_allowed_on_tarefa_route()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->get('/tarefas/99999');
    
        $response->assertStatus(405);
    }
    
    public function test_required_field_is_validated() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->post('/tarefas', [
            'descricao' => '',
        ]);
    
        $response->assertSessionHasErrors('descricao');
        $user->delete();
    }

    public function test_tarefa_with_invalid_date_fails() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->post('/tarefas', [
            'descricao' => 'Com data errada',
            'data_prevista' => 'data-invalida',
        ]);
    
        $response->assertSessionHasErrors('data_prevista');
        $user->delete();
    }

    public function test_cannot_create_tarefa_without_descricao() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->post('/tarefas', [
            'descricao' => '',
        ]);
    
        $response->assertSessionHasErrors('descricao');
        $user->delete();
    }

    public function test_page_not_found_returns_404() {
        $response = $this->get('/pagina-inexistente');
        $response->assertStatus(404);
    }

    public function test_empty_task_list_is_displayed() {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->get('/tarefas');
        $response->assertStatus(200);
        $response->assertSee('Lista de Tarefas');
    
        $user->delete();
    }

    public function test_pdf_export_route_requires_authentication()
    {
        // Tentar acessar a rota sem estar autenticado
        $response = $this->get('/tarefas/exportar-pdf');
    
        // Verificar se o usuário é redirecionado para a página de login
        $response->assertRedirect('/login');
    }
}