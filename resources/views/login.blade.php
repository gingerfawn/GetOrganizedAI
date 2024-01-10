@include('components.header')
@include('components.site-header-logged-out')

    <form action="/login" method="POST">
       @csrf
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" value="">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" value="">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    @isset($post)
    @dd($post);
    @endisset
</div>
@include('components.footer')