@extends('general')

@section('content')

    <style type="text/css">
        #connexion {
            padding-top: 10px !important;
            background: none;
            color: #5f5d5d !important;
        }
        .boutonLight {
            color:blue;
        }
    </style>

    <section class="bgGris entete" id="connexion">
        <div class="container">
            <div class="row">
                <div class="trois"></div>
                <div class="six txtCenter">
                    <h1>Connexion</h1>
                </div>
                <div class="trois"></div>
            </div>
            <div class="row">
                <div class="trois"></div>
                <div class="six">
                    <form id="login_form" action="/login" method="POST">
                        {{ csrf_field() }}
                        <input style="width: 100%;border: 2px solid #ebebeb;" type="text" onchange="changeBorderColor('email');" id="email" name="email" placeholder="Adresse mail" size="10" class="" >
                        <input style="width: 100%;border: 2px solid #ebebeb;" type="password" onchange="changeBorderColor('password');" id="password" name="password" placeholder="Mot de passe" size="10" class="" >

                        <div class="row">
                            <div class="huit">
                                <a href="/register" class="boutonVert ">Je crée mon compte</a>
                            </div>
                            <div id="sendButton" class="quatre txtRight"><a href="#" onclick="sendlogin(); return false;" class="boutonVert">Connexion</a>
                            </div>
                        </div>  
                        
                        <div class="row">
                        <input type="checkbox" id="loginkeeping" name="remember" value="checked"><label for="loginkeeping"> Rester connecté</label>
                        </div>
                        <hr>

                        @if ($error = $errors->first('email'))
                            <p id="attention" class="attention"><i class="fas fa-times" aria-hidden="true"></i> {{$error = $errors->first('email')}}</p>
                        @endif
                    </form>
                </div>
                <div class="trois"></div>
            </div>
        </div>
    </section>

    
    <script type="text/javascript">
        $(document).keypress(function(e) {
          if(e.which == 13) {
            sendlogin();
          } 
        });
    </script>
@endsection
