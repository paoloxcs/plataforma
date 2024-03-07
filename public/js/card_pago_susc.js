var card_tarjeta = document.getElementById('card-tarjeta');
var card_deposito = document.getElementById('card-deposito');
var card_paypal = document.getElementById('card-paypal');
var body_card_tarjeta = document.getElementById('body-card-tarjeta');
var body_card_deposito = document.getElementById('body-card-deposito');
var body_card_paypal = document.getElementById('body-card-paypal');
var radio_tarjeta = document.getElementById('radio_tarjeta');
var radio_deposito = document.getElementById('radio_deposito');
var radio_paypal = document.getElementById('radio_paypal');

var radio_culqi = document.getElementById('flexCheckDefault');


// bg-gray-50 dark:bg-ed-grey-700 py-3 px-3 w-full rounded-lg border-1 border-gray-200 dark:border-dark-bg-alt mb-4 cursor-pointer
$(".card-deposito").click(function () {
  card_tarjeta.classList.add('bg-gray-50', 'bg-gray-200');
  card_tarjeta.classList.remove('border-blue-300');
  body_card_tarjeta.style.display = "none";
  radio_tarjeta.checked = false;

  if (moneyLocal == 'pen') {
    card_deposito.classList.remove('bg-gray-50', 'bg-gray-200');
    card_deposito.classList.add('border-blue-300');
    body_card_deposito.style.display = "block";
    radio_deposito.checked = true;
  } else {
    card_paypal.classList.remove('bg-gray-50', 'bg-gray-200');
    card_paypal.classList.add('border-blue-300');
    body_card_paypal.style.display = "none";
    radio_paypal.checked = false;
  }

  radio_culqi.checked = false;

  $("#body-card-deposito").empty();
  $("#body-card-deposito").append(`
  <form onsubmit="saveYapeSuscCurso(this);" method="POST" action="#" form="d-grid l-block row-gap s-gap-3 s-mb-0">  
  <div class="grid grid-cols-2 md-grid-cols-1 gap-3 mb-4">
   
  <input type="hidden" class="form-control" value="${planSlug}" name="slug">
    <div class="!mb-0 input-form s-relative s-mb-3">
      <label class="s-mb-1 s-weight-semibold small">No. de indentificación (DNI)</label>
      <div class="s-relative s-cross-center">
        <input type="number" class="form-control placeholder:text-gray-300 outline-none" placeholder="00 00 00 00 00" name="dni">
      </div>
    </div>
    <div class="!mb-0 input-form s-relative s-mb-3">
      <label class="s-mb-1 s-weight-semibold small">No. telefónico</label>
      <div class="s-relative s-cross-center">
        <input type="number" class="form-control placeholder:text-gray-300 outline-none" placeholder="000 000 000" name="phoneNumber">
      </div>
    </div>
  </div>
  <div class="m-cols-2 smaller mb-7">
   
    <p class="mb-6"><b>Transferencias vía Yape</b></p>
   
  </div>
  <div class="px-3 py-1 border-1 border-yellow-300 bg-yellow-100 rounded mb-6">
    <p class="text-yellow-800 mb-0 font-normal text-sm text-center">
      Plataforma no guardará ninguna clase de información personal.
    </p>
  </div>
  <button class="button-deposito w-100" type="submit">Continúa con tu compra</button>
</form> `);

});

$(".card-tarjeta").click(function () {
  card_tarjeta.classList.remove('bg-gray-50', 'bg-gray-200');
  card_tarjeta.classList.add('border-blue-300');
  body_card_tarjeta.style.display = "block";
  radio_tarjeta.checked = true;

  if (moneyLocal == 'pen') {
    card_deposito.classList.add('bg-gray-50', 'bg-gray-200');
    card_deposito.classList.remove('border-blue-300');
    body_card_deposito.style.display = "none";
    radio_deposito.checked = false;
  } else {
    card_paypal.classList.add('bg-gray-50', 'bg-gray-200');
    card_paypal.classList.remove('border-blue-300');
    body_card_paypal.style.display = "none";
    radio_paypal.checked = false;
  }
});

$(".card-paypal").click(function () {
  card_tarjeta.classList.add('bg-gray-50', 'bg-gray-200');
  card_tarjeta.classList.remove('border-blue-300');
  body_card_tarjeta.style.display = "none";
  radio_tarjeta.checked = false;

  if (moneyLocal == 'pen') {
    card_deposito.classList.add('bg-gray-50', 'bg-gray-200');
    card_deposito.classList.remove('border-blue-300');
    body_card_deposito.style.display = "none";
    radio_deposito.checked = false;
  } else {
    card_paypal.classList.remove('bg-gray-50', 'bg-gray-200');
    card_paypal.classList.add('border-blue-300');
    body_card_paypal.style.display = "block";
    radio_paypal.checked = true;
  }
});