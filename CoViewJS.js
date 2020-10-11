//Filter Modal box
// Get the modal
var modal = document.getElementById("filterModal");

// Get the button that opens the modal
var btn = document.getElementById("filterButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
//filterForm
var filter = document.getElementById('filterForm')
var applyFilterBtn = document.getElementById("applyFilter");
applyFilterBtn.onclick = function() {
  var unchecked = [];
  var status = document.getElementsByName('patientStatus');
  for (var i = 0; i < status.length; i++) {
    if (status[i].checked == false) {
      unchecked.push(status[i].labels[0].innerHTML);
    }
  }
  if(unchecked.length == 5){
    unchecked = [];
  }
  var table = document.getElementById("reports");
  var rows = table.rows;
  for (var i = 0; i < rows.length; i++) {
    rows[i].style.display = '';
  }
  for (var n = 1; n < (rows.length); n++) {
    //var rowStatus = true;
    for (var i = 0; i < unchecked.length; i++) {
      if (unchecked[i] == rows[n].getElementsByTagName("TD")[2].innerHTML) {
        //rowStatus = false;
        rows[n].style.display = 'none';
      }
    }
  }

}
//Table sorting
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("reports");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if(n==0){
          if (parseInt(x.innerHTML.substring(1)) > parseInt(y.innerHTML.substring(1))) {
            shouldSwitch = true;
            break;
          }
        }
        else if(n==3 || n==4){
          if (parseInt(x.innerHTML.substring(6)) > parseInt(y.innerHTML.substring(6))) {
            shouldSwitch = true;
            break;
          }
          else if (parseInt(x.innerHTML.substring(6)) == parseInt(y.innerHTML.substring(6))
          && parseInt(x.innerHTML.substring(3,5)) > parseInt(y.innerHTML.substring(3,5))) {
            //console.log("months",x,y, parseInt(x.innerHTML.substring(3,5)) > parseInt(y.innerHTML.substring(3,5)));
            shouldSwitch = true;
            break;
          }
          else if (parseInt(x.innerHTML.substring(3,5)) == parseInt(y.innerHTML.substring(3,5))
          && parseInt(x.innerHTML.substring(0,2)) > parseInt(y.innerHTML.substring(0,2))) {
            //console.log("days",x,y, parseInt(x.innerHTML.substring(3,5)) > parseInt(y.innerHTML.substring(3,5)));
            shouldSwitch = true;
            break;
          }
        }
        else{
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
      } else if (dir == "desc") {
        if(n==0){
          if (parseInt(x.innerHTML.substring(1)) < parseInt(y.innerHTML.substring(1))) {
            shouldSwitch = true;
            break;
          }
        }
        else if(n==3 || n==4){
          if (parseInt(x.innerHTML.substring(6)) < parseInt(y.innerHTML.substring(6))) {
            shouldSwitch = true;
            break;
          }
          else if (parseInt(x.innerHTML.substring(6)) == parseInt(y.innerHTML.substring(6))
          && parseInt(x.innerHTML.substring(3,5)) < parseInt(y.innerHTML.substring(3,5))) {
            //console.log("months",x,y, parseInt(x.innerHTML.substring(3,5)) > parseInt(y.innerHTML.substring(3,5)));
            shouldSwitch = true;
            break;
          }
          else if (parseInt(x.innerHTML.substring(3,5)) == parseInt(y.innerHTML.substring(3,5))
          && parseInt(x.innerHTML.substring(0,2)) < parseInt(y.innerHTML.substring(0,2))) {
            //console.log("days",x,y, parseInt(x.innerHTML.substring(3,5)) > parseInt(y.innerHTML.substring(3,5)));
            shouldSwitch = true;
            break;
          }
        }
        else{
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
