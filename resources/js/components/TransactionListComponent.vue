<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col"></div>
        <div class="col-10">

          <ul id="transaction-list" class="p-0">
            <li v-for="(currentTransaction, index) in formattedTransactions">

              <!-- daily header when applicable -->
              <div v-if="currentTransaction.headerDate" class="container">
                <div class="row">
                  <div class="col-9 align-self-center pl-0">
                    <h5 class="text-muted mt-5 mb-3">{{ currentTransaction.headerDate }}</h5>
                  </div>
                  <div class="col-3 align-self-center">
                    <h4 v-if="Number(currentTransaction.headerTotal) > 0" class="float-right deposit pr-4 mt-4">
                      {{ formatCurrency(Number(currentTransaction.headerTotal), true) }}
                    </h4>
                    <h4 v-else class="float-right pr-4 mt-4">
                      {{ formatCurrency(Number(currentTransaction.headerTotal), true) }}
                    </h4>
                  </div>
                </div>
              </div>

              <!-- card with transaction info -->
              <div class="card mt-3" @mouseover="mouseover" @mouseleave="mouseleave">
                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-6 align-self-center">
                        <h4>{{ currentTransaction.label }}</h4>
                        <p class="text-muted m-0">{{ currentTransaction.date }}</p>
                      </div>
                      <div class="col-3 align-self-center">
                        <div class="edit-links float-right">
                          <a href="#" @click="showForm('form-' + currentTransaction.id)" class="mr-3">EDIT</a>
                          <a href="#" @click="deleteTransaction(currentTransaction.id)">DELETE</a>
                        </div>
                      </div>
                      <div class="col-3 align-self-center">
                        <h4 v-if="Number(currentTransaction.amount) > 0" class="float-right deposit">
                          {{ currentTransaction.amountString }}
                        </h4>
                        <h4 v-else class="float-right">
                          {{ currentTransaction.amountString }}
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- edit form -->
              <div class="card mt-0 edit-form" :ref="'form-' + String(currentTransaction.id)">
                <div class="card-body">
                  <div class="container mt-4">
                    <div class="row">
                      <div class="col align-self-center">

                        <form method="POST" :action="'/transactions/' + String(currentTransaction.id) + '/asyncupdate'" :ref="'form-tag-' + String(currentTransaction.id)">
                          <input type="hidden" name="_token" :value="csrf">

                          <!-- inputs -->
                          <div class="form-row">
                            <div class="col">
                              <div class="form-group">
                                <label for="labelInput">LABEL</label>
                                <input type="text" class="form-control" id="labelInput" maxlength="35" :value="currentTransaction.label">
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label for="dateInput">DATE</label>
                                <input type="date" class="form-control" id="dateInput" :value="formatDateForForm(currentTransaction.date)">
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label for="amountInput">AMOUNT</label>
                                <input type="number" class="form-control" id="amountInput" step="0.01" min="-5000" max="5000" :value="currentTransaction.amount">
                              </div>
                            </div>
                          </div>

                          <!-- buttons -->
                          <div class="mt-5">
                            <hr />
                            <div class="float-right mt-3 mb-3">
                              <button type="button" class="btn btn-lg btn-light mr-2" @click="hideForm('form-' + currentTransaction.id)">Cancel</button>
                              <button type="button" class="btn btn-lg btn-primary" @click="updateTransaction(currentTransaction.id)">Update Entry</button>
                            </div>
                          </div>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </li>
          </ul>

        </div>
        <div class="col"></div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
      props: {
        csrf: String,
        currentBalance: Number,
        currentTransactions: [Object, Array],
      },
      mounted(){
        //
      },
      methods: {
        emitUpdate: function () {
          this.$emit('update');
        },
        getMdyString: function (date) {
          return String(date.getMonth()).padStart(2, '0') + String(date.getDate()).padStart(2, '0') + String(date.getYear());
        },
        getDayString: function (date) {
          var days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
          var day = date.getDay();
          return days[day];
        },
        getMonthString: function (date) {
          var months = ['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];
          var month = date.getMonth();
          return months[month];
        },
        //when the mouse hovers over an entry then it's "edit" and "delete" links are shown
        mouseover: function (event) {
          event.currentTarget.querySelector('.edit-links').style.display = 'block';
        },
        //when the mouse leaves an entry then it's "edit" and "delete" links are hidden
        mouseleave: function (event) {
          event.currentTarget.querySelector('.edit-links').style.display = 'none';
        },
        deleteTransaction: function (id) {
          axios.get('/transactions/' + String(id) + '/asyncdestroy', {
              headers: {
                  'Accept': 'application/json'
              }
          })
            .then(response => {
                 var data = response.data;
                 if(data.status == 'deleted') {
                    console.log('deleted transaction - id # ' + String(id));
                    this.emitUpdate();
                 } else {
                    console.log('error deleting transaction - id # ' + String(id));
                 }
            })
            .catch(error => {
              console.log(error);
            });
        },
        //when an entry's "edit" link is clicked then it's corresponding form is displayed
        showForm: function(ref) {
          this.$refs[ref][0].style.display = 'block';
        },
        //when the cancel button in an entry's form is clicked then the form is hidden
        hideForm: function(ref) {
          this.$refs[ref][0].style.display = 'none';
        },
        formatDateForForm: function(dateString) {
          return new Date(dateString).toISOString().substring(0, 10)
        },
        updateTransaction: function (id) {
          var formTagRef = 'form-tag-' + String(id);

          axios.post('/transactions/' + String(id) + '/asyncupdate', {
              label: this.$refs[formTagRef][0].elements.labelInput.value,
              date: this.$refs[formTagRef][0].elements.dateInput.value,
              amount: this.$refs[formTagRef][0].elements.amountInput.value,
              headers: {
                  'Accept': 'application/json'
              }
          })
            .then(response => {
                 var data = response.data;
                 if(data.status == 'updated') {
                    console.log('updated transaction - id # ' + String(id));
                    this.emitUpdate();
                 } else {
                    console.log('error updating transaction - id # ' + String(id));
                    console.log(data.error);
                 }
            })
            .catch(error => {
              console.log(error);
            });
        },
      },
      computed: {
        //build a new array of transactions with daily header strings and formatted amount strings with "$" and "+" or "-"
        formattedTransactions: function () {
          var newArray = [];
          var currMdy = false;  //current header string's MMDDYYYY
          var currHeaderIndex;  //array index that holds the current header info
          var date, mdy;
          var today = new Date();
          var yesterday = new Date();
          yesterday.setDate(today.getDate() - 1);

          for(var i=0; i<this.currentTransactions.length; i++) {
            newArray.push(this.currentTransactions[i]);  //copy transaction record

            //check date of current transaction against the currentMdy
            date = new Date(this.currentTransactions[i].date);
            mdy = this.getMdyString(date);
            if(mdy != currMdy) {  //create next daily header
              currMdy = mdy;
              currHeaderIndex = i;

              //check if the date is today or yesterday
              if(this.getMdyString(today) == mdy) {
                newArray[i].headerDate = "TODAY";
              } else if(this.getMdyString(yesterday) == mdy) {
                newArray[i].headerDate = "YESTERDAY";
              } else {
                newArray[i].headerDate = this.getDayString(date) + ', ' + String(date.getDate()).padStart(2, '0') + ' ' + this.getMonthString(date);
              }

              newArray[i].headerTotal = Number(newArray[i].amount);  //add amount to the header total
            } else { //add to the current header's total
              newArray[currHeaderIndex].headerTotal += Number(newArray[i].amount);
              newArray[i].headerDate = false;
              newArray[i].headerTotal = false;
            }

            //add formatted amount string for display
            newArray[i].amountString = this.formatCurrency(newArray[i].amount, true);
          }
          return newArray;
        },
      },
    }
</script>

<style>
  ul {
    list-style-type: none;
  }
  .deposit {
    color: #00b357;
  }
  .edit-links {
    display: none;
  }
  .edit-form {
    display: none;
  }
  /* hide number inputs spin boxes */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }
  input[type=number] {
      -moz-appearance:textfield; /* Firefox */
  }
</style>
