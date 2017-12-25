<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookUpdateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('publicationDate', TextType::class)
            ->add('ISBNNumber', TextType::class)
            ->add('imageFile', FileType::class)
            ->add('genre', EntityType::class, [
                'class' => 'App:Genre',
            ])
            ->add('author', EntityType::class, [
                'class' => 'App:Author',
            ])
            ->add('language', EntityType::class, [
                'class' => 'App:Language',
            ]);

        $builder->get('publicationDate')
            ->addModelTransformer(new DateTimeToStringTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Book::class,
            'csrf_protection'    => false,
            'allow_extra_fields' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'book';
    }
}