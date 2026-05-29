<?php
session_start();
if(isset($_POST["se_connecter"])){
    try{
        require("connexion.php");
        
        $reqprep = 'SELECT id,email,user_password FROM user WHERE email=:email AND user_password=:user_password';
        $req = $conn->prepare($reqprep);

        $email = $_POST['email'];
        $password = $_POST['password'];

        $tab = array(':email'=>$email, ':user_password'=>$password);
        $req->execute($tab);

        $result = $req->fetchall(PDO::FETCH_ASSOC);

        // si ca ne correspond pas le tableau sera vide
        if(empty($result)){
            echo '
                <script>
                    alert("Identifiant ou mot de passe incorrect");
                    window.location.href = "../login.php";
                </script>';
        }

        else{ 
            foreach($result as $rows){
                $mail = $rows['email'];
                $id = $rows['id'];
            }
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $mail;
        } 

        $conn = NULL;
        echo '
        <script>
            alert("Login succesful");
            window.location.href = "../index.php";
        </script>';
        
    }
    catch(Exception $e){
        echo '
        <script>
            alert("Login failed");
        </script>';

        die("Erreur : ". $e->getmessage()); 
    }
}

?>