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

require_once('./includes/start-autoload.php');

use ThoPHPAuthorization\Service\HTTPService;
use ThoPHPAuthorization\Service\TemplatingService;

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
        'confirm_password' => HTTPService::getPostValue('confirm_password'),
        'first_name' => HTTPService::getPostValue('first_name'),
        'last_name' => HTTPService::getPostValue('last_name'),
        'birthday' => HTTPService::getPostValue('birthday'),
        'email' => HTTPService::getPostValue('email'),
        'phone' => HTTPService::getPostValue('phone'),
        'country' => HTTPService::getPostValue('country'),
        'state' => HTTPService::getPostValue('state'),
        'city' => HTTPService::getPostValue('city'),
        'address' => HTTPService::getPostValue('address'),
        'zip' => HTTPService::getPostValue('zip'),
    ];
    if (empty($form_data['name'])) {
        $errors['name'] = "Please enter user name.";
    }
    if (empty($form_data['password'])) {
        $errors['password'] = "Please enter user password.";
    }
    if (empty($form_data['confirm_password'])) {
        $errors['confirm_password'] = "Please confirm user password.";
    } elseif (!empty($form_data['password']) && $form_data['confirm_password'] !== $form_data['password']) {
        $errors['confirm_password'] = "Password and confirm password missmatch.";
    }
    if (empty($form_data['first_name'])) {
        $errors['first_name'] = "Please enter Your First name.";
    }
    if (empty($form_data['last_name'])) {
        $errors['last_name'] = "Please enter Your Last name.";
    }
    if (empty($form_data['email'])) {
        $errors['email'] = "Please enter Your email.";
    }
    if (empty($form_data['phone'])) {
        $errors['phone'] = "Please enter Your phone number.";
    }
    if (empty($form_data['country'])) {
        $errors['country'] = "Please enter Your Country.";
    }
    if (empty($form_data['state'])) {
        $errors['state'] = "Please enter Your State.";
    }
    if (empty($form_data['city'])) {
        $errors['city'] = "Please enter Your City.";
    }
    if (empty($form_data['address'])) {
        $errors['address'] = "Please enter Your address.";
    }
    if (empty($form_data['zip'])) {
        $errors['zip'] = "Please enter Your ZIP code.";
    }
    if (empty($errors)) {
        if ($user_service->signUp($form_data)) {
            $success = true;

            // Send admin email.
            $mail_data = [
                'subject' => 'New user',
                'text' => TemplatingService::readTemplateFile(realpath('./mail/new-user.txt'), $form_data),
                'html' => TemplatingService::readTemplateFile(realpath('./mail/new-user.html'), $form_data),
                'from' => SMTP_SENDER_EMAIL,
                'sender' => SMTP_SENDER_EMAIL,
                'receiver' => SMTP_ADMIN_EMAIL,
                'reply_to' => $form_data['email'],
            ];
            $mail_service->send($mail_data);

            // Send user email
            $mail_data = [
                'subject' => 'Your user has been created',
                'text' => TemplatingService::readTemplateFile(realpath('./mail/sign-up.txt'), $form_data),
                'html' => TemplatingService::readTemplateFile(realpath('./mail/sign-up.html'), $form_data),
                'from' => SMTP_SENDER_EMAIL,
                'sender' => SMTP_SENDER_EMAIL,
                'receiver' => $form_data['email'],
                'reply_to' => SMTP_REPLYTO_EMAIL,
                'attachment' => realpath('./mail/recipe.txt'),
            ];
            $mail_service->send($mail_data);
        } else {
            $errors['form'] = "Failed to create user or user with such name already exists.";
        }
    }
} else {
    $form_data = [
        'name' => '',
        'password' => '',
        'confirm_password' => '',
        'first_name' => '',
        'last_name' => '',
        'birthday' => '',
        'email' => '',
        'phone' => '',
        'country' => '',
        'state' => '',
        'city' => '',
        'address' => '',
        'zip' => '',
    ];
}

?>
<!DOCTYPE html>
<html>
<?php include('parts/head.php'); ?>
<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <?php if ($success) { ?>
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Thank you.</h1>
            <p class="col-lg-10 fs-4 mb-5">
                Your User was successfuly signed up! You can now sign in with it.
            </p>
            <a href="./index.php" class="btn btn-lg btn-primary">Sign in</a>
        <?php } else { ?>
            <div class="row g-lg-5 py-5">
                <div class="col-xl-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-4">Sign up</h1>
                    <?php include('parts/description.php'); ?>
                </div>
                <div class="col-md-10 mx-auto col-xl-6">
                    <form method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                        <?php if (isset($errors['form'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errors['form']; ?>
                            </div>
                        <?php } ?>
                        <div class="row gy-3 mb-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="name" type="text" class="form-control
                                        <?php if (isset($errors['name'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-name" placeholder="User name" value="<?= $form_data['name'] ?>">
                                    <label for="sign-up-name">User name</label>
                                    <?php if (isset($errors['name'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['name'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="password" type="password" class="form-control
                                        <?php if (isset($errors['password'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-password" placeholder="Password"
                                        value="<?= $form_data['password'] ?>">
                                    <label for="sign-up-password">Password</label>
                                    <?php if (isset($errors['password'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="confirm_password" type="password" class="form-control
                                        <?php if (isset($errors['confirm_password'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-confirm-password" placeholder="Confirm password"
                                        value="<?= $form_data['confirm_password'] ?>">
                                    <label for="sign-up-confirm-password">Confirm password</label>
                                    <?php if (isset($errors['confirm_password'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <input name="first_name" type="text" class="form-control
                                        <?php if (isset($errors['first_name'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-first-name" placeholder="First name"
                                        value="<?= $form_data['first_name'] ?>">
                                    <label for="sign-up-first-name">First name</label>
                                    <?php if (isset($errors['first_name'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['first_name'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <input name="last_name" type="text" class="form-control
                                        <?php if (isset($errors['last_name'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-last-name" placeholder="Last name"
                                        value="<?= $form_data['last_name'] ?>">
                                    <label for="sign-up-last-name">Last name</label>
                                    <?php if (isset($errors['last_name'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['last_name'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="birthday" type="text" class="form-control
                                        <?php if (isset($errors['birthday'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-birthday" placeholder="Birthday"
                                        value="<?= $form_data['birthday'] ?>">
                                    <label for="sign-up-birthday">Birthday</label>
                                    <?php if (isset($errors['birthday'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['birthday'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="email" type="email" class="form-control
                                        <?php if (isset($errors['email'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-email" placeholder="Email" value="<?= $form_data['email'] ?>">
                                    <label for="sign-up-email">Email</label>
                                    <?php if (isset($errors['email'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="phone" type="tel" class="form-control
                                        <?php if (isset($errors['phone'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-phone" placeholder="Phone number"
                                        value="<?= $form_data['phone'] ?>">
                                    <label for="sign-up-phone">Phone number</label>
                                    <?php if (isset($errors['phone'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <input name="country" type="text" class="form-control
                                        <?php if (isset($errors['country'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-country" placeholder="Country" value="<?= $form_data['country'] ?>">
                                    <label for="sign-up-country">Country</label>
                                    <?php if (isset($errors['country'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['country'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <input name="state" type="text" class="form-control
                                        <?php if (isset($errors['state'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-state" placeholder="State" value="<?= $form_data['state'] ?>">
                                    <label for="sign-up-state">State</label>
                                    <?php if (isset($errors['state'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['state'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <input name="city" type="text" class="form-control
                                        <?php if (isset($errors['city'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-city" placeholder="City" value="<?= $form_data['city'] ?>">
                                    <label for="sign-up-city">City</label>
                                    <?php if (isset($errors['city'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['city'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <input name="zip" type="text" class="form-control
                                        <?php if (isset($errors['zip'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-zip" placeholder="ZIP code" value="<?= $form_data['zip'] ?>">
                                    <label for="sign-up-zip">ZIP code</label>
                                    <?php if (isset($errors['zip'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['zip'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="address" type="text" class="form-control
                                        <?php if (isset($errors['address'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-address" placeholder="Address" value="<?= $form_data['address'] ?>">
                                    <label for="sign-up-address">Address</label>
                                    <?php if (isset($errors['address'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['address'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
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
    <?php include('parts/footer.php'); ?>
</body>
</html>