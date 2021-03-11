//Script para adicionar máscaras nos inputs para evitar a quebra do banco de dados e para maior organização do mesmo


const telefone = document.querySelector('.telefone');
const cpf = document.querySelector('.cpf');
const rua = document.getElementsByClassName('.rua');

var maskBehavior = function(val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

function telMask(tel) {
    $(tel).mask(maskBehavior(tel.value), options);
}

function cepMask(cep) {
    $(cep).mask('99999-999');
}

function cpfMask(cpf) {
    $(cpf).mask('999.999.999-99');
}

function removeChar(texto) {
    let removido = texto.replace(/'/g, ' ');
    texto = removido.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    return texto;
}

telefone.addEventListener('onfocus', telMask(telefone));
cpf.addEventListener('onfocus', cpfMask(cpf));