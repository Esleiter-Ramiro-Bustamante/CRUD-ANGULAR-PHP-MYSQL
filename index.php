<!DOCTYPE html>  
 <!-- index.php !-->  
 <html>  
      <head>  
           <title>Webslesson Tutorial | AngularJS Tutorial with PHP - Insert Data into Mysql Database</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           
           <link rel="stylesheet" href="css/toastr.min.css"> 
           
            <link rel="stylesheet" href="js/alertifyjs/css/alertify.min.css"> 
             <link rel="stylesheet" href="js/alertifyjs/css/themes/default.css">
           <script src="js/angular.min.js"></script>  
           <script src="js/jquery.min.js"></script>  
           <script src="js/toastr.min.js"></script> 
          <script src="js/alertifyjs/alertify.min.js"></script> 

      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:500px;">  
                <h3 align="center">AngularJS Tutorial with PHP </h3>  
                <div ng-app="myapp" ng-controller="usercontroller" ng-init="displayData()">  <!--ESTA CARGANDO LA TABLA DESDE EL INICIO-->
                     <label>First Name</label>  
                     <input type="text" name="first_name" ng-model="firstname" class="form-control" />  
                     <br />  
                     <label>Last Name</label>  
                     <input type="text" name="last_name" ng-model="lastname" class="form-control" />  
                     <br />  
                     <input type="hidden" ng-model="id" /> 
                     <input type="submit" name="btnInsert" class="btn btn-success" ng-click="insertData()" value="{{btnName}}"/>  
                        <br>
                        <br>
                        <table class="table table-bordered">  
                          <tr>  
                               <th>First Name</th>  
                               <th>Last Name</th>  
                               <th>Actualizar</th>
                               <th>Eliminar</th>  
                          </tr>  
                          <tr ng-repeat="x in names">  
                               <td>{{x.first_name}}</td>  
                               <td>{{x.last_name}}</td>
                              <td><button ng-click="updateData(x.id, x.first_name, x.last_name)" class="btn btn-warning btn-xs">actualizar</button></td>   
                              <td><button ng-click="deleteData(x.id )"class="btn btn-danger btn-xs">eliminar</button></td>  
                          </tr>  
                     </table> 
                </div>  
           </div> 

      </body>  
 </html>  
 <script>  
 var app = angular.module("myapp",[]);  
 app.controller("usercontroller", function($scope, $http){  
   $scope.btnName = "guardar";  
   //************************************************************ INICIO  $scope.insertData
   $scope.insertData = function(){  
           if($scope.firstname == null)  
           {  
               toastr.info('nombre!', 'Falta llenar el campo ', {timeOut: 5000,closeButton: true}) 
           }  
           else if($scope.lastname == null)  
           {  
               toastr.info('nombre2!', 'Falta llenar el campo ', {timeOut: 5000,closeButton: true}) 
              
           }  
           else  
           {  
                $http.post(  
                     "procedimientos/insert.php",  
                     {'firstname':$scope.firstname, 'lastname':$scope.lastname, 'btnName':$scope.btnName, 'id':$scope.id}  
                ).success(function(data){  
                 
                      toastr.success('Correctamente', 'Datos Guardados!', {timeOut: 5000,closeButton: true})  
                      
                     $scope.firstname = null;  
                     $scope.lastname = null;  
                     $scope.btnName = "guardar";  
                     $scope.displayData();  
                });  
           }  
      } 
  //************************************************************  FIN  $scope.insertData





      //************************************************************   INICIO $scope.displayData


         $scope.displayData = function(){  
           $http.get("procedimientos/select.php")  
           .success(function(data){  
                $scope.names = data;  
           });  
      }
      //************************************************************   FIN $scope.displayData


      
      
      //************************************************************ INICIO  $scope.updateData


       $scope.updateData = function(id, first_name, last_name){  
           $scope.id = id;  
           $scope.firstname = first_name;  
           $scope.lastname = last_name;  
           $scope.btnName = "actualizar";  
      }
      //************************************************************ FIN  $scope.updateData




      //************************************************************ INICIO  $scope.deleteData
        $scope.deleteData = function(id){  
          alertify.confirm("Eliminar", "¿Desea eliminar el siguiente registro?",
  function(){
              $http.post("procedimientos/delete.php", {'id':id})  
                .success(function(data){  
                  toastr.success('Correctamente', 'Dato Eliminado!', {timeOut: 5000,closeButton: true})    
                     $scope.displayData();  
                });
  },
  function(){
    toastr.error('Dato no eliminado', 'Error!', {timeOut: 5000,closeButton: true})   
  });

            
      } 
      //************************************************************ FIN  $scope.deleteData
      

 });  

// Display a warning toast, with no title
//toastr.warning('My name is Inigo Montoya. You killed my father, prepare to die!')

// Display a success toast, with a title
//toastr.success('Have fun storming the castle!', 'Miracle Max Says')

//toastr.info('nombre2!', 'Falta llenar el campo ', {timeOut: 5000,closeButton: true}) 

// Display an error toast, with a title
//toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')

// Immediately remove current toasts without using animation
//toastr.remove()

// Remove current toasts using animation
//toastr.clear()

// Override global options
//toastr.success('We do have the Kapua suite available.', 'Turtle Bay Resort', {timeOut: 5000,closeButton: true})



 </script>  