<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechnipFMC.app') }}</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/ap.css') }}" rel="stylesheet">




    
</head>
<body>
<!--    <div id="fixhead" style="width:100%;background-color: #f5f8fa; position: fixed;z-index: 1;">  -->
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" >
            <div class="container">
                <div class="navbar-header" style="margin-top: 0px">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('images/tpfmc_logo.png') }}" style="width:150px;padding-bottom: 0px;" >

                        <!-- {{ config('app.name', 'Laravel') }} -->
                    </a>
                   
                </div>

                <div style="width: 1300px" class="collapse navbar-collapse" id="app-navbar-collapse">  <!-- tamaño menu-->
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                           <!--  <li><a href="{{ route('register') }}">Register</a></li> -->

                        @else

                            
                          

                            <li id="s99"><a href="{{ route('home') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'"><img src="{{ asset('images/home-icon.png') }}" style="width:20px" ></a></li>
                            <li id="s0" class="dropdown"><a href="{{ route('equipments') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Equipments</a></li>
                            <li id="s1"><a href="{{ route('civils') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Civil</a></li>
                            <li id="s2"><a href="pipes" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Piping</a></li>
                            <li id="s4"><a href="ldlpipes" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">LDL</a></li>
                            
                            <li id="s3"><a href="delecdistboardsdatatable" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Electrical</a></li>
                            <li id="s3"><a href="delecdistboardsdatatable" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Instrumentation</a></li>
                             <li id="s0"><a href="{{ route('dashboard') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'"><strong>Dashboard</strong></a></li>
                             
                           <li id="s98"><a href="{{ route('pmanager') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'"><img src="{{ asset('images/config-icon.png') }}" style="width:20px" ></a></li>
                           

                           <!--  <li class="dropdown">

                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Charts <span class="caret"></span>
                                </a>
                                 <ul class="dropdown-menu" role="menu">
                                   <li>  
                                 
                                        <a data-toggle="modal" data-target="#glineequiModal">Equipments</a>                              
                                        <a data-toggle="modal" data-target="#glinecivilModal">Civil</a>
                                    
                                </li>
                                 </ul>    



                      
                            </li> -->

                                <li id="s00"><a href=""><strong>800111-PHOENIX</strong></a></li>
                              <li id="s00"><a href=""><img src="{{ asset('images/total_logo.png') }}" style="width:80px;"></a></li>
                            
                             
                            
                            <li class="dropdown">
                            
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('home') }}">
                                            Home
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <b>Logout<b>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>


                        @endif
                    </ul>

                </div>


                
            </div>
        </nav>

        @yield('content')
    
    </div>


</body>
</html>
