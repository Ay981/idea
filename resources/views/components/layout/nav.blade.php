<nav class="flex w-full border-b border-border  fixed justify-between" >
  <div class="w-full max-w-7xl mx-auto h-16 flex items-center justify-between">
    <div>
      <a href="/">
        <img src="{{ asset('images/logo.svg') }}" alt="Idea logo" width="100">
      </a>
    </div>

    <div class="flex gap-x-5 items-center">
      @guest
      <a href="/login">Sign In</a>
      <a href="/register" class="btn">Create account</a>
      @endguest

      @auth
      <form method="post" action="/logout">
        @csrf
        <button>log out</button>
      </form>
      @endauth
    </div>
  </div>
</nav>