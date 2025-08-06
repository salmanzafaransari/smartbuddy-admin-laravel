@extends('default')
@section('pageTitle', 'Dashboard')

@section('content')
<!-- Dashboard Content -->
 <div class="content">
     <!-- Stats Cards -->
     <div class="row g-4 mb-4">
         <div class="col-md-3">
             <div class="stat-card">
                 <div class="stat-icon bg-primary">
                     <i class="fas fa-robot"></i>
                 </div>
                 <div class="stat-content">
                     <h3 class="stat-number">24</h3>
                     <p class="stat-label">AI Models <span class="stat-change positive">+12%</span></p>
                 </div>
             </div>
         </div>
         <div class="col-md-3">
             <div class="stat-card">
                 <div class="stat-icon bg-success">
                     <i class="fas fa-chart-line"></i>
                 </div>
                 <div class="stat-content">
                     <h3 class="stat-number">1,247</h3>
                     <p class="stat-label">API Calls <span class="stat-change positive">+8%</span></p>
                 </div>
             </div>
         </div>
         <div class="col-md-3">
             <div class="stat-card">
                 <div class="stat-icon bg-warning">
                     <i class="fas fa-image"></i>
                 </div>
                 <div class="stat-content">
                     <h3 class="stat-number">567</h3>
                     <p class="stat-label">Images Generated <span class="stat-change positive">+15%</span></p>
                 </div>
             </div>
         </div>
         <div class="col-md-3">
             <div class="stat-card">
                 <div class="stat-icon bg-danger">
                     <i class="fas fa-clock"></i>
                 </div>
                 <div class="stat-content">
                     <h3 class="stat-number">89%</h3>
                     <p class="stat-label">Uptime <span class="stat-change negative">-2%</span></p>
                 </div>
             </div>
         </div>
     </div>

     <!-- Charts Row -->
     <div class="row g-4 mb-4">
         <div class="col-lg-8">
             <div class="dashboard-card">
                 <div class="card-header">
                     <h5 class="card-title">AI Usage Analytics</h5>
                     <div class="card-actions">
                         <button class="btn btn-sm btn-outline-primary">
                             <i class="fas fa-download"></i> Export
                         </button>
                     </div>
                 </div>
                 <div class="card-body">
                     <canvas id="usageChart" height="375"></canvas>
                 </div>
             </div>
         </div>
         <div class="col-lg-4">
             <div class="dashboard-card">
                 <div class="card-header">
                     <h5 class="card-title">Model Performance</h5>
                 </div>
                 <div class="card-body">
                     <canvas id="performanceChart" height="400"></canvas>
                 </div>
             </div>
         </div>
     </div>

     <!-- Recent Activity & Quick Actions -->
     <div class="row g-4">
         <div class="col-lg-8">
             <div class="dashboard-card">
                 <div class="card-header">
                     <h5 class="card-title">Recent Activity</h5>
                 </div>
                 <div class="card-body">
                     <div class="activity-list">
                         <div class="activity-item">
                             <div class="activity-icon bg-primary">
                                 <i class="fas fa-brain"></i>
                             </div>
                             <div class="activity-content">
                                 <h6>GPT-4 Model Training Completed</h6>
                                 <p>Advanced language model training finished successfully</p>
                                 <small class="text-muted">2 hours ago</small>
                             </div>
                         </div>
                         <div class="activity-item">
                             <div class="activity-icon bg-success">
                                 <i class="fas fa-image"></i>
                             </div>
                             <div class="activity-content">
                                 <h6>Image Generation Batch Complete</h6>
                                 <p>Generated 50 images using DALL-E model</p>
                                 <small class="text-muted">4 hours ago</small>
                             </div>
                         </div>
                         <div class="activity-item">
                             <div class="activity-icon bg-warning">
                                 <i class="fas fa-chart-bar"></i>
                             </div>
                             <div class="activity-content">
                                 <h6>Analytics Report Generated</h6>
                                 <p>Monthly performance report is ready for review</p>
                                 <small class="text-muted">6 hours ago</small>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-lg-4">
             <div class="dashboard-card">
                 <div class="card-header">
                     <h5 class="card-title">Quick Actions</h5>
                 </div>
                 <div class="card-body">
                     <div class="quick-actions">
                         <a href="ai-chat.html" class="quick-action-btn">
                             <i class="fas fa-comments"></i>
                             <span>Start AI Chat</span>
                         </a>
                         <a href="ai-image.html" class="quick-action-btn">
                             <i class="fas fa-image"></i>
                             <span>Generate Image</span>
                         </a>
                         <a href="ai-analytics.html" class="quick-action-btn">
                             <i class="fas fa-chart-line"></i>
                             <span>View Analytics</span>
                         </a>
                         <a href="ai-models.html" class="quick-action-btn">
                             <i class="fas fa-robot"></i>
                             <span>Manage Models</span>
                         </a>
                     </div>
                 </div>
             </div>
             
             <div class="dashboard-card mt-4">
                 <div class="card-header">
                     <h5 class="card-title">System Status</h5>
                 </div>
                 <div class="card-body">
                     <div class="status-list">
                         <div class="status-item position-relative">
                             <span class="status-label">API Status</span>
                             <span class="status-badge bg-success">Online</span>
                         </div>
                         <div class="status-item position-relative">
                             <span class="status-label">GPU Cluster</span>
                             <span class="status-badge bg-success">Active</span>
                         </div>
                         <div class="status-item position-relative">
                             <span class="status-label">Storage</span>
                             <span class="status-badge bg-warning">80% Used</span>
                         </div>
                         <div class="status-item position-relative">
                             <span class="status-label">Backup</span>
                             <span class="status-badge bg-info">Updated</span>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection
 @section('scripts')
 <script src="{{ asset('assets/js/dashboard.js') }}"></script>
 <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
 <script src="{{ asset('assets/js/charts.js') }}"></script>
 <!-- Chart.js -->
 @endsection