//change tower type
function changeTower(n) {
    document.getElementById('tower'+(n)).style.border = "3px dashed orange";
    document.getElementById('tower'+(currentTower)).style.border = "1px solid";
    currentTower = n;
}

//add tower
canvas.addEventListener('mousedown', function() {
  if(towerAllowed(mouse.x,mouse.y)) {
    towers.push(new towerClasses[currentTower](mouse.x,mouse.y));
    money -= towerClasses[currentTower].prototype.cost;
    document.getElementById('money').innerHTML = money + " €"; //update money when adding tower
  } else {
      if (towerExists(mouse.x, mouse.y, true)) {
          document.getElementById("remove").style.display = "block";
      }
  }// end if
}, false);

function getMousePos(evt) {
  var rect = canvas.getBoundingClientRect();
  mouse = {
    x: evt.clientX - rect.left,
    y: evt.clientY - rect.top
  };
  if (towerExists(mouse.x, mouse.y)) {
      canvas.style.cursor="pointer";
  } else {
      canvas.style.cursor="cell";
  }
} 

window.addEventListener('mousemove', getMousePos, false); 

//draws transperent radius around mouse to show potential tower range
function drawMouse() {
  //needed otherwise if mouse not on canvas returns error when first loading
    if(!mouse) return;
    if (!towerExists(mouse.x, mouse.y)) {
        var range = towerClasses[currentTower].prototype.range;
        var r = towerClasses[currentTower].prototype.r;
        context.beginPath();
        //transperency
        context.globalAlpha = 0.2;
        context.arc(mouse.x,mouse.y,range, 0, 2*Math.PI);
        if(towerAllowed(mouse.x,mouse.y)) context.fillStyle='yellow';
        else context.fillStyle = 'red';
        context.fill();
        context.globalAlpha = 1;
        context.beginPath();
        context.arc(mouse.x,mouse.y,r, 0, 2*Math.PI);
        context.fillStyle = towerClasses[currentTower].prototype.color;
        context.fill();
    }
}

function towerExists(x,y,clicked=false) {
    for (var i = 0, j = towers.length; i < j; i++) {
      if(Math.abs(x-towers[i].x) < 2*rectWidth && Math.abs(towers[i].y-y) < 2*rectWidth) { 
          if (clicked) {
            selectedTower = i;
          }
          return true;
      };   
    }
    return false;
}
//see if tower can be built here:
//starts at top of page
function towerAllowed(x,y) {
  if (money < towerClasses[currentTower].prototype.cost) return false; //can afford tower?
  if( y < rectWidth) return false;
  else if (y < firstBorder+rectWidth*2 && x > rightBorder- rectWidth  ) return false;
  else if (y > firstBorder - rectWidth && y < firstBorder + rectWidth *2 && x > leftBorder - rectWidth) return false;
  else if (y > firstBorder + rectWidth*3 && y < secondBorder + rectWidth && x > leftBorder - rectWidth && x < leftBorder + rectWidth*2) return false;
  else if (y > secondBorder - rectWidth && y < secondBorder + rectWidth * 2 && x > leftBorder + rectWidth *2) return false;
  else if (y > secondBorder && y < thirdBorder + rectWidth*2 && x > rightBorder - rectWidth) return false;
  else if (y > thirdBorder - rectWidth && y < thirdBorder + rectWidth*2) return false;
  else if (towerExists(x,y)) {
    return false;
  }
  return true;
}
