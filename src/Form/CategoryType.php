<?php

namespace App\Form;

use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Name
            ->add('name', TextType::class,[

                // label
                'label' => "Nom de la categorie",
                'label_attr' => [
                    'class' => "col-sm-3 col-form-label",
                ],

                // make it required
                'required' => true,

                // modifier attribut du champs
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Saisir le nom d'une categorie",
                ],

                // aide sur le champs
                'help' => "Merci de saisir le nom d'une categorie dans le champs",
                'help_attr' => [
                    'class' => "form-text text-muted",
                ],

                // contraintes du formulaire
                'constraints' => [
                    new NotBlank([
                        'message' => "le nom de la categorie est obligatoire",                 
                    ]),
                    new Length([
                        'max' => 80,
                        'maxMessage' => "le nom de la categorie est limité a {{ limit }} caracteres",
                    ]),
               ],
            ])

        // Couleur
        ->add('color', ColorType::class, [

            // label
            'label' => "Couleur de la categorie",
            'label_attr' => [
                'class' => "col-sm-3 col-form-label",
                ],

            // make it required
            'required' => false,

            // modifier attribut du champs
            'attr' => [
                'class' => "form-control",
                'placeholder' => "Saisir la couleur de la categorie",
            ],

            // aide sur le champs
            'help' => "Merci de saisir la couleur de la categorie dans le champs",
            'help_attr' => [
                'class' => "form-text text-muted",
            ],

            // contraintes du formulaire
            'constraints'=>[
                new Regex([
                   'pattern' => '/^#[\dA-Fa-f]{6}$/',
                   'message' => "Veuillez entrer une couleur valide",
                ]),
            ],   
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    
        $resolver->setDefaults([
            'data_class' => Category::class,

            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_category_token',
            'csrf_token_id' => '_csrf_category_token_id',
        ]);
    }
}
