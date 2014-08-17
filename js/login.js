/*
 * 
 * variables and functions to switch
 * between log in and sign up forms
 */
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
 * placeholder scripts
 */
$('.email').on('focus', function(e){
    InputClear('email');
}).on('blur', function(e){
    InputReset('email', 'e-mail');
});

$('.confirmEmail').on('focus', function(e){
    InputClear('confirmEmail');
}).on('blur', function(e){
    InputReset('confirmEmail', 'confirm e-mail');
});

$('.password').on('focus', function(e){
    InputClear('password');
}).on('blur', function(e){
    InputReset('password', 'password');
});

$('.confirm').on('focus', function(e){
    InputClear('confirm');
}).on('blur', function(e){
    InputReset('confirm', 'confirm pw');
});