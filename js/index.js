/*
 * store DOM objects in variables
 */
var day = document.querySelector('.dayView'),
    month = document.querySelector('.monthView'),
    daySelector = $('#daySelector'),
    monthSelector = $('#monthSelector');
    
/*
 * initialize day
 */
daySelector.addClass('underline');

/*
 * click events and functions to switch ***************************************
 */

/*
 * transaction type
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
 * day and month views
 */
daySelector.on('click', function(e){
    SwitchToDay();
});
monthSelector.on('click', function(e){
    SwitchToMonth();
});

function SwitchToDay(){
    day.style.display = 'block';
    month.style.display = 'none';
    $('#daySelector').addClass('underline');
    $('#monthSelector').removeClass('underline');
}

function SwitchToMonth(){
    day.style.display = 'none';
    month.style.display = 'block';
    $('#daySelector').removeClass('underline');
    $('#monthSelector').addClass('underline');
}

/*
 * goal tracker canvas script
 * may need to move to the HTML page so PhP can be used
 */
var canvas = document.querySelector('.goalCanvas');
var ctx = canvas.getContext('2d');
var gradient = ctx.createLinearGradient(0,150,0,0);
gradient.addColorStop(0, "red");
gradient.addColorStop(.35, "yellow");
gradient.addColorStop(.9, "green");
ctx.fillStyle = gradient;
ctx.fillRect(0,37.5,300,150);/*the second number gets bigger, it fills less (up to 150). use percentage and do math.*/