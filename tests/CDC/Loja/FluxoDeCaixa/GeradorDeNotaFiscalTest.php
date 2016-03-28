<?php
namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\Test\TestCase;
use CDC\Loja\FluxoDeCaixa\GeradorDeNotaFiscal;
use \Mockery;
use \DateTime;
use CDC\Exemplos\RelogioDoSistema;

class GeradorDeNotaFiscalTest extends TestCase
{
    /*public function testDeveGerarNFComValorDeImpostoDescontado()
    {
        $gerador = new GeradorDeNotaFiscal();
        $pedido = new Pedido("André", 1000, 1);
        
        $nf = $gerador->gera($pedido);
        
        $this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
    } */
    
    /*public function testDevePersistirNFGerada()
    {
        $dao = Mockery::mock("CDC\Loja\FluxoDeCaixa\NFDao");
        $dao->shouldReceive("executa")->andReturn(true);
     
        $sap = Mockery::mock("CDC\Loja\FluxoDeCaixa\SAP");
        $sap->shouldReceive("executa")->andReturn(true);
        
        $relogio = Mockery::mock("CDC\Exemplos\RelogioInterface");
        $relogio->shouldReceive("hoje")->andReturn(new DateTime());
        
        $gerador = new GeradorDeNotaFiscal(array($dao, $sap), $relogio);
        $pedido = new Pedido("André", 1000, 1);
        
        $nf = $gerador->gera($pedido);
        
        $this->assertTrue($dao->executa($nf));
        $this->assertTrue($sap->executa($nf));
        $this->assertNotNull($nf);
        $this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
    }*/
    
    public function testDeveConsultarATabelaParaCalcularValor()
    {
        //mockando uma tabela
        $tabela = Mockery::mock("CDC\Loja\Tributos\TabelaInterface");
        
        //defininfo o futuro comportamento "paraValor", 
        //que deve retornar 0.2 caso o valor seja 1000.00
        $tabela->shouldReceive("paraValor")->with(1000.0)->andReturn(0.2);
        
        $gerador = new GeradorDeNotaFiscal(array(), new RelogioDoSistema(), $tabela);
        $pedido = new Pedido("Andre", 1000.0, 1);
        
        $nf = $gerador->gera($pedido);
        
        //garantindo que a tabela foi consultada
        $this->assertEquals(1000 * 0.8, $nf->getValor(), null, 0.00001);
        
    }
}