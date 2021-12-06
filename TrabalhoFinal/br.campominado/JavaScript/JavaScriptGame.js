"use strict";

//Dados carregados ao iniciar a partida
var qtdBombas;
var qtdColunas;
var qtdLinhas;
var modoDeJogo;

//dados sobre a partida
var partidaRodando = false;
var contagemTempoIniciada = false;
var celulasAbertas = 0;
var bombasArmadas = 0;
var pontuacao = 0;
var modoClique = 0; // 0 = abertura da celula; 1 = colocar bandeira

//variáveis com os IDs dos tempos e seu valor
var tempoTrapacaId;
var tempoDePartidaId;
var tempoRestanteId;
var tempoRestante;

var dataInicio;
var tempoDePartida;

//----------------------------------------------- Gravar dados da partida ------------------------------------------------------

function RegistrarPartida(resultado){
	let dados = JSON.stringify({
		IdUsuario: document.getElementById("idUser").innerHTML,
		numBombas: qtdBombas,
		tabuleiro: (qtdColunas + "x" + qtdLinhas),
		modo: modoDeJogo,
		dataInicio: dataInicio,
		resultado: resultado,		
		duracao: tempoDeSegundosParaString(tempoDePartida)	
	});
	let request = new XMLHttpRequest();
	if (!request) {
		alert("Não foi possível criar um objeto XMLHttpRequest para salvar a partida.");
		return;
	}	
	
	request.onreadystatechange = mostrarResultadoRequisicao;
	request.open("POST", "./util/salvarPartida.php", true);
	request.setRequestHeader("Content-type", "application/json");
	request.send(dados);	
	
	function mostrarResultadoRequisicao() {
		try {
			if (request.readyState === XMLHttpRequest.DONE) {
				if (request.status === 200) {
					let retorno = request.responseText;
					if(retorno != "Partida salva")
						alert("Ocorreu um erro no servidor e sua partida não pode ser salva!\nERRO: " + retorno);
				}
				else {
					alert("Ocorreu um erro("+request.status+")e sua partida não pode ser salva!");
				}
			}
		}
		catch (e) {
			alert("Ocorreu uma exceção: " + e.description);
		}
	}
}


//----------------------------------------------- Funções para carregar partida ------------------------------------------------

function ResizeScreenHeight(){

    let pageBody = document.getElementById("page-body");
    let page = document.getElementById("html");

    if(window.innerHeight > window.screen.height){
        pageBody.style.height = "fit-content";
    }
}

function iniciarAPartida(){
    //verifica se todas as validações são válidas e, caso não sejam, exibe o balão sobre o erro
    if(!document.forms.dadosJogo.reportValidity()){
        return;
    }

    try {
        ResizeScreenHeight()
    } catch (e) {
        console.log("ERROR --> " + e);
    }
    
    //coleta dos dados
    qtdBombas = Number.parseInt(document.forms.dadosJogo.numBombas.value);
    qtdColunas = Number.parseInt(document.forms.dadosJogo.larguraTab.value);
    qtdLinhas = Number.parseInt(document.forms.dadosJogo.alturaTab.value);
    modoDeJogo = document.forms.dadosJogo.modoAtual.value;
    
    //verificar se a quantidade de bombas é valida
    if(qtdBombas >= qtdLinhas * qtdColunas){
        alert("Foi inserido um número de bombas além da quantidade que o tabuleiro consegue comportar. Altere o valor e inicie a partida novamente");
        return;
    }    
    
    configurarDadosVisiveisDaPartida(qtdBombas);

    //resetando para o calculo correto da pontuação caso seja o modo clássico
    tempoRestante = 0; 
    
    gerarTabuleiro(qtdLinhas, qtdColunas);    
    posicionarBombas(qtdBombas);    
    atualizarNumeroDeBombasNosArredores(qtdLinhas, qtdColunas);
    
    //Exibe os contadores do tempo de acordo com o modo de jogo
    exibirContadoresDoTempo(modoDeJogo);
    contagemTempoIniciada = false;
    
    travarFormularioDurantePartida();
    mudarVisibilidadeBotaoTrapaca();
    
    partidaRodando = true;
}


function gerarTabuleiro(altura, largura) {
    document.getElementById("campoMinado").innerHTML = "";//limpa para permitir novas partidas    
    
    var i,j;
    for(i=0;i < altura;i++){
        var divLinha = document.createElement("div");
        for(j=0;j < largura; j++){
            var divCelula = document.createElement("div");
            divCelula.setAttribute("id", "celula_l" + i + "_c" + j);
            divCelula.classList.add("celula");
            divCelula.classList.add("celulaFechada");
            divCelula.setAttribute("onclick", "selecionarCelula(this)");
            
            //coloca a célula na linha
            divLinha.appendChild(divCelula);
        }
        //coloca a linha na área do jogo
        document.getElementById("campoMinado").appendChild(divLinha);
    }    
}

function posicionarBombas(qtdBombas){
    let bombasColocadas = 0;    
    var celulas = document.getElementsByClassName("celula");
    while(bombasColocadas != qtdBombas){
        let numCelulaSorteada = Math.floor(Math.random() * celulas.length);
        let celulaSorteada = celulas[numCelulaSorteada];
        
        //se não foi inserido nada ainda, é uma posição válida para receber uma bomba
        if(!celulaSorteada.hasChildNodes()){
            //cria e inseri a bomba na célula
            let spanDeBomba = document.createElement("span");
            spanDeBomba.innerHTML = -1;
            celulaSorteada.appendChild(spanDeBomba);    

            //atualiza o número de bombas colocadas
            bombasColocadas++;
        }        
    }
}

function atualizarNumeroDeBombasNosArredores(qtdLinhas, qtdColunas){
    var celulas = document.getElementsByClassName("celula");
    let i, j;
    for(i = 0; i < celulas.length; i++){
        //verifica se a celula está sem nenhuma bomba
        if(!celulas[i].hasChildNodes()){
            let bombasProximas = 0;
            let celulasAoRedor = selecionarCelulasValidasAoRedor(celulas[i]);
            for(j = 0; j < celulasAoRedor.length; j++) {
                //verifica se o vizinho não está vazio e se é uma bomba
                if(celulasAoRedor[j].hasChildNodes() && Number.parseInt(celulasAoRedor[j].firstChild.innerHTML) == -1){
                    bombasProximas++;
                }
            }
            //cria uma tag span com o valor de bombas ao redor da célula
            let spanBombasAoRedor = document.createElement("span");
            spanBombasAoRedor.innerHTML = bombasProximas;
            celulas[i].appendChild(spanBombasAoRedor);
        }
    }
}

function configurarDadosVisiveisDaPartida(numDeBombas = 0) {
    //atualizar valor de celulas abertas
    document.getElementById("celulasAbertas").innerHTML = "Células abertas: 0";
    celulasAbertas = 0;
    //atualizar valor de bombas a serem "desarmadas"
    bombasArmadas = numDeBombas;
    document.getElementById("bombasArmadas").innerHTML = "Bombas armadas: " + bombasArmadas;
    //atualizar valor da pontuação
    document.getElementById("pontuacao").innerHTML = "Pontuação: 0";
    pontuacao = 0;   
}

//----------------------------------------------- Função de desistencia de partida ------------------------------------------------

function travarFormularioDurantePartida(){
    //trava o form para evitar novo envio
    document.forms.dadosJogo.numBombas.disabled = true;
    document.forms.dadosJogo.larguraTab.disabled = true;
    document.forms.dadosJogo.alturaTab.disabled = true;
    document.forms.dadosJogo.modoAtual.disabled = true;
    
    let botaoIniciarPartida = document.getElementById("iniciarPartida");
    botaoIniciarPartida.setAttribute("value", "Desistir da Partida");
    botaoIniciarPartida.setAttribute("onclick", "desistirDaPartida()");
    botaoIniciarPartida.setAttribute("id", "desistirPartida");
}

function destravarFormularioAposPartida(){
    //destrava o form para possibilitar um novo envio
    document.forms.dadosJogo.numBombas.disabled = false;
    document.forms.dadosJogo.larguraTab.disabled = false;
    document.forms.dadosJogo.alturaTab.disabled = false;
    document.forms.dadosJogo.modoAtual.disabled = false;
    
    let botaoDesistirPartida = document.getElementById("desistirPartida");
    botaoDesistirPartida.setAttribute("value", "Iniciar Partida");
    botaoDesistirPartida.setAttribute("onclick", "iniciarAPartida()");
    botaoDesistirPartida.setAttribute("id", "iniciarPartida");
}

//----------------------------------------------- Função de desistencia de partida ------------------------------------------------

function desistirDaPartida(){
    document.getElementById("campoMinado").innerHTML = "";//limpa o tabuleiro    
    
    //resetar dados da pagina
    configurarDadosVisiveisDaPartida();
    
    finalizarPartida("derrota");
    ocultarContadoresDoTempo();
}

//----------------------------------------------- Função finalizar partida ------------------------------------------------

function finalizarPartida(resultado){
    //pausa os calculos dos tempos
    pausarContagens();    
    partidaRodando = false;
	calcularPontuacaoFinal(resultado, qtdBombas,tempoRestante);
	//só salva se tiver iniciado as jogadas da partida
	if(contagemTempoIniciada)
		RegistrarPartida(resultado);
	
    destravarFormularioAposPartida();
    mudarVisibilidadeBotaoTrapaca();
}

function sinalizarDerrota(){
    finalizarPartida("derrota");
    exibirBombasFechadas();
    //atualiza o resultado final da partida com a quantidade real de bombas que deveriam ser desarmadas
    
    document.getElementById("bombasArmadas").innerHTML = "Bombas armadas: " + bombasArmadas;
    
    alert("Derrota.\nPara continuar jogando, clique para iniciar uma nova partida.");
}

function sinalizarVitoria(){
    finalizarPartida("vitoria");
    exibirTabuleiroDaVitoria();
    //Atualiza a marcação de bombas desarmadas
    document.getElementById("bombasArmadas").innerHTML = "Bombas armadas: 0";
    
    alert("Parabéns, você ganhou.\nPara continuar jogando, clique para iniciar uma nova partida.");
}



//----------------------------------------------- Funções relativas a realizar uma jogada ------------------------------------------------

function trocarModoClique(){
    modoClique = ++modoClique%2;
    let imgModo = document.getElementById("imagemModoClique");
    if(modoClique == 0)
        imgModo.setAttribute("src","./Assets/cursor.png");
    else
        imgModo.setAttribute("src","./Assets/bandeira.png");
}

function selecionarCelula(celula){
    //trava as jogadas quando não estiver mais jogando
    if(!partidaRodando)
        return;
    
    //Após o primeiro clique, iniciará a contagem do tempo
    if(!contagemTempoIniciada){
        contagemTempoIniciada = true;
        iniciarContagemTempoPartida();
        if(modoDeJogo == "Rivotril"){
            iniciarContagemTempoRestante(qtdLinhas, qtdColunas);
        }
    }

    if(modoClique == 0){
        //trava a abertura quando for selecionado uma celula com bandeira
        if(!celula.classList.contains("bandeira"))
            abrirCelula(celula);
    }else{
        alternarBandeira(celula);
    }    
}

function alternarBandeira(celula){
    if(celula.classList.contains("bandeira")){
        celula.classList.remove("bandeira");
		if(celula.classList.contains("trapaca"))
			celula.classList.add("bomba");
        bombasArmadas++;
        document.getElementById("bombasArmadas").innerHTML = "Bombas armadas: " + bombasArmadas;
    }else if(!celula.classList.contains("celulaAberta")){
        celula.classList.remove("bomba");
        celula.classList.add("bandeira");
        bombasArmadas--;
        document.getElementById("bombasArmadas").innerHTML = "Bombas armadas: " + bombasArmadas;
        if(bombasArmadas == 0){
            var celulasMarcadas = document.getElementsByClassName("bandeira");
            let sinalizacaoErrada = false;
            let i;
            for(i = 0; !sinalizacaoErrada && i < celulasMarcadas.length; i++){
                if(Number.parseInt(celulasMarcadas[i].firstChild.innerHTML) != -1)
                    sinalizacaoErrada = true;
            }
            if(sinalizacaoErrada)
                sinalizarDerrota();
            else{
                sinalizarVitoria();
            }
        }
    }    
}

function verificarArredores(celula, qtdLinhas, qtdColunas){
    let bandeirasAoRedor = 0;
    let celulasAoRedor = selecionarCelulasValidasAoRedor(celula);
    let i;
    for(i = 0; i < celulasAoRedor.length; i++) {
        if(celulasAoRedor[i].classList.contains("bandeira")){
            bandeirasAoRedor++;
        }
    }
    //se tiver a quantidade correta de bandeiras nos arredores, abre todos os que não foram sinalizados
    if(bandeirasAoRedor >= Number.parseInt(celula.firstChild.innerHTML)){
        for(i = 0; i < celulasAoRedor.length; i++) {
            //verifica se o vizinho não é uma bandeira e não está aberto e faz a abertura
            if(!celulasAoRedor[i].classList.contains("bandeira") && !celulasAoRedor[i].classList.contains("celulaAberta")){
                abrirCelulaSelecionada(celulasAoRedor[i], qtdLinhas, qtdColunas);
				
            }
        }
    }
}

function abrirCelula(celula){
    //Registro da quantidade de celulas abertas para o calculo correto dos pontos
    let celulasPreviamenteAbertas = celulasAbertas;    
    if(celula.classList.contains("celulaAberta")){
        verificarArredores(celula, qtdLinhas, qtdColunas);
    }else{
        abrirCelulaSelecionada(celula, qtdLinhas, qtdColunas); 
    }
    
    //atualizando a pontuação (1 ponto para cada celula aberta)
    pontuacao += celulasAbertas - celulasPreviamenteAbertas;// pontuação temporaria -------------------------------------------------------------------------------------------
    document.getElementById("pontuacao").innerHTML = "Pontuação: " + pontuacao;

    //atualizar valor de celulas abertas
    document.getElementById("celulasAbertas").innerHTML = "Células abertas: " + celulasAbertas;
    
    //Verifica se todas as posições foram abertas
    if( (qtdLinhas*qtdColunas) == (celulasAbertas + qtdBombas)){
        sinalizarVitoria();
    }
}

//função recursiva para abrir mais de uma célula se necessário
function abrirCelulaSelecionada(celula, qtdLinhas, qtdColunas){
    
    let valorDaCelula = Number.parseInt(celula.firstChild.innerHTML);
    
    //Verifica se foi aberto uma bomba e sinaliza a derrota
    if(valorDaCelula == -1){
        celula.classList.add("bomba");
        celula.classList.add("celulaSelecionadaErrada");
        sinalizarDerrota();
        return;
    }

    //não abre celula marcada com bandeira mesmo se não tiver nada
    if(celula.classList.contains("bandeira")){
        return;
    }
    celula.classList.remove("celulaFechada");
    celula.classList.remove("trapaca");
    celula.classList.add("celulaAberta");
    celulasAbertas++;
    
    //caso a posição esteja vazia, adiciona a tag correspondente para correta visualização    
    if(valorDaCelula == 0){
        //adiciona a tag
        celula.firstChild.classList.add("semNumeroDeBombasProximo");
        let celulasAoRedor = selecionarCelulasValidasAoRedor(celula);
        let i;
        for(i = 0; i < celulasAoRedor.length; i++) {
            //verifica se o vizinho já está aberto. Caso não esteja, seleciona a celula para abrir
            if(!celulasAoRedor[i].classList.contains("celulaAberta")){
                abrirCelulaSelecionada(celulasAoRedor[i], qtdLinhas, qtdColunas);
            }
        }
    }else{
        celula.classList.add("clicavel");
    }
}

function selecionarCelulasValidasAoRedor(celula) {
    let idDaCelula = celula.id;
    let posAux = idDaCelula.indexOf("_c")+2;//local em que inicia o numero da coluna
    let linha = Number.parseInt(idDaCelula.substring(8,posAux-2));
    let coluna = Number.parseInt(idDaCelula.substr(posAux));
    let x, y, celulaVizinha;
    
    var celulas = [];
    
    for(x = -1; x <=1; x++){
        for(y = -1; y <=1; y++){
            //Verifica se a posição está dentro do tabuleiro e que seja diferente da posição base
            if((linha + x >=0) && (linha + x < qtdLinhas) && (coluna + y >=0) && (coluna + y < qtdColunas) && !(x == 0 && y == 0)){
                celulaVizinha = document.getElementById("celula_l" + (x + linha) + "_c" + (y + coluna));
                celulas.push(celulaVizinha);
            }
        }
    }
    return celulas;
}

function exibirBombasFechadas(){
    var celulas = document.getElementsByClassName("celula");
    let i, valorDaCelula;
    for(i = 0; i < celulas.length; i++){
        valorDaCelula = Number.parseInt(celulas[i].firstChild.innerHTML);
        if(!celulas[i].classList.contains("bandeira")){
            //caso a posição seja de bomba, adiciona a tag correspondente para exibir a bomba
            if(valorDaCelula == -1){
                celulas[i].classList.add("bomba");
            }
        }else{
            //caso tenha uma bandeira sinalizada errada
            if(valorDaCelula != -1){
                celulas[i].classList.add("bandeiraErrada");
                //atualiza a quantidade de bombas realmente desarmadas
                bombasArmadas++;
            }
        }
    }
}

function exibirTabuleiroDaVitoria() {
    var celulas = document.getElementsByClassName("celula");
    let i, valorCelula;
    for(i = 0; i < celulas.length; i++){
        
        //remove a marcação de que a célula é clicavel
        celulas[i].classList.remove("clicavel");
        celulas[i].classList.remove("celulaFechada");
        celulas[i].classList.add("celulaAberta");
        valorCelula = Number.parseInt(celulas[i].firstChild.innerHTML);
        if( valorCelula == -1){
            //caso a posição seja de bomba, adiciona a tag correspondente para exibir a bandeira de bomba desarmada
            celulas[i].classList.remove("bomba"); 
            celulas[i].classList.add("bandeira");         
        }else if(valorCelula == 0){
            celulas[i].firstChild.classList.add("semNumeroDeBombasProximo"); 
        }
    }
}

//-----------------------------------------------Calculo da pontuação final -----------------------------------------------------------

function calcularPontuacaoFinal(resultado,qtdBombas,tempo = 0) { //exemplo temporário -------------------------------------------------------------------------------
    if(resultado == "vitoria") {
        //Adiciona a pontação referente a todas as bombas presentes no jogo
        pontuacao += qtdBombas * 100;
        
        //cada segundo restante do modo rivotril equivale a 10 pontos
        pontuacao += tempo * 10;    
    }else{    
        //se foi uma derrota, calcula o ponto apenas das bombas desarmadas corretamente
        let numBombasDesarmadasCorretamente = 0;
        var bandeiras = document.getElementsByClassName("bandeira");
        let i;
        for(i = 0; i < bandeiras.length; i++) {
            if(Number.parseInt(bandeiras[i].firstChild.innerHTML) == -1)
                numBombasDesarmadasCorretamente++;
        }    
        //Contabiliza todas as bombas abertas corretamente
        pontuacao += numBombasDesarmadasCorretamente * 100;        
    }
    //atualiza o documento com o valor final
    document.getElementById("pontuacao").innerHTML = "Pontuação: " + pontuacao;
}

//----------------------------------------------- Funções relativas ao botão de trapaça ------------------------------------------------

function mudarVisibilidadeBotaoTrapaca(){
    let btnTrapaca = document.getElementById("btnTrapaca");
    if(btnTrapaca.style.visibility == "visible")
        btnTrapaca.style.visibility = "hidden";
    else
        btnTrapaca.style.visibility = "visible";
}

function ativarTrapaca(){    
    //remove o temporizador anterior caso ainda não tenha ocorrido
    clearTimeout(tempoTrapacaId);
        
    iniciarTrapaca();
    //depois de 3 segundo ele retorna as celulas para o estado normal
    tempoTrapacaId = setTimeout(finalizarTrapaca,3000);
}

function iniciarTrapaca(){
    var celulas = document.getElementsByClassName("celula");
    let i, valorDaCelula;
    
    for(i = 0; i < celulas.length; i++){
        if(celulas[i].classList.contains("celulaFechada") && !celulas[i].classList.contains("bandeira")){
            //caso a posição seja de bomba ou vazia, adiciona a tag correspondente para correta visualização
            valorDaCelula = Number.parseInt(celulas[i].firstChild.innerHTML);
            if(valorDaCelula == 0)
                celulas[i].firstChild.classList.add("semNumeroDeBombasProximo");
            else if(valorDaCelula == -1)
                celulas[i].classList.add("bomba");
            //Atualiza a classe para a trapaca
            celulas[i].classList.remove("celulaFechada");
            celulas[i].classList.add("trapaca");
        }
    }
}

function finalizarTrapaca(){
    var celulas = document.getElementsByClassName("celula");
    let i;
    for(i = 0; i < celulas.length; i++){
        if(celulas[i].classList.contains("trapaca")){
            //remove a marcação de visualização caso tenha sido adicionada anteriormente
            celulas[i].classList.remove("bomba");
            celulas[i].firstChild.classList.remove("semNumeroDeBombasProximo");
            //retorna ao estado correto da celula
            celulas[i].classList.remove("trapaca");
            celulas[i].classList.add("celulaFechada");
        }
    }
}

//----------------------------------------------- Funções relativas a contagem do tempo ------------------------------------------------

function calcularTempoModoRivotril(linhas, colunas){
    return linhas * colunas * 3;//regra temporária -----------------------------------
}

//utiliza a quantidade de linhas e de colunas para iniciar o modo rivotril já marcando o tempo total para finalização
function exibirContadoresDoTempo(modoAtual){    
    let divTempoRestante = document.getElementById("tempoRestante");
    let divTempoPartida = document.getElementById("tempoPartida");
    divTempoPartida.getElementsByClassName("marcadorTempo")[0].innerHTML = "00:00:00";
    divTempoPartida.style.visibility = "visible";
    if(modoAtual == "Rivotril"){
        let tempoRestante = calcularTempoModoRivotril(qtdLinhas, qtdColunas); 
        divTempoRestante.getElementsByClassName("marcadorTempo")[0].innerHTML = tempoDeSegundosParaString(tempoRestante);
        divTempoRestante.style.visibility = "visible";
    }else{
        divTempoRestante.style.visibility = "hidden";
    }
}

function ocultarContadoresDoTempo(){
    document.getElementById("tempoRestante").style.visibility = "hidden";
    document.getElementById("tempoPartida").style.visibility = "hidden";
}

function iniciarContagemTempoPartida(){
	dataInicio = new Date().toISOString().slice(0, 19).replace('T', ' ');
    tempoDePartida = 0;
    tempoDePartidaId = setInterval(function(){
        tempoDePartida++;
        atualizarCronometroDocumento("tempoPartida", tempoDePartida);    
    },1000);
}

function iniciarContagemTempoRestante(linhas, colunas){
    tempoRestante = calcularTempoModoRivotril(linhas, colunas);
    
    tempoRestanteId = setInterval(function(){
        tempoRestante--;
        atualizarCronometroDocumento("tempoRestante", tempoRestante);
        if(tempoRestante == 0){
            sinalizarDerrota();
        }
    },1000);
}

function pausarContagens() {
    clearInterval(tempoRestanteId);
    clearInterval(tempoDePartidaId);
    //remove as marcações ao pausar a contagem do tempo caso esteja contando o tempo de trapaça
    clearInterval(tempoTrapacaId);
    finalizarTrapaca();
}

function atualizarCronometroDocumento(nomeTagIdCronometro, tempo){    
    let spanTempo = document.getElementById(nomeTagIdCronometro).getElementsByClassName("marcadorTempo")[0];
    spanTempo.innerHTML = tempoDeSegundosParaString(tempo);
}

function tempoDeSegundosParaString(tempo){
    let hora = Math.floor(tempo / 3600);
    let minutos = Math.floor((tempo % 3600) / 60);
    let segundos = (tempo % 3600) % 60;
    
    let stringTempo = "";    
    stringTempo += ((hora < 10) ? "0" : "") + hora + ":";
    stringTempo += ((minutos < 10) ? "0" : "") + minutos + ":";
    stringTempo += ((segundos < 10) ? "0" : "") + segundos;
    return stringTempo;
}

