<?php

/*
* This script generates a randomized sequence of moves that can be used to scramble a Rubik's Cube.
* A scramble is written in the following notation:
* 
* U for top face turns (Up)
* D for bottom face turns (Down)
* L for Left face turns 
* R for Right face turns 
* F for Front face turns 
* B for Back face turns 
* 
* A letter on its own instructs a 90 degree clockwise turn by default.
* To denote a counter-clockwise turn, an apostrophe is added.
* U' for example would mean "turn the top face counter clockwise 90 degrees"
* 
* A double turn is denoted with an added number 2: 
* F2 for example would mean "Turn the Front face 180 degrees(in either direction)".
* 
* Simply generating a sequence of random moves from the available letters
* causes a problem: a non-sensical succession of moves like U U2 U'.
* Turning the same face two moves in a row does not result in a good overall scramble.
* Therefore, the scrambler must be programmed in a way that bases the next move
* on the previous.
* 
* 
* 
*/

// Define a multidimensional array of available moves.
// The array contains faces U D R L F B, 
// and each face contains an array of possible degrees of rotation: 
// clockwise, counter-clockwise and double rotation
$moves = [
	['U','U\'','U2'], // Top face moves
	['D', 'D\'','D2'], // Bottom face moves
	['R','R\'','R2',], // Right face moves
	['L','L\'','L2'], // Left face moves
	['F','F\'','F2'], // Front face moves
	['B','B\'','B2'] // Back face moves
];

// Prepare a string
$scramble  = '';

// Choose a random number 
$previous  = rand(0,5);

/// This function generates a sensible key depending on the previous key
function getKey($previous, $offset){
	// Choose a random random key between 0 and 5 to select one of 6 faces
	do { $face = rand(0,5); } 
	// If the key happens to be the same as the previous, or if the key selects a face that's directly opposite of the previous one, choose another key
	while ($face == $previous || $face == $previous + $offset);

	return $face;
}

// Generate a sequence of 25 moves
for ($i=0; $i < 25; $i++) {
	switch ($previous) {
		// If the previously chosen face was U (key 0), offset 1 will prevent the next move from being on the D face
		case 0: case 2: case 4:
			$face = getKey($previous, 1);  break; 
		// Similarly, if the previously chosen face was D (key 1), offset -1 will prevent the next move from being on the U face
		case 1: case 3: case 5:
			$face = getKey($previous, -1); break;
		// All other keys will be generated accordingly
	}

	// Choose a key between 0 an 2 to select a degree of rotation
	$rotation_degree = rand(0,2);
	// Use the generated keys to select a move from the $moves array, and concatenate it to the existing string
	$scramble .= $moves[$face][$rotation_degree].' ';
	// Reassign the value of $previous as the face that was just selected in the switch statement
	$previous = $face;
}

// Present the scramble on the page
echo $scramble.'<br>';