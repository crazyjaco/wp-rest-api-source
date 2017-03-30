(

// Stuff goes here.
/* wp.api.loadPromise.done( */ function($, _) {
	// View for the list container.
	var postList = Backbone.View.extend({
		template: _.template( document.getElementById('post-list-table-template').innerHTML ),
		el: '#post-list-table-container',
		initialize: function() {
			this.render();
			this.listenTo( this.collection, 'add', this.renderResult );
		},
		renderResult: function( model, collection, options ) {
			var postItem = new postListItem( { 'collection': collection, 'model': model } );
			console.log(postItem.$el);
			this.$('#post-list-table tbody').append( postItem.$el );
		},
		render: function() {
			this.$el.html( this.template );
			return;
		}
	});

	// View for the items in our list.
	var postListItem = Backbone.View.extend({
		template: _.template( document.getElementById( 'post-list-item-template' ).innerHTML ),
		tagName: 'tr',
		className: 'post-list-item',
		initialize: function() {
			this.render();
		},
		render: function() {
			var $el = $(this.el);
			console.log('rendering post list item');
			console.log('data', this.model.toJSON());
			return this.$el.append( this.template( this.model.toJSON() ) );
		}
	});

	// More Stuff.
	var postsCollection = new wp.api.collections.Posts;
	postsCollection.fetch( { data: { per_page: 25 } } );
	var postsView = new postList( { 'collection': postsCollection });

 }
 //) 

)(jQuery, _);