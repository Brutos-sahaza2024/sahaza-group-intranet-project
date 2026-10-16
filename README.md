# Modèle de projet — Sahaza Group intranet

Ce dépôt est un **modèle de projet Composer** (`"type": "project"`). Il permet
d'obtenir un site Drupal complet, prêt à installer, en **une seule commande** :

```bash
composer create-project sahaza/sahaza-group-intranet-project mon-intranet
```

## Versions

| Version du modèle | Branche | Drupal | PHP | Commande |
|---|---|---|---|---|
| **2.x** | `2.0.x` | 11 | 8.3+ | `composer create-project sahaza/sahaza-group-intranet-project mon-intranet "^2.0"` |
| **1.x** | `1.0.x` | 10.5+ | 8.2+ | `composer create-project sahaza/sahaza-group-intranet-project mon-intranet "^1.0"` |

Sans contrainte de version, Composer installe la dernière version stable.

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
| Drupal core | `drupal/core-recommended ^11` (docroot `web/`) |
| Distribution | `drupal/sahaza_group_intranet` (branche `2.0.x`) dans `web/profiles/contrib/` |
| Modules contrib | toutes les dépendances du profil, y compris celles en alpha/beta/rc/dev |
| Drush | `drush/drush ^13` (`vendor/bin/drush`) |
| Dropzone 5.7.2 | dans `web/libraries/dropzone/` (requis par `dropzonejs`) |
| `config_sync_directory` | ajouté à `default.settings.php` (chemin absolu vers `config/sync` du profil) |
| `settings.php` | créé à partir de `default.settings.php` après chaque `composer install`/`update` s'il n'existe pas (requis par `drush site:install --existing-config`) |

Le modèle règle aussi, **à la racine**, ce qu'un profil ne peut pas imposer :
`minimum-stability: dev` + `prefer-stable: true` et les dépôts Composer
supplémentaires (CKEditor plugins, Panopoly libraries).

`config.platform.php` est fixé à `8.3.0` (minimum de Drupal 11) : les
dépendances sont résolues pour PHP 8.3 même si la commande est lancée avec une
version plus récente.

`symfony/runtime` est autorisé dans `allow-plugins` : c'est un plugin Composer
requis par `drupal/core` 11.4+.

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
chaque tag Git (`1.0.0`, `2.0.0`…) devient une version installable par
`composer create-project`.

Pour tester une modification avant de la publier :

```bash
composer create-project sahaza/sahaza-group-intranet-project mon-intranet \
  --stability=dev \
  --repository='{"type":"path","url":"/chemin/vers/sahaza-group-intranet-project","options":{"symlink":false}}'
```

## Maintenance

- Dès qu'une release 2.x du profil est taguée, remplacer
  `"drupal/sahaza_group_intranet": "2.0.x-dev"` par `"^2.0"`.
- Les correctifs Drupal 10 se font sur la branche `1.0.x` (tags `1.0.*`).
- Si le projet est publié sur `packages.drupal.org`, le dépôt `vcs`
  `sahaza_group_intranet` peut être retiré.
