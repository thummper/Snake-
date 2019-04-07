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
			background: gray;
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
 

    </style>
	<script src="main.js"></script>
    <script src="food.js"></script>
</head>

<body>
    <div class="wrapper">
		<div class="controls"></div>
		<div class="canvas-wrapper">
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
