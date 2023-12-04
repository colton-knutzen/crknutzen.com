// JavaScript Document
/*
	This file will:
	
	- Create a Javascript object including an array
	- Convert the Javascript object into a JSON object
	- Store the JSON object into local storage
	
	Goal: Provide an example of how to create JSON objects in Javascript
	Goal: Provide an example of how to consume JSON objects in Javascript

	Use the following data for your JSON object

		student_id = 332443
		student_gpa = 3.6
		student_courses = ["WDV101","WDV131","WDV105"]

		student_id = 545467
		student_gpa = 2.7
		student_courses = ["WDV101","WDV131","WDV105","WDV221","WDV205"]	
		
		student_id = 128574
		student_gpa = 3.4
		student_courses = ["WDV101","WDV131","WDV105","WDV221","WDV205","WDV341"]	



*/

let testStudents = [
	{
		student_id: 332443,
		student_gpa: 3.6,
		student_courses: ["WDV101","WDV131","WDV105"]

	},

	{
		student_id: 545467,
		student_gpa: 2.7,
		student_courses: ["WDV101","WDV131","WDV105","WDV221","WDV205"]	
	},

	{
		student_id: 128574,
		student_gpa: 3.4,
		student_courses: ["WDV101","WDV131","WDV105","WDV221","WDV205","WDV341"]	
	}

];

console.log(testStudents);

const studentsJSON = JSON.stringify(testStudents);

localStorage.setItem("students", studentsJSON);