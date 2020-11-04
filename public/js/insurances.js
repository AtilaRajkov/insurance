


$("#type").change(function() {

  let type = $("#type").val();

  if (type === 'group') {
    $("#addPerson").show();
    $("#field-wrapper").show();
    $("#additional-people-container").show();
  } else if (type === 'single') {
    $("#addPerson").hide();
    $("#additional-people-container").hide();
    $("#field-wrapper").hide();
  }

});


if ($("#type").val() === 'group') {
  $("#addPerson").show();
} else if ($("#type").val() === 'single') {
  $("#addPerson").hide();
}



// $(document).ready(function(){

  var maxField = 10; //Input fields increment limitation
  var addButton = $('#addPerson'); //Add button selector
  var wrapper = $('#field-wrapper'); //Input field wrapper

  var x = 1; //Initial field counter is 1
  // var y = 0;

  var latsPeopleKey = $('#lats_people_key').val();

  console.log(latsPeopleKey);

  if (latsPeopleKey !== '') {
    var y = parseInt(latsPeopleKey) + 1;
  } else {
    var y = 0;
  }

  //Once add button is clicked
  $(addButton).click(function(e){
    e.preventDefault();
    //Check maximum number of input fields
    if(x < maxField){
      x++; //Increment field counter

      $(wrapper).append(
        '<div class="input-group">' +
        '<label >Ime i prezime</label>' +
        '<input type="text" name="people['+y+'][name]" value=""/><br>' +
        '<label>Datum rođenja</label>' +
        '<input type="text" name="people['+y+'][birth_date]" value=""/>' +
        '<a href="javascript:void(0);" class="remove_button">' +
        '<img class="remove-image" src="/img/remove-23.png"/></a><br>' +
        '<label>Broj pasoša</label>' +
        '<input type="text" name="people['+y+'][passport]" value=""/><br>' +
        '<input type="hidden" name="people['+y+'][key]" value="'+y+'"/><br>' +
        '</div>'

      ); //Add field html
      y++;
    }
  });

  //Once remove button is clicked
  $(wrapper).on('click', '.remove_button', function(e){
    e.preventDefault();
    $(this).parent('div').remove(); //Remove field html
    x--; //Decrement field counter
  });
// });

$(".remove_button").click(function(e) {
  e.preventDefault();
  $(this).parent('div').remove();
});









$("#date_to, #date_from").change(function() {
  // console.log( "Handler for .change() called." );
  let start = $('#date_from').datepicker('getDate');
  let end   = $('#date_to').datepicker('getDate');

  if (start && end) {
    let days = (end - start)/1000/60/60/24;
    days = Math.floor(days);
    if (days == 0) {
      days = 1;
    }
    $("#numberOfDays").html(days);
    $("#number_of_days").val(days);
  }
});



$( function() {
  $( "#birth_date" ).datepicker({
    showWeek: true,
    firstDay: 1,
    dateFormat: 'dd-mm-yy',
  });
} );

$( function() {
  $( "#date_from" ).datepicker({
    showWeek: true,
    firstDay: 1,
    dateFormat: 'dd-mm-yy'
  });
} );

$( function() {
  $( "#date_to" ).datepicker({
    showWeek: true,
    firstDay: 1,
    dateFormat: 'dd-mm-yy'
  });
} );

jQuery(function($) {
  // $('input.datetimepicker').datepicker({
  //   duration: '',
  //   changeMonth: false,
  //   changeYear: false,
  //   yearRange: '2010:2020',
  //   showTime: false,
  //   time24h: true
  // });

  $.datepicker.regional['sr'] = {
    closeText: 'Zatvori',
    prevText: 'Prethodni',
    nextText: 'Sledeći',
    currentText: 'Trenutni',
    monthNames: ['januar', 'februar', 'mart',' april', 'maj', 'jun', 'jul', 'avgust', 'septembar',
      'oktobar', 'novembar', 'decembar'
    ],
    monthNamesShort: ['jan', 'feb', 'mar', 'apr', 'maj', 'jun', 'jul', 'avg', 'sep', 'oct', 'nov', 'dec'],
    dayNames: [ 'nedelja', 'ponedeljak', 'utorak', 'sreda', 'četvrtak', 'petak', 'subota'],
    dayNamesShort: ['ne', 'pon', 'ut', 'sre', 'cet', 'pet', 'sub'],
    dayNamesMin: ['ne', 'pon', 'ut', 'sre', 'cet', 'pet', 'sub'],
    weekHeader: 'Ned',
    dateFormat: 'dd-mm-yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };

  $.datepicker.setDefaults($.datepicker.regional['sr']);
});

