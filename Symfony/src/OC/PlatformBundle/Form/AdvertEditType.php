<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvertEditType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $option) {
        $builder->remove('date');
    }
    
    public function getParent() {
        return AdvertType::class;
    }
    
}

