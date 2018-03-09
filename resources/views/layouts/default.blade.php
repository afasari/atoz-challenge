<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('includes.partials.header')
</head>
<body>
    @include('includes.partials.navbar')
    
    <main class="py-4 text-center" id="app">
            @yield('content')
    </main>

    @include('includes.partials.footer')

</body>
</html>
