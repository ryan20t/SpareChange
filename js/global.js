/*
 * input clear function
 * @param {className} x
 */
function InputClear(x){
    $('.' + x).attr('placeholder', '');
}

/*
 *  input reset function
 *  @param className, placeholder
 */
function InputReset(x, y){
    $('.' + x).attr('placeholder', y);
}

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


/*
 * lightbox
 */
/****************************************
	Barebones Lightbox Template
	by Kyle Schaeffer
	kyleschaeffer.com
	* requires jQuery
****************************************/

//<a href="javascript:lightbox('Hello!');">Show me the lightbox</a>
//above used to display content within a lightbox
// display the lightbox
function lightbox(insertContent, ajaxContentUrl){

	// add lightbox/shadow <div/>'s if not previously added
	if($('#lightbox').size() == 0){
		var theLightbox = $('<div id="lightbox"/>');
		var theShadow = $('<div id="lightbox-shadow"/>');
		$(theShadow).click(function(e){
			closeLightbox();
		});
		$('body').append(theShadow);
		$('body').append(theLightbox);
	}

	// remove any previously added content
	$('#lightbox').empty();

	// insert HTML content
	if(insertContent != null){
		$('#lightbox').append(insertContent);
	}

	// insert AJAX content
	if(ajaxContentUrl != null){
		// temporarily add a "Loading..." message in the lightbox
		$('#lightbox').append('<p class="loading">Loading...</p>');

		// request AJAX content
		$.ajax({
			type: 'GET',
			url: ajaxContentUrl,
			success:function(data){
				// remove "Loading..." message and append AJAX content
				$('#lightbox').empty();
				$('#lightbox').append(data);
			},
			error:function(){
				alert('AJAX Failure!');
			}
		});
	}

	// move the lightbox to the current window top + 100px
	$('#lightbox').css('top', $(window).scrollTop() + 100 + 'px');

	// display the lightbox
	$('#lightbox').show();
	$('#lightbox-shadow').show();

}

// close the lightbox
function closeLightbox(){

	// hide lightbox and shadow <div/>'s
	$('#lightbox').hide();
	$('#lightbox-shadow').hide();

	// remove contents of lightbox in case a video or other content is actively playing
	$('#lightbox').empty();
}