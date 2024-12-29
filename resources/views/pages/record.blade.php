<x-app-layout>

    <div class="dashboard mx-auto sm:px--6 h-full w-full">
        <div class="bg-[var(--bg-white)] p-12 pb-0 h-full w-full">
            <h2 class="text-nowrap pb-5">REKOD TRANSAKSI</h2>
        </div>

        <div class="bg-[var(--bg-white)] px-12 h-full w-full">

            <form class="add-form flex flex-col w-min gap-3" method="POST" action="{{ route('record.find') }}">
                @csrf
                <div class="flex gap-8">
                    <div class="flex gap-2">
                        <label for="class_id">Kelas:</label>
                        <select id="class_id" name="class_id" required>
                            <option value="all">Semua Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ isset($class_id) && $class_id == $class->id ? 'selected' : '' }}
                                    {{ old('class_id') == $class->id || (isset($stud_details) && $stud_details->class_id == $class->id) ? 'selected' : '' }}>
                                    {{ $class->grade_lvl }} {{ $class->name }}
                                </option>
                            @endforeach


                        </select>
                    </div>

                    <div class="flex gap-2">
                        <label for="month">Tarikh:</label>
                        <input type="month" id="month" name="month" value="{{ $current }}" required>
                    </div>

                    <input type="submit" value="Papar Transaksi" class="btn crt">
                </div>
            </form>

            <div class="mt-5">

                @if (isset($transactions))
                    @if ($transactions->isNotEmpty())

                        <div class="flex flex-col">
                            <table class="table-auto w-full border">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">#</th>
                                        <th class="border px-4 py-2">Nama Pelajar</th>
                                        <th class="border px-4 py-2">Jenis Yuran</th>
                                        <th class="border px-4 py-2">Status Transaksi</th>
                                        <th class="border px-4 py-2">Tarikh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $index => $transaction)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="border px-4 py-2 text-left">
                                                {{ $transaction->student->name ?? 'Unknown' }}</td>
                                            <td class="border px-4 py-2 text-left">
                                                {{ $transaction->feetype->name ?? 'Unknown' }}</td>
                                            <td class="border px-4 py-2">{{ $transaction->status }}</td>
                                            <td class="border px-4 py-2">{{ $transaction->created_at->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4">
                                <form method="POST" action="{{ route('record.download') }}"
                                    class="w-full flex justify-end">
                                    @csrf
                                    <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                                    <input type="hidden" name="month" value="{{ request('month') }}">
                                    <button type="submit"
                                        class="btn crt flex gap-3 !bg-[var(--bg-main)] !text-[var(--bg-white)]">
                                        Simpan
                                        <img src="{{ asset('icons/ic_save.svg') }}" alt="save">
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                    <div class="mt-12">
                        <p class="text-gray-500">Maaf. Tiada transaksi direkodkan.</p>
                    </div>
                    @endif
                @else
                    <div class="mt-12">
                        <p class="text-gray-500">Sila pilih tarikh dan kelas untuk memaparkan transaksi.</p>
                    </div>
                @endif
            </div>
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
