<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if ($errors->has('email'))
        <p style="color:red;">{{ $errors->first('email') }}</p>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <p>Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
</body>
</html>