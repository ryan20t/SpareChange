/*
 * placeholder scripts
 */
$('.billName').on('focus', function(e){
    InputClear('billName');
}).on('blur', function(e){
    InputReset('billName', 'description');
});

$('.amount').on('focus', function(e){
    InputClear('amount');
}).on('blur', function(e){
    InputReset('amount', 'amount');
});