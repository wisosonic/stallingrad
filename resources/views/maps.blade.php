@extends("general")

@section("content")

    <section >
        <div class="container">
        	<div class="row">
        		@foreach ($maps as $key => $map)
		        	<div class="six txtCenter">
		        		<h2>{{$map->name}}</h2>
		        		<a href="/start-map/{{$map->id}}" class="bouton"> 
		        			<img class="savedGamesMap" src="{{$map->background}}">
		        		</a>
		        		<br>
		        		<a href="/start-map/{{$map->id}}" class="bouton"> Choisir</a>
		        	</div>
		        @endforeach
        	</div>
        </div>
    </section>

@endsection