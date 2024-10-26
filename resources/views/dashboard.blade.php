<x-app-layout>
    <x-slot name="header">
        <h2 class=" text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="dashboard max-w-7xl mx-auto sm:px--6  h-full">
        <div class="bg-white h-full flex items-center overflow-hidden shadow-sm">

            <div class="sidebar h-full py-10 px-6 " style="height: 100%;">
                <h2 class="text-nowrap">
                    Laman Utama
                </h2>
            </div>
            <div class="py-12 bg-[var(--bg-white)] p-12 h-full w-full">
                <div class="main p-6 text-gray-900 sm:px--6 lg:px--8">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard {
            .sidebar {
                background: var(--bg-main)
            }
            h2 {}

        }
    </style>
</x-app-layout>
