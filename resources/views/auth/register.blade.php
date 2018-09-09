@extends('general')


@section('content')

    <style type="text/css">
        input[type=password] {
            background-color: #FFF;
            border: 1px solid lightgrey;
            width: 100%;
            padding: 15px;
            margin: 7px 0;
            font-size: 1em;
            font-weight: 100;
            color: #3f927e;
            display: block;
        }
    </style>

    <section style="padding-top: 20px !important" class="entete" id="informations">
        <div class="container">
            <div class="row">
                <h1>Inscriptions</h1>
            </div>
            
            <form id="register_form"  action="" autocomplete="off" method="POST"> 
                {{ csrf_field() }}
                <div class="row">
                    <div class="cinq">
                        <h3>
                            <i class="fas fa-envelope txtPrimaryColor" aria-hidden="true"></i>
                            Adresse mail
                        </h3>
                        <hr>
                        <input type="text" id="email" name="email" placeholder="Votre e-mail *" size="10" class="" value="" autocomplete="new-email">
                        <input type="text" id="email_confirmation" name="email_confirmation" placeholder="Confirmez le mail *" size="10" class="" value="">
                        <p id="availability"></p>

                    </div>
                    <div class="un"></div>
                    <div class="six">
                        <h3>
                            <i class="fas fa-lock txtPrimaryColor" aria-hidden="true"></i>
                            Mot de passe
                        </h3>
                        <hr>
                        <input type="password" id="password" name="password" autocomplete="new-password" placeholder="Mot de passe *" size="10" class="" value="" >
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Confirmez le mot de passe *" size="10" class="" >
                    </div>
                </div>
                <hr>
                <div class="row">
                    <h3>
                        <i class="fas fa-user-circle txtPrimaryColor" aria-hidden="true"></i> 
                        Civilité
                    </h3>
                    <div class="six">
                        <input type="text" id="lname" name="lname" placeholder="Nom *" size="10" class="" >
                    </div>
                    <div class="six">
                        <input type="text" id="fname" name="fname" placeholder="Prénom *" size="10" class="" >
                    </div>
                </div>

            </form>
        
        <!-- bouton retour et continuer -->
            <div style="margin-top: 20px" class="row">
                <div class="un txtRight">
                    <a href="" class="bouton">Retour</a>
                </div>
                <div class="huit"></div>
                <div class="trois txtRight">
                    <a href="#" onclick="sendForm(); return false" class="boutonVert" >Créer mon compte</a>
                </div>

            </div>
        </div>
    </section>

    <script>
        var token = "{{ csrf_token() }}" ;
    </script>
    <script src="/js/register.js"></script>

    @if (Session('message'))
        <script>
            toastr["error"]("Your entered address is not valid !", "Invalid address !");
        </script>
        <?php
            Session::forget("message");
            ?>
    @endif

@endsection
