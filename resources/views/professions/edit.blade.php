<div class="modal" id="editProfessionModal">
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
                    <form method="POST" v-on:submit.prevent="updateProfession(fillProfession.id)">

                        <div class="form-group">
                            <label for="title">Nombre:</label>
                            <input type="text" class="form-control" name="title" id="title" v-model="fillProfession.title" aria-describedby="titleHelp" placeholder="Nombre...">
                            <small id="titleHelp" class="form-text text-muted">Por ejemplo: Coordinador</small>
                            <span class="text-danger" v-text="errors.get('title')"></span>
                        </div>
                            
                        <button type="submit" class="btn btn-success">Editar profesión</button>

                    </form>
                </slot>
            </div>
      </div>
    </div>
</div>