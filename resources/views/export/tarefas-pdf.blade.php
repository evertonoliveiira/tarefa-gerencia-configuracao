<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Lista de Tarefas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Data de Criação</th>
                <th>Data Prevista</th>
                <th>Data de Encerramento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tarefas as $tarefa)
                <tr>
                    <td>{{ $tarefa->id }}</td>
                    <td>{{ $tarefa->descricao }}</td>
                    <td>{{ $tarefa->data_criacao }}</td>
                    <td>{{ $tarefa->data_prevista }}</td>
                    <td>{{ $tarefa->data_encerramento ?? 'N/A' }}</td>
                    <td>{{ $tarefa->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>