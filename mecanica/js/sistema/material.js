$(document).ready(function () {
	//configurando a tabela de dados listados
	$("#lista_material").DataTable({
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
	$("#material_dados").validate({
		rules: {
			descricao_material: {
				required: true
			},
			tipo_material: {
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
			descricao_material: {
				required: "Este campo não pode ser vazio!"
			}
		}
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação da listagem
	$("#div_mensagem_botao_material").click(function () {
		$("#div_mensagem_material").hide();
	});

	//clicar no botão da div de erros e escondendo as mensagens de erros de validação do registro
	$("#div_mensagem_registro_botao_material").click(function () {
		$("#div_mensagem_registro_material").hide();
	});

	//voltando para a página inicial do menu do sistema
	$("#home_index_material").click(function () {
		$(location).prop("href", "menu.php");
	});

	//voltando para a página de listagem de material na mesma página onde ocorreu a chamada
	$("#material_index").click(function (e) {
		e.stopImmediatePropagation();

		$("#conteudo").load("material_index.php", {
			pagina_material: $("#pagina_material").val(),
			texto_busca_material: $("#texto_busca_material").val()
		});
	});

	//botão limpar do cadastro de informações
	$("#botao_limpar_material").click(function () {
		$("#nome").focus();
		$("#material_dados").each(function () {
			$(this).find(":input").removeClass("is-invalid");
			$(this).find(":input").removeAttr("value");
		});
	});

	//botão salvar do cadastro de informações
	$("#botao_salvar_material").click(function (e) {
		$("#modal_salvar_material").modal("show");
	});

	//botão sim da pergunta de salvar as informações de cadastro
	$("#modal_salvar_sim_material").click(function (e) {
		e.stopImmediatePropagation();

		if (!$("#material_dados").valid()) {
			$("#modal_salvar_material").modal("hide");
			return;
		}

		var dados = $("#material_dados").serializeArray().reduce(function (vetor, obj) {
			vetor[obj.name] = obj.value;
			return vetor;
		}, {});
		var operacao = null;

		$("#carregando_material").removeClass("d-none");

		if ($.trim($("#id_material").val()) != "") {
			operacao = "editar";
		} else {
			operacao = "adicionar";
		}
		dados = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			cache: false,
			url: "material_crud.php",
			data: {
				acao: operacao,
				registro: dados
			},
			dataType: "json",
			success: function (e) {
				$("#conteudo").load("material_index.php", {
					pagina_material: $("#pagina_material").val(),
					texto_busca_material: $("#texto_busca_material").val()
				}, function () {
					$("#div_mensagem_texto_material").empty().append("Material cadastrado!");
					$("#div_mensagem_material").show();
				});
			},
			error: function (e) {
				$("#div_mensagem_registro_texto_material").empty().append(e.responseText);
				$("#div_mensagem_registro_material").show();
			},
			complete: function () {
				$("#modal_salvar_material").modal("hide");
				$("#carregando_material").addClass("d-none");
			}
		});
	});

	//botão adicionar da tela de listagem de registros
	$("#botao_adicionar_material").click(function (e) {
		e.stopImmediatePropagation();

		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var pagina = $("#pagina_material.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_material").val();

		$("#conteudo").load("material_add.php", function () {
			$("#carregando_material").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "material_add.php",
				data: {
					pagina_material: pagina,
					texto_busca_material: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_material").empty().append(e.responseText);
					$("#div_mensagem_material").show();
				},
				complete: function () {
					$("#carregando_material").addClass("d-none");
				}
			});
		});
	});

	//botão pesquisar da tela de listagem de registros
	$("#botao_pesquisar_material").click(function (e) {
		e.stopImmediatePropagation();

		$("#carregando_material").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "material_index.php",
			data: {
				texto_busca_material: $("#texto_busca_material").val()
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_material").empty().append(e.responseText);
				$("#div_mensagem_material").show();
			},
			complete: function () {
				$("#carregando_material").addClass("d-none");
			}
		});
	});

	//botão editar da tela de listagem de registros
	$(document).on("click", "#botao_editar_material", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_material.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_material").val();

		$("#conteudo").load("material_edit.php", function () {
			$("#carregando_material").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "material_edit.php",
				data: {
					id_material: id,
					pagina_material: pagina,
					texto_busca_material: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_material").empty().append(e.responseText);
					$("#div_mensagem_material").show();
				},
				complete: function () {
					$("#carregando_material").addClass("d-none");
				}
			});
		});
	});

	//botão visualizar da tela de listagem de registros
	$(document).on("click", "#botao_view_material", function (e) {
		e.stopImmediatePropagation();
		//levando os elementos para tela de consulta para depois realizar as buscas/pesquisas
		var id = $(this).attr("chave");
		var pagina = $("#pagina_material.btn.btn-primary.btn-sm").val();
		var texto_busca = $("#texto_busca_material").val();

		$("#conteudo").load("material_view.php", function () {
			$("#carregando_material").removeClass("d-none");

			$.ajax({
				type: "POST",
				cache: false,
				url: "material_view.php",
				data: {
					id_material: id,
					pagina_material: pagina,
					texto_busca_material: texto_busca
				},
				dataType: "html",
				success: function (e) {
					$("#conteudo").empty().append(e);
				},
				error: function (e) {
					$("#div_mensagem_texto_material").empty().append(e.responseText);
					$("#div_mensagem_material").show();
				},
				complete: function () {
					$("#carregando_material").addClass("d-none");
				}
			});
		});
	});

	//botão paginação da tela de listagem de registros
	$(document).on("click", "#pagina_material", function (e) {
		//Aqui como links de botões têm o mesmo nome é necessário parar as chamadas
		e.stopImmediatePropagation();

		var texto_busca = $("#texto_busca_material").val();
		var pagina = $(this).val();
		$("#carregando_material").removeClass("d-none");

		$.ajax({
			type: "POST",
			cache: false,
			url: "material_index.php",
			data: {
				pagina_material: pagina,
				texto_busca_material: texto_busca
			},
			dataType: "html",
			success: function (e) {
				$("#conteudo").empty().append(e);
			},
			error: function (e) {
				$("#div_mensagem_texto_material").empty().append(e.responseText);
				$("#div_mensagem_material").show();
			},
			complete: function () {
				$("#carregando_material").addClass("d-none");
				$("#texto_busca_material").text(texto_busca);
			}
		});
	});

	//botão excluir da tela de listagem de registros
	$(document).on("click", "#botao_excluir_material", function (e) {
		e.stopImmediatePropagation();

		confirmaExclusao(this);
	});

	function confirmaExclusao(registro) {
		$("#modal_excluir_material").modal("show");
		$("#id_excluir_material").val($(registro).attr("chave"));
	}

	//botão sim da pergunta de excluir de listagem de registros
	$("#modal_excluir_sim_material").click(function () {
		excluirRegistro();
	});

	//operação de exclusão do registro
	function excluirRegistro() {
		var registro = new Object();
		var registroJson = null;

		registro.id = $("#id_excluir_material").val();
		registroJson = JSON.stringify(registro);

		$.ajax({
			type: "POST",
			cache: false,
			url: "material_crud.php",
			data: {
				acao: "excluir",
				registro: registroJson
			},
			dataType: "json",
			success: function () {
				$("#div_mensagem_texto_material").empty().append("Material excluído!");
				$("#div_mensagem_material").show();
				$("tr#" + registro.id + "_material").remove();
			},
			error: function (e) {
				$("#div_mensagem_texto_material").empty().append(e.responseText);
				$("#div_mensagem_material").show();
			},
			complete: function () {
				$("#modal_excluir_material").modal("hide");
			}
		});
	}
});