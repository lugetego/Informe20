<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class VisitantesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label'=>'Título',
                'placeholder'=>'Seleccionar',
                'required'=>true,
                'choices'=>array(
                    'Dr.'=>'Dr.',
                    'Dra.'=>'Dra.',
                    'Est.'=>'Est.',
                    'Lic.' => 'Lic.',
                    'Mat.'=>'Mat.',
                    'M.C.'=>'M.C.',
                    'Sr.'=>'Sr.',
                    'Sra.'=>'Sra.',
                ),
            ))
            ->add('lugar', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Lugar (ciudad, estado, país de origen)',
                'required'=>true,
            ))
            ->add('departamento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Departamento',
                'required'=>true,
            ))
            ->add('institucion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Institución',
                'required'=>true,
            ))
            ->add('nombreEvento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Nombre del evento',
                'required'=>true,
            ))
            ->add('anfitrion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Nombre del invitado',
                'required'=>true,
            ))

            ->add('fechaInicio','Symfony\Component\Form\Extension\Core\Type\DateType',array(
                'placeholder' => array(
                    'year' => 'Año',
                    'month' => 'Mes',
                    'day' => 'Día'),
                'years'=> range(2020,2020),
                'label'=>'Fecha de inicio',
                'required'=>true,
            ))
            ->add('fechaFin','Symfony\Component\Form\Extension\Core\Type\DateType',array(
                'placeholder' => array(
                    'year' => 'Año',
                    'month' => 'Mes',
                    'day' => 'Día'),
                'years'=> range(2020,2020   ),
                'label'=>'Fecha de término',
                'required'=>true,
            ))
            ->add('nacional', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Nacional'=>true,
                    'Internacional'=>false),
                'expanded'=>true,
                'required'=>true,
                'label'=>'Ámbito de la actividad',
            ))
            ->add('tipoActividad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Tipo de la Actividad',
                'choices'=>array(
                    'Coloquio CCM'=>'Coloquio CCM',
                    'Coloquio PCCM'=>'Coloquio PCCM',
                    'Congreso'=>'Congreso',
                    'Curso'=>'Curso',
                    'Simposio'=>'Simposio',
                    'Divulgación'=>'Divulgación',
                    'Investigación'=>'Investigación',
                    'Seminario'=>'Seminario',
                    'Sinodal'=>'Sinodal',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
                'expanded'=>false,
            ))
            ->add('tituloTrabajo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Título del trabajo',
                'required'=>false,
            ))
            ->add('observaciones', 'Symfony\Component\Form\Extension\Core\Type\TextareaType',array(
                'label'=>'Observaciones',
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
            'data_class' => 'App\Entity\Eventos'
        ));
    }

    /**
     * @return array
     */
    private function getPropositoChoice()
    {
        return array(
            'Coloquio'=>'Coloquio',
            'Conferencia'=>'Conferencia',
            'Congreso'=>'Congreso',
            'Curso'=>'Curso',
            'Distinción'=>'Distinción',
            'Feria'=>'Feria',
            'Investigación'=>'Investigación',
            'Jornadas'=>'Jornadas',
            'Mesa redonda'=>'Mesa redonda',
            'Reunión de trabajo'=>'Reunión de trabajo',
            'Taller'=>'Taller',
            'Seminario'=>'Seminario',
            'Sinodal'=>'Sinodal'
        );
    }
}