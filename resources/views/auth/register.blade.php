<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>

    @if ($errors->any())
        <div style="color:red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <label>Nome:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirme a Senha:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Registrar</button>
    </form>

    <p>Já tem conta? <a href="{{ route('login') }}">Fazer login</a></p>
</body>
</html>