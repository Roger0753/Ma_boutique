<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'merci de saisir votre prénom'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'merci de saisir votre nom'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'constraints' => new Length([
                'min' => 3,
                'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'merci de saisir votre adresse email'
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Votre sujet',
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'merci de saisir votre sujet'
                ],
            ])
            ->add('message', TextareaType::class,[
                'label' => 'votre message',
                'constraints' => new Length([
                    'min' => 5,
                    'max' => 500
                ]),
                'attr' => [
                    'placeholder' => 'merci de saisir votre message'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
