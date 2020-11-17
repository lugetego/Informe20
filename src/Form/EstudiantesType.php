<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class EstudiantesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('programas', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Programa',
                'choices'=>array(
                    'PCCM'=>'PCCM',
                    'Otro'=>'Otro',
                ),
                // *this line is important*
                'placeholder' => 'Seleccionar',
                'mapped'=> false,
                'required'=>true,
            ))
            ->add('nivel', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Nivel',
                'choices'=>array(
                    'Doctorado'=>'Doctorado',
                    'Licenciatura'=>'Licenciatura',
                    'Maestría'=>'Maestría',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
            ))
            ->add('tesis', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Tesis dirigidas o en proceso',
                'required'=>false,
            ))
            ->add('alumno', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Nombre del alumno',
                'required'=>true,
            ))
            ->add('avance', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Porcentaje de avance',
                'required'=>true,
                'choices'=>array(
                    '0'=>'0',
                    '10'=>'10',
                    '20'=>'20',
                    '30'=>'30',
                    '40'=>'40',
                    '50'=>'50',
                    '60'=>'60',
                    '70'=>'70',
                    '80'=>'80',
                    '90'=>'90',
                    '100'=>'100'),
                'placeholder'=>'Seleccionar',
            ))
            ->add('titulado', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Si'=>true,
                    'No'=>false ),
                'expanded'=>true,
                'required'=>true,
                'label'=>'*Estudiante titulado',
            ))
            ->add('titulacion','Symfony\Component\Form\Extension\Core\Type\DateType',array(
                'placeholder' => array(
                    'year' => 'Año',
                    'month' => 'Mes',
                    'day' => 'Día'),
                'years'=> range(2020,2024),
                'label'=>'Fecha de titulación',
                'required'=>false,
            ))
            ->add('programa',TextType::class,
                array('label' => 'Otro programa',
                       'attr' => ['read_only'=> true],
            ))
        ;

        $formModifier = function (FormInterface $form, $otro) {

            if ( 'Otro' == $otro) {
                $form->add('nivel', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Programa',
                ));
            }
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getPrograma());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                // this would be your entity, i.e. SportMeetup

                $data = $event->getData();
                if (isset($data['programas'])){

                    $val = $data['programas'];
                    if ( $val !='Otro') {
                        $data['programa'] = $val;
                        $event->setData($data);
                    }
                }
                else {
                    $data['programas']='';
                }
            }
        );

        $builder->get('programas')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $sport = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!

                $formModifier($event->getForm()->getParent(),$sport);

            }
        );

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Estudiantes'
        ));
    }
}