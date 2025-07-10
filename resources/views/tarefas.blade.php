<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas TESTE</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h1 class="mb-4">Lista de Tarefas TESTE</h1>

    <!-- Botões PDF e Logout -->
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('tarefas.exportar-pdf') }}" target="_blank" class="btn btn-primary">📄 Exportar para PDF</a>

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Sair</button>
            </form>
        @endauth
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Erros de validação -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário de criação -->
    <h2>Criar Nova Tarefa</h2>
    <form action="{{ route('tarefas.store') }}" method="POST" class="row g-3 mb-4">
        @csrf
        <div class="col-md-6">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" name="descricao" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="data_prevista" class="form-label">Data Prevista:</label>
            <input type="date" name="data_prevista" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">Adicionar</button>
        </div>
    </form>

    <!-- Tabela de tarefas -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Data de Criação</th>
                    <th>Data Prevista</th>
                    <th>Data de Encerramento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tarefas as $tarefa)
                <tr>
                    <form action="{{ route('tarefas.update', $tarefa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>{{ $tarefa->id }}</td>
                        <td><input type="text" name="descricao" class="form-control" value="{{ $tarefa->descricao }}"></td>
                        <td>{{ $tarefa->created_at ? $tarefa->created_at->format('Y-m-d H:i:s') : '' }}</td>
                        <td><input type="date" name="data_prevista" class="form-control" value="{{ $tarefa->data_prevista }}"></td>
                        <td>{{ $tarefa->data_encerramento ?? 'N/A' }}</td>
                        <td>
                            <select name="status" class="form-select">
                                <option value="pendente" {{ $tarefa->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="concluida" {{ $tarefa->status == 'concluida' ? 'selected' : '' }}>Concluída</option>
                            </select>
                        </td>
                        <td class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    </form>
                    <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $tarefas->links('pagination::bootstrap-5') }}
    </div>

</body>
</html>