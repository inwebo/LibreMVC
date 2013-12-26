<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 23:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot;

use LibreMVC\Controllers\LoginController;
use LibreMVC\Database;
use LibreMVC\Files\Directory;
use LibreMVC\Html\JavascriptConfig;
use LibreMVC\Helpers\BreadCrumbs;
use LibreMVC\Html\Helpers\Theme;
use LibreMVC\Localisation;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Instance;
use LibreMVC\Files\Config;
use LibreMVC\Routing\Router;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\UriParser\Asserts;
use LibreMVC\Http\Context;
use LibreMVC\Sessions;
use LibreMVC\System\Hooks;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Routing\Route;
use LibreMVC\Models\User;
use LibreMVC\Models\Role;
use LibreMVC\Database\Driver\SqLite;
use LibreMVC\Errors\ErrorsHandler;
//@todo Boot MVC, peut exister boot CLI
class Mvc {

    const LIBREMVC_CONFIG_INI = "config/paths.ini";

    protected static $config;

    static public function registerEnvironnement() {
        Environnement::this()->server = Context::getServer(true,true);
    }

    static public function registerErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );

    }

    static public function loadConfig() {
    }

    static public function autoloadInstance() {
        Environnement::this()->paths = Instance::current()->processPattern(Config::load( self::LIBREMVC_CONFIG_INI ), "", "" );
        Environnement::this()->instance = new Instance( Context::getUrl() );

        Environnement::this()->baseUrls = Environnement::this()->instance->processBaseIncludePattern( Environnement::this()->instance->baseUrl, Environnement::this()->paths );

        if(is_file( Environnement::this()->paths->base_autoload )) {
            include(Environnement::this()->paths->base_autoload );
        }
    }

    static public function selectThemes() {
        $config = Config::load( self::LIBREMVC_CONFIG_INI, true);
        $themeConf =  $config->Theme;
        Hooks::get()->callHooks('loadTheme', $themeConf );

        $theme = new Theme( Environnement::this()->paths->base_theme, Environnement::this()->instance->baseUrl ,$themeConf[1]->current );

        Environnement::this()->Theme = $themeConf[1];
        Environnement::this()->Theme->assets = $theme;

    }

    static public function autoloadPlugins() {
        $dir = new Directory( Environnement::this()->paths->base_modules );
        $dir->folders->rewind();
        while($dir->folders->valid()) {
            if(is_file($dir->folders->current()->realPath . '/autoload.php')) {
                include($dir->folders->current()->realPath . '/autoload.php');
            }
            if(is_file($dir->folders->current()->realPath . '/module.ini')) {
                $currentValue = $dir->folders->current()->realPath . '/module.ini';
                $currentKey = ucfirst($dir->folders->current()->name);
                // @todo new stdclass puis push ds env
                Environnement::this()->Modules = new \StdClass;
                Environnement::this()->Modules->$currentKey = new \StdClass;
                Environnement::this()->Modules->$currentKey->config = $dir->folders->current() . "/module.ini";
            }
            $dir->folders->next();
        }
    }

    static public function loadSystemDb() {

        Database\Provider::add('system', new SQlite(Environnement::this()->paths->base_routes));
        Environnement::this()->_dbSystem = Database\Provider::get('system');
    }

    static public function localisation() {
        Localisation::setup('','','');
    }

    static public function defaultRoute() {

        Hooks::get()->callHooks('prependRoutes');
        // Default route
        //@todo bug sur les routes nommées le chemin base_view n'est pas construit
        $defaultRoute = new Route();
        $defaultRoute->name = "";
        $defaultRoute->pattern = trim(Environnement::this()->instance->baseUri,'/').'[/][:action][/][:id][/]';
        $defaultRoute->controller = '\LibreMVC\Controllers\HomeController';
        $defaultRoute->action = 'index';
        RoutesCollection::addRoute($defaultRoute);
        Hooks::get()->callHooks('appendRoutes');
    }

    static public function startSession() {
        $sessions_vars = array('lg'=>'fr');
        Hooks::get()->callHooks('addDefaultSessionsVars', $sessions_vars);
        new Sessions();
    }

    static public function registerUser(){
        \LibreMVC\Models\Role::binder( Database\Provider::get( 'system' ), 'Roles', 'id' );
        \LibreMVC\Models\User::binder( Database\Provider::get( 'system' ), 'Users', 'id' );

        //var_dump(is_null(Sessions::get('User')));
        //var_dump(Sessions::get('User'));



        if( is_null(Sessions::get('User')) ) {
            $user = \LibreMVC\Models\User::load(0);
            Sessions::set('User', $user);
        }

        //var_dump(Sessions::this());
    }

    static public function sandBox() {
        $user = User::loadByPublicKey('inwebo','d46a1e7d07cb1bca68b501f85c803abc');
        var_dump($user);

        $newUser = new User("James","Password","passPhrase", "test@test.fr++");
        $newUser->save();
        var_dump($newUser);
    }

    static public function loadJavascriptConfig() {
        $jsc = new JavascriptConfig("LibreMVC",Sessions::this()['User'] );
        ViewBag::get()->JsConfig = $jsc;
    }


    static public function loadBreadCrumbs() {
        //var_dump(BreadCrumbs::this());
        Environnement::this()->BreadCrumbs = BreadCrumbs::this();
        //var_dump(Environnement::this()->BreadCrumbs = BreadCrumbs::this());
        Hooks::get()->callHooks('addItemsToBreadCrumbs', Environnement::this()->BreadCrumbs);
    }

    static public function sanitizeSuperGlobal() {
        //var_dump( $_GET );
        $filterGet = new \LibreMvc\Helpers\Sanitize\SuperGlobal( $_GET );
        $_GET = $filterGet->get();
        //var_dump( $filterGet->get() );
        ViewBag::get()->errors = ErrorsHandler::$stack;
    }

    /**
     * Devrait être un Object Front controller
     * Applique le pattron de concéption Commande
     */
    static public function frontController() {
        //var_dump(RoutesCollection::getRoutes());
        // Lock du singleton en lecture seule
        Environnement::this()->readOnly = true;

        $router = new Router( Uri::current(), RoutesCollection::getRoutes(), Asserts::load() );

        $routedRoute = $router->dispatch();
        Environnement::this()->controller  = $routedRoute->controller;
        Environnement::this()->action      = $routedRoute->action;
        Environnement::this()->params      = $routedRoute->params;
        Environnement::this()->routedRoute = $routedRoute;

        \LibreMVC\Mvc::invoker(
            $routedRoute->controller,
            $routedRoute->action,
            $routedRoute->params
        );

    }

    static public function postRender() {

    }


}