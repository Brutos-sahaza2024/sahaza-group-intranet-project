
/**
 * Distribution Sahaza Group intranet.
 *
 * Ajouté par le scaffold Composer du projet : le profil s'installe « depuis la
 * configuration » embarquée dans son dossier config/sync. Le chemin est rendu
 * absolu via $app_root pour que drush (lancé depuis la racine du projet) et
 * l'installateur web le résolvent de la même façon.
 */
$settings['config_sync_directory'] = $app_root . '/profiles/contrib/sahaza_group_intranet/config/sync';
