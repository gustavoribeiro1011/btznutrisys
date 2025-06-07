<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    @foreach ($stats as $stat)
        @include('components.dashboard.stat-card', $stat)
    @endforeach
</div>
