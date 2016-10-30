<?php

$con = mysqli_connect("localhost","USERNAME","WACHTWOORD","TABELNAAM")or die('Kan niet verbinden');
mysqli_set_charset($con, "utf8");

for($jaar = 1991; $jaar < 2016; $jaar ++){

	$page = file_get_contents("http://www.top40web.nl/nljr/nltsjr".$jaar.".html");

    $pattern = '#<td><strong>(.*?)</strong></td>#';
    preg_match_all($pattern, $page, $matches);

	$hits =$matches[0];

	foreach( $hits as $hit ){

		if($hit != ' '){

			$hit = explode(" - ", $hit);

			$artiest = mysqli_real_escape_string($con,strip_tags(utf8_encode($hit[1])));
			$nummer = mysqli_real_escape_string($con,strip_tags(utf8_encode($hit[0])));

			$aantalwoorden =  count(explode(" ", $nummer));

			if(strlen($artiest) > 2){
				mysqli_query($con,"INSERT INTO `charts` (jaar,titel,artiest,aantalwoorden) VALUES ('$jaar','$nummer','$artiest','$aantalwoorden')");
			}
		}
	}
}
?>