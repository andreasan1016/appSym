<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Header;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("user_to", EntityType::class, [
                'class'=>User::class,
                'choices'=>$builder->getData()->getMessage()->getUserFrom()->getAllFriends(),
                'choice_label' => 'username',
                'multiple'=>false,
                'mapped'=>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Header::class,
        ]);
    }
}
