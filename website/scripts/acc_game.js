let time = 0;
let startTime = new Date();
let endTime = new Date();
let d = new Date();
document.getElementById("input").value = "";

$(document).on('keypress',function(e) {
    if(e.which === 13) {
        $("#submit").click();
    }
});

// generate answer
const answer = [];
let array = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
for (let i = 0; i < 4; i++) {
    let index = Math.floor(Math.random() * (array.length));
    answer.push(array[index]);
    array.splice(index, 1);
}

// hide overlay
function off() {
    document.getElementById("overlay").style.display = "none";
    time = 0;
    startTime = new Date().getTime();
}

// check answer
function check() {
    console.log("check");
    time += 1;
    let a = 0;
    let b = 0;

    const input = document.getElementById("input").value;
    console.log(input);

    const re = /^(?!.*(.).*\1)[0-9]{4}$/;
    if (!re.test(input)){
        console.log("input error");
        document.getElementById("msg").innerText = "請重新輸入";
        document.getElementById("msg").setAttribute("style", "color : red;");
        return 0;
    }


    input.split("").forEach((val, id) => {
        let index = answer.indexOf(val);
        if (index !== -1) {
            if (index === id) {
                a++;
            } else {
                b++;
            }
        }
    })
    console.log("A: " + a + " B: " + b);
    if (a === 4) {
        endTime = new Date().getTime();
        let duration = (endTime - startTime)/1000;
        console.log("gameover");
        document.getElementById("ans").innerText = input;
        document.getElementById("time").innerText = time;
        document.getElementById("duration").innerHTML = duration + "秒";
        $('#exampleModalCenter').modal('show');
    } else {
        document.getElementById("msg").setAttribute("style", "color : black;");
        document.getElementById("msg").innerText = a + "A " + b + "B";
        document.getElementById("history").value += '\r\n' + input + " : " + a + "A " + b + "B";
		document.getElementById("input").value = "";
    }
}

// end
$('#exampleModalCenter').on('hidden.bs.modal', function () {
    location.reload();
})