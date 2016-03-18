<?php

namespace CDC\Loja\RH;

use PHPUnit_Framework_TestCase as PHPUnit;
use CDC\Loja\RH\CalculadoraDeSalario,
    CDC\Loja\RH\TabelaCargos;

class CalculadoraDeSalarioTest extends PHPUnit
{
    public function testCalculoSalarioDesenvolvedoresComSalarioAbaixoDoLimite()
    {
        $calculadora = new CalculadoraDeSalario();
        $desenvolvedor = new Funcionario("André", 1500.0, TabelaCargos::DESENVOLVEDOR);
        $salario = $calculadora->calculaSalario($desenvolvedor);
        $this->assertEquals(1500.0 * 0.9, $salario, null, 0.00001);
    } 
    
    public function testCalculoSalarioDesenvolvedoresComSalarioAcimaDoLimite()
    {
        $calculadora = new CalculadoraDeSalario();
        $desenvolvedor = new Funcionario("André", 4000.0, TabelaCargos::DESENVOLVEDOR);
        $salario = $calculadora->calculaSalario($desenvolvedor);
        $this->assertEquals(4000.00 * 0.8, $salario, null, 0.00001);
    } 
}