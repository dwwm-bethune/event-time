<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
            ])
            ->add('description', TextareaType::class)
            ->add('price', null, [
                'label' => 'Prix',
            ])
            // ->add('createdAt')
            ->add('startAt', null, [
                'label' => 'Date de début',
                'years' => range(2022, 2032),
            ])
            ->add('endAt', null, [
                'label' => 'Date de fin',
                'years' => range(2022, 2032),
            ])
            ->add('posterFile', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'constraints' => [
                    new File(maxSize: '4096k', mimeTypes: ['image/jpg', 'image/jpeg', 'image/png']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
