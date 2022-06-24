<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Topic;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'widget-form'
                ],
                'label' => 'Titre'
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'widget-form'
                ],
                'label' => 'Contenu'
            ])
            // ->add('published_date')
            // ->add('slug')
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
                },
                'attr' => [
                    'class' => 'widget-form'
                ],
                'label' => 'Auteur'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function(Category $category) {
                    return $category->getTitle();
                },
                'attr' => [
                    'class' => 'widget-form'
                ],
                'label' => 'Catégorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
