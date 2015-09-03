<?php
header("Content-Type: text/xml");

$commune = $_GET["commune"];
$format = $_GET["format"];
$filter = $_GET["filter"];

$communes = array(
	82 => "BLONAY",           
	84 => "CHARDONNE",
	81 => "CORSEAUX",
	80 => "CORSIER",
	88 => "JONGNY",
	51 => "MONTREUX",
	43 => "PORT_VALAIS",
	60 => "LA_TOUR_DE_PEILZ",
	71 => "VEVEY",
	50 => "VEYTAUX");

$commune_path = $communes[$commune];
$dir = "/data/wwwroot/intranet/croquis/CROQUIS/$commune_path";
$cdir = scandir($dir);

if ($filter == ""){
	$regexp = '/^' . $commune . "_.*\.(jpg)|(png)$/";
}else{
	$regexp = '/^' . $commune . "_" . $filter . "_.*\.(jpg)|(png)$/";
}

$files = Array();

foreach ($cdir as $key => $value){
	
	if (preg_match($regexp, $value, $matches) != 1)	{
		continue;
	}
	
	$abonne = preg_split('/^'.$commune.'_/', $value);
	$abonne = preg_split('/_/',$abonne[1]);
	$abonne = $abonne[0];
	
	$link = "CROQUIS/$commune_path/$value";

	$path_parts = pathinfo($link);
	$ext = $path_parts['extension'];	
	if ($format == "pdf" &&	( strcasecmp($ext,"jpg") == 0 || strcasecmp($ext,"png") == 0 || strcasecmp($ext,"jpeg") == 0 ) ){
		$link = "pdf.php?file=$link";
	}

	if ( empty( $files[$abonne] ) ){
		$files[$abonne] = array($link);		
		}
	else{
		array_push($files[$abonne], $link);
	}
}


ksort( $files );

echo "<?xml version=\"1.0\"?>\n";
echo "<files>\n";


foreach ( $files as $abonne => $links ){
	$cnt = count($links);
	echo 
"<file>
	<abonne>$abonne</abonne>
	<count>$cnt</count>
	<links>
";
	foreach ( $links as $link ){
		echo 
"		<link>$link</link>";
	}
	echo 
"	</links>
</file>";
}
echo
"</files>";
?>

