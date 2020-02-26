<?php

namespace ActivityBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('place')
            ->add('type',ChoiceType::class,
                [
                    'choices'  => [
                        'dailyscrum' => 'dailyscrum' ,
                        'sprint review' => 'sprintreview',
                        'sprint retrospective' => 'sprint retrospective',
                    ],
                ])
            ->add('meetingDate', DateTimeType::class, [
                'placeholder' => 'Select a value',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,
            ]])
            ->add('sprint', EntityType::class,array(
                'class'=>'SprintBundle:Sprint',
                'choice_label'=>'name',
                'multiple'=>false
            ))
            ->add('submit',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ActivityBundle\Entity\Meetings'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'activitybundle_meetings';
    }


}
