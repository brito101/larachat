import Vue from "vue";
import store from "./vuex/store";

const userId = window.Laravel.user;

window.Echo.channel(`larachat_database_private-chat.${userId}`).listen(
    "NewMessageCreated",
    (e) => {
        let conversation = e.message
        console.log(e.message);
        Vue.$vToastify.success(
            `Messagem: ${conversation.message}`,
            `${conversation.sender.name} enviou uma nova mensagem`
        );
    }
);

window.Echo.join("larachat_database_chatroom")
    .here((users) => {
        console.log("Usuários online");
        console.log(users);

        store.commit("ADD_ONLINE_USERS", users);
    })
    .joining((user) => {
        console.log("Entrou");
        console.log(user);

        store.commit("ADD_ONLINE_USER", user);
    })
    .leaving((user) => {
        console.log("Saiu");
        console.log(user);

        store.commit("REMOVE_ONLINE_USER", user);
    });
