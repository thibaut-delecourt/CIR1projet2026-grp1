<?php
if(isset($_POST["creer_mon_compte"])){
    try{
        require("connexion.php");
        $reqprep = 'INSERT INTO user(email,user_password) VALUES (:email,:user_password)';
        $req = $conn->prepare($reqprep);
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $tab = array(':email'=>$email, ':user_password'=>$password);
        $req->execute($tab);

        $conn = NULL;
        echo '
        <script>
            alert("Création du compte réussie");
            window.location.href = "../index.html";
        </script>';
        /*
        header("Location: ../index.html");
        exit();
        */
    }
    catch(Exception $e){
        echo '
        <script>
            alert("Echec de la création du compte");
        </script>';

        die("Erreur : ". $e->getmessage()); 
    }
}

?>