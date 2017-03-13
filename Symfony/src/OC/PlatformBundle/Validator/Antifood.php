<?php

namespace OC\PlatformBundle\Validator;

use SYmfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antiflood extends Constraints {
    public $message = "Vous avez déjà posté un message il y a moins de 15 secondes, merci d'attendre un peu.";
}