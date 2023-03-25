<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $contentHeader['title'] ?? 'Backend' }} - {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    @stack('before-styles')
    <link href="{{ mix('css/backend/app.css') }}" rel="stylesheet">
    @stack('after-styles')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    @include('backend.layouts.nav')

    @include('backend.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    {{-- @yield('content-header') --}}
    <x-backend.content-header :contentHeader="$contentHeader ?? []"/>

    @yield('content')

  </div>
  <!-- /.content-wrapper -->

  @include('backend.layouts.footer')

</div>
<!-- ./wrapper -->

@stack('before-scripts')
<script src="{{ mix('js/backend/app.js') }}"></script>
<script src="{{ asset('node_modules/admin-lte/dist/js/adminlte.min.js') }}"></script>
@stack('after-scripts')

@if (session('alert-message'))
    <script>
        let type = "{{ session('alert-type', 'info') }}";
        switch(type){
            case 'info':
               toastr.info("{{ session('alert-message') }}");
               break;
            case 'warning':
               toastr.warning("{{ session('alert-message') }}");
               break;
            case 'success':
               toastr.success("{{ session('alert-message') }}");
               break;
            case 'error':
               toastr.error("{{ session('alert-message') }}");
               break;
        }
    </script>
@endif
@if ($errors->any())
    <script>
        toastr.error("<ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul>")
    </script>
@endif

</body>
</html>
