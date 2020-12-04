<div class="modal fade" id="createUserModal">
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
                    <validation-observer v-slot="{ invalid }">    
                        <form method="POST" v-on:submit.prevent="createUser">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        <validation-provider rules="required" v-slot="{ errors }">
                                            <input type="text" class="form-control" name="name" id="newName" v-model="newUserName" aria-describedby="nameHelp" placeholder="Pon tu nombre aquí..." value="{{ old('name') }}">
                                            <small id="nameHelp" class="form-text text-muted">Por ejemplo: Kike Pérez</small>
                                            <span class="text-danger">@{{ errors[0] }}</span>
                                        </validation-provider>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email">Correo:</label>
                                        <validation-provider rules="required|email" v-slot="{ errors }">
                                            <input type="email" class="form-control" name="email" id="newEmail" v-model="newUserEmail" aria-describedby="emailHelp" placeholder="Pon tu correo aquí..." value="{{ old('email') }}">
                                            <span class="text-danger">@{{ errors[0] }}</span>
                                        </validation-provider>
                                        <span class="text-danger" v-text="errors.get('email')"></span>
                                        <small id="emailHelp" class="form-text text-muted">Por ejemplo: kikeperez@hotmail.es</small>
                                    </div>
                                </div>
                            </div>

                            <validation-observer> 
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="password">Clave:</label>
                                            <validation-provider name="password" rules="required|min:6" v-slot="{ errors }">
                                                <input type="password" class="form-control" name="password" id="newPassword" v-model="newUserPassword" aria-describedby="passwordHelp" placeholder="Pon tu clave aquí...">
                                                <span class="text-danger">@{{ errors[0] }}</span>
                                                <small id="passwordHelp" class="form-text text-muted">Mínimo: 6 caracteres</small>
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirmar clave:</label>
                                            <validation-provider rules="required|confirm_password:@password" v-slot="{ errors }">
                                                <input type="password" class="form-control" name="confirm_password" id="newConfirm_password" v-model="newUserConfirm_password" aria-describedby="confirmpasswordHelp">
                                                <span class="text-danger">@{{ errors[0] }}</span>
                                                <small id="confirmpasswordHelp" class="form-text text-muted">Confirma la clave</small>
                                            </validation-provider>
                                        </div>
                                    </div>
                                </div>
                            </validation-observer>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Departamento:</label><br>

                                            <fieldset v-for="department in departments" :key="department.id">
                                                <label>
                                                <validation-provider rules="required" v-slot="{ errors }">
                                                    <input type="radio" :value="department.id" v-model="newUserDepartment" name="department"> @{{ department.name }}<br>
                                                    <span class="text-danger">@{{ errors[0] }}</span>
                                                </validation-provider>
                                                </label>
                                                <br> 
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Profesión:</label><br>

                                            <fieldset v-for="profession in professions" :key="profession.id">
                                                <label>
                                                <validation-provider rules="required" v-slot="{ errors }">
                                                    <input type="radio" :value="profession.id" v-model="newUserProfession" name="profession"> @{{ profession.title }}<br>
                                                    <span class="text-danger">@{{ errors[0] }}</span>
                                                </validation-provider>
                                                </label>
                                                <br> 
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success" :disabled="invalid">Crear usuario</button>

                        </form>
                    </validation-observer>
                </slot>
            </div>
      </div>
    </div>
</div>