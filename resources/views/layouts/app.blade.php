        @include('components.header')
        @include('components.navbar')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @include('components.footer')
