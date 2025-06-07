    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach ($stats as $stat)
            @include('components.dashboard.stat-card', $stat)
        @endforeach
    </div>
