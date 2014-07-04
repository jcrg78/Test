<?
    namespace Test\ClickBus\CajeroBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Test\ClickBus\CajeroBundle\Entity\Cajero;
    use Test\ClickBus\CajeroBundle\Form\CajeroType;

    class CajeroController extends Controller
    {
        private $denominaciones = array(100, 50, 20, 10);

        public function indexAction()
        {
            $cajero = new Cajero();
            $form = $this->createForm(new CajeroType(), $cajero);

            $request = $this->get('request_stack')->getCurrentRequest();

            if ($request->getMethod() == 'POST') {
                $form->handleRequest($request);

                $retiro = $form->get('retiro')->getData();

                if ($form->isValid()) {

                    $this->get('session')->getFlashBag()->add('salida', $this->calcula_billetes($retiro));

                    return $this->redirect($this->generateUrl('cajero_homepage'));
                }
            }

            return $this->render('CajeroBundle:Default:index.html.twig', array(
                'form' => $form->createView()
            ));
        }

        protected function calcula_billetes($retiro){
            $salida=null;

            if($retiro==""){
                $salida=null;
            }elseif($retiro<=0){
                throw new \InvalidArgumentException('');

            }else{
                $ok=1;
                while ($ok==1 && list($key, $val) = each($this->denominaciones)) {
                    $div=(int)($retiro/$val);
                    if($div>0)
                        $sal_tmp[$val]=$div;
                    $retiro-=$div*$val;
                }
                if($retiro!=0){
                    throw new \Exception('NoteUnavailableException');
                }
            }

            if($sal_tmp){
                $salida="[";
                while(list($key, $val) = each($sal_tmp)) {
                    for($cant=1; $cant<=$val; $cant++)
                        $salida.=number_format($key, 2).", ";
                }
                $salida=substr($salida, 0, -2)."]";
            }

            return $salida;
        }
    }
?>