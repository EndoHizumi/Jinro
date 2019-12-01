<template>
  <div class="playersview">
    <ul id="playerslist" v-for="player in players" v-on:click="logout">
      <li id="playerslist__item" v-for="playerinfo in player">
        <player class="playericon" :id="playerinfo.id" :name="playerinfo.name"></player>
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
      players: [],
    };
  },
  methods: {
    appendPlayer(playerName) {
        this.id += 1 
        this.players.push({[playerName]: {id:this.id,name:playerName}})
    },
    removePlayer(playerName) {
        this.$delete(this.players[0],playerName)
    },
    logout(event){
        this.$emit("action", event.target.innerText);
    }
  }
};
</script>
<style>
#playerslist {
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
