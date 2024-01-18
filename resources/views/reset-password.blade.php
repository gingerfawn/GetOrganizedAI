@include('components.header')
@include('components.site-header-logged-out')
<form action="/reset-password" method="post">
    @csrf
    <input type="password" name="new_password">
    <input type="submit" value="Reset Password">
</form>
@include('components.footer')