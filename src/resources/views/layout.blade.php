<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />

  <title>@yield('title')</title>

  <link rel="stylesheet" href="/css/app.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed&display=swap&subset=cyrillic" />
</head>

<body>
  <div class="layout">
    <aside class="layout__sidebar">
      <div class="layout__sidebar-inner">
      @include('sidebar')
      </div>
    </aside>

    <main class="layout__main">
      <div class="layout__main-inner">
      @yield('content')
      </div>
    </main>
  </div>

  <script src="/js/manifest.js"></script>
  <script src="/js/vendor.js"></script>
  <script src="/js/app.js"></script>
</body>

</html>
