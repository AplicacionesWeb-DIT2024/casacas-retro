<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            

            <li class="nav-item nav-dropdown">
                <a class="nav-link" href="{{ url('admin/camisetas') }}">
                    <i class="nav-icon icon-globe"></i> {{ trans('admin.camiseta.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/camisetas/clubes-nacionales') }}">
                            <i class="nav-icon icon-soccer"></i> Clubes Nacionales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/camisetas/clubes-internacionales') }}">
                            <i class="nav-icon icon-soccer"></i> Clubes Internacionales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/camisetas/selecciones') }}">
                            <i class="nav-icon icon-soccer"></i> Selecciones
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/talles') }}"><i class="nav-icon icon-star"></i> Guia de Talle </a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
