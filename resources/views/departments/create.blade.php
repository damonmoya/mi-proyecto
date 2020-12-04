<div class="modal fade" id="createDepartmentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crear departamento</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <slot>
                    {{--Sección de formulario--}}     
                    <validation-observer v-slot="{ invalid }">       
                        <form method="POST" v-on:submit.prevent="createDepartment">

                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <validation-provider rules="required" v-slot="{ errors }">
                                    <input type="text" class="form-control" name="name" id="newName" v-model="newDepartmentName" aria-describedby="nameHelp" placeholder="Nombre de departamento..." value="{{ old('name') }}">
                                    <small id="nameHelp" class="form-text text-muted">Por ejemplo: Desarrollo</small>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <div class="form-group">
                                <label for="director">Director:</label>
                                <validation-provider rules="required" v-slot="{ errors }">
                                    <input type="text" class="form-control" name="director" id="newDirector" v-model="newDepartmentDirector" aria-describedby="directorHelp" placeholder="Nombre del director..." value="{{ old('director') }}">
                                    <small id="directorHelp" class="form-text text-muted">Por ejemplo: Pepe Mel</small>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <div class="form-group">
                                <label>Tipo de director:</label>
                                <validation-provider rules="required" v-slot="{ errors }">
                                    <fieldset id="newDirector_type">
                                        <label>
                                            <input type="radio" value="En propiedad" name="director_type" v-model="newDepartmentDirector_type"> En propiedad
                                        </label>
                                        <label>
                                            <input type="radio" value="En funciones" name="director_type" v-model="newDepartmentDirector_type"> En funciones 
                                        </label>
                                    </fieldset>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Empresa:</label>
                                        <validation-provider rules="required" v-slot="{ errors }">
                                            <fieldset v-for="company in companies" :key="company.id">
                                                <label>
                                                    <input type="radio" :value="company.id" v-model="newDepartmentCompany" @change="onChange($event)" name="company"> @{{ company.name }}<br>
                                                </label>
                                                <br> 
                                            </fieldset>
                                            <span class="text-danger">@{{ errors[0] }}</span>
                                        </validation-provider>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Departamento dependiente:</label><br>
                                        <validation-provider rules="required" v-slot="{ errors }">
                                            <fieldset>
                                                <input type="radio" value="no" v-model="newDepartmentDependent" name="dependent" checked> No<br>
                                            </fieldset>
                                            <fieldset v-for="dependent in dependents" :key="dependent.id">
                                                <label>
                                                    <input type="radio" :value="dependent.id" v-model="newDepartmentDependent" name="dependent"> @{{ dependent.name }}<br>
                                                </label>
                                                <br> 

                                            </fieldset>
                                            <span class="text-danger">@{{ errors[0] }}</span>
                                        </validation-provider>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="budget">Presupuesto:</label>
                                <validation-provider rules="required|numeric|between:10000,100000" v-slot="{ errors }">
                                    <input type="number" class="form-control" name="budget" id="newBudget" v-model="newDepartmentBudget" aria-describedby="budgetHelp" value="10000">
                                    <small id="budgetHelp" class="form-text text-muted">Introduce el presupuesto (entre 10.000 y 100.000)</small>
                                    <span class="text-danger">@{{ errors[0] }}</span>
                                </validation-provider>
                            </div>

                            <button type="submit" class="btn btn-success" :disabled="invalid">Crear Departamento</button>
                        </form>
                    </validation-observer>
                </slot>
            </div>
      </div>
    </div>
</div>