# Modèle de projet — Sahaza Group intranet

Ce dossier est un **modèle de projet Composer** (`"type": "project"`). Il permet
d'obtenir un site Drupal complet, prêt à installer, en **une seule commande** :

```bash
composer create-project sahaza/sahaza-group-intranet-project mon-intranet
```

Ou en deux temps (comme `thunder/thunder-project`) — pratique pour ajuster le
`composer.json` (version de Drupal, `platform.php`…) avant de télécharger quoi
que ce soit :

```bash
composer create-project sahaza/sahaza-group-intranet-project mon-intranet --no-interaction --no-install
cd mon-intranet
composer install
```

## Ce que la commande installe

| Élément | Détail |
|---------|--------|
| Drupal core | `drupal/core-recommended ^10.5` (docroot `web/`) |
| Distribution | `drupal/sahaza_group_intranet` (branche `1.0.x`) dans `web/profiles/contrib/` |
| Modules contrib | toutes les dépendances du profil, y compris celles en alpha/beta/rc/dev |
| Drush | `drush/drush ^12.5 \|\| ^13` (`vendor/bin/drush`) |
| Dropzone 5.7.2 | dans `web/libraries/dropzone/` (requis par `dropzonejs`) |
| `config_sync_directory` | ajouté à `default.settings.php` (chemin absolu vers `config/sync` du profil) |
| `settings.php` | créé à partir de `default.settings.php` après chaque `composer install`/`update` s'il n'existe pas (requis par `drush site:install --existing-config`) |

Le modèle règle aussi, **à la racine**, ce qu'un profil ne peut pas imposer :
`minimum-stability: dev` + `prefer-stable: true` et les dépôts Composer
supplémentaires (CKEditor plugins, Panopoly libraries).

`config.platform.php` est fixé à `8.2.0` : les dépendances sont résolues pour
PHP 8.2 même si la commande est lancée avec PHP 8.3+, ce qui garantit que le
code produit tourne sur tout serveur compatible Drupal 10.

`drupal/graphql` est contraint en `^4.14` (version de référence Drupal 10 du
profil) : la 5.1 utilise `Drush\Formatters\FormatterTrait`, présent seulement
dans Drush 13.7+ (PHP 8.3), et casse toute commande drush sous PHP 8.2.

### Passer sur Drupal 11

```bash
composer config platform.php 8.3.0
composer require drupal/core-recommended:^11 drupal/core-composer-scaffold:^11 \
  drupal/core-project-message:^11 "drupal/graphql:^4.14 || ^5.0" -W
```

Voir le §8 de `INSTALL.md` du profil pour les points de vigilance.

## Installer le site ensuite

```bash
cd mon-intranet
vendor/bin/drush site:install sahaza_group_intranet --existing-config \
  --db-url=mysql://user:pass@localhost/intranet \
  --account-name=admin --account-pass=CHANGEME -y
```

Ou via le navigateur : `/core/install.php`.

## Publication du modèle

Ce dépôt est publié sur [Packagist](https://packagist.org/packages/sahaza/sahaza-group-intranet-project) :
chaque tag Git (`1.0.0`, `1.0.1`…) devient une version installable par
`composer create-project`.

Pour tester une modification avant de la publier :

```bash
composer create-project sahaza/sahaza-group-intranet-project mon-intranet \
  --stability=dev \
  --repository='{"type":"path","url":"/chemin/vers/sahaza-group-intranet-project","options":{"symlink":false}}'
```

## Maintenance

- Dès qu'une release taguée du profil inclut la compatibilité actuelle, remplacer
  `"drupal/sahaza_group_intranet": "1.0.x-dev"` par `"^1.0"`.
- Si le projet est publié sur `packages.drupal.org`, le dépôt `vcs`
  `sahaza_group_intranet` peut être retiré.
