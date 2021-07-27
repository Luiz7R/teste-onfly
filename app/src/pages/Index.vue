<template>
  <q-page class="flex flex-center">
      <div class="row">  
         <div class="col col-md-12" style="margin-bottom: 30rem;">
          <q-dialog v-model="criarConta">
                <q-card style="width: 600px; max-width: 60vw;">
                  <q-card-section>
                        <q-btn round flat dense icon="close" class="float-right" color="grey-8" v-close-popup></q-btn>
                        <div class="text-h7" style="text-align: center;">Criar Conta</div>
                  </q-card-section>
                  <q-separator inset></q-separator>
                  <q-card-section class="q-pt-none">
                    <div>
                      <q-form class="q-gutter-md">
                        <q-list>
                          <q-item>
                            <q-item-section>
                              <q-item-label class="q-pb-xs">Nome</q-item-label>
                              <q-input dense outlined v-model="registrarUsuario.name" ref="regNome"
                                 :rules="[val => !!val || 'Nome está vazio']"
                              />
                            </q-item-section>
                          </q-item>                            
                          <q-item>
                            <q-item-section>
                              <q-item-label class="q-pb-xs">E-mail</q-item-label>
                              <q-input dense outlined v-model="registrarUsuario.email" ref="regEmail"
                                 :rules="[val => !!val || 'Email está vazio']"
                              />
                            </q-item-section>
                          </q-item>                       
                          <q-item>
                            <q-item-section>
                              <q-item-label class="q-pb-xs">Senha</q-item-label>
                              <q-input dense type="password" outlined v-model="registrarUsuario.password" ref="regSenha"
                                 :rules="[val => !!val || 'Senha está vazia']"
                              />                            
                            </q-item-section>
                          </q-item>
                          <q-btn label="Criar Conta" color="primary" dense  v-close-popup @click="Registrar">
                            
                          </q-btn>                          
                        </q-list>
                      </q-form>
                    </div>  
                  </q-card-section>
                </q-card>
          </q-dialog>         
          <div class="container">
              <div class="row mt-4 bg-blue-grey-13" style="margin-top: 20px; padding-bottom: 20px; border-radius: 5px;">          
                  <div class="col-6 offset-3" style="width: 600px;">
                      <form action="#" @submit.prevent="handleLogin">
                          <h3>Login</h3>
                          <div class="form-row">
                                <q-input class="bg-blue-grey-2" standout="bg-teal text-white" type="email" style="max-width: 20rem; border-radius: 5px;"
                                    v-model="formData.email" label="Email" 
                                    :rules="[val => !!val || 'Email está vazio']"
                                 />
                                <!--input type="email" name="email" class="form-control" v-model="formData.email" placeholder="email Endereço" -->
                          </div>
                          <div class="form-row">
                              <q-input class="bg-blue-grey-2" standout="bg-teal text-white" type="password" style="max-width: 20rem; border-radius: 5px;"
                                 v-model="formData.password"
                                 filled
                                 label="Senha" 
                                 :rules="[val => !!val || 'Senha está vazia']"   
                              />
                          </div>
                          <div class="form-row">
                              <q-btn color="primary" type="submit" style="margin-left: 20px;">Login</q-btn>
                          </div>
                          <q-btn color="primary" style="margin-left: 20px;" dense @click="modalRegistrar">Registrar</q-btn>
                      </form>
                  </div>               
              </div>                            
          </div> 
        </div> 
      </div>   
  </q-page> 
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import { ref } from 'vue'

export default defineComponent({
  name: 'PageIndex',
  data () {
     const inputRef = ref(null)
     return { 
        criarConta: false,                  
        usuario: [],
        formData: {
          email: '',
          password: '',
          device_name: 'Browser'
        },
        registrarUsuario: {
           name: '',
           email: '',
           password: ''
        },
        inputRef,
        usuarioLogado: false,
     }
  },
  methods: {          
      handleLogin () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.post('http://localhost:8000/api/login', this.formData).then((res) => {
                     this.formData.email = null                  
                     this.formData.password = null                    
                     this.$q.localStorage.set('dataUser', res.data)
                     this.$router.push('/')
                })
          })
      }, 
      modalRegistrar () {
          this.criarConta = true      
      },       
      Registrar () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.post('http://localhost:8000/api/registrar', this.registrarUsuario).then(res => {
                     this.registrarUsuario.name = null                  
                     this.registrarUsuario.email = null                  
                     this.registrarUsuario.password = null                  
                })
          })          
      },          
  }

})
</script>

<style>
    .form-row {
       margin-bottom: 8px;
    }
</style>
