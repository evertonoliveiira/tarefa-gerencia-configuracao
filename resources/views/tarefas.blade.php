<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Lista de Tarefas</h1>

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