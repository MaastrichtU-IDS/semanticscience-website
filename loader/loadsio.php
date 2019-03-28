<?php
$php = "php";
$base_dir    = "/data/sio/";
$sio_dir     = "/data/semanticscience/";
$cheminf_dir = "/data/semanticchemistry/";
$port = 1111;

$graphs = array(
	"sio"=>"http://bio2rdf.org/graph/sio",
	"cheminf"=> "http://bio2rdf.org/graph/cheminf"
);

system( "mkdir -p $sio_dir");
system( "cd $sio_dir");
system( "git clone https://github.com/MaastrichtU-IDS/semanticscience.git");
exit;
system( "mkdir -p $cheminf_dir");
system( "cd $cheminf_dir;git clone https://github.com/semanticchemistry/semanticchemistry.git");


$files = array(
	"sio-release.owl"         => array('dir'=>$sio_dir.'ontology/sio/release/', 'graph'=>$graphs['sio']),
	"cheminf.owl"          => array('dir'=>$cheminf_dir.'ontology/', 'graph'=>$graphs['cheminf']),
	"cheminf-core.owl"     => array('dir'=>$cheminf_dir.'ontology/', 'graph'=>$graphs['cheminf']),
//	"cheminf-algorithms.owl"     => array('dir'=>$cheminf_dir.'ontology/', 'graph'=>$graphs['cheminf']),
	"cheminf-external.owl" => array('dir'=>$cheminf_dir.'ontology/', 'graph'=>$graphs['cheminf'])
);
$i = 0;
foreach($files AS $file => $a) {
  $graph = $a['graph'];
  $file  = $a['dir'].$file;
  $cmd   = "$php loader.php file=$file pass=dba graph=$graph port=$port";
  if(!isset($dgraph[$graph])) {
	$cmd .= ' deletegraph=true';
	$dgraph[$graph] = 'true';
  }
  if(count($files) == (++$i)) $cmd .= ' updatefacet=true';
  echo $cmd.PHP_EOL;
  system($cmd);
}
?>
