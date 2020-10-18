//Filter Modal box
// When the user clicks on the button, open the modal
function openFilter() {
  let filterModal = document.getElementById("filterModal");
  filterModal.style.display = "block";
  window.addEventListener('click', outCloseFilter);
}

// When the user clicks on <span> (x), close the modal
function xCloseFilter() {
  filterModal.style.display = "none";
  window.removeEventListener('click', outCloseFilter);
}

// When the user clicks anywhere outside of the modal, close it
function outCloseFilter(event) {
  if (event.target == filterModal) {
    filterModal.style.display = "none";
  }
}

//filterForm
//returns the patient types to remove
function getPatientTypeFilter(){
  let unchecked = [];
  let status = document.getElementsByName('patientStatus');
  for (let i = 0; i < status.length; i++) {
    if (status[i].checked == false) {
      unchecked.push(status[i].labels[0].innerHTML);
    }
  }
  if(unchecked.length == 5){
    unchecked = [];
  }
  return unchecked;
}

//returns the status to keep
function getReportStatusFilter(){
  let status = document.getElementsByName('status');
  if(status[0].checked == true){
    return "Pending";
  }
  else if(status[1].checked == true){
    return "Complete";
  }
  else if(status[2].checked == true){
    return null;
  }
}
//gets the date filter conditons // n =0 for testDates and n=2 for resultDates
function getDateFilter(n){
  let startDate = document.getElementsByClassName('filterDates')[n].value;
  let endDate = document.getElementsByClassName('filterDates')[n + 1].value;
  return [startDate, endDate];
}

//function for the filter
//var applyFilterBtn = document.getElementById("applyFilter");
function applyFilter() {
  let unchecked = getPatientTypeFilter();
  let status = getReportStatusFilter();
  let table = document.getElementById("reports");
  let rows = table.rows;
  let testDates = getDateFilter(0);
  let resultDates = getDateFilter(2);
  //unhides the hidden things so they don't remain hidden
  for (let i = 0; i < rows.length; i++) {
    rows[i].style.display = '';
  }
  //applys the filter
  for (let n = 1; n < (rows.length); n++) {
    //filter for patient type
    let currentRow = rows[n];
    for (let i = 0; i < unchecked.length; i++) {
      if (unchecked[i] == currentRow.getElementsByTagName("TD")[2].innerHTML) {
        currentRow.style.display = 'none';
      }
    }
    //filter for status
    if (status != null && status != currentRow.getElementsByTagName("TD")[5].innerHTML) {
      currentRow.style.display = 'none';
    }
    //filter for test date
    let currentTestDate = currentRow.getElementsByTagName("TD")[3].innerHTML;
    let d = new Date(currentTestDate.substring(6), currentTestDate.substring(3,5) - 1, currentTestDate.substring(0,2));
    let testDateFrom = new Date(testDates[0]);
    let testDateTo = new Date(testDates[1]);
    if(testDateFrom.getTime() >= d.getTime() || d.getTime() >= testDateTo.getTime()){
      currentRow.style.display = 'none';
    }
    //filter for result date
    let resultDateFrom = new Date(resultDates[0]);
    let resultDateTo = new Date(resultDates[1]);
    if(resultDateFrom.getTime() >= d.getTime() || d.getTime() >= resultDateTo.getTime()){
      currentRow.style.display = 'none';
    }
  }

}
//Search
function searchId(){
  let s = document.getElementsByName('searchReport')[0].value;
  let table = document.getElementById('reports')
  let rows = table.rows;
  for (let n = 1; n < rows.length; n++) {
    rows[n].style.display='';
  }
  //console.log(s , rows[1].getElementsByTagName("TD")[1].innerHTML);
  for (let i = 1; i < rows.length; i++) {
    let id = rows[i].getElementsByTagName("TD")[0];
    let name = rows[i].getElementsByTagName("TD")[1];
    if(s.toUpperCase() !== id.innerHTML.toUpperCase() && s.toUpperCase() !== name.innerHTML.toUpperCase()){
      rows[i].style.display='none';
    }
  }
}
function sortByIDasc(i){
  table = document.getElementById("reports");
  rows = table.rows;
  let shouldSwitch = false;
  let x = rows[i].getElementsByTagName("TD")[0];
  let y = rows[i + 1].getElementsByTagName("TD")[0];
  if (parseInt(x.innerHTML.substring(1)) > parseInt(y.innerHTML.substring(1))) {
    shouldSwitch = true;
    return shouldSwitch;
  }
  return false;
}
//Table sorting
function sortTable(n) {
  let pointers = document.getElementsByClassName('tableSortPointers');
  for (let i = 0; i < pointers.length; i++) {
    pointers[i].src = "doubleTableSorter.png";
  }
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
        pointers[n].src = "ascTableSorter.png";
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
          else if(parseInt(x.innerHTML.substring(6)) == parseInt(y.innerHTML.substring(6))
          && parseInt(x.innerHTML.substring(3,5)) == parseInt(y.innerHTML.substring(3,5))
        && parseInt(x.innerHTML.substring(0,2)) == parseInt(y.innerHTML.substring(0,2))) {
            shouldSwitch = sortByIDasc(i);
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
        pointers[n].src = "descTableSorter.png";
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
          else if(parseInt(x.innerHTML.substring(6)) == parseInt(y.innerHTML.substring(6))
          && parseInt(x.innerHTML.substring(3,5)) == parseInt(y.innerHTML.substring(3,5))
        && parseInt(x.innerHTML.substring(0,2)) == parseInt(y.innerHTML.substring(0,2))) {
            shouldSwitch = sortByIDasc(i);
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

function neTestKitForm(){
  tkValue = document.getElementsByName('tkNew');
  newTk = document.getElementsByClassName('testKitNew')[0];
  existsTk = document.getElementsByClassName('testKitExists')[0];
  if(tkValue[0].checked == true){
    newTk.style.display = '';
    existsTk.style.display = "none";
  }
  if(tkValue[1].checked == true){
    newTk.style.display = "none";
    existsTk.style.display = '';
  }
}
