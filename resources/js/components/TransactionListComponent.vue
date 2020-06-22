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
              <div class="card mb-3" @mouseover="mouseover" @mouseleave="mouseleave">
                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-6 align-self-center">
                        <h4>{{ currentTransaction.label }}</h4>
                        <p class="text-muted m-0">{{ currentTransaction.date }}</p>
                      </div>
                      <div class="col-3 align-self-center">
                        <div class="edit-links float-right">
                          <a href="#" class="mr-3">EDIT</a>
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
        mouseover: function (event) {
          event.currentTarget.querySelector('.edit-links').style.display = 'block';
        },
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
</style>
