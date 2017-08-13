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
        }
        
        canvas {
            background: #eee;
            display: block;
            margin: 0 auto;
            margin-top: 50px;
        }

    </style>
</head>

<body>
    <canvas id="myCanvas" width="686" height="588"></canvas>
    
    <div class="lastEdit">
    <?php
        echo "Last Modified (GMT): ".date("F d Y H:i:s.", (getlastmod() + 18000));
        
        ?>
    </div>

    <script>
        //To render things on canvas we need a reference to it
        var canvas = document.getElementById("myCanvas");
        var ctx = canvas.getContext("2d");
        //Lets us render 2d stuff I think 
        var foodx;
        var foody;

        function pickFoodLocation() {
            var rows = canvas.width / snake.scale;
            var cols = canvas.height / snake.scale;
            
            
    
            //RANDOM COLUMN
            foodx = Math.round(Math.random() * 48 ) * 14;
            foody = Math.round( Math.random() * 41 ) * 14;
          
            






        }




        //DRAW SNAKE
       
        var snake = {
            scale: 14,
            xspeed: 1,
            yspeed: 0,
            length: 1,
            x: (canvas.width * 2) / 14,
            y: (canvas.height * 2)/ 14
        }
         var tail = [[snake.x, snake.y]];
        
        pickFoodLocation();

        var gameState = 1; 
        //GAME LOOP 
        function gameLoop() {
            //Will do stuff
            //Clear canvas 
            if(gameState) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            moveSnake();
            drawSnake();
            snakeEat();
            drawFood();
            } else {
                //Game is PAUSED
            }
             

        }
        setInterval(gameLoop, 100);

        function snakeEat() {
            if(snake.x == foodx && snake.y == foody) {
                //EAT 
                
                snake.length++;
               
                pickFoodLocation();
            }
        }




        function moveSnake() {
            var move = false;
            
            if ((snake.x + snake.xspeed * snake.scale) > (canvas.width - 14) || (snake.x + snake.xspeed * snake.scale) < 0) {
                //Dont Move
                
            } else {
                snake.x += snake.xspeed * snake.scale;
                if((snake.xspeed * snake.scale) != 0) {
                    move = true;
                }
                
            
                
            }

            if ((snake.y + snake.yspeed * snake.scale) < 0 || (snake.y + snake.yspeed * snake.scale) > (canvas.height - 14)) {
                //Dont Move 
                
            } else {
                snake.y += snake.yspeed * snake.scale;
                  if((snake.yspeed * snake.scale) != 0) {
                    move = true;
                }
                
                
                
            }
            if(move) {
                shiftArray();
                console.log("SNAKE MOVE, X: " + snake.x + " Y: " + snake.y);
            } 

            //IF SNAKE MOVES CHECK IF IT IS TOUCHING FOOD 
            //IF FOOD EATEN PICK NO CO-ORDS 
        }
        function shiftArray() {
            //This function fires after the snake MOVES 
            //First will will move all values along the array by 1 
            for( i = snake.length - 1; i > 0; i--) {
                tail[i] = tail[ i - 1];
            }
            //Array shifted so last snake pos is at ind 1 in the array 
            //Add current location to head
            tail[0] = [snake.x, snake.y];
            
            if(snake.length > 1) {
                console.log("Current Pos: " + tail[0]);
                console.log("ind 1 pos: " + tail[1])
            }
    
        }

        function drawSnake() {
            for(i = 0; i< snake.length; i++) {
            
            ctx.beginPath();
            ctx.rect(tail[i][0], tail[i][1], snake.scale, snake.scale);
            ctx.fillStyle = "black";
            ctx.fill();
            ctx.closePath();
                
            }
           

        }
        
        function drawFood() {
            ctx.beginPath();
            ctx.rect(foodx, foody, snake.scale, snake.scale);
            ctx.fillStyle = "red";
            ctx.fill();
            ctx.closePath(); 
            
        }


        document.addEventListener("keydown", eventHandler, false);

        function eventHandler(e) {
            if (e.keyCode == 87 || e.keyCode == 38) {
                //UP
                snake.xspeed = 0;
                snake.yspeed = -1;
            } else if (e.keyCode == 68 || e.keyCode == 39) {
                //RIGHT 
                snake.xspeed = 1;
                snake.yspeed = 0;

            } else if (e.keyCode == 83 || e.keyCode == 40) {
                //DOWN
                snake.xspeed = 0;
                snake.yspeed = 1;

            } else if (e.keyCode == 65 || e.keyCode == 37) {
                //LEFT
                snake.xspeed = -1;
                snake.yspeed = 0;

            } else if (e.keyCode == 80) {
                if(gameState) {
                    gameState = 0; 
                } else {
                    gameState = 1;
                }
            }

        }

    </script>
</body>

</html>
