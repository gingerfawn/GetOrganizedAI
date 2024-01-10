@include('components.header')
@include('components.site-header-logged-out')

<form action="/sign-up" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="">
        </div>
        <div>
            <label for='email'>Email</label>
            <input type="text" name="email" value="">
        </div>
        <div>
            <label for="password">Password</label>
            <input name="password" type="password" value="">
        </div>
        <div>
            <label for='confirm_password'>Confirm Password</label>
            <input name="confirm_password" type="password" value="">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    <div>
    @isset($post)
        @dd($post);
    @endisset
    </div>
@include('components.footer')