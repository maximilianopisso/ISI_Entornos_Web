<?php
class Calculadora
{
    private $numero1;
    private $numero2;

    public function __construct($numero1, $numero2)
    {
        $this->numero1 = $numero1;
        $this->numero2 = $numero2;
    }

    public function sumar()
    {
        return $this->numero1 + $this->numero2;
    }

    public function restar()
    {
        return $this->numero1 - $this->numero2;
    }

    public function multiplicar()
    {
        return $this->numero1 * $this->numero2;
    }

    public function dividir()
    {
        if ($this->numero2 == 0) {
            return ('Error: No se puede dividir entre cero.');
        }

        return $this->numero1 / $this->numero2;
    }
}
