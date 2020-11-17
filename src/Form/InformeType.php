<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enviado', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Si'=>true,
                    'No'=>false),
                'expanded'=>true,
                'required'=>true,
                'label'=>'Informe y plan de trabajo enviados',
            ))
            ->add('dictamen', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'Dictamen',
                'choices'=>array(
                    'Aprobado'=>'Aprobado',
                    'Aprobado con observaciones'=>'Aprobado con observaciones',
                    'No aprobado'=>'No aprobado',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>false,
            ))
            ->add('observaciones', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Observaciones',
                'required'=>false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Informe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_informe';
    }


}