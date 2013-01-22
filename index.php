<!DOCTYPE html>
<html>
<head>
<title>Game Test</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<link rel="stylesheet" type="text/css" href="style/style.css" />
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		deltaT = 25;
		friction = 0.05;
		canvas = $('#canvas');
		player = $('#player');
		player.weight = 1;
		player.position = player.position();
		
		player.x = player.position.left;
		player.y = player.position.top;
		
		player.accbase = 3;
		player.accmax = 3;
		player.accn = 0;
		player.accs = 0;
		player.accnetx = 0;
		player.acce = 0;
		player.accw = 0;
		player.accnety = 0;
		
		player.velx = 0;
		player.vely = 0;
		player.velmax = 6;
		
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

			player.css({
				'top' : player.y + 'px',
				'left' : player.x + 'px',
			})
		};
		
		function spinPlayer(){
			 player.css({
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
		
		canvas.mousemove(function(e){
			 parentOffset = $(this).offset(); 
		   cursor.x = e.pageX - parentOffset.left;
		   cursor.y = e.pageY - parentOffset.top;
		});
		
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
     
     setInterval(function(){    
	     updatePlayer();
	     debug();
     },deltaT)

	})

</script>
</head>
<body>
<div id="debug">
player position:<br />
x:<br />
pos: <span id="playerxpos">400</span><br />
vel: <span id="playerxvel"></span><br />
e acc: <span id="playerxacce"></span><br />
w acc: <span id="playerxaccw"></span><br />
acc: <span id="playerxacc"></span><br />
<br />
y:<br />
pos: <span id="playerypos">300</span><br />
vel: <span id="playeryvel"></span><br />
n acc: <span id="playeryaccn"></span><br />
s acc: <span id="playeryaccs"></span><br />
acc: <span id="playeryacc"></span><br />
<br />



<br />
cursor position:<br />
cursor x pos: <span id="cursorxpos">400</span><br />
cursor y pos: <span id="cursorypos">300</span><br />
slope: <span id="slope">0</span><br />
theta: <span id="theta">0</span><br />
</div>
<div id="canvas">
<div id="cursor"></div>
<img src="images/sprites/ship.png" id="player">
</div>
</body>
</html>