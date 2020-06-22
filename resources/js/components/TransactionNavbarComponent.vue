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
                <button type="button" class="btn btn-primary border-0 navbar-button ml-3 pl-0" @click="showModal">
                  <img src="img/add.png" class="mr-2" width="10%" />
                  ADD ENTRY
                </button>
                <button type="button" class="btn btn-primary border-0 navbar-button ml-3 pl-0" disabled>
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

    <!-- new transaction form modal -->
    <div class="modal" tabindex="-1" role="dialog" ref="modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Balance Entry</h5>
          </div>
          <div class="modal-body">

            <form class="mt-3" method="POST" :action="'/transactions/asyncstore'" :ref="'new-form-tag'">
              <input type="hidden" name="_token" :value="csrf">

              <!-- inputs -->
              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="labelInput">LABEL</label>
                    <input type="text" class="form-control" id="labelInput" maxlength="35">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="dateInput">DATE</label>
                    <input type="date" class="form-control" id="dateInput">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="amountInput">AMOUNT</label>
                    <input type="number" class="form-control" id="amountInput" step="0.01" min="-5000" max="5000">
                  </div>
                </div>
              </div>

              <!-- buttons -->
              <div class="mt-4">
                <hr />
                <div class="float-right mt-3 mb-3">
                  <button type="button" class="btn btn-lg btn-light mr-2" @click="hideModal()">Cancel</button>
                  <button type="button" class="btn btn-lg btn-primary" @click="addTransaction()">Save Entry</button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
    export default {
      props: {
        csrf: String,
        currentBalance: Number,
      },
      mounted(){
        //
      },
      methods: {
        emitUpdate: function () {
          this.$emit('update');
        },
        //display the modal with the add entry form
        showModal() {
          let element = this.$refs.modal;
          $(element).modal('show')
        },
        //hide the modal with the add entry form
        hideModal() {
          let element = this.$refs.modal;
          $(element).modal('hide')
        },
        //add a new transaction
        addTransaction: function (id) {
          this.hideModal();

          var formTagRef = 'new-form-tag';

          axios.post('/transactions/asyncstore', {
              label: this.$refs[formTagRef].elements.labelInput.value,
              date: this.$refs[formTagRef].elements.dateInput.value,
              amount: this.$refs[formTagRef].elements.amountInput.value,
              headers: {
                  'Accept': 'application/json'
              }
          })
            .then(response => {
                 var data = response.data;
                 if(data.status == 'created') {
                    console.log('added new transaction - id # ' + String(data.transaction));
                    this.emitUpdate();
                 } else {
                    console.log('error adding new transaction');
                    console.log(data.error);
                 }
            })
            .catch(error => {
              console.log(error);
            });
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
