# About

Fully functional semantic science website. Use `docker-compose.prod.yaml` (will be ignored by git) for production environments.

## Prepare data

Prepare the 2 ontologies that will be deployed, this will clone them in `/data/semanticscience-data`:

```bash
./prepare-data.sh
```

## Run

```bash
docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml up -d
```

* SemanticScience website at http://localhost
* SemanticScience Virtuoso at http://localhost:8890

## Run with default nginx proxy

Using jwilder/nginx-proxy to deploy to https://semanticscience.org

```bash
docker-compose up -d
```

### Restart to update
```bash
docker-compose restart
```
