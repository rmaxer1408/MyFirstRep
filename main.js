window.addEventListener('load', function () {
	const firstPages = document.getElementsByClassName('first-page');
	const firstPagesLen = firstPages.length;
	const secondPages = document.getElementsByClassName('second-page');
	const secondPagesLen = secondPages.length;
	const mainButtons = document.getElementsByClassName('main-button');

	const firstPageClick = function() {
		let key = this.id.slice(-1);
		let buttonId = `button_${key}`;
		let secondPageKey = `second-page_${key}_`;

		document.getElementById(buttonId).style.display = 'block';

		for (let firstPage of firstPages) {
			firstPage.style.display = 'none';
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

		for (let secondPage of secondPages) {
			secondPage.style.display = '';
		};		
	};


	const mainButtonClick = function() {	
		let key = this.id.slice(-1);	
		let buttonId = `button_${key}`;
		let secondPageKey = `second-page_${key}_`;

		
		if (document.querySelector(`#${buttonId} .main-button__tarif`).offsetHeight != 0) {
			for (let secondPage of secondPages) {
				secondPage.style.display = '';
			};	

			for (let i = 0; i < firstPagesLen; i++) {
				firstPages[i].style.display = '';
				mainButtons[i].style.display = '';				
			};

		} else {		
			document.querySelector(`#${buttonId} .main-button__select`).style.display = '';
			document.querySelector(`#${buttonId} .main-button__tarif`).style.display = 'block';
			
			for (let firstPage of firstPages) {
				firstPage.style.display = 'none';
			}

			for (let i = 0; i < 4 ; i++) {
				let secondPageId = secondPageKey + i;
				document.getElementById(secondPageId).style.display = 'block';
			};
		};
	};

	for (let i = 0; i < firstPagesLen; i++) {
		firstPages[i].addEventListener('click', firstPageClick);	
		mainButtons[i].addEventListener('click', mainButtonClick);
	};

	for (let i = 0; i < secondPagesLen; i++) {
		secondPages[i].addEventListener('click', secondPageClick);
	};
});