<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 <title>SAR GEMAS</title>


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .title {
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        h5{
            margin: 0
        }
    </style>
</head>

<body>
    <div class="title">
        <h2>
            Rekod Transaksi
        </h2>
        <div>
            <h5>Kelas: {{ $class->grade_lvl }} {{ $class->name }}</h5>
            <h5>Bulan: {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
        </div>

    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelajar</th>
                <th>Jenis Yuran</th>
                <th>Status Transaksi</th>
                <th>Tarikh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->student->name ?? 'Unknown' }}</td>
                    <td>{{ $transaction->feetype->name ?? 'Unknown' }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
