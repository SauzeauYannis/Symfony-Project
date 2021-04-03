<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifiant', TextType::class,
                    ['label' => 'Identifiant']) //vérifiez qu'il n'est pas déjà pris
            ->add('motdepasse', PasswordType::class,
                    ['label' => 'Mot de passe']) // hashez le mdp avec sh1
            ->add('nom', TextType::class,
                    ['label' => 'Nom'])
            ->add('prenom', TextType::class,
                    ['label' => 'Prénom'])
            ->add('anniversaire', DateType::class,
                    ['label' => 'Date de naissance', 'years' => range(date('Y') - 100, date('Y') - 1)]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
