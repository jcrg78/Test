<?
    namespace Test\ClickBus\OrdenamientoBundle\Entity;

    class Ordenamiento
    {
        protected $rango;

        public function getRango()
        {
            return $this->rango;
        }

        public function setRango($rango)
        {
            $this->$rango = $rango;
        }

  }
?>