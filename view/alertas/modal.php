<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#miModal" data-whatever="@mdo"><i class="fa fa-whatsapp nav-icon" aria-hidden="true"></i> Enviar Pre-Compra</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Realizar Pedidos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioUsuario">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label class="col-form-label">Proveedor:</label>
                        <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                            <option value="">Seleccione...</option>
                            <!-- Aquí se generan las opciones de proveedores dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="col-form-label">Dirección:</label>
                        <label class="form-control" id="direccion_label" name="direccion" readonly></label>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="col-form-label">Email:</label>
                        <label class="form-control" id="email" name="email" readonly></label>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-form-label">Teléfono:</label>
                        <label class="form-control" id="telefono_label" name="telefono" readonly></label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary m-1" id="EnviarMensaje">Enviar Pedido</button>
            </div>
        </div>
    </div>
</div>
<script>
    let emailProveedor = "";
    let telfProveedor = "";
    fetch("../../controllers/router.php?op=getProveedores")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Hubo un problema al obtener los datos de los proveedores.");
            }
            return response.json();
        })
        .then((data) => {
            const selectProveedor = document.getElementById("id_proveedor");
            selectProveedor.innerHTML = "";
            const defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "Seleccione...";
            selectProveedor.appendChild(defaultOption);
            data.forEach((proveedor) => {
                const option = document.createElement("option");
                option.value = proveedor.id;
                option.textContent = proveedor.nombre;
                selectProveedor.appendChild(option);
            });

            function actualizarInfoProveedor() {
                var seleccionado = selectProveedor.value;
                var proveedor = data.find(p => p.id == seleccionado);
                emailProveedor = proveedor ? proveedor.email : '';
                telfProveedor = proveedor ? proveedor.telefono : '';
                document.getElementById("email").textContent = proveedor ? proveedor.email : '';
                document.getElementById("direccion_label").textContent = proveedor ? proveedor.direccion : ''; // Si el proveedor existe, mostrar su dirección, de lo contrario, dejar vacío
                document.getElementById("telefono_label").textContent = proveedor ? proveedor.telefono : ''; // Si el proveedor existe, mostrar su teléfono, de lo contrario, dejar vacío
            }
            selectProveedor.addEventListener("change", actualizarInfoProveedor);
            actualizarInfoProveedor();
        })
        .catch((error) => {
            console.error("Error al obtener los datos de los proveedores:", error);
        });
</script>