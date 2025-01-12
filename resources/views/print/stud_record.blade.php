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

        h5 {
            margin: 0
        }

        .card {
            display: flex;
            flex-direction: column;
            padding: 20px 30px;
            border: 1px solid #000;
        }

        table td {
            text-wrap: nowrap;
            border: #ccc solid 1px;
            padding: 10px 25px;

        }

        label {
            padding-right: 30px;
        }

        .hidden-table {
            border: 0;
        }
    </style>

</head>

<body>
    <div class="dashboard mx-auto sm:px--6 h-full flex justify-center relative w-full">

        <div class="p-12 bg-[var(--bg-white)] w-min h-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8">
                <h2 class="text-nowrap pb-5">BUTIRAN PELAJAR</h2>

                <div class="flex gap-5">
                    <table class="hidden-table">
                        <tr>
                            <td colspan="2">Nama Penuh:</td>
                            <td colspan="2">{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Kelas:</td>
                            <td colspan="2">{{ $class->name }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">No. Kad Pengenalan:</td>
                            <td colspan="2">{{ $student->nric }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Tarikh Lahir:</td>
                            <td colspan="2">{{ $student->birthday }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">No. Surat Beranak:</td>
                            <td colspan="2">{{ $student->birth_cert }}</td>
                        </tr>
                        <tr>
                            <th colspan="4">Maklumat Waris</th>
                        </tr>
                        <tr>
                            <td colspan="2">Nama:</td>
                            <td colspan="2">{{ $parent->name }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Pekerjaan:</td>
                            <td colspan="2">{{ $parent->occupation }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Alamat:</td>
                            <td colspan="2">{{ $parent->address }}</td>
                        </tr>
                        <tr>
                            <th colspan="4">Status Yuran</th>
                        </tr>
                        <tr>
                            <td>Bil.</td>
                            <td>Jenis Yuran</td>
                            <td>Amaun (RM)</td>
                            <td>Status</td>
                        </tr>
                        <tbody>
                            @php
                                $feetypes = $feetypes->filter(function ($feetype) use ($student) {
                                    return $feetype->grade_lvl == $student->class->grade_lvl ||
                                        $feetype->grade_lvl == 'all';
                                });
                            @endphp
                            @foreach ($feetypes as $index => $feetype)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $feetype->name }}</td>
                                    <td>{{ number_format($feetype->amount, 2) }}</td>

                                    <td>
                                        @php
                                            // Filter transactions by feetype_id and get distinct transaction statuses
                                            $matchingTransactions = $transactions->where('feetype_id', $feetype->id);
                                            $approvedTransaction = $matchingTransactions->firstWhere(
                                                'status',
                                                'Diluluskan',
                                            );
                                            $pendingTransaction = $matchingTransactions->firstWhere(
                                                'status',
                                                'Pending',
                                            );
                                        @endphp

                                        @if ($approvedTransaction)
                                            {{ $approvedTransaction->status }}
                                        @elseif ($pendingTransaction)
                                            <span>Perlu Disemak</span>
                                        @else
                                            <span>Belum Bayar</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="font-bold">
                                <td colspan="2">Jumlah Sudah Dibayar</td>
                                <td colspan="2">RM
                                    {{ number_format(
                                        $feetypes->filter(function ($feetype) use ($transactions) {
                                                return $transactions->where('feetype_id', $feetype->id)->contains('status', 'Diluluskan');
                                            })->sum('amount'),
                                        2,
                                    ) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
