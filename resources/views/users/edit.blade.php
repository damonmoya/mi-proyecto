<div class="modal" id="editUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Editar usuario</h4>
                <button type="button" class="close" data-dismiss="modal" v-on:click.prevent="clearErrors()"><span>&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <slot>
                    {{--Sección de formulario--}}        
                    <form method="POST" v-on:submit.prevent="updateUser(fillUser.id)">

                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" class="form-control" name="name" id="name" v-model="fillUser.name" aria-describedby="nameHelp" placeholder="Pon tu nombre aquí...">
                            <small id="nameHelp" class="form-text text-muted">Por ejemplo: Kike Pérez</small>
                            <span class="text-danger" v-text="errors.get('name')"></span>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo:</label>
                            <input type="email" class="form-control" name="email" id="email" v-model="fillUser.email" aria-describedby="emailHelp" placeholder="Pon tu correo aquí...">
                            <small id="emailHelp" class="form-text text-muted">Por ejemplo: kikeperez@hotmail.es</small>
                            <span class="text-danger" v-text="errors.get('email')"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Clave:</label>
                            <input type="password" class="form-control" name="password" id="password" v-model="fillUser.password" aria-describedby="passwordHelp" placeholder="Pon tu clave aquí...">
                            <small id="passwordHelp" class="form-text text-muted">Mínimo: 6 caracteres. Dejar en blanco si no se desea cambiar</small>
                            <span class="text-danger" v-text="errors.get('password')"></span>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirmar clave:</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" v-model="fillUser.confirm_password" aria-describedby="confirmpasswordHelp">
                            <small id="confirmpasswordHelp" class="form-text text-muted">Confirma la clave, en caso de cambiarla</small>
                            <span class="text-danger" v-text="errors.get('confirm_password')"></span>
                        </div>

                        <button type="submit" class="btn btn-success">Editar usuario</button>
                        
                    </form>
                </slot>
            </div>
      </div>
    </div>
</div>
