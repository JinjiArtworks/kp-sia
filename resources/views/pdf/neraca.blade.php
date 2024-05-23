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
                {{-- <th>Keterangan</th> --}}
                <th>Tipe Coa</th>
                {{-- <th>Tanggal</th> --}}
                <th class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cashflow as $item)
                <tr>
                    <td>{{ $item->nama_akun }}</td>
                    {{-- <td>{{ $item->name }}</td> --}}
                    <td>{{ $item->coa_name }}</td>
                    {{-- <td>{{ $item->date }}</td> --}}
                    <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Nama Akun</th>
                {{-- <th>Keterangan</th> --}}
                <th>Tipe Coa</th>
                {{-- <th>Tanggal</th> --}}
                <th class="text-right">Saldo</th>
            </tr>
        </tfoot>
    </table>
    <hr>
</body>

</html>
