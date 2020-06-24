<template>
  <div>
    <transaction-navbar-component @update="update" :csrf="csrf" :currentBalance="currentBalance" ></transaction-navbar-component>
    <transaction-list-component @update="update" :csrf="csrf" :currentPlinks="currentPlinks" :currentBalance="currentBalance" :currentTransactions="currentTransactions"></transaction-list-component>
  </div>
</template>

<script>
    import axios from "axios";

    export default {
      props: {
        balance: Number,
        transactions: [Object, Array],
        plinks: String,
      },
      data(){
        return {
            currentBalance: 0,
            currentTransactions: [],
            currentPlinks: '',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
      },
      mounted(){
        //initialize data values from props sent by the view
        this.currentBalance = this.balance;
        this.currentTransactions = this.transactions;
        this.currentPlinks  = this.plinks;
      },
      methods: {
        //call server for updated data
        update: function () {
          axios.get('/transactions/getupdate', {
              headers: {
                  'Accept': 'application/json'
              }
          })
            .then(response => {
                 var data = response.data;
                 if(data.status == 'ok'){
                   this.currentBalance = Number(data.balance);
                   this.currentTransactions = data.transactions;
                 } else {
                   console.log('error retrieving update');
                 }
            })
            .catch(error => {
              console.log(error);
            });
        }
      }
    }
</script>
