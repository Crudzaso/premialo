<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con Mercado Pago</title>
</head>
<body>
<h1>Formulario de Pago</h1>
<form action="{{ route('mercado_pago.create_payment') }}" method="POST">
    @csrf
    <label for="title">Título del producto:</label>
    <input type="text" name="title" value="Producto de Ejemplo" required><br>

    <label for="quantity">Cantidad:</label>
    <input type="number" name="quantity" value="1" required><br>

    <label for="price">Precio:</label>
    <input type="number" name="price" value="100" required><br>

    <button type="submit">Pagar</button>
</form>

</body>
</html>
