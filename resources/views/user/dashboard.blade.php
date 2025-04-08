<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Total Applieds</div>
                    <div class="text-2xl font-bold text-indigo-600">{{$totalApplications ?? 0}}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Approved Applications</div>
                    <div class="text-2xl font-bold text-green-600">{{$approvedApplications ?? 0}}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Rejected Applicants</div>
                    <div class="text-2xl font-bold text-blue-600">{{$rejectedApplications}}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Pending Applicants</div>
                    <div class="text-2xl font-bold text-red-600">{{$pendingApplications ?? 0}}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>