<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Catalis HR') }}</title>
  @livewireStyles
</head>

<body class="">
  <div>
    <h1>This Is {{ config('app.name', 'Some App') }}</h1>
  </div>

  <livewire:counter />


  @livewireScripts
</body>

</html>
