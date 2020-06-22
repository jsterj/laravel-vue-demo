<template>
  <div>
    <transaction-navbar-component @update="update" :currentBalance="currentBalance" ></transaction-navbar-component>
    <transaction-list-component @update="update" :currentBalance="currentBalance" :currentTransactions="currentTransactions"></transaction-list-component>
  </div>
</template>

<script>
    import axios from "axios";

    export default {
      props: {
        balance: Number,
        transactions: [Object, Array],
      },
      data(){
        return {
            currentBalance: 0,
            currentTransactions: [],
        }
      },
      mounted(){
        //initialize data values from props sent by the view
        this.currentBalance = this.balance;
        this.currentTransactions = this.transactions;
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
                 console.log(response.data);
            })
            .catch(error => {
              console.log(error);
            });
        }
      }
    }
</script>
