<?php

namespace app\core;

use app\core\Request;
use app\core\Router;

abstract class Controller {

    protected Router $router;
    protected Request $request;

    public function __construct() {
        $this->router = new Router();
        $this->request = new Request();
        //niz rola dozvoljenih u konkretnom kontroleru
        $roles = $this->authorize();
        //kada user dodje na sajt bice pokrenuta sesija za njega
        //ta sesija ce imati referencu na usera
        //preuzmi usera iz trenutne sesije
        $user = Application::getApp()->getSession()->get("logged_in_user");
        //proveri da li se role korisnika poklapaju sa dozvoljenim rolama konkretnog kontrolera
        $this->checkRoles($roles, $user);
    }

    //vraca niz rola definisanih u konkretnim kontrolerima
    //koje imaju pristup kontroleru
    //i samim tim pristup odredjenim modulima aplikacije
    //korisnici koji pokusaju pristup nekom modulu bez odgovarajuce role
    //bice poslati na accessDenied view
    public abstract function authorize();

    public function checkRoles($roles, $user) {

        if(!$this->loopRoles($roles, $user))  {
            $this->router->redirect("/accessDenied");
        }
    }

    //pomocna funkcija za proveru prava pristupa
    private function loopRoles($roles, $user): bool {
        foreach($roles as $role) {
            //ako su gosti dozvoljeni, onda je i korisnik sa bilo kojom rolom dozvoljen u tom kontroleru
            if ($role === "guest") {
                return true;
            }
            //ako user postoji u bazi kao korisnik proveri da li ima rolu dozvoljenu u kontroleru
            if($user) {
                foreach ($user->roles as $userRole) {
                    if ($userRole === $role) {
                        return true;
                    }
                }
            }
        }
        return false;
    }


    protected function getPathToView(): string {
        $path = "";
        //app\controllers\AuthenticationController -> Authentication
        $className = str_replace("Controller", "",debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['class']);
        $className = str_replace("app\\controllers\\", "", $className);
        //ime funkcija koja je pozvala getPathToView();
        //npr registration()
        $functionName = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
        $path .= $className . "/" . $functionName;
        return $path;
    }
}
