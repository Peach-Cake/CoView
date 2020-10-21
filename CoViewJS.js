//Filter Modal box
// When the user clicks on the button, open the modal
function openModal(n) {
  let modal = document.getElementsByClassName("modal")[n];
  modal.style.display = "block";
  window.addEventListener('click', outCloseFilter);
}

// When the user clicks on <span> (x), close the modal
function xCloseFilter(n) {
  let modal = document.getElementsByClassName("modal")[n];
  modal.style.display = "none";
  window.removeEventListener('click', outCloseFilter);
}

// When the user clicks anywhere outside of the modal, close it
function outCloseFilter(event) {
  if (event.target == modal) {
    modal.style.display = "none";
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

function regTester(){
  event.preventDefault();
  let data = document.getElementsByTagName('input');
  let table = document.getElementsByTagName('tbody')[0];
  let username = data[1].value;
  let name = data[2].value;
  let email = data[3].value;
  let password = data[4].value;
  let cpassword = data[5].value;
  let notifications = document.getElementsByClassName('errorNotifications');
  if(validateUsername(username) == true){
  if(password == cpassword){
    notifications[0].style.display = 'none';
    notifications[1].style.display = 'none';
    let row = table.insertRow(table.rows.length);
    for (var i = 0; i < 3; i++) {
      let cell = row.insertCell(i);
      cell.innerHTML = data[i+1].value;
    }
  }
  else {
    notifications[0].style.display = 'none';
    notifications[1].style.display = '';
    notifications[1].innerHTML = "Password in confirm does not match password";
  }
}
  else {
    notifications[1].style.display = 'none';
    notifications[0].style.display = '';
    notifications[0].innerHTML = "Username already taken!";
  }
}
function validateUsername(username){
  let table = document.getElementsByTagName('tbody')[0];
  let row = table.rows;
  for (var i = 0; i < row.length; i++) {
    if(row[i].getElementsByTagName('td')[0].innerHTML==username){
      return false;
    }
  }
  return true;
}

function login(){
  event.preventDefault();
  let form = document.getElementsByName("logInForm")[0];
  let notification = document.getElementsByTagName('small');
  let user = document.getElementsByTagName('input');
  let username = user[0].value;
  let password = user[1].value;
  if(username.toUpperCase() != "MANAGER" &&
  username.toUpperCase() != "TESTER" && username.toUpperCase() != "PATIENT"){
    notification[1].style.display = 'none';
    notification[0].style.display = '';
    notification[0].innerHTML = "Username does not exist";
  }
  else if(password != "password"){
    notification[0].style.display = 'none';
    notification[1].style.display = '';
    notification[1].innerHTML = "Incorrect Password";
  }
  else{
    if(username.toUpperCase() == "MANAGER"){
      form.action = "ManagerMenu.html";
      form.submit();
    }
    else if(username.toUpperCase() == "TESTER"){
      form.action = "testerMenu.html";
      form.submit();
    }
    if(username.toUpperCase() == "PATIENT"){
      form.action = "patient.html";
      form.submit();
    }
  }
}

/*function addReport() {
  event.preventDefault();
  var count;
  count = 1;

  var list = document.getElementById("list");
  let tab = document.getElementById("reports");
  let testID = count;
  let patientName = document.getElementById("patientName").value;
  let patientType = list.value;
  let resultDate = document.getElementById("patientName").value;
  let testDate = document.getElementById("testDate").value;
  let status1 = document.getElementById("box1");
  let status2 = document.getElementById("box2");
  if (status1.checked == true){
    var status;
    status = status1.value;
  }
  else {
    status = status2.value;
  }

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    cell1.innerHTML = count;
    cell2.innerHTML = patientName;
    cell3.innerHTML = patientType;
    cell4.innerHTML = resultDate;
    cell5.innerHTML = testDate;
    cell6.innerHTML = status;
  }

  }
}
*/
