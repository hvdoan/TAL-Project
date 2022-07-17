function addStar(nbrOfStars){
	switch(nbrOfStars){
		case 1:
			star1.classList.add("starChecked");
			star2.classList.remove("starChecked");
			star3.classList.remove("starChecked");
			star4.classList.remove("starChecked");
			star5.classList.remove("starChecked");
			break;
		case 2:
			star1.classList.add("starChecked");
			star2.classList.add("starChecked");
			star3.classList.remove("starChecked");
			star4.classList.remove("starChecked");
			star5.classList.remove("starChecked");
			break;
		case 3:
			star1.classList.add("starChecked");
			star2.classList.add("starChecked");
			star3.classList.add("starChecked");
			star4.classList.remove("starChecked");
			star5.classList.remove("starChecked");
			break;
		case 4:
			star1.classList.add("starChecked");
			star2.classList.add("starChecked");
			star3.classList.add("starChecked");
			star4.classList.add("starChecked");
			star5.classList.remove("starChecked");
			break;
		case 5:
			star1.classList.add("starChecked");
			star2.classList.add("starChecked");
			star3.classList.add("starChecked");
			star4.classList.add("starChecked");
			star5.classList.add("starChecked");
			break;
	}
}

function removeStars(){
	star1.classList.remove("starChecked");
	star2.classList.remove("starChecked");
	star3.classList.remove("starChecked");
	star4.classList.remove("starChecked");
	star5.classList.remove("starChecked");
}

function insertRatingStars(nbrOfStars){
	if(document.getElementById("descriptionRating").value !== ""){
		insertRating(nbrOfStars, document.getElementById("descriptionRating").value, document.getElementById("idUserRating").value, document.getElementById("tokenRating").value);
	}else{
		alert("Merci de bien vouloir remplir une description avant de donner une note");
		$("#descriptionRating").focus();
	}
}
/**************************************************
 * AJAX : INSERT RATING
 ***************************************************/
function insertRating(rate, description, idUser, token)
{
	const requestType       = "insertRating";
	const ratingRate        = rate;
	const ratingDescription = description;
	const ratingIdUser      = idUser;
	const tokenForm         = token;

	const request = new XMLHttpRequest();
	request.open('POST', '/rating');

	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			alert("merci de nous avoir laissé un avis de " + rate + " étoile(s) sur votre expérience");
		}
	};

	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&ratingRate=${ratingRate}&ratingIdUser=${ratingIdUser}&ratingDescription=${ratingDescription}`;

	request.send(body);
}