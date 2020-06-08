@include('plantillas.head')

<body>

<header>
    @include('plantillas.nav')
</header>

@yield('main')
<div class="container working">
    <div class="container div-working">
        <div class="card" style="width: 18rem;">
            <img src="../../css/working.jpg" class="card-img-top img-working" alt="...">
            <div class="card-body">
                <p class="card-text">Proyecto en desarrollo...</p>
            </div>
        </div>
    </div>
</div>
@include('plantillas.footer')
