<?php
class User {

    private string $username = '';
    private string $password = '';
    private string $encrypted_password = '';
    private string $raw_password = '';
    private string $storage;
    private array $stored_users = [];
    private array $new_user = [];

    public function __construct() {
        $this->storage = '\..\models\UserData.json';
    }

    public function register(string $username, string $password):string {


        if (!$this->checkFieldValues($username, $password)) {
            throw new Exception("Both fields are required.");
        }

        $this->username = $username;
        $this->raw_password = filter_var(trim($password), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        $this->new_user = [
            "username" => $this->username,
            "password" => $this->encrypted_password
        ];

        if ($this->usernameExists($this->username, $this->stored_users)) {
            throw new Exception("Username already exists. Please choose a different one.");
        }

        if ($this->insertUser($this->new_user, $this->stored_users)) {
            if (file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT)) === false) {
                throw new Exception("Failed to write JSON data.");
            }
            return "Your registration was succesful!";
            
        } else {
            throw new Exception("An error occurred while trying to save your data. Please try again.");
        }
 
    }
  
    private function checkFieldValues($username, $password) {
        return !empty($username) && !empty($password);
    }

    private function insertUser($new_user, &$stored_users) {
        if (!$this->usernameExists($new_user['username'], $stored_users)) {
            array_push($stored_users, $new_user);
            if (file_put_contents($this->storage, json_encode($stored_users, JSON_PRETTY_PRINT))) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function usernameExists($username, $stored_users) {
        foreach ($stored_users as $user) {
            if ($user["username"] == $username) {
                return true;
            }
        }
        return false;
    }
    public function login($username, $password) {

        $this->username = $username;
        $this->password = $password;

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        if ($this->authenticateUser($this->username, $this->password, $this->stored_users)) {
            return true;
        } else {
            throw new Exception("Wrong username or password.");
        }
    }

    private function authenticateUser($username, $password, $stored_users) {
  
        foreach ($stored_users as $user) {
            if ($user['username'] == $username) {
                if (password_verify($password, $user['password'])) {
                    return true;
                }
            }
        }
        return false;
    }
}


?>
