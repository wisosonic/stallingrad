@extends("general")

@section("content")

    <style type="text/css">
        .canvas {
            background:url("{{$map->background}}");
        }
    </style>

    <section class="noPaddingTop">
        <div class="container">
            <div class="row">
                <div class="deux NoMarginRight">
                    <button id="pause" onclick="pause(); return false;"><i class="fas fa-pause"></i> Suspendre</button>
                    <button id="restart" onclick="restart(); return false;"><i class="fas fa-sync-alt"></i> Recommencer</button>
                    @if (Auth::user())
                        <button id="savegame" onclick="savegame('{{Auth::user()->id}}'); return false;"><i class="fas fa-save"></i> Sauvegarder</button>
                    @else
                        <p>
                            <i>Vous nes pouvez pas sauvegarder votre session si vous n'êtes pas 
                            connecté avec votre compte</i>
                        </p>
                    @endif
                    <div id="remove" style="display: none" class="row">
                        <hr>
                        <button onclick="removeTower(); return false;"><i class="fas fa-euro-sign"></i> Vendre</button>
                        <button onclick="cancelRemoveTower(); return false;">Anuuler</button>
                    </div>
                </div>
                <div class="quatre">
                    <div class="row boiteVerte">
                        <h2>Statistiques:</h2>
                        Chars passés: <span id="attackersScore">0</span>
                        <span class="right">Cash: <span id="money">250 €</span></span>
                        <br>
                        Chars neutralisés: <span id="stopped">0</span>
                        <span class="right">Niveau * : <span id="level">0</span></span>
                        <br><br>
                        Temps de jeu: <span id="timer">00:00:00</span>
                    </div>
                    <div class="row">
                        <p>
                            Le <i>Niveau</i> correspond aux points de vie supplémentaires aquis
                        </p>
                        <p>
                            Nombre de chars allemands autorisés : 10
                        </p>
                    </div>
                    <div class="row">
                        <h2>Canons:</h2>
                        <div id="tower0" class="tower quatre bgOrange" onclick="changeTower(0);">
                            Patriot
                            <hr>
                            Range: ++
                            <br>
                            Damage: +
                            <br>
                            Rate: +
                            <br>
                            Cost: 50 €
                        </div>
                        <div id="tower1" class="tower quatre bgBrown" style="display:none" onclick="changeTower(1);">
                            Tomahawk
                            <hr>
                            Range: +++
                            <br>
                            Damage: +
                            <br>
                            Rate: +++
                            <br>
                            Cost: 75 €
                        </div>
                        <div id="tower2" class="tower quatre bgAqua" style=" display:none;" onclick="changeTower(2);">
                            Scud
                            <hr>
                            Range: +
                            <br>
                            Damage: +++
                            <br>
                            Rate: ++
                            <br>
                            Cost: 100 €
                        </div>
                    </div>
                    <div class="row">
                        <div id="tower4" class="tower quatre bgYellow" style="display:none;" onclick="changeTower(4);">
                            EMP
                            <hr>
                            Range: +
                            <br>
                            Damage: -
                            <br>
                            Rate: +
                            <br>
                            Cost: 150 €
                        </div> 
                        <div id="tower3" class="tower quatre bgBlue" style="display:none" onclick="changeTower(3);">
                            Nucléaire
                            <hr>
                            Range: ++
                            <br>
                            Damage: +++++
                            <br>
                            Rate: +
                            <br>
                            Cost: 250 €
                        </div>
                        <div class="quatre"></div>
                    </div>
                </div>
                <div class="six">
                    <h3>{{$map->name}}</h3>
                    <img id="pause_icon" style="display:none;" width="{{$map->width}}" height="{{$map->height}}" src="/images/pause.png" alt="" />
                    <canvas id="canvas" class="canvas" width="{{$map->width}}" height="{{$map->height}}"></canvas> 
                </div>
                
            </div>
        </div>
    </section>
    
    

    <script type="text/javascript">
        var token = "{{ csrf_token() }}" ;
        var game_id = 0;

        var enemies = [];
        var towers=[];
        var bullets = [];

        var mainTimer;
        var gTimer;
        var canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        rectWidth = 20, //basic game unit size (pixles)
        maxWidth = canvas.width, //add maxHight if not perfect square
        FPS = 30,
        baseSpeed = 4*rectWidth/FPS,
        mouse, //mouse x and y for drawing range
        currentTower = 0, //tower type selector.
        //borders for attacker's path
        leftBorder = {{$map->structure["vBorders"][0]}},
        rightBorder = {{$map->structure["vBorders"][1]}},
        //vertical borders:
        firstBorder = {{$map->structure["hBorders"][0]}},
        secondBorder = {{$map->structure["hBorders"][1]}},
        thirdBorder = {{$map->structure["hBorders"][2]}},
        //points/statistics
        attackerPoints = 0,
        stopped = 0,
        addedLife = 0, //incremented in checkForDead()
        //counter for when to add enemy units
        addEnemyTimer = 20,
        money = 250,
        moneyIncrement = 10;
        paused = 0;
        var selectedTower;
        timer = 0;
        mapid = "{{$map->id}}";
        document.getElementById("tower0").style.border = "3px dashed orange";

        restart = function() {
            swal({
                title: 'Recommencer ?',
                text: "Êtes-vous sur  ?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui!',
                cancelButtonText: 'Non!',
                }).then((result) => {
                    if (result.value) {
                        context.beginPath();
                        context.clearRect(0,0,canvas.width,canvas.height);
                        clearInterval(mainTimer);
                        clearInterval(gTimer);
                        paused = 0;
                        timer=0;
                        money=250;
                        attackerPoints=0;
                        stopped=0;
                        addedLife=0;
                        enemies = [];
                        towers=[];
                        bullets = [];
                        currentTower = 0;
                        document.getElementById('money').innerHTML = money + " €";
                        document.getElementById('level').innerHTML = addedLife;
                        document.getElementById('stopped').innerHTML = stopped;
                        document.getElementById('attackersScore').innerHTML = attackerPoints; 
                        document.getElementById("timer").innerHTML = "00:00:00";
                        document.getElementById("remove").style.display = "none";
                        document.getElementById("pause_icon").style.display = "none";
                        swal({
                          title: '',
                          text: 'Votre session va commencer dans 3 secondes !',
                          timer: 3000,
                          allowOutsideClick: false,
                          allowEscapeKey: false ,
                          onOpen: () => {
                            swal.showLoading()
                          }
                        }).then((result) => {
                            if (result.dismiss === swal.DismissReason.timer) {
                                mainTimer = setInterval(mainLoopLogic, 1000/FPS);
                                gTimer = setInterval(gameTimer, 1000);
                                activateTowers();
                                mainLoopRender();
                            }
                        })
                    }
                });
        }
        window.onload = function() {
            swal({
              title: '',
              text: 'Votre session va commencer dans 3 secondes !',
              timer: 3000,
              allowOutsideClick: false,
              allowEscapeKey: false ,
              onOpen: () => {
                swal.showLoading()
              }
            }).then((result) => {
                if (result.dismiss === swal.DismissReason.timer) {
                    mainTimer = setInterval(mainLoopLogic, 1000/FPS);
                    gTimer = setInterval(gameTimer, 1000);
                    activateTowers();
                    mainLoopRender();
                }
            })
            
        };
    </script>
    <script type="text/javascript" src="/js/mainLoop.js"></script>
    <script type="text/javascript" src="/js/attackerUnits.js"></script>
    <script type="text/javascript" src="/js/towerUnits.js"></script>
    <script type="text/javascript" src="/js/bullets.js"></script>
    <script type="text/javascript" src="/js/mouseClick.js"></script>
    
@endsection