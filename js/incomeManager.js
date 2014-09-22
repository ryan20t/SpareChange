/*
 * placeholder scripts
 */
$('.amount').on('focus', function(e){
    InputClear('amount');
}).on('blur', function(e){
    InputReset('amount', 'amount');
});