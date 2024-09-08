//Máscara CPF
function mascaraCPF(cpf) {
    cpf = cpf.replace(/\D/g, ""); // remove caracteres não numéricos
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // insere o primeiro ponto
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // insere o segundo ponto
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // insere o traço
    return cpf;
}
const inputCPF = document.getElementById("cpf");
inputCPF.addEventListener("input", function(event) {
    event.target.value = mascaraCPF(event.target.value);
});
//Máscara Telefone
function mascaraTelefone(telefone) {
    telefone = telefone.replace(/\D/g, ""); // remove caracteres não numéricos
    telefone = telefone.replace(/^(\d{2})(\d)/g, "($1) $2"); // insere o DDD entre parênteses
    telefone = telefone.replace(/(\d)(\d{4})$/, "$1-$2"); // insere o traço
    return telefone;
}
const inputTelefone = document.getElementById("telefone");
inputTelefone.addEventListener("input", function(event) {
    event.target.value = mascaraTelefone(event.target.value);
});
//Máscara CNH
function mascaraCNH(cnh) {
    cnh = cnh.replace(/\D/g, ""); // remove caracteres não numéricos
    cnh = cnh.replace(/(\d{3})(\d)/, "$1.$2"); // insere o primeiro ponto
    cnh = cnh.replace(/(\d{3})(\d)/, "$1.$2"); // insere o segundo ponto
    cnh = cnh.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // insere o traço
    return cnh;
}
const inputCNH = document.getElementById("numero_cnh");
inputCNH.addEventListener("input", function(event) {
    event.target.value = mascaraCNH(event.target.value);
});