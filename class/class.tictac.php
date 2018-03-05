<?php

class tictac {
	var $playerId = "X";	//Player identifier
	var $TicTac = array();	//the tic tac toe board to store moves
	var $moves = 0;		//how many moves have been made so far to decide a draw	
	var $gameover, $playerName, $won;	


	function startGame() {		
		$this->gameover = false;
		$this->won = false;
	}

	function __construct() {
		$this->startGame();
        $this->resetBoard();
	}
	
	function newGame() {
		$this->startGame(); //reset everything and start a new gane
		$this->playerId = "X"; //Initialize player 1
		$this->playerName = "Player 1";
		$this->moves = 0;
        $this->resetBoard();
	}
    
    function resetBoard() {
		$this->TicTac = array();
        for ($i = 0; $i <= 2; $i++)
        {
            for ($x = 0; $x <= 2; $x++)
            {
                $this->TicTac[$i][$x] = null;
            }
        }
    }	

	function play($payload) {
		if (!$this->isMatch() && isset($payload['move'])) {
			$this->move($payload);
        }
		if (isset($payload['newgame'])) {
			$this->newGame();
        }
		$this->showGame();
	}
	
	function showGame(){
		if (!$this->isMatch()) {
			echo "<div id=\"game_board\">";
			
			for ($i = 0; $i <= 2; $i++) {
				for ($x = 0; $x <= 2; $x++) {
					echo "<div class=\"cell\">";
					if ($this->TicTac[$i][$x])
						echo "<img src=\"assets/{$this->TicTac[$i][$x]}.jpg\" alt=\"{$this->TicTac[$i][$x]}\" title=\"{$this->TicTac[$i][$x]}\" />";
					else {
						echo "<select name=\"{$i}_{$x}\">
								<option value=\"\"></option>
								<option value=\"{$this->playerId}\">{$this->playerId}</option>
							</select>";
					}					
					echo "</div>";
				}				
				echo "<div class=\"clearfix\"></div>";
			}			
			echo "
				<p align='center'>
					<input type='submit' name= 'move' value='Play' /><br/>
					<b>It's player ".$this->playerName."'s turn.</b></p>
			</div>";
		}
		else {
			echo "<div id=\"game_board\">";
			if ($this->isMatch() != "Draw")
				echo win("Congrats player " . $this->playerName . ", you've won the game!");
			else if ($this->isMatch() == "Draw")
				echo draw("Ooooops! It's a tie game. Restart Game?");
				
			session_destroy(); 
				
			echo "<p align=\"center\"><input type=\"submit\" name=\"newgame\" value=\"New Game\" /></p>";
			echo "</div";
		}
	}	

	function isMatch() {		
		if ($this->TicTac[0][0] && $this->TicTac[0][0] == $this->TicTac[0][1] && $this->TicTac[0][1] == $this->TicTac[0][2])
			return $this->TicTac[0][0];
			
		if ($this->TicTac[1][0] && $this->TicTac[1][0] == $this->TicTac[1][1] && $this->TicTac[1][1] == $this->TicTac[1][2])
			return $this->TicTac[1][0];
			
		if ($this->TicTac[2][0] && $this->TicTac[2][0] == $this->TicTac[2][1] && $this->TicTac[2][1] == $this->TicTac[2][2])
			return $this->TicTac[2][0];
			
		if ($this->TicTac[0][0] && $this->TicTac[0][0] == $this->TicTac[1][0] && $this->TicTac[1][0] == $this->TicTac[2][0])
			return $this->TicTac[0][0];
			
		if ($this->TicTac[0][1] && $this->TicTac[0][1] == $this->TicTac[1][1] && $this->TicTac[1][1] == $this->TicTac[2][1])
			return $this->TicTac[0][1];
			
		if ($this->TicTac[0][2] && $this->TicTac[0][2] == $this->TicTac[1][2] && $this->TicTac[1][2] == $this->TicTac[2][2])
			return $this->TicTac[0][2];
			
		if ($this->TicTac[0][0] && $this->TicTac[0][0] == $this->TicTac[1][1] && $this->TicTac[1][1] == $this->TicTac[2][2])
			return $this->TicTac[0][0];
			
		if ($this->TicTac[0][2] && $this->TicTac[0][2] == $this->TicTac[1][1] && $this->TicTac[1][1] == $this->TicTac[2][0])
			return $this->TicTac[0][2];
			
		if ($this->moves > 8)
			return "Draw";
	}

	function move($payload) {			

		if ($this->isMatch())
			return;

		//remove duplicates and take first count
		$payload = array_unique($payload);
		
		foreach ($payload as $key => $value) {
			if ($value == $this->playerId) {	
				$pos = explode("_", $key);
				$this->TicTac[$pos[0]][$pos[1]] = $this->playerId;

				//change the turn to the next player
				if ($this->playerId == "X"){
					$this->playerId = "O";
					$this->playerName = "Player 2";
				}
				else {
					$this->playerId = "X";
					$this->playerName = "Player 1";
				}	
				$this->moves++;
			}
		}
	
		if ($this->isMatch())
			return;
	}
}

function draw($data) {
	return "<div class=\"draw\">$data</div>";
}

function win($data) {
	return "<div class=\"win\">$data</div>";
}