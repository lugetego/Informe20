<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class EventosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Tipo de Solicitud',
                'choices'=>array(
                    'Comisión'=>'Comisión',
                    'Licencia'=>'Licencia',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
            ))
            ->add('tipoActividad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => '*Tipo de Actividad',
                'choices' => array(
                    'Asesoría Tesis' => 'Asesoría Tesis',
                    'Coloquio' => 'Coloquio',
                    'Conferencia' => 'Conferencia',
                    'Congreso' => 'Congreso',
                    'Curso' => 'Curso',
                    'Distinción Académica' => 'Distinción Académica',
                    'Feria' => 'Feria',
                    'Investigación' => 'Investigación',
                    'Jornadas' => 'Jornadas',
                    'Mesa redonda' => 'Mesa redonda',
                    'Reunión de trabajo' => 'Reunión de trabajo',
                    'Taller' => 'Taller',
                    'Seminario' => 'Seminario',
                    'Sinodal' => 'Sinodal'
                ),
                'placeholder' => 'Seleccionar',
                'required' => true,
            ))
            ->add('nombreEvento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Nombre del evento',
                'required'=>false,
            ))
            ->add('nacional', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Nacional'=>true,
                    'Internacional'=>false),
                'expanded'=>true,
                'required'=>true,
                'label'=>'*Ámbito de la actividad',
            ))
            ->add('invitacion', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Si'=>true,
                    'No'=>false),
                'expanded'=>true,
                'required'=>true,
                'label'=>'Por invitación',
            ))
            ->add('plenaria', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Si'=>true,
                    'No'=>false),
                'expanded'=>true,
                'required'=>true,
                'label'=>'Conferencia plenaria',
            ))
            ->add('sinodalAlumno', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Nombre del alumno',
                'required'=>false,
            ))
            ->add('sinodalGrado', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'Grado',
                'choices'=>array(
                    'Licenciatura'=>'Licenciatura',
                    'Maestría'=>'Maestría',
                    'Doctorado'=>'Doctorado',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>false,
            ))
            ->add('lugar', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Lugar',
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
                'years'=> range(2020,2020),
                'label'=>'Fecha de término',
                'required'=>true,
            ))

            ->add('motivo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Motivo de la Actividad',
                'choices'=>array(
                    'Asistencia'=>'Asistencia',
                    'Divulgación'=>'Divulgación',
                    'Participación'=>'Participación',
                    'Organización'=>'Organización',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
                'expanded'=>true,
                'multiple'=>true,

            ))
//            ->add('fin','Symfony\Component\Form\Extension\Core\Type\DateType',array(
//                'placeholder' => array(
//                    'year' => 'Año',
//                    'month' => 'Mes',
//                    'day' => 'Día'),
//                'years'=> range(2018,2018),
//                'label'=>'*Fin',
//                'required'=>true,
//            ))
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