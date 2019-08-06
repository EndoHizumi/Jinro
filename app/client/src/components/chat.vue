<template>
    <div class="chat">
      {{messageDatas}}
      <div class="message" v-for="message in messageDatas" v-bind:key="message.id">
        <div vclass="head">
          <span class="head__name">{{message.name}}</span>
        </div>
        <div class="body">
          <p class="body__text">{{message.text}}</p>
        </div>
      </div>
      <div class="toolbar">
        <div class="toolbar__header">
          <button class="toolbar__actionbutton" type="button">action</button>
        </div>
        <div class="inputarea">
          <input class="inputarea__text" type="text" />
          <button class="inputarea__submit" type="submit">send</button>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  /* eslint-disable */
  name: "Chat",
  props: {},
  data() {
    return {
      lastid: 1,
      messageDatas: [
        {
          id: 0,
          name: "hizumi",
          text:
            "ホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲホゲ",
          icon: "gameMaster.png"
        }
      ]
    };
  },
  methods: {
    addMessage(message) {
      this.messageDatas.push({
        id: this.lastid,
        name: message.Name,
        text: message.Message,
        icon: "gameMaster.png"
      });
      this.lastid += 1;
    }
  }
};
</script>

<style>
.message {
  position: relative;
  min-width: 250px;
  max-width: 95%;
}
.head__icon {
  width: 32px;
  height: 32px;
  padding-top: 15px;
}
.head_name {
  font-weight: bold;
}
.body__text {
  margin: 0px;
  width: 95vw;
  height: 100%;
  min-width: 350px;
  border: solid 1px black;
  border-radius: 10px;
  padding-left: 5px;
  margin-left: 10px;
}
.toolbar {
  position: absolute;
  bottom: 25px;
  width: 99vw;
  height: 50px;
}
.inputarea  button{
  height: 33px;
}
.toolbar__actionbutton{
  width: 100%;
  height: 35px;
}
.inputarea__text{
  width: 94vw;
  height: 25px;
}
</style>