<x-layout>
    <div class="ml-50 w-full mx-auto ">
        <div class="mb-10 flex items-center justify-between">
        <a href="{{ route('ideas.index') }}" class="inline-flex items-center text-sm font-medium text-white hover:underline mt-23">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to all ideas
        </a>
        <div class="flex gap-2">
            {{-- <a href="{{ route(name: 'ideas.edit', $idea) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-gray-700 transition">Edit</a> --}}
            <form action="{{ route('idea.destroy', $idea) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded hover:bg-gray-700 transition">Delete</button>
            </form>
        </div>
        </div>
        <div>
            @if ($idea?->path_to_image)
                <div class="rounded-lg overflow-hidden">
                    <img 
                        src="{{ asset('storage/' . $idea->path_to_image) }}" 
                        alt="Idea image" 
                        class=" w-full h-auto rounded-t shadow-lg object-cover"
                    >
                </div>
            @endif
            <h1 class="text-4xl font-extrabold mb-6 text-white tracking-tight">
                {{ $idea?->title ?? 'Untitled' }}
            </h1>
        </div>
        <div class="flex gap-x-3 ">
            <x-idea.status :status="$idea?->status?->value">{{ $idea?->status?->label() }}</x-idea.status>
            <p>{{ $idea?->created_at?->diffForHumans() }}</p>
        </div>

        <x-card class="w-full mt-8 p-6 md:p-7 border border-border/60 bg-card shadow-[0_16px_40px_rgba(0,0,0,0.35)]">
            <p class="text-sm md:text-base leading-relaxed text-white">
                {{ $idea?->text ?? '' }}
            </p>
        </x-card>
        @if ($idea->steps->count())
           <h1 class="text-4xl font-extrabold mb-6 text-white tracking-tight mt-10">
            Actionable steps
        </h1>
    
        <div class="grid gap-4">
        @foreach ($idea?->steps ?? [] as $step)
            <x-card class="p-4 border border-border/60 bg-card shadow-[0_12px_30px_rgba(0,0,0,0.25)]">
                <form method="POST" action="{{ route('steps.update', $step) }}">
                    @csrf
                    @method('PATCH')

                     <div class = "flex items-center gap-x-3">
                    <button class="size-7 flex items-center justify-center rounded-full transition text-primary-foreground{{ $step->completed ? ' bg-primary' : ' border border-primary' }}">
                
                    &check;
                </button>
                <p class="text-white font-semibold {{ $step->completed ? 'line-through text-muted-foreground' : '' }}">{{ $step->description }}</p>
              
                </div>
                </form>
            </x-card>
        @endforeach
        </div>
            
        @endif

        @if ($idea?->links->count())
          <h1 class="text-4xl font-extrabold mb-6 text-white tracking-tight mt-10">
            Links
        </h1>
    
        <div class="grid gap-4">
        @foreach ($idea?->links ?? [] as $link)
            <x-card class="p-4 border border-border/60 bg-card shadow-[0_12px_30px_rgba(0,0,0,0.25)]">
                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="text-primary font-semibold hover:underline break-all transition rounded-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H19v5.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 13.5L19 6" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 13.5v4A1.5 1.5 0 0 1 17.5 19h-11A1.5 1.5 0 0 1 5 17.5v-11A1.5 1.5 0 0 1 6.5 5h4" />
                    </svg>
                    {{ $link }}
                </a>
            </x-card>
        @endforeach
        </div>
 
            
        @endif
         </div>

</x-layout>
