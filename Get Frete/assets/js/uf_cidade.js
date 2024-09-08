const urlUF = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome'
const cidade = document.getElementById("cidade")
const uf = document.getElementById("uf")

uf.addEventListener('change', async function(){
    const urlCidades = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/'+uf.value+'/municipios'
    const request = await fetch(urlCidades)
    const response = await request.json()
    let options = ''
    response.forEach(function(cidades){
        options += '<option value="'+cidades.nome+'">'+cidades.nome+'</option>'
    })
    cidade.innerHTML = options
})

window.addEventListener('load', async ()=>{
    const request = await fetch(urlUF)
    const response = await request.json()
    const options = document.createElement("optgroup")
    options.setAttribute('label','UFs')
    response.forEach(function(uf){
        options.innerHTML += '<option value="'+uf.sigla+'">'+uf.nome+'</option>'
    })
    uf.append(options)
})