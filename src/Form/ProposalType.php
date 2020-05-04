<?php

namespace App\Form;

use App\Entity\Proposal;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProposalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('economic', CKEditorType::class, [
                'label' => 'Économie',
                'label_attr' => [
                    'class' => 'wysiwyg-label'
                ]
            ])
            ->add('juridic', CKEditorType::class, [
                'label' => 'Droit',
                'label_attr' => [
                    'class' => 'wysiwyg-label'
                ]
            ])
            ->add('environmental', CKEditorType::class, [
                'label' => 'Environnement',
                'label_attr' => [
                    'class' => 'wysiwyg-label'
                ]
            ])
            ->add('education', CKEditorType::class, [
                'label' => 'Éducation',
                'label_attr' => [
                    'class' => 'wysiwyg-label'
                ]
            ])
            ->add('cultural', CKEditorType::class, [
                'label' => 'Culture',
                'label_attr' => [
                    'class' => 'wysiwyg-label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposal::class,
        ]);
    }
}
