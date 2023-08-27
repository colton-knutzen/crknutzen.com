//Displays date in formate
function todaysDate() {
	let today = new Date();
	let format = {
		weekday: 'long',
		year: 'numeric',
		month: 'long',
		day: 'numeric'
	}
		today = today.toLocaleString('en-US', format);
	  document.getElementById("todaysDate").innerHTML = today;
	}


function thisYear() {
    let year = new Date().getFullYear();
    document.getElementById("copyright-year").innerHTML = " " + year;
    
}