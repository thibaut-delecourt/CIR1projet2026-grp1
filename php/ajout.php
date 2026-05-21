<?php
session_start();
if(isset($_POST["creer_mon_compte"])){
    try{
        require("connexion.php");
        $reqprep = 'INSERT INTO user(email,user_password) VALUES (:email,:user_password)';
        $req = $conn->prepare($reqprep);
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $tab = array(':email'=>$email, ':user_password'=>$password);
        $req->execute($tab);

        $_SESSION['email'] = $email;
        // pour recupérer id car on en aura besoin avec le score
        $_SESSION['id'] = $conn->lastInsertId();

        $reqscoreprep = 'INSERT INTO score(id_user,score_max) VALUES (:id,:score)';
        $reqscore = $conn->prepare($reqscoreprep);

        $tab2 = array(':id'=>$_SESSION['id'], ':score'=>0);
        $reqscore->execute($tab2);

        $conn = NULL;
        echo '
        <script>
            alert("Création du compte réussie");
            window.location.href = "../index.php";
        </script>';
        

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