<nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#!">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="{{route('welcome')}}"><span class="fa fa-home"></span> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('about')}}"><span class="fa fa-book"></span> About</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{route('dashboard')}}"><span class="fa fa-tachometer-alt"></span> Dashboard</a></li>
                @endauth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        @foreach ($categories as $slug => $name)
                            <li><a class="dropdown-item" href="{{route('category.products', $slug)}}">{{$name}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                @auth
                <a class="btn btn-outline-light position-relative" href="{{ route('carts.index') }}">
                    <i class="bi-cart-fill me-1"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification">{{ count(auth()->user()->cartProducts) }}</span>
                </a>
                @else
                    <a class="btn btn-sm btn-outline-light" aria-current="page" href="{{route('login')}}">Log In</a>
                @endauth
            </form>
        </div>
    </div>
</nav>
