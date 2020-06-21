<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col"></div>
        <div class="col-10">
          <ul id="transaction-list" class="p-0">
            <li v-for="currentTransaction in currentTransactions">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-9 align-self-center">
                        <h4>{{ currentTransaction.label }}</h4>
                        <p class="text-muted m-0">{{ currentTransaction.date }}</p>
                      </div>
                      <div class="col-3 align-self-center">
                        <h4 v-if="Number(currentTransaction.amount) > 0" class="float-right deposit">
                          {{ formatCurrency(currentTransaction.amount) }}
                        </h4>
                        <h4 v-else class="float-right">
                          {{ formatCurrency(currentTransaction.amount) }}
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
      methods: {
        //format a transaction amount string as currency and prepend with "+" or "-"
        formatCurrency: function(str) {
          str = Number(str);
          var sign = (str > 0) ? '+' : '-';
          return sign + " $" + Math.abs(str).toFixed(2);
        },
      },
      mounted(){
        //
      }
    }
</script>

<style>
  ul {
    list-style-type: none;
  }
  .deposit {
    color: #00b357;
  }
</style>
