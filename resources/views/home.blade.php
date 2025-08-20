@extends('default')
@section('pageTitle', 'Dashboard')

@section('content')
<!-- Dashboard Content -->
 <div class="content">
     <!-- Stats Cards -->
     <div class="row g-4 mb-4">
         <div class="col-md-4">
             <div class="stat-card">
                 <div class="stat-icon bg-primary">
                     <i class="fas fa-robot"></i>
                 </div>
                 <div class="stat-content">
                     <h3 class="stat-number">{{ $totalModels }}</h3>
                     <p class="stat-label">ChatBots</p>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <div class="stat-card">
                 <div class="stat-icon bg-success">
                     <i class="fas fa-chart-line"></i>
                 </div>
                 <div class="stat-content">
                     <h3 class="stat-number">{{ $totalBotCalls }}</h3>
                     <p class="stat-label">API Calls</p>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <div class="stat-card">
                 <div class="stat-icon bg-danger">
                     <i class="fas fa-clock"></i>
                 </div>
                 <div class="stat-content">
                     <h3 class="stat-number">{{ $avgResponseTime }}</h3>
                     <p class="stat-label">Average Response Time (MS)</p>
                 </div>
             </div>
         </div>
     </div>

     <!-- Charts Row -->
     <div class="row g-4 mb-4">
         <div class="col-lg-12">
             <div class="dashboard-card">
                 <div class="card-header">
                     <h5 class="card-title">Chatbot Usage Analytics</h5>
                     <div class="card-actions">
                         <!-- <button class="btn btn-sm btn-outline-primary">
                             <i class="fas fa-download"></i> Export
                         </button> -->
                        <select id="yearSelect" class="form-select form-select-sm">
                            @foreach($years as $year)
                                <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                     </div>
                 </div>
                 <div class="card-body">
                     <canvas id="usageChart" height="375"></canvas>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection
 @section('scripts')
 <script src="{{ asset('assets/js/dashboard.js') }}"></script>
 <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
 <script>
    const labels = @json($labels); // ['Jan', 'Feb', ...]
    const datasets = @json($datasets);

    const ctx = document.getElementById('usageChart');
    const usageChart = new Chart(ctx, {
        type: 'line',
        data: { labels: labels, datasets: datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'API Calls' }
                },
                x: {
                    title: { display: true, text: 'Months' }
                }
            }
        }
    });
    $('#yearSelect').on('change', function(){
    const year = $(this).val();
        $.ajax({
            url: "{{ route('dashboard.usageByYear') }}",
            data: { year },
            success: function(res){
                usageChart.data.datasets = res.datasets;
                usageChart.update();
            }
        });
    });

 </script>
 <!-- Chart.js -->
 @endsection