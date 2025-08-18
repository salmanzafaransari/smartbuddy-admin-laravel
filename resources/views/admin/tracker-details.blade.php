@section('style')
<style></style>
@endsection
<div class="card-body" style="">
    <div class="row align-items-center mb-4">
        <div class="col-md-4 text-center">
            <img src="{{ $chatbot['chatbot_photo'] }}" 
                 alt="{{ $chatbot['name'] }}"
                 class="img-thumbnail rounded-circle shadow"
                 style="width: 120px; height: 120px; object-fit: cover;">
        </div>
        <div class="col-md-8">
            <h3 class="fw-bold mb-1">{{ $chatbot['name'] }}</h3>
            <div class="d-flex flex-wrap gap-2 mb-2">
                <span class="badge bg-primary">{{ $chatbot['type'] }}</span>
                <span class="badge bg-secondary">
                    <i class="far fa-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($chatbot['created_at'])->format('d F Y') }}
                </span>
            </div>
            <a href="{{ $chatbot['source_file'] }}" 
               target="_blank" 
               class="btn btn-sm btn-outline-primary">
                <i class="fas fa-file-pdf me-1"></i> View Source Document
            </a>
        </div>
    </div>
    <hr class="my-3">

    <!-- Tracker Table -->
    <h5 class="mb-3 d-flex align-items-center">
        <i class="fas fa-history text-primary me-2"></i>
        Tracking History
        <span class="badge bg-info ms-2">{{ count($trackers) }} records</span>
    </h5>
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="50">#</th>
                <th>Visited Page</th>
                <th width="180">Time</th>
                <th width="80">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trackers as $index => $tracker)
                <tr>
                    <td class="fw-bold">{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <a href="{{ $tracker['page'] }}" target="_blank" class="text-dark fw-semibold">
                                {{ last(explode('/', $tracker['page'])) ?: 'Home' }}
                            </a>
                            <small class="text-muted">{{ $tracker['website'] }}</small>
                        </div>
                    </td>
                    <td>
                        <small class="text-nowrap">
                            {{ \Carbon\Carbon::parse($tracker['created_at'])->format('d M Y \a\t h:i A') }}
                        </small>
                    </td>
                    <td>
                        <a href="{{ $tracker['page'] }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-primary"
                           title="Visit page">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">No tracking activity found</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>