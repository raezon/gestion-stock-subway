<?php
namespace App\Form;

use App\Entity\Ingrediant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class IngredientQuantityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ingredient', EntityType::class, [
                'class' => Ingrediant::class,
                'choice_label' => 'name',
                'placeholder' => 'Select an ingredient',
                'label' => 'Ingredient'
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Quantity'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // No data class here as this is a collection of embedded forms
        $resolver->setDefaults([
            'validation_groups' => false, // Disable validation groups
        ]);
    }
}