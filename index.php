<!DOCTYPE html>
<html>

<head>
    <?php include("../webAnalytics.php"); ?>
    <meta charset="utf-8" />
    <title> Snake Game</title>
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

    </div>
    <canvas id="myCanvas" width="686" height="588"></canvas>
    <script>
        //To render things on canvas we need a reference to it
        var canvas = document.getElementById("myCanvas");
        var ctx = canvas.getContext("2d");
        //Lets us render 2d stuff I think 
        //Stuff for food. 

        var foodArray = [];
        var gameState = 1;
        var mousex;
        var mousey;
        var resButton = false;
        //Snake object.
        var snake = {
            scale: 14,
            xspeed: 1,
            yspeed: 0,
            length: 1,
            x: 350,
            y: 294
        }
        //Tail array. 
        var tail = [
            [snake.x, snake.y]
        ];


        function makeFood() {
            if (foodArray.length < 2) {
                food = new Food();
                food.pickLocation();
                foodArray.push(food);
            }
        }
        //GAME LOOP 
        function gameLoop() {
            //Game States: 0 - paused, 1 - normal, 2 - game over
            //Clear canvas 
            if (gameState == 1) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                makeFood();
                moveSnake();
                drawSnake();
                snakeEat();
                drawFood();
                drawScore();

            } else if (gameState == 0) {
                //Game is PAUSED
            } else if (gameState == 2) {
                //GAMEOVER
                drawGameOver();
            }
        }

        setInterval(gameLoop, 100);

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

        function snakeEat() {
            for (i in tail) {
                for (j in foodArray) {
                    if (tail[i][0] == foodArray[j].x && tail[i][1] == foodArray[j].y) {
                        foodArray.splice(j, 1);
                        snake.length++;
                    }


                }

            }

        }


        function drawScore() {
            //Draws score. 
            ctx.beginPath();
            ctx.fillStyle = "black";
            ctx.font = "16px Arial";
            ctx.fillText("Score: " + (snake.length - 1), 10, 20);
        }





        function moveSnake() {
            var move = false;

            if ((snake.x + snake.xspeed * snake.scale) > (canvas.width - 14) || (snake.x + snake.xspeed * snake.scale) < 0) {
                //Dont Move - Hit wall
                console.log("HitWall");
                gameState = 2;

            } else {
                snake.x += snake.xspeed * snake.scale;
                if ((snake.xspeed * snake.scale) != 0) {
                    move = true;
                }



            }

            if ((snake.y + snake.yspeed * snake.scale) < 0 || (snake.y + snake.yspeed * snake.scale) > (canvas.height - 14)) {
                //Dont Move - Hit wall
                console.log("HitWall");
                gameState = 2;

            } else {
                snake.y += snake.yspeed * snake.scale;
                if ((snake.yspeed * snake.scale) != 0) {
                    move = true;
                }



            }




            if (move) {
                shiftArray();
                console.log("SNAKE MOVE, X: " + snake.x + " Y: " + snake.y);
            }


            //Check if snake is touching itself. 
            for (i = 1; i < snake.length; i++) {
                if (snake.x == tail[i][0] && snake.y == tail[i][1]) {
                    //Snake is touching itself - Lose Score??
                    console.log("Touched Self.");
                    snake.length -= 1;
                }
            }

            //After Array updated check if snake has hit itself.

            //IF SNAKE MOVES CHECK IF IT IS TOUCHING FOOD 
            //IF FOOD EATEN PICK NO CO-ORDS 
        }

        function shiftArray() {
            //This function fires after the snake MOVES 
            //First will will move all values along the array by 1 
            for (i = snake.length - 1; i > 0; i--) {
                tail[i] = tail[i - 1];
            }
            //Array shifted so last snake pos is at ind 1 in the array 
            //Add current location to head
            tail[0] = [snake.x, snake.y];

            if (snake.length > 1) {
                console.log("Current Pos: " + tail[0]);
                console.log("ind 1 pos: " + tail[1])
            }

        }

        function drawSnake() {
            for (i = 0; i < snake.length; i++) {
                
                if(i == 0) {
                    //drawing head
                    //UP
                    ctx.beginPath();
                    ctx.fillStyle = "black";
                    ctx.rect(tail[i][0], tail[i][1], snake.scale, snake.scale);
                    ctx.fill();
                    
                    
                    
                    
                    
                    if(snake.yspeed == -1) {
                        //eyes facing up
                        ctx.fillStyle = "white";
                        ctx.fillRect(tail[i][0] + 3, tail[i][1] + 1, 2, 3);
                        ctx.fillRect(tail[i][0] + 9, tail[i][1] + 1, 2, 3);
                        
                    }
                    else if(snake.yspeed == 1) {
                        //eyes down
                        ctx.fillStyle = "white";
                        ctx.fillRect(tail[i][0] + 3, tail[i][1] + 10, 2, 3);
                        ctx.fillRect(tail[i][0] + 9, tail[i][1] + 10, 2, 3);
                    }
                    else if(snake.xspeed == -1) {
                        //eyes left
                        ctx.fillStyle = "white";
                        ctx.fillRect(tail[i][0] + 1, tail[i][1] + 3, 3, 2);
                        ctx.fillRect(tail[i][0] + 1, tail[i][1] + 9, 3, 2);
                    }
                    else if(snake.xspeed == 1) {
                        //eyes right
                        ctx.fillStyle = "white";
                        ctx.fillRect(tail[i][0] + 10, tail[i][1] + 3, 3, 2);
                        ctx.fillRect(tail[i][0] + 10, tail[i][1] + 9, 3, 2);
                    }
                    ctx.closePath();
                } else {
                    
                    
                

                ctx.beginPath();
                ctx.rect(tail[i][0], tail[i][1], snake.scale, snake.scale);
                ctx.fillStyle = "black";
                ctx.fill();
                ctx.closePath();
                }

            }


        }

        function drawFood() {

            for (i in foodArray) {
                ctx.beginPath();
                ctx.rect(foodArray[i].x, foodArray[i].y, snake.scale, snake.scale);
                ctx.fillStyle = "red";
                ctx.fill();
                ctx.closePath();

            }


        }


        document.addEventListener("keydown", eventHandler, false);
        document.getElementById("myCanvas").addEventListener("mousemove", mouseMoveHandler, false);
        document.getElementById("myCanvas").addEventListener("mousedown", mouseClickHandler, false);

        function eventHandler(e) {
            e.preventDefault();
            if (e.keyCode == 87 || e.keyCode == 38) {
                //UP
                snake.xspeed = 0;
                snake.yspeed = -1;
            } else if (e.keyCode == 68 || e.keyCode == 39) {
                //RIGHT 
                if (snake.xspeed != -1) {
                    snake.xspeed = 1;
                    snake.yspeed = 0;
                }
            } else if (e.keyCode == 83 || e.keyCode == 40) {
                //DOWN
                snake.xspeed = 0;
                snake.yspeed = 1;

            } else if (e.keyCode == 65 || e.keyCode == 37) {
                //LEFT
                if (snake.xspeed != 1) {
                    snake.xspeed = -1;
                    snake.yspeed = 0;
                }
            } else if (e.keyCode == 80) {
                if (gameState) {
                    gameState = 0;
                } else {
                    gameState = 1;
                }
            }

        }

        function mouseMoveHandler(evt) {
            if (gameState == 2) {
                //Game is over, watch for mouse to enter button. 
                var rect = canvas.getBoundingClientRect();
                mousex = Math.round((evt.clientX - rect.left) / (rect.right - rect.left) * canvas.width);
                mousey = Math.round((evt.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height);
                inResButton(mousex, mousey);


                console.log("Mouse x,y : " + mousex + " , " + mousey);
            }
        }

        function mouseClickHandler(e) {
            if (resButton == true) {

                //Then restart game. 
                gameState = 1;
                snake = {
                    scale: 14,
                    xspeed: 1,
                    yspeed: 0,
                    length: 1,
                    x: 350,
                    y: 294
                }
                tail = [
                    [snake.x, snake.y]
                ];

                resButton = false;
            }
        }

        function inResButton(x, y) {
            console.log("Resbutton");
            //Check if coords inside restart button. 
            var width = canvas.width;
            var height = canvas.height;
            if ((x > width / 2 - 75) && (x < width / 2 - 75 + 150) && (y > height / 2 + 20) && (y < height / 2 + 50)) {
                resButton = true;
            } else {
                resButton = false;
            }

        }

    </script>
</body>

</html>
