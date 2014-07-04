<?
    namespace Test\ClickBus\OrdenamientoBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Test\ClickBus\OrdenamientoBundle\Entity\Ordenamiento;
    use Test\ClickBus\OrdenamientoBundle\Form\OrdenamientoType;

    class OrdenamientoController extends Controller
    {
        private $lista = array(10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131 , -9 , -10);
//        private $lista = array(10, 1, 'A',  14, 99, 133, 19, 20, 117, 22, 93,  120, 131);

        public function indexAction()
        {
            $bloques=null;

            $ordenamiento = new Ordenamiento();
            $form = $this->createForm(new OrdenamientoType(), $ordenamiento);

            $request = $this->get('request_stack')->getCurrentRequest();

            if ($request->getMethod() == 'POST') {
                $form->handleRequest($request);

                $rango = $form->get('rango')->getData();

                if ($form->isValid()) {
                    $bloques = $this->crea_bloques($rango);
                    $bloques_ordenados = $this->ordena_bloques($bloques);
                    $final = $this->ordena_contenido($bloques_ordenados, $bloques);

                    $this->get('session')->getFlashBag()->add('salida', $this->crea_salida($final));
                    return $this->redirect($this->generateUrl('ordenamiento_homepage'));
                }
            }

            return $this->render('OrdenamientoBundle:Default:index.html.twig', array(
                'form' => $form->createView(),
                'lista'=> implode(',', $this->lista)
            ));
        }

        protected function crea_salida($bloques_ordenados){
            $salida="";

            while (list($key, $val) = each($bloques_ordenados)){
                $salida.="[".implode(',', $val)."], ";
            }
            $salida="{".substr($salida, 0, -2)."}";

            return $salida;
        }

        protected function ordena_contenido($bloques_ordenados, $bloques){
            while (list($key, $val) = each($bloques_ordenados)){
                $contenido_ordenado[$key]=$this->ordenamiento_burbuja($bloques[$val], sizeof($bloques[$val]));
//                $salida.="[".implode(',', $contenido_ordenado)."], ";
            }
//            $salida="{".substr($salida, 0, -2)."}";
            return $contenido_ordenado;

        }

        protected function ordena_bloques($bloques){

            while (list($key, $val) = each($bloques)) {
                $indices[]=$key;
            }

            return $this->ordenamiento_burbuja($indices,sizeof($indices));
        }


        protected function crea_bloques($rango){
            $bloques=null;

            // Creo bloques
            while (list($key, $val) = each($this->lista)) {
                if(!is_numeric($val)){
                    throw new \InvalidArgumentException('');
                }

                $indice=(int)($val / $rango);

                if($indice==0){
                    $indice = ($val>0)?1:-1;
                }else{
                    if($val>0)
                        $indice++;
                    else
                        $indice--;

                    if($val % $rango == 0){
                        if($val>0)
                            $indice--;
                        else
                            $indice++;
                    }
                }

                $bloques[$indice][]=$val;
            }

            return $bloques;
        }

        protected function ordenamiento_burbuja($A,$n){
            for($i=1;$i<$n;$i++){
                for($j=0;$j<$n-$i;$j++){
                    if($A[$j]>$A[$j+1]){
                        $k=$A[$j+1];
                        $A[$j+1]=$A[$j];
                        $A[$j]=$k;
                    }
                }
            }
            return $A;
        }

    }
?>