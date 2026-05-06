@extends('layouts.app')

@section('title', 'Market Watch — SyariahWatch')
@section('page-title', 'Market Watch')
@section('page-subtitle', 'Daftar saham syariah screened & real-time')

@section('content')

{{-- Stats Row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
        $stats = [
            ['label' => 'Total Emiten', 'value' => '10', 'sub' => 'Saham Syariah', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'color' => 'cyan'],
            ['label' => 'Emiten Naik', 'value' => '6', 'sub' => 'Hari ini', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'color' => 'emerald'],
            ['label' => 'Emiten Turun', 'value' => '4', 'sub' => 'Hari ini', 'icon' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6', 'color' => 'rose'],
            ['label' => 'Avg. Change', 'value' => '+1.12%', 'sub' => 'Keseluruhan', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'color' => 'blue'],
        ];
    @endphp

    @foreach ($stats as $stat)
    <div class="card-glow bg-navy-800 rounded-xl p-4">
        <div class="flex items-start justify-between mb-3">
            <p class="text-xs text-slate-500 uppercase tracking-widest">{{ $stat['label'] }}</p>
            <div class="w-7 h-7 rounded-lg bg-{{ $stat['color'] }}-500/10 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-{{ $stat['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white font-mono">{{ $stat['value'] }}</p>
        <p class="text-xs text-slate-500 mt-1">{{ $stat['sub'] }}</p>
    </div>
    @endforeach
</div>

{{-- Line Chart --}}
<div class="card-glow bg-navy-800 rounded-2xl p-4 sm:p-6 mb-8">
    <div class="flex flex-wrap items-start justify-between gap-2 mb-4 sm:mb-6">
        <div>
            <h2 class="text-white font-bold text-sm sm:text-base">Perbandingan Harga Emiten</h2>
            <p class="text-xs text-slate-500 mt-0.5">Harga terkini semua 10 emiten syariah</p>
        </div>
        <div class="flex items-center gap-1.5 bg-cyan-500/10 border border-cyan-500/20 rounded-full px-3 py-1">
            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 live-dot"></span>
            <span class="text-cyan-400 text-xs font-mono font-bold">MOCK DATA</span>
        </div>
    </div>
    {{-- Tinggi chart lebih kecil di mobile --}}
    <div class="relative h-48 sm:h-64">
        <canvas id="priceChart"></canvas>
    </div>
</div>

{{-- Search & Filter Bar --}}
<div class="flex flex-col gap-3 mb-6">
    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
        </svg>
        <input
            type="text"
            id="searchInput"
            placeholder="Cari kode emiten atau nama perusahaan..."
            class="w-full bg-navy-800 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/20 transition"
        />
    </div>
    <div class="flex gap-2">
        <button onclick="filterChange('all')" id="btn-all" class="filter-btn active flex-1 py-2.5 rounded-xl text-xs font-bold border transition">Semua</button>
        <button onclick="filterChange('up')" id="btn-up" class="filter-btn flex-1 py-2.5 rounded-xl text-xs font-bold border transition">↑ Naik</button>
        <button onclick="filterChange('down')" id="btn-down" class="filter-btn flex-1 py-2.5 rounded-xl text-xs font-bold border transition">↓ Turun</button>
    </div>
</div>

<style>
    .filter-btn { background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08); color: #94a3b8; }
    .filter-btn.active { background: rgba(34,211,238,0.12); border-color: rgba(34,211,238,0.35); color: #22d3ee; }
</style>

{{-- MOBILE: Grid Card (< lg) --}}
<div class="lg:hidden">
    <div id="cardGrid" class="grid grid-cols-1 sm:grid-cols-2 gap-4"></div>
    <p id="emptyCard" class="hidden text-center text-slate-600 py-16 text-sm">Tidak ada emiten yang cocok.</p>
</div>

{{-- DESKTOP: Data Table (>= lg) --}}
<div class="hidden lg:block card-glow bg-navy-800 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Emiten</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Sektor</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Harga</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">% 24h</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Volume</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Mkt Cap</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>
    <p id="emptyTable" class="hidden text-center text-slate-600 py-16 text-sm">Tidak ada emiten yang cocok.</p>
</div>

@endsection

@push('scripts')
<script>
let allStocks = [];
let currentFilter = 'all';
let currentSearch = '';

async function fetchStocks() {
    // const res = await fetch('/data/stocks.json');
    const res = await fetch('/sharia-stocks');
    allStocks = await res.json();
    renderAll();
}

function renderAll() {
    let data = allStocks.filter(s => {
        const q = currentSearch.toLowerCase();
        const matchSearch = s.ticker.toLowerCase().includes(q) || s.company_name.toLowerCase().includes(q);
        const matchFilter =
            currentFilter === 'all' ? true :
            currentFilter === 'up'   ? s.change >= 0 :
                                       s.change < 0;
        return matchSearch && matchFilter;
    });

    renderCards(data);
    renderTable(data);
}

function renderCards(data) {
    const grid = document.getElementById('cardGrid');
    const empty = document.getElementById('emptyCard');
    grid.innerHTML = '';

    if (data.length === 0) { empty.classList.remove('hidden'); return; }
    empty.classList.add('hidden');

    data.forEach((s, i) => {
        const isUp = s.change >= 0;
        const changeColor = isUp ? 'text-emerald-400' : 'text-rose-400';
        const badgeBg    = isUp ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-rose-500/10 border-rose-500/20';
        const arrow      = isUp ? '▲' : '▼';
        const sign       = isUp ? '+' : '';

        grid.innerHTML += `
        <div class="card-glow bg-navy-800 rounded-xl p-5 fade-up" style="animation-delay:${i * 0.05}s">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-white font-mono font-bold text-lg">${s.ticker}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400">${s.sector}</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-tight">${s.company_name}</p>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-full border ${badgeBg} ${changeColor} font-mono font-bold">
                    ${arrow} ${sign}${s.change.toFixed(2)}%
                </span>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-2xl font-mono font-bold text-white">Rp ${s.price.toLocaleString('id-ID')}</p>
                    <p class="text-xs text-slate-600 mt-1">Vol: ${s.volume}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500">Mkt Cap</p>
                    <p class="text-sm font-mono text-slate-300">Rp ${s.market_cap}</p>
                </div>
            </div>
        </div>`;
    });
}

function renderTable(data) {
    const tbody = document.getElementById('tableBody');
    const empty = document.getElementById('emptyTable');
    tbody.innerHTML = '';

    if (data.length === 0) { empty.classList.remove('hidden'); return; }
    empty.classList.add('hidden');

    data.forEach((s, i) => {
        const isUp = s.change >= 0;
        const changeColor = isUp ? 'text-emerald-400' : 'text-rose-400';
        const badgeBg    = isUp ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-rose-500/10 border-rose-500/20';
        const arrow      = isUp ? '▲' : '▼';
        const sign       = isUp ? '+' : '';

        tbody.innerHTML += `
        <tr class="border-b border-white/5 hover:bg-white/[0.02] transition fade-up" style="animation-delay:${i * 0.04}s">
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-cyan-500/10 border border-cyan-500/15 flex items-center justify-center">
                        <span class="text-cyan-400 font-mono font-bold text-xs">${s.ticker.slice(0,2)}</span>
                    </div>
                    <div>
                        <p class="text-white font-mono font-bold text-sm">${s.ticker}</p>
                        <p class="text-xs text-slate-500">${s.company_name}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <span class="text-xs px-2 py-1 rounded-full bg-cyan-500/8 border border-cyan-500/15 text-cyan-400/80">${s.sector}</span>
            </td>
            <td class="px-6 py-4 text-right">
                <p class="text-white font-mono font-semibold">Rp ${s.price.toLocaleString('id-ID')}</p>
            </td>
            <td class="px-6 py-4 text-right">
                <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full border font-mono font-bold ${badgeBg} ${changeColor}">
                    ${arrow} ${sign}${s.change.toFixed(2)}%
                </span>
            </td>
            <td class="px-6 py-4 text-right">
                <p class="text-slate-400 font-mono text-sm">${s.volume}</p>
            </td>
            <td class="px-6 py-4 text-right">
                <p class="text-slate-400 font-mono text-sm">Rp ${s.market_cap}</p>
            </td>
            <td class="px-6 py-4 text-center">
                <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Syariah
                </span>
            </td>
        </tr>`;
    });
}

document.getElementById('searchInput').addEventListener('input', function () {
    currentSearch = this.value;
    renderAll();
});

function filterChange(type) {
    currentFilter = type;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('btn-' + type).classList.add('active');
    renderAll();
}

fetchStocks();
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let priceChart = null;

function initChart(stocks) {
    const ctx = document.getElementById('priceChart').getContext('2d');

    const labels = stocks.map(s => s.ticker);
    const prices = stocks.map(s => s.price);
    const changes = stocks.map(s => s.change);

    const pointColors = changes.map(c => c >= 0 ? '#34d399' : '#f87171');
    const pointBorder = changes.map(c => c >= 0 ? '#10b981' : '#ef4444');

    const isMobile = window.innerWidth < 640;

    if (priceChart) priceChart.destroy();

    priceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Harga (Rp)',
                data: prices,
                borderColor: '#22d3ee',
                borderWidth: 2,
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const { ctx: c, chartArea } = chart;
                    if (!chartArea) return 'transparent';
                    const gradient = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    gradient.addColorStop(0, 'rgba(34,211,238,0.18)');
                    gradient.addColorStop(1, 'rgba(34,211,238,0)');
                    return gradient;
                },
                fill: true,
                tension: 0.4,
                pointBackgroundColor: pointColors,
                pointBorderColor: pointBorder,
                pointBorderWidth: 2,
                pointRadius: isMobile ? 3 : 5,
                pointHoverRadius: isMobile ? 5 : 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0d1830',
                    borderColor: 'rgba(34,211,238,0.2)',
                    borderWidth: 1,
                    titleColor: '#94a3b8',
                    bodyColor: '#ffffff',
                    padding: 10,
                    callbacks: {
                        label: ctx => {
                            const stock = stocks[ctx.dataIndex];
                            const sign = stock.change >= 0 ? '+' : '';
                            return [
                                `Harga: Rp ${ctx.raw.toLocaleString('id-ID')}`,
                                `Change: ${sign}${stock.change.toFixed(2)}%`
                            ];
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Space Mono', size: isMobile ? 9 : 11 },
                        maxRotation: isMobile ? 45 : 0,
                    },
                    border: { color: 'rgba(255,255,255,0.06)' }
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Space Mono', size: isMobile ? 9 : 11 },
                        maxTicksLimit: isMobile ? 4 : 6,
                        callback: v => isMobile
                            ? (v >= 1000 ? (v/1000).toFixed(0) + 'K' : v)
                            : 'Rp ' + v.toLocaleString('id-ID')
                    },
                    border: { color: 'rgba(255,255,255,0.06)' }
                }
            }
        }
    });
}

// Override fetchStocks agar juga render chart
const _originalFetch = fetchStocks;
async function fetchStocks() {
    // const res = await fetch('/data/stocks.json');
    const res = await fetch('/sharia-stocks');
    allStocks = await res.json();
    renderAll();
    initChart(allStocks); // chart selalu pakai semua 10 data, tidak ikut filter
}

fetchStocks();

// Re-init chart saat resize (orientasi HP berubah)
window.addEventListener('resize', () => {
    if (allStocks.length) initChart(allStocks);
});
</script>
@endpush