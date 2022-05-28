<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD de Funcionário</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js">
	</script>
	<style>
		input[type=text]:focus {
			box-shadow: none;
			border: solid 1px var(#81b3ff);
		}

		input[type=date]:focus {
			box-shadow: none;
			border: solid 1px var(#81b3ff);
		}

		.btn:focus {
			box-shadow: none;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row"></div>
		<div class="row my-5">
			<!-- cadastro -->
			<div class="col-4">
				<div class="card text-center">
					<div class="card-header">
						<b>Cadastro de Funcionário</b>
					</div>
					<div class="card-body">
						<div class="form-group">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default">Nome</span>
								</div>
								<input id="nome" name="nome" type="text" class="form-control" aria-label="Nome" aria-describedby="inputGroup-sizing-default" required>
							</div>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default">CPF</span>
								</div>
								<input id="cpf" name="cpf" type="text" class="form-control" aria-label="CPF" aria-describedby="inputGroup-sizing-default" required>
							</div>
							<div class="mb-2">
								<div class="form-check d-flex">
									<input class="form-check-input" type="radio" name="radioSexo" id="sexoM" value="M" checked>
									<label class="form-check-label ms-2" for="sexoM">
										Masculino
									</label>
								</div>
								<div class="form-check d-flex">
									<input class="form-check-input" type="radio" name="radioSexo" id="sexoF" value="F">
									<label class="form-check-label ms-2" for="sexoF">
										Feminino
									</label>
								</div>
							</div>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default">Data Nascimento</span>
								</div>
								<input id="datanasc" name="datanasc" type="date" class="form-control" aria-label="Data Nascimento" required>
								<span class="" id="codigo"></span>
							</div>

							<button href="#" id="cadastrar" class="btn btn-dark">Cadastrar</button>
							<button href="#" style="display: none;" id="salvar" class="btn btn-warning">Editar Funcionário</button>
						</div>
					</div>
					<div class="card-footer text-muted">
						<b><span class="badge bg-success" id="resultado"></span></b>
					</div>

				</div>
			</div>
			<!-- Modal Deletar Item-->
			<div id="ModalDeletar" class="modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h4>Confirmar exclusão?</h4>
						</div>
						<div class="modal-body">
							<input type="hidden" id="codigoDelete">
							<p>Deseja exlcuir o seguinte funcionário:
								<b class="modal-title" id="deleteAtividade"></b>
							</p>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-primary btn-deletar-nao" data-dismiss="modal">Não</button>
							<button type="button" class="btn btn-danger btn-deletar-sim" data-dismiss="modal" id="confirmarExlcusao">Sim</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Tabela -->
			<div class="col-8" id="tabela">
				<div class="card text-center" >
					<div class="card-header">
						<b>Relatório de Funcionário</b>
					</div>
					<div class="">
						<table class="table table-bordered table-striped">
							<thead>
								<tr class="text-center align-middle">
									<th scope="col">Código</th>
									<th scope="col">Nome</th>
									<th scope="col">CPF</th>
									<th scope="col">Sexo</th>
									<th scope="col">Data Nascimento</th>
									<th scope="col">Operações</th>
								</tr>
							</thead>
							</tbody>
							<tbody id="funcionarios">

							</tbody>
						</table>
					</div>
					<div class="text-muted">
					</div>
				</div>
			</div>

		</div>
		<div class="row"></div>
	</div>
	</div>

	<script>
		function loadData() {
			$.ajax({
				method: "POST",
				url: "../backend/rel_funcionario.php"
			}, ).done(function(resposta) {
				//console.log(resposta)
				var obj = $.parseJSON(resposta);
				var funcionarios = []
				var quantidade = 0;

				if (obj.status != "vazio") {
					$('#tabela').show();
					Object.keys(obj).forEach((item) => {
						var funcionario = $.parseJSON(obj[item])
						funcionarios.push(funcionario)
						quantidade++
					});

					if (quantidade > 0) {
						$('#funcionarios').empty();
						for (var i = 0; i < funcionarios.length; i++) {
							var codigo = funcionarios[i].codigo
							var nome = funcionarios[i].nome
							var cpf = funcionarios[i].cpf
							var sexo = funcionarios[i].sexo
							var data_nascimento = funcionarios[i].data_nascimento

							var dia = data_nascimento.split("-")[0];
							var mes = data_nascimento.split("-")[1];
							var ano = data_nascimento.split("-")[2];

							data_nascimento = ("0" + ano).slice(-2) + '/' + ("0" + mes).slice(-2) + '/' + dia;

							var nova_linha = '';
							var nova_linha =
								'<tr class="text-center align-midle" id="row' + codigo + '">' +
								'<th class="text-center align-midle" scope="row">' + codigo + '</th>' +
								'<td class="text-center align-midle" id="content' + codigo + '">' + nome + '</td>' +
								'<td class="text-center align-midle">' + cpf + '</td>' +
								'<td class="text-center align-midle" >' + sexo + '</td>' +
								'<td class="text-center align-midle">' + data_nascimento + '</td>' +
								'<td class="text-center align-midle"> ' +
								'<button href="#" id="editar' + codigo + '" class="btn btn-sm me-2 btn-warning btn-edit">Editar</button>' +
								'<button href="#" id="excluir' + codigo + '" class="btn btn-sm btn-danger btn-delete">Excluir</button>' +
								'</td>' +
								'</tr>';
							$('#funcionarios').append(nova_linha);

						}
					}

					$("#salvar").hide();
				}
				else if (obj.status == "vazio"){
					//$('#funcionarios').empty();
					$('#tabela').hide();
				}


			})
		}
		$(document).ready(function() {
			$.ajax({
				method: "POST",
				url: "../backend/rel_funcionario.php"
			}, ).done(function(resposta) {
				//console.log(resposta)
				var obj = $.parseJSON(resposta);
				var funcionarios = []
				var quantidade = 0;

				if (obj.status != "vazio") {
					Object.keys(obj).forEach((item) => {
						var funcionario = $.parseJSON(obj[item])
						funcionarios.push(funcionario)
						quantidade++
					});
					if (quantidade > 0) {
						$('#funcionarios').empty();
						for (var i = 0; i < funcionarios.length; i++) {
							var codigo = funcionarios[i].codigo
							var nome = funcionarios[i].nome
							var cpf = funcionarios[i].cpf
							var sexo = funcionarios[i].sexo
							var data_nascimento = funcionarios[i].data_nascimento

							var dia = data_nascimento.split("-")[0];
							var mes = data_nascimento.split("-")[1];
							var ano = data_nascimento.split("-")[2];

							data_nascimento = ("0" + ano).slice(-2) + '/' + ("0" + mes).slice(-2) + '/' + dia;

							var nova_linha = '';
							var nova_linha =
								'<tr class="text-center align-midle" id="row' + codigo + '">' +
								'<th class="text-center align-midle" scope="row">' + codigo + '</th>' +
								'<td class="text-center align-midle" id="content' + codigo + '">' + nome + '</td>' +
								'<td class="text-center align-midle">' + cpf + '</td>' +
								'<td class="text-center align-midle" >' + sexo + '</td>' +
								'<td class="text-center align-midle">' + data_nascimento + '</td>' +
								'<td class="text-center align-midle"> ' +
								'<button href="#" id="editar' + codigo + '" class="btn btn-sm me-2 btn-warning btn-editar">Editar</button>' +
								'<button href="#" id="excluir' + codigo + '" class="btn btn-sm btn-danger btn-delete">Excluir</button>' +
								'</td>' +
								'</tr>';
							$('#funcionarios').append(nova_linha);

						}
						$("#salvar").hide();
					}
				} else {
					loadData()
				}
			})
		});

		$("#cadastrar").click(
			function() {
				$("#resultado").text("");
				var nome = $("#nome").val();
				var cpf = $("#cpf").val();
				var sexo = $("input[name='radioSexo']:checked").val();
				var datanasc = $("#datanasc").val();

				$.ajax({
					method: "POST",
					url: "../backend/cad_funcionario.php",
					data: {
						nome: nome,
						cpf: cpf,
						sexo: sexo,
						datanasc: datanasc
					}
				}).done(
					function(resposta) {
						var obj = $.parseJSON(resposta);

						if (obj.status == 'incomplete') {

							$("#resultado").addClass('bg-warning');
							$("#resultado").html(obj.resultado);
							setTimeout(function() {
								$('#resultado').hide();
								$("#resultado").removeClass('bg-warning');
							}, 2000);

							clearFields();
						}
						if (obj.status == 'cadastrado') {
							$("#resultado").html(obj.resultado);
							clearFields()
							loadData();

						}
					}
				);
			}
		);

		function editItem(row) {
			var index = row;
			$.ajax({
				method: "POST",
				url: "../backend/edit_funcionario.php",
				data: {
					index: index,
					operation: "edit"
				}
			}).done(function(resposta) {
				var obj = $.parseJSON(resposta);
				var codigo = obj.codigo;
				var nome = obj.nome;
				var cpf = obj.cpf;
				var sexo = obj.sexo;
				var data_nascimento = obj.data_nascimento;

				fillFields(codigo, nome, cpf, sexo, data_nascimento);

				$("#cadastrar").hide();
				$("#salvar").show();
				$("#resultado").html("Funcionário Editado")
				$("#resultado").removeClass('bg-success');
				$("#resultado").addClass('bg-warning');
				setTimeout(function() {
					$('#resultado').hide();
				}, 2000);
				$("#resultado").removeClass('bg-warning');

			});
		}

		function updateFuncionario(codigo, nome, cpf, sexo, datanasc) {
			$.ajax({
				method: "POST",
				url: "../backend/edit_funcionario.php",
				data: {
					operation: "update",
					codigo: codigo,
					nome: nome,
					cpf: cpf,
					sexo: sexo,
					datanasc: datanasc
				}
			}).done(function(resposta) {
				loadData()
				clearFields()
				$("#resultado").text("Funcionário editado");
				$("#resultado").removeClass('bg-success');
				$("#resultado").addClass('bg-warning');
				setTimeout(function() {
					$('#resultado').hide();
				}, 2000);
				$("#resultado").removeClass('bg-warning');
			});
		}

		$(document).on("click", 'button', function(element) {
			var id = element.currentTarget.id;

			if (id.includes("editar")) {
				var row = id.replace("editar", "");
				editItem(row)

			} else if (id.includes("salvar")) {
				var row = id.replace("editar", "");
				var codigo = $("#codigo").val();
				var nome = $("#nome").val();
				var cpf = $("#cpf").val();
				var sexo = $("input[name='radioSexo']:checked").val();
				var datanasc = $("#datanasc").val();

				updateFuncionario(codigo, nome, cpf, sexo, datanasc);
				$("#cadastrar").show();
				$("#salvar").hide();

			} else if (id.includes("excluir")) {
				var row = id.replace("excluir", "");
				var contentId = "#content" + row;
				//Pega o HTML da linha
				$("#deleteAtividade").text($(contentId).html());
				//Passa o codigo do cliente para um input invisivel
				$("#codigoDelete").val(row);
				$("#ModalDeletar").modal('show');
			}
		})

		$('#confirmarExlcusao').click(function() {
			deleteFuncionario($("#codigoDelete").val());
			$("#row" + $("#codigoDelete").val()).remove();
			$("#codigoDelete").val("");
			$("#deleteAtividade").text("");
			$("#ModalDeletar").modal('hide');
			loadData();
		});

		function deleteFuncionario(row) {
			var index = row;
			$.ajax({
				method: "POST",
				url: "../backend/edit_funcionario.php",
				data: {
					operation: "delete",
					codigo: index
				}
			}).done(function(resposta) {
				$("#resultado").text("Funcionário excluído");
				$("#resultado").removeClass('bg-success');
				$("#resultado").addClass('bg-danger');

				setTimeout(function() {
					$('#resultado').hide();
				}, 2000);
				$("#resultado").removeClass('bg-danger');
				loadData()

			});
		}

		function fillFields(codigo, nome, cpf, sexo, data_nascimento) {
			$('#codigo').val(codigo)
			$("#nome").val(nome);
			$("#cpf").val(cpf);
			if (sexo == "M") {
				$("#sexoM").prop("checked", true);
			} else {
				$("#sexoF").prop("checked", true);
			}
			$("#datanasc").val(data_nascimento);
		}

		function clearFields() {
			$("#codigo").val("");
			$("#nome").val("");
			$("#cpf").val("");
			$("#sexoM").prop("checked", true);
			$("#datanasc").val("");
		}



		datanasc.max = new Date().toISOString().split("T")[0];

		$(document).ready(function() {
			var $seuCampoCpf = $("#cpf");
			$seuCampoCpf.mask('000.000.000-00', {
				reverse: false
			});
		});

		jQuery(':input').keyup(function() {
			$(this).val($(this).val().toUpperCase());
		});
	</script>

</body>

</html>