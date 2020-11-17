<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('investigacion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Actividades de investigación',
                'required'=>false,
            ))
            ->add('estudiantes', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Estudiantes',
                'required'=>false,
            ))
            ->add('posdocs', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Posdocs',
                'required'=>false,
            ))
            ->add('cursos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Cursos',
                'required'=>false,
            ))
            ->add('proyectos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Proyectos',
                'required'=>false,
            ))
            ->add('eventos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Eventos',
                'required'=>false,
            ))
            ->add('visitantes', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Visitantes',
                'required'=>false,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Plan'
        ));
    }
}