const check = function () {
    // check whether two password is same
    if (document.getElementById('password').value ===
        document.getElementById('repass').value) {

        // set error
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = '密碼不符合';
        document.getElementById('submit').setAttribute("disabled", "disabled");

        // check whether password is safe
        const regex = new RegExp("^(?=.*[a-z])(?=.*[0-9])(?=.{6,})");
        if (regex.test(document.getElementById('password').value)) {
            document.getElementById('message').innerHTML = '';
            document.getElementById('submit').removeAttribute("disabled");
        } else {
            document.getElementById('message').innerHTML = '密碼不符合規則:<br>一英文字母<br>一數字<br>至少8個字元';
        }

    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = '密碼不符合';
        document.getElementById('submit').setAttribute("disabled", "disabled");
    }
};