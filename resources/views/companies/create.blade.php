<div class="modal fade" id="createCompanyModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crear empresa</h4>
                <button type="button" class="close" data-dismiss="modal" v-on:click.prevent="clearErrors()"><span>&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <slot>
                {{--Sección de formulario--}}        
                <form method="POST" id="crtCompForm" v-on:submit.prevent="createCompany">

                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" name="name" id="newName" v-model="newCompanyName" aria-describedby="nameHelp" placeholder="Nombre de empresa..." value="{{ old('name') }}">
                        <small id="nameHelp" class="form-text text-muted">Por ejemplo: Digital Art & Designers</small>
                        <span class="text-danger" v-text="errors.get('name')"></span>
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección:</label>
                        <input type="text" class="form-control" name="address" id="newAddress" v-model="newCompanyAddress" aria-describedby="addressHelp" placeholder="Pon tu correo aquí..." value="{{ old('address') }}">
                        <small id="addressHelp" class="form-text text-muted">Por ejemplo: Agustín Millares Carló, 18. Las Palmas, España</small>
                        <span class="text-danger" v-text="errors.get('address')"></span>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción:</label><br>
                        <textarea rows="4" cols="50" class="form-control" name="description" id="newDescription" v-model="newCompanyDescription" form="crtCompForm" aria-describedby="descriptionHelp">
                        {{ old('description') }}
                        </textarea>
                        <small id="descriptionHelp" class="form-text text-muted">Mínimo: 20 caracteres</small>
                        <span class="text-danger" v-text="errors.get('description')"></span>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contacto:</label>
                        <input type="tel" class="form-control" name="contact" id="newContact" v-model="newCompanyContact" aria-describedby="contactHelp" pattern="[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}" value="{{ old('contact') }}">
                        <small id="contactHelp" class="form-text text-muted">Formato: 123 45 67 89</small>
                        <span class="text-danger" v-text="errors.get('contact')"></span>
                    </div>

                    <button type="submit" class="btn btn-success">Crear empresa</button>

                    </form>
                </slot>
            </div>
      </div>
    </div>
</div>
