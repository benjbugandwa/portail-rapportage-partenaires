# CONTEXTE

Tu participes au développement d'un portail web humanitaire pour le rapportage des activités par secteur et par organisation.

Avant toute action, lis et respecte impérativement les documents suivants :

- C:/xampp/report-project/docs/Architecture.md
- C:/xampp/report-project/docs/BusinessRules.md
- C:/xampp/report-project/docs/CodingStandards.md
- C:/xampp/report-project/docs/DatabaseDesign.md
- C:/xampp/report-project/docs/UI.md
- C:/xampp/report-project/docs/AGENTS.md

Ces documents constituent la source unique de vérité.

Ne fais jamais d'hypothèses lorsqu'une règle métier est documentée.

En cas d'incohérence entre deux documents, arrête-toi et explique le problème avant toute implémentation.

---

# MODULE À DÉVELOPPER

Gestion des utilisateurs.

Objectifs :

Développer le CRUD complet de gestion des utilisateurs

- Authentification via Google OAuth
- Sélection de l'organisation et de la province
- visualisation des utilisateurs (uniquement les administrateurs), avec options de filtres et pagination
- affectation des utilisateurs à une organisation (uniquement les administrateurs)
- affectation des utilisateurs à une province (uniquement les administrateurs)
- Activation/Désactivation des utilisateurs (Uniquement les administrateurs)
- Auditer un utilisateur: fréquence des connexions, nombre d'activités ajoutées sur une période (uniquement les administrateurs)


---

# STACK

Laravel 12

Livewire 4

PHP 8.2

PostgreSQL

TailwindCSS

AlpineJS


Laravel Notifications

Pest

---

# CONTRAINTES

Le développement doit respecter strictement :

- Architecture.md
- DatabaseDesign.md
- UI.md
- BusinessRules.md
- CodingStandards.md


Respecter :

- SOLID
- DRY
- KISS
- Clean Architecture
- PSR-12

Ne jamais casser une fonctionnalité existante.

Ne jamais dupliquer du code.

Toujours privilégier la solution la plus maintenable.

---

# LIVRABLES OBLIGATOIRES

Le module doit inclure si nécessaire :

- migrations

- modèles

- relations

- enums

- factories

- seeders

- policies

- gates

- middleware

- form requests

- services

- repositories (si nécessaire)

- DTO (si nécessaire)

- notifications

- mail

- jobs

- events

- listeners

- composants Livewire

- vues Blade

- routes

- configuration

- tests Unit

- tests Feature

- documentation

---

# MÉTHODOLOGIE

Ne commence jamais directement à coder.

Travaille obligatoirement selon les étapes suivantes.

## Étape 1

Analyse tous les documents.

Identifie les règles métier.

Identifie les dépendances.

Identifie les risques.

Identifie les incohérences éventuelles.

Ne code rien.

---

## Étape 2

Présente un plan d'architecture détaillé.

Explique :

- les modules concernés
- les modèles
- les migrations
- les relations
- les services
- les composants Livewire
- les routes
- les notifications
- les tests

Explique également pourquoi ces choix sont les meilleurs.

Ne code toujours rien.

---

## Étape 3

Découpe le travail en petites tâches indépendantes.

Chaque tâche doit pouvoir être développée en moins d'une heure.

Présente un backlog sous la forme :

Task 1

Objectif

Fichiers concernés

Dépendances

Critères d'acceptation

---

Task 2

...

Attends ensuite ma validation.

---

## Étape 4

Une fois le backlog validé, développe toutes les tâches.



---

## Étape 5

À la fin du développement de toutes les tâches :

- exécute les tests
- vérifie la sécurité
- vérifie les performances
- mets à jour la documentation
- résume les modifications
- propose la tâche suivante

---

# IMPORTANT

Si tu estimes qu'une meilleure architecture est possible que celle décrite dans les documents, explique-la avant de coder.

N'effectue aucune modification structurelle sans validation.