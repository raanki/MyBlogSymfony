<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormConfigBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormConfigBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextareaType::class, [
           'label' => 'Votre message',
        ]);

        $builder->add('article', HiddenType::class, [
        ]);

        $builder->add('send', SubmitType::class, [
            'label' => 'Envoyer',
        ]);

        $builder->get('article')->addModelTransformer(new CallbackTransformer(
            fn (Article $article) => $article->getId(),
            fn (Article $article) => $article->getTitle(),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }

}