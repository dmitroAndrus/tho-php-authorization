<?php

/**
 * This file contains example of advanced user authorization.
 * php version 7.4
 *
 * Output sign in form, or user details for signed in users.
 *
 * @category GenericExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

require_once('./includes/start-autoload.php');

use ThoPHPAuthorization\Service\HTTPService;

// Get active user.
$user = $user_service->getActiveUser();

// If there is no active user - set sign in form data.
if (!$user) {
    // Form errors.
    $errors = [];
    // Check if form was submited.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data from the POST request.
        $form_data = [
            'identity' => HTTPService::getPostValue('identity'),
            'password' => HTTPService::getPostValue('password'),
            'keep_signed' => !!HTTPService::getPostValue('keep_signed'),
        ];
        // Validate form data.
        if (empty($form_data['identity'])) {
            $errors['identity'] = "Please enter user name, email or phone number.";
        }
        if (empty($form_data['password'])) {
            $errors['password'] = "Please enter user password.";
        }
        // If there were no errors - try to authorize user.
        if (empty($errors)) {
            if ($user_service->authorize($form_data['identity'], $form_data['password'], $form_data['keep_signed'])) {
                // Get active user.
                $user = $user_service->getActiveUser();
            } else {
                // Authorization failed.
                $errors['form'] = "User with such name or password doesn't exists.";
            }
        }
    } else {
        // Set default form data.
        $form_data = [
            'identity' => '',
            'password' => '',
            'keep_signed' => false,
        ];
    }
}
if ($user) {
    // Set active tab.
    $active_tab = 'details';
}

?>
<!DOCTYPE html>
<html>
<?php include('parts/head.php'); ?>
<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <?php if ($user) { ?>
            <?php include('parts/user-tabs.php'); ?>
            <div>
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
                    <?php $additional_emails = $user->getEmails() ?>
                    <?php if ($additional_emails) { ?>
                        <?php foreach ($additional_emails as $item) { ?>
                            Email (<?= $item->getType() ?>): <strong><?= $item->getEmail() ?></strong><br/>
                        <?php } ?>
                    <?php } ?>
                    Phone: <strong><?= $user->getPhone() ?></strong><br/>
                    <?php $additional_phones = $user->getPhones() ?>
                    <?php if ($additional_phones) { ?>
                        <?php foreach ($additional_phones as $item) { ?>
                            Phone (<?= $item->getType() ?>): <strong><?= $item->getPhone() ?></strong><br/>
                        <?php } ?>
                    <?php } ?>
                    <?php $addresses = $user->getAddresses() ?>
                    <?php if ($addresses) { ?>
                        <?php foreach ($addresses as $item) { ?>
                            Address (<?= $item->getType() ?>): <strong><?= $item->getFullAddress() ?></strong><br/>
                        <?php } ?>
                    <?php } ?>
                </p>
            </div>
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