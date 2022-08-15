$(document).ready(function () {
	//configurando a tabela de dados listados
	$("#lista_ponto").DataTable({
		columnDefs: [{
			targets: [4],
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
	$("#ponto_dados").validate({
		rules: {
			valor_corrente_ponto: {
				required: true
			},
			valor_desgaste_ponto: {
				required: true
			},
			valor_remocao_ponto: {
				required: true
			},
			valor_rugosidade_ponto: {
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
			valor_corrente_ponto: {
				required: "Este campo não pode ser vazio!"
			},
			valor_desgaste_ponto: {
				required: "Este campo não pode ser vazio!"
			},
			valor_remocao_ponto: {
				required: "Este campo não pode ser vazio!"
			},
			valor_rugosidade_ponto: {
				required: "Este campo não pode ser vazio!"
			}
		}
	});

	$("#valor_corrente_ponto").inputmask("decimal", {
		autoUnmask: true,
		radixPoint: ",",
		groupSeparator: ".",
		allowMinus: false,
		digits: 3,
		digitsOptional: false,
		rightAlign: true,
		unmaskAsNumber: false
	});

	$("#valor_desgaste_ponto").inputmask("decimal", {
		autoUnmask: true,
		radixPoint: ",",
		groupSeparator: ".",
		allowMinus: false,
		digits: 3,
		digitsOptional: false,
		rightAlign: true,
		unmaskAsNumber: false
	});

	$("#valor_remocao_ponto").inputmask("decimal", {
		autoUnmask: true,
		radixPoint: ",",
		groupSeparator: ".",
		allowMinus: false,
		digits: 3,
		digitsOptional: false,
		rightAlign: true,
		unmaskAsNumber: false
	});

	$("#valor_rugosidade_ponto").inputmask("decimal", {
		autoUnmask: true,
		radixPoint: ",",
		groupSeparator: ".",
		allowMinus: false,
		digits: 3,
		digitsOptional: false,
		rightAlign: true,
		unmaskAsNumber: false
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação da listagem
	$("#div_mensagem_botao_ponto").click(function () {
		$("#div_mensagem_ponto").hide();
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação do registro
	$("#div_mensagem_registro_botao_ponto").click(function () {
		$("#div_mensagem_registro_ponto").hide();
	});

	//voltando para a página inicial do menu do sistema
	$("#home_index_ponto").click(function () {
		$(location).prop("href", "menu.php");
	});

	//voltando para a página de listagem de ponto na mesma página onde ocorreu a chamada
	$("#ponto_index").click(function (e) {
		e.stopImmediatePropagation();

		$("#conteudo").load("ponto_index.php", {
			pagina_ponto: $("#pagina_ponto").val(),
			texto_busca_ponto: $("#texto_busca_ponto").val()
		});
	});

	//botão limpar do cadastro de informações
	$("#botao_limpar_ponto").click(function () {
		$("#nome").focus();
		$("#ponto_dados").each(function () {
			$(this).find(":input").removeClass("is-invalid");
			$(this).find(":input").removeAttr("value");
		});
	});

	//botão salvar do cadastro de informações
	$("#botao_salvar_ponto").click(function (e) {
		$("#modal_salvar_ponto").modal("show");
	});

	//botão sim da pergunta de salvar as informações de cadastro
	$("#modal_salvar_sim_ponto").click(function (e) {
		e.stopImmediatePropagation();

		if (!$("#ponto_dados").valid()) {
			$("#modal_salvar_ponto").modal("hide");
			return;
		}

		var dados = $("#ponto_dados").serializeArray().reduce(function (vetor, obj) {
			vetor[obj.name] = obj.value;
			return vetor;
		}, {});
		var ponto = null;

		$("#carregando_ponto").removeClass("d-none");

		if ($.trim($("#id_ponto").val()) != "") {
			ponto = "editar";
		} else {
			ponto = "adicionar";
		}
		dados = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			cache: false,
			url: "ponto_crud.php",
			data: {
				acao: ponto,
				registro: dados
			},
			dataType: "json",
			success: function (e) {
				$("#conteudo").load("ponto_index.php", {
					pagina_ponto: $("#pagina_ponto").val(),
					texto_busca_ponto: $("#texto_busca_ponto").val()
				}, function () {
					$("#div_mensagem_texto_ponto").empty().append("ponto cadastrado!");
					$("#div_mensagem_ponto").show();
				});
			},
			error: function (e) {
				$("#div_mensagem_registro_texto_ponto").empty().append(e.responseText);
				$("#div_mensagem_registro_ponto").show();
			},
			complete: function () {
				$("#modal_salvar_ponto").modal("hide");
				$("#carregando_ponto").addClass("d-none");
			}
		});
	});

	//botão adicionar da tela de listagem de registros
	$("#botao_adicionar_ponto").click(function (e) {
		e.stopImmediatePropagation();

		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var pagina = $("#pagina_ponto.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_ponto").val();

		$("#conteudo").load("ponto_add.php", function () {
			$("#carregando_ponto").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "ponto_add.php",
				data: {
					pagina_ponto: pagina,
					texto_busca_ponto: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_ponto").empty().append(e.responseText);
					$("#div_mensagem_ponto").show();
				},
				complete: function () {
					$("#carregando_ponto").addClass("d-none");
				}
			});
		});
	});

	//botão pesquisar da tela de listagem de registros
	$("#botao_pesquisar_ponto").click(function (e) {
		e.stopImmediatePropagation();

		$("#carregando_ponto").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "ponto_index.php",
			data: {
				texto_busca_ponto: $("#texto_busca_ponto").val()
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_ponto").empty().append(e.responseText);
				$("#div_mensagem_ponto").show();
			},
			complete: function () {
				$("#carregando_ponto").addClass("d-none");
			}
		});
	});

	//botão editar da tela de listagem de registros
	$(document).on("click", "#botao_editar_ponto", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_ponto.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_ponto").val();

		$("#conteudo").load("ponto_edit.php", function () {
			$("#carregando_ponto").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "ponto_edit.php",
				data: {
					id_ponto: id,
					pagina_ponto: pagina,
					texto_busca_ponto: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_ponto").empty().append(e.responseText);
					$("#div_mensagem_ponto").show();
				},
				complete: function () {
					$("#carregando_ponto").addClass("d-none");
				}
			});
		});
	});

	//botão visualizar da tela de listagem de registros
	$(document).on("click", "#botao_view_ponto", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_ponto.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_ponto").val();

		$("#conteudo").load("ponto_view.php", function () {
			$("#carregando_ponto").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "ponto_view.php",
				data: {
					id_ponto: id,
					pagina_ponto: pagina,
					texto_busca_ponto: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_ponto").empty().append(e.responseText);
					$("#div_mensagem_ponto").show();
				},
				complete: function () {
					$("#carregando_ponto").addClass("d-none");
				}
			});
		});
	});

	//botão paginação da tela de listagem de registros
	$(document).on("click", "#pagina_ponto", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();

		var texto_busca = $("#texto_busca_ponto").val();
		var pagina = $(this).val();
		$("#carregando_ponto").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "ponto_index.php",
			data: {
				pagina_ponto: pagina,
				texto_busca_ponto: texto_busca
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_ponto").empty().append(e.responseText);
				$("#div_mensagem_ponto").show();
			},
			complete: function () {
				$("#carregando_ponto").addClass("d-none");
				$("#texto_busca_ponto").text(texto_busca);
			}
		});
	});

	//botão excluir da tela de listagem de registros
	$(document).on("click", "#botao_excluir_ponto", function (e) {
		e.stopImmediatePropagation();

		confirmaExclusao(this);
	});

	function confirmaExclusao(registro) {
		$("#modal_excluir_ponto").modal("show");
		$("#id_excluir_ponto").val($(registro).attr("chave"));
	}

	//botão sim da pergunta de excluir de listagem de registros
	$("#modal_excluir_sim_ponto").click(function () {
		excluirRegistro();
	});

	//operação de exclusão do registro
	function excluirRegistro() {
		var registro = new Object();
		var registroJson = null;

		registro.id = $("#id_excluir_ponto").val();
		registroJson = JSON.stringify(registro);

		$.ajax({
			type: "POST",
			cache: false,
			url: "ponto_crud.php",
			data: {
				acao: "excluir",
				registro: registroJson
			},
			dataType: "json",
			success: function () {
				$("#div_mensagem_texto_ponto").empty().append("ponto excluído!");
				$("#div_mensagem_ponto").show();
				$("tr#" + registro.id + "_ponto").remove();
			},
			error: function (e) {
				$("#div_mensagem_texto_ponto").empty().append(e.responseText);
				$("#div_mensagem_ponto").show();
			},
			complete: function () {
				$("#modal_excluir_ponto").modal("hide");
			}
		});
	}
});