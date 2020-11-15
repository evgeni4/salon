<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use function Sodium\add;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['required' => false, 'empty_data' => '',])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Моля, въведете парола',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Паролата Ви трябва да е минимум {{ limit }} знака',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'type' => PasswordType::class,
                'invalid_message' => 'Паролите не съвпадат.',
                'first_options' => array('label' => 'Парола'),
                'second_options' => array('label' => 'Потвърди парола')
            ])
        ->add('firstName', TextType::class,
            [
                'required' => false,
                'empty_data' => '',
                'label'=>'Име',
                ]
        )
        ->add('lastName', TextType::class, ['required' => false, 'empty_data' => '','label'=>'Фамилия']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
