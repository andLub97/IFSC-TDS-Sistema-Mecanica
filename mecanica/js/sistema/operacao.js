$(document).ready(function () {
	//configurando a tabela de dados listados
	$("#lista_operacao").DataTable({
		columnDefs: [{
			targets: [2],
			orderable: false
		}],
		destroy: true,
		info: false,
		language: {
			decimal: ",",
			thousands: "."
		},
		order: [
			[0, "asc"]
		],
		ordering: true,
		paging: false,
		searching: false
	});

	//configurando validação dos dados digitados no cadastro/edição
	$("#operacao_dados").validate({
		rules: {
			descricao_operacao: {
				required: true
			}
		},
		highlight: function (element) {
			$(element).addClass("is-invalid");
		},
		unhighlight: function (element) {
			$(element).removeClass("is-invalid");
		},
		errorElement: "div",
		errorClass: "invalid-feedback",
		errorPlacement: function (error, element) {
			if (element.parent(".input-group-prepend").length) {
				$(element).siblings(".invalid-feedback").append(error);
			} else {
				error.insertAfter(element);
			}
		},
		messages: {
			descricao_operacao: {
				required: "Este campo não pode ser vazio!"
			},
			tipo_operacao: {
				required: "Este campo não pode ser vazio!",
			}
		}
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação da listagem
	$("#div_mensagem_botao_operacao").click(function () {
		$("#div_mensagem_operacao").hide();
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação do registro
	$("#div_mensagem_registro_botao_operacao").click(function () {
		$("#div_mensagem_registro_operacao").hide();
	});

	//voltando para a página inicial do menu do sistema
	$("#home_index_operacao").click(function () {
		$(location).prop("href", "menu.php");
	});

	//voltando para a página de listagem de operacao na mesma página onde ocorreu a chamada
	$("#operacao_index").click(function (e) {
		e.stopImmediatePropagation();

		$("#conteudo").load("operacao_index.php", {
			pagina_operacao: $("#pagina_operacao").val(),
			texto_busca_operacao: $("#texto_busca_operacao").val()
		});
	});

	//botão limpar do cadastro de informações
	$("#botao_limpar_operacao").click(function () {
		$("#nome").focus();
		$("#operacao_dados").each(function () {
			$(this).find(":input").removeClass("is-invalid");
			$(this).find(":input").removeAttr("value");
		});
	});

	//botão salvar do cadastro de informações
	$("#botao_salvar_operacao").click(function (e) {
		$("#modal_salvar_operacao").modal("show");
	});

	//botão sim da pergunta de salvar as informações de cadastro
	$("#modal_salvar_sim_operacao").click(function (e) {
		e.stopImmediatePropagation();

		if (!$("#operacao_dados").valid()) {
			$("#modal_salvar_operacao").modal("hide");
			return;
		}

		var dados = $("#operacao_dados").serializeArray().reduce(function (vetor, obj) {
			vetor[obj.name] = obj.value;
			return vetor;
		}, {});
		var operacao = null;

		$("#carregando_operacao").removeClass("d-none");

		if ($.trim($("#id_operacao").val()) != "") {
			operacao = "editar";
		} else {
			operacao = "adicionar";
		}
		dados = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			cache: false,
			url: "operacao_crud.php",
			data: {
				acao: operacao,
				registro: dados
			},
			dataType: "json",
			success: function (e) {
				$("#conteudo").load("operacao_index.php", {
					pagina_operacao: $("#pagina_operacao").val(),
					texto_busca_operacao: $("#texto_busca_operacao").val()
				}, function () {
					$("#div_mensagem_texto_operacao").empty().append("Operação cadastrada!");
					$("#div_mensagem_operacao").show();
				});
			},
			error: function (e) {
				$("#div_mensagem_registro_texto_operacao").empty().append(e.responseText);
				$("#div_mensagem_registro_operacao").show();
			},
			complete: function () {
				$("#modal_salvar_operacao").modal("hide");
				$("#carregando_operacao").addClass("d-none");
			}
		});
	});

	//botão adicionar da tela de listagem de registros
	$("#botao_adicionar_operacao").click(function (e) {
		e.stopImmediatePropagation();

		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var pagina = $("#pagina_operacao.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_operacao").val();

		$("#conteudo").load("operacao_add.php", function () {
			$("#carregando_operacao").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "operacao_add.php",
				data: {
					pagina_operacao: pagina,
					texto_busca_operacao: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_operacao").empty().append(e.responseText);
					$("#div_mensagem_operacao").show();
				},
				complete: function () {
					$("#carregando_operacao").addClass("d-none");
				}
			});
		});
	});

	//botão pesquisar da tela de listagem de registros
	$("#botao_pesquisar_operacao").click(function (e) {
		e.stopImmediatePropagation();

		$("#carregando_operacao").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "operacao_index.php",
			data: {
				texto_busca_operacao: $("#texto_busca_operacao").val()
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_operacao").empty().append(e.responseText);
				$("#div_mensagem_operacao").show();
			},
			complete: function () {
				$("#carregando_operacao").addClass("d-none");
			}
		});
	});

	//botão editar da tela de listagem de registros
	$(document).on("click", "#botao_editar_operacao", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_operacao.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_operacao").val();

		$("#conteudo").load("operacao_edit.php", function () {
			$("#carregando_operacao").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "operacao_edit.php",
				data: {
					id_operacao: id,
					pagina_operacao: pagina,
					texto_busca_operacao: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_operacao").empty().append(e.responseText);
					$("#div_mensagem_operacao").show();
				},
				complete: function () {
					$("#carregando_operacao").addClass("d-none");
				}
			});
		});
	});

	//botão visualizar da tela de listagem de registros
	$(document).on("click", "#botao_view_operacao", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_operacao.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_operacao").val();

		$("#conteudo").load("operacao_view.php", function () {
			$("#carregando_operacao").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "operacao_view.php",
				data: {
					id_operacao: id,
					pagina_operacao: pagina,
					texto_busca_operacao: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_operacao").empty().append(e.responseText);
					$("#div_mensagem_operacao").show();
				},
				complete: function () {
					$("#carregando_operacao").addClass("d-none");
				}
			});
		});
	});

	//botão paginação da tela de listagem de registros
	$(document).on("click", "#pagina_operacao", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();

		var texto_busca = $("#texto_busca_operacao").val();
		var pagina = $(this).val();
		$("#carregando_operacao").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "operacao_index.php",
			data: {
				pagina_operacao: pagina,
				texto_busca_operacao: texto_busca
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_operacao").empty().append(e.responseText);
				$("#div_mensagem_operacao").show();
			},
			complete: function () {
				$("#carregando_operacao").addClass("d-none");
				$("#texto_busca_operacao").text(texto_busca);
			}
		});
	});

	//botão excluir da tela de listagem de registros
	$(document).on("click", "#botao_excluir_operacao", function (e) {
		e.stopImmediatePropagation();

		confirmaExclusao(this);
	});

	function confirmaExclusao(registro) {
		$("#modal_excluir_operacao").modal("show");
		$("#id_excluir_operacao").val($(registro).attr("chave"));
	}

	//botão sim da pergunta de excluir de listagem de registros
	$("#modal_excluir_sim_operacao").click(function () {
		excluirRegistro();
	});

	//operação de exclusão do registro
	function excluirRegistro() {
		var registro = new Object();
		var registroJson = null;

		registro.id = $("#id_excluir_operacao").val();
		registroJson = JSON.stringify(registro);

		$.ajax({
			type: "POST",
			cache: false,
			url: "operacao_crud.php",
			data: {
				acao: "excluir",
				registro: registroJson
			},
			dataType: "json",
			success: function () {
				$("#div_mensagem_texto_operacao").empty().append("Operação excluída!");
				$("#div_mensagem_operacao").show();
				$("tr#" + registro.id + "_operacao").remove();
			},
			error: function (e) {
				$("#div_mensagem_texto_operacao").empty().append(e.responseText);
				$("#div_mensagem_operacao").show();
			},
			complete: function () {
				$("#modal_excluir_operacao").modal("hide");
			}
		});
	}
});