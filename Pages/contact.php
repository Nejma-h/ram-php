<?php
session_start();
include('header.php');

//Création des constantes des messages d'erreurs 
const ERROR_REQUIRED = "Veuillez renseigner ce champ";
const ERROR_LENGTH_NAME = "La longueur de ce champ doit être compris entre 2 et 25 caractères";
const ERROR_LENGTH_MESSAGE = "La longueur du message doit être compris entre 25 et 500 caractères";
const ERROR_EMAIL = "L'email n'est pas valide";

$errors = [
    'civilite' =>'',
    'nom' =>'',
    'prenom' =>'',
    'motif' =>'',
    'message' =>''
];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $_SESSION = filter_input_array(INPUT_POST,[
        'civilite' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'nom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'prenom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'email' => FILTER_SANITIZE_EMAIL,
        'motif' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'message' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ]);

//Gestion de la validation des champs
$civilite = $_POST['civilite'] ?? '';//fusion nulle
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$email = $_POST['email'] ?? '';
$motif = $_POST['motif'] ?? '';
$message = $_POST['message'] ?? '';

if(!$civilite){
    $errors['civilite']=ERROR_REQUIRED;
}

if(!$nom){
        $errors['nom']=ERROR_REQUIRED;
}elseif(mb_strlen($nom)<2 || mb_strlen($nom)>25){
    $errors['nom']=ERROR_LENGTH_NAME;

}

if(!$email){
    $errors['email']=ERROR_REQUIRED;
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
$errors['email']=ERROR_EMAIL;
}

if(!$motif){
    $errors['motif']=ERROR_REQUIRED;

}

if(!$message){
    $errors['message']=ERROR_REQUIRED;
}elseif(mb_strlen($message)<25 || mb_strlen($nom)>500){
    $errors['nom']=ERROR_LENGTH_MESSAGE;

}

$data = $civilite.' '.$nom.' '.$prenom.' ❚ Email : '.$email.' ❚ Objet : '.$motif.' ❚ Message : '.$message;
        $today = date("Y-m-d-h-i-s");
        $file = "contact_".$today.".txt";
        file_put_contents($file, $data);
        chmod($file, 0777);
        echo "✅";
 }
?>

<section class="container card mt-5 text-center">
<h1 class="mt-5">Formulaire de contact</h1>
   <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" class="p-5 w-auto mx-auto">
    <div class="mb-3">
    <?= $errors['civilite'] ? "<p style='color:red'>".$errors['civilite']."</p>" : ' '?>
    <select class="form-select" aria-label="Default select example" name="civilite">
        <option selected hidden disabled>Civilité</option>
        <option>M.</option>
        <option>Mme</option>
    </select>
    </div>
    <div class="mb-4">
    <?= $errors['nom'] ? "<p style='color:red'>".$errors['nom']."</p>" : ' '?>
    <input class="form-control" type="text" name="nom" placeholder="Nom">
    <?= $errors['prenom'] ? "<p style='color:red'>".$errors['prenom']."</p>" : ' '?>
    <input class="form-control" type="text" name="prenom" placeholder="Prénom">
    </div>
    <div class="mb-4">

    <input class="form-control" type="email " name="email" placeholder="Email">
    </div>
    <div class="mb-4">
    <label class="bg-dark text-white" for="motif">Raison du contact</label><br>
    <?= $errors['motif'] ? "<p style='color:red'>".$errors['motif']."</p>" : ' '?>
    <input class="form-check-input" type="radio" name="motif" value="Proposition d'emploi">Proposition d'emploi
    <input class="form-check-input" type="radio" name="motif" value="Demande d'information">Demande d'information
    <input class="form-check-input" type="radio" name="motif" value="Prestations">Prestations
        
    </div>
    <div class="mb-3">
    <?= $errors['message'] ? "<p style='color:red'>".$errors['message']."</p>" : ' '?>
    <label for="message">Message</label><br>
    <textarea class="form-control" name="message"></textarea>
    </div>
    <div class="mb-3">
    <input type="submit" name="submit" class="btn btn-dark">
    </div>
</form>
</section>