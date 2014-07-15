var loginID = document.querySelector('#login'),
    signupID = document.querySelector('#signup'),
    loginClass = document.querySelector('#loginMessage'),
    signupClass = document.querySelector('#signupMessage');

function SwitchToLogin(){
    loginID.style.display = 'block';
    signupID.style.display = 'none';
    loginClass.style.display = 'block';
    signupClass.style.display = 'none';
}

function SwitchToSignup(){
    loginID.style.display = 'none';
    signupID.style.display = 'block';
    loginClass.style.display = 'none';
    signupClass.style.display = 'block';
}

/*
 * input field stuff
 */
$('.email').on('focus', function(e){
        EmailClear();
}).on('blur', function(e){
        EmailReset();
});

function EmailClear(){
    $('.email').attr('placeholder', '');
}

function EmailReset(){
    $('.email').attr('placeholder', 'e-mail');
}

$('.password').on('focus', function(e){
    PasswordClear();
}).on('blur', function(e){
    PasswordReset();
});

function PasswordClear(){
    $('.password').attr('placeholder', '');
}

function PasswordReset(){
    $('.password').attr('placeholder', 'password');
}

$('.confirm').on('focus', function(e){
    ConfirmClear();
}).on('blur', function(e){
    ConfirmReset();
});

function ConfirmClear(){
    $('.confirm').attr('placeholder', '');
}

function ConfirmReset(){
    $('.confirm').attr('placeholder', 'confirm pw');
}