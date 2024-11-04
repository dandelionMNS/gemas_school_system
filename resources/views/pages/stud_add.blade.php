<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            TAMBAH PELAJAR BAHARU
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full flex justify-center relative w-full">
    
        <div class="p-12 bg-[var(--bg-white)] w-min h-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8">
                <h2 class="text-nowrap pb-5">TAMBAH PELAJAR BAHARU</h2>

                @if (isset($stud_details))
                    <form method="POST" action="{{ route('student.update', ['id' => $stud_details->id]) }}"
                        class="flex flex-col gap-3" id="studentForm">
                        @csrf
                        @method('PUT')
                    @else
                        <form action="{{ route('student.create') }}" method="POST" class="flex flex-col gap-3"
                            id="studentForm">
                            @csrf
                @endif

                <div class="flex flex-col">
                    <label for="name">Nama Penuh:</label>
                    <input id="name" name="name"
                        value="{{ old('name', isset($stud_details) ? $stud_details->name : '') }}">
                </div>

                <div class="flex flex-col">
                    <label for="class_id">Kelas:</label>

                    <select id="class_id" name="class_id">

                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ old('class_id', isset($stud_details) && $stud_details->class_id == $class->id ? 'selected' : '') }}>
                                {{ $class->grade_lvl }} {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="nric">No. Kad Pengenalan:</label>
                    <input id="nric" name="nric"
                        value="{{ old('nric', isset($stud_details) ? $stud_details->nric : '') }}">
                </div>

                <div class="flex flex-col">
                    <label for="birthday">Tarikh Lahir:</label>
                    <input id="birthday" name="birthday" type="date"
                        value="{{ old('birthday', isset($stud_details) ? $stud_details->birthday : '') }}">
                </div>

                <div class="flex flex-col">
                    <label for="birth_cert">No. Surat Beranak:</label>
                    <input id="birth_cert" name="birth_cert"
                        value="{{ old('birth_cert', isset($stud_details) ? $stud_details->birth_cert : '') }}">
                </div>

                <input type="hidden" name="parent_id" value="{{ Auth::user()->id }}">

                <input type="submit" class="btn crt" value="Simpan" id="submitBtn">

                @isset($stud_details)
                    <button id="toggleEdit" class="btn w-full text-nowrap mt-5 upt" type="button">Kemas Kini</button>
                @endisset()
                </form>

            </div>
        </div>

    </div>

    <style>
        .card {
            display: flex;
            flex-direction: column;
            padding: 20px 30px;
            border: 1px solid #000;
        }
    </style>

    @if (isset($stud_details))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll(
                    '#studentForm input:not([type="submit"]), #studentForm select'
                );

                inputs.forEach(input => {
                    input.disabled = true;
                });
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.style.display = "none";
            });



            document.getElementById('toggleEdit').addEventListener('click', function() {
                const inputs = document.querySelectorAll(
                    '#studentForm input:not([type="submit"]), #studentForm select'
                );

                let allDisabled = true;

                inputs.forEach(input => {
                    if (!input.disabled) {
                        allDisabled =
                            false;
                    }

                    input.disabled = !input.disabled;
                });

                const submitBtn = document.getElementById('submitBtn');
                submitBtn.style.display = !allDisabled ? "none" : "flex";
                this.textContent = !allDisabled ? 'Kemas Kini' : 'Batal';
            });
        </script>
    @endif

</x-app-layout>
