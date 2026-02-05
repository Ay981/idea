<x-layout>
  <div>
    <header class="py-8 md:py-12">
      <h1 class="text-3xl font-bold text-muted-foreground">Ideas</h1>
      <p class="text-muted-foreground text-sm mt-2">Capture your thoughts. Make a plan.</p>
    </header>
    <div class="flex gap-3 items-center">
      @php $counts = $statusCounts ?? collect(); @endphp
      <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">
        All
        <span class="ml-2 inline-flex items-center justify-center min-w-[32px] px-2 py-0.5 rounded-full bg-slate-800/60 text-xs font-semibold text-white border border-slate-700">{{ $counts->get('all', 0) }}</span>
      </a>

      @foreach (App\Ideastatus::cases() as $status)
        @php $c = $counts->get($status->value, 0); @endphp
        <a href="/ideas?status={{ $status->value }}" class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">
          {{ $status->label() }}
          <span class="ml-2 inline-flex items-center justify-center min-w-[32px] px-2 py-0.5 rounded-full bg-slate-800/60 text-xs font-semibold text-white border border-slate-700">{{ $c }}</span>
        </a>
      @endforeach
    </div>

    <div class="mt-10">
      <div class="grid md:grid-cols-2 gap-6">
        @forelse($ideas as $idea)
          <x-card>
            <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>
            <x-idea.status status="{{ $idea->status->value }}">
              {{ $idea->status->label() }}
            </x-idea.status>
            <div class="line-clamp-3 mt-4"> <p>{{ $idea->text }}</p> </div>
            <p class="mt-5">{{ $idea->created_at->diffForHumans() }}</p>
          </x-card>
        @empty
          <p>No ideas at this time.</p>
        @endforelse
      </div>
    </div>
  </div>

</x-layout>