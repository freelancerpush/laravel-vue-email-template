<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel Vue.js Email Template Task') }}</title>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div id="vue-wrapper">
      @yield('content')
    </div>
  </div>
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  @yield('scripts')
</body>
</html>
