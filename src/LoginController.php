<?php


namespace Tudublin;


class LoginController extends Controller
{
    public function loginForm()
    {
        $template = 'loginForm.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }


    public function processLogin()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $isValidLogin = $this->checkCredentials($username, $password);

        if($isValidLogin){
            // store value in session ...
            $_SESSION['username'] = $username;
            $mainController = new MainController();
            $mainController->home();
        } else {
            $movieController = new MovieController();
            $movieController->error('bad username or password');
        }
    }


    public function isLoggedIn()
    {
        if(isset($_SESSION['username'])){
            return true;
        }

        return false;
    }

    public function logout()
    {
        $_SESSION = [];
        $mainController = new MainController();
        $mainController->home();
    }

    /**
     * @param $username
     * @param $password
     * @return bool - true/false success or failure
     *
     */
    public function checkCredentials($username, $password)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByUserName($username);

        if($user) {
            $passwordFromDatabase = $user->getPassword();
            if(password_verify($password, $passwordFromDatabase)){
                return true;
            }
        }

        return false;
    }
}