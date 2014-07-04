<?

    namespace Test\ClickBus\OrdenamientoBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;

    class OrdenamientoType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('rango');
        }

        public function getName()
        {
            return 'clickbus_rango';
        }

        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setDefaults(array(
                                       'validation_groups' => false,
                                   ));
        }
    }
?>