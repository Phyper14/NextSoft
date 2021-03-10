<?php
include('conection.php');

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$tipocep = $_POST['tipocep'];
$cep = $_POST['cep'];
$uf = $_POST['uf'];
$cidade = $_POST['cidade'];
$bairro = $_POST['bairro'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];

$cpfQuery = "select cpf from teste3 where cpf = '${cpf}'";
$cpfProcura = pg_query($conexao, $cpfQuery);
$cpfExiste  = pg_num_rows($cpfProcura);
// if($cpfExiste == 1){
//     echo ("<SCRIPT LANGUAGE='JavaScript'>
//         window.alert('O CPF: ${CPF} JÁ ESTÁ CADASTRADO!')
//         window.location.href='../index.html';
//         </SCRIPT>"
//     );
//     exit;
// }

$query = "insert into teste3 (nome, cpf, email, telefone) values ('${nome}','${cpf}','${email}','${telefone}') returning id";
$insere = pg_query($conexao, $query) or die ('Deu Merda cambada');
$idBusca = pg_query($conexao, 'select lastval()');
$idLinha = pg_fetch_row($idBusca);
$id = $idLinha[0];
$tamanho = count($cep);

echo "Numero de CEPs: ${tamanho} \n\n";
echo "Numero do id agora: ${id} \n\n";

for($x = 0; $x < $tamanho; $x++){
    $enderecoQuery = "insert into testeenderecos (tipo, cep, estado, cidade, bairro, rua, numero, complemento, teste_id) values ('$tipocep[$x]','$cep[$x]','$uf[$x]','$cidade[$x]','$bairro[$x]','$rua[$x]','$numero[$x]','$complemento[$x]','${id}')";
    echo pg_last_error($conexao);
    $insereCep = pg_query($conexao, $enderecoQuery) or die ('Deu muito ruim');
    echo nl2br("Valor de x: ${x} \n");
    echo nl2br("${enderecoQuery} \n");
}

echo 'sucesso';
?>