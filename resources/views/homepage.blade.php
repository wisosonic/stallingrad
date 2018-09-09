@extends("general")

@section("content")

    <section >
        <div class="container txtCenter">
	        <div class="row">
	        	<div class="trois"></div>
	        	<div class="six">
					<a href="/get-maps" class="bouton"> Commencer !</a>
					@if (Auth::user())
						<br>
			        	<a href="/saved-games" class="bouton"> Mes sessions sauvegardés</a>
		        	@endif
		        	<br>
		        	<a href="/download-report" class="bouton" target="_blank"> Rapport du projet</a>
		        </div>
	        	<div class="trois"></div>
	        </div>
        </div>
    </section>

@endsection