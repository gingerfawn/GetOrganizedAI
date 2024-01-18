@include('components.header')
@include('components.site-header-logged-out')

@isset($dup_account_message)
{!! $dup_account_message !!}
@else 
    <form action="/sign-up" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="@isset($name) {{$name}} @endisset" required>
        </div>
        <div>
            <label for='email'>Email</label>
            <input type="text" name="email" value="@isset($email){{$email}} @endisset" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input name="password" type="password" value="" required>
        </div>
        <div>
            <label for="confirm_password">Confirm Password</label>
            <input name="confirm_password" type="password" value="" required>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    @isset($validation_error)
    <div class="alert alert-danger">
     {{$validation_error}}
    </div>
    @endisset
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endisset

@include('components.footer')