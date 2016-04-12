<?php

namespace BF\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChallengeEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleFR', 'text')
            ->add('titleEN', 'text')
            ->add('descriptionFR', 'textarea')
            ->add('descriptionEN', 'textarea')
            ->add('endDate', 'datetime')
            ->add('one', 'integer')
            ->add('two', 'integer')
            ->add('three', 'integer')
            ->add('four', 'integer')
            ->add('five', 'integer')
            ->add('six', 'text')
            ->add('partner','checkbox',array('required' => false))
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BF\SiteBundle\Entity\Challenge'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bf_sitebundle_challenge';
    }
}
