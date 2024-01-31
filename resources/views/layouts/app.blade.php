        @include('components.header')
        @include('components.navbar');

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/bootstrap.js')}}"></script>
    @stack('scripts');
</body>
</html>
