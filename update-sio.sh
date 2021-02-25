#!/bin/bash

# Update sio ontology
cd /data/semanticscience-data/semanticscience
git pull

# Update semanticchemistry ontology
cd /data/semanticscience-data/semanticchemistry
git pull

# Load ontologies in semanticscience Virtuoso
docker exec -it semanticscience-website php /loader/loadsio.php
