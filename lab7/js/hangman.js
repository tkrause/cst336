// VARIABLES
var alphabet = [
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
    'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
    'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
];

var board = [];
var selectedWord = '';
var selectedHint = '';
var remainingGuesses = 6;
var showHint = false;
var isInit = false;
var words = [
    {word: "snake", hint: "It's a reptile"},
    {word: "monkey", hint: "It's a mammal"},
    {word: "beetle", hint: "It's an insect"}
];
var previousWords = [];
            
// LISTENERS
window.onload = startGame;

$('#hintBtn').on('click', function() {
    $('#hintBtn').hide();
    showHint = true;
    remainingGuesses-=1;
    updateMan();
    updateBoard();
});

$('.letter').on('click', function() {
    var $this = $(this);
    checkLetter($this.attr('id'));
    disableButton($this);
});

$('.replayBtn').on('click', function() {
    showHint = false;
    startGame();
});

// FUNCTIONS
function startGame() {
    
    if (! isInit) {
        createLetters();
        isInit = true;
    }

    resetGame();
    pickWord();
    initBoard();
    updateBoard();
    updateMan();
}

function resetButtons(){
    $('#letters').show();
    for (var letter of alphabet) {
        $('#'+letter).attr('class', 'letter btn btn-success');
        $('#'+letter).prop('disabled', false);
    }
}

function resetGame() {
    $('#hintBtn').show();
    $('#lost').hide();
    $('#won').hide();

    board = [];
    showHint = false;
    remainingGuesses = 6;
    resetButtons();
}

function initBoard() {
    for (var letter of selectedWord) {
        board.push("_");
    }
} 
           
function pickWord() { 
    var randomInt = Math.floor(Math.random() * words.length);
    selectedWord = words[randomInt].word.toUpperCase();
    selectedHint = words[randomInt].hint;
}

function updateBoard() {
    $word = $('#word');
    $word.empty();
    
    for (var letter of board) {
        document.getElementById('word').innerHTML += letter + ' ';
    }
    
    $word.append('<br>');
    if (showHint) {
        $word.append('<span class="hint">Hint: ' + selectedHint + '</span>');
    }
}

function createLetters() {
    for (var letter of alphabet) {
        $('#letters').append('<button class="letter btn btn-success" id="' + letter + '">' + letter + '</button>');
    }
}

function updateWord(positions, letter) {
    for (var pos of positions) {
        board[pos] = letter;
    }    
    
    updateBoard();
}

function checkLetter(letter) {
    var positions = [];
    
    // Put all positions the letter exists in in array
    for (var i = 0; i < selectedWord.length; i++) {
        if (letter === selectedWord[i]) {
            positions.push(i);
        }
    }
    
    if (positions.length > 0) {
        updateWord(positions, letter);
        
        if (! board.includes('_')) {
            endGame(true);
        }
    } else {
        remainingGuesses -= 1;
        updateMan();
    }
    
    if (remainingGuesses <= 0) {
        endGame(false);
    }
}

function updateMan() {
    $('#hangImg').attr('src', 'img/stick_' + (6 - remainingGuesses) + '.png');
}

function endGame(win) {
    $('#letters').hide();
    
    if (win) {
        $('#won').show();
        previousWords.push(selectedWord);
        if (previousWords.length === 1) {
            $('#previousWords').append('<h2>Correctly Guessed Words:</h2><br>');
        }
        
        $('#previousWords').append('<h3>'+selectedWord+'</h3><br>');
    } else {
        $('#lost').show();
    }
}

function disableButton(btn) {
    btn.prop('disabled', true);
    btn.attr('class', 'btn btn-danger');
}
