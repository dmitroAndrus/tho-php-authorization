<?php

/**
 * This file contains example of advanced user authorization.
 * php version 7.4
 *
 * Edit signed in user details.
 *
 * Form fields:
 * * First name
 * * Last name
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

// If there is no active user - redirect to index.php page.
if (!$user) {
    HTTPService::redirectToPage(URL_PATH . 'index.php');
}

// Current active tab.
$active_tab = 'edit-details';
// Edit form result.
$success = false;
// Edit form errors.
$errors = [];

$form_id = 'edit-user-details-form';

function getUserFormData($user_obj)
{
    $data = [
        'first_name' => $user_obj->getFirstName(),
        'last_name' => $user_obj->getLastName(),
        'birthday' => $user_obj->getBirthday('Y-m-d'),
        'emails' => [],
        'phones' => [],
        'addresses' => [],
    ];
    $emails = $user_obj->getEmails();
    if ($emails) {
        foreach ($emails as $item) {
            $data['emails'][] = [
                'type' => $item->getType(),
                'email' => $item->getEmail(),
            ];
        }
    }
    $phones = $user_obj->getPhones();
    if ($phones) {
        foreach ($phones as $item) {
            $data['phones'][] = [
                'type' => $item->getType(),
                'phone' => $item->getPhone(),
            ];
        }
    }
    $addresses = $user_obj->getAddresses();
    if ($addresses) {
        foreach ($addresses as $item) {
            $item_data = [
                'type' => $item->getType(),
                'country' => $item->getCountry(),
                'state' => $item->getState(),
                'city' => $item->getCity(),
                'address' => $item->getAddress(),
                'zip' => $item->getZIP(),
            ];
            if ($item_data['type'] === '@main' && !isset($data['addresses']['main'])) {
                $data['addresses']['main'] = $item_data;
            } else {
                $data['addresses'][] = $item_data;
            }
        }
    }
    return $data;
}

// Check if form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'first_name' => HTTPService::getPostValue('first_name'),
        'last_name' => HTTPService::getPostValue('last_name'),
        'emails' => HTTPService::getPostValue('emails'),
        'phones' => HTTPService::getPostValue('phones'),
        'addresses' => HTTPService::getPostValue('addresses'),
        'birthday' => HTTPService::getPostValue('birthday'),
    ];
    // Validate form data.
    if (empty($form_data['first_name'])) {
        $errors['first_name'] = "Please enter Your First name.";
    }
    if (empty($form_data['last_name'])) {
        $errors['last_name'] = "Please enter Your Last name.";
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
    // If there were no errors - try to edit user.
    if (empty($errors)) {
        if ($user_service->edit($user, $form_data)) {
            $success = true;
            // Renew form data.
            $form_data = getUserFormData($user);
        } else {
            // User edit failed failed.
            $errors['form'] = "Failed to edit user.";
        }
    }
} else {
    // Set default form data.
    $form_data = getUserFormData($user);
}

?>
<!DOCTYPE html>
<html>
<?php include('parts/head.php'); ?>
<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <?php include('parts/user-tabs.php'); ?>
        <div>
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Edit user details</h1>
            <form id="<?= $form_id ?>" method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                <?php if ($success) { ?>
                    <div class="alert alert-success" role="alert">
                        Changes have been saved
                    </div>
                <?php } ?>
                <?php if (isset($errors['form'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errors['form']; ?>
                    </div>
                <?php } ?>
                <div class="row gy-3 mb-3">
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
                <button class="btn btn-lg btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
    <?php include('parts/footer.php'); ?>
</body>
</html>