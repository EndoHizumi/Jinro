<template>
  <div class="playersview">
    <ul id="playerslist">
      <li class="playerslist__item" v-for="player in players" v-on:click="logout" :key="player.id">
        <player class="playericon" :id="player.id" :name="player.name"></player>
      </li>
    </ul>
  </div>
</template>
<script>
import Player from "./player.vue";
export default {
  components: {
    Player
  },
  data() {
    return {
      id: 1,
      players: {}
    };
  },
  methods: {
    appendPlayer(playerName) {
      this.id += 1;
      this.$set(this.players, playerName, { id: this.id, name: playerName });
    },
    removePlayer(playerName) {
      this.$delete(this.players, playerName);
    },
    logout(event) {
      this.$emit("action", event.target.innerText);
    }
  }
};
</script>
<style>
.playerslist__item {
  display: inline-block;
}

.playersview {
  width: 100vw;
  height: 75px;
  background-color: whitesmoke;
  padding: 5px;
  box-sizing: border-box;
}
</style>
