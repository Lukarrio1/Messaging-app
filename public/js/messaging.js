activeUser = () => {
    let output = "";
    axios
        .get(`/active/${user.id}`)
        .then(res => {
            res.data.forEach(value => {
                output += `
                 <li class="list-group-item mt-1 pointer" id="act${value.id}">${
                    value.name
                }
                </li>
                `;
            });
            document.querySelector("#activeuser").innerHTML = output;
            document.querySelectorAll(".list-group-item").forEach(a => {
                a.addEventListener("click", () => {
                    localStorage.setItem("to", a.id.substring(3));
                    getMessages();
                });
            });
        })
        .catch(err => console.error(err));
};

getMessages = () => {
    let output = "";
    from = () => {
        axios
            .get(`/user/${localStorage.getItem("to")}`)
            .then(res => {
                document.querySelector("#from").innerHTML = res.data.name;
            })
            .catch(err => {
                console.log(err);
            });
    };
    axios
        .get(`/messages/${localStorage.getItem("to")}`)
        .then(res => {
            res.data.forEach(message => {
                let date = new Date(message.created_at);
                let position =
                    user.id == message.from
                        ? "text-right mr-5"
                        : "text-left ml-5";
                output += `
                <div class="${position}" >
                <span class="pointer" data-toggle="collapse" data-target="#collapse${
                    message.id
                }">${message.message}</span> <br/>
                  <div class="collapse ${position}" id="collapse${message.id}">
                  <a class="btn btn-sm delete" href="#" id="del${
                      message.id
                  }"><i class="text-danger fa fa-trash"></i></a>
                </div>
                <small class="text-muted">${date.getHours()}:${date.getMinutes()}</small>
                <br>
                 </div>`;
            });

            document.querySelector("#messages").innerHTML = output;
            document.querySelectorAll(".delete").forEach(del => {
                del.addEventListener("click", () => {
                    deleteMessage(del.id.substring(3));
                });
            });
            from();
        })
        .catch(err => console.log(err));
};

document.querySelector("#sendform").addEventListener("submit", event => {
    event.preventDefault();
    let message = document.querySelector("#messageInput").value;
    if (message.length > 1) {
        sendMessage(message);
    }
});

sendMessage = msg => {
    fd = new FormData();
    fd.append("to", localStorage.getItem("to"));
    fd.append("message", msg);
    axios
        .post("/message", fd)
        .then(res => {
            console.log(res);
            getMessages(localStorage.getItem("to"));
        })
        .catch(err => console.log(err));
    document.querySelector("#messageInput").value = "";
};

deleteMessage = id => {
    fd = new FormData();
    fd.append("message_id", id);
    axios
        .post("/delete/message", fd)
        .then(res => getMessages(localStorage.getItem("to")))
        .catch(err => console.log(err));
};

setInterval(() => {
    getMessages();
    activeUser();
}, 12000);

activeUser();
