# Database Design

## Principes

- Base cible : PostgreSQL.
- Les clés étrangères suivent les conventions Laravel : `secteur_id`, `user_id`, etc.
- Les suppressions métier utilisent Soft Deletes.
- Les colonnes `deleted_at` sont obligatoires sur les tables métier supprimables.

## Tables 

### `provinces`

- `id`, VARCHAR(255), clé primaire.
- `nom_province`, VARCHAR(255), UNIQUE.



### `secteurs`

- `id`, UUID, clé primaire.
- `denomination`, VARCHAR(255), nom du secteur (ex. PROTECTION, SANTE, WASH, etc.).
- `description`, TEXT, optionnel.


Index :
- index sur `denomination`.

### `organisations`
- `id`, UUID, clé primaire.
- `denomination`, VARCHAR(255), unique.

Index :
- index sur `denomination`.


### `users`

- `id`, UUID, clé primaire.
- `organisation_id`, UUID, FK vers `organisations.id`.
- `nom`, VARCHAR(150).
- `email`, VARCHAR(255), UNIQUE.
- `password`, VARCHAR(255), optionnel.
- `province_id`, VARCHAR(255), FK vers `provinces.id` .
- `role`, VARCHAR(255), par défaut 'Guest'.
- `email_verified_at`, TIMESTAMP, optionnel.
- `phone_number`, VARCHAR(50), optionnel.
- `profile_photo_path`, VARCHAR(500), optionnel.
- `is_active`, BOOLEAN, défaut TRUE.
- `last_login_at`, TIMESTAMP, optionnel.
- `two_factor_secret`, TEXT, optionnel, chiffré.
- `two_factor_recovery_codes`, TEXT, optionnel, chiffré.
- `remember_token`, VARCHAR(100), optionnel.
- `created_at`, TIMESTAMP.
- `updated_at`, TIMESTAMP.
- `deleted_at`, TIMESTAMP, optionnel.
- `google_id`, VARCHAR(255),UNIQUE, optionnel.
- `auth_provider`, VARCHAR(255), optionnel.
- `google_token`, TEXT, optionnel.
- `google_refresh_token`, TEXT, optionnel.


### `activites`

- `id`, UUID, clé primaire.
- `date_activite`, DATE.
- `secteur_id`,UUID, FK vers `secteurs.id`
- `population_cible`, JSONB (Une activité peut cibler plusieurs type de population), ex. PDI, Réfugié, Autochtones, Autres.
- `description`, TEXT.
- `defis_contraintes`, TEXT.
- `localites`, TEXT, optionnel.
- `province_id`, JSONB, FK vers `provinces.id`, Une activité peut concerner plusieurs provinces.
- `nbre_personnes`, INTEGER, >=0, optionnel.
- `nbre_menage`, INTEGER, >=0, optionnel.
- `file_path`, VARCHAR(255), pièce jointe, optionnel.
- `created_by`, UUID, FK vers `users.id`
- `created_at`, TIMESTAMP.
- `updated_at`, TIMESTAMP.
- `deleted_at`, TIMESTAMP, optionnel.


### `documents`

- `id`, UUID, clé primaire.
- `date_publication`, DATE.
- `doc_name`, VARCHAR(255).
- `file_path`, VARCHAR(255).
- `mime_type`, VARCHAR(255), optionnel.
- `original_name`, VARCHAR(255).
- `doc_category`, VARCHAR(255), optionnel.
- `uploaded_by`, UUID,FK vers `users.id` optionnel.
- `doc_summary`, VARCHAR(255), optionnel.
- `download_count`, INTEGER, zero par défaut.

Index :
- index sur `uploaded_by`.
- index sur `doc_category`.









