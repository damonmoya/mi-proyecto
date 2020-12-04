<div class="modal fade" id="editUserModal">
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
                    <validation-observer v-slot="{ invalid }">         
                        <form method="POST" v-on:submit.prevent="updateUser(fillUser.id)">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        <validation-provider rules="required" v-slot="{ errors }">
                                            <input type="text" class="form-control" name="name" id="name" v-model="fillUser.name" aria-describedby="nameHelp" placeholder="Pon tu nombre aquí...">
                                            <small id="nameHelp" class="form-text text-muted">Por ejemplo: Kike Pérez</small>
                                            <span class="text-danger">@{{ errors[0] }}</span>
                                        </validation-provider>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email">Correo:</label>
                                        <validation-provider rules="required|email" v-slot="{ errors }">
                                            <input type="email" class="form-control" name="email" id="email" v-model="fillUser.email" aria-describedby="emailHelp" placeholder="Pon tu correo aquí...">
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
                                            <validation-provider name="password" vid="password" rules="min:6" v-slot="{ errors }">
                                                <input type="password" class="form-control" name="password" id="password" v-model="fillUser.password" aria-describedby="passwordHelp" placeholder="Pon tu clave aquí...">
                                                <span class="text-danger">@{{ errors[0] }}</span>
                                                <small id="passwordHelp" class="form-text text-muted">Mínimo: 6 caracteres. Dejar en blanco si no se desea cambiar</small>
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirmar clave:</label>
                                            <validation-provider rules="required_if:password|confirm_password:@password" v-slot="{ errors }">
                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" v-model="fillUser.confirm_password" aria-describedby="confirmpasswordHelp">
                                                <span class="text-danger">@{{ errors[0] }}</span>
                                                <small id="confirmpasswordHelp" class="form-text text-muted">Confirma la clave, en caso de cambiarla</small>
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
                                                    <validation-provider v-slot="{ errors }">
                                                        <input type="radio" :value="department.id" v-model="fillUser.department_id" name="department"> @{{ department.name }}<br>
                                                        <span class="text-danger">@{{ errors[0] }}</span>
                                                    </validation-provider>
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
                                                    <validation-provider rules="required" v-slot="{ errors }">
                                                        <input type="radio" :value="profession.id" v-model="fillUser.profession_id" name="profession"> @{{ profession.title }}<br>
                                                        <span class="text-danger">@{{ errors[0] }}</span>
                                                    </validation-provider>
                                                </label>
                                                <br> 
                                            </fieldset>
                                            <span class="text-danger" v-text="errors.get('profession_id')"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success" :disabled="invalid">Editar usuario</button>

                        </form>
                </slot>
            </div>
      </div>
    </div>
</div>
