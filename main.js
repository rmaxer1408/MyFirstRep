window.addEventListener('load', function () {
	const firstPage = document.getElementsByClassName('first-page');
	const firstPageLen = firstPage.length;
	const secondPage = document.getElementsByClassName('second-page');
	const secondPageLen = secondPage.length;
	const thirdPage = document.getElementsByClassName('third-page');
	const thirdPageLen = thirdPage.length;
	const mainButton = document.getElementsByClassName('main-button');

	const firstPageClick = function() {
		let key = this.id.slice(-1);
		let buttonId = `button_${key}`;
		let secondPageKey = `second-page_${key}_`;

		document.getElementById(buttonId).style.display = 'block';

		for (let i = 0; i < firstPageLen; i++){
			firstPage[i].style.display = 'none';
		}	

		for (let i = 0; i < 4 ; i++) {
			let secondPageId = secondPageKey + i;
			document.getElementById(secondPageId).style.display = 'block';
		};		
	};

	const secondPageClick = function() {
		let keyStr = this.id.slice(-3);
		let key = keyStr[0];
		let buttonId = `button_${key}`;
		let thirdPageId = `third-page_${keyStr}`;
		
		document.getElementById(thirdPageId).style.display = 'block';
		document.querySelector(`#${buttonId} .main-button__select`).style.display = 'block';
		document.querySelector(`#${buttonId} .main-button__tarif`).style.display = 'none';		

		for (let i = 0; i < secondPageLen; i++) {
			secondPage[i].style.display = '';
		};		
	};


	const mainButtonClick = function() {	
		let key = this.id.slice(-1);	
		let buttonId = `button_${key}`;
		let secondPageKey = `second-page_${key}_`;

		
		if (document.querySelector(`#${buttonId} .main-button__tarif`).offsetHeight != 0) {
			for (let i = 0; i < secondPageLen; i++) {
				secondPage[i].style.display = '';
			};

			for (let i = 0; i < firstPageLen; i++) {
				firstPage[i].style.display = '';
				mainButton[i].style.display = ''
			};

		} else {		
			document.querySelector(`#${buttonId} .main-button__select`).style.display = '';
			document.querySelector(`#${buttonId} .main-button__tarif`).style.display = 'block';
			
			for (let i = 0; i < thirdPageLen; i++) {
				thirdPage[i].style.display = '';
			};

			for (let i = 0; i < 4 ; i++) {
				let secondPageId = secondPageKey + i;
				document.getElementById(secondPageId).style.display = 'block';
			};
		};
	};

	for (let i = 0; i < firstPageLen; i++) {
		firstPage[i].addEventListener('click', firstPageClick);	
		mainButton[i].addEventListener('click', mainButtonClick);
	};

	for (let i = 0; i < secondPageLen; i++) {
		secondPage[i].addEventListener('click', secondPageClick);
	};
});