/*
 * transaction type (budget or note)
 */
$('#budgetBox').on('click', function(e){
    if (budgetBox.checked) {
        IsCategory();
    }
    else {
        IsNote();
    }
});

function IsNote(){
    $('.note').css({display: "inline-block"});
    $('.category').css({display: "none"});
}

function IsCategory(){
    $('.note').css({display: "none"});
    $('.category').css({display: "inline-block"});
}

/*
 * goal tracker canvas script
 * may need to move to the HTML page so PhP can be used
 */
var canvas = document.querySelector('.goalCanvas');
var ctx = canvas.getContext('2d');
var gradient = ctx.createLinearGradient(0,150,0,0);
gradient.addColorStop(0, "firebrick");
gradient.addColorStop(.35, "gold");
gradient.addColorStop(.9, "limegreen");
ctx.fillStyle = gradient;
ctx.fillRect(0,37.5,300,150);/*the second number gets bigger, it fills less (up to 150). use percentage and do math.*/

/*
 * placeholder scripts
 */
$('.noteInput').on('focus', function(e){
    InputClear('noteInput');
}).on('blur', function(e){
    InputReset('noteInput', 'note');
});

$('.amount').on('focus', function(e){
    InputClear('amount');
}).on('blur', function(e){
    InputReset('amount', 'amount');
});

/*
 * Create datepicker
 */
$( '.date' ).datepicker({ 
    dateFormat : "mm/dd/yy"});

/*-------------------------------------------------------------------
 *                   Numeric input only for amount                  *
 -------------------------------------------------------------------*/ 
$('.amount').on('input', function()
{
   $text = this.value;
   $lastChar = $text.slice(-1);
   $oldText = $text.replace($lastChar, "");
   
   /*
    * Block input of second decimal place
    */
   var twoPeriods = false;
   
   if ( $oldText.indexOf(".") !== -1 && $lastChar === "." )
   {
       twoPeriods = true;
   }
   
   /*
    * Force only valid character entry
    */
   var regexDigitsDecimal = /[0-9|.]/; //valid characters
   
   if ( !regexDigitsDecimal.test($lastChar) || twoPeriods )
   {
       this.value = $text.substring(0, $text.length - 1);
   }
   
   /*
    * No more than two places after decimal
    */
   if ( this.value.indexOf(".") !== -1 )
   {
       $index = this.value.indexOf(".");
       if ( this.value.length > $index + 3 )
       {
           this.value = this.value.substring(0, $index + 3);
       }
   }

});