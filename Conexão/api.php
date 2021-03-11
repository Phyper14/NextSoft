<?php
//inclui a conexão com o banco de dados.
include('conection.php');

//exige uma chave na url para aceitar requisições na api
if(!array_key_exists('function', $_GET))
{
    echo 'Error. function missing.';
    exit;
}

$function = explode('/', $_GET['function']);
if(count($function) == 0 || $function[0] == "")
{
    echo 'Error. function missing.';
    exit;
}

//indica o conteúdo da aplicação, resgata o corpo da requisição e o método utilizado
header('Content-type: application/json');
$body = file_get_contents('php://input');
$method = $_SERVER['REQUEST_METHOD'];

//Funções de máscara para impedir a quebra do banco de dados e organizar o mesmo.
function Mask($mask,$str){

    $str = str_replace("-","",$str);
    $str = str_replace(" ","",$str);

    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }

    return $mask;

}

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

//Ativa se o método da requisição for GET
if($method === 'GET'){
    //Valida o valor da chave na url
    switch($function[0]){
        case "buscar":
            if(count($function) == 2)
            {
                if(!($function[1] == ""))
                {
                    //se a chave estiver correta, no caso o número do cpf de um usuario cadastrado.
                    if(strlen($function[1]) == 11)
                    {
                        //Valida no Banco de dados se existe um usuario com esse cpf e retorna os dados do mesmo ou uma mensagem de erro.
                        $cpf = Mask("###.###.###-##", $function[1]);
                        $querySelectUser = "select * from $tabelaUsuario where cpf = '$cpf'";
                        $selectUser = pg_query($conexao, $querySelectUser);
                        $resultUser = pg_fetch_row($selectUser);
                        $id = $resultUser[0];
                        $querySelectAddr = "select * from $tabelaEndereco where users_id = '$id'";
                        $selectAddr = pg_query($querySelectAddr);
                        $resultAddr = pg_fetch_all($selectAddr);

                        $dado = [
                            "id" => $resultUser[0],
                            "nome" => $resultUser[1],
                            "cpf" => $resultUser[2],
                            "email" => $resultUser[3],
                            "telefone" => $resultUser[4],
                            "enderecos" => $resultAddr
                        ];

                        $userData = json_encode($dado);
                        echo $userData;
                        exit;
                    }
                    else
                    {
                        echo "O cpf procurado está com quantidade de numeros errado";
                        exit;
                    }
                }
                else
                {
                    echo "Não foi inserido nenhum cpf.";
                }
            }
            else{
                echo "Numero de parametros esta errado.";
            }
        break;
        default:
            echo "Não existe essa função";
    }
}

//Aciona se o método da requisição for POST
if($method === 'POST'){
    //Valida a url e se a função e o metodo são POST
    switch($function[0]){
        case "post":
            //Transforma as variáveis do json da requisição em variáveis do script já adicionando as máscaras
            $fileBody = json_decode($body, true);
            $postCpf = Mask("###.###.###-##", $fileBody["cpf"]);
            $postNome = $fileBody["nome"] ;
            $postEmail = $fileBody["email"];
            $postTelefone = Mask("(##) #####-####", $fileBody["telefone"]);
    
            $enderecos = $fileBody["enderecos"];
            $tipocep = [];
            $cep = [];
            $uf = [];
            $cidade = []; 
            $bairro = [];
            $rua = [];
            $numero = [];
            $complemento = [];
    
            for($s = 0; $s < count($enderecos); $s++){
                $tipocep[$s] = $enderecos[$s]["tipo"];
                $cep[$s] = Mask("#####-###", $enderecos[$s]["cep"]);
                $uf[$s] = $enderecos[$s]["estado"];
                $cidade[$s] = tirarAcentos($enderecos[$s]["cidade"]); 
                $bairro[$s] = tirarAcentos($enderecos[$s]["bairro"]); 
                $rua[$s] = tirarAcentos($enderecos[$s]["rua"]);
                $numero[$s] = tirarAcentos($enderecos[$s]["numero"]);
                $complemento[$s] = tirarAcentos($enderecos[$s]["complemento"]);
            }

            //Verifica se já existe usuário com o cpf cadastrado, se sim, encerra e exibe uma mensagem de erro    
            $cpfQuery = "select cpf from $tabelaUsuario where cpf = '$postCpf'";
            $cpfProcura = pg_query($conexao, $cpfQuery);
            $cpfExiste  = pg_num_rows($cpfProcura);
            if($cpfExiste == 1){
                echo "usuario ja existe";
                exit;
            }
            
            //Insere na tabela de usuarios o usuário recebido
            $postQuery = "insert into ".$tabelaUsuario." (nome, cpf, email, telefone) values ('${postNome}','${postCpf}','${postEmail}','${postTelefone}') returning users_id";
            $postUsuario= pg_query($conexao, $postQuery) or die ('Não foi possível inserir informações na tabela de usuários.');
    
            $indexBusca = pg_query($conexao, 'select lastval()');
            $indexLinha = pg_fetch_row($indexBusca);
            $index = $indexLinha[0];
            $tamanho = count($cep);
            
            //Insere na tabela de endereços os endereços do usuário.
            for($x = 0; $x < $tamanho; $x++){
                $enderecoQuery = "insert into ".$tabelaEndereco." (tipo, cep, estado, cidade, bairro, rua, numero, complemento, users_id) values ('$tipocep[$x]','$cep[$x]','$uf[$x]','$cidade[$x]','$bairro[$x]','${rua[$x]}','$numero[$x]','$complemento[$x]','${index}')";
                $insereCep = pg_query($conexao, $enderecoQuery) or die ('Não foi possível inserir os dados de endereço na tabela de endereços.');
            }
            
            //exibe uma mensagem de sucesso e encerra a conexão.
            echo "Usuário $postNome Cadastrado com sucesso.";
            exit;
        break;
    }
}