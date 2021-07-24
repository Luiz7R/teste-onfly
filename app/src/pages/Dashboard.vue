<template>
<div class="container">   
    <div class="col-sm-4 col-md-1 col-lg-1">
        <q-btn round flat icon="logout" class="float-right" @click="logout" color="grey-8" v-close-popup>Logout</q-btn>   
    </div>        
    <div class="row">       
        <div class="offset-3">      
            <div class="col-12 col-md-auto">
                <h4>Bem Vindo, {{ dataUser.name }} !</h4>
                <div style="margin-bottom: 20px;">
                    <h4>Minhas Despesas</h4>              
                    <q-btn color="primary" style="margin-left: 20px;" dense @click="modalcriarDespesa">Criar Nova Despesa</q-btn>
                </div>                 
                <div class="" style="max-width: 57vw;">
                    <q-table
                    dense
                    title="Despesas"
                    :rows="despesas"
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
                    <q-dialog v-model="modalImagem">
                        <q-card style="">
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
                    <q-dialog v-model="editar_despesa">
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
                                    @click="updateDespesa"
                                ></q-btn>
                                </q-card-actions>
                            </q-card-section>
                            </q-card>
                    </q-dialog>  
                    <q-dialog v-model="deletar_despesa" >
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
                <q-dialog v-model="criar_despesa">
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
</div>         
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
  descricao: '',
  data_criacao: '',
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
           modalImagem: false,   
           editar_despesa: false,
           medium: false,           
           criar_despesa: false,  
           deletar_despesa: false,
           DespesaAnexo: desp,  
           DespesasEditar: desp, 
           criarDesp: despCriar,
           dataUser: this.$q.localStorage.getItem('dataUser'),   
           despesas: [],  
           DespesaCriar: {
              descricao: '',
              data_criacao: '',
              anexo: '',
              valor: '',
           },
           imagePath: {
              anexo: '',
           },           
        }
    },
    methods: { 
      getDespesas() {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
            axios.get('http://localhost:8000/api/getDespesas').then((res) => { 
                this.despesas = res.data

            })
          })
      }, 
      modalcriarDespesa () {
          this.criar_despesa = true    
      }, 
      logout () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.get('http://localhost:8000/api/logout', this.formData).then((res) => {
                     this.$q.localStorage.remove('dataUser')
                     this.$router.push('/login')
                })
          })
      },  
      criarDespesa () {
          this.DespesaCriar.anexo = this.imagePath.anexo
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.post('http://localhost:8000/api/criarDespesa', this.DespesaCriar).then(res => {
                    this.getDespesas()
                })
          })   
      },         
      anexo (despesa)
      {
          const urlImages = ref('http://localhost:8000/storage/images/')

          this.modalImagem = true
          urlImages.value = 'http://localhost:8000/storage/images/' + despesa.anexo
          this.DespesaAnexo.anexo = urlImages.value
          // this.DespesaAnexo.anexo = 'http://localhost:8000/storage/images/' + despesa.anexo
      }, 
      editar (despesa) {
        this.editar_despesa = true
        this.DespesasEditar.id = despesa.id
        this.DespesasEditar.descricao = despesa.descricao
        this.DespesasEditar.data_criacao = despesa.data_criacao
        this.DespesasEditar.dataFormatada = moment(despesa.data_criacao).format('DD/MM/YYYY')
        this.DespesasEditar.anexo = despesa.anexo
        this.DespesasEditar.valor = despesa.valor
      }, 
      deletar (id) {
        this.deletar_despesa = true 
        this.DespesasEditar.id = id
      },        
      updateDespesa () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.put('http://localhost:8000/api/updateDespesa', this.DespesasEditar).then(res => {
                    console.log(res)
                })
          })          
          this.getDespesas()
      }, 
      deleteDesp () {
          axios.get('http://localhost:8000/sanctum/csrf-cookie').then((res) => {
                axios.delete(`http://localhost:8000/api/deletarDespesa/${this.DespesasEditar.id}`) 
                  .then(res => {

                  }).catch((err) => {
                      console.error(err)
                  }) 
          })  
          this.getDespesas() 
      },                
      uploadFile(files) 
      {
          let fileData = new FormData()
          //fileData.anexo = this.file_path.name

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
      limparSess()
      { 
            setInterval(function(){

               const user = localStorage.getItem('dataUser')
               
               if ( user ) 
               {
                    localStorage.removeItem('dataUser')
               }

            }, 60 * 60 * 1000 );           
      }                
    },
    beforeMount()
    {
        this.getDespesas()
        this.limparSess()
    } 
})
</script>
