<template>
  <div class="playersview">
    <ul id="playerslist">
      <li id="playerslist__item" v-for="player in players" :key="player.id" v-on:click="logout">
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
      players: []
    };
  },
  methods: {
    appendPlayer(playerName) {
        this.id += 1 
        this.players.push({id:this.id,name:playerName})
    },
    logout(event){
        this.$emit("action", event.target.innerText);
    }
  }
};
</script>
<style>
#playerslist__item {
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
