<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-background text-foreground">

    <x-layout.nav />
    
    <main class=" mx-auto px-20 pb-10">
        {{$slot}}
    </main>
    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 1000)"
        x-show="show"
        x-transition.opacity.duration.500ms
        @click="show = false"
        class="bg-primary px-4 py-3 fixed bottom-4 right-4 rounded-lg z-50"
    >
        {{ session('success') }}
    </div>
    @endif
</body>
</html>