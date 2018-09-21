<?php

//$_GET['id'] = '000000.rdf';
$arcdir = "/data/sio/arc/";

/* ARC2 static class inclusion */ 
include_once($arcdir.'/ARC2.php');


$ns = array(
 "rdf" => "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
 "rdfs" => "http://www.w3.org/2000/01/rdf-schema#",
 "owl" => "http://www.w3.org/2002/07/owl#",
 "xsd" => "http://www.w3.org/2001/XMLSchema#",
 "dc" => "http://purl.org/dc/terms/",
 "foaf" => "http://xmlns.com/foaf/0.1/",
 "ss" => "http://semanticscience.org/resource/"
);

$prefix = "";
foreach($ns AS $pref => $uri) {
 $prefix .= "PREFIX $pref: <$uri>".PHP_EOL;
}


/* configuration */ 
$config = array(
//  'remote_store_endpoint' => 'http://bio2rdf.semanticscience.org:8050/sparql',
//  'remote_store_endpoint' => 'http://s4.semanticscience.org:10004/sparql',
//  'remote_store_endpoint' => 'http://localhost:8890/sparql',
  'remote_store_endpoint' => 'http://virtuoso:8890/sparql',
  'ns' => $ns
);
/* instantiation */
$store = ARC2::getRemoteStore($config);

$str = $_GET['id'];
if(strstr($str,".rdf")) {
	// just strip it
	$str = substr($str,0,strpos(".rdf",$str)-4);
}

if(!is_numeric($str)) {
 // see if it's a short name
 $str = str_replace('-',' ',$str);
 // fetch the number from an exact match on the label
 $q = $prefix." SELECT ?x WHERE {?x rdfs:label ?label . FILTER regex(?label,\"^$str\")}";
 $rs = $store->query($q);
 if ($errs = $store->getErrors()) {
  // problem
  print_r($errs);
  exit;
 }
 $n = count($rs['result']['rows']);
 if(isset($rs['result']['rows'][0]['x'])) {
  $uri = $rs['result']['rows'][0]['x'];
  $str = substr($uri,strrpos($uri,"/")+1);
 }
}

$pos = strpos( $str, "_");
$ns_prefix = substr($str,0,$pos);
$id = substr($str,$pos+1);
if(!is_numeric($id)) exit;
$id = $ns_prefix."_".$id;

if(FALSE !== ($pos = strrpos($id,".rdf"))) {
 $id = substr($id,0,$pos);
}
$uri = '<http://semanticscience.org/resource/'.$id.'>';
$doc_uri = '<http://semanticscience.org/resource/'.$id.'.rdf>';

$onto_uri = '<http://semanticscience.org/ontology/sio.owl>';
if(strstr($ns_prefix,"CHEMINF")) $onto_uri = '<http://semanticscience.org/ontology/cheminf.owl>';

$sio_graph = '<http://bio2rdf.org/graph/sio>';
$cheminf_graph = '<http://bio2rdf.org/graph/cheminf>';


$q = $prefix.'
CONSTRUCT 
{
 ?x ?y ?z .
 ?x dc:identifier "'.str_replace("_",":",$id).'" .
 ?x rdfs:isDefinedBy '.$onto_uri.' .
 '.$doc_uri.' rdf:type owl:Ontology ;
  rdfs:label "Summary document for '.$id.'" ;
  dc:subject ?x ;
  owl:imports '.$onto_uri.' .
 ?a ?b ?c .
 ?d ?e ?f .
}
FROM '.$sio_graph.' 
FROM '.$cheminf_graph.'
WHERE {

{
  ?x ?y ?z . 
  FILTER (?x = '.$uri.' && !isBlank(?z)) .

} UNION {
  OPTIONAL {
   ?a ?b ?c .
   FILTER (?a = '.$uri.') .
   FILTER (?b = rdfs:subClassOf || ?b = rdfs:subPropertyOf || ?b = owl:inverseOf) .

   ?d ?e ?f .
   FILTER (?c = ?d && ?e = rdfs:label) .
  }
} UNION {
  OPTIONAL {
   ?a ?b ?c .
   ?d ?e ?f .
   FILTER (?c = '.$uri.').
   FILTER (?b = rdfs:subClassOf || ?b = rdfs:subPropertyOf || ?b = owl:inverseOf).
   FILTER (?a = ?d).
   FILTER (?e = rdfs:label).
  }
}

}
';


$rs = $store->query($q);
if ($errs = $store->getErrors()) {
 // problem
 print_r($errs);
  exit;
}


/*** PRINT OUT ***/
$doc = $store->toRDFXML($rs['result']);
//echo $doc = $store->toNTriples($rs['result']);
//echo $doc = $store->toRDFJSON($rs['result']);

$search  = '<?xml version="1.0" encoding="UTF-8"?>';
$replace = '<?xml version="1.0" encoding="UTF-8" ?>
<?xml-stylesheet type="text/xsl" href="http://semanticscience.org/resource/resource.xsl" ?>
';
$doc = str_replace($search,$replace,$doc);

GetHeader();
echo $doc;


function GetHeader() {
// check for accept header type
$a = explode(";",$_SERVER['HTTP_ACCEPT']);
$b = explode(",",$a[0]);

if(in_array("application/rdf+xml",$b)) {
	header("Content-type: application/rdf+xml");
	return 0;
} else if(in_array("text/rdf+xml",$b)) { 
	header("Content-type: text/rdf+xml");
	return 1;
} else { 
	header("Content-type: text/xml");
	return 2;
}

}
?>
