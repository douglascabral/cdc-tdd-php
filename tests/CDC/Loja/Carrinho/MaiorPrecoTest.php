<?php
namespace CDC\Loja\Carrinho;

use CDC\Loja\Test\TestCase;
use CDC\Loja\Carrinho\CarrinhoDeCompras;
use CDC\Loja\Carrinho\MaiorPreco;
use CDC\Loja\Produto\Produto;

class MaiorPrecoTest extends TestCase
{
    public function testDeveRetornarZeroSeCarrinhoVazio()
    {
        $carrinho = new CarrinhoDeCompras();
        
        $algoritmo = new MaiorPreco();
        
        $valor = $algoritmo->encontra($carrinho);
        
        $this->assertEquals(0, $valor, null, 0.0001);
    }
    
    public function testDeveRetornarValorDoItemSeCarrinhoTiver1Elemento()
    {
        $carrinho = new CarrinhoDeCompras();
        $carrinho->adiciona(new Produto("Geladeira", 900.00));
        
        $algoritmo = new MaiorPreco();
        
        $valor = $algoritmo->encontra($carrinho);
        
        $this->assertEquals(900.00, $valor, null, 0.0001);
    }
    
    public function testDeveRetornarOMaiorValorCasoTenhaMuitosItens()
    {
        $carrinho = new CarrinhoDeCompras();
        $carrinho->adiciona(new Produto("Fogão", 400.00));
        $carrinho->adiciona(new Produto("Geladeira", 900.00));
        $carrinho->adiciona(new Produto("Torradeira", 150.00));
        
        $algoritmo = new MaiorPreco();
        
        $valor = $algoritmo->encontra($carrinho);
        
        $this->assertEquals(900.00, $valor, null, 0.0001);
    }
}