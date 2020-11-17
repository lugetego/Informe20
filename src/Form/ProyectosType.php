<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class ProyectosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipos', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Programa',
                'choices'=>array(
                    'CONACYT'=>'CONACYT',
                    'PAEP'=>'PAEP',
                    'PAPIME'=>'PAPIME',
                    'PAPIIT'=>'PAPIIT',
                    'Otro'=>'Otro'
                ),
                // *this line is important*
//                'choices_as_values' => true,
                'placeholder' => 'Seleccionar',
                'label'=>'*Tipo de programa',
                'mapped'=> false,
            ))
            ->add('tipo','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Otro tipo de proyecto',
            ))
            ->add('nombre', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Nombre del proyecto',
                'required'=>true,
            ))
            ->add('numero', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Número del proyecto',
                'required'=>true,
            ))
            ->add('inicio','Symfony\Component\Form\Extension\Core\Type\DateType',array(
                'placeholder' => array(
                    'year' => 'Año',
                    'month' => 'Mes',
                    'day' => 'Día'),
                'years'=> range(2016,2020),
                'label'=>'Fecha de inicio',
                'empty_data' => null,
                'required'=>false,
            ))
            ->add('fin','Symfony\Component\Form\Extension\Core\Type\DateType',array(
                'placeholder' => array(
                    'year' => 'Año',
                    'month' => 'Mes',
                    'day' => 'Día'),
                'years'=> range(2020,2024),
                'label'=>'Fecha de término',
                'empty_data' => null,
                'required'=>false,
            ))
        ;

        $formModifier = function (FormInterface $form, $otro) {

            if ( 'Otro' == $otro) {
                $form->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Tipo',
                ));
            }
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getTipo());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                // this would be your entity, i.e. SportMeetup

                $data = $event->getData();
                if (isset($data['tipos'])){

                    $val = $data['tipos'];
                    if ( $val !='Otro') {
                        $data['tipo'] = $val;
                        $event->setData($data);
                    }
                }
                else {
                    $data['tipos']='';
                }
            }
        );

        $builder->get('tipos')->addEventListener(
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
            'data_class' => 'App\Entity\Proyectos'
        ));
    }
}