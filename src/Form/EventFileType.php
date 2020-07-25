<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class EventFileType
 *
 * @package App\Form
 */
class EventFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'eventsFile',
            FileType::class,
            [
                'label'       => 'Event File',
                'mapped'      => false,
                'required'    => true,
                'constraints' => [
                    new File(
                        [
                            'mimeTypes'        => [
                                'application/json',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid json file',
                        ]
                    ),
                ],
            ]
        );
    }

}
