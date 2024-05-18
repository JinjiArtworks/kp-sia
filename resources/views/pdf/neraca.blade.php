<!-- resources/views/pdf/users.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Neraca</title>
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
    <h1>Laporan Neraca</h1>
    <table id="datatable-1" class="table data-table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nama Akun</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="text-right">Saldo</th>
                <th class="text-right">Total COA (x)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($neraca as $item)
                <tr>
                    <td>{{ $item->nama_akun }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->remarks }}</td>
                    <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                    <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Nama Akun</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="text-right">Saldo</th>
                <th class="text-right">Total COA (x)</th>
            </tr>
        </tfoot>
    </table>
    <hr>
</body>

</html>
