@props(['name', 'title'])
    <div
     x-data="{ open: false, name: @js($name) }"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
      style="display: none;"
      x-show="open"
      x-transition
      @open-modal.window="if ($event.detail === `${name}`) open = true;"
      @close-modal.window="if ($event.detail === `${name}`) open = false;"
      x-cloak
      aria-modal="true"
      role="dialog"
      @keydown.escape.window="open = false"
      
    >
      <div class="w-full max-w-2xl mx-auto px-4">
        <x-card @click.away="open = false" class="shadow-xl max-w-2xl w-full max-h-[80vh] overflow-auto">
            <div class="flex items-center gap-3 mb-4">
                <h2 class="text-xl font-bold">{{ $title }}</h2>
            </div>

            {{ $slot }}
        </x-card>

      </div>


    </div>