<div class="modal" id="createUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crear usuario</h4>
                <button type="button" class="close" data-dismiss="modal" v-on:click.prevent="clearErrors()"><span>&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <slot>
                    {{--Sección de formulario--}}        
                    <form method="POST" v-on:submit.prevent="createUser">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control" name="name" id="newName" v-model="newUserName" aria-describedby="nameHelp" placeholder="Pon tu nombre aquí..." value="{{ old('name') }}">
                                    <small id="nameHelp" class="form-text text-muted">Por ejemplo: Kike Pérez</small>
                                    <span class="text-danger" v-text="errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Correo:</label>
                                    <input type="email" class="form-control" name="email" id="newEmail" v-model="newUserEmail" aria-describedby="emailHelp" placeholder="Pon tu correo aquí..." value="{{ old('email') }}">
                                    <small id="emailHelp" class="form-text text-muted">Por ejemplo: kikeperez@hotmail.es</small>
                                    <span class="text-danger" v-text="errors.get('email')"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password">Clave:</label>
                                    <input type="password" class="form-control" name="password" id="newPassword" v-model="newUserPassword" aria-describedby="passwordHelp" placeholder="Pon tu clave aquí...">
                                    <small id="passwordHelp" class="form-text text-muted">Mínimo: 6 caracteres</small>
                                    <span class="text-danger" v-text="errors.get('password')"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirmar clave:</label>
                                    <input type="password" class="form-control" name="confirm_password" id="newConfirm_password" v-model="newUserConfirm_password" aria-describedby="confirmpasswordHelp">
                                    <small id="confirmpasswordHelp" class="form-text text-muted">Confirma la clave</small>
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
                                                <input type="radio" :value="department.id" v-model="newUserDepartment" name="department"> @{{ department.name }}<br>
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
                                                <input type="radio" :value="profession.id" v-model="newUserProfession" name="profession"> @{{ profession.title }}<br>
                                            </label>
                                            <br> 
                                        </fieldset>
                                        <span class="text-danger" v-text="errors.get('profession_id')"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Crear usuario</button>

                    </form>
                </slot>
            </div>
      </div>
    </div>
</div>