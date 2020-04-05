<nav class="sidebar">
  <ul>
    @if (Auth::check())
    <li>
      <a class="link" href="/">Dashboard</a>
    </li>

    <li>
      <form method="POST" action="/logout">
        @csrf
        <button class="link" type="submit">Sign Out</button>
      </form>
    </li>
    @else
    <li>
      <a class="link" href="/login">Sign In</a>
    </li>

    <li>
      <a class="link" href="/register">Sign Up</a>
    </li>
    @endif
  </ul>
</nav>
