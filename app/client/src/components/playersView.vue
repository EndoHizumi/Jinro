<template>
    <div class="playersview">
        <Player name="User"></Player>
    </div>
</template>
<script>
import Player from './player.vue'
export default {
    components:{
        Player
    }
}
</script>
<style>
.playersview{
    width: 100vw;
    height: 75px;
    background-color: whitesmoke;
    padding:5px;
    box-sizing: border-box;
}
</style>
