<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            {{-- Senarai Kelas --}}
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full">
        <div class="py-12 bg-[var(--bg-white)] p-12 h-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8">
                <h2 class="text-nowrap pb-5">Senarai Kelas</h2>

                <form class="add-form flex flex-col gap-3 p-3 w-full" method="POST" action="{{ route('feetype.create') }}">
                    @csrf
                    <h3 class="text-nowrap flex items-center">Tambah Kelas:</h3>

                    <div class="grid grid-cols-3 gap-3 w-full">

                        <div class="flex gap-2">
                            <label for="name">Nama Yuran:</label>
                            <input class="w-full" type="text" id="name" name="name" required>
                        </div>

                        <div class="flex gap-2">
                            <label for="amount">Jumlah Bayaran:</label>
                            <input type="number" step="0.01" id="amount" name="amount" required>
                        </div>

                        <div class="flex gap-2">
                            <label for="due">Tarikh Akhir Bayaran:</label>
                            <input class="w-full" type="date" id="due" name="due" required>
                        </div>
                        <div class="flex gap-2">
                            <label for="grade_lvl">Tarikh Akhir Bayaran:</label>
                            <select class="w-full" id="grade_lvl" name="grade_lvl">
                                <option value="all">
                                    all
                                </option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div></div>

                        <div class="flex justify-end">
                            <input type="submit" value="Simpan" class="btn crt">
                        </div>
                    </div>
                </form>

                <div class="w-full py-5 overflow-auto">
                    <table>
                        <thead class="border-b-2 border-gray-900 ">
                            <tr class="text-nowrap">
                                <td>No.</td>
                                <td>Nama</td>
                                <td>Amaun (RM)</td>
                                <td>Tarikh Akhir Bayaran</td>
                                <td>Suntingan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp

                            @foreach ($feetypes as $feetype)
                                <tr>
                                    <td class="w-0">{{ $counter }}</td>
                                    <td class="w-28">
                                        <form method="POST"
                                            action="{{ route('feetype.update', ['id' => $feetype->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <input name="name" value="{{ $feetype->name }}" class="bg-none border-0"
                                                required>

                                    </td>
                                    <td>
                                        <input name="amount" type="number"
                                            value="{{ number_format($feetype->amount, 2) }}"
                                            class="bg-none border-0 rounded-lg" required>
                                    </td>

                                    <td>
                                        <input name="due" type="date" value="{{ $feetype->due }}"
                                            class="bg-none border-0 rounded-lg" required>
                                    </td>

                                    <td>
                                        <select class="w-full" id="grade_lvl" name="grade_lvl">
                                            <option value="all">
                                                all
                                            </option>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}" {{$feetype->grade_lvl == $i? 'selected': ''}}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </td>

                                    <td class="p-3 flex gap-3 justify-center">
                                        <input type="submit" value="Kemas Kini" class="btn upt w-full text-center">
                                        </form>

                                        <form class="w-fit" method="POST"
                                            action="{{ route('feetype.delete', ['id' => $feetype->id]) }}">

                                            @csrf
                                            @method('DELETE')
                                            <input class="btn dlt w-full text-center" type="submit" value="Padam">
                                        </form>

                                    </td>

                                </tr>
                                @php $counter++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
