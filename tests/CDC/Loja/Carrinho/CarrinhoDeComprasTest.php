<?php
namespace CDC\Loja\Carrinho;

use CDC\Loja\Test\TestCase;
use CDC\Loja\Carrinho\CarrinhoDeCompras;
use CDC\Loja\Produto\Produto;

class CarrinhoDeComprasTest extends TestCase
{
    public function testDeveRetornarZeroSeCarrinhoVazio()
    {
        $carrinho = new CarrinhoDeCompras();
        $valor = $carrinho->maiorValor();
        $this->assertEquals(0, $valor, null, 0.0001);
    } 
    
    public function testDeveRetornarValorDoItemSeCarrinhoCom1Elemento()
    {
        $carrinho = new CarrinhoDeCompras();
        $carrinho->adiciona(new Produto("Geladeira", 900.00));
        $valor = $carrinho->maiorValor();
        $this->assertEquals(900.00, $valor, null, 0.0001);
    }
    
    public function testDeveRetornarMaiorValorSeCarrinhoComMuitosItens()
    {
        $carrinho = new CarrinhoDeCompras();
        $carrinho->adiciona(new Produto("Torradeira", 120.00));
        $carrinho->adiciona(new Produto("Geladeira", 900.00));
        $carrinho->adiciona(new Produto("Fogão", 450.00));
        $valor = $carrinho->maiorValor();
        $this->assertEquals(900.00, $valor, null, 0.0001);
    }
}