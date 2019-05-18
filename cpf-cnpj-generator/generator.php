<?php

function mod( $dividendo, $divisor ) {
	return round( $dividendo - ( floor( $dividendo / $divisor ) * $divisor ) );
}

function cpf( $compontos ) {
	$n1 = rand( 0, 9 );
	$n2 = rand( 0, 9 );
	$n3 = rand( 0, 9 );
	$n4 = rand( 0, 9 );
	$n5 = rand( 0, 9 );
	$n6 = rand( 0, 9 );
	$n7 = rand( 0, 9 );
	$n8 = rand( 0, 9 );
	$n9 = rand( 0, 9 );
	$d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
	$d1 = 11 - ( mod( $d1, 11 ) );
	if ( $d1 >= 10 ) {
		$d1 = 0;
	}
	$d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
	$d2 = 11 - ( mod( $d2, 11 ) );
	if ( $d2 >= 10 ) {
		$d2 = 0;
	}
	$retorno = '';
	if ( $compontos == 1 ) {
		$retorno = '' . $n1 . $n2 . $n3 . "." . $n4 . $n5 . $n6 . "." . $n7 . $n8 . $n9 . "-" . $d1 . $d2;
	} else {
		$retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
	}

	return $retorno;
}

function cnpj( $compontos ) {
	$n1  = rand( 0, 9 );
	$n2  = rand( 0, 9 );
	$n3  = rand( 0, 9 );
	$n4  = rand( 0, 9 );
	$n5  = rand( 0, 9 );
	$n6  = rand( 0, 9 );
	$n7  = rand( 0, 9 );
	$n8  = rand( 0, 9 );
	$n9  = 0;
	$n10 = 0;
	$n11 = 0;
	$n12 = 1;
	$d1  = $n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5;
	$d1  = 11 - ( mod( $d1, 11 ) );
	if ( $d1 >= 10 ) {
		$d1 = 0;
	}
	$d2 = $d1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6;
	$d2 = 11 - ( mod( $d2, 11 ) );
	if ( $d2 >= 10 ) {
		$d2 = 0;
	}
	$retorno = '';
	if ( $compontos == 1 ) {
		$retorno = '' . $n1 . $n2 . "." . $n3 . $n4 . $n5 . "." . $n6 . $n7 . $n8 . "/" . $n9 . $n10 . $n11 . $n12 . "-" . $d1 . $d2;
	} else {
		$retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $n10 . $n11 . $n12 . $d1 . $d2;
	}

	return $retorno;
}

function toxml( $a = null, $format = 'array' ) {
	global $results;

	if ( $format == 'json' ):
		$a = json_decode( $a, true );
	endif;

	if ( is_null( $a ) && ! empty( $results ) ):
		$a = $results;
	elseif ( is_null( $a ) && empty( $results ) ):
		return false;
	endif;

	$items = new SimpleXMLElement( "<items></items>" );    // Create new XML element

	foreach ( $a as $b ):                                // Lop through each object in the array
		$c      = $items->addChild( 'item' );                // Add a new 'item' element for each object
		$c_keys = array_keys( $b );                        // Grab all the keys for that item
		foreach ( $c_keys as $key ):                        // For each of those keys
			if ( $key == 'uid' ):
				$c->addAttribute( 'uid', $b[ $key ] );
			elseif ( $key == 'arg' ):
				$c->addAttribute( 'arg', $b[ $key ] );
			elseif ( $key == 'valid' ):
				if ( $b[ $key ] == 'yes' || $b[ $key ] == 'no' ):
					$c->addAttribute( 'valid', $b[ $key ] );
				endif;
			elseif ( $key == 'autocomplete' ):
				$c->addAttribute( 'autocomplete', $b[ $key ] );
			else:
				$c->$key = $b[ $key ];
			endif;
		endforeach;
	endforeach;

	return $items->asXML();                                // Return XML string representation of the array

}

$results = array();

$cpf = cpf( true );
$cnpj = cnpj( true );

$results[] = array(
	'uid'      => 'cpf-com-ponto',
	'title'    => 'CPF com pontuação',
	'subtitle' => $cpf,
	'arg'      => $cpf,
	'icon'     => 'icon.png',
	'valid'    => 'yes'
);

$results[] = array(
	'uid'      => 'cpf-sem-ponto',
	'title'    => 'CPF sem pontuação',
	'subtitle' => preg_replace('/\.|-/u', '', $cpf),
	'arg'      => preg_replace('/\.|-/u', '', $cpf),
	'icon'     => 'icon.png',
	'valid'    => 'yes'
);
$results[] = array(
	'uid'      => 'cnpj-com-ponto',
	'title'    => 'CNPJ com pontuação',
	'subtitle' => $cnpj,
	'arg'      => $cnpj,
	'icon'     => 'icon.png',
	'valid'    => 'yes'
);

$results[] = array(
	'uid'      => 'cnpj-com-ponto',
	'title'    => 'CNPJ sem pontuação',
	'subtitle' => preg_replace('/\.|-/u', '', $cnpj),
	'arg'      => preg_replace('/\.|-/u', '', $cnpj),
	'icon'     => 'icon.png',
	'valid'    => 'yes'
);

echo toxml();
