<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
            ])
            ->add('description')
            ->add('price', null, [
                'label' => 'Prix',
            ])
            // ->add('createdAt')
            ->add('startAt', null, [
                'label' => 'Date de début',
                'years' => range(2021, 2031),
            ])
            ->add('endAt', null, [
                'label' => 'Date de fin',
                'years' => range(2021, 2031),
            ])
            ->add('poster')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
