<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            TAMBAH PELAJAR BAHARU
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full flex justify-center relative w-full">

        <div class="p-12 bg-[var(--bg-white)] w-min h-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8">
                @empty($receipt_details)
                    <h2 class="text-nowrap pb-5">Buat Transaksi</h2>

                    <div class="border border-[#ddd] rounded-lg py-5 px-10">
                        <div>
                            <form class="flex flex-col gap-3" method="POST"
                                action="{{ route('transaction.create', ['stud_id' => $student->id, 'feetype_id' => $feetype->id]) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <label for="student"><strong>Pelajar: </strong> {{ $student->name }}</label>
                                <input type="hidden" id="student" name="student_id" value="{{ $student->id }}">
                                <label for="feetype"><strong>Jenis Yuran:</strong> {{ $feetype->name }}</label>
                                <input id="feetype" type="hidden" value="{{ $feetype->id }}" name="feetype_id">
                                <label><strong>Muat Naik Resit:</strong></label>
                                <input type="file" name="receipt" accept=".zip,.pdf,.jpg,.jpeg,.png" required>
                                <input type="submit" value="Hantar" class="btn crt">
                            </form>
                        </div>
                    </div>

                @else
                    <h2 class="text-nowrap pb-5">Bukti Transaksi</h2>
                    <div class="border border-[#ddd] rounded-lg py-5 px-10">
                        <div>
                            <form class="flex flex-col gap-3" method="POST"
                                action="{{ route('transaction.create', ['stud_id' => $student->id, 'feetype_id' => $feetype->id]) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <label for="student"><strong>Pelajar: </strong> {{ $student->name }}</label>
                                <input type="hidden" id="student" name="student_id" value="{{ $student->id }}">
                                <label for="feetype"><strong>Jenis Yuran:</strong> {{ $feetype->name }}</label>
                                <input id="feetype" type="hidden" value="{{ $feetype->id }}" name="feetype">
                                <label><strong>Muat Naik Resit:</strong></label>
                                <input type="file" name="receipt" accept=".zip,.pdf,.jpg,.jpeg,.png" required>
                                <input type="submit" value="Hantar" class="btn crt">
                            </form>
                        </div>
                    </div>
                @endempty



            </div>
        </div>

    </div>

</x-app-layout>
