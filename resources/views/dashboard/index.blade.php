@extends('layouts.app')

@section('content')

<div class="flex">

   


    {{-- MAIN CONTENT --}}

      


        {{-- CONTENT --}}
        <div class="p-8">

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-4 gap-6 mb-8">

                {{-- Card 1 --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Admin</p>
                        <h2 class="text-4xl font-semibold mt-2">4</h2>
                    </div>

                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-xl">
                        👥
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Petugas Layanan</p>
                        <h2 class="text-4xl font-semibold mt-2">10</h2>
                    </div>

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl">
                        🎧
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Data Statistik</p>
                        <h2 class="text-4xl font-semibold mt-2">122</h2>
                    </div>

                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl">
                        📈
                    </div>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Jadwal Konsultasi</p>
                        <h2 class="text-4xl font-semibold mt-2">25</h2>
                    </div>

                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 text-xl">
                        ⏰
                    </div>
                </div>

            </div>


            {{-- DATA STATISTIK CHART --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Data Statistik
                    </h2>

                    <select class="bg-gray-100 px-4 py-2 rounded-lg border border-gray-200">
                        <option>2025</option>
                        <option>2024</option>
                    </select>
                </div>

                <canvas id="statistikChart" height="100"></canvas>

            </div>

        </div>
    </div>
</div>


{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statistikChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Jumlah Data',
                data: [5,12,7,22,13,14,6,7,11,16,10,14],
                borderColor: '#1E40AF',
                backgroundColor: 'rgba(30,64,175,0.1)',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

@endsection