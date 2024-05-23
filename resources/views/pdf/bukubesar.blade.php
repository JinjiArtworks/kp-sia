<!-- resources/views/pdf/users.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Buku Besar</title>
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
    <h1>Buku Besar</h1>
    <table id="datatable-1" class="table data-table table-striped table-bordered">
        <thead>
            <tr>
                <th>No Akun</th>
                <th>Nama Akun</th>
                <th>Keterangan</th>
                <th>Tipe Coa</th>
                <th>Tanggal</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cashflow as $item)
                <tr>
                    <td>{{ $item->no_reff }}</td>
                    <td>{{ $item->nama_akun }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->coa_name }}</td>
                    <td>{{ $item->date }}</td>
                    <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                    <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                    <td class="text-right">{{ formatToIDR($item->saldo) }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</body>

</html>
