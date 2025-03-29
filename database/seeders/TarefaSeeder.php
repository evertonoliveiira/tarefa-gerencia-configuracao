<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TarefaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarefas = [
            ['descricao' => 'Finalizar relatório mensal', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-05', 'data_encerramento' => null, 'status' => 'pendente'],
            ['descricao' => 'Revisar código do sistema', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-07', 'data_encerramento' => null, 'status' => 'pendente'],
            ['descricao' => 'Realizar backup do banco de dados', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-02', 'data_encerramento' => null, 'status' => 'pendente'],
            ['descricao' => 'Corrigir bugs reportados', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-10', 'data_encerramento' => null, 'status' => 'em andamento'],
            ['descricao' => 'Preparar apresentação para reunião', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-03', 'data_encerramento' => '2025-04-03', 'status' => 'concluída'],
            ['descricao' => 'Testar nova funcionalidade', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-08', 'data_encerramento' => null, 'status' => 'pendente'],
            ['descricao' => 'Configurar servidor de produção', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-06', 'data_encerramento' => null, 'status' => 'pendente'],
            ['descricao' => 'Criar documentação do projeto', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-12', 'data_encerramento' => null, 'status' => 'em andamento'],
            ['descricao' => 'Atualizar dependências do sistema', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-04', 'data_encerramento' => '2025-04-04', 'status' => 'concluída'],
            ['descricao' => 'Implementar autenticação de dois fatores', 'data_criacao' => Carbon::now(), 'data_prevista' => '2025-04-15', 'data_encerramento' => null, 'status' => 'pendente'],
        ];

        DB::table('tarefas')->insert($tarefas);
    }
}
