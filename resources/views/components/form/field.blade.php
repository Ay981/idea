@props(['label','name','type'=>'text'])
<div class="space-y-2">

        <label for="{{ $name }}" class="label">{{ $label }}</label>
        <input
                type="{{ $type }}"
                class="input"
                id="{{ $name }}"
                name="{{ $name }}"
                @if($type !== 'password') value="{{ old($name) }}" @endif
        >
        @error($name)
                <p class="error">{{ $message }}</p>
        @enderror

</div>