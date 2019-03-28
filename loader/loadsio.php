<?php
$php = "php";
$base_dir    = "/data/sio/";
$sio_dir     = "/usr/local/virtuoso-opensource/var/lib/virtuoso/db/import/semanticscience/";
$cheminf_dir = "/usr/local/virtuoso-opensource/var/lib/virtuoso/db/import/semanticchemistry/";
$port = 1111;

$graphs = array(
	"sio"=>"http://bio2rdf.org/graph/sio",
	"cheminf"=> "http://bio2rdf.org/graph/cheminf"
);

system( "mkdir -p $sio_dir");
system( "git clone https://github.com/MaastrichtU-IDS/semanticscience.git $sio_dir");
//exit;
system( "mkdir -p $cheminf_dir");
system( "cd $cheminf_dir;git clone https://github.com/semanticchemistry/semanticchemistry.git $cheminf_dir");


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
