<?php
/*
    Controller za uporabnike. Vključuje naslednje standardne akcije:
        create: izpiše obrazec za registracijo
        store: obdela podatke iz obrazca za registracijo in ustvari uporabnika v bazi
        edit: izpiše obrazec za urejanje profila
        update: obdela podatke iz obrazca za urejanje profila in jih shrani v bazo
*/

class users_controller
{
    function create(){
        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                case 2: $error = "Gesli se ne ujemata."; break;
                case 3: $error = "Uporabniško ime je že zasedeno."; break;
                default: $error = "Prišlo je do napake med registracijo uporabnika.";
            }
        }
        require_once('views/users/create.php');
    }
    
    function store(){
        //Preveri če so vsi podatki izpolnjeni
        if(empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])){
            header("Location: /users/create?error=1"); 
        }
        //Preveri če se gesli ujemata
        else if($_POST["password"] != $_POST["repeat_password"]){
            header("Location: /users/create?error=2"); 
        }
        //Preveri ali uporabniško ime obstaja
        else if(User::is_available($_POST["username"])){
            header("Location: /users/create?error=3"); 
        }
        //Podatki so pravilno izpolnjeni, registriraj uporabnika
        else if(User::create($_POST["username"], $_POST["email"], $_POST["password"])){
            header("Location: /auth/login");
        }
        //Prišlo je do napake pri registraciji
        else{
            header("Location: /users/create?error=4"); 
        }
        die();
    }

    public function edit() {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        $error = "";
    
        if (isset($_POST["register"])) {
            // Retrieve form data
            $oldPassword = $_POST["old_password"];
            $newPassword = $_POST["password"];
            $repeatPassword = $_POST["repeat_password"];
    
            if ($newPassword !== $repeatPassword) {
                $error = "New password and repeat password do not match";
            } else {
                $passwordChanged = $user->update($oldPassword, $newPassword);
    
                if ($passwordChanged) {
                    session_unset();
                    session_destroy();
                    header("Location: /");
                    exit(); 
                } else {
                    $error = "Old password is incorrect";
                }
            }
        }
    
        // Load view with the form
        include('views/users/edit.php');
    }

    function update(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        //Preveri če so vsi podatki izpolnjeni
        if(empty($_POST["username"]) || empty($_POST["email"])){
            header("Location: /users/edit?error=1"); 
        }
        //Preveri ali uporabniško ime obstaja
        else if($user->username != $_POST["username"] && User::is_available($_POST["username"])){
            header("Location: /users/edit?error=2"); 
        }
        //Podatki so pravilno izpolnjeni, registriraj uporabnika
        else if($user->update($_POST["username"], $_POST["email"])){
            header("Location: /");
        }
        //Prišlo je do napake pri registraciji
        else{
            header("Location: /users/edit?error=3"); 
        }
        die();
    }
    function mojprofil(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        $profileData = $user->mojprofil();

        $username = $profileData['username'];
        $email = $profileData['email'];

        $nmbrofposts = $profileData['article_count'];

        include ('views/users/mojprofil.php');
    }

    function publisherprofil() {
    
        $userId = $_GET['id']; 
        $user = User::find($userId);
    
        if (!$user) {
            header("Location: /pages/error");
            die();
        }
        
        $profileData = $user->publisherprofil($userId);
        $username = $profileData['username'];
        $email = $profileData['email'];
        $nmbrofposts = $profileData['article_count'];
        
        include ('views/users/publisherprofile.php');
    }
}