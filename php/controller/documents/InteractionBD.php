<?php



/**
* @Params int training_id, int student_group
* fonction qui récupère les étudiants correspondant au groupe voulu et renvoie cette liste sous form de tableau indexé
**/
function getStudentsByTrainingGroup($training_id = null, $student_group = null){

    if($training_id == null || $student_group == null)
        return false;
      
    $mysqli = new mysqli("mysql-maquetteprojet.alwaysdata.net", "114038_equipe1", "123456", "maquetteprojet_zenetude");
    if ($mysqli->connect_errno)
    {
        echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    if ($result = $mysqli->query("SELECT  student_id, Student.user_id, student_personnalemail, student_origin, student_avatar, user_name, user_firstname 
                                FROM    Student JOIN User ON Student.user_id = User.user_id 
                                WHERE   training_id = ".$training_id." 
                                AND     student_group = ".$student_group." 
                                ORDER BY user_name")) {
            
        for ($tablearesultat = array (); $row = $result->fetch_assoc(); $tablearesultat[] = $row);
        
        return $tablearesultat;
    }
       
     /*  $dbh = new PDO('mysql:host=mysql-maquetteprojet.alwaysdata.net;dbname=maquetteprojet_zenetude', '114038_equipe1', '123456');  
       $query = $dbh->prepare("SELECT  student_id, Student.user_id, student_personnalemail, student_origin, student_avatar, user_name, user_firstname 
                               FROM    Student JOIN User ON Student.user_id = User.user_id 
                               WHERE   training_id = '".$training_id."' 
                               AND     student_group = '".$student_group."'");
                               
       $query->execute();
       
       
       
    $sql = $pdo->query("SELECT  student_id, Student.user_id, student_personnalemail, student_origin, student_avatar, user_name, user_firstname 
                               FROM    Student JOIN User ON Student.user_id = User.user_id 
                               WHERE   training_id = '".$training_id."' 
                               AND     student_group = '".$student_group."'");
    $sql->setFetchMode(PDO::FETCH_BOTH); // Mode par défaut (tableau)
    return $sql->fetch();*/
}