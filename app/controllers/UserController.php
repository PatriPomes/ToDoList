<?php

require_once('../app/models/UserModel.php');
require_once(__DIR__.'/../../lib/base/Controller.php');


class UserController extends Controller{
    private $userModel;

    public function __construct(){
        $this->userModel = new User();
    }

    public function indexAction(){
       
    }

    public function RegisterViewAction() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $result = $this->userModel->register($username, $password);
                echo $result;
                header("Location: LoginView.phtml");
                exit();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function LoginViewAction() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            try {
                if ($this->userModel->login($username, $password)) {
                    header("Location: AccountView.phtml");
                    exit();
                } else {
                    echo "Login failed.";
                }
            } catch (Exception $e) {
     
                echo $e->getMessage();
            }
        } 
    }

    public function AccountViewAction() {
        $this->view->render('../../views/user/AccountView.phtml');
    }
 
    
}

?>
