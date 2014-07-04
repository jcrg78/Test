<?

    namespace Test\ClickBus\CajeroBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;

    class CajeroType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('retiro');
        }

        public function getName()
        {
            return 'clickbus_cajero';
        }

        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setDefaults(array(
                                       'validation_groups' => false,
                                   ));
        }
    }
?>