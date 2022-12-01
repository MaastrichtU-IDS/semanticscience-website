# About

Semantic science website, which redirects queries from http://semanticscience.org/resource/* to the right concept in [Ontobee](https://ontobee.org/)

## Run locally

```bash
docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml up -d
```

SemanticScience website at http://localhost, e.g. http://localhost/resource/SIO_000001

## Run with default nginx proxy

Using [jwilder/nginx-proxy](https://github.com/nginx-proxy/nginx-proxy) to deploy to https://semanticscience.org

```bash
docker-compose up -d
```

