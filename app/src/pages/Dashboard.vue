<template>
    <div class="container">
          <div class="row">
                <div class="col-md-2"></div> 
          </div>          
          <div class="row mt-4">
            <div class="col-6 offset-3">
                <h3>Minhas Despesas</h3>
                <button class="btn btn-sm btn-secondary">Atualizar Despesas</button>
                <div class="secret">
                        Criado: <br>
                        Descricao: 
                        Valor: <br>
                </div>
                <q-btn color="primary" style="margin-left: 20px;" dense @click="LoggedUs">Criar Nova Despesa</q-btn>
            </div>
          </div>           
    </div>         
</template>


<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import User from "../apis/User";

export default defineComponent({
    name: 'PageIndex',
    data () {
        return {
           logged: ''
        }
    },
    methods: { 
      LoggedUs () {
          this.logged = localStorage.getItem("token")
          console.log(JSON.stringify(this.logged))      
      },
    } 
})
</script>
