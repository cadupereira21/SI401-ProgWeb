function CriarTabela() {

    // Captura a referência da tabela com id “game-table”
    let table = document.getElementById("game-table");
    // Captura a quantidade de linhas já existentes na tabela
    let numOfRows = document.forms["dadosJogo"]["alturaTab"].value;
    // Captura a quantidade de colunas da última linha da tabela
    let numOfCols = document.forms["dadosJogo"]["larguraTab"].value;

    // Muda o tamanho da página caso o jogo tenha uma altura maior que 23 linhas
    ResizeScreenHeight(numOfRows);

    // Faz um loop para criar as colunas
    for(let i = 0; i < numOfRows; i++){
        let newRow = table.insertRow(i);
        for (let j = 0; j < numOfCols; j++) {
            // Insere uma coluna na nova linha
            let newCell = newRow.insertCell(j);
            // Insere um conteúdo na coluna
            // newCell.innerHTML = ".";
        }
    }
}

function ResizeScreenHeight(tableHeight){

    let pageBody = document.getElementById("page-body");

    if(tableHeight > 23){
        pageBody.style.height = "fit-content";
    }
}