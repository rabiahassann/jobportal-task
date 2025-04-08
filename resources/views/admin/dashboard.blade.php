<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Total Users</div>
                    <div class="text-2xl font-bold text-indigo-600">{{$totalUsers ?? 0}}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Active Job Posts</div>
                    <div class="text-2xl font-bold text-green-600">{{$activeJobPosts ?? 0}}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Total Applicants</div>
                    <div class="text-2xl font-bold text-blue-600">{{$totalApplicants}}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Pending Approvals</div>
                    <div class="text-2xl font-bold text-red-600">{{$pendingApprovals ?? 0}}</div>
                </div>
            </div>
            @if(isset($recentPosts))
            {{-- Recent Activity --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Job Posts</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($recentPosts as $post)
                    <li class="py-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">{{$post->title }} </span>
                            <span>{{$post->category}}</span>
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>

                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>