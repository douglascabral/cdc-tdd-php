<?php
namespace CDC\Loja\Persistencia;

use CDC\Loja\Test\TestCase;
use CDC\Loja\Persistencia\ConexaoComBancoDeDados;
use CDC\Loja\Persistencia\ProdutoDAO;
use CDC\Loja\Produto\Produto;
use PDO;

class ProdutoDAOTest extends TestCase
{
    
    private $conexao;
    
    protected function setUp()
    {
        parent::setUp();
        
        if ( file_exists("test.db") ) unlink("test.db");
        $this->conexao = new PDO("sqlite:test.db");
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->criaTabela();
    }
    
    protected function criaTabela()
    {
        $sqlString = "CREATE TABLE produto ";
        $sqlString .= "(id INTEGER PRIMARY KEY, descricao TEXT, ";
        $sqlString .= "valor_unitario TEXT, status TINYINT(1) );";
        
        $this->conexao->query($sqlString);
    }
    
    protected function tearDown()
    {
        parent::tearDown();
        
        $this->conexao = null;
        unlink("test.db");
    }
    
    public function testDeveAdicionarUmProduto()
    {
        //$conexao = (new ConexaoComBancoDeDados())->getConexao();
        $conexao = $this->conexao;
        $produtoDAO = new ProdutoDAO($conexao);
        $produto = new Produto("Geladeira", 150.0);    
      
        //Sobrescrevendo a conexão para continuar trabalhando
        //sobre a mesma já instanciada
        $conexao = $produtoDAO->adiciona($produto);
        
        //buscando pelo id para
        //ver se está igual o produto do cenário
        $salvo = $produtoDAO->porId($conexao->lastInsertId());
        
        $this->assertEquals(
            $salvo['descricao'], 
            $produto->getNome()
        );
        
        $this->assertEquals(
            $salvo['valor_unitario'],
            $produto->getValorUnitario()
        );
        
        $this->assertEquals(
            $salvo['status'],
            1
        );
    } 
    
    public function testDeveFiltrarAtivos()
    {
        $produtoDAO = new ProdutoDAO($this->conexao);
        
        $ativo = new Produto("Geladeira", 150.0, 1);
        $inativo = new Produto("Geladeira", 180.0, 1);
        $inativo->inativa();
        
        $produtoDAO->adiciona($ativo);
        $produtoDAO->adiciona($inativo);
        
        $produtosAtivos = $produtoDAO->ativos();
        
        $this->assertEquals(1, count($produtosAtivos));
        $this->assertEquals(150.0, $produtosAtivos[0]['valor_unitario']);
    }
}