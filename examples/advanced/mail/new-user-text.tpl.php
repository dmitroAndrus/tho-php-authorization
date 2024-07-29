<?php

/**
 * This file contains email template for new user.
 * php version 7.4
 *
 * @category AdvancedExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

?>
User name: <?= $data['name'] ?>
First name: <?= $data['first_name'] ?>
Last name: <?= $data['last_name'] ?>
Birthday: <?= $data['birthday'] ?>
E-mail: <?= $data['email'] ?>
<?php
if (!empty($data['emails'])) {
    foreach ($data['emails'] as $item) {
        ?>
E-mail (<?= $item['type']; ?>): <?= $item['email']; ?>
        <?php
    }
}
?>
Phone: <?= $data['phone'] ?>
<?php
if (!empty($data['phones'])) {
    foreach ($data['phones'] as $item) {
        ?>
Phone (<?= $item['type']; ?>): <?= $item['phone']; ?>
        <?php
    }
}
?>
<?php
if (!empty($data['addresses'])) {
    foreach ($data['addresses'] as $item) {
        ?>
Address (<?= $item['type']; ?>)
    Country: <?= $item['country'] ?>
    State: <?= $item['state'] ?>
    City: <?= $item['city'] ?>
    Address: <?= $item['address'] ?>
    Zip code: <?= $item['zip'] ?>
        <?php
    }
}
?>