<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class EventSearchType
 *
 * @package App\Form
 */
class EventSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'employeeName',
            TextType::class,
            [
                'label'    => 'Employee Name',
                'mapped'   => false,
                'required' => false,
            ]
        )
            ->add(
                'eventName',
                TextType::class,
                [
                    'label'    => 'Event Name',
                    'mapped'   => false,
                    'required' => false,
                ]
            )
            ->add(
                'fromDate',
                DateType::class,
                [
                    'label'    => 'From Date',
                    'mapped'   => false,
                    'required' => false,
                ]
            )
            ->add(
                'toDate',
                DateType::class,
                [
                    'label'    => 'To Date',
                    'mapped'   => false,
                    'required' => false,
                ]
            );
    }

}
