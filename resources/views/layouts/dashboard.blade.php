@extends('layouts.plane')

@section('body')

    <header id="fh5co-header" role="banner">
        <div class="container">
            <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle dark"><i></i></a>
            <div id="fh5co-logo"><a href="index.html"><img src="images/logo.jpg" alt="Free HTML5 Website Template"></a></div>
            <nav id="fh5co-main-nav" role="navigation">
                <ul>
                    <li><a href="about.html">About</a></li>
                    <li class="has-sub">
                        <div class="drop-down-menu">
                            <a href="services.html">Services</a>
                            <div class="dropdown-menu-wrap">
                                <ul>
                                    <li><a href="#">Web Development</a></li>
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">Graphic Design</a></li>
                                    <li><a href="#">Branding</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li><a href="portfolio.html">Portfolio</a></li>
                    <li class="has-sub">
                        <div class="drop-down-menu">
                            <a href="#">Sidebars</a>
                            <div class="dropdown-menu-wrap">
                                <ul>
                                    <li><a href="right-sidebar.html">Right Sidebar</a></li>
                                    <li><a href="left-sidebar.html">Left Sidebar</a></li>

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="cta"><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>



    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <img class="navbar-brand" src="/images/logo.jpg">
                <a class="navbar-brand" href="{{ url ('') }}">Kairosformazione</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                    </a>

                    @if( Auth::check() )

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="users/{{ Auth::user()->id }}/edit"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>

                            <li class="divider"></li>
                            <li><a href="{{ url ('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout </a></li>
                        </ul>
                        @endif
                                <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">


                            {{ Form::open(['method'=>'GET','url'=>'commesse','class'=>'','role'=>'search'])  }}
                            <div class="form-group">
                                <div class="input-group custom-search-form form-group">
                                    <input type="text" id="search"  name="search"   class="form-control" placeholder="Cerca commessa...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                                </span>
                                </div>

                            </div>
                            {{ Form::close()  }}


                        </li>

                        <!--                    <li>
                                                <a href="#"><i class="fa fa-wrench fa-fw"></i> Commesse <span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">-->
                        <li {{ (Request::is('*Calendario') ? 'class="active"' : '') }}>
                            <a href="{{ url ('calendario') }}"><i class="fa fa-plus-square-o fa-fw"></i>Inserisci commessa</a>
                        </li>

                        <li {{ (Request::is('*feriepermessi') ? 'class="active"' : '') }}>
                            <a href="{{ url ('feriepermessi') }}"><i class="fa fa-plane   fa-fw"></i>Ferie Permessi Recuperi</a>
                        </li>

                        <li {{ (Request::is('*calendar') ? 'class="active"' : '') }}>
                            <a href="{{ url ('calendar') }}"><i class="fa fa-calendar fa-fw"></i>Calendario mie commesse</a>
                        </li>




                        <li class="divider"></li>
                        <li class="divider"></li>


                        @if(Auth::user()->hasAnyGroups(array('Admin', 'Contabilita')))
                            <li {{ (Request::is('*Dipendenti') ? 'class="active"' : '') }}>
                                <a href="{{ url ('users') }}"><i class="fa fa-user fa-fw"></i>Dipendenti</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasAnyGroups(array('Admin', 'Contabilita')))
                            <li {{ (Request::is('*Commesse') ? 'class="active"' : '') }}>
                                <a href="{{ url ('commesse') }}"><i class="fa fa-dribbble  fa-fw"></i>Commesse</a>

                            </li>
                        @endif

                        @if(Auth::user()->hasAnyGroups(array('Admin', 'Contabilita')))
                            <li {{ (Request::is('*Commesse') ? 'class="active"' : '') }}>
                                <a href="{{ url ('commesse/create') }}"><i class="fa fa-dribbble  fa-fw"></i>Nuova Commesse</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasAnyGroups(array('Admin', 'Tutor')))
                            <li {{ (Request::is('*approvazione') ? 'class="active"' : '') }}>
                                <a href="{{ url ('approvazione') }}"><i class="fa   fa-unlock-alt fa-fw"></i>Approvazione extra</a>
                            </li>

                        @endif



                        @if(Auth::user()->hasAnyGroups(array('Contabilita')))
                            <li {{ (Request::is('*rilevazione') ? 'class="active"' : '') }}>
                                <a href="{{ url ('rilevazione') }}"><i class="fa   fa-unlock-alt fa-fw"></i>Rilevazione extra</a>
                            </li>
                            @endif


                                    <!--</li></ul>-->



                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page_heading')
                        <div class="pull-right">@yield('action_button')</div>
                    </h1>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                @yield('section')

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop

@yield('script')