$(document).ready(function () {
	//configurando a tabela de dados listados
	$("#lista_eletrodo").DataTable({
		columnDefs: [{
			targets: [3],
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
	$("#eletrodo_dados").validate({
		rules: {
			descricao_eletrodo: {
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
			descricao_eletrodo: {
				required: "Este campo não pode ser vazio!"
			},
			tipo_eletrodo: {
				required: "Este campo não pode ser vazio!",
			}
		}
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação da listagem
	$("#div_mensagem_botao_eletrodo").click(function () {
		$("#div_mensagem_eletrodo").hide();
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação do registro
	$("#div_mensagem_registro_botao_eletrodo").click(function () {
		$("#div_mensagem_registro_eletrodo").hide();
	});

	//voltando para a página inicial do menu do sistema
	$("#home_index_eletrodo").click(function () {
		$(location).prop("href", "menu.php");
	});

	//voltando para a página de listagem de eletrodo na mesma página onde ocorreu a chamada
	$("#eletrodo_index").click(function (e) {
		e.stopImmediatePropagation();

		$("#conteudo").load("eletrodo_index.php", {
			pagina_eletrodo: $("#pagina_eletrodo").val(),
			texto_busca_eletrodo: $("#texto_busca_eletrodo").val()
		});
	});

	//botão limpar do cadastro de informações
	$("#botao_limpar_eletrodo").click(function () {
		$("#nome").focus();
		$("#eletrodo_dados").each(function () {
			$(this).find(":input").removeClass("is-invalid");
			$(this).find(":input").removeAttr("value");
		});
	});

	//botão salvar do cadastro de informações
	$("#botao_salvar_eletrodo").click(function (e) {
		$("#modal_salvar_eletrodo").modal("show");
	});

	//botão sim da pergunta de salvar as informações de cadastro
	$("#modal_salvar_sim_eletrodo").click(function (e) {
		e.stopImmediatePropagation();

		if (!$("#eletrodo_dados").valid()) {
			$("#modal_salvar_eletrodo").modal("hide");
			return;
		}

		var dados = $("#eletrodo_dados").serializeArray().reduce(function (vetor, obj) {
			vetor[obj.name] = obj.value;
			return vetor;
		}, {});
		var eletrodo = null;

		$("#carregando_eletrodo").removeClass("d-none");

		if ($.trim($("#id_eletrodo").val()) != "") {
			eletrodo = "editar";
		} else {
			eletrodo = "adicionar";
		}
		dados = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			cache: false,
			url: "eletrodo_crud.php",
			data: {
				acao: eletrodo,
				registro: dados
			},
			dataType: "json",
			success: function (e) {
				$("#conteudo").load("eletrodo_index.php", {
					pagina_eletrodo: $("#pagina_eletrodo").val(),
					texto_busca_eletrodo: $("#texto_busca_eletrodo").val()
				}, function () {
					$("#div_mensagem_texto_eletrodo").empty().append("Eletrodo cadastrado!");
					$("#div_mensagem_eletrodo").show();
				});
			},
			error: function (e) {
				$("#div_mensagem_registro_texto_eletrodo").empty().append(e.responseText);
				$("#div_mensagem_registro_eletrodo").show();
			},
			complete: function () {
				$("#modal_salvar_eletrodo").modal("hide");
				$("#carregando_eletrodo").addClass("d-none");
			}
		});
	});

	//botão adicionar da tela de listagem de registros
	$("#botao_adicionar_eletrodo").click(function (e) {
		e.stopImmediatePropagation();

		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var pagina = $("#pagina_eletrodo.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_eletrodo").val();

		$("#conteudo").load("eletrodo_add.php", function () {
			$("#carregando_eletrodo").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "eletrodo_add.php",
				data: {
					pagina_eletrodo: pagina,
					texto_busca_eletrodo: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_eletrodo").empty().append(e.responseText);
					$("#div_mensagem_eletrodo").show();
				},
				complete: function () {
					$("#carregando_eletrodo").addClass("d-none");
				}
			});
		});
	});

	//botão pesquisar da tela de listagem de registros
	$("#botao_pesquisar_eletrodo").click(function (e) {
		e.stopImmediatePropagation();

		$("#carregando_eletrodo").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "eletrodo_index.php",
			data: {
				texto_busca_eletrodo: $("#texto_busca_eletrodo").val()
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_eletrodo").empty().append(e.responseText);
				$("#div_mensagem_eletrodo").show();
			},
			complete: function () {
				$("#carregando_eletrodo").addClass("d-none");
			}
		});
	});

	//botão editar da tela de listagem de registros
	$(document).on("click", "#botao_editar_eletrodo", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_eletrodo.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_eletrodo").val();

		$("#conteudo").load("eletrodo_edit.php", function () {
			$("#carregando_eletrodo").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "eletrodo_edit.php",
				data: {
					id_eletrodo: id,
					pagina_eletrodo: pagina,
					texto_busca_eletrodo: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_eletrodo").empty().append(e.responseText);
					$("#div_mensagem_eletrodo").show();
				},
				complete: function () {
					$("#carregando_eletrodo").addClass("d-none");
				}
			});
		});
	});

	//botão visualizar da tela de listagem de registros
	$(document).on("click", "#botao_view_eletrodo", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_eletrodo.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_eletrodo").val();

		$("#conteudo").load("eletrodo_view.php", function () {
			$("#carregando_eletrodo").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "eletrodo_view.php",
				data: {
					id_eletrodo: id,
					pagina_eletrodo: pagina,
					texto_busca_eletrodo: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_eletrodo").empty().append(e.responseText);
					$("#div_mensagem_eletrodo").show();
				},
				complete: function () {
					$("#carregando_eletrodo").addClass("d-none");
				}
			});
		});
	});

	//botão paginação da tela de listagem de registros
	$(document).on("click", "#pagina_eletrodo", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();

		var texto_busca = $("#texto_busca_eletrodo").val();
		var pagina = $(this).val();
		$("#carregando_eletrodo").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "eletrodo_index.php",
			data: {
				pagina_eletrodo: pagina,
				texto_busca_eletrodo: texto_busca
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_eletrodo").empty().append(e.responseText);
				$("#div_mensagem_eletrodo").show();
			},
			complete: function () {
				$("#carregando_eletrodo").addClass("d-none");
				$("#texto_busca_eletrodo").text(texto_busca);
			}
		});
	});

	//botão excluir da tela de listagem de registros
	$(document).on("click", "#botao_excluir_eletrodo", function (e) {
		e.stopImmediatePropagation();

		confirmaExclusao(this);
	});

	function confirmaExclusao(registro) {
		$("#modal_excluir_eletrodo").modal("show");
		$("#id_excluir_eletrodo").val($(registro).attr("chave"));
	}

	//botão sim da pergunta de excluir de listagem de registros
	$("#modal_excluir_sim_eletrodo").click(function () {
		excluirRegistro();
	});

	//operação de exclusão do registro
	function excluirRegistro() {
		var registro = new Object();
		var registroJson = null;

		registro.id = $("#id_excluir_eletrodo").val();
		registroJson = JSON.stringify(registro);

		$.ajax({
			type: "POST",
			cache: false,
			url: "eletrodo_crud.php",
			data: {
				acao: "excluir",
				registro: registroJson
			},
			dataType: "json",
			success: function () {
				$("#div_mensagem_texto_eletrodo").empty().append("Eletrodo excluído!");
				$("#div_mensagem_eletrodo").show();
				$("tr#" + registro.id + "_eletrodo").remove();
			},
			error: function (e) {
				$("#div_mensagem_texto_eletrodo").empty().append(e.responseText);
				$("#div_mensagem_eletrodo").show();
			},
			complete: function () {
				$("#modal_excluir_eletrodo").modal("hide");
			}
		});
	}
});