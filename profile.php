<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['nom'])) {
    header('Location: login.php');
    exit();
}
$nom = $_SESSION['nom'];
$sql = "SELECT * FROM utilisateur WHERE nom = '$nom'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_et_prenom = $_POST['nom_et_prenom'];
    $email = $_POST['email'];
    $sql = "UPDATE utilisateur SET nom_et_prenom = '$nom_et_prenom', email = '$email' WHERE nom = '$nom'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['nom_et_prenom'] = $nom_et_prenom;
        $_SESSION['email'] = $email;

        $success = 'Informations mises à jour avec succès.';
    } else {
        $error = 'Une erreur est survenue lors de la mise à jour des informations.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon compte</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">reseau social</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">File d'actualité</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Mon compte</h2>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>