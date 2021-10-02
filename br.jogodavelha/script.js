// 0 = circulo, 1 = xis, -1 = vazio

var tabela = new Array(3);

tabela[0] = [-9, -8, -7];
tabela[1] = [-6, -5, -4];
tabela[2] = [-3, -2, -1];

var vez = 0;

function jogada(linha, coluna){
    
    /*
    * ao clicar em uma celula
    *   
    *   1) apaecer a imagem correta na celula
    *   2) mudar a vez
    *   3) computar na celula
    * 
    * */
    
    var tableElement = "";
    var buttonPositionId = "table-button-";
    var textoVitoria = document.getElementById("winner");
    
    // Salva a jogada valor na matriz
    tabela[linha][coluna] = vez;
    
    // Altera a vez
    switch (vez){
        case 0:
            tableElement = "circulo";
            vez += 1;
            break;
        case 1:
            tableElement = "xis";
            vez -= 1;
            break;
    }
    
    switch (linha) {
        case 0:
            buttonPositionId = buttonPositionId + "top-";
            break;
        case 1:
            buttonPositionId = buttonPositionId + "middle-";
            break;
        case 2:
            buttonPositionId = buttonPositionId + "bottom-";
            break;
    }
    
    switch (coluna){
        case 0:
            buttonPositionId = buttonPositionId + "left";
            break;
        case 1:
            buttonPositionId = buttonPositionId + "middle";
            break;
        case 2:
            buttonPositionId = buttonPositionId + "right";
            break;
    }
    
    // Coloca a imagem na tela 
    var button = document.getElementById(buttonPositionId);
    button.style.backgroundColor = "rgb(40,40,40)";
    button.style.backgroundImage = "url(./Assets/"+ tableElement + "_goldenrod.png)"
    
    if(CheckWinner()){
        var vencedor = "";
        
        switch (vez){
            case 0:
                vencedor = "xis";
                break;
            case 1:
                vencedor = "circulo";
                break;
        }
        
        textoVitoria.innerText = "O vencedor é o jogador utilizando " + vencedor + "! Parabéns!";

        BlockAllButtons();
    }
    
    if(CheckVelha()){

        textoVitoria.innerText = "Poxa! Esse jogo deu velha! Tentem novamente!";
        BlockAllButtons();
    }
}

function CheckWinner(){
    
    // Checa de cima para baixo
    for(let i = 0; i<tabela.length; i++){
        if(tabela[0][i] === tabela[1][i] && tabela[0][i] === tabela[2][i])
            return true;
    }
    
    // Checa de lado
    for(let i = 0; i<tabela.length; i++){
        if(tabela[i][0] === tabela[i][1] && tabela[i][0] === tabela[i][2])
            return true;
    }
    
    // Checa uma diagonal
    if(tabela[0][0] === tabela[1][1] && tabela[0][0] === tabela[2][2])
        return true;
    
    
    // Checa a outra diagonal
    if(tabela[2][0] === tabela[1][1] && tabela[2][0] === tabela[0][2])
        return true;
    
    return false;
}

function BlockAllButtons(){
    var allButtons = document.getElementsByClassName("table-button");

    for(let i = 0; i<allButtons.length;i++){
        allButtons[i].disabled = true;
    }
}

function ReloadWindow(){
    location.reload();
}

function CheckVelha(){
    for(let i = 0; i<tabela.length;i++)
        for(let k = 0; k<tabela.length; k++){
            if(tabela[i][k] < 0)
                return false;
        }
    return true;
}