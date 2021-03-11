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

            $(`.rua.${id}`).val(removeChar(resposta.logradouro));
            $(`.complemento.${id}`).val(removeChar(resposta.complemento));
            $(`.bairro.${id}`).val(removeChar(resposta.bairro));
            $(`.cidade.${id}`).val(removeChar(resposta.localidade));
            $(`.uf.${id}`).val(removeChar(resposta.uf));

            $(`.numero.${id}`).focus();
        }
    });
}