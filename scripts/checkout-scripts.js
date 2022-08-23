// event listener for billing checkbox
document
  .getElementById("billing-checkbox")
  .addEventListener("change", clearBilling);

// event listeners to shipping fields
document
  .getElementById("firstname")
  .addEventListener("keyup", copyShippingToBilling);
document
  .getElementById("lastname")
  .addEventListener("keyup", copyShippingToBilling);
document
  .getElementById("address-line-one")
  .addEventListener("keyup", copyShippingToBilling);
document
  .getElementById("address-line-two")
  .addEventListener("keyup", copyShippingToBilling);
document
  .getElementById("suburb")
  .addEventListener("keyup", copyShippingToBilling);
document
  .getElementById("postcode")
  .addEventListener("keyup", copyShippingToBilling);

// show hide billing form
function formBillingHide() {
  let billingForm = document.querySelector("#form-billing");

  if (document.querySelector("#billing-checkbox").checked) {
    billingForm.style.display = "none";
  } else {
    billingForm.style.display = "block";
  }
}

formBillingHide();

// Need to alter php so that this works - including information in url
function toggleShipping() {
  const shippingForm = document.getElementById("form-shipping");

  if (shippingForm.style.display === "none") {
    shippingForm.style.display = "inherit";
  } else {
    shippingForm.style.display = "none";
  }
}

// Probably won't use
// function jumpTo(location) {
//   window.location.href = "#" + location;
// }

function copyShippingToBilling() {
  // Shipping address information
  let first = document.getElementById("firstname").value;
  let last = document.getElementById("lastname").value;
  let addressLineOne = document.getElementById("address-line-one").value;
  let addressLineTwo = document.getElementById("address-line-two").value;
  let suburb = document.getElementById("suburb").value;
  let postcode = document.getElementById("postcode").value;

  if (document.querySelector("#billing-checkbox").checked) {
    // billing address fields
    document.getElementById("firstname-billing").value = first;
    document.getElementById("lastname-billing").value = last;
    document.getElementById("address-line-one-billing").value = addressLineOne;
    document.getElementById("address-line-two-billing").value = addressLineTwo;
    document.getElementById("suburb-billing").value = suburb;
    document.getElementById("postcode-billing").value = postcode;
  }
}

function clearBilling() {
  if (document.querySelector("#billing-checkbox").checked === false) {
    document.getElementById("firstname-billing").value = "";
    document.getElementById("lastname-billing").value = "";
    document.getElementById("address-line-one-billing").value = "";
    document.getElementById("address-line-two-billing").value = "";
    document.getElementById("suburb-billing").value = "";
    document.getElementById("postcode-billing").value = "";
  } else {
    copyShippingToBilling();
  }
}
