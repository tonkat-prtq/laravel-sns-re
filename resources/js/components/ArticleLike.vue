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
    {{ countLikes }} <!-- この行を変更 -->
  </div>
</template>

<script>
  export default {
    props: {
      initialIsLikedBy: {
        type: Boolean,
        default: false,
      },
      //==========ここから追加==========
      initialCountLikes: {
        type: Number,
        default: 0,
      },
      //==========ここまで追加==========
    },
    data() {
      return {
        isLikedBy: this.initialIsLikedBy,
        //==========ここから追加==========
        countLikes: this.initialCountLikes,
        //==========ここまで追加==========
      }
    },
  }
</script>
