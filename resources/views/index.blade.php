@include('components.header')
@include('components.site-header')
<div id="container">
    @auth
    <div id="sideNav">
        @include('components.sideNav')
    </div>

    <div id="main">            
        @include('components.AIForm')
    </div>

    <div id="sideGallery">
        @include('components.side-media-gallery')
    </div>
    @endauth
</div>
@include('components.footer')