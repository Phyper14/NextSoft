CREATE TABLE usuarios (
    users_id SERIAL,
    nome VARCHAR (200) NOT NULL,
    cpf VARCHAR (50) NOT NULL,
    email VARCHAR (200) NOT NULL,
    telefone VARCHAR (50) NOT NULL,
    PRIMARY KEY (users_id),
    UNIQUE (cpf)
);

CREATE TABLE enderecos (
    enderecos_id SERIAL,
    users_id INTEGER REFERENCES usuarios (users_id),
    tipo VARCHAR (100) NOT NULL,
    cep VARCHAR (50) NOT NULL,
    estado VARCHAR (2) NOT NULL,
    cidade VARCHAR (200) NOT NULL,
    bairro VARCHAR (200) NOT NULL,
    rua VARCHAR (200) NOT NULL,
    numero VARCHAR (50) NOT NULL,
    complemento VARCHAR (200),
    PRIMARY KEY (enderecos_id)
);