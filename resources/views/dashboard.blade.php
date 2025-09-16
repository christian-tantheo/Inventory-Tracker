    @extends('layouts.app') 

    @section('content')

    <!-- Row untuk 4 widget (cards) -->
<div class="row mb-4">
  <!-- Total Assets -->
  <div class="col-sm-6 col-lg-3">
    <div class="card">
      <div class="card-body text-center">
        <h5 class="card-title">Total Assets</h5>
        <div class="fs-4 fw-semibold">6</div>
      </div>
    </div>
  </div>
  <!-- Used Assets -->
  <div class="col-sm-6 col-lg-3">
    <div class="card">
      <div class="card-body text-center">
        <h5 class="card-title">Used Assets</h5>
        <div class="fs-4 fw-semibold">4</div>
      </div>
    </div>
  </div>
  <!-- New Assets -->
  <div class="col-sm-6 col-lg-3">
    <div class="card">
      <div class="card-body text-center">
        <h5 class="card-title">New Assets</h5>
        <div class="fs-4 fw-semibold">1</div>
      </div>
    </div>
  </div>
  <!-- Damaged Assets -->
  <div class="col-sm-6 col-lg-3">
    <div class="card">
      <div class="card-body text-center">
        <h5 class="card-title">Damaged Assets</h5>
        <div class="fs-4 fw-semibold">1</div>
      </div>
    </div>
  </div>
</div>

<!-- Row untuk grafik -->
<div class="row">
  <!-- Grafik Pie: Asset By Condition -->
  <div class="col-md-6 mb-4">
    <div class="card">
      <div class="card-header">Asset By Condition</div>
      <div class="card-body p-0">
         <div style="height: 400px;">
           <canvas id="assetByConditionChart"></canvas>
         </div>
      </div>
    </div>
  </div>
  <!-- Grafik Bar: Asset By Category -->
  <div class="col-md-6 mb-4">
    <div class="card">
      <div class="card-header">Asset by Category</div>
      <div class="card-body p-0">
         <div style="height: 400px;">
           <canvas id="assetByCategoryChart"></canvas>
         </div>
      </div>
    </div>
  </div>
</div>



    @endsection

    @push('after-scripts')
  <!-- Sertakan Chart.js, jika belum termasuk di layout Anda -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Pie Chart: Asset By Condition
    // Pie Chart: Asset By Condition
const ctxCondition = document.getElementById('assetByConditionChart').getContext('2d');
const assetByConditionChart = new Chart(ctxCondition, {
  type: 'pie',
  data: {
    labels: ['Active', 'Maintenance', 'Archived'],
    datasets: [{
      data: [60, 25, 15],
      backgroundColor: ['#28a745', '#ffc107', '#dc3545']
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'bottom' }
    }
  }
});

// Bar Chart: Asset by Category
const ctxCategory = document.getElementById('assetByCategoryChart').getContext('2d');
const assetByCategoryChart = new Chart(ctxCategory, {
  type: 'bar',
  data: {
    labels: ['Furniture', 'Electronics', 'IT Equipment'],
    datasets: [{
      label: 'Number of Assets',
      data: [10, 20, 30],
      backgroundColor: ['#007bff', '#6610f2', '#6f42c1']
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: { beginAtZero: true }
    },
    plugins: {
      legend: { position: 'bottom' }
    }
  }
});

  </script>
@endpush