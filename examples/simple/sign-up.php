<?php

/**
 * This file contains example of simple user authorization.
 * php version 7.4
 *
 * @category SimpleExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

require_once('./includes/start.php');

use ThoPHPAuthorization\Service\HTTPService;

$user = $user_service->getActiveUser();

if ($user) {
    HTTPService::redirectToPage('/examples/simple/index.php');
}
$success = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_data = [
        'name' => HTTPService::getPostValue('name'),
        'password' => HTTPService::getPostValue('password'),
    ];
    if (empty($form_data['name'])) {
        $errors['name'] = "Please enter user name.";
    }
    if (empty($form_data['password'])) {
        $errors['password'] = "Please enter user password.";
    }
    if (empty($errors)) {
        if ($user_service->signUp($form_data)) {
            $success = true;
        } else {
            $errors['form'] = "Failed to create user or user with such name already exists.";
        }
    }
} else {
    $form_data = [
        'name' => '',
        'password' => '',
    ];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Simple example of User Authorization</title>
    <link href="./assets/bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <?php if ($success) { ?>
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Thank you.</h1>
            <p class="col-lg-10 fs-4 mb-5">
                Your User was successfuly signed up! You can now sign in with it.
            </p>
            <a href="./index.php" class="btn btn-lg btn-primary">Sign in</a>
        <?php } else { ?>
            <div class="row align-items-center g-lg-5 py-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-4">Simple example of User Authorization</h1>
                    <p class="col-lg-10 fs-4">
                        This is an example of Sign Up form with basic user functionality.
                        The form built entirely with Bootstrap’s form controls.
                    </p>
                </div>
                <div class="col-md-10 mx-auto col-lg-5">
                    <form method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                        <?php if (isset($errors['form'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errors['form']; ?>
                            </div>
                        <?php } ?>
                        <div class="form-floating mb-3">
                            <input name="name" type="text" class="form-control
                                <?php if (isset($errors['name'])) { ?>
                                    is-invalid
                                <?php } ?>" id="name" placeholder="User name" value="<?= $form_data['name'] ?>">
                            <label for="name">User name</label>
                            <?php if (isset($errors['name'])) { ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php } ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control
                                <?php if (isset($errors['password'])) { ?>
                                    is-invalid
                                <?php } ?>" id="password" placeholder="Password" value="<?= $form_data['password'] ?>">
                            <label for="password">Password</label>
                            <?php if (isset($errors['password'])) { ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php } ?>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
                        <hr class="my-4">
                        <small class="text-body-secondary">
                            Already have user? <a href="./index.php">Sign in</a>
                        </small>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>