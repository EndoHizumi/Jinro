<template>
  <div class="player">
    <div class="back">
      <span class="back__name">{{name}}</span>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    id: Number,
    name: String,
    icon: String
  },
  computed: {
    styles() {
      return {
        icon: this.icon
      };
    }
  }
};
</script>
<style>
.back {
  width: 100%;
  height: 100%;
  background-image: url({{icon}});
  background-color: gray;
}
.back__name{
    width: 100%;
    position: absolute;
    bottom: 0;

    color: white;
    font-weight: bold;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.5)
}
.player {
  width: 64px;
  height: 64px;
  position: relative;
  margin-left: 5px;
}
.player:hover {
  opacity: 0.7;
}
.player:active {
  opacity: 1;
}
</style>
