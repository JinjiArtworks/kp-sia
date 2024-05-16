<!-- resources/views/pdf/users.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Coa List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Coa List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Tipe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coa as $item)
                <tr>
                    <td>{{ $item->nama_akun }}</td>
                    <td>{{ $item->saldo }}</td>
                    <td>{{ $item->tipe_coa->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <h1>Buku Besar</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Tipe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coa as $item)
                <tr>
                    <td>{{ $item->nama_akun }}</td>
                    <td>{{ $item->saldo }}</td>
                    <td>{{ $item->tipe_coa->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
