<template>
<div>
  some text hehe
</div>
</template><script>
    export default {
      props: {
        balance: Number,
        transactions: [Object, Array],
      },
      mounted(){
        console.log('mounted');
      }
    }
</script>
