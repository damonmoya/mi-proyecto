<div class="modal fade" id="editProfessionModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Editar profesión</h4>
                <button type="button" class="close" data-dismiss="modal" v-on:click.prevent="clearErrors()"><span>&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <slot>
                    {{--Sección de formulario--}}   
                    <validation-observer v-slot="{ invalid }">              
                        <form method="POST" v-on:submit.prevent="updateProfession(fillProfession.id)">

                            <div class="form-group">
                                <label for="title">Nombre:</label>
                                <validation-provider rules="required" v-slot="{ errors }">
                                    <input type="text" class="form-control" name="title" id="title" v-model="fillProfession.title" aria-describedby="titleHelp" placeholder="Nombre...">
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                    <small id="titleHelp" class="form-text text-muted">Por ejemplo: Coordinador</small>
                                </validation-provider>
                            </div>

                            <button type="submit" class="btn btn-success" :disabled="invalid">Editar profesión</button>
                        </form>
                    </validation-observer>
                </slot>
            </div>
      </div>
    </div>
</div>