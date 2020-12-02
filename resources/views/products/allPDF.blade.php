<html>
<head>
    <meta charset="UTF-8">
    <title> All products</title>
</head>
<body>
<table>
    <tr>
        <th>Product</th>
        <th>Quantity</th>
    </tr>
    @foreach ( $displayProduct as $key => $value)


            <tr>
                <td>{{ $key }}</td>
                <td>{{ $value }}</td>
            </tr>
    @endforeach
</table>
</body>
</html>

