<?php

namespace AppBundle\Form;

use AppBundle\Products\Command\NewProductCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class Product
 */
class Product extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form_product.name',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'form_product.description',
                'required' => true,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Min 100 chars'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'form_product.price',
                'required' => true,
                'scale' => 2,
                'attr' => [
                    'placeholder' => '0.00'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'form_product',
            'data_class' => NewProductCommand::class
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'product';
    }
}