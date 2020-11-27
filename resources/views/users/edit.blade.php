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

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control" name="name" id="name" v-model="fillUser.name" aria-describedby="nameHelp" placeholder="Pon tu nombre aquí...">
                                    <small id="nameHelp" class="form-text text-muted">Por ejemplo: Kike Pérez</small>
                                    <span class="text-danger" v-text="errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Correo:</label>
                                    <input type="email" class="form-control" name="email" id="email" v-model="fillUser.email" aria-describedby="emailHelp" placeholder="Pon tu correo aquí...">
                                    <small id="emailHelp" class="form-text text-muted">Por ejemplo: kikeperez@hotmail.es</small>
                                    <span class="text-danger" v-text="errors.get('email')"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password">Clave:</label>
                                    <input type="password" class="form-control" name="password" id="password" v-model="fillUser.password" aria-describedby="passwordHelp" placeholder="Pon tu clave aquí...">
                                    <small id="passwordHelp" class="form-text text-muted">Mínimo: 6 caracteres. Dejar en blanco si no se desea cambiar</small>
                                    <span class="text-danger" v-text="errors.get('password')"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirmar clave:</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" v-model="fillUser.confirm_password" aria-describedby="confirmpasswordHelp">
                                    <small id="confirmpasswordHelp" class="form-text text-muted">Confirma la clave, en caso de cambiarla</small>
                                    <span class="text-danger" v-text="errors.get('confirm_password')"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Departamento:</label><br>

                                        <fieldset v-for="department in departments" :key="department.id">
                                            <label>
                                                <input type="radio" :value="department.id" v-model="fillUser.department_id" name="department"> @{{ department.name }}<br>
                                            </label>
                                            <br> 
                                        </fieldset>
                                        <span class="text-danger" v-text="errors.get('department_id')"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Profesión:</label><br>

                                        <fieldset v-for="profession in professions" :key="profession.id">
                                            <label>
                                                <input type="radio" :value="profession.id" v-model="fillUser.profession_id" name="profession"> @{{ profession.title }}<br>
                                            </label>
                                            <br> 
                                        </fieldset>
                                        <span class="text-danger" v-text="errors.get('profession_id')"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Editar usuario</button>
                        
                    </form>
                </slot>
            </div>
      </div>
    </div>
</div>
