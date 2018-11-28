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
    bg1 = $('<img/>',{
        class: 'gameObject',
        src: img('bg.jpg'),
        css: {
            width: '800px',
            height: '1422px',
            left: 0,
            top: 0,
        }
    }).appendTo(gameScreen);

    bg2 = $('<img/>',{
        class: 'gameObject',
        src: img('bg.jpg'),
        css: {
            width: '800px',
            height: '1422px',
            left: 0,
            top: '-1422px',
        }
    }).appendTo(gameScreen);

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

    respawnMessage = $('<div/>', {
        text: 'Press Enter to Respawn',
        class: 'gameObject',
        css: {
            width: gameScreen.style.width,
            top: '500px',
            textAlign: 'center',
            color: 'yellow',
            fontSize: '48px',
            display: 'none',
        }
    }).appendTo(gameScreen);

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
    var bgY = parseInt(bg1.css('top')) + BG_SPEED;
    if (bgY > GS_HEIGHT) {
        bg1.css('top', -1 * parseInt(bg1.css('height')) + 'px');
    } else {
        bg1.css('top', bgY + 'px');
    }

    bgY = parseInt(bg2.css('top')) + BG_SPEED;
    if (bgY > GS_HEIGHT) {
        bg2.css('top', -1 * parseInt(bg2.css('height')) + 'px');
    } else {
        bg2.css('top', bgY + 'px');
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
                respawnMessage.show();
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
    respawnMessage.hide();
    canRespawn = false;
}

function explode(obj) {
    $('<img/>', {
        src: img('explosion.gif?x=' + Date.now()),
        class: 'gameObject',
        css: {
            width: obj.style.width,
            height: obj.style.height,
            left: obj.style.left,
            top: obj.style.top,
        }
    }).appendTo(gameScreen);
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
    var shipX = parseInt(ship.style.left) + parseInt(ship.style.width) / 2;

    var bullet = $('<div/>',{
        class: 'gameObject',
        css: {
            backgroundColor: 'yellow',
            width: bulletWidth + 'px',
            height: bulletHeight + 'px',
            left: (shipX - bulletWidth / 2) + 'px',
            top: parseInt(ship.style.top) - bulletHeight + 'px',
        },
    });

    bullet = bullet.get(0);
    bullet.speed = 20;
    bullets.appendChild(bullet);
}

$(document).on('keypress', function(e) {
    if (e.charCode === 32) {
        fire();
    }
});

$(document).on('keydown', function(e) {
    if (e.keyCode==37) {
        leftArrowDown = true;
    }

    if (e.keyCode==39) {
        rightArrowDown = true;
    }
});

$(document).on('keyup', function(e) {
    if (e.keyCode==37) {
        leftArrowDown = false;
    }

    if (e.keyCode==39) {
        rightArrowDown = false;
    }

    if (e.keyCode === 13) {
        respawn();
    }
});