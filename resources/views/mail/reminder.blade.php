<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
 <title>SAR GEMAS</title>
    <style>
        :root {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <h1>Peringatan: Pembayaran Tertunggak</h1>
    <p>Tuan/Puan {{ $parent->user->name }},</p>

    <p>Sila selesaikan bayaran yuran/pembayaran berikut untuk mengelakkan sebarang kesulitan:</p>



    @foreach ($unpaidFees as $student_id => $fees)
        @php
            $student = \App\Models\Student::find($student_id);
        @endphp

        <h4>Nama Pelajar: {{ $student->name }}</h4>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis Yuran</th>
                    <th>Jumlah</th>
                    <th>Tarikh Akhir Bayaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalAmount = 0;
                @endphp

                @foreach ($fees as $index => $feetype_id)
                    @php
                        $feetype = \App\Models\Feetype::find($feetype_id);
                        $totalAmount += $feetype->amount;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $feetype->name }}</td>
                        <td>RM {{ number_format($feetype->amount, 2) }}</td>
                        <td>{{ $feetype->due }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="2"><strong>Jumlah perlu dibayar: </strong></td>
                    <td colspan="2">RM {{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    {{-- @php
        dd($unpaidFees);
    @endphp --}}


    <p>Terima kasih atas perhatian segera anda.</p>
    <p>Salam sejahtera,<br>Jabatan Kewangan</p>


</body>

</html>
