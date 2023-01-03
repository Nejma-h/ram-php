<?php include('header.php'); ?>
<section class="container card mt-5 text-center">
    <h1 class="mt-5">Formulaire de contact</h1>
<form action="contact.php" method="POST" class="p-5 w-auto mx-auto">
    <div class="mb-3">

    <select class="form-select" aria-label="Default select example" name="civilite">
        <option selected>Civilité</option>
        <option>M.</option>
        <option>Mme</option>
    </select>
    </div>
    <div class="mb-4">
    <input class="form-control" type="text" name="nom" placeholder="Nom">
    <input class="form-control" type="text" name="prenom" placeholder="Prénom">
    </div>
    <div class="mb-4">
    <input class="form-control" type="email " name="email" placeholder="Email">
    </div>
    <div class="mb-4">
    <label class="bg-dark text-white" for="motif">Raison du contact</label><br>
    <input class="form-check-input" type="radio" name="motif" value="Proposition d'emploi">
        <label class="form-check-label" for="message">Proposition d'emploi</label><br>
    <input class="form-check-input" type="radio" name="motif" value="Demande d'information">
        <label class="form-check-label" for="message">Demande d'information</label><br>
    <input class="form-check-input" type="radio" name="motif" value="Prestations">
        <label class="form-check-label" for="message">Prestations</label><br>
    </div>
    <div class="mb-3">
    <label for="message">Message</label><br>
    <textarea class="form-control" name="message"></textarea>
    </div>
    <div class="mb-3">
    <button type="submit" name="submit" class="btn btn-dark">ENVOYER</button>
    </div>
</form>
</section>
<?php
$civilite = $_POST['civilite'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$motif = $_POST['motif'];
$message = $_POST['message'];

$data = $civilite.' '.$nom.' '.$prenom.'<br/>'.$email.'<br/>>'.'Objet: '.$motif.'<br/>>'.$message;
$today = date(DATE_ATOM, mktime(0, 0, 0, 7, 1, 2000));
$file = "contact_".$today.".txt";

if(isset($_POST['submit'])) {
    file_put_contents($file, $data);
    chmod($file,0777);
}
