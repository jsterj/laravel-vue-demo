<template>
  <div class="transaction-navbar">
    <div class="container transaction-navbar-inner-div">
      <div class="row transaction-navbar-inner-div">
        <div class="col"></div>
        <div class="col-10 align-self-center">

          <div class="container">
            <div class="row pr-3">
              <div class="col-9 align-self-center">
                <h3 class="navbar-text align-self-center">Your Balance</h3>
                <button @click="emitUpdate" type="button" class="btn btn-primary border-0 navbar-button ml-3 pl-0">
                  <img src="img/add.png" class="mr-2" width="10%" />
                  ADD ENTRY
                </button>
                <button type="button" class="btn btn-primary border-0 navbar-button ml-3 pl-0">
                  <img src="img/import.png" class="mr-2" width="10%" />
                  IMPORT CSV
                </button>
              </div>
              <div class="col-3 align-self-center">
                <h5 class="navbar-text-secondary float-right">TOTAL BALANCE</h5>
                <h4 v-if="currentBalance > 0" class="float-right positive-balance">
                  {{ formatCurrency(currentBalance, false) }}
                </h4>
                <h4 v-else class="float-right">
                  {{ formatCurrency(currentBalance, false) }}
                </h4>
              </div>
            </div>
          </div>

        </div>
        <div class="col"></div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
      props: {
        currentBalance: Number,
      },
      mounted(){
        //
      },
      methods: {
        emitUpdate: function () {
          this.$emit('update');
        },
      },
    }
</script>

<style>
  .transaction-navbar {
    background-color: #192b4e;
    height: 150px;
  }
  .transaction-navbar-inner-div {
    height: 100%;
  }
  .navbar-text {
    color: white;
  }
  .navbar-text-secondary {
    color: #a3aab8;
  }
  .navbar-button {
    background-color: #0054fe;
  }
  .positive-balance {
    color: #00b357;
  }
</style>
