(

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
			return this.$el.append( this.template( this.model.toJSON() ) );
		},
		events: {
			"click button": "doSomething"
		},
		doSomething: function() {
			alert('lolwut ' + this.model.attributes.title.rendered);
		}
	});

	// Create a new Posts Collection.
	var postsCollection = new wp.api.collections.Posts;
	// Populate the Collection.
	postsCollection.fetch( { data: { per_page: 25 } } );
	// Populate the View with the Collection.
	var postsView = new postList( { 'collection': postsCollection });

	console.log('postsCollection', postsCollection);

 }
 //) 

)(jQuery, _);