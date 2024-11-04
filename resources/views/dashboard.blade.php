<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            Laman Utama
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full w-full">
        <div class="py-12 bg-[var(--bg-white)] p-12 h-full w-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8 relative">

                @if (Auth::check() && Auth::user()->type === 'parent')
                    <h2 class="text-nowrap pb-5">ANAK SAYA</h2>

                    <div class="flex gap-3">

                        @foreach ($children as $child)
                            <div class="card">
                                <div> <strong>Name:</strong> {{ $child->name }}</div>
                                <div> <strong>Kelas:</strong>{{ $child->class->grade_lvl }} {{ $child->class->name }}
                                </div>
                                <div class="pt-5 flex gap-3">
                                    <a href="{{ route('student.details', ['id' => $child->id]) }}" class="btn upt">Butiran</a>

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
                @endif
                <div class="round-btn">
                    <img src="{{ asset('/icons/ic_plus.svg') }}">
                    <span>
                        <a href="{{ route('student.add') }}" class="active opacity-0">Add New Student</a>
                    </span>
                </div>

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
