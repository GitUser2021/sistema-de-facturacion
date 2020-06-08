<nav class="navbar navbar-expand-lg navbar-dark">
    <button id = "btn-menu" class="navbar-toggler" type="button" xxxdata-toggle="xxxcollapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="" href="/facturas"><i class="far fa-list-alt"></i>FACTURAS</a>
            </li>
            <li class="nav-item">
                <a class="" href="/productos"><i class="fas fa-barcode"></i>PRODUCTOS</a>
            </li>
            <li class="nav-item">
                <a class="" href="/clientes"><i class="fas fa-user"></i>CLIENTES</a>
            </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle salir" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
            </ul>
    </div>

</nav>
<script>
    $("#btn-menu").click(function(){
        $("#navbarNav").toggle();
    });
</script>
