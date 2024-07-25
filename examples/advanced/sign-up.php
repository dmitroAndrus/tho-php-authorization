<?php

/**
 * This file contains example of advanced user authorization.
 * php version 7.4
 *
 * Sign up user form.
 *
 * Form fields:
 * * User name
 * * Password
 * * Confirm password
 * * First name
 * * Last name
 * * Email
 * * Phone
 * * Birthday
 * * Country
 * * State
 * * City
 * * Zip code
 * * Address
 *
 * @category GenericExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

require_once('./includes/start-autoload.php');

use ThoPHPAuthorization\Service\HTTPService;
use ThoPHPAuthorization\Service\TemplatingService;

// Get active user.
$user = $user_service->getActiveUser();

// If there is active user - redirect to index.php page.
if ($user) {
    HTTPService::redirectToPage(URL_PATH . 'index.php');
}

// Sign up result.
$success = false;
// Sign up errors.
$errors = [];

$form_id = 'sign-up-form';

// Check if sing up form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'name' => HTTPService::getPostValue('name'),
        'password' => HTTPService::getPostValue('password'),
        'confirm_password' => HTTPService::getPostValue('confirm_password'),
        'first_name' => HTTPService::getPostValue('first_name'),
        'last_name' => HTTPService::getPostValue('last_name'),
        'birthday' => HTTPService::getPostValue('birthday'),
        'email' => HTTPService::getPostValue('email'),
        'phone' => HTTPService::getPostValue('phone'),
        'emails' => HTTPService::getPostValue('emails'),
        'phones' => HTTPService::getPostValue('phones'),
        'addresses' => HTTPService::getPostValue('addresses'),
    ];
    // Validate form data.
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
    if (!empty($form_data['emails'])) {
        foreach ($form_data['emails'] as $key => $additional) {
            $additional_errors = [];
            if (empty($additional['type'])) {
                $additional_errors['type'] = "Please enter Your email type.";
            }
            if (empty($additional['email'])) {
                $additional_errors['email'] = "Please enter Your email.";
            }
            if (!empty($additional_errors)) {
                $errors['emails'][$key] = $additional_errors;
            }
        }
    }
    if (empty($form_data['phone'])) {
        $errors['phone'] = "Please enter Your phone number.";
    }
    if (!empty($form_data['phones'])) {
        foreach ($form_data['phones'] as $key => $additional) {
            $additional_errors = [];
            if (empty($additional['type'])) {
                $additional_errors['type'] = "Please enter Your phone type.";
            }
            if (empty($additional['phone'])) {
                $additional_errors['phone'] = "Please enter Your phone.";
            }
            if (!empty($additional_errors)) {
                $errors['phones'][$key] = $additional_errors;
            }
        }
    }
    if (!empty($form_data['addresses'])) {
        foreach ($form_data['addresses'] as $key => $additional) {
            $additional_errors = [];
            if (empty($additional['type'])) {
                $additional_errors['type'] = "Please enter address type.";
            }
            if (empty($additional['country'])) {
                $additional_errors['country'] = "Please enter Country.";
            }
            if (empty($additional['state'])) {
                $additional_errors['state'] = "Please enter State.";
            }
            if (empty($additional['city'])) {
                $additional_errors['city'] = "Please enter City.";
            }
            if (empty($additional['zip'])) {
                $additional_errors['zip'] = "Please enter ZIP code.";
            }
            if (empty($additional['address'])) {
                $additional_errors['address'] = "Please enter address.";
            }
            if (!empty($additional_errors)) {
                $errors['addresses'][$key] = $additional_errors;
            }
        }
    }
    if (empty($form_data['birthday'])) {
        $errors['birthday'] = "Please enter Your Birthday.";
    }
    // If there were no errors - try to sign up user.
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
            // Sign up failed.
            $errors['form'] = "Failed to create user or user with such name already exists.";
        }
    }
} else {
    // Set default form data.
    $form_data = [
        'name' => '',
        'password' => '',
        'confirm_password' => '',
        'first_name' => '',
        'last_name' => '',
        'birthday' => '',
        'email' => '',
        'phone' => '',
        'emails' => '',
        'phones' => [],
        'addresses' => [],
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
                    <form id="<?= $form_id ?>" method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
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
                                        id="<?= $form_id ?>-password" placeholder="Password"
                                        value="<?= $form_data['password'] ?>">
                                    <label for="<?= $form_id ?>-password">Password</label>
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
                                        id="<?= $form_id ?>-confirm-password" placeholder="Confirm password"
                                        value="<?= $form_data['confirm_password'] ?>">
                                    <label for="<?= $form_id ?>-confirm-password">Confirm password</label>
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
                                        id="<?= $form_id ?>-first-name" placeholder="First name"
                                        value="<?= $form_data['first_name'] ?>">
                                    <label for="<?= $form_id ?>-first-name">First name</label>
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
                                        id="<?= $form_id ?>-last-name" placeholder="Last name"
                                        value="<?= $form_data['last_name'] ?>">
                                    <label for="<?= $form_id ?>-last-name">Last name</label>
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
                                        id="<?= $form_id ?>-birthday" placeholder="Birthday"
                                        value="<?= $form_data['birthday'] ?>"
                                        data-flatpickr>
                                    <label for="<?= $form_id ?>-birthday">Birthday</label>
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
                                        id="<?= $form_id ?>-email" placeholder="Email" value="<?= $form_data['email'] ?>">
                                    <label for="<?= $form_id ?>-email">Email</label>
                                    <?php if (isset($errors['email'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <?php
                                    $field = [
                                        'id' => $form_id . '-emails',
                                        'name' => 'emails',
                                    ];
                                    $field_values = $form_data['emails'];
                                    $field_errors = isset($errors['emails']) ? $errors['emails'] : [];
                                    ?>
                                <?php include('parts/form-emails.php'); ?>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="phone" type="tel" class="form-control
                                        <?php if (isset($errors['phone'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="<?= $form_id ?>-phone" placeholder="Phone number"
                                        value="<?= $form_data['phone'] ?>">
                                    <label for="<?= $form_id ?>-phone">Phone number</label>
                                    <?php if (isset($errors['phone'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <?php
                                    $field = [
                                        'id' => $form_id . '-phones',
                                        'name' => 'phones',
                                    ];
                                    $field_values = $form_data['phones'];
                                    $field_errors = isset($errors['phones']) ? $errors['phones'] : [];
                                    ?>
                                <?php include('parts/form-phones.php'); ?>
                            </div>
                            <div class="col-12">
                                <fieldset class="mb-3">
                                    <?php
                                        $additional_address = isset($form_data['addresses']['main'])
                                            ? $form_data['addresses']['main']
                                            : [
                                                'type' => '',
                                                'country' => '',
                                                'state' => '',
                                                'city' => '',
                                                'zip' => '',
                                                'address' => '',
                                            ];
                                        ?>
                                    <div class="row gy-3">
                                        <input type="hidden" name="addresses[main][type]" value="@main"/>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-floating">
                                                <input name="addresses[main][country]" type="text" class="form-control
                                                    <?php if (isset($errors['addresses']['main']['country'])) { ?>
                                                        is-invalid
                                                    <?php } ?>"
                                                    id="<?= $form_id ?>-addresses-2-country" placeholder="Country"
                                                    value="<?= $additional_address['country'] ?>">
                                                <label for="<?= $form_id ?>-addresses-2-country">Country</label>
                                                <?php if (isset($errors['addresses']['main']['country'])) { ?>
                                                    <div class="invalid-feedback"><?= $errors['addresses']['main']['country'] ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-floating">
                                                <input name="addresses[main][state]" type="text" class="form-control
                                                    <?php if (isset($errors['addresses']['main']['state'])) { ?>
                                                        is-invalid
                                                    <?php } ?>"
                                                    id="<?= $form_id ?>-addresses-2-state" placeholder="State"
                                                    value="<?= $additional_address['state'] ?>">
                                                <label for="<?= $form_id ?>-addresses-2-state">State</label>
                                                <?php if (isset($errors['addresses']['main']['state'])) { ?>
                                                    <div class="invalid-feedback"><?= $errors['addresses']['main']['state'] ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-floating">
                                                <input name="addresses[main][city]" type="text" class="form-control
                                                    <?php if (isset($errors['addresses']['main']['city'])) { ?>
                                                        is-invalid
                                                    <?php } ?>"
                                                    id="<?= $form_id ?>-addresses-2-city" placeholder="City"
                                                    value="<?= $additional_address['city'] ?>">
                                                <label for="<?= $form_id ?>-addresses-2-city">City</label>
                                                <?php if (isset($errors['addresses']['main']['city'])) { ?>
                                                    <div class="invalid-feedback"><?= $errors['addresses']['main']['city'] ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-floating">
                                                <input name="addresses[main][zip]" type="text" class="form-control
                                                    <?php if (isset($errors['addresses']['main']['zip'])) { ?>
                                                        is-invalid
                                                    <?php } ?>"
                                                    id="<?= $form_id ?>-addresses-2-zip" placeholder="ZIP code"
                                                    value="<?= $additional_address['zip'] ?>">
                                                <label for="<?= $form_id ?>-addresses-2-zip">ZIP code</label>
                                                <?php if (isset($errors['addresses']['main']['zip'])) { ?>
                                                    <div class="invalid-feedback"><?= $errors['addresses']['main']['zip'] ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input name="addresses[main][address]" type="text" class="form-control
                                                    <?php if (isset($errors['addresses']['main']['address'])) { ?>
                                                        is-invalid
                                                    <?php } ?>"
                                                    id="<?= $form_id ?>-addresses-2-address" placeholder="Address"
                                                    value="<?= $additional_address['address'] ?>">
                                                <label for="<?= $form_id ?>-addresses-2-address">Address</label>
                                                <?php if (isset($errors['addresses']['main']['address'])) { ?>
                                                    <div class="invalid-feedback"><?= $errors['addresses']['main']['address'] ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <?php
                                    $field = [
                                        'id' => $form_id . '-addresses',
                                        'name' => 'addresses',
                                    ];
                                    $field_values = $form_data['addresses'];
                                    if (isset($field_values['main'])) {
                                        unset($field_values['main']);
                                    }
                                    $field_errors = isset($errors['addresses']) ? $errors['addresses'] : [];
                                    ?>
                                <?php include('parts/form-addresses.php'); ?>
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