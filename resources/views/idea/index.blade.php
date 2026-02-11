<x-layout>
  <div class="max-w-6xl mx-auto">
    <header class="py-8 md:py-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
      <div class="space-y-2">
        <p class="text-xs uppercase tracking-[0.2em] text-muted-foreground">Workspace</p>
        <h1 class="text-3xl md:text-4xl font-bold text-foreground">Ideas</h1>
        <p class="text-muted-foreground text-sm md:text-base">Capture your thoughts. Make a plan.</p>
      </div>
  
    </header>

  <x-card
    x-data="{}"
    x-on:click="$dispatch('open-modal', 'create')"

  class="hover:shadow-lg transition-shadow"
>
      <button
        dusk="create-idea-button"
        class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between w-full text-left focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-lg p-4 hover:bg-muted/50 transition-colors"
        type="button"
      >
        <div class="space-y-1">
          <h2 class="text-base md:text-lg font-semibold text-foreground">Start a new idea</h2>
          <p class="text-sm text-muted-foreground">Write a short title and outline the next steps.</p>
        </div>
        <div class="inline-flex items-center gap-2 text-xs text-muted-foreground">
          <span class="h-2 w-2 rounded-full bg-primary"></span>
          Drafts stay private
        </div>
      </button>
    </x-card>

    <div class="mt-6 flex flex-wrap gap-2 items-center">
      @php $counts = $statusCounts ?? collect(); @endphp
      <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">
        All
        <span class="ml-2 inline-flex items-center justify-center min-w-8 px-2 py-0.5 rounded-full bg-slate-800/60 text-xs font-semibold text-white border border-slate-700">
          {{ $counts->get('all', 0) }}
        </span>
      </a>

      @foreach (App\Ideastatus::cases() as $status)
        @php $c = $counts->get($status->value, 0); @endphp
        <a href="/ideas?status={{ $status->value }}" class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">
          {{ $status->label() }}
          <span class="ml-2 inline-flex items-center justify-center min-w-8 px-2 py-0.5 rounded-full bg-slate-800/60 text-xs font-semibold text-white border border-slate-700">
            {{ $c }}
          </span>
        </a>
      @endforeach
    </div>

    <div class="mt-10">
      <div class="grid gap-6 md:grid-cols-2">
        @forelse($ideas as $idea)
          <a href="{{ route('idea.show', $idea->id) }}" class="group block">
            <x-card>
              @if ($idea?->path_to_image)
                <img src="{{ asset('storage/' . $idea->path_to_image) }}" alt="Idea image" class="w-full h-32 md:h-40 object-cover rounded-t">
              @endif
              <div class="p-4">
                <div class="flex items-center gap-2 mb-2">
                  <h3 class="text-foreground text-lg font-semibold group-hover:text-primary transition-colors flex-1">
                    {{ $idea->title }}
                  </h3>
                  <x-idea.status status="{{ $idea->status->value }}">
                    {{ $idea->status->label() }}
                  </x-idea.status>
                </div>
              
                <p class="text-xs text-muted-foreground mb-2">
                    {{ $idea->created_at->diffForHumans() }}
                </p>
                <div class="line-clamp-3 text-sm text-muted-foreground">
                    <p>{{ $idea->text }}</p>
                </div>
              </div>
            </x-card>
          </a>
          @empty
          <p class="text-sm text-muted-foreground">No ideas at this time.</p>
        @endforelse
      </div>
    </div>
    <x-modal name="create" title="Create Idea">
        <form 
        x-data="{ status: @js(\App\Ideastatus::pending->value),
          newlink: '',  
          links: [],
            newStep: '', 
            steps: []
         }"
         method="POST" 
        action="{{ route('ideas.store') }}"
        enctype="multipart/form-data">
          @csrf
          <div class="space-y-6">
                  @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-900/80 text-red-200 border border-red-700">
                      <div class="font-semibold mb-1">There were problems with your submission:</div>
                      <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
            <x-form.field 
                label="Title"
                name="title"
                autofocus
                required
            />
            <div>
              <label for="status" class="label">Status</label>
              <div class="flex gap-2">
                  @foreach (\App\Ideastatus::cases() as $status)
                  <button
                    dusk="button-status-{{ $status->value }}"
                    class="btn flex flex-1 h-10"
                    type="button"
                    @click="status = @js($status->value)"
                    :class="status === @js($status->value) ? '' : 'btn-outlined'"
                  >
                    {{ $status->label() }}
                  </button>
                  @endforeach
              </div>
              <p class="text-xs text-muted-foreground mt-2">
                  Selected: <span class="text-foreground" x-text="status"></span>
              </p>
              <input type="hidden" name="status" :value="status">
            </div>
            <x-form.field
                label="Text"
                name="text"
                type="textarea"
                placeholder="What's on your mind?"
            />

            <div class="space-y-3">
              <label for="image" class="label">Image</label>
              <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full" />


            </div>
            {{-- steps --}}

            <div class="flex w-full max-w-3xl gap-4">

              <fieldset class="w-full">
                <legend>Actionable steps</legend>
                <div class="flex flex-col gap-2 mb-2 w-full">
                  <template x-for="step in steps">
                        <div class="flex items-center w-full">
                        <input type="hidden" name="steps[]" :value="step">
                        <span class="input flex-1" x-text="step"></span>
                        <button
                          type="button"
                          class="ml-2 text-red-500 hover:text-red-700 flex items-center justify-center w-6 h-6"
                          @click="steps = steps.filter(s => s !== step)"
                          aria-label="Remove step"
                          tabindex="0"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                        </button>
                      </div>                  
            </template>
                </div>
                <div class="flex w-full items-center gap-2">
                  <input
                  x-model="newStep"
                  type="text"
                  id="newStep"
                  class="input flex-1 w-full"
                  placeholder="Steps to follow"
                  spellcheck="false"
                  >
                  <button
                    @click.prevent="steps.push(newStep); newStep = ''"
                    type="button"
                    class="inline-flex items-center justify-center rounded-full text-white w-8 h-8 hover:bg-primary/90 transition-colors shadow-md focus:outline-none focus:ring-2 focus:ring-primary/50"
                    aria-label="Add step"
                    :disabled="newStep.trim() === ''"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                  </button>
                </div>
              </fieldset>
            </div>
            

            {{-- link --}}
            <div class="flex w-full max-w-3xl gap-4">

              <fieldset class="w-full">
                <legend>Links</legend>
                <div class="flex flex-col gap-2 mb-2 w-full">
                  <template x-for="link in links">
                        <div class="flex items-center w-full">
                        <input type="hidden" name="links[]" :value="link">
                        <span class="input flex-1" x-text="link"></span>
                        <button
                          type="button"
                          class="ml-2 text-red-500 hover:text-red-700 flex items-center justify-center w-6 h-6"
                          @click="links = links.filter(l => l !== link)"
                          aria-label="Remove link"
                          tabindex="0"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                        </button>
                      </div>                  
            </template>
                </div>
                <div class="flex w-full items-center gap-2">
                  <input
                  x-model="newlink"
                  type="url"
                  id="new-link"
                  class="input flex-1 w-full"
                  placeholder="https://example.com"
                  autocomplete="url"
                  spellcheck="false"
                  >
                  <button
                    @click.prevent="links.push(newlink); newlink = ''"
                    type="button"
                    class="inline-flex items-center justify-center rounded-full text-white w-8 h-8 hover:bg-primary/90 transition-colors shadow-md focus:outline-none focus:ring-2 focus:ring-primary/50"
                    aria-label="Add link"
                    :disabled="newlink.trim() === ''"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                  </button>
                </div>
              </fieldset>
            </div>
            <div class="flex justify-end gap-4 mt-6">
              <button type="button" @click="$dispatch('close-modal', 'create')" class="text-red-500">Cancel</button>
              <button type="submit" class="btn" dusk="create-idea-submit">Submit</button>
            </div>

            </div>
          </div>
        </form>
    </x-modal>
  </div>
</x-layout>