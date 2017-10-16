<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthpersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('accountId')
             
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults(array(
            'data_class' => 'Andre\Thelittlefoxesclub\ContactBundle\Entity\Authperson',
        ));
    }



    public function getName()
    {
        return 'contact_authperson';
    }
}
