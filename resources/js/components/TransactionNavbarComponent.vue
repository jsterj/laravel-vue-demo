<template>
  <div class="transaction-navbar">
    <div class="container">
      <div class="row">
        <div class="col"></div>
        <div class="col-8 align-self-center">
          <h3 class="navbar-text">Your Balance</h3>
          <button type="button" class="btn btn-primary border-0 navbar-button ml-3 pl-0" width="1.5em" height="1.5em">
            <img src="img/add.png" class="mr-2" width="10%" />
            ADD ENTRY
          </button>
          <button type="button" class="btn btn-primary border-0 navbar-button ml-3 pl-0" width="1.5em" height="1.5em">
            <img src="img/import.png" class="mr-2" width="10%" />
            IMPORT CSV
          </button>
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
      }
    }
</script>

<style>
  .transaction-navbar {
    background-color: #192b4e;
    height: 150px;
  }
  .navbar-text {
    color: white;
  }
  .navbar-button {
    background-color: #0054fe;
  }
</style>
