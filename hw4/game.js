var gameScreen;
var output;

var bullets;

var ship;
var enemies = [];

var deathTimer;
var gameTimer;
var respawnMessage;

var canRespawn = false;
var leftArrowDown = false;
var rightArrowDown = false;

var bg1, bg2;
const BG_SPEED = 4;

const GS_WIDTH = 800;
const GS_HEIGHT = 600;

window.onload = init;

function init(){
    gameScreen = document.getElementById('gameScreen');
    gameScreen.style.width = GS_WIDTH + 'px';
    gameScreen.style.height = GS_HEIGHT + 'px';

    // Backgrounds
    bg1 = document.createElement('IMG');
    bg1.className = 'gameObject';
    bg1.src = img('bg.jpg');
    bg1.style.width = '800px';
    bg1.style.height = '1422px';
    bg1.style.left = '0px';
    bg1.style.top = '0px';
    gameScreen.appendChild(bg1);

    bg2 = document.createElement('IMG');
    bg2.className = 'gameObject';
    bg2.src = img('bg.jpg');
    bg2.style.width = '800px';
    bg2.style.height = '1422px';
    bg2.style.left = '0px';
    bg2.style.top = '-' + bg2.style.height;
    gameScreen.appendChild(bg2);

    // Bullets
    bullets = document.createElement('DIV');
    bullets.className = 'gameObject';
    bullets.style.width = gameScreen.style.width;
    bullets.style.height = gameScreen.style.height;
    bullets.style.left = '0px';
    bullets.style.top = '0px';
    gameScreen.appendChild(bullets);

    output = document.getElementById('output');

    ship = document.createElement('IMG');
    ship.src = img('ship.gif');
    ship.className = 'gameObject';
    ship.style.width = '68px';
    ship.style.height = '68px';
    ship.style.top = '500px';
    ship.style.left = '366px';
    gameScreen.appendChild(ship);

    respawnMessage = document.createElement('DIV');
    respawnMessage.innerText = 'Press Enter to Respawn';
    respawnMessage.className = 'gameObject';
    respawnMessage.style.width = gameScreen.style.width;
    respawnMessage.style.top = '500px';
    respawnMessage.style.textAlign = 'center';
    respawnMessage.style.color = 'yellow';
    respawnMessage.style.fontSize = '48px';
    respawnMessage.style.display = 'none';
    gameScreen.appendChild(respawnMessage);

    for (let i = 0; i < 10; i++) {
        var enemy = new Image();
        enemy.className = 'gameObject';
        enemy.style.width = '64px';
        enemy.style.height = '64px';
        enemy.src = img('enemyShip.gif');
        gameScreen.appendChild(enemy);
        placeEnemyShip(enemy);
        enemies.push(enemy);
    }

    gameTimer = setInterval(gameloop, 50);
}

function placeEnemyShip(e) {
    e.speed = Math.floor(Math.random() * 10) + 6;

    var maxX = GS_WIDTH - parseInt(e.style.width);
    var newX = Math.floor(Math.random() * maxX);
    e.style.left = newX + 'px';

    var newY = Math.floor(Math.random() * 600) - 1000;
    e.style.top = newY + 'px';
}

function img($name) {
    return 'img/' + $name;
}

function gameloop() {
    var bgY = parseInt(bg1.style.top) + BG_SPEED;
    if (bgY > GS_HEIGHT) {
        bg1.style.top = -1 * parseInt(bg1.style.height) + 'px';
    } else {
        bg1.style.top = bgY + 'px';
    }

    bgY = parseInt(bg2.style.top) + BG_SPEED;
    if (bgY > GS_HEIGHT) {
        bg2.style.top = -1 * parseInt(bg2.style.height) + 'px';
    } else {
        bg2.style.top = bgY + 'px';
    }

    if (leftArrowDown) {
        var newX = parseInt(ship.style.left);
        if (newX > 0) ship.style.left = newX - 20 + 'px';
        else ship.style.left = '0px';
    }

    if (rightArrowDown) {
        var newX = parseInt(ship.style.left);
        var maxX = GS_WIDTH - parseInt(ship.style.width);
        if(newX <  maxX) ship.style.left = newX + 20 + 'px';
        else ship.style.left = maxX + 'px';
    }

    for (var b of bullets.children) {
        var newY = parseInt(b.style.top) - b.speed;
        if (newY < 0) {
            bullets.removeChild(b);
        } else {
            b.style.top = newY + 'px';

            for (var enemy of enemies) {
                if (hittest(b, enemy)) {
                    bullets.removeChild(b);
                    explode(enemy);
                    placeEnemyShip(enemy);

                    break;
                }
            }
        }
    }

    for (var enemy of enemies) {
        var newY = parseInt(enemy.style.top);
        if (newY > GS_HEIGHT)
            placeEnemyShip(enemy);
        else
            enemy.style.top = newY + enemy.speed + 'px';

        if (hittest(enemy, ship)) {
            explode(ship);
            explode(enemy);

            ship.style.top = '-10000px';
            setTimeout(function() {
                respawnMessage.style.display = 'block';
                canRespawn = true;
            }, 3000);
            placeEnemyShip(enemy);
        }
    }
}

function respawn() {
    if (! canRespawn)
        return;

    ship.style.top = '500px';
    ship.style.left = '366px';
    respawnMessage.style.display = 'none';
    canRespawn = false;
}

function explode(obj) {
    var explosion = document.createElement('IMG');
    explosion.src = img('explosion.gif?x=' + Date.now());
    explosion.className = 'gameObject';
    explosion.style.width = obj.style.width;
    explosion.style.height = obj.style.height;
    explosion.style.left = obj.style.left;
    explosion.style.top = obj.style.top;

    gameScreen.appendChild(explosion);
}

function hittest(a, b) {
    var aW = parseInt(a.style.width);
    var aH = parseInt(a.style.height);

    var aX = parseInt(a.style.left) + aW / 2;
    var aY = parseInt(a.style.top) + aH / 2;

    var aR = (aW + aH) / 4;

    var bW = parseInt(b.style.width);
    var bH = parseInt(b.style.height);

    var bX = parseInt(b.style.left) + bW / 2;
    var bY = parseInt(b.style.top) + bH / 2;

    var bR = (bW + bH) / 4;

    var minDistance = aR + bR;

    var cXs = (aX - bX) * (aX - bX);
    var cYs = (aY - bY) * (aY - bY);
    var distance = Math.sqrt(cXs + cYs);

    return distance < minDistance;
}

function fire() {
    var bulletWidth = 4;
    var bulletHeight = 10;
    var bullet = document.createElement('DIV');
    bullet.className = 'gameObject';
    bullet.style.backgroundColor = 'yellow';
    bullet.style.width = bulletWidth;
    bullet.style.height = bulletHeight;
    bullet.speed = 20;
    bullet.style.top = parseInt(ship.style.top) - bulletHeight + 'px';
    var shipX = parseInt(ship.style.left) + parseInt(ship.style.width) / 2;
    bullet.style.left = (shipX - bulletWidth / 2) + 'px';
    bullets.appendChild(bullet);
}

document.addEventListener('keypress', function(e) {
    if (e.charCode === 32) fire();
});

document.addEventListener('keydown', function(e) {
    if (e.keyCode==37) leftArrowDown = true;
    if (e.keyCode==39) rightArrowDown = true;
});

document.addEventListener('keyup', function(e) {
    if (e.keyCode==37) leftArrowDown = false;
    if (e.keyCode==39) rightArrowDown = false;

    if (e.keyCode === 13) respawn();
});