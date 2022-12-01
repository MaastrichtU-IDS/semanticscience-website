#!/bin/bash

ssh ids1 'cd /data/deploy-ids-services/semanticscience-website ; docker-compose down ; docker-compose up -d'

