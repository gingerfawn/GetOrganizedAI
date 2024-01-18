@include('components.header')
@include('components.site-header-logged-out')
<div>{{$message}}</div>
    <form action="/login" method="POST">
       @csrf
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" value="@isset($email) {{$email}} @endisset">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" value="">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>

</div>
<div><a href="/forgot-password">Forgot Password</a></div>

@include('components.footer')