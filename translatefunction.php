<?php
function translateFromDb( $lang = 'fa', $filename = 'frontMaster' ) {
    $mysqli = new mysqli( "localhost", "safar360", 'GW@!pvGOZ$h9Mk[JdoU', "safar360_gds" );
	/* check connection */
	if ( $mysqli->connect_errno ) {
		echo "Connect failed " . $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset( "utf8" );
	$string    = 'lang_' . $lang;
	$query     = "SELECT id, selector,{$string} FROM translation_tb";
	$dataArray = [];
	if ( $result = $mysqli->query( $query ) ) {
		/* fetch associative array */
		while ( $row = $result->fetch_assoc() ) {
			array_push( $dataArray, $row );
		}
		if ( count( $dataArray ) ) {
			createXMLfile( $dataArray, $filename, $lang );
			header( 'Content-type:application/json' );
			echo json_encode( $dataArray, 256 | 64 );
		}
		/* free result set */
		$result->free();
	}
	
	/* close connection */
}

function createXMLfile( $dataArray = [], $filename = 'frontMaster', $lang = 'fa' ) {
	$filePath          = 'langs/' . $lang . '_' . $filename . '.xml';
	$dom               = new DOMDocument( '1.0', 'utf-8' );
	$dom->formatOutput = true;
	$root              = $dom->createElement( 'Main' );
	foreach ( $dataArray as $key => $row ) {
		$value   = $row[ 'lang_' . $lang ] ? strip_tags( $row[ 'lang_' . $lang ] ) : ' ';
		$rowItem = $dom->createElement( $row['selector'], $value );
		$root->appendChild( $rowItem );
	}
	$dom->appendChild( $root );
	$dom->save( $filePath );
}

function xmlToDbFromFile( $lang = 'fa' ) {
	$content = file_get_contents( 'langs/' . $lang . '_frontMaster.xml' );
	$parse   = simplexml_load_string( $content );
	$array   = [];
	foreach ( $parse as $key => $item ) {
		$value = (array) $item;
		if ( is_array( $item ) ) {
			$value = end( $item );
		}
//		var_dump($value);
		$array[ $key ] = $value[0];
	}
	insertToDb( $array, $lang );
	//	header( 'Content-type:application/json' );
	//	echo json_encode($array,256|64);
	//	exit();
}

function insertToDb( $dataArray, $lang = 'fa' ) {
    $mysqli = new mysqli( "localhost", "safar360", 'GW@!pvGOZ$h9Mk[JdoU', "safar360_gds" );
    /* check connection */
	if ( $mysqli->connect_errno ) {
		echo "Connect failed " . $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset( "utf8" );
	foreach ( $dataArray as $key => $value ) {
		$value  = str_replace( "'", "\'", $value );
		$string = 'lang_' . $lang;
		$query  = "SELECT id, selector,{$string} FROM translation_tb WHERE selector = '{$key}'" ;
		if ( $result = $mysqli->query( $query )->fetch_assoc() ) {
			$queryUpdate = "UPDATE translation_tb SET `{$string}` = '{$value}' WHERE `selector` = '{$key}'";

			if ( $mysqli->query( $queryUpdate ) == true ) {
				echo '-';
			} else {
				echo '|' . $mysqli->error . '<br>';
			}
		} else {
			$queryInsert = "INSERT INTO `translation_tb` (`selector`, `{$string}`) VALUES ('{$key}', '{$value}');";

			if ( $mysqli->query( $queryInsert ) == true ) {
				echo '_';
			} else {
				echo '\\' . $mysqli->error . '<br>';
			}
		}
	}
}


if ( isset( $_GET['create'] ) ) {
	$lang = isset( $_GET['lang'] ) ? $_GET['lang'] : 'fa';
	translateFromDb( $lang );
}

if ( isset( $_GET['insert'] ) ) {
	$lang = isset( $_GET['lang'] ) ? $_GET['lang'] : 'fa';
	xmlToDbFromFile( $lang );
}
/*
if(isset($_REQUEST['insertNew'])){
	$key = $_REQUEST[''];
	insertToDb($lang);
	
}*/
