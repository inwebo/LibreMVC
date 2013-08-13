<?php
/**
 * Helper IDE
 */

/**
 * Le nom de l'instance courante. 
 * <p>
 * Par défaut vaut <b>_default</b>
 * </p>
 */
define('INSTANCE', 'string');
/**
 * Le nom du controller à instancier.
 * <p>
 * Par défaut vaut <b>home</b>
 * </p>
 */
define('CONTROLLER','string');
/**
 * Le nom de la méthode du controller <b>CONTROLLER</b> à utiliser.
 * <p>
 * Par défaut vaut <b>index</b>
 * </p>
 */
define('ACTION', 'string');
/**
 * Tableau sérialisé des paramétres à fournier à ACTION.
 * <p>
 * Par défaut est un <b>tableau null.</b>
 * </p>
 */
define('PARAMS','string');

define('LIBREMVC_MINIMUM_PHP', '5.4');