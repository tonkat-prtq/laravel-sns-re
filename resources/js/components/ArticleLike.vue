<template>
  <div>
    <button
      type="button"
      class="btn m-0 p-1 shadow-none"
    >
    <i class="fas fa-heart mr-1"
      :class="{'red-text':this.isLikedBy}"
    />
    </button>
    10
  </div>
</template>

<script>
  export default {
    props: {
      // blade側でinitial-is-liked-byに渡した値は、initialIsLikedByに渡される
      initialIsLikedBy: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        // initialIsLikedByの値をそのままデータisLikedByにセットしている
        isLikedBy: this.initialIsLikedBy,
      }
    },
  }
</script>