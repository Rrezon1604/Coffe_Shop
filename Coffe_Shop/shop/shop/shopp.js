window.onload = function () {
  document.getElementById("showhotcoffe").onclick = function () {
    document.getElementById("hotcoffe").style.display = "flex";
    document.getElementById("coldcoffe").style.display = "none";
  };

  document.getElementById("showcoldcoffe").onclick = function () {
    document.getElementById("hotcoffe").style.display = "none";
    document.getElementById("coldcoffe").style.display = "flex";
  };

  let num = 0;
  let sum = 0;

  function addOrder(coffee, price) {
    num += 1;

    let priceValue = parseFloat(price.replace("€", ""));
    sum += priceValue;

    let totali = document.querySelector(".total");
    totali.innerHTML = "Total: " + sum.toFixed(2) + "€";

    let orderRow = document.createElement("table");
    orderRow.innerHTML = `
            <tr>
                <td>${num}</td>
                <td>${coffee}</td>
                <td style="padding-left:30px;">${price}</td>
                <td style="padding-left:40px;"><i class='bx bxs-trash' style="cursor:pointer;"></i></td>
            </tr>
        `;

    orderRow.querySelector(".bxs-trash").onclick = function () {
      let priceValueToRemove = parseFloat(price.replace("€", ""));
      sum -= priceValueToRemove;
      totali.innerHTML = "Total: " + sum.toFixed(2) + "€";
      orderRow.remove();
      updateRowNumbers();
    };

    document.getElementById("orderList").appendChild(orderRow);
    orderList.scrollTop = orderList.scrollHeight;
  }

  function updateRowNumbers() {
    let rows = document.querySelectorAll("#orderList tr");
    rows.forEach((row, index) => {
      row.querySelector("td:first-child").innerText = index + 1;
    });
  }

  document.getElementById("flatewhite").onclick = function () {
    addOrder("Flate White", "2.99€");
  };

  document.getElementById("caffelate").onclick = function () {
    addOrder("Caffe Late", "1.49€");
  };
  document.getElementById("cappuccino").onclick = function () {
    addOrder("Cappucino", "1.00€");
  };
  document.getElementById("mocha").onclick = function () {
    addOrder("Mocha", "1.50€");
  };
  document.getElementById("americano").onclick = function () {
    addOrder("Americano", "1.20€");
  };
  document.getElementById("caramelmacchiato").onclick = function () {
    addOrder("Caramel Macchiato", "3.00€");
  };
  document.getElementById("expresso").onclick = function () {
    addOrder("Expresso", "1.20€");
  };
  document.getElementById("parisianchocolate").onclick = function () {
    addOrder("Parisian Chocolate", "2.59€");
  };
  document.getElementById("cold-coffe").onclick = function () {
    addOrder("Cold Coffe", "2.45€");
  };
  document.getElementById("oreocoffe").onclick = function () {
    addOrder("Oreo Ice Coffe", "3.15€");
  };
  document.getElementById("frapuccino").onclick = function () {
    addOrder("Frapuccino", "2.49€");
  };
  document.getElementById("spanishlatte").onclick = function () {
    addOrder("Spanish Latte", "1.99€");
  };
  document.getElementById("chocolatecappucino").onclick = function () {
    addOrder("Chocolate Cappucino", "1.20€");
  };
  document.getElementById("glacecoffe").onclick = function () {
    addOrder("Glace Coffe", "3.20€");
  };
  document.getElementById("rafcoffe").onclick = function () {
    addOrder("Raf Coffe", "2.80€");
  };
  document.getElementById("maocchinocoffe").onclick = function () {
    addOrder("Maocchino Coffe", "3.59€");
  };

  document.getElementById("fshij").onclick = function () {
    document.getElementById("orderList").innerHTML = "";

    let totalElement = document.querySelector(".total");
    totalElement.innerHTML = "Total: 0.00€";

    num = 0;
    sum = 0;
  };

  document.getElementById("printo").onclick = function () {
    let orderListContent = document.getElementById("orderList").innerHTML;

    let rows = orderListContent.split("</tr>");
    let filteredRows = rows
      .map((row) => {
        let cols = row.split("</td>");
        if (cols.length > 3) {
          return cols.slice(0, 3).join("</td>") + "</td>";
        }
        return row;
      })
      .join("</tr>");

    let printWindow = window.open("", "", "height=400,width=600");
    printWindow.document.write("<html><head><title>Print</title>");
    printWindow.document.write("<style>");
    printWindow.document.write(
      "body { font-family: Arial, sans-serif; margin: 20px; }"
    );
    printWindow.document.write("h2 { text-align: start; }");
    printWindow.document.write(
      "table { width: 100%; border-collapse: collapse; margin: 20px 0; table-layout: fixed; }"
    );
    printWindow.document.write(
      "th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ccc; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1; }" // Shtoni 'flex: 1' për të barazuar gjatësitë
    );
    printWindow.document.write("th { background-color: #f2f2f2; }");
    printWindow.document.write(
      "tr:nth-child(even) { background-color: #f9f9f9; }"
    );
    printWindow.document.write("tr:hover { background-color: #f1f1f1; }");
    printWindow.document.write(
      "tbody { display: flex; flex-direction: column; }"
    );
    printWindow.document.write(
      "tbody tr { display: flex; justify-content: space-around; }"
    );
    printWindow.document.write("tbody td { flex: 1; }");
    printWindow.document.write("</style>");
    printWindow.document.write("</head><body>");
    printWindow.document.write("<h2>Porositë Tua</h2>");
    printWindow.document.write(
      "<table><thead><tr><th>Sasia</th><th>Emri</th><th>Çmimi</th></tr></thead><tbody>"
    );
    printWindow.document.write(filteredRows);
    printWindow.document.write(
      "<p style='text-align: right;'><strong>Total: </strong><strong>" +
        sum.toFixed(2) +
        "€</strong></p>"
    );
    printWindow.document.write("</tbody></table>");
    printWindow.document.write("</body></html>");
    printWindow.document.close();
    printWindow.print();
  };

  document.getElementById("ruaj").onclick = function () {
    document.getElementById("datacontent").value = document.getElementById("orderList").innerText;
  };
};
