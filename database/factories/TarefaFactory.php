<?php

namespace Database\Factories;

use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TarefaFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica está criando.
     *
     * @var string
     */
    protected $model = Tarefa::class;

    /**
     * Defina os dados fictícios da tarefa.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descricao' => $this->faker->sentence(10), // Descrição com 10 palavras
            'data_criacao' => now(), // Data de criação atual
            'data_prevista' => $this->faker->date(), // Data aleatória no formato Y-m-d
            'status' => $this->faker->randomElement(['pendente', 'em andamento', 'concluída']), // Status aleatório
            //'prioridade' => $this->faker->randomElement(['baixa', 'média', 'alta']), // Prioridade aleatória
            'data_encerramento' => $this->faker->optional()->date(), // Data de conclusão opcional
            //'created_at' => now(), // Data de criação
            //'updated_at' => now(), // Data de atualização
        ];
    }
}