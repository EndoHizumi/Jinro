<template>
  <div class="chat">
    {{messageDatas}}
    <div class="message" v-for="message in messageDatas" v-bind:key="message.id">
      <div vclass="head">
        {{message.id}}
        <span class="head__name">{{message.name}}</span>
      </div>
      <div class="body">
        <p class="body__text">{{message.text}}</p>
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
        { id: 0, name: "hizumi", text: "ホゲホゲ", icon: "gameMaster.png" }
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
.body {
  position: relative;
  left: 35px;
}

.body__text {
  margin: 0px;
  width: 100%;
  height: 100%;
  min-width: 350px;
  border: solid 1px black;
  border-radius: 10px;
  padding-left: 10px;
}
</style>