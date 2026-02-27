<?php 

namespace App\Helper;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

class Utilities {

    public static function handleError(Form $form, string $key, string $message) {
        $form->get($key)->addError(
            new FormError($message)
        );
    }
}