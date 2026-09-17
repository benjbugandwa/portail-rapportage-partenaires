## Contexte

Le bureau du HCR dans le grand Katanga possède 4 partenaires: CNR, ADSSE, AIDES, et DIVAH.
Ces partenaires implémentent des activités dans 3 provinces: le Tanganyika, le Haut-Katanga et le Lualaba. Ces activités sont classées par secteur: Protection, CCCM, Abris, WASH, VBG, Enregistrement, Documentation, Distribution.

Chaque activité porte un intitulé, une description, une date de mise en oeuvre, une population cible (Réfugiés, PDI, Familles d'accueil, etc.), les secteurs couverts,  le nombre de ménages atteints, le nombre de personnes atteintes, les défis/contraintes, le gap (par rapport aux prévisions), les ou la province dans les (la) quelle l'activité a été implémentée, les justificatifs (pièces jointes): listes de présence, rapport d'activité, etc., un statut (en cours, clôturée)

Je souhaite créer un portail web pour permettre aux staffs des partenaires de rapporter les activités: ajouter des activités, modifier une activité en cours, exporter les activités sur une période données (entre deux dates), etc.

## Mission

Ta mission est de m'accompagner dans la création de cet outil:
- Me proposer une roadmap complète, les étapes à suivre etc.
- Les contraintes, la validation des données, etc.
- Déploiement

## Outils

- Je vais utiliser antigravity comme IDE
- Base des données: PostgreSQL
- Laravel 12, Livewire

## Encodage

- Tous les fichiers doivent être encodés en UTF-8.
- Les accents français doivent être conservés correctement.
- Les secrets, mots de passe, tokens et clés API ne doivent jamais être versionnés dans la documentation ou le code.

## Livewire

- Un composant = une responsabilité.
- Validation côté serveur obligatoire.
- Pas de JavaScript inutile.
- Alpine.js est réservé aux interactions UI légères qui ne justifient pas un composant Livewire.

## Base de Données

- PostgreSQL est la base cible.
- Les clés étrangères suivent les conventions Laravel : `secteur_id`, `user_id`, etc.
- Les clés étrangères sont obligatoires dès qu'une relation métier existe.
- Les colonnes de recherche, filtrage, tri, jointure et déclenchement de jobs doivent être indexées.

## PHP

- PSR-12 obligatoire.
- `declare(strict_types=1);` obligatoire dans les fichiers PHP applicatifs.
- Utiliser les typed properties, return types et value objects lorsque pertinent.
- Utiliser des Enums PHP lorsque c'est nécessaire.
- Utiliser des DTO pour transporter des données entre Livewire/Controllers, Services et Repositories.


## Git

- Branches : `feature/`, `bugfix/`, `hotfix/`, `release/`.
- Les migrations existantes ne doivent jamais être supprimées une fois partagées.

## Documentation

- Mettre à jour README, API, Database et Roadmap lorsqu'une fonctionnalité les impacte.
- PHPDoc uniquement lorsque cela clarifie un contrat ou une logique non évidente.
- Les commentaires doivent expliquer le pourquoi, pas répéter le code.

