//Código retirado de https://velhobit.com.br/programacao/carregando-cep-cidades-dinamicamente.html
//Usaddo com JQuery para autocompletar o preenchimento do endereço com o cep

function buscaCep(cep) {
    let id = cep.id;

    console.log($(`.rua.${id}`));

    $.ajax({
        url: 'https://viacep.com.br/ws/' + cep.value + '/json/unicode/',

        dataType: 'json',

        success: function(resposta) {
            console.log("sucesso");
            console.log(`O valor do id ta em ${id} na resposta`);
            console.log(`.rua#${id}`);
            $(`.rua.${id}`).val(resposta.logradouro);
            $(`.complemento.${id}`).val(resposta.complemento);
            $(`.bairro.${id}`).val(resposta.bairro);
            $(`.cidade.${id}`).val(resposta.localidade);
            $(`.uf.${id}`).val(resposta.uf);

            $(`.numero.${id}`).focus();
        }
    });
}


$(".cep").focusout(function() {
    let id = $(this).prop('id');
    console.log("ola");
    console.log(`O id tá em ${index - 1} no começo`);

});