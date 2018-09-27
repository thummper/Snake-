<!DOCTYPE html>
<html>

<head>
    <?php include("../../../webAnalytics.php"); ?>
    <meta charset="utf-8" />
    <title> Snake Game</title>
    <meta name="description" content="A simple JS snake game." />
    <meta name="author" content="Aron" />
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: "Arial";
        }
        
        canvas {
            background: #eee;
            display: block;
            margin: 0 auto;
            margin-top: 30px;
            margin-bottom: 50px;
            border: 2px solid black;
        }
        
        .lastEdit {
            display: block;
            text-align: center;
            padding-top: 20px;
        }
        
        .controls {
            position: absolute;
            top: 50%;
            left: 100px;
        }

    </style>
    <script src="food.js"></script>
</head>

<body>
    <div class="lastEdit">
        <?php echo "Last Modified (GMT): ".date("F d Y H:i:s.", (getlastmod() + 18000));?>
    </div>

    <div class="controls">
        Movement:
        <br> WASD OR Arrow Keys.
        <br> Press "P" to pause.
		<br> Press "R" to reset.

    </div>
    <canvas id="myCanvas" width="686" height="588"></canvas>
    <script>
		class Game{
			constructor(canvas){
				this.canvas = canvas;
				this.ctx = canvas.getContext('2d');
				//Game vars
				this.movex = 0;
				this.movey = 0;
				this.foodArray = [];
				this.gameState = 1;
				this.mousex;
				this.mousey;
				this.move = 0;
				this.resButtons = false;
				this.snake = {
					scale: 14,
					xspeed: 1,
					yspeed: 0, 
					length: 1,
					x: 350,
					y: 294
				};
				this.tail = [
					[this.snake.x, this.snake.y]
				];
				this.gameLoop;
			}
			init(){
				//Set everything up
				this.addListeners();
				this.makeFood();
				this.gameLoop = window.setInterval(this.loop.bind(this), 150);
				
			}
			addListeners(){
				document.addEventListener('keydown', function(e){
					let kc = e.keyCode;
					if(kc == 87 || kc == 38){
						//Up
						if(this.snake.yspeed != 1){
							//Not going down.
							this.snake.yspeed = -1;
							this.snake.xspeed = 0;
						}
					} else if(kc == 68 || kc == 39){
						//Right
						if(this.snake.xspeed != -1){
							this.snake.xspeed = 1;
							this.snake.yspeed = 0;
						}
						
					} else if(kc == 83 || kc == 40){
						//Down
						if(this.snake.yspeed != -1){
							this.snake.yspeed = 1;
							this.snake.xspeed = 0;
						}
					} else if(kc == 65 || kc == 37){
						//Left
						if(this.snake.xspeed != 1){
							this.snake.xspeed = -1;
							this.snake.yspeed = 0;
						}
					} else if(kc == 80){
						if(this.gameState != 0){
							this.gameState = 0;
						} else {
							this.gameState = 1;
						}
					} else if(kc == 82){
						//Reset
						this.reset();
					}
					
				}.bind(this));
				this.canvas.addEventListener('mousemove', function(e){
					console.log("Mouse X/Y: ", e.offsetX, e.offsetY);
				}.bind(this));
				this.canvas.addEventListener('click', function(e){
					console.log("Clicked at: ", e.offsetX, e.offsetY);
				}.bind(this));
			}
			
			reset(){
				//Reset game.
				this.movex = 0;
				this.movey = 0;
				this.foodArray = [];
				this.gameState = 1;
				this.mousex;
				this.mousey;
				this.move = 0;
				this.resButtons = false;
				this.snake = {
					scale: 14,
					xspeed: 1,
					yspeed: 0, 
					length: 1,
					x: 350,
					y: 294
				};
				this.tail = [
					[this.snake.x, this.snake.y]
				];
			}
			//Makes x pieces of food
			makeFood(){
				let food = new Food();
				food.pickLocation();
				this.foodArray.push(food);
			}
			loop(){
				//Game states: 0 = paused, 1 = normal, 2 = gameover
				if(this.gameState == 1){
					if(this.foodArray.length <= (this.snake.length + 1) / 2){
						this.makeFood();
					}
					//Do normal game things
					this.clearScreen();
					this.snakeEat();
					this.drawFood();
					this.drawSnake();
					this.moveSnake();
				} else if(this.gameState == 0){
					//Do paused things
				} else if(this.gameState == 2){
					//Do gameover things
				}
				

			}
			clearScreen(){
				this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
			}
			snakeEat(){
				//Handles collision for food, increases snake length and deletes old food.
				for(let i = 0, j = this.tail.length; i < j; i++){
					let block = this.tail[i];
					let x = block[0];
					let y = block[1];
					let len = this.foodArray.length - 1;
					for(let a = len; a >= 0; a--){
						let food = this.foodArray[a];
						if(food.x == x && food.y == y){
							this.snake.length++;
							this.foodArray.splice(a, 1);
						}
					}	
				}
			}
			drawFood(){	
				for(let i = 0, j = this.foodArray.length; i < j; i++){
					let food = this.foodArray[i];
					this.drawRect(food.x, food.y, 'red', this.snake.scale);
				}
			}
			drawSnake(){
				let snake = this.snake;
				let tail = this.tail;
				for(let i = 0; i < snake.length; i++){
					let x = tail[i][0];
					let y = tail[i][1];
					if(i == 0){
						this.drawRect(x, y, "black", snake.scale);
						let direction = this.snakeDir();
						if(direction == "U"){
							//Eyes facing up.
							this.drawRect(x + 3, y + 1, 'white', 2);
							this.drawRect(x + 9, y + 1, 'white', 2);
						} else if(direction == "D"){
							//Eyes facing down
							this.drawRect(x + 3, y + 10, 'white', 2);
							this.drawRect(x + 9, y + 10, 'white', 2);
						} else if(direction == "L"){
							//Eyes facing left
							this.drawRect(x + 1, y + 3, 'white', 2);
							this.drawRect(x + 1, y + 9, 'white', 2);
						} else if(direction == "R"){
							this.drawRect(x + 10, y + 3, 'white', 2);
							this.drawRect(x + 10, y + 9, 'white', 2);
						}
					} else {
						this.drawRect(x, y, 'black', snake.scale);
					}
				}	
			}
			drawRect(x, y, col, size){
				this.ctx.beginPath();
				this.ctx.fillStyle = col;
				this.ctx.rect(x, y, size, size);
				this.ctx.fill();
				this.ctx.closePath();
			}
			snakeDir(){
				let dir = null;
				if(this.snake.yspeed == -1){
					//Snake is going update
					return "U";
				}
				if(this.snake.yspeed == 1){
					//Snake is going down 
					return "D";
				}
				if(this.snake.xspeed == 1){
					//Snake is going right
					return "R";
				}
				if(this.snake.xspeed == -1){
					//Snake is going left
					return "L";
				}
			}
			moveSnake(){
				let snake = this.snake;
				if((snake.x + (snake.xspeed * snake.scale)) > this.canvas.width - 14 || (snake.x + (snake.xspeed * snake.scale ))< 0){
				   //Hit a wall.
				   console.log("Hit left or right");
				   this.gameState = 2;
				   } else if(snake.y + (snake.yspeed * snake.scale) < 0 || snake.y + (snake.yspeed * snake.scale) > this.canvas.height - 14){
					   //Hit a wall
					   this.gameState = 2;
					   console.log("Hit top or bottom");
				   } else {
					   //Didn't hit a wall.
					   snake.x += snake.xspeed * snake.scale;
					   snake.y += snake.yspeed * snake.scale;
					   this.shiftSnake();
				   }
			}
			shiftSnake(){
				//Move all values in the tail array by one
				this.tail.unshift([this.snake.x, this.snake.y]);
				
			}
		}
		
		window.addEventListener("load", function(e){
			console.log("Making game");
			let game = new Game(document.getElementById('myCanvas'));
			game.init();
		});

		

        function drawGameOver() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.beginPath();
            ctx.fillStyle = "black";
            //Box for GameOver text. 
            ctx.fillRect(canvas.width / 2 - 150, canvas.height / 2 - 50, 300, 50);
            ctx.fill();

            if (resButton) {
                //Make button change.
                ctx.fillStyle = "yellow";
                ctx.fillRect(canvas.width / 2 - 75, canvas.height / 2 + 20, 150, 30);
                ctx.fill();

            } else {
                //Normal button.
                //Box for restart button.
                ctx.fillStyle = "black";
                ctx.fillRect(canvas.width / 2 - 75, canvas.height / 2 + 20, 150, 30);
                ctx.fill();
            }

            //All text stuff here.
            ctx.beginPath();
            ctx.font = "30px arial";
            ctx.fillStyle = "red";
            ctx.fillText("Game Over", canvas.width / 2 - 70, canvas.height / 2 - 12);
            ctx.font = "16px arial";
            ctx.fillText("Restart?", canvas.width / 2 - 28, canvas.height / 2 + 40);
        }
        function drawScore() {
            //Draws score. 
            ctx.beginPath();
            ctx.fillStyle = "black";
            ctx.font = "16px Arial";
            ctx.fillText("Score: " + (snake.length - 1), 10, 20);
        }


//            //Check if snake is touching itself. 
//            for (i = 1; i < snake.length; i++) {
//                if (snake.x == tail[i][0] && snake.y == tail[i][1]) {
//                    //Snake is touching itself - Lose Score??
//                    console.log("Touched Self.");
//                    snake.length -= 1;
//                }
//            }



//
//        function mouseMoveHandler(evt) {
//            if (gameState == 2) {
//                //Game is over, watch for mouse to enter button. 
//                var rect = canvas.getBoundingClientRect();
//                mousex = Math.round((evt.clientX - rect.left) / (rect.right - rect.left) * canvas.width);
//                mousey = Math.round((evt.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height);
//                inResButton(mousex, mousey);
//
//
//                console.log("Mouse x,y : " + mousex + " , " + mousey);
//            }
//        }
//
//        function mouseClickHandler(e) {
//            if (resButton == true) {
//                //Then restart game. 
//                gameState = 1;
//                snake = {
//                    scale: 14,
//                    xspeed: 1,
//                    yspeed: 0,
//                    length: 1,
//                    x: 350,
//                    y: 294
//                }
//                tail = [
//                    [snake.x, snake.y]
//                ];
//
//                resButton = false;
//            }
//        }
//
//        function inResButton(x, y) {
//            console.log("Resbutton");
//            //Check if coords inside restart button. 
//            var width = canvas.width;
//            var height = canvas.height;
//            if ((x > width / 2 - 75) && (x < width / 2 - 75 + 150) && (y > height / 2 + 20) && (y < height / 2 + 50)) {
//                resButton = true;
//            } else {
//                resButton = false;
//            }
//
//        }

    </script>
</body>

</html>
