<template>
  <div>
    <button
      type="button"
      class="btn m-0 p-1 shadow-none"
    >
      <!-- ハートのアイコンがクリックされた際に、@clickでclickLikeメソッドが発火する -->
      <i class="fas fa-heart mr-1"
        :class="{'red-text':this.isLikedBy, 'animated heartBeat fast':this.gotToLike}"
        @click = "clickLike"
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
      initialCountLikes: {
        type: Number,
        default: 0,
      },
      authorized: {
        type: Boolean,
        default: false,
      },
      endpoint: {
        type: String,
      },
    },
    data() {
      return {
        isLikedBy: this.initialIsLikedBy,
        countLikes: this.initialCountLikes,
        gotToLike: false,
      }
    },
    methods: {
      clickLike() {
        // 未ログインであればメソッドを終了させる
        if (!this.authorized) {
          alert('いいね機能はログイン中のみ使用できます')
          return
        }

        this.isLikedBy // いいねしようとしている記事が現在いいね済みかどうかを判定
          ? this.unlike() // いいね済みであればunlikeメソッド
          : this.like() // 未いいねであればlikeメソッド
      },
      async like() {
        const response = await axios.put(this.endpoint)

        this.isLikedBy = true
        this.countLikes = response.data.countLikes
        this.gotToLike = true
      },
      async unlike() {
        const response = await axios.delete(this.endpoint)

        this.isLikedBy = false
        this.countLikes = response.data.countLikes
        this.gotToLike = false
      },
    },
  }
</script>
