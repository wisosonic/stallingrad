
function Bullet(x,y,target,hurt, color) {
  this.x = x,
  this.y = y,
  this.target = target,
  this.hurt = hurt,
  this.color = color
};

Bullet.prototype.r = rectWidth/4;
Bullet.prototype.speed = baseSpeed*3;

Bullet.prototype.move = function() {
  //find unit vector
  var xDist = this.target.x+rectWidth/2-this.x; //"+rectWidth/2" because we want bullet to go for center of enemy no top left corner
  var yDist = this.target.y+rectWidth/2-this.y;
  var dist = Math.sqrt(xDist*xDist+yDist*yDist);
  this.x = this.x+this.speed*xDist/dist;
  this.y = this.y+this.speed*yDist/dist;
};

Bullet.prototype.draw = function() {
  context.beginPath();
  context.arc(this.x,this.y,this.r,0,2*Math.PI);
  context.fillStyle=this.color;
  context.fill();
};
 
Bullet.prototype.checkCollision = function() {
  if(this.x < this.target.x + rectWidth &&
     this.x + this.r > this.target.x &&
     this.y < this.target.y + rectWidth &&
     this.y + this.r > this.target.y) {
       this.target.life -= this.hurt;
       if (this.color == "yellow") {
           
               console.log(this.target.speed);
            this.target.speed = this.target.speed /1.33 ;
           
       }
       return true;
  }
  return false;
};
