import DetectAgent from './global/agent-classes';

const website = {
	agent_classes: DetectAgent,
	js_enabled: () =>
		( document.body.className = document.body.className.replace(
			'no-js',
			'js'
		) ),
};

document.addEventListener( 'DOMContentLoaded', function () {
	website.agent_classes();
	website.js_enabled();
} );
