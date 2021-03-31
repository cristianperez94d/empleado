<template>
    <div class="container">
        
        <div class="container">
            <h2 class="text-secondary text-center">{{datoAgregar ? 'Agregar Empleados': 'Actualizar Empleados'}}</h2>
            <form @submit.prevent="submitForm()">
                <div class="row mb-3 text-center">
                    <label class="col-sm-2 col-form-label text-right">Nombre Completo * </label>
                    <div class="col-sm-10">
                        <input v-model="empleado.nombre" class="form-control" type="text" placeholder="Ingrese el nombre completo...">
                    </div>
                </div>
                <div class="row mb-3 text-center">
                    <label class="col-sm-2 col-form-label text-right">Correo electronico * </label>
                    <div class="col-sm-10">
                        <input v-model="empleado.email" class="form-control" type="email" placeholder="Ingrese correo">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2 text-right">Sexo*</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input v-model="empleado.sexo" class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="M">
                            <label class="form-check-label" for="gridRadios1">
                            Masculino
                            </label>
                        </div>
                        <div class="form-check">
                            <input v-model="empleado.sexo" class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="F">
                            <label class="form-check-label" for="gridRadios2">
                            Femenino
                            </label>
                        </div>                    
                    </div>
                </div>

                <div class="row mb-3 text-center">
                    <label class="col-sm-2 col-form-label text-right">Area *</label>
                    <div class="col-sm-10">
                        <select v-model="empleado.area_id" class="custom-select">
                            <option value="0">Seleccione una Opcion</option>
                            <option 
                                v-for="(area, index) in areas" :key="index" 
                                :value="area.id">{{area.nombre}}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3 text-center">
                    <label class="col-sm-2 col-form-label text-right">Descripcion* </label>
                    <div class="col-sm-10">
                        <textarea v-model="empleado.descripcion" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ingrese una descripcion...."></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-right">Boletin </label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input v-model="empleado.boletin" class="form-check-input" type="checkbox" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Deseo recibir boletin informativo
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-right">Roles *</label>
                    <div class="col-sm-10">
                        <div v-for="(rol, index) in roles" :key="index" class="form-check">
                            <input v-model="checkedRoles" :value="rol.id" class="form-check-input" type="checkbox" :id="'check'+index">
                            <label class="form-check-label" :for="'check'+index">
                                {{rol.nombre}}
                            </label>
                        </div>
                    </div>
                </div>
                                
                <div  class="text-center mb-3">
                    <button class="col-12 col-sm-7 col-md-4 btn btn-sm btn-primary">{{datoAgregar ? 'Agregar Empleado' : 'Actualizar Empleado'}}</button>
                    <button v-if="!datoAgregar" @click="cancelarSubmit()" type="button" class="col-12 col-sm-7 col-md-4 btn btn-sm btn-secondary">Cancelar</button>
                </div>

                <div v-if="alert.visible" class="alert" :class="alert.type">
                    {{alert.message}}
                </div>
            </form>
        </div>

        <hr/>

        <h2 class="text-secondary text-center">Lista de Empleados</h2>
        <table class="table table-sm table-striped">
            <thead class="bg-primary text-light">
                <tr>
                    <th><font-awesome-icon icon="user"/> Nombre</th>
                    <th><font-awesome-icon icon="envelope"/> Email</th>
                    <th><font-awesome-icon icon="venus-mars"/> Sexo</th>
                    <th><font-awesome-icon icon="chart-area"/> Area</th>
                    <th><font-awesome-icon icon="home"/> Boletin</th>
                    <th class="text-center">Modificar</th>
                    <th class="text-center">Eliminar</th>
                </tr>
            </thead> 

            <tbody v-if="empleados.length > 0">
                <tr v-for="(empleado,index) in empleados" :key="index">
                    <td>{{ empleado.nombre }}</td>
                    <td>{{ empleado.email }}</td>
                    <td>{{ empleado.sexo }}</td>
                    <td>{{ empleado.area.nombre }}</td>
                    <td>{{ empleado.boletin == 1 ? 'Si' : 'No' }}</td>
                    <td class="text-center">
                        <button @click="editar(empleado.id)"><font-awesome-icon class="text-warning" icon="edit"/></button>
                    </td>
                    <td class="text-center text-warning">
                        <button @click="eliminar(empleado.id)"><font-awesome-icon class="text-danger" icon="trash"/></button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7">No hay Registros</td>
                </tr>
            </tbody>
        </table>
    </div> 
</template>

<style scoped>
    
</style>

<script>
import Button from '../Jetstream/Button.vue';
import Label from '../Jetstream/Label.vue'
    export default {
        components: { Label },
        data() {
            return {
                alert: {
                    message : '',
                    type: 'alert-danger',
                    visible: false,
                },
                datoAgregar: true,
                empleados: [],
                empleado : {
                    id: 0,
                    nombre : '',
                    email: '',
                    sexo: '',
                    area_id: 0,
                    boletin: 0,
                    descripcion: ''
                },
                areas: [],
                area: {
                    id:	0,
                    nombre:	'',
                },
                roles: [],
                rol: {
                    id:	0,
                    nombre:	'',
                },
                checkedRoles: [],
            }
        },
        created(){
            this.getEmpleados();
            this.getAreas();
            this.getRoles();
        },
        methods: {
            getEmpleados(){
                fetch(window.location+"api/empleado")
                .then(res => res.json())
                .then(data => {
                    if(data.response){
                        if(data.response.length > 0){
                            this.empleados = data.response;
                        }
                    }
                });
            },
            getAreas(){
                fetch(window.location+"api/empleado/area")
                .then(res => res.json())
                .then(data => {
                    if(data.response){
                        if(data.response.length > 0){
                            this.areas = data.response;
                        }
                    }
                });
            },
            getRoles(){
                fetch(window.location+"api/empleado/rol")
                .then(res => res.json())
                .then(data => {
                    if(data.response){
                        if(data.response.length > 0){
                            this.roles = data.response;
                        }
                    }
                });
            },
            getRolesEmpleado(id){
                fetch(`${window.location}api/empleado/${id}/rol`)
                .then(res => res.json())
                .then(data => {
                    if(data.response){
                        if(data.response.length > 0){
                            this.roles = data.response;
                        }
                    }
                });
            },
            editar(id){
                this.alert.visible = false;
                this.datoAgregar = false;
                fetch(`${window.location}api/empleado/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    if(data.response){
                        this.empleado = data.response;                 
                    }
                });
                fetch(`${window.location}api/empleado/${id}/rol`)
                .then(res => res.json())
                .then(data => {
                    const lista = [];
                    if(data.response && data.response.length > 0){
                        data.response.forEach(element => {
                            lista.push(element.rol_id);
                        });                 
                    }
                    this.checkedRoles = lista;
                });
            },
            eliminar(id){
                fetch(`${window.location}api/empleado/${id}`,{method: 'DELETE'})
                .then(res => res.json())
                .then(data => {
                    if(data.response){
                        
                        this.getEmpleados();
                        this.getAreas();
                        this.getRoles();    
                        this.cancelarSubmit();    
                        
                        this.alert.message = data.message;     
                        this.alert.type = 'alert-success';     
                        this.alert.visible = true;
                    }
                });
            },
            submitForm(){
                const urlUpdate = `${window.location}api/empleado/${this.empleado.id}`;
                const urlCreate = `${window.location}api/empleado`;
                this.empleado.boletin = this.empleado.boletin ? 1 : 0;
                let datos = {'empleado': this.empleado, 'roles': this.checkedRoles}
                if(!this.datoAgregar){
                    // actualizar empleado
                    fetch(urlUpdate, {
                        method: 'PUT',
                        body:  JSON.stringify(datos),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.response){
                            
                            this.getEmpleados();
                            this.cancelarSubmit();

                            this.alert.message = data.message;     
                            this.alert.type = 'alert-success';     
                            this.alert.visible = true;
                        }
                        if(data.error){
                            this.alert.message = data.error;     
                            this.alert.type = 'alert-danger';     
                            this.alert.visible = true;
                        }
                    });
                }else{
                    // agregar empleado
                    fetch(urlCreate, {
                        method: 'POST',
                        body: JSON.stringify(datos),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.response){
                            this.getEmpleados();
                            this.cancelarSubmit();

                            this.alert.message = data.message;     
                            this.alert.type = 'alert-success';     
                            this.alert.visible = true;
                        }
                        if(data.error){
                            this.alert.message = data.error;     
                            this.alert.type = 'alert-danger';     
                            this.alert.visible = true;
                        }
                    });
                }
                
            },
            cancelarSubmit(){
                this.datoAgregar = true,
                
                this.empleado = {
                    id: 0,
                    nombre : '',
                    email: '',
                    sexo: '',
                    area_id: 0,
                    boletin: 0,
                    descripcion: ''
                }
                this.checkedRoles = [];

                this.alert.visible = false;
            }
        }
    }
</script>
