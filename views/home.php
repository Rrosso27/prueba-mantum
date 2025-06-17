<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>

<div class="mt-4 d-flex justify-content-center align-items-center">
    <div class="card" style="width: 50rem;">
        <div class="card-body">
            <form id="formulario">
                <div id="alert"></div>
                <div class="row d-flex justify-content-center align-items-center">
                    <input type="hidden" name="id" id="id">
                    <div class="col-auto">
                        <div class="mb-4">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Jose Perez" style="width: 300px;">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="mb-4">
                            <label for="cedula" class="form-label">cedula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="121212" style="width: 300px;">
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-auto">
                        <div class="mb-4">
                            <label for="fecha_nacimiento" class="form-label">Fecha De Nacimiento</label>5
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="name@example.com" style="width: 300px;">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="mb-4">
                            <label for="sexo" class="form-label">Email address</label>
                            <select class="form-select" id="sexo" name="sexo" aria-label="Default select example" style="width: 300px;">
                                <option selected>Open this select menu</option>
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                    <button href="#" class="btn btn-primary" style="width: 50%;">Guardar</button>

                    <a href="#" onclick="limpiarFormulario()" class="btn btn-warning" style="width: 50%;">Limpiar formulario </a>

                </div>
            </form>

        </div>
    </div>

</div>


<div class="mt-4 d-flex justify-content-center align-items-center">
    <div class="card" style="width: 50rem;">
        <div class="card-body">
            <h5 class="card-title">Usuarios Registrados</h5>
            <div id="listUsers">
                <!-- Aquí se mostrarán los usuarios -->
            </div>
        </div>
    </div>
</div>



<script>
    document.getElementById('cedula').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '');
    });
    $(document).ready(function() {
        getUsuarios();
        $('#formulario').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append("action", "store");
            $.ajax({
                url: "router/api.php?action=createUsuario",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status === 'error') {

                        document.getElementById('alert').innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
                    } else if (response.status === 'success') {
                        $('#alert').html('<div class="alert alert-success">' + response.message + '</div>');
                    }
                    setTimeout(function() {
                        $('#alert').html('');
                    }, 4000);
                    limpiarFormulario();
                    getUsuarios();
                },
                error: function(xhr, status, error) {
                    document.getElementById('alert').innerHTML = '<div class="alert alert-danger">Error al procesar la solicitud.</div>';
                    console.error('Error:', error);
                }

            });
        })
    });

    function getUsuarios() {
        $.ajax({
            url: "router/api.php?action=getUsuarios",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'error') {
                    document.getElementById('alert').innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
                } else if (response.status === 'success') {
                    console.log(response.data);
                    let listUsers = document.getElementById('listUsers');
                    listUsers.innerHTML = '';
                    response.data.forEach(function(usuario) {
                        let userCard = document.createElement('div');
                        userCard.className = 'card mb-3';
                        userCard.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title">${usuario.nombre}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Cédula: ${usuario.cedula}</h6>
                                <p class="card-text">Fecha de Nacimiento: ${usuario.fecha_nacimiento}</p>
                                <p class="card-text">Sexo: ${usuario.sexo}</p>
                                <div class="d-flex justify-content-between">
                                    <a href="#" onclick="getUsuariosById(${usuario.id})" class="btn btn-success" style="width: 45%;">Actualizar</a>
                                    <!-- Button trigger modal -->
                                    <button type="button"   class="btn btn-danger"  style="width: 45%;" data-bs-toggle="modal" data-bs-target="#userModal${usuario.id}">
                                        Eliminar
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="userModal${usuario.id}" tabindex="-1" aria-labelledby="usersModalLabel${usuario.id}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="usersModalLabel${usuario.id}"></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Está seguro de que desea eliminar este usuario?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                 <a type="button" href="#"  data-bs-dismiss="modal" onclick="deleteUsuario(${usuario.id})" class="btn btn-danger">Si</a>
                                </div>
                                </div>
                            </div>
                            </div>

                        `;
                        listUsers.appendChild(userCard);
                    });
                }
            },
            error: function(xhr, status, error) {
                document.getElementById('alert').innerHTML = '<div class="alert alert-danger">Error al obtener los usuarios.</div>';
            }
        });
    }

    function getUsuariosById(id) {
        $.ajax({
            url: "router/api.php?action=getUsuarioById&id=" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'error') {
                    document.getElementById('alert').innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
                    setTimeout(function() {
                        $('#alert').html('');
                    }, 4000);
                } else if (response.status === 'success') {
                    // Aquí puedes manejar la respuesta y mostrar los usuarios
                    console.log(response.data);
                    document.getElementById('id').value = response.data.id;
                    document.getElementById('nombre').value = response.data.nombre;
                    document.getElementById('cedula').value = response.data.cedula;
                    document.getElementById('fecha_nacimiento').value = response.data.fecha_nacimiento;
                    document.getElementById('sexo').value = response.data.sexo;


                }
            },
            error: function(xhr, status, error) {
                document.getElementById('alert').innerHTML = '<div class="alert alert-danger">Error al obtener los usuarios.</div>';
            }
        });
    }

    function deleteUsuario(id) {
        $.ajax({
            url: "router/api.php?action=deleteUsuario&id=" + id,
            type: "DELETE",
            dataType: "json",
            success: function(response) {
                if (response.status === 'error') {
                    document.getElementById('alert').innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
                } else if (response.status === 'success') {
                    document.getElementById('alert').innerHTML = '<div class="alert alert-success">' + response.message + '</div>';
                    getUsuarios(); // Actualizar la lista de usuarios
                }
                setTimeout(function() {
                    $('#alert').html('');
                }, 4000);
            },
            error: function(xhr, status, error) {
                document.getElementById('alert').innerHTML = '<div class="alert alert-danger">Error al eliminar el usuario.</div>';
            }
        });
    }

    // limpiar formulario
    function limpiarFormulario() {
        document.getElementById('formulario').reset();
    }
    // listrar 
</script>

<?php include 'layout/footer.php'; ?>