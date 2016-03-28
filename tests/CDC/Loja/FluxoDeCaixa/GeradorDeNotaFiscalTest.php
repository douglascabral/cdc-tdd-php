<?php
namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\Test\TestCase;
use CDC\Loja\FluxoDeCaixa\GeradorDeNotaFiscal;
use \Mockery;

class GeradorDeNotaFiscalTest extends TestCase
{
    /*public function testDeveGerarNFComValorDeImpostoDescontado()
    {
        $gerador = new GeradorDeNotaFiscal();
        $pedido = new Pedido("André", 1000, 1);
        
        $nf = $gerador->gera($pedido);
        
        $this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
    } */
    
    public function testDevePersistirNFGerada()
    {
        $dao = Mockery::mock("CDC\Loja\FluxoDeCaixa\NFDao");
        $dao->shouldReceive("executa")->andReturn(true);
     
        $sap = Mockery::mock("CDC\Loja\FluxoDeCaixa\SAP");
        $sap->shouldReceive("executa")->andReturn(true);
        
        $gerador = new GeradorDeNotaFiscal(array($dao, $sap));
        $pedido = new Pedido("André", 1000, 1);
        
        $nf = $gerador->gera($pedido);
        
        $this->assertTrue($dao->executa($nf));
        $this->assertTrue($sap->executa($nf));
        $this->assertNotNull($nf);
        $this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
    }
}