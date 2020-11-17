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

function login(){
  $(function () {

        $('#logInForm').on('submit', function (e) {

          e.preventDefault();
          //var data = $('#logInForm').serialize();

          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/login.php',
            data: $('#logInForm').serialize(),
            success: function (userType) {
              //alert('form was submitted');
              console.log(this.data);
              console.log(userType);
              console.log($.ajax);
              if (userType == "NewManager") {
                window.location.href = "http://localhost/CoView/webpages/ManageTestCentre.php";
              }
              if(userType == "Manager"){
                window.location.href = "http://localhost/CoView/webpages/ManagerMenu.php";
              }
              if(userType == "Tester"){
                window.location.href = "http://localhost/CoView/webpages/testerMenu.php";
              }
              if(userType == "Patient"){
                window.location.href = "http://localhost/CoView/webpages/patient.php";
              }
              if(userType == "Not Found"){
                let notification = document.getElementsByTagName('small')[0];
                notification.style.display = '';
                notification.innerHTML = "Username or Password Incorrect!";
              }
            },
            error: function(datas){
              alert('form error');
              console.log(this.data);
              console.log(datas);
            }
          });

        });

      });
}

function registerTester(){
  $(function () {
        $('#testerForm').on('submit', function (e) {
          e.preventDefault();
          let notifications = document.getElementsByClassName('errorNotifications');
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/RegisterTester.php',
            data: $('#testerForm').serialize(),
            success: function (testerAdded) {
              console.log(this.data);
              console.log(testerAdded);
              if (testerAdded == "Added") {
                window.alert("tester added");
                $('#close').click();
                location.reload();
              }
              if (testerAdded == "Password") {
                notifications[0].style.display = 'none';
                notifications[1].style.display = 'none';
                notifications[2].style.display = '';
                notifications[2].innerHTML = "Passwords do not match!";
              }
              if (testerAdded == "Username") {
                notifications[0].style.display = '';
                notifications[1].style.display = 'none';
                notifications[2].style.display = 'none';
                notifications[0].innerHTML = "Username already taken!";
              }
              if (testerAdded == "Email") {
                notifications[0].style.display = 'none';
                notifications[1].style.display = '';
                notifications[2].style.display = 'none';
                notifications[1].innerHTML = "Email already registered!";
              }
            },
            error: function(datas){
              alert('form error');
              console.log(this.data);
              console.log(datas);
            }
          });

        });

      });
}
function nameChange(){
  $(function () {
        $('#tkeName').on('change', function (e) {
          getStock();
        });
      });
}
function numChange(){
  $(function () {
        $('#tkeStock').on('change', function (e) {
          getStock();
        });
      });
}
function getStock(){
  let tkID = {id: $('#tkeName').val()};
  let aStock = document.getElementById('tkeAvailableStock');
  let addStock = document.getElementById('tkeStock').value;
  let newStock = document.getElementById('tkeNewStock');
  console.log($('#tkeName').val());
  $.ajax({
    type: 'POST',
    url: 'http://localhost/CoView/scripts/GetStock.php',
    data: tkID,
    success: function (stock) {
      aStock.innerHTML = "Available Stock: "+ stock;
      newStock.innerHTML = "New Stock: "+ (parseInt(stock) + parseInt(addStock));
    },
    error: function(){
      alert('error');
    }
  });
}

function updateStock(){
  $(function () {
        $('#tkeform').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/UpdateStock.php',
            data: $('#tkeform').serialize(),
            success: function (nstock) {
              if(nstock == "Update"){
                alert('Stock updated');
                getStock();
              }
              else{
                alert(nstock);
              }
            },
            error: function(){
              alert('form error');
            }
          });
        });
      });
}

function addStock(){
  $(function () {
        let error = document.getElementsByClassName('errorNotifications')[0];
        $('#tknform').on('submit', function (e) {

          e.preventDefault();
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/AddStock.php',
            data: $('#tknform').serialize(),
            success: function (nstock) {
              if(nstock == "AddedAdded"){
                alert('Test Kit Added');
                error.style.display = 'none';
                location.reload();
              }
              if(nstock == "Exists"){
                error.innerHTML="This Test Kit is already in the system";
                error.style.display = '';
              }
              else{
                console.log(nstock);
              }
            },
            error: function(){
              alert('form error');
            }
          });
        });
      });
}

function addTestCentre(){
  $(function () {
        let error = document.getElementsByClassName('errorNotifications')[0];
        $('#tcForm').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/AddTestCentre.php',
            data: $('#tcForm').serialize(),
            success: function (tc) {
              if(tc == "AddedAdded"){
                alert('Test Centre now registered to your account.');
                error.style.display = 'none';
                window.location.href = 'http://localhost/ManagerMenu.php';
              }
              if(tc == "Exists"){
                error.innerHTML="Test Centre with that name already exists";
                error.style.display = '';
              }
              else{
                console.log(tc);
              }
            },
            error: function(){
              alert('form error');
            }
          });
        });
      });
}

function getReportDetails(){
  $(function () {

        $('tbody tr').on('click', function (e) {
          let data = {tid:$(this).find('td:first').text().substring(1)};
          let rep = document.getElementById('tResults');
          console.log("test");
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/GetReportDetails.php',
            data: data,
            success: function (results) {
              console.log(results);
              rep.innerHTML = results;
              //$('#reports tr').attr('data-toggle')='modal';
              //$('#reports tr').attr('data-target')='#resultsModal';
              //openModal(0);
            },
            error: function(){
              alert('form error');
            }
          });

        });
      });

}

function reportCreated(){
  $(function () {

        $('#form').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/insertData.php',
            data: $('#form').serialize(),
            success: function (recordAdded) {
              console.log(this.data);
              console.log(recordAdded);
              if (recordAdded == "Added") {
                window.alert("Record added");
                window.location.href = "http://localhost/CoView/webpages/testerMenu.php";
              }
              if (recordAdded == "Failed"){
                window.alert("Selected kit stock has finished");
                window.location.href = "http://localhost/CoView/webpages/testerMenu.php";
              }
            },
            error: function(datas){
              alert('form error');
              console.log(this.data);
              console.log(datas);
            }
          });

        });

      });
}

function getDetails(){
  $(function () {

        $('tbody tr button').on('click', function (e) {
          //event.stopPropagation();
          //e.stopPropogation();
          //event.cancelBubble = true;
          let row = $(this).parent().parent();
          let rowId = row.find('td:first').html();
          let data = {tid:parseInt(rowId.substring(1))};
          let details = document.getElementById('reportResults');
          console.log("test");
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/getDetails.php',
            data: data,
            success: function (results) {
              console.log(results);
              console.log(data);
              details.innerHTML = results;
            },
            error: function(){
              alert('form error');
            }
          });

        });
      });

}
function updateReports(){
  $(function () {

        $('#updateForm').on('submit', function (e) {
          e.preventDefault();
          let res = document.getElementById('results').value;
          let resultDate = document.getElementById('resultDate').value;
          let row = $(this).parent().parent();
          let rowId = row.find('td:first').html();
          let data = {
            reportResults: res, resultDate: resultDate};
          let details = document.getElementById('reportResults');
          console.log("test");
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/update.php',
            data: data,
            success: function (results) {
              console.log(results);
              alert('Report has been succesfully updated');
              location.reload();
            },
            error: function(){
              alert('form error');
            }
          });

        });
      });

}
function filter(e){
  $(function () {
        //let error = document.getElementsByClassName('errorNotifications')[0];
        $('#filterForm').on('submit', function (e) {
          console.log($('#filterForm').serialize());
          e.preventDefault();
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/FilterTable.php',
            data: $('#filterForm').serialize(),
            success: function (tbody) {
              console.log(tbody);
              document.getElementsByTagName('tbody')[0].innerHTML = tbody;
              getReportDetails();
              getDetails();
              document.getElementById('close').click();
            },
            error: function(){
              alert('form error');
            }
          });

        });
      });
}
function sort(){
  $(function () {
        $('table th').on('click', function (e) {
          let sortby = $(this).attr('id');
          let n = $(' table th').index($(this));
          let others = $('table th').not(this);
            if($(this).attr("data-dir") == 'ASC'){
              var dirs = 'DESC';
              others.find('img').attr("src", "../icons/doubleTableSorter.png");
              others.attr("data-dir", 'NONE');
              $(this).find('img').attr("src", "../icons/descTableSorter.png");
              $(this).attr("data-dir", 'DESC');
            }
            else {
              var dirs = 'ASC';
              others.find('img').attr("src", "../icons/doubleTableSorter.png");
              others.attr("data-dir", 'NONE');
              $(this).find('img').attr("src", "../icons/ascTableSorter.png");
              $(this).attr("data-dir", 'ASC');
            }
          let data = {sort:sortby, dir:dirs};
          $.ajax({
            type: 'POST',
            url: 'http://localhost/CoView/scripts/SortTable.php',
            data: data,
            success: function (tbody) {
              console.log(tbody);
              document.getElementsByTagName('tbody')[0].innerHTML = tbody;
              getReportDetails();
              getDetails();
            },
            error: function(){
              alert('form error');
            }
          });
        });
      });
    }
