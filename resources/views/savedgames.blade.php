@extends("general")

@section("content")

    <section >
        <div class="container">
        	<div class="row">
				<div class="deux"></div>
				<div class="huit">
					<h2>Mes sessions sauvegardées</h2>
					<table id="savedgames">
						<col width="10%">
						<tr>
							<th>Carte</th>
							<th>Date</th>
							<th>Temps de jeu</th>
							<th>Chars neutralisés</th>
							<th>Chars passés</th>
							<th>Cash</th>
							<th></th>
							<th></th>
						</tr>

						@if (count($savedgames)>0)
							@foreach ($savedgames as $key => $game)
								<tr>
									<td>
										<img src="{{$game->map()->first()->background}}" alt="">
									</td>
									<td>{{$game->updated_at}}</td>
									<td>{{$game->timer}}</td>
									<td>{{$game->stopped}}</td>
									<td>{{$game->attackerPoints}}</td>
									<td>{{$game->money}} €</td>
									<td class="txtCenter">
										<a href="/continue-game/{{$game->id}}">
											<i class="fas fa-play-circle"></i> Continuer
										</a>
									</td>
									<td class="txtCenter">
										<button onclick="deleteGame('{{$game->id}}'); return false;">
											<i class="fas fa-trash-alt"></i>
										</button>
									</td>
								</tr>
							@endforeach
						@else
							<td class="txtCenter" colspan=8>Vous n'avez aucune session sauvegardée</td>
						@endif
						
					</table>
				</div>
				<div class="deux"></div>
			</div>
        </div>
    </section>

    <script type="text/javascript">

    	@if (Session::has("message"))
    		toastr["success"]("Votre session a bien été supprimér !", "");
    	@endif

    	deleteGame = function(game_id) {
		    swal({
		        title: 'Supprimer la session ?',
		        text: "Êtes-vous sur ?",
		        type: 'warning',
		        showCancelButton: true,
		        confirmButtonColor: '#3085d6',
		        cancelButtonColor: '#d33',
		        confirmButtonText: 'Oui!',
		        cancelButtonText: 'Annuler!',
		        closeOnConfirm: false,
		        }).then((result) => {
		            if (result.value) {
		                window.location.href = "/delete-game/"+game_id;
		            }
		        });
		}
    </script>


@endsection