/*
// MENU LATERAL ~ TEM QUE FICAR NESSA ALTURA DO CÓDIGO ~
var checkBtn = document.querySelector("#check");
var sidebar = document.querySelector(".sidebar");

if (checkBtn) {
    checkBtn.addEventListener('click', () => {
        
        if (checkBtn.checked) {
            sidebar.style.animation = 'slide-out 1s ease-out';
            sidebar.style.left = '0'
        } else {
            sidebar.style.animation = 'slide-in 1s ease';
            sidebar.style.left = '-200px'
        }
        
    })
}
*/

//menu responsivo
const toggleButton = document.querySelector(".toggle-button")
const navbarLinks = document.querySelector('.navbar-links')

if(toggleButton){
    toggleButton.addEventListener('click', () => {
        
        navbarLinks.classList.toggle('active')
        
    })
}

//visualizar senha
function ver_senha() {
    const span = document.querySelector("#olho")
    var x = document.getElementById("id_senha");
    if (x.type === "password") {
      x.type = "text";
      span.textContent = "visibility_off";
    } else {
      x.type = "password";
      span.textContent = "visibility";
    }
}

/*redirecionamentos*/
function red_index(){
    window.location.href = "index.php";
}
function red_cadastro(){
    window.location.href = "cadastro.php";
}
function red_cad_cliente(){
    window.location.href = "cadastro_cliente.php";
}
function red_cad_motorista(){
    window.location.href = "cadastro_motorista.php";
}
function red_cad_motorista2(){
    window.location.href = "cadastro_motorista2.php";
}
function limpar_cadastro(){
    window.location.href = "limpar_cadastro.php";
}

function validarSenha() {
    var senha = document.getElementById('senha').value;
    var senhaConf = document.getElementById('senha_conf').value;
    var regex = /^(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
    if (regex.test(senha)) {
        document.getElementById('mensagem').innerHTML = '';
        //document.getElementById('btn_azul').disabled = false;
    } else {
        document.getElementById('mensagem').innerHTML = 'A senha deve conter pelo menos 8 caracteres e um número';
        document.getElementById('btn_azul').disabled = true;
    }
}

function senhasIguais() {
    var senha = document.getElementById('senha').value;
    var senhaConf = document.getElementById('senha_conf').value;
    var regex = /^(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
    if (regex.test(senha) && senha === senhaConf) {
        document.getElementById('mensagem').innerHTML = '';
        document.getElementById('btn_azul').disabled = false;
    } else {
        document.getElementById('mensagem').innerHTML = 'Os campos de senha e confirmação de senha devem ser iguais.';
        document.getElementById('btn_azul').disabled = true;
    }
}

//preview imagem
const inputFile = document.querySelector("#picture__input");
const pictureImage = document.querySelector(".picture__image");
const pictureImageTxt = "Escolha a imagem";
pictureImage.innerHTML = pictureImageTxt;

inputFile.addEventListener("change", function (e) {
  const inputTarget = e.target;
  const file = inputTarget.files[0];

  if (file) {
    const reader = new FileReader();

    reader.addEventListener("load", function (e) {
      const readerTarget = e.target;

      const img = document.createElement("img");
      img.src = readerTarget.result;
      img.classList.add("picture__img");

      pictureImage.innerHTML = "";
      pictureImage.appendChild(img);
    });

    reader.readAsDataURL(file);
  } else {
    pictureImage.innerHTML = pictureImageTxt;
  }
});