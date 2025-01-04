<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            {{-- ANAK SAYA --}}
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full">
        <div class="py-12 bg-[var(--bg-white)] p-12 h-full">

            <form method="GET" action="{{ route('student.index') }}" class="flex w-full justify-end gap-5">
                <input type="text" name="search" class="border-0 rounded-lg min" placeholder="Cari Pelajar" value="{{ $search }}">
                <button type="submit" class="crt btn">Cari</button>
            </form>
            @foreach ($classes as $class)
                <div class="main text-gray-900 sm:px--6 lg:px--8 relative py-5">

                    <h2 class="text-nowrap pb-3">KELAS: {{ strtoupper($class->name) }}</h2>
                    <div class="flex w-full gap-3">

                        <table class="w-full">
                            <thead class="border-b-2 border-gray-900 ">
                                <tr class="text-nowrap">
                                    <td>#</td>
                                    <td>ID</td>
                                    <td class="w-full text-left">Nama </td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $classStudents = $students->filter(
                                        fn($student) => $student->class->id == $class->id,
                                    );
                                @endphp

                                @if ($classStudents->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">Tiada Pelajar Dijumpai.</td>
                                    </tr>
                                @else
                                    @foreach ($classStudents as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->id }}</td>
                                            <td class="text-left">{{ $student->name }}</td>
                                            <td class="p-3 flex flex-nowrap justify-center gap-3">
                                                <a href="{{ route('student.details', ['id' => $student->id]) }}"
                                                    class="btn upt">Butiran</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
