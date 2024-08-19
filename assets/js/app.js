// assets/js/app.js

var app = angular.module('TestStudentsCRUD', ['ngAnimate']);

app.service('studentService', ['$http', function($http) {
    this.getStudents = function() {
        return $http.get('/api/students');
    }
    this.addStudent = function(newStudent) {
        return $http.post('/api/students/create', newStudent);
    };
    this.deleteStudent = function(id) {
        return $http.delete('/api/students/delete/' + id);
    };
    this.updateStudent = function(id, updatedStudent) {
        return $http.put('/api/students/update/' + id, updatedStudent);
    };
}]);

app.controller('ListController', ['$scope', 'studentService', function($scope, studentService) {
    $scope.students = [];
    $scope.newStudent = {};  // object to hold new student data

    studentService.getStudents().then(function(response){
        $scope.students = response.data;
    });

    $scope.addStudent = function() {
        studentService.addStudent($scope.newStudent).then(function(response) {
            // Use the server response here.
            $scope.students.push(response.data);
            $scope.newStudent = {};
        });
    };

    $scope.deleteStudent = function(studentId) {
        studentService.deleteStudent(studentId).then(function() {
            // if delete successful, remove the student from the list
            $scope.students = $scope.students.filter(function(student) {
                return student.id !== studentId;
            });
        });
    };

    $scope.editStudent = function(student) {
        student.editing = true;
    };

    $scope.submitEdit = function(student) {
        studentService.updateStudent(student.id, student).then(function() {
            // if update successful, remove the editing state from the student
            student.editing = false;
        });
    };
}])
