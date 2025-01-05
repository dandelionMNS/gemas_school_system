<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            {{-- ANAK SAYA --}}
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full">
        <div class="py-12 bg-[var(--bg-white)] p-12 h-full">
            <div class="flex justify-between w-full items-center border-b border-gray-300 pb-5 mb-5">
                <h2 class="text-nowrap">SENARAI PELAJAR</h2>
                <form method="GET" action="{{ route('student.class_teach') }}" class="flex w-full justify-end gap-3">
                    <input type="text" name="search" class="border-0 rounded-lg min outline-0 w-full max-w-80"
                        placeholder="Cari Pelajar" value="{{ $search }}">
                    <button type="submit" class="crt btn">Cari</button>
                </form>
            </div>
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

                                                <form class="w-fit" method="POST"
                                                    action="{{ route('student.delete', ['id' => $student->id]) }}">

                                                    @csrf
                                                    @method('DELETE')
                                                    <input class="btn dlt w-full text-center" type="submit"
                                                        value="Padam">
                                                </form>


                                            </td>
                                            <td class="text-nowrap">{{ $status }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>

                    </div>


                </div>
            @endforeach
        </div>

    </div>




    <style>
        .dashboard {
            width: 100%;
            overflow-x: auto;
        }

        .main {
            position: relative;
            overflow-x: hidden;
            max-width: 100%;
        }

        table {
            width: 100%;
            overflow-x: scroll;
        }

        .btn {
            max-width: 150px;
        }
    </style>
</x-app-layout>
