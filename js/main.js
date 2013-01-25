var player, environment, layer, stage, ship;

$(document).ready(function(){
	
	canvas = $('#canvas');
		
	$.get("json/data.json", function(data){
		
		initialize(data);
    setData(data);
    
  }).error(function() { console.log('Server Error') });
  
  stage = new Kinetic.Stage({
  	container: 'canvas',
    width: 800,
    height: 600
  });
  
  layer = new Kinetic.Layer();

  var imageObj = new Image();
  imageObj.onload = function() {
  	ship = new Kinetic.Image({
    	x: stage.getWidth() / 2 - 32,
      y: stage.getHeight() / 2 - 32,
      image: imageObj,
      width: 64,
      height: 64
    });
    // add the shape to the layer
    layer.add(ship);
    // add the layer to the stage
    stage.add(layer);
    
        // one revolution per 4 seconds
        var angularSpeed = Math.PI / 2;
        var anim = new Kinetic.Animation(function(frame) {
          var angleDiff = frame.timeDiff * angularSpeed / 1000;
          ship.rotate(angleDiff);
          
        }, layer);

        anim.start();
    
   };
   imageObj.src = 'images/ship.png';
	
	
    
	
	canvas.mousemove(function(e){
		 parentOffset = $(this).offset(); 
	   cursor.x = e.pageX - parentOffset.left;
	   cursor.y = e.pageY - parentOffset.top;
	   //console.log(cursor.x + ' ' + cursor.y);
	   
	});
	
	
	
});
	
function calculateAngle(){
slope = (cursor.y - player.y) / (cursor.x - player.x);

theta = Math.atan(slope)*180/Math.PI;
if(player.x < cursor.x){
  theta += 180;
}
};

function calculateHorizontal(){
player.accnetx = (player.acce - player.accw);
	player.velx += player.accnetx;
	player.x += player.velx;

	if (player.accw > 0) player.accw--;
	if (player.acce > 0) player.acce--;
	if (player.velx != 0){
	if (player.velx > 0){ 
 		if (player.velx > player.velmax){
   		player.velx = player.velmax;
 		}
 		player.velx -= friction;
 		if (player.velx < 0) player.velx = 0;
 	}
 	if (player.velx < 0){
 		if (player.velx < -player.velmax){
   		player.velx = -player.velmax;
 		}
 		player.velx += friction;
 		if (player.velx > 0) player.velx = 0;
 	}
		}
}

function calculateVertical(){
player.accnety = (player.accs - player.accn);
	player.vely += player.accnety;
	player.y += player.vely;

	if (player.accn > 0) player.accn--;
	if (player.accs > 0) player.accs--;
	if (player.vely != 0){
	if (player.vely > 0){ 
 		if (player.vely > player.velmax){
 			player.vely = player.velmax;
 		}
 		player.vely -= friction;
 		if (player.vely < 0) player.vely = 0;
 	}
 	if (player.vely < 0){
 		if (player.vely < -player.velmax){
   		player.vely = -player.velmax;
 		}
 		player.vely += friction;
 		if (player.vely > 0) player.vely = 0;
 	}
	}
}

function movePlayer(){
calculateHorizontal();
calculateVertical();

pc.css({
	'top' : player.y + 'px',
	'left' : player.x + 'px',
})
};

function spinPlayer(){
 pc.css({
 	'-webkit-transform': 'rotate(' + theta + 'deg)',
 	'-moz-transform': 'rotate(' + theta + 'deg)',
  '-ms-transform': 'rotate(' + theta + 'deg)',
  '-o-transform': 'rotate(' + theta + 'deg)',
  'transform': 'rotate(' + theta + 'deg)',
 });
};

function updatePlayer(){
calculateAngle();
movePlayer();
spinPlayer();
}

function debug(){
debugPlayerXPos.html(player.x);
debugPlayerXVel.html(player.velx);
debugPlayerXAccE.html(player.acce);
debugPlayerXAccW.html(player.accw);
debugPlayerXAcc.html(player.accnetx);

debugPlayerYPos.html(player.y);
debugPlayerYVel.html(player.vely);
debugPlayerYAccN.html(player.accn);
debugPlayerYAccS.html(player.accs);
debugPlayerYAcc.html(player.accnety);

debugCursorXPos.html(cursor.x);
debugCursorYPos.html(cursor.y);
debugSlope.html(slope);
debugTheta.html(theta);
}

function setData(data){
player = data.player;
environment = data.environment;
};

function initialize(data){
								
cursor = $('#cursor');
cursor.x = 0;
cursor.y = 0;

debugCursorXPos = $('#cursorxpos');
debugCursorYPos = $('#cursorypos');

debugSlope = $('#slope');
debugTheta = $('#theta');

debugPlayerXPos = $('#playerxpos');
debugPlayerXVel = $('#playerxvel');
debugPlayerXAccE = $('#playerxacce');
debugPlayerXAccW = $('#playerxaccw');
debugPlayerXAcc = $('#playerxacc');

debugPlayerYPos = $('#playerypos');
debugPlayerYVel = $('#playeryvel');
debugPlayerYAccN = $('#playeryaccn');
debugPlayerYAccS = $('#playeryaccs');
debugPlayerYAcc = $('#playeryacc');

/*setInterval(function(){    
 updatePlayer();
 debug();
},data.environment.deltaT)*/
};

$(document).keydown(function(e) {

	if (e.keyCode == 38 || e.keyCode == 87){
		//up
 	player.accn += player.accbase;
 	e.preventDefault();
	}
	if (e.keyCode == 40 || e.keyCode == 83){
		//down
		player.accs += player.accbase;
		
 	e.preventDefault();
	}
	if (e.keyCode == 37 || e.keyCode == 65){
		//left
 	player.accw += player.accbase;
 	e.preventDefault();
	}
	
	if (e.keyCode == 39 || e.keyCode == 68){
		//right
	player.acce += player.accbase;
 	e.preventDefault();
	}

});
   
    

	