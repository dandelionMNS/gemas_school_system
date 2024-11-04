<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            Senarai Pengguna
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full">
        <div class="py-12 bg-[var(--bg-white)] p-12 h-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8">
                <h2 class="text-nowrap pb-5">SENARAI PENGGUNA BERDAFTAR</h2>
                <div class="w-full py-5 overflow-auto">
                    <table>
                        <thead class="border-b-2 border-gray-900 ">
                            <tr class="text-nowrap">
                                <td>No.</td>
                                <td>ID</td>
                                <td>Jenis Akaun</td>
                                <td>Nama</td>
                                <td>Tarikh Daftar</td>
                                <td>Suntingan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach ($users as $user)
                                @if ($user->type != 'admin')
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('user.updateType', $user->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <select name="type">
                                                    <option
                                                        value="teacher"{{ $user->type == 'teacher' ? 'selected' : '' }}>
                                                        Guru</option>
                                                    <option value="parent"
                                                        {{ $user->type == 'parent' ? 'selected' : '' }}>Waris</option>
                                                </select>

                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->created_at->format('d M Y') }}
                                            ({{ $user->created_at->format('l') }})
                                        </td>

                                        <td class="p-3 flex flex-wrap gap-3">
                                            <input type="submit" value="Kemas Kini"
                                                class="btn upt w-full text-center text-nowrap">
                                            </form>
                                            <a href="{{ route('dashboard', ['fyp_id' => $user->id]) }}"
                                                class="btn dlt w-full text-center">Padam</a>
                                        </td>

                                    </tr>
                                    @php $counter++; @endphp
                                @endif
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
