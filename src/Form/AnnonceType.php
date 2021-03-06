<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Tag;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\AdressType;
class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // le $builder nous permet de construire le formulaire
        $builder
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('price', MoneyType::class, [
                'divisor' => 100
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'status.0' => Annonce::STATUS_VERY_BAD,
                    'status.1' => Annonce::STATUS_BAD,
                    'status.2' => Annonce::STATUS_GOOD,
                    'status.3' => Annonce::STATUS_VERY_GOOD,
                    'status.4' => Annonce::STATUS_PERFECT
                ]
            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'allow_add' => true,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('address', AddressAutoCompleteType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
            'translation_domain' => 'annonce'
        ]);
    }
}
