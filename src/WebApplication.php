<?php


namespace Tudublin;


class WebApplication
{
    public function run()
    {
        $action = filter_input(INPUT_GET, 'action');
        if(empty($action)){
            $action = filter_input(INPUT_POST, 'action');
        }
        $mainController = new MainController();
        $movieController = new MovieController();
        $loginController = new LoginController();
        $adminContoller = new AdminController();

        switch ($action) {
            case 'processNewUser':
                if($loginController->isLoggedIn()){
                    $adminContoller->processNewUser();
                } else {
                    $movieController->error('you are not authorised for this action');
                }
                break;

            case 'newUserForm':
                $adminContoller->newUserForm();
                break;

            case 'processLogin':
                $loginController->processLogin();
                break;

            case 'logout':
                $loginController->logout();
                break;

            case 'login':
                $loginController->loginForm();
                break;

            case 'processEditMovie':
                if($loginController->isLoggedIn()){
                    $movieController->processUpdateMovie();
                } else {
                    $movieController->error('you are not authorised for this action');
                }
                break;

            case 'editMovie':
                $movieController->edit();
                break;

            case 'processNewMovie':
                if($loginController->isLoggedIn()){
                    $movieController->processNewMovie();
                } else {
                    $movieController->error('you are not authorised for this action');
                }
                break;

            case 'newMovieForm':
                $movieController->createForm();
                break;

            case 'deleteMovie':
                if($loginController->isLoggedIn()){
                    $movieController->delete();
                } else {
                    $movieController->error('you are not authorised for this action');
                }
                break;

            case 'about':
                $mainController->about();
                break;

            case 'contact':
                $mainController->contact();
                break;

            case 'list':
                $movieController->listMovies();
                break;

            case 'sitemap':
                $mainController->sitemap();
                break;

            default:
                $mainController->home();
        }
    }
}