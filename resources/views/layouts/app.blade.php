{{-- Based on: vendor\jeroennoten\laravel-adminlte\resources\views\master.blade.php --}}
{{-- Page Layout: vendor\jeroennoten\laravel-adminlte\resources\views\page.blade.php --}}
@extends('adminlte::page')
@section('title', config('app.name'))

@section('content_header')
  <!-- Page Heading -->
  <header class="d-flex py-1 bg-white shadow-sm border-bottom">
    <div class="container">
      {{ $header }}
    </div>
  </header>
@stop

@section('content')
  <!-- Page Content -->
  <main class="container">
    {{ $slot }}
  </main>
@stop

@section('footer')
      Pangkalan Data dan Informasi, Est. 2021
@stop

@extends('layouts.app-rightbar')

@section('css')
  {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
  @once
    @push('scripts')
      <script defer>
        // console.log('Hi!');

      </script>
    @endpush
  @endonce
@stop
