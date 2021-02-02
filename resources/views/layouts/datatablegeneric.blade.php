<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name') }}</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >

    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
    <script src="{{ asset('js/dropzone.js') }}"></script>



    
</head>
<body>
<!--    <div id="fixhead" style="width:100%;background-color: #f5f8fa; position: fixed;z-index: 1;">  -->
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="width: 100%">
    <div style="position:fixed;width: 20%;font-size:16px;opacity: 0.9;margin-top: 2%;margin-left: 40%">
        
        <center><div id="messages">
        @if ($message = Session::get('success'))

        <br>


        <div class="alert alert-success"> 
            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="font-size: 16px">x</a>
            <p><img src="{{ asset('images/plan-icon.png') }}" style="width:30px" ><br>{{ $message }}</p>
        </div>

    @endif

        @if ($message = Session::get('warning'))
        <br>
        <br>

        <div class="alert alert-warning"> 
            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="font-size: 16px">x</a>
            <p><img src="{{ asset('images/warning-icon.png') }}" style="width:50px" ><br>{{ $message }}</p>
        </div>

    @endif

        @if ($message = Session::get('danger'))
        <br>
        <br>

                <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="font-size: 16px">x</a> 
                    <p><img src="{{ asset('images/error-icon.png') }}" style="width:50px" ><br>{{ $message }}</p>
                </div>

            @endif
        </div>
</center>

<script type="text/javascript">
    
    setTimeout(function() {
    $('#messages').fadeOut('slow');
}, 2000);

</script>
    </div>
            <div class="container" style="">

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


                           
                            <img src="{{ asset('images/tpfmc_logo.svg') }}" style="width:200px;padding-bottom: 0px;" >

                            


                        <!-- {{ config('app.name', 'Laravel') }} -->
                    </a>
                   
                </div>

                <div style="width: 750px;height: 40px" class="collapse navbar-collapse" id="app-navbar-collapse">  <!-- tamaño menu-->
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">

                            <h2><b>Naviswork XML Generator</b></h2>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                           <!--  <li><a href="{{ route('register') }}">Register</a></li> -->

                        @else

                            
                             @role('Pipe')
                             <li id="s99"><a href="{{ route('home') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'"><img src="{{ asset('images/home-icon.png') }}" style="width:20px" ></a></li>

                            <li id="s2" class="dropdown" style="font-size: 13px">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Piping <span class="caret"></a>
                            <ul class="dropdown-menu" role="menu">
                                <li style="font-size: 13px">
                                <a href="{{ route('epipes') }}">Estimated</a>
                                <a href="{{ route('pipes') }}">Modelled</a>
                                <a href="{{ route('holds') }}">Holds</a>
                                <a href="{{ route('glinepipetotal') }}">Progress Curve</a>
                <!--                 <a href="{{ route('glinepipe') }}">Progress Curve by Area</a> -->
                                <!-- <a href="{{ route('filterpipes') }}">Filter</a> -->
<!--                                 <a href="{{ route('modeledequi') }}">Modelled</a>
                                <a href="{{ route('glineequi') }}">Line Progress</a>
                                <a href="{{ route('glineequitotal') }}">Line Progress by Areas</a> -->
                                <a href="{{ route('home') }}">Home</a>
                                </li>        
                            </ul>
                        </li>
                        @endrole

                            @role('Equi')<li id="s0" class="dropdown" style="font-size: 13px">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'" >Equipment <span class="caret"></a>
                            <ul class="dropdown-menu" role="menu">
                                <li style="font-size: 13px">
                                <a href="{{ route('eequis') }}">Estimated</a>
                                <a href="{{ route('modeledequi') }}">Modelled</a>
                                <a href="{{ route('glineequitotal') }}">Progress Curve</a>
                                <!-- <a href="{{ route('glineequi') }}">Progress Curve by Area</a> -->
                                <a href="{{ route('typesequi') }}">Types</a>    
                                <a href="{{ route('home') }}">Home</a>
                                </li>        
                            </ul>
                        </li>
                            @endrole

                           
                            
                            <!-- <li id="s0"  style="font-size: 13px" class="dropdown"><a href="{{ route('equipments') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Equipments</a></li> -->

                         <!--    <li id="s2" style="font-size: 13px"><a href="pipes" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Piping</a></li> -->
                            
                            @role('Civil')
                            <li id="s1" class="dropdown" style="font-size: 13px">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'" >Civil <span class="caret"></a>
                            <ul class="dropdown-menu" role="menu">
                                <li style="font-size: 13px">
                                <a href="{{ route('ecivils') }}">Estimated</a>
                                <a href="{{ route('modeledcivil') }}">Modelled</a>
                                <a href="{{ route('glineciviltotal') }}">Progress Curve</a>
                     <!--            <a href="{{ route('glinecivil') }}">Progress Curve by Area</a> -->
                                <a href="{{ route('typescivil') }}">Types</a>    
                                <a href="{{ route('home') }}">Home</a>
                                </li>        
                            </ul>
                        </li>
                            @endrole

                            @role('Inst')
                            <li id="s3" class="dropdown" style="font-size: 13px">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'" >Instrumentation <span class="caret"></a>
                            <ul class="dropdown-menu" role="menu">
                                <li style="font-size: 13px">
                                <a href="{{ route('einsts') }}">Estimated</a>
                                <a href="{{ route('modeledinst') }}">Modelled</a>
                                <a href="{{ route('glineinsttotal') }}">Progress Curve</a>
                               <!--  <a href="{{ route('glineinst') }}">Progress Curve by Area</a> -->
                                <a href="{{ route('typesinst') }}">Types</a>    
                                <a href="{{ route('home') }}">Home</a>
                                </li>        
                            </ul>
                        </li>
                            @endrole

                            @role('Elec')
                            <li id="s4" class="dropdown" style="font-size: 13px">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'" >Electrical <span class="caret"></a>
                            <ul class="dropdown-menu" role="menu">
                                <li style="font-size: 13px">
                                <a href="{{ route('eelecs') }}">Estimated</a>
                                <a href="{{ route('modeledelec') }}">Modelled</a>
                                <a href="{{ route('glineelectotal') }}">Progress Curve</a>
                       <!--          <a href="{{ route('glineelec') }}">Progress Curve by Area</a> -->
                                <a href="{{ route('typeselec') }}">Types</a>    
                                <a href="{{ route('home') }}">Home</a>
                                </li>        
                            </ul>
                        </li>
                            @endrole

                         @role('Isoctrl')<li id="s5" class="dropdown" style="font-size: 13px">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'" >Iso Tracker <span class="caret"></a>
                            <ul class="dropdown-menu" role="menu">
                                <li style="font-size: 13px">
                                <a href="{{ route('isostatus') }}">Status</a>
                                <a href="{{ route('hisoctrl') }}">History</a>
                                <a href="{{ route('design') }}">Design</a>
                                <a href="{{ route('stress') }}">Stress</a>
                                <a href="{{ route('supports') }}">Supports</a>    
                                <a href="{{ route('materials') }}">Materials</a>
                                <a href="{{ route('lead') }}">Issuer</a>    
                                <a href="{{ route('iso') }}">LDE/Isocontrol</a>
                                <a href="{{ route('commontray') }}"><b>CHECK BY...</b></a>
                                </li>        
                            </ul>
                        </li>
                            @endrole

                           
                            
                            <!--  <li id="s4" style="font-size: 13px"><a href="ldlpipes" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">LDL</a></li>
                            
                            <li id="s3" style="font-size: 13px"><a href="delecdistboardsdatatable" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Electrical</a></li>
                            <li id="s3" style="font-size: 13px"><a href="delecdistboardsdatatable" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Instrumentation</a></li> -->
                             <!-- <li id="s0" style="font-size: 13px"><a href="{{ route('dashboard') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'"><strong>Dashboard</strong></a></li> -->
                             
                          <!--  <li id="s98" style="font-size: 13px"><a href="{{ route('pmanager') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'">Setup</a></li> -->

                         <!--   <li id="s98"><a href="{{ route('pmanager') }}" style="border-radius: 0px 0px 4px 4px;transition:200ms" onMouseOver="this.style.background='#B0BED9';this.style.color='white'" onMouseOut="this.style.background='white';this.style.color='black'"><img src="{{ asset('images/config-icon.png') }}" style="width:20px" ></a></li> -->
                           

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
                        
                              <!-- <li id="s00" style="font-size: 13px"><a href=""><strong>000000-PROJECT</strong></a></li> -->
                              <!-- <li id="s00" style="font-size: 13px"><a href=""><strong>PROJECT LOGO</strong></a></li> -->
                               <li id="s00" style="font-size: 13px"><a href=""><strong><?php echo env('APP_NAMEPROJ') ?></strong></a></li> 
                               <li id="s00"><a href=""><img src="{{ asset('images/iquoxe_logo.png') }}" style="width:65px;"></a></li>
                            
                             
                         <li style="font-size: 13px" class="dropdown">
                            
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li style="font-size: 13px">
                                        <a href="{{ route('home') }}">
                                            Home
                                        </a>
                                        <a href="{{ route('password') }}">
                                            Change Password
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
