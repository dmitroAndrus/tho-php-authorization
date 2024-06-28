<?php

/**
 * This file contains example of generic user authorization.
 * php version 7.4
 *
 * @category GenericExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

require_once('./includes/start-autoload.php');

use ThoPHPAuthorization\Service\HTTPService;

$user = $user_service->getActiveUser();

if (!$user) {
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form_data = [
            'identity' => HTTPService::getPostValue('identity'),
            'password' => HTTPService::getPostValue('password'),
            'keep_signed' => !!HTTPService::getPostValue('keep_signed'),
        ];
        if (empty($form_data['identity'])) {
            $errors['identity'] = "Please enter user name, email or phone number.";
        }
        if (empty($form_data['password'])) {
            $errors['password'] = "Please enter user password.";
        }
        if (empty($errors)) {
            if ($user_service->authorize($form_data['identity'], $form_data['password'], $form_data['keep_signed'])) {
                $user = $user_service->getActiveUser();
            } else {
                $errors['form'] = "User with such name or password doesn't exists.";
            }
        }
    } else {
        $form_data = [
            'identity' => '',
            'password' => '',
            'keep_signed' => false,
        ];
    }
}

?>
<!DOCTYPE html>
<html>
<?php include('parts/head.php'); ?>
<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <?php if ($user) { ?>
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Hello <?= $user->getIdentity() ?></h1>
            <p class="col-lg-10 fs-4 mb-5">
                This is generic example of User Authorization.<br/>
                You are signed in! Thank You for testing this project!
            </p>
            <p class="col-lg-10 fs-5 mb-5">
                <span class="fs-4">Your details:</span><br/>
                Full Name: <strong><?= $user->getFullName() ?></strong><br/>
                Birthday: <strong><?= $user->getBirthday('Y-m-d') ?></strong><br/>
                Email: <strong><?= $user->getEmail() ?></strong><br/>
                Phone: <strong><?= $user->getPhone() ?></strong><br/>
                Address: <strong><?= $user->getFullAddress() ?></strong>
            </p>
            <a href="./sign-out.php" class="btn btn-lg btn-primary">Sign out</a>
        <?php } else { ?>
            <div class="row g-lg-5 py-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-4">Sign In</h1>
                    <?php include('parts/description.php'); ?>
                </div>
                <div class="col-md-10 mx-auto col-lg-5">
                    <form method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                        <?php if (isset($errors['form'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errors['form']; ?>
                            </div>
                        <?php } ?>
                        <div class="form-floating mb-3">
                            <input name="identity" type="text" class="form-control
                                <?php if (isset($errors['identity'])) { ?>
                                    is-invalid
                                <?php } ?>" id="identity" placeholder="User name" value="<?= $form_data['identity'] ?>">
                            <label for="identity">User name</label>
                            <?php if (isset($errors['identity'])) { ?>
                                <div class="invalid-feedback"><?= $errors['identity'] ?></div>
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
                        <div class="checkbox mb-3">
                            <label>
                                <input name="keep_signed" type="checkbox" value="1"
                                    <?php if ($form_data['keep_signed']) { ?>
                                        checked="checked"
                                    <?php } ?>
                                > Remember me
                            </label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                        <hr class="my-4">
                        <small class="text-body-secondary">
                            Don't have user? <a href="./sign-up.php">Sign up</a><br/>
                            <a href="./forgot-password.php">Forgot password?</a>
                        </small>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php include('parts/footer.php'); ?>
</body>
</html>