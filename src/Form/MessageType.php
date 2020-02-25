<?php

namespace App\Form;

use App\Entity\Friendship;
use App\Entity\Message;
use App\Entity\Header;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject')
            ->add('content')
            ->add("user_to", EntityType::class, [
                'class'=>Friendship::class,
                'choices'=>$builder->getData()->getUserFrom()->getFriendships(),
                'multiple'=>false,
                'mapped'=>false,
            ])
            //->add('user_to', ChoiceType::class,['choices'=>[new User('user1')],["choice_value"=>'id'],["choice_label"=> function(?User $user){return $user ? strtoupper($user->getUsername()): '';}]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
