<?php

namespace ForumBundle\Form;

use ForumBundle\Entity\Categories;
use ForumBundle\Entity\Question;
use ForumBundle\Form\Type\TagsType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
            ->add('description', CKEditorType::class, array(
                'base_path' => 'ckeditorQuestion',
                'js_path'   => 'ckeditorQuestion/ckeditor.js',))

            ->add('type')
            ->add('Categories',EntityType::class,array(
                'class'=>'ForumBundle:Categories',
                'choice_label'=>'cname',
                'multiple'=>false
            ))
            ->add('tags', TagsType::class)

            ->add('submit',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ForumBundle\Entity\Question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'forumbundle_question';
    }


}
