@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

<h2 class="text-xl font-bold mb-4">
    {{ $statistic->judul_data }}  {{-- ✅ bukan title --}}
</h2>

<p>Wilayah: {{ $statistic->wilayah_data }}</p>  {{-- ✅ bukan region --}}
<p>Indikator: {{ $statistic->indikator_data }}</p>

<table class="table-auto border w-full mt-4">
    <thead>
        <tr>
            <th class="border p-2">Tahun</th>
            <th class="border p-2">Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($values as $v)
        <tr>
            <td class="border p-2">{{ $v->year }}</td>
            <td class="border p-2">{{ $v->value }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<canvas id="chart" class="mt-6"></canvas>

<h3 class="mt-6 font-bold">Interpretasi Otomatis</h3>
<p class="mt-2">{{ $interpretation }}</p>

<form method="POST" action="{{ route('statistics.publish', $statistic->id) }}">
@csrf
<button class="bg-green-600 text-white px-4 py-2 mt-4">Publish</button>
</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let ctx = document.getElementById('chart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($values->pluck('year')) !!},
        datasets: [{
            label: '{{ $statistic->judul_data }}',  {{-- ✅ bukan title --}}
            data: {!! json_encode($values->pluck('value')) !!},
            borderWidth: 2
        }]
    }
});
</script>
@endsection