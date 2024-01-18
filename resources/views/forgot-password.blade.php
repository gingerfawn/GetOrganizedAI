@include('components.header')
@include('components.site-header-logged-out')
<form action="/reset-password-temp" method="post">
    @csrf
    <label for="email">Email</label>
    <input type="text" name="email">
    <input type="submit" value="Reset Password">
</form>
@include('components.footer')