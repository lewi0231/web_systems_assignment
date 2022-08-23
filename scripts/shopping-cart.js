let selectDelivery = document.getElementById("delivery");
selectDelivery.addEventListener("change", calculateDeliveryCost);

// Upon click - this function retrieves the delivery selection
function calculateDeliveryCost(e) {
  let deliveryCost = e.target.options[selectDelivery.selectedIndex].value;

  updateDeliveryCost(deliveryCost);
  boldenDeliveryLabel(deliveryCost);
}

// Upon change this function is called - it determines the value of the 'selection' and inserts that into the 'delivery-cost' of the Order Summary
function updateDeliveryCost(costType) {
  let cost = 0;
  if (costType === "express") {
    cost = 10;
  } else if (costType === "standard") {
    cost = 7;
  } else {
    cost = 0;
  }

  document.getElementById("delivery-cost").textContent = "$" + cost.toFixed(2);

  updateTotal(cost);
  boldenDeliveryLabel(costType);
}

// updates the total of shopping cart.
function updateTotal(cost) {
  let totalElement = document.getElementById("total");

  let subtotalElement = document.getElementById("subtotal");

  let subtotal = parseFloat(
    subtotalElement.textContent.substring(1).replace(/,/g, "")
  );

  totalElement.innerHTML = `<span id='total'>$${(subtotal + cost).toFixed(
    2
  )}</span>`;
}

// bolden selected delivery label
function boldenDeliveryLabel(selection) {
  if (selection === "express") {
    document.getElementById("express-label").classList.add("bolden");
    document.getElementById("standard-label").classList.remove("bolden");
    document.getElementById("clickandcollect-label").classList.remove("bolden");
  } else if (selection === "standard") {
    document.getElementById("standard-label").classList.add("bolden");
    document.getElementById("express-label").classList.remove("bolden");
    document.getElementById("clickandcollect-label").classList.remove("bolden");
  } else {
    document.getElementById("clickandcollect-label").classList.add("bolden");
    document.getElementById("express-label").classList.remove("bolden");
    document.getElementById("standard-label").classList.remove("bolden");
  }
}
