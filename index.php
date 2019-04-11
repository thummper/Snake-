<!DOCTYPE html>
<html>

<head>
    <?php include("../../../webAnalytics.php"); ?>
    <meta charset="utf-8" />
    <title> Snake Game </title>
    <meta name="description" content="A simple JS snake game." />
	<link href="https://fonts.googleapis.com/css?family=Delius+Swash+Caps" rel="stylesheet"> 
    <meta name="author" content="Aron" />
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: "Arial";
        }
		html, body {
			height: 100%;
		}
		
		.wrapper{
			width: 100%;
			height: 100%;
			display: flex;

		}
		.controls{
			flex-basis: 300px;
			background: #f2f2f2;
		}
		.canvas-wrapper{
			flex: 1;
			background: white;
			display: flex;
			justify-content: center;
			position: relative;
		}
		.menu {
			position: absolute;
			width: 90%;
			height: 90%;
			align-self: center;
			display: none;
			background: transparent;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}
		.menu-bg{
			position: absolute;
			width: 100%;
			height: 100%;
			background: #d5dfdf;
			z-index: -1;
			opacity: 0.5;
			filter: blur(2px);
		}
		.main{
			z-index: 10;
			display: flex;
		}
		#scanvas{
			background: white;
			border: 2px solid grey;
			border-radius: 4px;
			width: 90%;
			height: 90%;
			align-self: center;	
		}
		.main-button{
			background: #008080;
			transition: all 0.2s;
			color: white;
			text-align: center;
			padding: 12px 0;
			margin: 12px 0;
			border-radius: 4px;
			cursor: pointer;
			user-select: none;
			-moz-user-select: -moz-none;
		}
		.main-button:hover{
			background: #004d4d;
		}

		.title{
			position: absolute;
			display: flex;
			align-items: center;
			justify-content: center;
			width: 400px;
			height: 200px;
			top: 50px;
			left: 0;
			right: 0;
			bottom: 0;
			margin: 0 auto;
			font-size: 100px;
			font-family: "Delius Swash Caps";
		}
		.over .title{
			width: 100%;
		}
		.difficulty{
			text-align: center;
		}


		input[type=range] {
  -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
  width: 100%; /* Specific width is required for Firefox. */
  background: transparent; /* Otherwise white in Chrome */
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
}

input[type=range]:focus {
  outline: none; /* Removes the blue border. You should probably do some kind of focus styling for accessibility reasons though. */
}

input[type=range]::-ms-track {
  width: 100%;
  cursor: pointer;

  /* Hides the slider so custom styles can be added */
  background: transparent; 
  border-color: transparent;
  color: transparent;
}


input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  border: 1px solid #004d4d;
  height: 12px;
  width: 16px;
  border-radius: 3px;
  background: #008080;
  cursor: pointer;
  margin-top: -14px; /* You need to specify a margin in Chrome, but in Firefox and IE it is automatic */
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d; /* Add cool effects to your sliders! */
}

/* All the same stuff for Firefox */
input[type=range]::-moz-range-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #004d4d;
  height: 12px;
  width: 16px;
  border-radius: 3px;
  background: #008080;
  cursor: pointer;
}

/* All the same stuff for IE */
input[type=range]::-ms-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #004d4d;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #008080;
  cursor: pointer;
}


input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  background: #FFFFFF;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}

input[type=range]:focus::-webkit-slider-runnable-track {
  background: #FFFFFF;
}

input[type=range]::-moz-range-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;

  background: #FFFFFF;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}

input[type=range]::-ms-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  background: transparent;
  border-color: transparent;
  border-width: 16px 0;
  color: transparent;
}
input[type=range]::-ms-fill-lower {
  background: #2a6495;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
 
}
input[type=range]:focus::-ms-fill-lower {
  background: #FFFFFF;
}
input[type=range]::-ms-fill-upper {
  background: #FFFFFF;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
 
}
input[type=range]:focus::-ms-fill-upper {
  background: #FFFFFF;
}
.score-holder{
	position: absolute;
	align-self: center;
	height: 90%;
}



    </style>
	<script src="main.js"></script>
    <script src="food.js"></script>
</head>

<body>
    <div class="wrapper">
		<div class="controls">
		WASD / Arrows for movement. 
		<br>
		P to pause / resume.
		<br>
		R to reset game.
		
		
		</div>
		<div class="canvas-wrapper">
			<div class="score-holder">Score: 0</div>
			<div class="menu main">
				<div class="menu-bg"></div>
				<div class="title"> Snake </div>
				<div class="main-controls">
					<div class="difficulty">Medium</div>
					<input class="diff-slider" type="range" min="0" max="100" value="50" />
					<div class="main-button start"> Start </div>
				</div>
			</div>
			<div class="menu paused">
				<div class="menu-bg"></div>
				<div class="title"> Paused </div>
			
			</div>
			<div class="menu over">
			<div class="menu-bg"></div>	
			<div class="title"> Game Over </div>
			<div class="main-button reset"> Restart </div>
			</div>
			<canvas id="scanvas"></canvas>
		</div>
	</div>
</body>
</html>
