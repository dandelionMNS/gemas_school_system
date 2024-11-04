<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            {{-- ANAK SAYA --}}
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full">
        <div class="py-12 bg-[var(--bg-white)] p-12 h-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8">
                <h2 class="text-nowrap pb-5">REKOD PEMBAYARAN YURAN</h2>

                <form class="add-form flex flex-col w-min gap-3 p-3" method="POST" action="{{ route('class.create') }}">
                    @csrf
                    <h3 class="text-nowrap flex items-center">REKOD PEMBAYARAN YURAN</h3>

                    <div class="flex gap-8">
                        <div class="flex gap-2">
                            <label for="grade_lvl">Tahun:</label>
                            <select id="grade_lvl" name="grade_lvl">
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <label for="name">Nama Kelas:</label>
                            <input type="text" id="name" name="name" required>
                        </div>

                        <div class="flex gap-2">
                            <label for="teacher_id">Guru Kelas:</label>
                            <select name="teacher_id" required>
                                <option value=""></option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">Cikgu {{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="submit" value="Simpan" class="btn crt">
                    </div>
                </form>

                <div class="w-full py-5 overflow-auto">
                    <table>
                        <thead class="border-b-2 border-gray-900 ">
                            <tr class="text-nowrap">
                                <td>No.</td>
                                <td>Tahun</td>
                                <td>Kelas</td>
                                <td>Guru Kelas</td>
                                <td>Jumlah Murid</td>
                                <td>Status</td>
                                <td>Suntingan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                                $sortedClasses = $classes->sortBy('grade_lvl');
                            @endphp

                            @foreach ($sortedClasses as $class)
                                <tr>
                                    <td class="w-0">{{ $counter }}</td>
                                    <td class="w-28">
                                        <form method="POST" action="{{ route('class.update', ['id' => $class->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="grade_lvl" class="w-full">
                                                @for ($i = 1; $i <= 6; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $class->grade_lvl == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                    </td>
                                    <td>
                                        <input name="name" value="{{ $class->name }}" class="bg-none border-0"
                                            required>
                                    </td>

                                    <td>
                                        <select name="teacher_id" class="w-full">
                                            <option value=""></option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                    {{ $class->teacher->id == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>

                                    <td class="p-3 flex flex-wrap gap-3">
                                        <input type="submit" value="Kemas Kini" class="btn upt w-full text-center">
                                        </form>

                                        <form class="w-fit" method="POST"
                                            action="{{ route('class.delete', ['id' => $class->id]) }}">

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
