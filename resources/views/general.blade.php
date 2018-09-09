<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ligne Maginot</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link rel="stylesheet" type="text/css" href="/css/responsive.css">
        <link rel="stylesheet" type="text/css" href="/css/stallingrad.css">
        <link rel="stylesheet" href="/css/toastr.css">


        <script src="/js/jquery-1.11.0.min.js"></script>
        <script src="/js/toastr.js"></script>
        <script type="text/javascript" src="/js/fontawesome.js"></script>
        <script type="text/javascript" src="/js/sweetalert2.js"></script>
        

    </head>
    <body>
        <div class="subHeader">
            <div class="container">
                <div class="row">
                    @if (Auth::user())
                        <small>
                            <i class="fas fa-user-circle" aria-hidden="true"></i> 
                            Bonjour <b>
                            {{Auth::user()->fname}} {{Auth::user()->lname}}</b>
                            | <a href="#" onclick="logout(); return false;">Déconnexion</a>
                        </small>
                    @endif
                    <small>
                        <form style="display: none;" id="logout_form" action="" method="POST" hidden>
                            {{ csrf_field() }}
                        </form>
                        @if (!Auth::user())
                            <a href="/login" class="connexion">Se connecter</a>
                            <a href="/register" class="inscription">inscription</a>
                        @endif
                    </small>
                </div>
            </div>
        </div>
        <section class="noPaddingBottom">
            <div class="container">
                <div class="row">
                    <div class="cinq"></div>
                    <div class="deux txtCenter">
                        <a href="/">
                            <img class="gameAvatar" src="/images/avatar2.jpg" alt="AVATAR" >
                        </a>
                    </div>
                    <div class="cinq"></div>
                </div>
                <div class="row txtCenter">
                    <div class="trois"></div>
                    <div class="six">
                        <h3>Ligne Maginot</h3>
                        <hr class="divider alignCenter">
                    </div>
                    <div class="trois"></div>
                </div>
            </div>
        </section>


        @yield("content")


        
        <script src="/js/login.js"></script>
        <script type="text/javascript">
            @if (Session::has('accountcreated'))
                @if (Session::get('accountcreated')=="accountcreated") 
                    swal({   
                            title: "Votre compte a bien été créé !",   
                            text: "Merci pour votre inscription. Nous vous souhaitons un bon jeu !", 
                            type: "success",   
                            confirmButtonColor: "#3f927e",   
                            confirmButtonText: "Ok"
                        });
                @endif
            @endif
        </script>
        

    </body>
</html>