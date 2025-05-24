@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-gold">Monthly Statistics</h2>
    <div class="btn-group mb-3" id="toggle-group">
        <button class="btn btn-gold" data-type="sales">Sales</button>
        <button class="btn btn-outline-gold" data-type="expenses">Expenses</button>
        <button class="btn btn-outline-gold" data-type="profit">Profit</button>
    </div>
    <canvas id="statsChart" height="100"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chart;
let chartType = 'sales';
function fetchAndRender(type) {
    fetch('/dashboard/data')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(d => d.date);
            let dataset, label, color;
            if (type === 'sales') {
                dataset = data.map(d => d.total_sales);
                label = 'Daily Sales';
                color = '#4e73df';
            } else if (type === 'expenses') {
                dataset = data.map(d => d.total_expenses);
                label = 'Daily Expenses';
                color = '#e74a3b';
            } else {
                dataset = data.map(d => d.net_profit);
                label = 'Daily Profit';
                color = '#1cc88a';
            }
            if (chart) chart.destroy();
            chart = new Chart(document.getElementById('statsChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: dataset,
                        borderColor: color,
                        backgroundColor: color + '33',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { labels: { color: '#D4AF37' } }
                    },
                    scales: {
                        x: { ticks: { color: '#D4AF37' } },
                        y: { ticks: { color: '#D4AF37' } }
                    }
                }
            });
        });
}
document.querySelectorAll('#toggle-group button').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#toggle-group button').forEach(b => b.classList.remove('btn-gold'));
        document.querySelectorAll('#toggle-group button').forEach(b => b.classList.add('btn-outline-gold'));
        this.classList.remove('btn-outline-gold');
        this.classList.add('btn-gold');
        fetchAndRender(this.dataset.type);
    });
});
fetchAndRender('sales');
</script>
<style>
.btn-gold {
    background-color: #D4AF37 !important;
    color: #2c1e1e !important;
    border: none !important;
}
.btn-outline-gold {
    background: transparent !important;
    border: 2px solid #D4AF37 !important;
    color: #D4AF37 !important;
}
.text-gold { color: #D4AF37 !important; }
@media (max-width: 576px) {
    .container.py-4 {
        padding: 0.5rem !important;
    }
    h2.text-gold {
        font-size: 1.1rem !important;
        margin-bottom: 1rem !important;
    }
    #toggle-group {
        flex-direction: column !important;
        display: flex !important;
        gap: 0.5rem !important;
    }
    #toggle-group .btn {
        width: 100% !important;
        font-size: 1rem !important;
        padding: 0.7rem 1rem !important;
    }
    #statsChart {
        max-width: 100vw !important;
        min-width: 0 !important;
    }
}
</style>
@endsection 