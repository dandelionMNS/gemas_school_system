<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            SENARAI PELAJAR
        </h2>
    </x-slot>

    <div class="dashboard mx-auto sm:px--6  h-full">
        <div class="bg-white h-full flex items-center overflow-hidden shadow-sm">


            <div class="py-12 bg-[var(--bg-white)] p-12 h-full w-full" style="100px">
                <div class="main p-6 text-gray-900 sm:px--6 lg:px--8">
                    <h2 class="text-nowrap pb-5">SENARAI PELAJAR</h2>

                    <table>
                        <thead class="border-b-2 border-gray-900 ">
                            <tr class="text-nowrap">
                                <td>No.</td>
                                <td>Nama:</td>
                                <td>Kelas:</td>
                                <td>Nama Waris:</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Ali Bin Abu</td>
                                <td>5 Bestari:</td>
                                <td>Abu bin Waris</td>
                            <tr>
                                <td>2.</td>
                                <td>Aminah binti Syukor</td>
                                <td>5 Bestari</td>
                                <td>Syukor Roslan</td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Rizal Bin Rizaman</td>
                                <td>5 Bestari</td>
                                <td>Rizaman Kamaruddin</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Siti Mastura binti Kampit</td>
                                <td>5 Bestari</td>
                                <td>Kampit Kapitan</td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    
    <style>
        td {
            border: solid 1px #000;
            padding: 5px 20px
        }
    </style>
</x-app-layout>
