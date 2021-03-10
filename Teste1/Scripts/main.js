const btnAddEndereco = document.querySelector('.addendereco');
const btnRemoveEndereco = document.querySelector('.removeendereco');
const endereco = document.querySelector('.enderecos');
let index = 2;
let ident = 1;

function addEndereco() {
    const item = document.createElement('div');
    const dentro = `
    <div class="field">
                    <label for="tipocep">Endereço ${index}</label>
                    <select id="tipocep" name="tipocep[${ident}]">
                    <option value="residencial">Residencial</option>
                    <option value="comercial">Comercial</option>
                    <option value="entrega">Entrega</option>
                    <option value="geral">Geral</option>
                </select>
                </div>
                <div class="field">
                    <label for="cep">CEP</label>
                    <input type="text" class="cep" id="${index}" name="cep[${ident - 1}]" onfocusout="buscaCep(this)" required minlength="9" maxlength="9" placeholder="00000-000">
                </div>
                <div class="field">
                    <label for="uf">Estado</label>
                    <select class="uf ${index}" name="uf[${ident - 1}]">
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
                </div>
                <div class="field">
                    <label for="cidade">Cidade</label>
                    <input type="text" class="cidade ${index}" name="cidade[${ident}]" required>
                </div>
                <div class="field">
                    <label for="bairro">Bairro</label>
                    <input type="text" class="bairro ${index}" name="bairro[${ident}]" required>
                </div>
                <div class="field">
                    <label for="rua">Rua</label>
                    <input type="text" class="rua ${index}" name="rua[${ident}]" required>
                </div>
                <div class="fiel">
                    <label for="numero">Número</label>
                    <input type="text" class="numero ${index}" name="numero[${ident}]" required>
                </div>
                <div class="field">
                    <label for="complemento">Complemento</label>
                    <input type="text" class="complemento ${index}" name="complemento[${ident}]" placeholder="OPICIONAL">
                </div>
    `;

    console.log(index);

    item.classList.add('item');
    item.innerHTML = dentro;
    endereco.appendChild(item);
    console.log('ola');
    index++;
    ident++;
}

function removeEndereco() {
    if (endereco.childElementCount > 1) {
        endereco.removeChild(endereco.lastChild);
        index--;
    }
}

btnRemoveEndereco.addEventListener("click", removeEndereco);
btnAddEndereco.addEventListener("click", addEndereco);