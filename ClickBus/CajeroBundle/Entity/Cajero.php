<?
    namespace Test\ClickBus\CajeroBundle\Entity;

    class Cajero
    {
        protected $retiro;

        public function getRetiro()
        {
            return $this->retiro;
        }

        public function setRetiro($retiro)
        {
            $this->$retiro = $retiro;
        }

  }
?>