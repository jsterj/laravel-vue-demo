<template>
  <div class="transaction-navbar">
    <div class="container transaction-navbar-inner-div">
      <div class="row transaction-navbar-inner-div">
        <div class="col"></div>
        <div class="col-10 align-self-center">
          <h3 class="navbar-text align-self-center">Your Balance</h3>
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
  .transaction-navbar-inner-div {
    height: 100%;
  }
  .navbar-text {
    color: white;
  }
  .navbar-button {
    background-color: #0054fe;
  }
</style>
