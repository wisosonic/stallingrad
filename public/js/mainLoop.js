toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

//draw stuff
mainLoopRender = function() {
  context.beginPath();
  context.clearRect(0,0,canvas.width,canvas.height);
  for(var i =0, j = enemies.length; i < j; i ++ ) {
    enemies[i].draw();
  }
  for(var i = 0, j = towers.length; i < j; i++ ) {
    towers[i].draw();
  }
  for(var i = 0, j = bullets.length; i < j; i++) {
    bullets[i].draw();
  }
  drawMouse(); //potential gun radius
  requestAnimationFrame(mainLoopRender);
};

//game logic (seperate from draw stuff)
mainLoopLogic = function() {
  checkLost();
  activateTowers();
  checkForDead();
  addEnemyTimer--;
  if(addEnemyTimer<1) {
    addEnemy();
    addEnemyTimer = (stopped > 40) ? 20 : 30;  //how quicklly a new enemy is generated
  }
  for(var i =0, j = enemies.length; i < j; i ++ ) {
    //true if attacker scored
    if(enemies[i].move()){
      attackerPoints++;
      //add point outside of canvas
      document.getElementById('attackersScore').innerHTML = attackerPoints; 
      enemies.splice(i,1);
      i--;
      j--;
    }
  }
  for(var i = 0, j = towers.length; i < j; i++ ) {
    towers[i].findTarget();
    towers[i].findUnitVector();
    towers[i].fire();
  }
  //move bullets, check for hits, remove bullets if hit
  for(var i = 0, j = bullets.length; i < j; i++) {
    bullets[i].move();
    if(bullets[i].checkCollision()) {
     bullets.splice(i,1);
     j--;
     i--;
    }
  }
  //mainTimer = setTimeout(mainLoopLogic, 1000/FPS);
};

gameTimer = function() {
    timer++;
    hours = parseInt(timer/3600);
    minutes = parseInt( (timer - parseInt(hours*3600))/60);
    seconds = timer - parseInt(hours*3600) - parseInt(minutes*60);
    hours = ("0" + hours).slice(-2);
    minutes = ("0" + minutes).slice(-2);
    seconds = ("0" + seconds).slice(-2);
    document.getElementById("timer").innerHTML = hours + ":"+minutes+":"+seconds;
}

pause = function(force) {
    if (paused == 0 || force) {
        clearInterval(mainTimer);
        clearInterval(gTimer);
        paused = 1;
        document.getElementById("pause_icon").style.display = "block";
        document.getElementById("pause").innerHTML = '<i class="fas fa-play"></i> Continuer';
    } else {
        mainTimer = setInterval(mainLoopLogic, 1000/FPS);
        gTimer = setInterval(gameTimer, 1000);
        paused = 0;
        document.getElementById("pause_icon").style.display = "none";
        document.getElementById("pause").innerHTML = '<i class="fas fa-pause"></i> Suspendre';
    }
}

savegame = function (user_id) {
    pause(true);
    swal({
        title: 'Sauvegarder ?',
        text: "Êtes-vous sur ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui!',
        cancelButtonText: 'Non!',
        closeOnConfirm: false,
        }).then((result) => {
            if (result.value) {
                var enemiesProto = [];
                var towersProto = [];
                for (var i=0; i<enemies.length; i++) {
                    enemiesProto.push([
                        enemies[i].color,
                        enemies[i].speed,
                        enemies[i].maxLife
                    ]);
                }
                for (var i=0; i<towers.length; i++) {
                    towersProto.push([
                        towers[i].r,
                        towers[i].rateOfFire,
                        towers[i].range,
                        towers[i].hurt,
                        towers[i].color,
                        towers[i].cost
                    ]);
                }
                if (game_id == 0) {
                    update = "false";
                    $.ajax({
                        type: "POST",
                        url: "/save-game",
                        data: {
                                _token : token,
                                data : {
                                        game_id:game_id,
                                        update:update,
                                        user_id:user_id,
                                        enemies:JSON.stringify(enemies),
                                        enemiesProto:JSON.stringify(enemiesProto),
                                        towers:JSON.stringify(towers),
                                        towersProto:JSON.stringify(towersProto),
                                        attackerPoints:attackerPoints,
                                        addEnemyTimer:addEnemyTimer,
                                        addedLife:addedLife,
                                        stopped:stopped,
                                        money:money,
                                        timer:timer,
                                        map_id:mapid
                                        }
                            },
                        success: function(gamesession_id){
                            game_id = gamesession_id ;
                            toastr["success"]("Votre session a bien été sauvegardée !", "");	
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    swal({
                        title: 'Mettre à jour ?',
                        text: "Voulez-vous mettre à jour la session actuelle ?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui!',
                        cancelButtonText: 'Non! Créer une nouvelle session',
                        closeOnConfirm: false,
                        }).then((result2) => {
                            if (result2.value) {
                                update = "true";
                                $.ajax({
                                    type: "POST",
                                    url: "/save-game",
                                    data: {
                                            _token : token,
                                            data : {
                                                    game_id:game_id,
                                                    update:update,
                                                    user_id:user_id,
                                                    enemies:JSON.stringify(enemies), 
                                                    enemiesProto:JSON.stringify(enemiesProto),
                                                    towers:JSON.stringify(towers),
                                                    towersProto:JSON.stringify(towersProto),
                                                    attackerPoints:attackerPoints,
                                                    addEnemyTimer:addEnemyTimer,
                                                    addedLife:addedLife,
                                                    stopped:stopped,
                                                    money:money,
                                                    timer:timer,
                                                    map_id:mapid
                                                    }
                                        },
                                    success: function(gamesession_id){
                                        game_id = gamesession_id ;
                                        toastr["success"]("Votre session a bien été sauvegardée !", "");	
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(xhr.responseText);
                                    }
                                });
                            } else {
                                update = "false";
                                $.ajax({
                                    type: "POST",
                                    url: "/save-game",
                                    data: {
                                            _token : token,
                                            data : {
                                                    game_id:game_id,
                                                    update:update,
                                                    user_id:user_id,
                                                    enemies:JSON.stringify(enemies),
                                                    enemiesProto:JSON.stringify(enemiesProto),
                                                    towers:JSON.stringify(towers),
                                                    towersProto:JSON.stringify(towersProto),
                                                    attackerPoints:attackerPoints,
                                                    addEnemyTimer:addEnemyTimer,
                                                    addedLife:addedLife,
                                                    stopped:stopped,
                                                    money:money,
                                                    timer:timer,
                                                    map_id:mapid
                                                    }
                                        },
                                    success: function(gamesession_id){
                                        game_id = gamesession_id ;
                                        toastr["success"]("Votre session a bien été sauvegardée !", "");	
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(xhr.responseText);
                                    }
                                });
                            }
                        });
                    
                }
                
            }
            
        });
}


buildEnemies = function(json1, json2) {
    for(var i=0; i<json1.length;i++) {
        var temp = new Enemy(json1[i].x, json1[i].y, json1[i].life);
        temp.color = json2[i][0];
        temp.speed = json2[i][1];
        temp.maxLife = json2[i][2];
        enemies.push(temp);
    }
}
buildTowers = function(json1, json2) {
    for(var i=0; i<json1.length;i++) {
        var temp = new Tower(json1[i].x, json1[i].y);
        temp.r = json2[i][0];
        temp.rateOfFire = json2[i][1];
        temp.range = json2[i][2];
        temp.hurt = json2[i][3];
        temp.color = json2[i][4];
        temp.cost = json2[i][5];
        towers.push(temp);
    }
}



