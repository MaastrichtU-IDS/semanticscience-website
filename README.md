# ℹ️ About

Semantic science website, which redirects queries from http://semanticscience.org/resource/* to the right concept in [Ontobee](https://ontobee.org/)

⚠️ Ontobee is really instable and frequently crashes (weekly at least) for many hours (even days). So we might want to change the redirection to use OLS, which is much nicer. The URI would look like: https://www.ebi.ac.uk/ols/ontologies/sio/terms?iri=http://semanticscience.org/resource/SIO_000983

But be careful as OLS is moving to a new v4, and by doing so they made their URI scheme harder to use and requires to make a difference between properties and classes (wtf, why people are always going for the less logical and practical direction? Why is the semantic web degrading so much over the years?)

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

