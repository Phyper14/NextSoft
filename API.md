# Utilizando a API
Para utilizar a API é necessário usar sua url, no projeto é "../api.php"

A API tem uma chave na url chamada "function" que precisar estar presente com algum valor.

## Acessando Dados
Para fazer uma requisição de dados é necessário utilizar a função "buscar" com o o cpf do usuário a ser acessado, usando o método GET:
"../api.php?function=buscar/*CPF DO USUARIO*

A requisição irá retornar um arquivo json como a seguir:


{
    "nome": "Nome do Usuario",
    "cpf": "999.999.999-99",
    "email": "email.usuario@email.com",
    "telefone": "(99) 9999-9999",
    "enderecos": [{
            "tipo": "residencial",
            "cep": "99999-999",
            "estado": "SP",
            "cidade": "Sao Paulo",
            "bairro": "Centro",
            "rua": "Rua 1",
            "numero": "345",
            "complemento": "Ao lado da loja"
        }
    ]
}

## Cadastrando uma pessoa
O cadastramento é feito a partir da url:
"../api.php?function=post"

No corpo da requisição é necessário os dados do usuário:
{
    "nome": "Nome",
    "cpf": "###.###.###-##",
    "email": "email@email.com",
    "telefone": "(##) ####-####",
    "enderecos": [{
            "tipo": "residencial",
            "cep": "#####-###",
            "estado": "SP",
            "cidade": "Sao Paulo",
            "bairro": "Centro",
            "rua": "Rua Vermelha",
            "numero": "46",
            "complemento": ""
        }
    ]
}

Apenas o item "complemento" é opcional.
Deve ser usado máscaras nos dados, pois não é permitido dados numéricos sem a correta formatação ou acentos e caracteres especiais.