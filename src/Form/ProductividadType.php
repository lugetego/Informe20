<?php

namespace App\Form;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\Academico;
use App\Entity\Productividad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ProductividadType extends AbstractType
{


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $options['user'];

        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder

            ->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Tipo de publicación',
                'choices'=>array(
                    'Artículo'=>'article',
                    'Capítulo de Libro'=>'incollection',
                    'Editor Memorias de Congreso'=>'proceedings',
                    'Libro'=>'book',
                    'Memoria de Congreso'=>'inproceedings',
                    'Preprint'=>'preprint',
                    'Tesis'=>'thesis'),
                'placeholder'=>'Seleccionar',
                'required'=>true,
//                'choices_as_values' => true,
            ))

            ->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Título',
                'required'=>true,
            ))
            ->add('autores', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Autores',
                'required'=>true,
            ))
            ->add('year', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Año',
                'choices'=>array(
                    '2020'=>'2020',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
//                'choices_as_values' => true,
            ))
            ->add('pags', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'*Páginas',
                'required'=>true,
            ))
            ->add('volumen', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Volumen',
                'required'=>false,
            ))
            ->add('numero', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Número',
                'required'=>false,
            ))
            ->add('status', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Status',
                'choices'=>array(
                    'Aceptado'=>'Aceptado',
                    'Enviado'=>'Enviado',
                    'Publicado'=>'Publicado',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
//                'choices_as_values' => true,
            ))
            ->add('issn', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'ISSN',
                'required'=>false,
            ))
            ->add('proyectos', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Proyectos relacionados',
                'required'=>false,
            ))
            ->add('indizado', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Si'=>true,
                    'No'=>false),
                'expanded'=>true,
                'required'=>true,
                'label'=>'Indizado',
//                'choices_as_values' => false,
            ))
            ->add('revista', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                'label'=>'Revista',
                'required'=>false,
            ))
            /* ->add('autor',null, array(
                 'class' => 'InformeBundle\Entity\Academico',
                 'label' => 'Autor',
                 'read_only'=>'true',
                 'required'=>true,
                 'disabled'  => false,
                 'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                     return $er->createQueryBuilder('q')
                         ->select('r')
                         ->from('InformeBundle\Entity\Academico', 'r')
                         ->leftjoin('r.user','a')
                         ->where('a.id = :id')
                         ->setParameter('id', $user->getId())
                         ;}, 'data' => ($user->getAcademico()->getAutor())))
 */
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Productividad',
            'user' => null,
        ));
    }
}