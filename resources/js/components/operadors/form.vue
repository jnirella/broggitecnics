<template>
    <div>
        <button v-if="idUsuario == -1"
            @click="abrirModal('crear')"
            class="btn btn-secondary btn-flotant"
            :class="{ hide: idUsuario > 0 }">
            <i class="bi bi-plus-circle"></i> Crear Usuario
        </button>
        <div v-else>
            <!-- ms-3 me-1 -->
            <button :modalref="modalId" @click="abrirModal('pssw')" class="btn btn-sm btn-purple">
                <i class="bi bi-key"></i>
            </button>
            <button :modalref="modalId" @click="abrirModal('editar')" class="btn btn-sm btn-tertiary">
                <i class="bi bi-pencil-square"></i>
            </button>
            <button :modalref="modalId" @click="abrirModal('borrar')" class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        <form
            :id="modalId"
            @submit.prevent="actuar()"
            class="modal"
            tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 v-if="idUsuario == -1"
                            class="modal-title">Crear usuario</h5> -->
                        <h5 v-if="tipoModal == 'crear'"
                            class="modal-title">Crear usuario</h5>
                        <h5 v-else-if="tipoModal == 'editar'"
                            class="modal-title">Editar usuario</h5>
                        <h5 v-else-if="tipoModal == 'pssw'"
                            class="modal-title">Editar contraseña</h5>
                        <h5 v-else
                            class="modal-title">Borrar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div v-if="tipoModal == 'crear' || tipoModal == 'editar'"
                        class="modal-body">
                        <div class="form-floating">
                            <input type="text" name="username" id="username"
                                class="form-control mb-2"
                                v-model="_userdata.username" required>
                            <label for="username">Nombre de usuario</label>
                        </div>
                        <!-- <div class="form-floating"
                            :class="{ hide: idUsuario > 0 }"> -->
                        <div class="form-floating"
                            v-show="idUsuario == -1">
                            <input type="password" name="password" id="password"
                                class="form-control mb-2"
                                v-model="_userdata.contrasenya" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" name="nombre" id="nombre"
                                class="form-control mb-2"
                                v-model="_userdata.nom" required>
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" name="apellidos" id="apellidos"
                                class="form-control mb-2"
                                v-model="_userdata.cognoms" required>
                            <label for="apellidos">Apellidos</label>
                        </div>
                        <div class="form-floating">
                            <select id="tipususuari" name="tipususuari"
                                class="form-select"
                                v-model="_userdata.tipus_usuaris_id" required>
                                <!-- <option value="1">Operador 112</option>
                                <option value="2">Supervisor 112</option>
                                <option value="3">Administrador Sistema</option> -->
                                <option v-for="tipus in tiposusuaris" :key="tipus.id"
                                    :value="tipus.id"
                                    :selected="checkTipo(tipus.id)"
                                    >{{ tipus.nom }}</option>
                            </select>
                            <label for="tipususuari">Tipo de usuario</label>
                        </div>
                    </div>
                    <div v-else-if="tipoModal == 'pssw'"
                        class="modal-body">
                        <div class="form-floating">
                            <input type="password" name="password" id="password"
                                class="form-control mb-2"
                                v-model="_newpssw" required>
                                <!-- v-model="_userdata.contrasenya" -->
                            <label for="password">Contraseña</label>
                        </div>
                    </div>
                    <div v-else class="modal-body">
                        <p>Estas seguro de borrar al usuario: <b>{{ deluser.username }}</b>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</template>
<script>
import axios from 'axios'
import * as bootstrap from 'bootstrap'
import { markRaw } from 'vue'
export default {
    // props: ['idUsuario'],
    props: {
        idUsuario: {
            type: Number,
            default: -1,
        }
    },
    data() {
        return {
            _newpssw: '',
            _userdata: {
                id: '',
                username: '',
                contrasenya: '',
                nom: '',
                cognoms: '',
                tipus_usuaris_id: '',
            },
            modal: {},
            edituser: {},
            deluser: {},
            loggedUser: window.Usuario,
            tipoModal: 'crear',
            alert: {
                show: false,
                code: 0,
                error: false,
                message: '',
            }
        }
    },
    // mounted() {
    //     console.log(this.idUsuario);
    // },
    methods: {
        abrirModal(modo="crear") {
            this.tipoModal = modo

            // this.modal = new bootstrap.Modal('#modalUsuario')
            this.modal = new bootstrap.Modal(`#${this.modalId}`)
            this.modal.show()
            console.log(this.modalId);

            if (modo == 'editar' || modo == 'pssw' ) {
                this.getUsuario()
                // console.log('editar');
            } else if ( modo == 'borrar' ) {
                this.getUsuario(false)
                // console.log('borrar');
            }
        },
        abrir(modo="crear") {
            this.tipoModal = modo

            this.modal = new bootstrap.Modal('#modaltest')
            this.modal.show()

            this.getUsuario(false)
        },
        insertarUsuario() {
            const self = this
            this.modal.hide()
            // console.log(this);
            axios.post('/usuari',this._userdata)
                .then( (response) => {
                    console.log(response);
                    // console.log(self)
                    // self.$emit('apiCalled', response)
                    self.$emit('apiCalled', response)
                    return response
                })
                .catch( error => {
                    console.error(error);
                    // this.$emit('apiCalled', error)
                })
        },
        modificarUsuario() {
            const self = this
            this.modal.hide()
            let url = `/usuari/${this.edituser.id}`;
            if (this.tipoModal == 'pssw') {
                this._userdata.contrasenya = this._newpssw;
                url += '?password=true'
            }
            axios.put(url, this.edituser)
                .then( (response) => {
                    // console.log(response);
                    self.$emit('apiCalled', response)
                    return response
                })
                .catch( error => {
                    console.error(error)
                })
        },
        borrarUsuario() {
            const self = this
            this.modal.hide()

            axios.delete(`/usuari/${this.idUsuario}`)
                .then( (response) => {
                    console.log(response);
                    // Lanza un evento luego de que se borre el usuario
                    self.$emit('apiCalled', response, true)
                    return response
                })
                .catch( error => {
                    console.error(error)
                })
        },
        getUsuario(edit=true) {
            const self = this
            axios.get(`/usuari/${this.idUsuario}`)
                .then( (response) => {
                    return response.data
                })
                .then( data => {
                    if (edit) {
                        this.edituser = data
                        this._userdata = data
                    } else {
                        this.deluser = data
                    }
                })
                .catch( error => {
                    console.error(error)
                })
        },
        actuar() {
            // console.log('hola');
            switch (this.tipoModal) {
                case 'crear':
                    // console.log('crear');
                    this.insertarUsuario()
                    break;
                case 'editar':
                case 'pssw':
                    this.modificarUsuario()
                    break;
                case 'borrar':
                    console.log('borrar');
                    this.borrarUsuario()
                    break;
            }
            // this.modal.hide()
        },
        checkTipo(id) {
            return this._userdata.tipus_usuaris_id == id
        },
    },
    computed: {
        modalId() {
            if (this.idUsuario == -1) {
                return 'modal-crear'
            } else {
                return `modal-${this.idUsuario}`
            }
        },
        tiposusuaris() {
            if ( this.loggedUser.tipus_usuaris_id == 2 )
                return [ { id: 1, nom: 'Operador 112' }, { id: 2, nom: 'Supervisor 112' } ]
            else
                return [ { id: 1, nom: 'Operador 112' }, { id: 2, nom: 'Supervisor 112' }, { id: 3, nom: 'Administrador Sistema' } ]
            // return [ { id: 1, nom: 'Operador 112' }, { id: 2, nom: 'Supervisor 112' }, { id: 3, nom: 'Administrador Sistema' } ]
        }
    }
}
</script>
<style scoped>
.hide {
    display: none;
}
.btn-flotant {
    position: fixed;
    bottom: 50px;
    right: 50px;
}
.btn-tertiary {
    --bs-btn-color: #fff;
}
.btn-purple {
    --bs-btn-color: #fff;
    --bs-btn-bg: #ae00ff;
    --bs-btn-border-color: #ae00ff;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #8900c9;
    --bs-btn-hover-border-color: #8900c9;
}
.modal {
    background-color: rgb(128, 128, 128, 0.75);

    /* display: block; */
}
.modal > .modal-dialog {
    margin-top: 6rem !important;
    max-width: 50%;
}

.my-alert-dismissible {
    padding-right: 3rem;
}
.my-alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    padding: 1.25rem 1rem;

}
.floating {
    z-index: 1000;
    position: fixed;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
}
</style>
