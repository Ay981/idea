@if(isset($href))
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'border-border rounded-lg bg-card dark:bg-neutral-900 text-foreground p-2 md:text-sm']) }}>
        {{ $slot }}
    </a>
@else
    <div {{ $attributes->merge(['class' => 'border-border rounded-lg bg-card dark:bg-neutral-900 text-foreground p-4 md:text-sm']) }}>
        {{ $slot }}
    </div>
@endif