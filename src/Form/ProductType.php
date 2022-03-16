<?php

namespace App\Form;

use App\Entity\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Title
            ->add('title', TextType::class, [
               
                // label
                'label' => "Nom du produit",
                'label_attr' => [
                    'class' => "col-sm-3 col-form-label",
                ],

                // make it required
                'required' => true,

                // modifier attribut du champs
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Saisir le prix du produit",
                ],

                // aide sur le champs
                'help' => "Merci de saisir le prix du produit dans le champs",
                'help_attr' => [
                    'class' => "form-text text-muted",
                ],

                // contraintes du formulaire
                'constraints' => [
                    new NotBlank([
                        'message' => "le prix du produit est obligatoire",                 
                    ]),
                    new Length([
                        'max' => 120,
                        'maxMessage' => "le prix du produit est limité a {{ limit }} caracteres",
                    ]),
               ],
            ])

            // Description
            ->add('description', TextareaType::class, [

                // label
                'label' => "Description du produit",
                'label_attr' => [
                    'class' => "col-sm-3 col-form-label",
                    ],

                // make it required
                'required' => false,

                // modifier attribut du champs
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Saisir la description du produit",
                ],

                // aide sur le champs
                'help' => "Merci de saisir la description du produit dans le champs",
                'help_attr' => [
                    'class' => "form-text text-muted",
                ],

                // contraintes du formulaire
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 80,
                        'minMessage' => "la description du produit est limité a {{ limit }}  10 caractères minimum",                 
                        'maxMessage' => "la description du produit est limité a {{ limit }}  80 caractères minimum",                        
                    ]),
                ]
            ])

            // Price
            ->add('price', MoneyType::class, [

                // label
                'label' => "Prix du produit",
                'label_attr'=> [
                    'class' => "col-sm-3 col-form-label",
                ],

                // make it required
                'required' => true,

                // modifier attribut du champs
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Saisir le prix du produit",
                ],

                // aide sur le champs
                'help' => "Merci de saisir le prix du produit dans le champs",
                'help_attr' => [
                    'class' => "form-text text-muted",
                ],
                
                // contraintes du formulaire
                'currency' => "USD",
                'html5' => true,
                'constraints' => [
                    new Length([
                        'max' => 5,
                        'maxMessage' => "le prix est limité a {{ limit }}  5 caractères maximum",                 
                    ]),
                ]
            ])

            // ajout du form Pizza
            // ->add('superpizza', PizzaType::class,[
            //     'mapped' => false
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,

            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_product_token',
            'csrf_token_id' => '_csrf_product_token_id',
        ]);
    }
}
