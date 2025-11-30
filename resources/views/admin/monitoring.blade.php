@extends('layouts.admin')

@section('title', 'Monitoring Aktivitas | KantinKu')

@section('content')

<main class="flex-1 p-8">

    <h2 class="text-3xl font-bold text-green-700 mb-8">
        Monitoring Aktivitas Sistem
    </h2>

    <!-- CARD WRAPPER -->
    <div class="bg-white rounded-2xl shadow p-6">

        <!-- TABLE -->
        <table class="w-full border-collapse rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="py-3 px-4 text-left">Waktu</th>
                    <th class="py-3 px-4 text-left">Pengguna</th>
                    <th class="py-3 px-4 text-left">Role</th>
                    <th class="py-3 px-4 text-left">Aktivitas</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @forelse($activities as $activity)
                <tr class="border-b hover:bg-gray-50 transition">

                    <!-- Waktu -->
                    <td class="px-4 py-3">
                        <span class="font-medium text-gray-800">
                            {{ $activity->created_at->format('d M Y') }}
                        </span><br>
                        <span class="text-sm text-gray-500">
                            {{ $activity->created_at->format('H:i') }}
                        </span>
                    </td>

                    <!-- Pengguna -->
                    <td class="px-4 py-3">
                        {{ $activity->user->nama }}
                    </td>

                    <!-- Role Badge -->
                    <td class="px-4 py-3 capitalize">
                        @if($activity->user->role == 'admin')
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-sm rounded-lg font-semibold">
                                Admin
                            </span>
                        @elseif($activity->user->role == 'mahasiswa')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-lg font-semibold">
                                Mahasiswa
                            </span>
                        @elseif($activity->user->role == 'penjual')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-lg font-semibold">
                                Penjual
                            </span>
                        @endif
                    </td>

                    <!-- Aktivitas -->
                    <td class="px-4 py-3">
                        {{ $activity->aktivitas }}
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="4" class="py-3 px-4 text-center text-gray-500">
                        Belum ada data.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

        <!-- PAGINATION (Hanya tampil jika ada lebih dari 1 halaman) -->
        @if ($activities->hasPages())
            <div class="mt-6">
                <div class="inline-block px-4 py-2 rounded-lg bg-gray-100 shadow">
                    {{ $activities->links() }}
                </div>
            </div>
        @endif

    </div>

</main>

@endsection