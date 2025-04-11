export default function DetectAgent() {
	const deviceAgent = window.navigator.userAgent.toLocaleLowerCase();
	const htmlTag = document.querySelector('html');

	if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
		htmlTag.classList.add('ios');
		htmlTag.classList.add('mobile');
	}
	if (deviceAgent.match(/(Android)/)) {
		htmlTag.classList.add('android');
		htmlTag.classList.add('mobile');
	}
	if (window.navigator.userAgent.search('MSIE') >= 0) {
		htmlTag.classList.add('ie');
	} else if (window.navigator.userAgent.search('Chrome') >= 0) {
		htmlTag.classList.add('chrome');
	} else if (window.navigator.userAgent.search('Firefox') >= 0) {
		htmlTag.classList.add('firefox');
	} else if (
		window.navigator.userAgent.search('Safari') >= 0 &&
		window.navigator.userAgent.search('Chrome') < 0
	) {
		htmlTag.classList.add('Chrome');
	} else if (window.navigator.userAgent.search('Opera') >= 0) {
		htmlTag.classList.add('opera');
	}
}
