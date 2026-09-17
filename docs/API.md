# API Specification

## Principes


- Toutes les réponses sont en JSON.
- Les endpoints métier sont protégés par authentification.
- La suppression métier standard utilise Soft Deletes ou une action métier explicite.


## Authentication

- `POST /login`
- `POST /logout`
- `POST /forgot-password`
- `POST /reset-password`
- `POST /two-factor-challenge`

