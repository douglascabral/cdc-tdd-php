<?php

namespace CDC\Loja\RH;

use CDC\Loja\RH\Funcionario;
use CDC\Loja\RH\Cargo;

class CalculadoraDeSalario
{
    public function calculaSalario(Funcionario $funcionario)
    {
        $cargo = new Cargo($funcionario->getCargo());
        return $cargo->getRegra()->calcula($funcionario);
    }
}