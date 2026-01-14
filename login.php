<?php
require_once 'lib/config.php';
require_once 'lib/session.php';
require_once 'lib/pdo.php';
require_once 'lib/user.php';
require_once 'templates/header.php';

$errors = [];
$messages = [];

// Si le formulaire a été soumis
if (isset($_POST['loginUser'])) {

    // Vérification des identifiants
    $user = verifyUserLoginPassword($pdo, $_POST['email'], $_POST['password']);

    if ($user === false) {
        // Identifiants incorrects
        $errors[] = "Email ou mot de passe incorrect";
    } else {
        // Stockage de l'utilisateur en session
        $_SESSION['user'] = $user;

        // Redirection selon le rôle
        if ($user['role'] === 'admin') {
            header('Location: admin/index.php');
            exit;
        } else {
            header('Location: index.php');
            exit;
        }
    }
}
?>
<h1>Login</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $error): ?>
            <?= htmlspecialchars($error) ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <input type="submit" name="loginUser" class="btn btn-primary" value="Enregistrer">
</form>

<?php
require_once 'templates/footer.php';
?>
