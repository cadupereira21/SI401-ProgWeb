function mudarVisualizacao(modo){
	let request = new XMLHttpRequest();
	if (!request) {
		alert("Não foi possível atualizar a página!");
		return;
	}
	request.onreadystatechange = atualizarPagina;
	request.open("POST", "./util/obterRanking.php", true);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');//--------------------------------------------------------------------------------
	request.send("modo="+ encodeURIComponent(modo.value));
	
	function atualizarPagina() {
		try {
			if (request.readyState === XMLHttpRequest.DONE) {
				if (request.status === 200) {
					let conteudoAtualizado = request.responseText;					
					let corpoTabela = document.getElementsByTagName("tbody")[0];
					corpoTabela.innerHTML = conteudoAtualizado;				
				}
				else {
					alert("Não foi possível atualizar a página!(Erro "+request.status+")");
				}
			}
		}
		catch (e) {
			alert("Ocorreu uma exceção: " + e.description);
		}
	}	
}