<!DOCTYPE html>
<html>
<head>
    <title>Cifrado César</title>
</head>
<body>
    <h1>Cifrado César</h1>

    <form method="POST" action="/cesar">
        @csrf
        <label>Texto:</label>
        <input type="text" name="texto" required>

        <label>Desplazamiento:</label>
        <input type="number" name="desplazamiento" required>

        <button type="submit">Cifrar</button>
    </form>

    @isset($resultado)
        <h2>Resultado: {{ $resultado }}</h2>
    @endisset
</body>
</html>
