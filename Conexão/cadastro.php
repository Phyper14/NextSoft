<?php
//inclui a nossa conexão do banco de dados
include('conection.php');

//relaciona as variáveis do formulário a variáveis usáveis.
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$tipocep = $_POST['tipocep'];
$cep = $_POST['cep'];
$uf = $_POST['uf'];
$cidade = $_POST["cidade"];
$bairro = $_POST["bairro"];
$rua = $_POST["rua"];
$numero = $_POST["numero"];
$complemento = $_POST["complemento"];

// verifica se o cpf já existe na base de dados, 
// caso exista encerra o programa, exibe um alerta e redireciona para pagina principal
$cpfQuery = "select cpf from teste3 where cpf = '${cpf}'";
$cpfProcura = pg_query($conexao, $cpfQuery);
$cpfExiste  = pg_num_rows($cpfProcura);
if($cpfExiste == 1){
    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('O CPF: ${CPF} JÁ ESTÁ CADASTRADO!')
        window.location.href='../index.html';
        </SCRIPT>"
    );
    exit;
}

//Insere as informações do usuário na tabela de usuários
$query = "insert into ".$tabelaUsuario." (nome, cpf, email, telefone) values ('${nome}','${cpf}','${email}','${telefone}') returning users_id";
$insere = pg_query($conexao, $query) or die ('Não foi possível inserir informações na tabela de usuários.');

//Busca o valor de users_id para usar referenciar na tabela de endereços.
$idBusca = pg_query($conexao, 'select lastval()');
$idLinha = pg_fetch_row($idBusca);
$id = $idLinha[0];
$tamanho = count($cep);

echo "Numero de CEPs: ${tamanho} \n\n";
echo "Numero do id agora: ${id} \n\n";


//insere as informações dos endereços do usuário na tabela de endereços.
//referenciando a tabela de usuários
for($x = 0; $x < $tamanho; $x++){
    $enderecoQuery = "insert into ".$tabelaEndereco." (tipo, cep, estado, cidade, bairro, rua, numero, complemento, users_id) values ('$tipocep[$x]','$cep[$x]','$uf[$x]','$cidade[$x]','$bairro[$x]','${rua[$x]}','$numero[$x]','$complemento[$x]','${id}')";
    echo nl2br("\n $enderecoQuery \n");
    $insereCep = pg_query($conexao, $enderecoQuery) or die ('Não foi possível inserir os dados de endereço na tabela de endereços.');
    echo nl2br("Valor de x: ${x} Valor do Cep: $cep[$x] \n");
    echo nl2br("${enderecoQuery} \n");
}

echo "sucesso";
echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('O USUÁRIO $nome FOI CADASTRADO!')
        window.location.href='../index.html';
        </SCRIPT>"
);
exit;
?>