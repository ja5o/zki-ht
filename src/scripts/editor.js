wp.domReady( () => {
	const unregisterBlocks = [
		'core/archives',
		'core/avatar',
		'core/calendar',
		'core/comment-author-name',
		'core/comment-content',
		'core/comment-date',
		'core/comment-edit-link',
		'core/comment-reply-link',
		'core/comment-template',
		'core/comments',
		'core/comments-pagination',
		'core/comments-pagination-next',
		'core/comments-pagination-numbers',
		'core/comments-pagination-previous',
		'core/comments-query-loop',
		'core/comments-title',
		'core/home-link',
		'core/legacy-widget',
		'core/loginout',
		'core/navigation',
		'core/navigation-link',
		'core/navigation-submenu',
		'core/post-comments',
		'core/post-comments-form',
		'core/post-content',
		'core/site-logo',
		'core/site-tagline',
		'core/site-title',
	];

	for ( const unregisterBlock of unregisterBlocks ) {
		wp.blocks.unregisterBlockType( unregisterBlock );
	}
} );
