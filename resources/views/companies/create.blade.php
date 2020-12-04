<div class="modal fade" id="createCompanyModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crear empresa</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <slot>
                    {{--Sección de formulario--}}  
                    <validation-observer v-slot="{ invalid }">          
                        <form method="POST" id="crtCompForm" v-on:submit.prevent="createCompany">

                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <validation-provider rules="required" v-slot="{ errors }">
                                    <input type="text" class="form-control" name="name" id="newName" v-model="newCompanyName" aria-describedby="nameHelp" placeholder="Nombre de empresa..." value="{{ old('name') }}">
                                    <small id="nameHelp" class="form-text text-muted">Por ejemplo: Digital Art & Designers</small>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <div class="form-group">
                                <label for="address">Dirección:</label>
                                <validation-provider rules="required" v-slot="{ errors }">
                                    <input type="text" class="form-control" name="address" id="newAddress" v-model="newCompanyAddress" aria-describedby="addressHelp" placeholder="Pon tu correo aquí..." value="{{ old('address') }}">
                                    <small id="addressHelp" class="form-text text-muted">Por ejemplo: Agustín Millares Carló, 18. Las Palmas, España</small>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <div class="form-group">
                                <label for="description">Descripción:</label><br>
                                <validation-provider rules="required|min:20" v-slot="{ errors }">
                                    <textarea rows="4" cols="50" class="form-control" name="description" id="newDescription" v-model="newCompanyDescription" form="crtCompForm" aria-describedby="descriptionHelp">
                                    {{ old('description') }}
                                    </textarea>
                                    <small id="descriptionHelp" class="form-text text-muted">Mínimo: 20 caracteres</small>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <div class="form-group">
                                <label for="contact">Contacto:</label>
                                <validation-provider :rules="{ regex: /[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}/ }" rules="required" v-slot="{ errors }">
                                    <input type="tel" class="form-control" name="contact" id="newContact" v-model="newCompanyContact" aria-describedby="contactHelp" pattern="[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}" value="{{ old('contact') }}">
                                    <small id="contactHelp" class="form-text text-muted">Formato: 123 45 67 89</small>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <button type="submit" class="btn btn-success" :disabled="invalid">Crear empresa</button>

                        </form>
                    </validation-observer>
                </slot>
            </div>
      </div>
    </div>
</div>
