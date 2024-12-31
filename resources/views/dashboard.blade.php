<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            Laman Utama
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full w-full">
        <div class="py-12 bg-[var(--bg-white)] p-12 h-full w-full">

            @if (Auth::check() && Auth::user()->type === 'parent')
                <div class="main text-gray-900 sm:px--6 lg:px--8 relative">
                    <h2 class="text-nowrap pb-5">ANAK SAYA</h2>

                    <div class="flex gap-3">

                        @foreach ($children as $child)
                            <div class="card">
                                <div> <strong>Nama:</strong> {{ $child->name }}</div>
                                <div> <strong>Kelas:</strong>{{ $child->class->grade_lvl }} {{ $child->class->name }}
                                </div>
                                <div class="pt-5 flex gap-3">
                                    <a href="{{ route('student.details', ['id' => $child->id]) }}"
                                        class="btn upt">Butiran</a>

                                    <form class="w-fit" method="POST"
                                        action="{{ route('student.delete', ['id' => $child->id]) }}">

                                        @csrf
                                        @method('DELETE')
                                        <input class="btn dlt w-full text-center" type="submit" value="Padam">
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="round-btn">
                        <img src="{{ asset('/icons/ic_plus.svg') }}">
                        <span>
                            <a href="{{ route('student.add') }}" class="active opacity-0">Daftar Pelajar Baru</a>
                        </span>
                    </div>
                </div>
            @elseif (Auth::check() && Auth::user()->type === 'teacher')
                @foreach ($class_teaches as $class_teach)
                    <div class="main text-gray-900 sm:px--6 lg:px--8 relative">

                        <h2 class="text-nowrap pb-5">KELAS: {{ strtoupper($class_teach->name) }}</h2>
                        <div class="flex w-full gap-3">

                            <table class="w-full">
                                <thead class="border-b-2 border-gray-900 ">
                                    <tr class="text-nowrap">
                                        <td>No.</td>
                                        <td>ID</td>
                                        <td class="w-full text-left">Nama </td>
                                        <td>Status Bayaran</td>
                                        <td>Suntingan</td>
                                        <td>Notifikasi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        @if ($student->class->id == $class_teach->id)
                                            <tr>
                                                <td>{{ $index + 1 }}</td> <!-- Using $index for the counter -->
                                                <td>{{ $student->id }}</td>
                                                <td class="text-left">{{ $student->name }}</td>

                                                @php
                                                    $paid_transaction_count = \App\Models\Transaction::where(
                                                        'student_id',
                                                        $student->id,
                                                    )
                                                        ->where('status', 'Diluluskan')
                                                        ->count();

                                                    $pending_transaction_count = \App\Models\Transaction::where(
                                                        'student_id',
                                                        $student->id,
                                                    )
                                                        ->where('status', 'Belum Diproses')
                                                        ->count();

                                                    $total_fee_types = $feetypes->count();

                                                    // Determine the status
                                                    if ($pending_transaction_count > 0) {
                                                        $status = 'Perlu Disemak';
                                                    } elseif ($paid_transaction_count === $total_fee_types) {
                                                        $status = 'Selesai';
                                                    } else {
                                                        $status = 'Belum Selesai';
                                                    }
                                                @endphp

                                                <td>{{ $paid_transaction_count }} / {{ $total_fee_types }}</td>
                                                <td class="p-3 flex flex-nowrap justify-center gap-3">
                                                    <a href="{{ route('student.details', ['id' => $student->id]) }}"
                                                        class="btn upt">Butiran</a>
                                                </td>
                                                <td>{{ $status }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                        <div class="round-btn">
                            <img src="{{ asset('/icons/ic_plus.svg') }}">
                            <span>
                                <a href="{{ route('student.add') }}" class="active opacity-0">Add New Student</a>
                            </span>
                        </div>
                    </div>
                @endforeach
            @elseif (Auth::check() && Auth::user()->type === 'admin')
                <div class="w-full grid grid-cols-2 lg:grid-cols-2 gap-5">

                    <div class="flex items-center border border-gray-400 rounded-xl p-3">

                        <div class="flex flex-col items-center p-3 flex-1">
                            <h4 class="text-nowrap">Jumlah Pengguna:</h4>
                            <h3 class="text-3xl">
                                <strong>
                                    {{ $users->count() }}
                                </strong>
                            </h3>
                        </div>

                        <div class="flex flex-col border-l border-gray-400 p-3">

                            <div class="flex-col flex items-center border-b p-3 border-gray-400">
                                <h4 class="text-nowrap">Akaun Admin:</h4>
                                <h3 class="text-3xl">
                                    <strong>
                                        {{ $users->where('type', 'admin')->count() }}
                                    </strong>
                                </h3>
                            </div>

                            <div class="flex-col flex items-center border-b p-3 border-gray-400">
                                <h4 class="text-nowrap">Akaun Guru:</h4>
                                <h3 class="text-3xl">
                                    <strong>
                                        {{ $users->where('type', 'teacher')->count() }}
                                    </strong>
                                </h3>
                            </div>

                            <div class="flex-col flex items-center p-3">
                                <h4 class="text-nowrap">Akaun Waris:</h4>
                                <h3 class="text-3xl">
                                    <strong>
                                        {{ $users->where('type', 'parent')->count() }}
                                    </strong>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center border border-gray-400 rounded-xl p-3">
                        <div class="flex-col flex w-full items-center border-b p-3 border-gray-400">
                            <h4 class="text-nowrap">Jumlah Yuran:</h4>
                            <h3 class="text-3xl">
                                <strong>
                                    {{ $feetypes->count() }}
                                </strong>
                            </h3>
                        </div>

                        <div class="w-full p-3 flex-1">
                            <h4 class="text-nowrap text-xl mb-3">Senarai Yuran:</h4>
                            <table class="table-auto w-full border-collapse border border-gray-300 text-lg">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($feetypes as $index => $feetype)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2 text-left">
                                                {{ $feetype->name }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @php
                                                    $completedTransactions = $transactions
                                                        ->where('feetype_id', $feetype->id)
                                                        ->filter(function ($transaction) {
                                                            return $transaction->status === 'Diluluskan';
                                                        })
                                                        ->count();
                                                    $totalStudents = $studentss->count();

                                                    $status =
                                                        $completedTransactions === $totalStudents
                                                            ? 'Lengkap'
                                                            : 'Tertunda';
                                                @endphp


                                                {{ $status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="col-span-2 flex flex-col items-center border border-gray-400 rounded-xl p-3">

                        <div class="flex w-full items-center border-b p-3">
                     
                            <div class="flex-col flex w-full items-center">
                                <h4 class="text-nowrap">Transaksi Berjaya:</h4>
                                <h3 class="text-3xl">
                                    <strong>
                                        {{ $transactions->count() }}
                                    </strong>
                                </h3>
                            </div>

                            <div class="flex-col flex w-full items-center p-3 ">
                                <h4 class="text-nowrap">Transaksi Perlu Diproses:</h4>
                                <h3 class="text-3xl">
                                    <strong>
                                        {{ $transactions->count() }}
                                    </strong>
                                </h3>
                            </div>

                            <div class="flex-col flex w-full items-center p-3">
                                <h4 class="text-nowrap">Transaksi Gagal:</h4>
                                <h3 class="text-3xl">
                                    <strong>
                                        {{ $transactions->count() }}
                                    </strong>
                                </h3>
                            </div>

                            <div class="flex-col flex w-full items-center border-l p-3 border-gray-400">
                                <h4 class="text-nowrap">Jumlah Transaksi:</h4>
                                <h3 class="text-3xl">
                                    <strong>
                                        {{ $transactions->count() }}
                                    </strong>
                                </h3>
                            </div>
                        </div>

                        <div class="flex-col flex w-full items-center p-3">
                            <h4 class="text-nowrap py-3 border-b border-gray-400">Jumlah Dana Berdasarkan Jenis Yuran:
                            </h4>
                            <div class="w-full grid grid-cols-2 lg:grid-cols-3 gap-3 p-6">
                                @foreach ($feetypes as $feetype)
                                    <div
                                        class="flex flex-col items-center justify-center w-full odd:border-r lg:border gap-3 p-3 border-gray-400">
                                        <div class="flex w-full items-center justify-center">
                                            <p class="p-3 border-r border-gray-400 w-1/2">
                                                {{ $feetype->name }}
                                            </p>
                                            <p class="p-3 flex text-nowrap w-1/2">
                                                RM
                                                {{ number_format(
                                                    $transactions->where('feetype_id', $feetype->id)->filter(function ($transaction) {
                                                            return $transaction->status === 'Diluluskan';
                                                        })->count() * $feetype->amount,
                                                    2,
                                                ) }}

                                            </p>
                                        </div>

                                        <div class="w-full flex p-3 pb-0 border-t border-gray-400">
                                            <p class=" border-r border-gray-400 w-1/2 font-semibold">
                                                Jumlah Bayaran
                                            </p>
                                            <p class="px-3 flex text-nowrap w-1/2">
                                                RM
                                                {{ number_format(
                                                    $transactions->where('feetype_id', $feetype->id)->filter(function ($transaction) {
                                                            return $transaction->status === 'Diluluskan';
                                                        })->count() * $feetype->amount,
                                                    2,
                                                ) }}

                                            </p>
                                        </div>


                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>

    </div>


    <style>
        .card {
            display: flex;
            flex-direction: column;
            padding: 20px 30px;
            border: 1px solid #000
        }
    </style>
</x-app-layout>
