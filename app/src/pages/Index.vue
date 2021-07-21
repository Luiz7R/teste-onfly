<template>
  <q-page class="flex flex-center">
      <div class="row">
          <div class="col col-md-12" v-if="usuarioLogado">
              <div class="logout">
              </div>  
          </div>   
         <div class="col col-md-12" style="margin-bottom: 30rem;">
          <q-dialog v-model="criarConta">
                <q-card style="width: 600px; max-width: 60vw;">
                  <q-card-section>
                        <q-btn round flat dense icon="close" class="float-right" color="grey-8" v-close-popup></q-btn>
                        <div class="text-h7" style="text-align: center;">Criar Conta</div>
                  </q-card-section>
                  <q-separator inset></q-separator>
                  <q-card-section class="q-pt-none">
                      <q-form class="q-gutter-md">
                        <q-list>
                          <q-item>
                            <q-item-section>
                              <q-item-label class="q-pb-xs">Nome</q-item-label>
                              <q-input dense outlined v-model="registrarUsuario.name" />
                            </q-item-section>
                          </q-item>                            
                          <q-item>
                            <q-item-section>
                              <q-item-label class="q-pb-xs">E-mail</q-item-label>
                              <q-input dense outlined v-model="registrarUsuario.email" />
                            </q-item-section>
                          </q-item>                       
                          <q-item>
                            <q-item-section>
                              <q-item-label class="q-pb-xs">Senha</q-item-label>
                              <q-input dense type="password" outlined v-model="registrarUsuario.password" />                            
                            </q-item-section>
                          </q-item>
                          <q-btn label="Criar Conta" color="primary" dense  v-close-popup @click="Registrar">
                            
                          </q-btn>                          
                        </q-list>
                      </q-form>
                  </q-card-section>
                </q-card>
          </q-dialog>         
          <div class="container">
              <div class="row mt-4" v-if="!usuarioLogado">          
                  <div class="col-6 offset-3" style="width: 600px;">
                      <form action="#" @submit.prevent="handleLogin">
                          <h3>Login</h3>
                          <div class="form-row">
                                <q-input standout="text-white" type="email" style="max-width: 13rem;" v-model="formData.email" label="Email" />
                                <!--input type="email" name="email" class="form-control" v-model="formData.email" placeholder="email Endereço" -->
                          </div>
                          <div class="form-row">
                              <q-input standout="text-white" type="password" style="max-width: 13rem;" v-model="formData.password" label="Senha" />
                              <!--input type="password" class="form-control" v-model="formData.password" name="password" placeholder="password here"-->
                          </div>
                          <div class="form-row">
                              <q-btn color="primary" type="submit" style="margin-left: 20px;">Login</q-btn>
                          </div>
                          <q-btn color="primary" style="margin-left: 20px;" dense @click="modalRegistrar">Registrar</q-btn>
                      </form>
                  </div>               
              </div>           
          
              <div class="row mt-4" v-if="usuarioLogado">         
                  <div class="row" style="margin-left: 100px; margin-bottom: 25px;">
                      <div class="offset-3 mr-20" style="margin-bottom: 20px;">
                          <h3>Minhas Despesas</h3>              
                          <q-btn color="primary" dense @click="getSecrets">Atualizar Despesas</q-btn>
                          <q-btn color="primary" style="margin-left: 20px;" dense @click="modalcriarDespesa">Criar Nova Despesa</q-btn>
                      </div>                 
                      <div class="col- col-md-2"></div>
                      <div class="" style="max-width: 70vw;">         
                        <q-table
                          dense
                          title="Despesas"
                          :rows="secrets"
                          :columns="columns"
                          row-key="id"
                          class="col"
                        > 
                        <template v-slot:body-cell-anexo="props">                           
                          <q-td :props="props">
                            <q-btn
                              icon="attach_file"
                              color="positive"
                              size="sm"
                              dense
                              @click="anexo(props.row)"
                            />
                          </q-td>
                        </template>                        
                        <template v-slot:body-cell-action="props">                           
                          <q-td :props="props">
                            <q-btn
                              icon="create"
                              color="primary"
                              size="sm"
                              dense
                              @click="editar(props.row)"
                            />
                            <q-btn
                              icon="delete"
                              color="negative"
                              size="sm"
                              dense
                              class="q-ml-sm"
                              @click="deletar(props.row.id)"
                            />
                          </q-td>
                        </template>
                        </q-table>
                        <q-dialog v-model="modalImage">
                              <q-card style="width: 600px; max-width: 60vw;">
                                <q-card-section>
                                      <q-btn round flat dense icon="close" class="float-right" color="grey-8" v-close-popup></q-btn>
                                </q-card-section>
                                <q-card-section>
                                      <div class="text-h7" style="text-align: center;" >Imagem</div>
                                      <q-card class="my-card" style="margin-top: 2%;">
                                        <img :src="DespesaAnexo.anexo">
                                      </q-card>                                      
                                </q-card-section>                                
                                <q-separator inset></q-separator>
                              </q-card>
                        </q-dialog>                        
                        <q-dialog v-model="show_dialog">
                              <q-card style="width: 600px; max-width: 60vw;">
                                <q-card-section>
                                      <q-btn round flat dense icon="close" class="float-right" color="grey-8" v-close-popup></q-btn>
                                      <div class="text-h7" style="text-align: center;">Atualizar Despesa</div>
                                </q-card-section>
                                <q-separator inset></q-separator>
                                <q-card-section class="q-pt-none">
                                  <q-form class="q-gutter-md">
                                    <q-list>
                                      <q-item>
                                        <q-item-section>
                                          <q-item-label class="q-pb-xs">Descrição</q-item-label>
                                          <q-input dense outlined v-model="DespesasEditar.descricao" />
                                        </q-item-section>
                                      </q-item>
                                      <q-item>
                                        <q-item-section>
                                          <q-item-label class="q-pb-xs">Data</q-item-label>
                                          <q-input dense outlined v-model="DespesasEditar.dataFormatada" />
                                        </q-item-section>
                                      </q-item>
                                      <q-item>
                                        <q-item-section>
                                          <q-item-label class="q-pb-xs">Anexo</q-item-label>
                                          <q-input dense outlined v-model="DespesasEditar.anexo" />
                                        </q-item-section>
                                      </q-item>
                                      <q-item>
                                        <q-item-section>
                                          <q-item-label class="q-pb-xs">Valor</q-item-label>
                                          <q-input dense outlined v-model="DespesasEditar.valor" />
                                        </q-item-section>
                                      </q-item>
                                    </q-list>
                                  </q-form>
                                </q-card-section>
                                <q-card-section>
                                  <q-card-actions align="right">
                                    <q-btn
                                      flat
                                      label="Cancel"
                                      color="warning"
                                      dense
                                      v-close-popup
                                    ></q-btn>
                                    <q-btn
                                      flat
                                      label="OK"
                                      color="primary"
                                      dense
                                      v-close-popup
                                      @click="updateRow"
                                    ></q-btn>
                                  </q-card-actions>
                                </q-card-section>
                              </q-card>
                        </q-dialog>
                        <q-dialog v-model="medium" >
                            <q-card style="width: 500px; max-width: 80vw;">
                              <q-card-section>
                                <div class="text-h6">Apagar</div>
                              </q-card-section>

                              <q-card-section class="q-pt-none">
                                  Tem certeza que Desejar apagar a Despesa?
                              </q-card-section>

                              <q-card-actions align="right">
                                    <q-btn
                                      flat
                                      label="Cancelar"
                                      color="warning"
                                      dense
                                      v-close-popup
                                    ></q-btn>
                                    <q-btn
                                      flat
                                      label="OK"
                                      color="primary"
                                      dense
                                      v-close-popup
                                      @click="deleteDesp"
                                    ></q-btn>
                              </q-card-actions>
                            </q-card>
                        </q-dialog> 

                      </div>   
                  </div>             
              </div>   
              <q-dialog v-model="create_despesa">
                    <q-card style="width: 600px; max-width: 60vw;">
                      <q-card-section>
                            <q-btn round flat dense icon="close" class="float-right" color="grey-8" v-close-popup></q-btn>
                            <div class="text-h7" style="text-align: center;">Criar Despesa</div>
                      </q-card-section>
                      <q-separator inset></q-separator>
                      <q-card-section class="q-pt-none">
                          <q-form class="q-gutter-md">
                            <q-list>
                              <q-item>
                                <q-item-section>
                                  <q-item-label class="q-pb-xs">Descrição</q-item-label>
                                  <q-input dense outlined v-model="DespesaCriar.descricao" />
                                </q-item-section>
                              </q-item>
                              <q-item>
                                <q-item-section>
                                    <q-uploader
                                      style="max-width: 300px"
                                      label="Anexo"
                                      @add="file_upload"
                                      :factory="uploadFile"
                                      max-files="1"
                                      max-file-size="1048576"
                                      accept=".jpg, image/*"
                                      @rejected="onRejected"
                                    />                               
                                </q-item-section>
                              </q-item>                         
                              <q-item>
                                <q-item-section>
                                  <q-item-label class="q-pb-xs">Valor</q-item-label>
                                  <q-input dense outlined v-model="DespesaCriar.valor" />                            
                                </q-item-section>
                              </q-item>
                            </q-list>
                          </q-form>
                      </q-card-section>
                      <q-card-section>
                        <q-card-actions align="right">
                          <q-btn
                            flat
                            label="Cancel"
                            color="warning"
                            dense
                            v-close-popup
                          ></q-btn>
                          <q-btn
                            flat
                            label="OK"
                            color="primary"
                            dense
                            v-close-popup
                            @click="criarDespesa"
                          ></q-btn>
                        </q-card-actions>
                      </q-card-section>
                    </q-card>
              </q-dialog>                  
          </div> 
        </div> 
      </div>   
  </q-page> 
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import moment from 'moment'
import { ref } from 'vue'

const desp = {
  id: '',
  descricao: '',
  data_criacao: '',
  dataFormatada: '',
  anexo: '',
  valor: ''
}

const despCriar = {
  id: '',
  descricao: '',
  data_criacao: '',
  dataFormatada: '',
  anexo: '',
  valor: ''
}

export default defineComponent({
  name: 'PageIndex',
  data () {
     return { 
        columns: [
          {
            name: 'id',
            label: 'id',
            field: 'id',
            align: 'left',
            sortable: true
          },
          {
            name: 'descricao',
            label: 'Descricao',
            field: 'descricao',
            align: 'left',
            sortable: true
          },
          {
            name: 'data_criacao',
            label: 'Data Criação',
            field: 'data_criacao',
            format: val => `${moment(val).format('DD/MM/YYYY')}`,
            align: 'left',
            sortable: true
          },
          {
            name: 'anexo',
            label: 'Anexo',
            field: 'anexo',
            align: 'left',
            sortable: true
          },
          {
            name: 'valor',
            label: 'Valor',
            field: 'valor',
            format: val => Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(val),
            align: 'left',
            sortable: true
          },
          {
            name: 'action',
            label: 'Ações',
            align: 'left',
            sortable: true
          }
        ],    
        selectedFile: '',
        check_if_document_upload:false,
        model: ref(null),
        show_dialog: false,
        modalImage: false,
        file_path: null,
        medium: false,
        create_despesa: false,                   
        DespesasEditar: desp,  
        DespesaAnexo: desp,
        criarConta: false,                  
        secrets: [],
        usuario: [],
        logged: false,
        image: '',
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
        DespesaCriar: {
           descricao: '',
           data_criacao: '',
           anexo: '',
           valor: '',
        },
        imagePath: {
           anexo: '',
        },
        usuarioLogado: false,
     }
  },
  methods: {  
      file_selected(file) {
          this.selectedFile = file[0];
          this.check_if_document_upload=true
      },          
      handleLogin () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.post('http://localhost:8000/api/login', this.formData).then((res) => {
                     this.getSecrets()
                     this.usuarioLogado = true
                })
          })
      },
      handleLogout () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.get('http://localhost:8000/api/logout').then((res) => {
                      console.log(res.data)
                      this.usuarioLogado = false
                      Location.reload()
                })
          })
      },      
      getSecrets() {
          axios.get('http://localhost:8000/api/getDespesas').then((res) => { 
              this.secrets = res.data
              // console.log(this.secrets)
          });
      },    
      modalcriarDespesa () {
          this.create_despesa = true      
      },
      modalRegistrar () {
          this.criarConta = true      
      },      
      criarDespesa () {
          this.DespesaCriar.anexo = this.imagePath.anexo

          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.post('http://localhost:8000/api/criarDespesa', this.DespesaCriar).then(res => {
                    console.log(res)
                })
          })          
      },   
      Registrar () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.post('http://localhost:8000/api/registrar', this.registrarUsuario).then(res => {
                    console.log(res)
                })
          })          
      },          
      updateRow () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.put('http://localhost:8000/api/updateDespesa', this.DespesasEditar).then(res => {
                    console.log(res)
                })
          })          
      },       
      anexo (despesa)
      {
          const urlImages = ref('http://localhost:8000/storage/images/')

          this.modalImage = true
          urlImages.value = 'http://localhost:8000/storage/images/' + despesa.anexo
          this.DespesaAnexo.anexo = urlImages.value
          // this.DespesaAnexo.anexo = 'http://localhost:8000/storage/images/' + despesa.anexo
      },
      editar (despesa) {
        this.show_dialog = true
        this.DespesasEditar.id = despesa.id
        this.DespesasEditar.descricao = despesa.descricao
        this.DespesasEditar.data_criacao = despesa.data_criacao
        this.DespesasEditar.dataFormatada = moment(despesa.data_criacao).format('DD/MM/YYYY')
        this.DespesasEditar.anexo = despesa.anexo
        this.DespesasEditar.valor = despesa.valor
      },
      deletar (id) {
        this.medium = true 
        this.DespesasEditar.id = id
      },  
      uploadFile(files) 
      {
          let fileData = new FormData()
          //fileData.anexo = this.file_path.name

          console.log(files[0])

          fileData.append('anexo', files[0]);

          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {               
              axios.post('http://localhost:8000/api/uploadsFile', fileData, { headers: { 'Content-Type': 'multipart/form-data' } } ).then((res) => {
                  this.imagePath.anexo = res.data
                  this.$q.notify({ type: 'positive', message: `Imagem Adicionada` })
              })
          })    
      },
      onRejected (rejectedEntries) {
            // Notify plugin needs to be installed
            // https://quasar.dev/quasar-plugins/notify#Installation
            this.$q.notify({
              type: 'negative',
              message: `${rejectedEntries.length} file(s) did not pass validation constraints`
            })
      },      
      deleteDesp () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.delete(`http://localhost:8000/api/deletarDespesa/${this.DespesasEditar.id}`) 
                  .then(res => {  
                      console.log(res)
                  }).catch((err) => {
                      console.log(err)
                  }) 
          })          
      },                       
      handleLogged () {
          
      },     
      getUser () {
          axios.get('http://localhost:8000/api/user').then((res) => {
            console.log(res)
            //  this.usuario = res.data

            //  if ( this.usuario )
            //  {
            //       this.logged = true
            //  }
            //  else
            //  {
            //       console.log("Deslogado") 
            //  }

            //  localStorage.setItem('token', this.usuario);
  
            //  let user = localStorage.getItem('token'); 
          })
      },
      logout () {
      //      this.usuario = []
      //      console.log(" usuario : " + this.usuario)
      }
  }

})
</script>

<style>
    .form-row {
       margin-bottom: 8px;
    }
</style>
