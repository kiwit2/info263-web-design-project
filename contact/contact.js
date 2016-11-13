function checkFields() { //check required fields have data
	var missinginfo = "";
	
    if (document.getElementsByTagName("input")[0].value == "") { //First Name
		missinginfo += "\n     -  First Name";
	}
	
    if (document.getElementsByTagName("input")[1].value == "") { //Last Name
		missinginfo += "\n     -  Last Name";
	}
	
    if (document.getElementsByTagName("input")[2].value == "") { //Email Address
		missinginfo += "\n     -  Email Address";
    }
	
	
	if (missinginfo != "") {
		missinginfo ="_____________________________\n" +
		"You failed to correctly fill in your:\n" +
		missinginfo + "\n_____________________________" +
		"\nPlease re-enter and submit again!";
		alert(missinginfo);
		return false;
    }

	alert("We have receieved your message.\nThankyou.");
	return true;
}

//make spam bot's jobs harder by 'encrypting' email and phone number
function stringReverse(string) {
	return string.split('').reverse().join('');
}

function showEmail(userName, emailServer) {
	userName = stringReverse(userName);
	emailServer = stringReverse(emailServer);
	var emailLink = userName + "@" + emailServer;
	document.write("<a href='mailto:" + emailLink + "'>");
	document.write(emailLink);
	document.write("</a>");
}

function showPhoneNumber(phoneNumber) {
	phoneNumber = stringReverse(phoneNumber);
	document.write(phoneNumber);
}

