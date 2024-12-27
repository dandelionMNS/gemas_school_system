<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            TAMBAH PELAJAR BAHARU
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6 h-full flex justify-center relative w-full">

        <div class="p-12 bg-[var(--bg-white)] w-min h-full">
            <div class="main text-gray-900 sm:px--6 lg:px--8">
                @if (isset($stud_details))
                    <h2 class="text-nowrap pb-5">BUTIRAN PELAJAR</h2>
                @else
                    <h2 class="text-nowrap pb-5">TAMBAH PELAJAR BAHARU</h2>
                @endif

                {{-- Transactions Summary --}}
                <div class="flex gap-5">
                    <div class="form-container border border-[#ddd] rounded-lg py-5 px-10">
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
                                    <option class="text-left" value="{{ $class->id }}"
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

                        @isset($stud_details)
                            @php
                                $parentt_stud = \App\Models\Parentt::find($stud_details->parent_id);
                                $parent_details = \App\Models\User::find($parentt_stud->user_id);
                            @endphp

                            <div class="border-t border-[#ccc] pt-3 flex flex-col gap-3">
                                <h3>Maklumat Waris</h3>
                                <div class="flex gap-2 flex-wrap">
                                    <label>
                                        Nama:
                                    </label>
                                    <p>{{ $parent_details->name }}</p>
                                </div>

                                <div class="flex gap-2 flex-wrap">
                                    <label>
                                        Pekerjaan:
                                    </label>
                                    <p>{{ $parent_details->occupation }}</p>
                                </div>

                                <div class="flex gap-2 flex-wrap">
                                    <label>
                                        Alamat:
                                    </label>
                                    <p>{{ $parent_details->address }}</p>
                                </div>

                            </div>

                            <input type="hidden" name="parent_id" value="{{ $stud_details->parent_id }}">
                        @endisset

                        @if (Auth::user()->type == 'parent')
                            @php
                                $parentt_create_form = \App\Models\Parentt::where('user_id', Auth::user()->id)->first();
                            @endphp
                            <input type="hidden" name="parent_id" value="{{ $parentt_create_form->id }}">
                        @endif

                        <input type="submit" class="btn crt" value="Simpan" id="submitBtn">


                        @isset($stud_details)
                            @if (Auth::user()->type == 'teacher')
                                <button id="toggleEdit" class="btn w-full text-nowrap mt-5 upt" type="button">Kemas
                                    Kini</button>
                            @endif
                        @endisset()
                        </form>






                    </div>



                    @if (isset($stud_details))
                        <div class="payment-container border border-[#ddd] rounded-lg py-5 px-10">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Bil.</td>
                                        <td>Jenis Yuran</td>
                                        <td>Amaun (RM)</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($feetypes as $index => $feetype)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $feetype->name }}</td>
                                            <td>{{ number_format($feetype->amount, 2) }}</td>
                            
                                            <td>
                                                @php
                                                    // Filter transactions by feetype_id and get distinct transaction statuses
                                                    $matchingTransactions = $transactions->where('feetype_id', $feetype->id);
                                                    $approvedTransaction = $matchingTransactions->firstWhere('status', 'Diluluskan');
                                                    $pendingTransaction = $matchingTransactions->firstWhere('status', 'Pending');
                                                @endphp
                            
                                                @if ($approvedTransaction)
                                                    <button class="btn upt">{{ $approvedTransaction->status }}</button>
                                                @elseif ($pendingTransaction)
                                                    <span>Perlu Disemak</span>
                                                @else
                                                    @if (Auth::user()->type == 'parent')
                                                        <a class="btn crt-sec"
                                                           href="{{ route('transaction', ['stud_id' => $stud_details->id, 'feetype_id' => $feetype->id]) }}">
                                                           Bayar Sekarang
                                                        </a>
                                                    @else
                                                        <span>Belum Bayar</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-bold">
                                        <td colspan="2">Jumlah</td>
                                        <td colspan="2">RM {{ number_format($feetypes->sum('amount'), 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>

                    @endif
                </div>



                {{-- Transactions Records --}}
                @isset($stud_details)
                    <div class="flex flex-col">
                        <h2 class="text-xl text-gray-800 leading-tight pt-10">
                            REKOD TRANSAKSI
                        </h2>

                        <table>
                            <thead class="border-b-2 border-gray-900 ">
                                <tr class="text-nowrap">
                                    <td>No.</td>
                                    <td>ID</td>
                                    <td>Tarikh/Masa</td>
                                    <td>Jenis Yuran</td>
                                    <td>Bukti Transaksi</td>
                                    <td>Status</td>
                                    <td>Suntingan</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($transactions as $index => $transaction)
                                    <tr>
                                        <td class="w-0">{{ $index + 1 }}</td>
                                        <td>{{ $transaction->id }}</td>
                                        <td class="w-28">{{ $transaction->created_at->format('d/m/Y (h:i:s A)') }}</td>
                                        <td>{{ $transaction->feetype->name }}</td>
                                        <td>
                                            <a class="text-blue-500 underline cursor-pointer font-semibold"
                                                href="{{ route('transaction.download', ['encodedPath' => base64_encode($transaction->ref_url)]) }}">
                                                MuatTurun
                                            </a>
                                        </td>

                                        <td>{{ $transaction->status }}</td>

                                        <td class="p-3 flex gap-3">

                                            @if ($transaction->status == 'Belum Diproses' && Auth::user()->type == 'parent')
                                                <form class="w-fit" method="POST"
                                                    action="{{ route('transaction.delete', ['transaction_id' => $transaction->id]) }}">

                                                    @csrf
                                                    @method('DELETE')
                                                    <input class="btn dlt w-full text-center" type="submit" value="Padam">
                                                </form>
                                            @elseif ($transaction->status == 'Belum Diproses' && Auth::user()->type == 'teacher')
                                                <form class="w-fit" method="POST"
                                                    action="{{ route('transaction.approve', ['transaction_id' => $transaction->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input class="btn crt w-full text-center" type="submit"
                                                        value="Diluluskan">
                                                </form>

                                                <form class="w-fit" method="POST"
                                                    action="{{ route('transaction.reject', ['transaction_id' => $transaction->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input class="btn dlt w-full text-center" type="submit"
                                                        value="Ditolak">
                                                </form>
                                            @else
                                                <p>Sudah Disemak</p>
                                            @endif


                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                @endisset




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


    <style>
        table td {
            text-wrap: nowrap;
            border: #ccc solid 1px;
            padding: 10px 25px;

        }
    </style>

</x-app-layout>
